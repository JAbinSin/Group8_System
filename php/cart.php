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
        <div class="container p-3 mb-2 bg-normal-92 text-white rounded-3 w-75 table-responsive">
            <h1 class="text-start mb-2">Cart</h1>

            <?php
            //Check if the Cart is Empty
            if(empty($_SESSION["cartItemId"])) {
                echo "
                    <div class='alert alert-warning text-center' role='alert'>
                        <h2>Cart is Empty.</h2>
                    </div>";
            } else {
              echo "
              <form action='cartUpdate.php' method='post' id=formCart>
                  <table class='table table-dark  border-white align-middle'>
                      <thead class='text-center'>
                          <tr>
                              <th class='col-1'>REMOVE</th>
                              <th class='col-1'>PICTURE</th>
                              <th class='col-2'>NAME</th>
                              <th class='col-1'>PRICE</th>
                              <th class='col-1'>QUANTITY</th>
                              <th class='col-1'>TOTAL</th>
                          </tr>
                      </thead>

                      <tbody>
              ";

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
                      $itemUnitPrice = $itemInfo["price"];
                      $itemDescription = $itemInfo["description"];
                      @$totalPrice = $totalPrice + $itemPrice;

                      //Make variable to Number Format
                      $totalPriceNumber = number_format($totalPrice, 2, '.', ',');
                      $itemPriceNumber = number_format($itemPrice, 2, '.', ',');
                      $itemUnitPriceNumber = number_format($itemUnitPrice, 2, '.', ',');

                      echo "
                          <tr class='text-center'>
                              <td class='h2 border-start border-end border-white'><button type='submit' form='formCart' value='REMOVE|$sessItemId' name='btnSubmit'><i class='bi bi-trash'></i></button></td>
                              <td class='border-start border-end'><a href='item.php?id=$sessItemId'><img src='../img/items/$itemPicture' class='rounded mx-auto d-block img-fluid cart-img' alt='$itemName'></a></td>
                              <td class='h5 border-start border-end'><a href='item.php?id=$sessItemId' class='text-reset text-decoration-none'>$itemName</a></td>
                              <td class='h5 border-start border-end'>₱ $itemUnitPriceNumber</td>
                              <td class='border-start border-end'>
                                  <div class='quantity quantity-center'>
                                      ".($sessItemQuantity <= 1 ? "<button class='btn dec disabled' name='btnSubmit'>-</button>" : "<button class='btn dec' value='UPDATE|$sessItemId' name='btnSubmit'>-</button>")."
                                      <input class='quantity-input bg-dark h5' type='number' id='$i' name='Qty_$sessItemId' value='$sessItemQuantity' pattern='/^-?\d+\.?\d*$/' onKeyPress='if(this.value.length==2) return false;' onkeypress='return event.charCode >= 48 && event.charCode <= 57' title='Item Quantity' required>
                                      ".($sessItemQuantity >= 99 ? "<button class='btn inc disabled' name='btnSubmit'>+</button>" : "<button class='btn inc' value='UPDATE|$sessItemId' name='btnSubmit'>+</button>")."
                                      <input type='submit' hidden id='submitEnter$i' name='btnSubmit' class='submitEnter' value='UPDATE|$sessItemId'>
                                  </div>
                              </td>
                              <td class='h5 border-start border-end'>₱ $itemPriceNumber</td>
                          </tr>
                      ";
                  }
              }
              echo "
                      </tbody>

                      <tfoot class='text-center'>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class='text-end h5'>Grand Total:</td>
                              <td class='h5'>₱ $totalPriceNumber</td>
                          </tr>
                      </tfoot>
                  </table>
              </form>
              ";
            }


            //If the cart is empty the option for Clear and Buy would not be visible/available
            if(!empty(@array_keys($_SESSION["cartItemId"]))) {
                echo "
                    <form action='buy.php' method='post'>
                        <div class='col text-end me-5'>
                            <input class='btn btn-primary btn-danger btn-lg mt-3' type='submit' name='btnSubmit' value='CLEAR'>
                            <input class='btn btn-primary btn-primary btn-lg mt-3 ms-3' type='submit' name='btnSubmit' value='BUY'>
                        </div>
                    </form>
                ";
            }
            ?>

        </div>

        <script>
            //variables
            var incrementButton = document.getElementsByClassName('inc');
            var decrementButton = document.getElementsByClassName('dec');
            var input = document.getElementsByClassName('quantity-input');

            //for enter
            for(var i = 0; i < input.length; i++) {
                var enter = input[i];
                var id = "submitEnter" + i;

                enter.addEventListener("keyup", function(event) {
                    var buttonClicked = event.target;
                    var input = buttonClicked.parentElement.children[3];

                    if (event.keyCode === 13) {
                        event.preventDefault();
                        document.getElementById(id).click();
                    }
                });
            }

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
