<?php
    //Connect to the database
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the userId from the previous form
    $userId = $_POST["userId"];

    //Use to delete the picture from the img/profile folder
    //Run this first before deleteing the whole column from the table
    $queryPictureDelete = "SELECT profile_picture FROM tbl_users WHERE id = '$userId'";
    $executeQueryPicture = mysqli_query($con, $queryPictureDelete);
    $infoUserPicture = mysqli_fetch_assoc($executeQueryPicture);
    $path = "../img/profile/" . $infoUserPicture["profile_picture"];
    if($infoUserPicture["profile_picture"] != "default.png") {
        unlink($path);
    }

    //Ready the query and execute it
    $deleteQuery = "DELETE FROM tbl_users WHERE id = '$userId'";
    $deleteUserInfo = mysqli_query($con, $deleteQuery);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Delete User</title>

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
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25">
            <h1 class="text-center mb-2">Delete User</h1>
            <div class="alert alert-success text-center h2 overflow-auto" role="alert">
                Database: User Deleted.
            </div>
            <div class="col text-center">
                <a class='btn btn-secondary rounded-pill' href='adminListUsers.php' role='button'>RETURN</a>
            </div>
        </div>
    </body>
</html>
