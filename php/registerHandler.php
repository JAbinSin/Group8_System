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
    $userFirstName = trim($_POST['userFirstName']);
    $userLastName = trim($_POST['userLastName']);
    $userUsername = trim($_POST['userUsername']);
    $userPassword = trim($_POST['userPassword']);
    $userConfirmPassword = trim($_POST['userConfirmPassword']);
    $userEmail = trim($_POST['userEmail']);
    $userPhoneNumber = trim($_POST['userPhoneNumber']);
    $userUserType = $_POST['userUsertype'];

    //Sanitize all the Inputs
    $userFirstName = filter_var($userFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $userLastName = filter_var($userLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $userUsername = filter_var($userUsername, FILTER_SANITIZE_SPECIAL_CHARS);
    $userPassword = filter_var($userPassword, FILTER_SANITIZE_SPECIAL_CHARS)
    $userConfirmPassword = filter_var($userConfirmPassword, FILTER_SANITIZE_SPECIAL_CHARS)
    $userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);
    $userPhoneNumber = filter_var($userPhoneNumber, FILTER_SANITIZE_NUMBER_INT);
    $userUserType = filter_var($userUserType, FILTER_SANITIZE_NUMBER_INT);

    //An array for easier and faster checking if there is an error in the variable
    $arrayPost = array("First Name:" => $userFirstName, "Last Name:" => $userLastName, "Username:" => $userUsername, "Password:" => $userPassword, "Confirm Password:" => $userConfirmPassword, "Email:" => $userEmail, "Cellphone Number:" => $userPhoneNumber);

    //Used as a bool to check if there is an error in the whole validation
    $logsErrorTest = false;

    //Encrypt the password
    //This would be used to be pass to the database instead of the password or confirmpassword
    $passwordHashed = password_hash($userPassword, PASSWORD_DEFAULT);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Register</title>

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
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the register handler -->
        <div class="container p-3 mb-2 bg-dark text-white w-25 rounded-3 opacity-1">
            <h1 class="text-center mb-2">Register</h1>

            <!-- php for the verifications and execution to the database  -->
            <?php

                //This check if the user input a blank input because space count as an input for some reasons.
                foreach($arrayPost as $label => $value) {
                    if(empty($value)) {
                        echo
                            "<div class='alert alert-danger text-center h2 overflow-auto' role='alert'>"
                                . $label . " Input Empty/Invalid." .
                            "</div>
                        ";
                        $logsErrorTest = true;
                    }
                }

                //Check if the password and confirmed password is the same.
                if(!($userPassword === $userConfirmPassword)) {
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Confirm Password: Does not Match.
                        </div>
                    ";
                    $logsErrorTest = true;
                }

                //Check if the Email, Username, and Cellphone Number already exist
                $querySelectInfoUsers = "SELECT email, username, phone_number FROM tbl_users";
                $executeQuerySelectInfoUsers = mysqli_query($con, $querySelectInfoUsers);

                while($userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUsers)) {
                    if($userEmail === $userInfo["email"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                                Email: Already Exist.
                            </div>
                        ";
                    }
                    if($userUsername === $userInfo["username"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                                Username: Already Exist.
                            </div>
                        ";
                    }
                    if($userPhoneNumber === $userInfo["phone_number"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                                Cellphone Number: Already Exist.
                            </div>
                        ";
                    }
                }

                //Verify the password length, and usernamne length because whitespace can bypass the minlength attribute in the input tag
                if((strlen($userPassword) < 8) && !empty($userPassword)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Password: Must be 8 Character and Above.
                        </div>
                    ";
                }
                if((strlen($userUsername) < 8) && !empty($userUsername)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Username: Must be 8 Character and Above.
                        </div>
                    ";
                }

                //Verify if the phone number is 11 character
                //Incase the pattern tag cannot stop the user
                if((strlen($userPhoneNumber) != 11) && !empty($userPhoneNumber)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Cellphone Number: Must be 11 Digits.
                        </div>
                    ";
                }

                //If the following Inputs are valid it would enter the database, and if not it would not.
                if($logsErrorTest == true) {
                    echo "
                        <div class='alert alert-danger text-center h2 overflow-auto' role='alert'>
                            Database: No Changes are Made.
                        </div>

                        <div class='col text-center'>
                            <a class='btn btn-secondary mb-3 rounded-pill shadow-lg' href='register.php' role='button'>Register Again</a>
                        </div>
                    ";
                } else {
                    echo "
                        <div class='alert alert-success text-center h2 overflow-auto' role='alert'>
                            Database: User Registered.
                        </div>

                        <div class='col text-center'>
                            <a class='btn btn-secondary mb-3 rounded-pill shadow-lg' href='login.php' role='button'>Login</a>
                        </div>
                    ";

                    //Query for the new User that would be registered
                    $queryInsertUser = "
                    INSERT INTO tbl_users(
                        first_name,
                        last_name,
                        username,
                        password,
                        email,
                        phone_number,
                        user_type
                    )
                    VALUES (
                        '$userFirstName',
                        '$userLastName',
                        '$userUsername',
                        '$passwordHashed',
                        '$userEmail',
                        '$userPhoneNumber',
                        '$userUserType'
                    )
                    ";

                    //Execute the Insert Query Above
                    $executeQueryInsertUser = mysqli_query($con, $queryInsertUser);
                }
            ?>
        </div>
    </body>
</html>
