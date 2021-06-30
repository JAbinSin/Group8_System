<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    if(isset($_POST["btnSubmit"])) {
        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = trim($_POST["password"]);
        $confirmPassword = trim($_POST["confirmPassword"]);

        if(empty($password) || empty($confirmPassword)) {
            header("Location: passwordReset.php?pass=empty");
            exit();
        } elseif($password != $confirmPassword) {
          header("Location: passwordReset.php?pass=notmatch");
          exit();
        } elseif($password == $confirmPassword && strlen($password) < 8) {
          header("Location: passwordReset.php?pass=less");
          exit();
        }

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
                            $queryUpdate = "UPDATE tbl_users SET password=? WHERE email=?";
                            if(!mysqli_stmt_prepare($stmt, $queryUpdate)) {
                                //Error handling
                                echo "Error";
                                exit();
                            } else {
                                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $tokenEmail);
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
                                    header("Location: ../php/login.php?newpass=success");
                                    $success = true;
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {
        header("Location: ../index.php");
    }
?>
