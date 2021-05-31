<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Only the admin can access this webpage
    if(!($_SESSION['userType'] == "admin")) {
        header("Location: ../index.php");
    }
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
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Link the boostrap icon 1.4 to the webpage -->
        <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

        <!-- Link the local css to the webpage -->
        <link href="../bootstrap/local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the input form of the add item -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25 opacity-1">
            <h1 class="text-center mb-2">Add Item</h1>
            <!-- This is the form that would need inputs that would be passed to the addItemHandler.php -->
            <form action="addItemHandler.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                    <label for="itemPicture" class="form-label">Item Picture</label>
                    <input class="form-control text-light bg-dark" type="file" accept="image/*" name="itemPicture">
                </div>
                <div class="mb-3">
                    <label for="itemName" class="form-label">Item Name (Only Characters and Number Are Allowed)</label>
                    <input type="text" class="form-control text-light bg-dark" name="itemName" placeholder="e.g Hotdog" pattern="[A-z0-9À-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="itemPrice" class="form-label">Item Price</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                        <input type="number" class="form-control text-light bg-dark" aria-label="Peso amount (with dot and two decimal places)" name="itemPrice" placeholder="e.g 25.00" step=".01" min="1" max="999999999" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="itemDescription" class="form-label">Item Description</label>
                    <textarea class="form-control bg-dark text-light" rows="3" name="itemDescription" style="max-height: 15rem;" required></textarea>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary mt-2 rounded-pill">ADD ITEM</button>
                </div>
            </form>
        </div>
    </body>
</html>
