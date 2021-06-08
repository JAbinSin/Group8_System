<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //only admin can access this page to create another admin account
    if(!($_SESSION['userType'] == "admin")) {
        header("Location: ../index.php");
    }

    //The data that would be input to the database
    //Note:
    //Username and Password should be 8 character and above
    //Cellphone Number should be 11 Digits
    $root_username = "admin123456";
	  $root_email = "admin123456@admin";
	  $root_password = "admin123456";
	  $root_fname = "Severino";
	  $root_lname = "Norbert";
    $root_CellphoneNumber = "11111123421";
	  $root_type = "admin";

    //An array for easier and faster checking if there is an error in the variable
    $arrayPost = array("First Name:" => $root_fname, "Last Name:" => $root_lname, "Username:" => $root_username, "Password:" => $root_password, "Email:" => $root_email, "Cellphone Number:" => $root_CellphoneNumber);

    //Used as a bool to check if there is an error in the whole validation
    $logsErrorTest = false;

    //Encrypt the password
    //This would be used to be pass to the database instead of the password or confirmpassword
    $root_passwordHashed = password_hash($root_password, PASSWORD_DEFAULT);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Add Admin User</title>

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

        <!-- Container for the output message of the add admin account -->
        <div class="container p-3 mb-2 bg-dark text-white rounded-3">
            <h1 class="text-center mb-2">Add Admin User</h1>

            <!-- php for the verifications and execution to the database  -->
            <?php

                //This check if the admin input a blank value
                foreach($arrayPost as $label => $value) {
                    if(empty($value)) {
                        echo
                            "<div class='alert alert-danger text-center h2' role='alert'>"
                                . $label . " Input Empty/Invalid." .
                            "</div>
                        ";
                        $logsErrorTest = true;
                    }
                }

                //Check if the Email, Username, and Cellphone Number already exist
                $querySelectInfoUsers = "SELECT email, username, phone_number FROM tbl_users";
                $executeQuerySelectInfoUsers = mysqli_query($con, $querySelectInfoUsers);

                while($userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUsers)) {
                    if($root_email === $userInfo["email"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Email: Already Exist.
                            </div>
                        ";
                    }
                    if($root_username === $userInfo["username"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Username: Already Exist.
                            </div>
                        ";
                    }
                    if($root_CellphoneNumber === $userInfo["phone_number"]) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Cellphone Number: Already Exist.
                            </div>
                        ";
                    }
                }

                //Verify the password length, and username length
                if(strlen($root_password) < 8) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Password: Must be 8 Character and Above.
                        </div>
                    ";
                }
                if(strlen($root_username) < 8) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Username: Must be 8 Character and Above.
                        </div>
                    ";
                }

                //Verify if the phone number is 11 character
                if((strlen($root_CellphoneNumber) != 11) && !empty($root_CellphoneNumber)) {
                    $logsErrorTest = true;
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Cellphone Number: Must be 11 Digits.
                        </div>
                    ";
                }

                //If the following data are valid it would enter the database, and if not it would not.
                if($logsErrorTest == true) {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Database: No Changes are Made.
                        </div>
                    ";
                } else {
                    echo "
                        <div class='alert alert-success text-center h2' role='alert'>
                            Database: User Registered.
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
                        '$root_fname',
                        '$root_lname',
                        '$root_username',
                        '$root_passwordHashed',
                        '$root_email',
                        '$root_CellphoneNumber',
                        '$root_type'
                    )
                    ";

                    //Execute the Insert Query Above
                    $executeQueryInsertUser = mysqli_query($con, $queryInsertUser);
                }
            ?>
            <div class="col text-center">
                <a class="btn btn-primary" href="itemList.php" role="button">Home</a>
            </div>
        </div>
    </body>
</html>
