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
    $itemName = trim($_POST["itemName"]);
    $itemPrice = trim($_POST["itemPrice"]);
    $itemDescription = trim($_POST["itemDescription"]);

    //Allow special characters in the Item Description
    $itemDescription = filter_var($itemDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);

    //An array for easier and faster checking if there is an error in the variable
    $arrayPost = array("Item Name:" => $itemName, "Item Price:" => $itemPrice, "Item Description:" => $itemDescription);
    $logsErrorTest = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Add Item</title>

        <!-- The meta tags used in the webpage -->
        <!-- charset="utf-8" to use almost all the character and symbol in the world -->
        <!-- viewport to make the webpage more responsive -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Link the boostrap5 to the webpage -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <!-- Link the boostrap icon 1.4 to the webpage -->
        <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

        <!-- Link the local css to the webpage -->
        <link href="../bootstrap/local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-50">
            <h1 class="text-center mb-2">Add Item</h1>
            <?php 

                //This check if the user input a blank input because space count as an input for some reasons.
                foreach($arrayPost as $label => $value) {
                    if(empty($value)) {
                        echo 
                            "<div class='alert alert-danger text-center h2' role='alert'>" 
                                . $label . " Input Empty/Invalid." .
                            "</div>
                        ";
                        $logsErrorTest = true;
                    }
                }

                //Check if the Name already exist
                $querySelectItemInfo = "SELECT name FROM tbl_items";
                $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);

                while($itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo)) {
                    if($itemName === $itemInfo["name"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Item Name: Already Exist.
                            </div>
                        ";
                    }
                }

                //Check if the file type is an image format and if the user upload an image or not
                //Add an exception so it would not check an empty upload
                if((@exif_imagetype($_FILES["itemPicture"]['tmp_name']) == false) && (@!empty($_FILES["itemPicture"]['tmp_name']))) {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Item Picture: File Uploaded is not an Image Format.
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
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Database: Add Item Failed.
                        </div>
                    ";
                } else {
                    //This query is to select find the id increment value for the image name
                    $queryTableStatus = "SHOW TABLE STATUS LIKE 'tbl_items'"; 
                    $executeQueryTableStatus = mysqli_query($con, $queryTableStatus);
                    $tableInfo = mysqli_fetch_assoc($executeQueryTableStatus); 
                    $nextId = $tableInfo["Auto_increment"];


                    //Moving and naming the img to img/items folder
                    if($uploadedImage == true) {
                        $target_dir = "../img/items/";
                        @$fileType = pathinfo($_FILES["itemPicture"]["name"])["extension"];
                        $fileName = $nextId . "_picture." . $fileType;
                        $target_file = $target_dir . $fileName;
                        move_uploaded_file($_FILES["itemPicture"]["tmp_name"], $target_file);
                    }
                    

                    //Query for the new User that would be registered
                    //This query is for an upload without an image
                    if($uploadedImage == false) {
                        $queryInsert = "
                        INSERT INTO tbl_items(
                            name,
                            price,
                            description
                        )
                        VALUES (
                            '$itemName',
                            '$itemPrice',
                            '$itemDescription'
                        )
                        ";
                    } else {
                        //Query for the image with an image
                        $queryInsert = "
                        INSERT INTO tbl_items(
                            name,
                            price,
                            description,
                            picture
                        )
                        VALUES (
                            '$itemName',
                            '$itemPrice',
                            '$itemDescription',
                            '$fileName'
                        )
                        ";
                    }

                    //Execute the Insert Query Above
                    $executeQueryInsert = mysqli_query($con, $queryInsert);

                    echo "
                        <div class='alert alert-success text-center h2' role='alert'>
                            Database: Item Added.
                        </div>
                    ";
                }
            ?>
            <div class="col text-center">
                <a class="btn btn-primary" href="itemList.php" role="button">Return</a>
            </div>
        </div>
    </body>
</html>