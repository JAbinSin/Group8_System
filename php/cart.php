<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin and client can access this webpage
    if(!isset($_SESSION['userType'])) {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Cart</title>

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
        <div class="container p-3 mb-2 bg-dark text-white rounded-3">
            <h1 class="text-center mb-2">Cart</h1>

            <?php
            //Check if the Cart is Empty
            if(empty($_SESSION["cartItemId"])) {
                echo "
                    <div class='alert alert-warning text-center h2' role='alert'>
                        Cart is Empty.
                    </div>";
            }

            //If the Cart is not empty, list all the current item in cart
            for($i=0; $i < (1 + @max(array_keys($_SESSION["cartItemId"]))); $i++) {
                if(isset($_SESSION["cartItemId"][$i])) {
                    $sessItemId = $_SESSION["cartItemId"][$i];
                    $sessItemQuantity = $_SESSION["cartItemQuantity"][$i];

                    //Query and Execute for the item information
                    $querySelectItemInfo = "SELECT * FROM tbl_items WHERE id = $sessItemId";
                    $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);

                    $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);

                    $itemPicture = $itemInfo["picture"];
                    $itemName = $itemInfo["name"];
                    $itemPrice = $itemInfo["price"] * $sessItemQuantity;
                    $itemDescription = $itemInfo["description"];


                    echo "
                        <form action='cartUpdate.php' method='post'>
                            <div class='card mb-3 text-dark bg-transparent mx-auto' style='max-width: 50rem; border: 0;'>
                                <div class='row g-0 border border-secondary border-2' style='margin-bottom: 1rem;'>
                                    <div class='col-md-4 p-0 bg-transparent' style='max-height: 16rem; min-height: 16rem;'>
                                        <a href='item.php?id=$sessItemId'>
                                            <img src='../img/items/$itemPicture' alt='Image Unavailable' style='width: 100%; height: 100%;'>
                                        </a>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='card-body text-break text-white'>
                                            <h1 class='card-title text-primary'>$itemName</h1>
                                            <hr>
                                            <p class='h5'>Item Total Price: ₱$itemPrice</p>
                                            <div class='row mt-4'>
                                                <label for='itemQuantity' class='col-sm-3 col-form-label h5'>Item Quantity:</label>
                                                <div class='col-sm-1'>
                                                    <input type='number' class='form-control text-light bg-dark' style='width: 4rem;' name='itemQuantity' value='$sessItemQuantity' step='1' min='1' max='99' pattern='/^-?\d+\.?\d*$/' onKeyPress='if(this.value.length==2) return false;' onkeypress='return event.charCode >= 48 && event.charCode <= 57' title='Item Quantity' required>
                                                </div>
                                            </div>
                                            <div>
                                                <input type='hidden' name='itemId' value='$sessItemId'>
                                                <input class='btn btn-primary btn-danger btn-sm mt-3' type='submit' name='btnSubmit' value='Remove'>
                                                <input class='btn btn-primary btn-primary btn-sm mt-3 ms-3' type='submit' name='btnSubmit' value='Update'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    ";
                }
            }

            //If the cart is empty the option for Clear and Buy would not be visible/available
            if(!empty(@array_keys($_SESSION["cartItemId"]))) {
                echo "
                    <form action='buy.php' method='post'>
                        <div class='col text-center'>
                            <input class='btn btn-primary btn-danger btn-lg mt-3' type='submit' name='btnSubmit' value='Clear'>
                            <input class='btn btn-primary btn-primary btn-lg mt-3 ms-3' type='submit' name='btnSubmit' value='Buy'>
                        </div>
                    </form>
                ";
            }
            ?>
        </div>
    </body>
</html>
