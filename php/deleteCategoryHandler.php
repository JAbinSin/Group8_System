<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the userId from the previous form
    $categoryId = $_POST["categoryId"];

    //Use to delete the picture from the img/category folder
    //Run this first before deleteing the whole column from the table
    $queryPictureDelete = "SELECT category_picture FROM tbl_category WHERE id = '$categoryId'";
    $executeQueryPicture = mysqli_query($con, $queryPictureDelete);
    $infoCategoryPicture = mysqli_fetch_assoc($executeQueryPicture);
    $path = "../img/category/" . $infoCategoryPicture["category_picture"];

    //Ready the query and execute it to delete the item
    $deleteQuery = "DELETE FROM tbl_category WHERE id = '$categoryId'";
    $deleteUserInfo = mysqli_query($con, $deleteQuery);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Category Delete</title>

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

        <!-- Container for the message output of the handler -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25">
            <h1 class="text-center mb-2">Category Delete</h1>
            <div class="alert alert-success text-center overflow-auto" role="alert">
                <h2>Database:</h2>
                <h4 class="fw-normal">Category Deleted.</h4>
            </div>
            <div class="col text-center">
                <a class='btn btn-secondary' href='../index.php' role='button'>HOME</a>
            </div>
        </div>
    </body>
</html>
