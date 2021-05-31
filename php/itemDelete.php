<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin can access this webpage
    if(($_SESSION['userType'] != "admin") || (empty($_GET["id"]))) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $itemId = $_GET["id"];

    //Query for that user using the id to find it
    $querySelectItemInfo = "SELECT name FROM tbl_items WHERE id = '$itemId'";
    $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);
    $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);

    //Would be using this variable to ask for confirmation of user deletion
    $itemName = $itemInfo["name"];

    //Redirect the user if the id is invalid
    if(is_null($itemName)) {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Item Delete</title>

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

        <!-- Container for the form of delete user -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25 opacity-1">
            <h1 class="text-center mb-2">Item Delete</h1>
            <div class="alert alert-danger text-center h2 overflow-auto" role="alert">
                <?php
                    echo "
                        Delete Item: <strong>" . $itemName . "</strong>"
                    ;
                ?>
            </div>

            <div class="col text-center">
                <!-- Form used to pass the data to the adminDeleteUserHandler.php -->
                <form action="itemDeleteHandler.php" method="post">
                    <input class="btn btn-primary btn-danger rounded-pill" type="submit" value="DELETE">
                    <input type="hidden" name="itemId" value="<?php echo $itemId?>">
                </form>
                <a class='btn btn-primary mt-2 rounded-pill' href='itemList.php' role='button'>CANCEL</a>
            </div>
        </div>
    </body>
</html>
