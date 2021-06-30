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

        <?php
            if(isset($_GET["verify"])) {
                if($_GET["newpass"] == "success") {
                    echo "
                        <div class='alert alert-center alert-success d-flex align-items-center w-25 alert-dismissible fade show' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                            <div>
                                Password Change.
                            </div>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    ";
                }
            }
        ?>

        <!-- This is the container of the form  -->
        <div class="container p-3 mb-2 bg-normal-92 text-white w-25 rounded-3">
            <h1 class="text-center mb-2 opacity-1">Login</h1>
            <!-- This is the form that would need inputs that would be passed to the loginHandler.php -->
            <form action="loginHandler.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control text-light bg-dark" name="username" placeholder="Enter Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control text-light bg-dark" name="password" placeholder="Enter Password" required>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-secondary mb-3 rounded-pill shadow-lg">LOGIN</button>
                    <p class="m-0"><a href="forgotPassword.php">Forgot Password?</a></p>
                    <p class="m-0">Not a member? <a href="register.php">Register now</a></p>
                </div>
            </form>
        </div>
    </body>
</html>
