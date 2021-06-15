<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    if(empty($_GET["id"])) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $itemId = $_GET["id"];

    //Query and Execute for the user information
    $querySelectItemInfo = "SELECT * FROM tbl_items WHERE id = $itemId";
    $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);

    $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);

    @$itemPicture = $itemInfo["picture"];
    @$itemName = $itemInfo["name"];
    @$itemPrice = $itemInfo["price"];
    @$itemDescription = $itemInfo["description"];
    @$itemCategory = $itemInfo["category"];

    //Make variable to Number Format
    $itemPrice = number_format($itemPrice, 2, '.', ',');
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Menu</title>

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

        <!-- Container for the item details -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-50 opacity-1">
            <?php
                if(is_null($itemName)) {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Item no longer exist.
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='../index.php' role='button'>HOME</a>
                        </div>
                      </div>
                      </body>
                    ";
                    exit();
                }
            ?>
            <h1 class="text-end pe-3"><a href="itemList.php?category=<?php echo "$itemCategory"?>" class="text-reset text-decoration-none" onclick="window.history.go(-1); return false;"><i class="bi bi-arrow-counterclockwise"></i>Back</a></h1>
            <div class="card mb-3 text-dark bg-transparent mx-auto" style="max-width: 50rem; border: 0;">
                <div class="row g-0">
                    <div class="col-md-4 p-0 bg-transparent mb-3" style="max-height: 16rem; min-height: 16rem;">
                        <img class='border border-4 border-secondary' src="../img/items/<?php echo "$itemPicture"?>" alt="Image Unavailable" style="width: 100%; height: 100%">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body text-break text-white">
                            <h2 class="card-title text-primary"><?php echo "$itemName"?></h2>
                            <hr>
                            <p class="h5">Item Price: ₱<?php echo "$itemPrice"?></p>
                            <?php
                                //Only the admin and client can see the Add to cart button and the Quantity Input
                                if((@$_SESSION["userType"] == "admin") || (@$_SESSION["userType"] == "client")) {
                                    echo"
                                        <form action='itemHandler.php' method='post'>
                                            <div class='row mt-4'>
                                                <label for='itemQuantity' class='col-sm-3 col-form-label h5'>Item Quantity</label>
                                                <div class='quantity '>
                                                    <div class='btn dec'>-</div>
                                                    <input class='quantity-input bg-dark h5' type='number' id='0' name='itemQuantity' value='1' step='1' min='1' max='99' pattern='/^-?\d+\.?\d*$/' onKeyPress='if(this.value.length==2) return false;' onkeypress='return event.charCode >= 48 && event.charCode <= 57' title='Item Quantity' required>
                                                    <div class='btn inc'>+</div>
                                                </div>
                                            </div>
                                            <div>
                                                <input type='hidden' name='itemId' value='$itemId'>
                                                <button type='submit' class='btn btn-primary mt-2'><i class='bi bi-cart-plus'></i> Add to Cart</button>
                                            </div>
                                        </form>
                                    ";
                                } else {
                                    echo"
                                        <div class='row mt-4'>
                                            <label for='itemQuantity' class='col-sm-3 col-form-label h5'>Item Quantity</label>
                                            <div class='col-sm-1'>
                                                <input type='number' class='form-control text-light bg-dark' style='width: 4rem;' name='itemQuantity' value='1' disabled>
                                            </div>
                                        </div>
                                        <div>
                                            <button type='submit' class='btn btn-primary btn-lg mt-2 disabled'><i class='bi bi-cart-plus'></i> Add to Cart</button>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="text-white text-break mt-3">
                    <hr>
                    <h1 class="text-primary">Description</h1>
                    <p class="h5 mt-4 lh-base"><?php echo nl2br($itemDescription)?></p>
                </div>
            </div>
        </div>

        <script>
            //variables
            var incrementButton = document.getElementsByClassName('inc');
            var decrementButton = document.getElementsByClassName('dec');

            //for increment button
            for(var i = 0; i < incrementButton.length; i++) {
                var button = incrementButton[i];
                button.addEventListener('click', function(event){
                    var buttonClicked = event.target;
                    var input = buttonClicked.parentElement.children[1];
                    var inputValue = input.value;

                    var newValue = parseInt(inputValue) + 1;

                    input.value = newValue;
                });
            }

            //for decrement button
            for(var i = 0; i < decrementButton.length; i++) {
                var button = decrementButton[i];
                button.addEventListener('click', function(event){
                    var buttonClicked = event.target;
                    var input = buttonClicked.parentElement.children[1];
                    var inputValue = input.value;

                    var newValue = parseInt(inputValue) - 1;

                    if(newValue > 0) {
                       input.value = newValue;
                    }
                });
            }
        </script>
    </body>
</html>
