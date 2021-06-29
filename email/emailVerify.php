<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Get the values from the url
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];
    $success = false;

    if(empty($selector) || empty($validator)) {
        echo "Error Validating your Request!";
    } else {
        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            $currentDate = date("U");

            $querySelect = "SELECT * FROM tbl_email WHERE selector=? AND expires >= ?";
            $stmt = mysqli_stmt_init($con);
            if(!mysqli_stmt_prepare($stmt, $querySelect)) {
                //Error handling
                echo "Error";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                if(!$row = mysqli_fetch_assoc($result)) {
                    echo "You need to Resubmit your Email Verification";
                    exit();
                } else {
                    $tokenBin = hex2bin($validator);
                    $tokenCheck = password_verify($tokenBin, $row["token"]);

                    if($tokenCheck === false) {
                        echo "You need to Resubmit your Email Verification";
                        exit();
                    } elseif($tokenCheck === true) {
                        $tokenEmail = $row["email"];

                        $querySelect = "SELECT * FROM tbl_users WHERE email=?";
                        $stmt = mysqli_stmt_init($con);
                        if(!mysqli_stmt_prepare($stmt,  $querySelect)) {
                            //Error handling
                            echo "Error";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if(!$row = mysqli_fetch_assoc($result)) {
                                echo "Error";
                                exit();
                            } else {
                                $queryUpdate = "UPDATE tbl_users SET validated=? WHERE email=?";
                                if(!mysqli_stmt_prepare($stmt, $queryUpdate)) {
                                    //Error handling
                                    echo "Error";
                                    exit();
                                } else {
                                    $validated = "yes";
                                    mysqli_stmt_bind_param($stmt, "ss", $validated, $tokenEmail);
                                    mysqli_stmt_execute($stmt);

                                    $queryDelete = "DELETE FROM tbl_email WHERE email=?";
                                    $stmt = mysqli_stmt_init($con);
                                    if(!mysqli_stmt_prepare($stmt, $queryDelete)) {
                                        //Error handling
                                        echo "Error";
                                        exit();
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                        mysqli_stmt_execute($stmt);
                                        //header("Location: ../index.php");
                                        $success = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

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
        <!-- This is the container of the form  -->
        <div class="container p-3 mb-2 bg-normal-92 text-white w-25 rounded-3">
            <!-- This is the form that would need inputs that would be passed to the loginHandler.php -->
            <?php
                if($success == true) {
                    echo "
                        <div class='alert alert-success text-center' role='alert'>
                            <h2>Email Verification Successful.</h2>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='../index.php' role='button'>HOME</a>
                        </div>
                    ";
                } else {
                    echo "
                        <div class='alert alert-danger text-center' role='alert'>
                            <h2>Email Verification Failed.</h2>
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='../index.php' role='button'>HOME</a>
                        </div>
                    ";
                }
            ?>
        </div>
    </body>
</html>
