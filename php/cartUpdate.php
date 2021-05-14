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
    $choice = $_POST["btnSubmit"];
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | </title>

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
        <link href="../local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3">
            <h1 class="text-center mb-2">Cart</h1>
            
            <?php 
                if($choice == "Update") {
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

                    //If there is no error update the item in the cart array
                    if($testError == false) {
                       //Declare a temporary variable for the keyholder
                        $idTmp = array_search($itemId, $_SESSION["cartItemId"]);
                        $valueReplace =  $itemQuantity;

                        //So that the Quantity can't exceed the maximum limit of 99
                        if($valueReplace > 99) {
                            $valueReplace = 99;
                        }

                        //Used to replace the current Quantity of Cart with the additional Quantity from the form
                        $_SESSION["cartItemQuantity"][$idTmp] = $valueReplace;

                        header("Location: cart.php");
                    } else {
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Item: Failed to Updated.
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-primary' href='cart.php' role='button'>Return</a>
                            </div>
                        "; 
                    }
                } elseif($choice == "Remove") {
                    $idTmp = array_search($itemId, $_SESSION["cartItemId"]);
                    unset($_SESSION["cartItemId"][$idTmp]); //Clear the Session for cartItemId
                    unset($_SESSION["cartItemQuantity"][$idTmp]); //Clear the Session for cartItemQuantity

                    header("Location: cart.php");
                }
            ?>
        </div>
    </body>
</html>