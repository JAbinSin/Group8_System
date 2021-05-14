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
    $itemId = $_POST["itemId"];
    $itemQuantity = trim($_POST["itemQuantity"]);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Menu</title>

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
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-50">
            <h1 class="text-center mb-2">Menu</h1>
            <?php 
                //Check if the input is blank
                //This is just a safety measure if it happens
                if(empty($itemQuantity)) {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Quantity: Invalid Input/Value.
                        </div>
                    ";
                    $testError = true;
                }

                //If there is no error add the item to the cart
                if($testError == false) {

                    //Call session_start() before using $_SESSION Variables
                    if(empty($_SESSION["cartItemId"])){ // check if the cart is empty
                        $_SESSION["cartItemId"] = array();
                        $_SESSION["cartItemQuantity"] = array();
                    }

                    //This is used to add the cart number to an existing array key
                    if(in_array($itemId, $_SESSION["cartItemId"])) {
                        //Declare a temporary variable for the keyholder
                        $idTmp = array_search($itemId, $_SESSION["cartItemId"]);
                        $valueReplace = $_SESSION["cartItemQuantity"][$idTmp] + $itemQuantity;

                        //So that the Quantity can't exceed the maximum limit of 99
                        if($valueReplace > 99) {
                            $valueReplace = 99;
                        }

                        //Used to replace the current Quantity of Cart with the additional Quantity from the form
                        $_SESSION["cartItemQuantity"][$idTmp] = $valueReplace;
                    } else {
                        //If the array key didn't exist before
                        array_push($_SESSION["cartItemId"], $itemId); // push the id in the cart (array)
                        array_push($_SESSION["cartItemQuantity"], $itemQuantity); // push the quantity in the cart (array)
                    }

                    echo "
                        <div class='alert alert-success text-center h2' role='alert'>
                            Item: Added to Cart.
                        </div>
                    ";
                } else {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Item: Failed to add in Cart.
                        </div>
                    ";
                }
            ?>
            <div class="col text-center">
                <a class='btn btn-primary' href='itemList.php' role='button'>Home</a>
            </div>
        </div>
    </body>
</html>