<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the guest can access this webpage
    if(isset($_SESSION['userType'])) {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Register</title>

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

        <!-- This is the container of the form  -->
        <div class="container p-3 mb-2 bg-normal-92 text-white w-25 rounded-3">
            <h1 class="text-center mb-2">Register</h1>
            <!-- This is the form that would need inputs that would be passed to the registerHandler.php -->
            <form action="registerHandler.php" method="post">
                <div class="mb-3">
                    <label for="userFirstName" class="form-label">First Name</label>
                    <input type="text" class="form-control text-light bg-dark" name="userFirstName" placeholder="Enter First Name" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userLastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control text-light bg-dark" name="userLastName" placeholder="Enter Last Name" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userUsername" class="form-label">Username (Space are not Allowed)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userUsername" placeholder="Enter Username" pattern="[A-z0-9À-ž]+" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userPassword" class="form-label">Password</label>
                    <input type="password" class="form-control text-light bg-dark" name="userPassword" placeholder="Enter Password" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control text-light bg-dark" name="userConfirmPassword" placeholder="Enter Confirm Password" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email</label>
                    <input type="text" class="form-control text-light bg-dark" name="userEmail" placeholder="Enter Email" required>
                </div>
                <div class="mb-3">
                    <label for="userAddress" class="form-label">Address</label>
                    <input type="text" class="form-control text-light bg-dark" name="userAddress" placeholder="Enter Address" required>
                </div>
                <div class="mb-3">
                    <label for="userZipCode" class="form-label">Zip Code</label>
                    <input type="number" class="form-control text-light bg-dark" name="userZipCode" placeholder="Enter Zip Code" required>
                </div>
                <div class="mb-3">
                    <label for="userPhoneNumber" class="form-label">Cellphone Number (11-Digits)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userPhoneNumber" placeholder="Enter Cellphone Number" pattern="[0-9]{11}" maxlength="11" minlength="11" required>
                </div>
                <input type="hidden" name="userUsertype" value="client">
                <div class="col text-center">
                    <button type="submit" class="btn btn-secondary mb-3 rounded-pill shadow-lg">REGISTER</button>
                    <p class="m-0">Already have an account? <a href="register.php">Login now</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
