<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Set the variable names for the values receive from the itemEdit.php
    $categoryName = trim($_POST["categoryName"]);
    $categoryId = $_POST["categoryId"];

    //Sanitize all the Inputs
    $categoryName = filter_var($categoryName, FILTER_SANITIZE_SPECIAL_CHARS);

    //Error handler
    $logsErrorTest = false;
    $uploadedImage = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Edit Category</title>

        <!-- Add a logo for the title head -->
        <link rel="icon" href="../img/logo/logo-test.ico" type="image/ico">

        <!-- The meta tags used in the webpage -->
        <!-- charset="utf-8" to use almost all the character and symbol in the world -->
        <!-- viewport to make the webpage more responsive -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Link the boostrap5 to the webpage -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Link the boostrap icon 1.4 to the webpage -->
        <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

        <!-- Link the local css to the webpage -->
        <link href="../bootstrap/local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the output messafe of the edit handler -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25">
            <h1 class="text-center mb-2">Edit Category</h1>
            <?php
                //This check if the user input a blank input because space count as an input for some reasons.
                if(empty($categoryName)) {
                    echo
                        "<div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Category Name: Input is Invalid/Empty.
                        </div>
                    ";
                    $logsErrorTest = true;
                }

                //Check if the Name already exist
                $querySelectCategoryInfo = "SELECT id ,name FROM tbl_category";
                $executeQuerySelectCategoryInfo = mysqli_query($con, $querySelectCategoryInfo);

                while($categoryInfo = mysqli_fetch_assoc($executeQuerySelectCategoryInfo)) {
                    if(($categoryName === $categoryInfo["name"]) && ($categoryId != $categoryInfo["id"])) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                                Category Name: Already Exist.
                            </div>
                        ";
                    }
                }

                //Check if the file type is an image format and if the user upload an image or not
                //Add an exception so it would not check an empty upload
                if((@exif_imagetype($_FILES["categoryPicture"]['tmp_name']) == false) && (@!empty($_FILES["categoryPicture"]['tmp_name']))) {
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Category Picture: File Uploaded is not an Image Format.
                        </div>
                    ";
                    $logsErrorTest = true;
                } else if(@empty(exif_imagetype($_FILES["categoryPicture"]['tmp_name']))) {
                    $uploadedImage = false;
                } else {
                    $uploadedImage = true;
                }

                //If the following Inputs are valid it would enter the database, and if not it would not.
                if($logsErrorTest == true) {
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Database: Category Update Failed.
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-secondary rounded-pill' href='itemEdit.php?=$itemId' role='button'>Return</a>
                        </div>
                    ";
                } else {
                    //Select the profile image then delete the old profile
                    $queryProfile = "SELECT category_picture FROM tbl_category WHERE id = '$categoryId'";
                    $executeQueryProfile = mysqli_query($con, $queryProfile);
                    $infoProfilePicture = mysqli_fetch_assoc($executeQueryProfile);
                    $path = "../img/category/" . $infoProfilePicture["category_picture"];

                    //Delete the profile picture if they change from an image that is not a default
                    if(($infoProfilePicture["category_picture"] != "default.png") && ($uploadedImage == true)) {
                        unlink($path);
                    }

                    //Moving and naming the img to img/category folder
                    if($uploadedImage == true) {
                        $target_dir = "../img/category/";
                        @$fileType = pathinfo($_FILES["categoryPicture"]["name"])["extension"];
                        $fileName = $categoryId . "_picture." . $fileType;
                        $target_file = $target_dir . $fileName;
                        move_uploaded_file($_FILES["categoryPicture"]["tmp_name"], $target_file);
                    }


                    //Query for the Update of the User
                    //This is the Query for the edit with image upload
                    if($uploadedImage == true) {
                        $queryUpdate = "UPDATE
                                            tbl_category
                                        SET
                                            name = '$categoryName',
                                            category_picture = '$fileName'
                                        WHERE
                                            id = '$categoryId'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center h2 overflow-auto' role='alert'>
                                Database: Category Update.
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-secondary rounded-pill' href='../index.php' role='button'>Home</a>
                            </div>
                        ";
                    } else {
                        //This is the Query for the edit without image upload
                        $queryUpdate = "UPDATE
                                            tbl_category
                                        SET
                                            name = '$categoryName'
                                        WHERE
                                            id = '$categoryId'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center h2 overflow-auto' role='alert'>
                                Database: Category Updated.
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-secondary' href='../index.php' role='button'>Home</a>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
    </body>
</html>
