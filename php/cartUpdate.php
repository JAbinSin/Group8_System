<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");
    ob_start();

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the input from the POST
    $testError = false;

    $choice = filter_input(INPUT_POST, 'btnSubmit');
    $exploded_value = explode('|', $choice);
    $choiceSelect = $exploded_value[0];
    $choiceId = $exploded_value[1];

    $choiceQty = $_POST["Qty_$choiceId"];
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | </title>

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
        <link href="../local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3">
            <h1 class="text-center mb-2">Cart</h1>

            <?php
                if($choiceSelect == "UPDATE") {
                    //Check if the input is blank
                    //This is just a safety measure if it happens
                    if(empty($choiceId)) {
                        echo "
                            <div class='alert alert-danger text-center' role='alert'>
                                <h2>Quantity</h2>
                                <h4 class='fw-normal'>Invalid Input/Value</h4>
                            </div>
                        ";
                        $testError = true;
                    }

                    //If there is no error update the item in the cart array
                    if($testError == false) {
                       //Declare a temporary variable for the keyholder
                        $idTmp = array_search($choiceId, $_SESSION["cartItemId"]);
                        $valueReplace =  $choiceQty;

                        //So that the Quantity can't exceed the maximum limit of 99
                        if($valueReplace > 99) {
                            $valueReplace = 99;
                        }

                        //Used to replace the current Quantity of Cart with the additional Quantity from the form
                        $_SESSION["cartItemQuantity"][$idTmp] = $valueReplace;
                        header("Location: cart.php");
                        exit();
                    } else {
                        echo "
                            <div class='alert alert-danger text-center' role='alert'>
                                <h2>Item: Failed to Update.</h2>
                                <h4 class='fw-normal'></h4>
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-primary' href='cart.php' role='button'>RETURN</a>
                            </div>
                        ";
                    }
                } elseif($choiceSelect == "REMOVE") {
                    $idTmp = array_search($choiceId, $_SESSION["cartItemId"]);
                    unset($_SESSION["cartItemId"][$idTmp]); //Clear the Session for cartItemId
                    unset($_SESSION["cartItemQuantity"][$idTmp]); //Clear the Session for cartItemQuantity
                    header("Location: cart.php");
                    exit();
                }
            ?>
        </div>
    </body>
</html>
