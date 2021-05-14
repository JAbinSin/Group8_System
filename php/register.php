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

        <!-- This is the container of the form  -->
        <div class="container p-3 mb-2 bg-dark text-white w-50 rounded-3">
            <h1 class="text-center mb-2">Register</h1>
            <!-- This is the form that would need inputs that would be passed to the registerHandler.php -->
            <form action="registerHandler.php" method="post">
                <div class="mb-3">
                    <label for="userFirstName" class="form-label">First Name (Only Characters)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userFirstName" placeholder="e.g Zate" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userLastName" class="form-label">Last Name (Only Characters)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userLastName" placeholder="e.g Niemo" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userUsername" class="form-label">Username (Only Characters and Numbers)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userUsername" placeholder="e.g LoliShlong" pattern="[a-zA-Z0-9]+" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userPassword" class="form-label">Password</label>
                    <input type="password" class="form-control text-light bg-dark" name="userPassword" placeholder="Password" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control text-light bg-dark" name="userConfirmPassword" placeholder="Confirm Password" minlength="8" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email</label>
                    <input type="text" class="form-control text-light bg-dark" name="userEmail" placeholder="e.g example@email.com" required>
                </div>
                <div class="mb-3">
                    <label for="userPhoneNumber" class="form-label">Cellphone Number (11-Digits)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userPhoneNumber" placeholder="e.g 09452960981" pattern="[0-9]{11}" maxlength="11" minlength="11" required>
                </div>
                <input type="hidden" name="userUsertype" value="client">
                <div class="col text-center">
                    <a href="login.php" class="link-primary">Already have an Account?</a>
                    <br>
                    <button type="submit" class="btn btn-primary mt-2">Register</button>
                </div>
            </form>
        </div>
    </body>
</html>