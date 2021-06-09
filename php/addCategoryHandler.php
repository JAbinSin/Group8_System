<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Set the variable names for the values receive from the register.php
    $categoryName = trim($_POST["categoryName"]);

    //Sanitize all the Inputs
    $categoryName = filter_var($categoryName, FILTER_SANITIZE_SPECIAL_CHARS);

    //Error variable checker
    $logsErrorTest = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Add Category</title>

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

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25">
            <h1 class="text-center mb-2">Add Item</h1>
            <?php

                //This check if the user input a blank input because space count as an input for some reasons.{
                if(empty($categoryName)) {
                    echo
                        "<div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Category Name:</h2>
                            <h4 class='fw-normal'>Input Empty/Invalid.</h4>
                        </div>
                    ";
                    $logsErrorTest = true;
                }

                //Check if the Name already exist
                $querySelectItemInfo = "SELECT name FROM tbl_category";
                $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);

                while($itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo)) {
                    if($categoryName === $itemInfo["name"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center overflow-auto' role='alert'>
                                <h2>Category Name</h2>
                                <h4 class='fw-normal'>Already Exist.</h4>
                            </div>
                        ";
                    }
                }

                //Check if the file type is an image format and if the user upload an image or not
                //Add an exception so it would not check an empty upload
                if((@exif_imagetype($_FILES["categoryPicture"]['tmp_name']) == false) && (@!empty($_FILES["categoryPicture"]['tmp_name']))) {
                    echo "
                        <div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Category Picture:</h2>
                            <h4 class='fw-normal'>File Uploaded is not an Image Format.</h4>
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
                        <div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Database:</h2>
                            <h4 class='fw-normal'>Add Category Failed.</h4>
                        </div>
                    ";
                } else {
                    //This query is to select find the id increment value for the image name
                    $queryTableStatus = "SHOW TABLE STATUS LIKE 'tbl_category'";
                    $executeQueryTableStatus = mysqli_query($con, $queryTableStatus);
                    $tableInfo = mysqli_fetch_assoc($executeQueryTableStatus);
                    $nextId = $tableInfo["Auto_increment"];


                    //Moving and naming the img to img/items folder
                    if($uploadedImage == true) {
                        $target_dir = "../img/category/";
                        @$fileType = pathinfo($_FILES["categoryPicture"]["name"])["extension"];
                        $fileName = $nextId . "_picture." . $fileType;
                        $target_file = $target_dir . $fileName;
                        move_uploaded_file($_FILES["categoryPicture"]["tmp_name"], $target_file);
                    }


                    //Query for the new User that would be registered
                    //This query is for an upload without an image
                    if($uploadedImage == false) {
                        $queryInsert = "
                        INSERT INTO tbl_category(
                            name
                        )
                        VALUES (
                            '$categoryName'
                        )
                        ";
                    } else {
                        //Query for the image with an image
                        $queryInsert = "
                        INSERT INTO tbl_category(
                            name,
                            category_picture
                        )
                        VALUES (
                            '$categoryName',
                            '$fileName'
                        )
                        ";
                    }

                    //Execute the Insert Query Above
                    $executeQueryInsert = mysqli_query($con, $queryInsert);

                    echo "
                        <div class='alert alert-success text-center overflow-auto' role='alert'>
                            <h2>Database:</h2>
                            <h4 class='fw-normal'>Category Added.</h4>
                        </div>
                    ";
                }
            ?>
            <div class="col text-center">
                <a class="btn btn-secondary" href="itemList.php" role="button">RETURN</a>
            </div>
        </div>
    </body>
</html>
