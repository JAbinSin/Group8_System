<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

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
    if($choice == "Clear") {
        header("Location: clear.php");
        exit();
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Buy</title>

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
                $userId = $_SESSION["userId"];
                $itemStatus = "pending";

                if(empty($_SESSION["cartItemId"])) {
                  echo "<div class='alert alert-warning text-center h2' role='alert'>
                          Items Failed to Purchase.
                        </div>";
                  exit();
                } else {
                  //Query and Execute for the Order Id
                  $querySelectOrderId = "SELECT max(order_id) AS order_id FROM tbl_history";
                  $executeQuerySelectOrderId = mysqli_query($con, $querySelectOrderId);
                  $orderIdInfo = mysqli_fetch_assoc($executeQuerySelectOrderId);
                  @$orderId = $orderIdInfo["order_id"] + 1;

                  for($i=0; $i < (1 + @max(array_keys($_SESSION["cartItemId"]))); $i++) {
                      if(isset($_SESSION["cartItemId"][$i])) {
                          $sessItemId = $_SESSION["cartItemId"][$i];
                          $sessItemQuantity = $_SESSION["cartItemQuantity"][$i];

                          //Query and Execute for the item information
                          $querySelectItemInfo = "SELECT * FROM tbl_items WHERE id = $sessItemId";
                          $executeQuerySelectItemInfo = mysqli_query($con, $querySelectItemInfo);
                          $itemInfo = mysqli_fetch_assoc($executeQuerySelectItemInfo);
                          $itemPrice = $itemInfo["price"] * $sessItemQuantity;

                          $queryInsert = "
                          INSERT INTO tbl_history(
                              user,
                              item,
                              quantity,
                              price,
                              status,
                              order_id
                          )
                          VALUES (
                              '$userId',
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
                      }
                  }
                  echo "<div class='alert alert-primary text-center h2' role='alert'>
                          Items Successfully Purchase.
                        </div>";
                }
            ?>
        </div>
    </body>
</html>
