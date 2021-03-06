<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the input from the form and asign a variable from the register.php
    $userUsername = trim($_POST["username"]);
    $userPassword = trim($_POST["password"]);

    //Used as a bool to check if there is an error in the whole validation
    $logsErrorTest = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Login</title>

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
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-dark text-white w-25 rounded-3">

            <!-- php for the verifications and execution to the database  -->
            <?php

                //Check if the input is blank or empty because whitespace can bypass the required attribute
                if(empty($userUsername)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center text-wrap overflow-auto' role='alert'>
                            <h2>Username:</h2>
                            <h4 class='fw-normal'>Input Empty/Invalid</h4>
                        </div>
                        ";
                }
                if(empty($userPassword)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center overflow-auto' role='alert'>
                            <h2>Password:</h2>
                            <h4 class='fw-normal'>Input Empty/Invalid.</h4>
                        </div>
                    ";
                }


                //Query for the user
                $querySelectInfoUser = "SELECT id, username, password, email, user_type, validated FROM tbl_users WHERE username = '$userUsername'";

                //Set a temporary variable for comparison
                if($executeQuerySelectInfoUser = mysqli_query($con, $querySelectInfoUser)) {
                    $userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUser);
                    if(isset($userInfo)) {
                        $userUsernametmp = $userInfo["username"];
                        $userPasswordtmp = $userInfo["password"];
                        $user_type = $userInfo["user_type"];
                    }
                }

                //Validate if the information provided by the user is correct
                //If true then the user would be able to login
                //If false they would need to login again
                if($logsErrorTest == false) {
                    if($userUsername == @$userUsernametmp) {
                        if(password_verify($userPassword, $userPasswordtmp)) {

                            //Set a session for usertype and id used when accessing webpages
                            $_SESSION["userType"] = $userInfo["user_type"];
                            $_SESSION["userId"] = $userInfo["id"];
                            $_SESSION["userValidated"] = $userInfo["validated"];
                            $_SESSION["userEmail"] = $userInfo["email"];

                            header("Location: itemList.php");
                            exit();
                        } else {
                            echo "
                                <div class='alert alert-danger text-center overflow-auto' role='alert'>
                                    <h2>Password:</h2>
                                    <h4 class='fw-normal'>Incorrect.</h4>
                                </div>
                            ";
                        }
                    } else {
                        echo "
                            <div class='alert alert-danger text-center overflow-auto' role='alert'>
                                <h2>Username:</h2>
                                <h4 class='fw-normal'>Does not Exist.</h4>
                            </div>
                        ";
                    }
                }
            ?>

            <div class="col text-center">
                <a class="btn btn-secondary mb-3 shadow-lg" href="login.php" role="button">Login Again</a>
            </div>
        </div>
    </body>
</html>
