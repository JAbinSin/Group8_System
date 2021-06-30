<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Get the values from the url
    @$selector = $_GET["selector"];
    @$validator = $_GET["validator"];
    $success = false;

    if(empty($selector) || empty($validator)) {
    } else {
        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            $success = true;
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Password Reset</title>

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
        <!-- This is the container of the form  -->
        <div class="container p-3 mb-2 mt-5 bg-normal-92 text-white w-25 rounded-3">
            <!-- This is the form that would need inputs that would be passed to the loginHandler.php -->
            <?php
                if($success == true) {
                    echo "
                        <h1 class='text-center mb-2 opacity-1'>New Password</h1>
                        <form action='newPassword.php' method='post'>
                            <div class='mb-3'>
                                <label for='password' class='form-label'>Password</label>
                                <input type='password' class='form-control text-light bg-dark' name='password' placeholder='Enter Password' required>
                            </div>
                            <div class='mb-3'>
                                <label for='confirmPassword' class='form-label'>Confirm Password</label>
                                <input type='password' class='form-control text-light bg-dark' name='confirmPassword' placeholder='Confirm Password' required>
                            </div>
                            <div class='col text-center'>
                                <input type='hidden' name='selector' value='$selector'>
                                <input type='hidden' name='validator' value='$validator'>
                                <button type='submit' name='btnSubmit' class='btn btn-secondary mb-3 rounded-pill shadow-lg'>Send</button>
                            </div>
                        </form>
                    ";
                } elseif($_GET["pass"] == "empty") {
                    echo "
                        <div class='alert alert-danger text-center' role='alert'>
                            <h2>Password Empty.</h2>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='#' onclick='window.history.go(-1); return false;' role='button'>Return</a>
                        </div>
                    ";
                } elseif($_GET["pass"] == "notmatch") {
                    echo "
                        <div class='alert alert-danger text-center' role='alert'>
                            <h2>Password Does not Match.</h2>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='#' onclick='window.history.go(-1); return false;' role='button'>Return</a>
                        </div>
                    ";
                } elseif($_GET["pass"] == "less") {
                    echo "
                        <div class='alert alert-danger text-center' role='alert'>
                            <h2>Password Must be 8 Characters and Above.</h2>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='#' onclick='window.history.go(-1); return false;' role='button'>Return</a>
                        </div>
                    ";
                }
            ?>
        </div>
    </body>
</html>
