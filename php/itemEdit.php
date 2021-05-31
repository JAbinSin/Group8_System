<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Only the admin can access this webpage
    if(($_SESSION['userType'] != "admin") || (empty($_GET["id"]))) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $itemId = $_GET['id'];

    //Query and Execute for the user information
    $querySelectItemInfo = "SELECT name, price, description FROM tbl_items WHERE id = $itemId";
    $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);
    $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);

    $itemName = $itemInfo["name"];
    $itemPrice = $itemInfo["price"];
    $itemDescription = $itemInfo["description"];

    //Redirect the user if the id is invalid
    if(is_null($itemName)) {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Item Edit</title>

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

        <!-- Container for the item edit -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25 opacity-1">
            <h1 class="text-center mb-2">Item Edit</h1>
            <form action="itemEditHandler.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="itemPicture" class="form-label">Item Picture</label>
                    <input class="form-control text-light bg-dark" type="file" accept="image/*" name="itemPicture">
                </div>
                <div class="mb-3">
                    <label for="itemName" class="form-label">Item Name (Only Characters and Number Are Allowed)</label>
                    <input type="text" class="form-control text-light bg-dark" name="itemName" placeholder="<?php echo "$itemName"?>" value="<?php echo "$itemName"?>" pattern="[A-z0-9À-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="itemPrice" class="form-label">Item Price</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                        <input type="number" class="form-control text-light bg-dark" aria-label="Peso amount (with dot and two decimal places)" name="itemPrice" placeholder="<?php echo "$itemPrice"?>" value="<?php echo "$itemPrice"?>" step=".01" min="1" max="999999999.99" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="itemDescription" class="form-label">Item Description</label>
                    <textarea class="form-control bg-dark text-light" rows="3" name="itemDescription" placeholder="<?php echo "$itemDescription"?>" style="max-height: 15rem;" required><?php echo "$itemDescription"?></textarea>
                </div>
                <input type="hidden" name="itemId" value="<?php echo "$itemId"?>">
                <div class="col text-center">
                    <input class="btn btn-primary btn-success rounded-pill" type="submit" value="UPDATE ITEM">
                    <br>
                    <a class='btn btn-danger mt-2 rounded-pill' href='itemList.php' role='button'>CANCEL</a>
                </div>
            </form>
        </div>
    </body>
</html>
