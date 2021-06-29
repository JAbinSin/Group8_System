<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Include the email system
    include_once("../email/orderEmail.php");

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the input from the POST
    $testError = false;
    $choice = $_POST["btnSubmit"];

    //Redirect the user if they pick the clear option
    if($choice == "CLEAR") {
        header("Location: clear.php");
        exit();
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Buy</title>

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
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-25 opacity-1">
            <h1 class="text-center mb-2">Cart</h1>
            <?php
                $userId = $_SESSION["userId"];
                $itemStatus = "pending";

                if(empty($_SESSION["cartItemId"])) {
                  echo "<div class='alert alert-warning text-center overflow-auto' role='alert'>
                          <h2>Items Failed to Purchase.</h2>
                          <h4>Item Failed to Purchase.</h4>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-secondary' href='itemList.php' role='button'>Home</a>
                        </div>";
                  exit();
                } else {
                  //Query and Execute for the Order Id
                  $querySelectOrderId = "SELECT max(order_id) AS order_id FROM tbl_history";
                  $executeQuerySelectOrderId = mysqli_query($con, $querySelectOrderId);
                  $orderIdInfo = mysqli_fetch_assoc($executeQuerySelectOrderId);
                  @$orderId = $orderIdInfo["order_id"] + 1;

                  //Email Form 1
                  $mail->Subject = "Restauday Order Status";
                  $mail->Body = "<p>Order Status: Pending</p>";
                  $mail->Body .= "<p>Order Id: $orderId</p>";
                  $mail->Body .= "<table><tr><th>Name</th><th>Quantity</th><th>Price</th></tr>";

                  for($i=0; $i < (1 + @max(array_keys($_SESSION["cartItemId"]))); $i++) {
                      if(isset($_SESSION["cartItemId"][$i])) {
                          $sessItemId = $_SESSION["cartItemId"][$i];
                          $sessItemQuantity = $_SESSION["cartItemQuantity"][$i];

                          //Query and Execute for the item information
                          $querySelectItemInfo = "SELECT * FROM tbl_items WHERE id = $sessItemId";
                          $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);
                          $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);
                          $itemPrice = $itemInfo["price"];
                          $itemPicture = $itemInfo["picture"];
                          $itemName = $itemInfo["name"];
                          @$itemTotalQuantity = $itemTotalQuantity + $sessItemQuantity;
                          $itemPriceTotal = $itemPrice * $sessItemQuantity;
                          @$itemPriceGrandTotal = $itemPriceGrandTotal + $itemPriceTotal;
                          $itemPriceTotalFormat = number_format($itemPriceTotal, 2, '.', ',');

                          $queryInsert = "
                          INSERT INTO tbl_history(
                              user,
                              picture,
                              name,
                              item,
                              quantity,
                              price,
                              status,
                              order_id
                          )
                          VALUES (
                              '$userId',
                              '$itemPicture',
                              '$itemName',
                              '$sessItemId',
                              '$sessItemQuantity',
                              '$itemPrice',
                              '$itemStatus',
                              '$orderId'
                          )
                          ";

                          $executeQueryInsert = mysqli_query($con, $queryInsert);

                          unset($_SESSION["cartItemId"][$i]); //Clear All the Session for cartItemId
                          unset($_SESSION["cartItemQuantity"][$i]); //Clear All the Session for cartItemQuantity

                          //Email Form2 Table
                          $mail->Body .= "<tr style='text-align: center'><td style='margin: 5px'>$itemName</td><td style='margin: 5px'>$sessItemQuantity</td><td style='margin: 5px'>₱ $itemPriceTotalFormat</td></tr>";
                      }
                  }
                  echo "<div class='alert alert-success text-center overflow-auto' role='alert'>
                          <h2>Items Successfully Purchase.</h2>
                        </div>";

                  $itemPriceGrandTotalFormat = number_format($itemPriceGrandTotal, 2, '.', ',');

                  //Email Form3 Send
                  $email = $_SESSION["userEmail"];
                  $mail->Body .= "<tr><td style='margin: 5px'></td><td style='margin: 5px text-align:end'>Total Items:</td><td style='margin: 5px'>$itemTotalQuantity</td></tr>";
                  $mail->Body .= "<tr><td style='margin: 5px'></td><td style='margin: 5px text-align:end'>Grand Total:</td><td style='margin: 5px'>₱ $itemPriceGrandTotalFormat</td></tr>";
                  $mail->Body .= "</table>";
                  $mail->AddAddress("$email");

                  //Only send the email if the email is validated
                  if($_SESSION["userValidated"] == "yes") {
                      $mail->Send();
                  }
                }
            ?>
            <div class="col text-center">
                <a class='btn btn-secondary' href='itemList.php' role='button'>Home</a>
            </div>
        </div>
    </body>
</html>
