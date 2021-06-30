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
    $itemName = trim($_POST["itemName"]);
    $itemPrice = trim($_POST["itemPrice"]);
    $itemDescription = trim($_POST["itemDescription"]);
    $itemId = $_POST["itemId"];
    @$itemCategory = $_POST["itemCategory"];

    //Sanitize all the Inputs
    $itemName = filter_var($itemName, FILTER_SANITIZE_SPECIAL_CHARS);
    $itemPrice = filter_var($itemPrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $itemDescription = filter_var($itemDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
    $itemCategory = filter_var($itemCategory, FILTER_SANITIZE_SPECIAL_CHARS);

    //An array for easier and faster checking if there is an error in the variable
    $arrayPost = array("Item Name:" => $itemName, "Item Price:" => $itemPrice,  "Item Description:" => $itemDescription, "Item Category:" => $itemCategory);
    $logsErrorTest = false;
    $uploadedImage = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Item Edit</title>

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
            <h1 class="text-center mb-2">Item Edit</h1>
            <?php
                //This check if the user input a blank input because space count as an input for some reasons.
                foreach($arrayPost as $label => $value) {
                    if(empty($value)) {
                        echo
                            "<div class='alert alert-danger text-center overflow-auto' role='alert'>
                                <h2>" . $label . " </h2>
                                <h4 class='fw-normal'>Input Empty/Invalid.</h4>" .
                            "</div>
                        ";
                        $logsErrorTest = true;
                    }
                }

                //Check if the Name already exist
                $querySelectItemInfo = "SELECT id ,name FROM tbl_items";
                $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);

                while($itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo)) {
                    if(($itemName === $itemInfo["name"]) && ($itemId != $itemInfo["id"])) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center overflow-auto' role='alert'>
                                <h2>Item Name:</h2>
                                <h4 class='fw-normal'>Already Exist.</h4>
                            </div>
                        ";
                    }
                }

                //Check if the file type is an image format and if the user upload an image or not
                //Add an exception so it would not check an empty upload
                if((@exif_imagetype($_FILES["itemPicture"]['tmp_name']) == false) && (@!empty($_FILES["itemPicture"]['tmp_name']))) {
                    echo "
                        <div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Item Picture</h2>
                            <h4 class='fw-normal'>File Uploaded is not an Image Format.</h4>
                        </div>
                    ";
                    $logsErrorTest = true;
                } else if(@empty(exif_imagetype($_FILES["itemPicture"]['tmp_name']))) {
                    $uploadedImage = false;
                } else {
                    $uploadedImage = true;
                }

                //If the following Inputs are valid it would enter the database, and if not it would not.
                if($logsErrorTest == true) {
                    echo "
                        <div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Database:</h2>
                            <h4 class='fw-normal'>Item Update Failed.</h4>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-secondary' href='itemEdit.php?=$itemId' role='button'>Return</a>
                        </div>
                    ";
                } else {
                    //Select the profile image then delete the old profile
                    $queryProfile = "SELECT picture FROM tbl_items WHERE id = '$itemId'";
                    $executeQueryProfile = mysqli_query($con, $queryProfile);
                    $infoProfilePicture = mysqli_fetch_assoc($executeQueryProfile);
                    $path = "../img/items/" . $infoProfilePicture["picture"];

                    //Delete the profile picture if they change from an image that is not a default
                    if(($infoProfilePicture["picture"] != "default.png") && ($uploadedImage == true)) {
                        unlink($path);
                    }

                    //Moving and naming the img to img/items folder
                    if($uploadedImage == true) {
                        $target_dir = "../img/items/";
                        @$fileType = pathinfo($_FILES["itemPicture"]["name"])["extension"];
                        $fileName = $itemId . "_picture." . $fileType;
                        $target_file = $target_dir . $fileName;
                        move_uploaded_file($_FILES["itemPicture"]["tmp_name"], $target_file);
                    }


                    //Query for the Update of the User
                    //This is the Query for the edit with image upload
                    if($uploadedImage == true) {
                        $queryUpdate = "UPDATE
                                            tbl_items
                                        SET
                                            name = '$itemName',
                                            price = '$itemPrice',
                                            description = '$itemDescription',
                                            picture = '$fileName',
                                            category = '$itemCategory'
                                        WHERE
                                            id = '$itemId'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center overflow-auto' role='alert'>
                                <h2>Database:</h2>
                                <h4 class='fw-normal'>Item Updated</h4>
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-secondary' href='itemList.php' role='button'>Home</a>
                            </div>
                        ";
                    } else {
                        //This is the Query for the edit without image upload
                        $queryUpdate = "UPDATE
                                            tbl_items
                                        SET
                                            name = '$itemName',
                                            price = '$itemPrice',
                                            description = '$itemDescription',
                                            category = '$itemCategory'
                                        WHERE
                                            id = '$itemId'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center overflow-auto' role='alert'>
                                <h2>Database:</h2>
                                <h4 class='fw-normal'>Item Updated.</h4>
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-secondary' href='itemList.php' role='button'>Home</a>
                            </div>
                        ";
                    }
                }

            ?>
        </div>
    </body>
</html>
