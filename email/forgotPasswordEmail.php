<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Inlclude the PHPMailer
    require_once("../PHPMailer/PHPMailerAutoLoad.php");

    //Only when it goes from the form then the user can access this webpage
    if(!empty($_POST)) {
        $userEmail = trim($_POST["email"]);

        $querySelect = "SELECT COUNT(email) AS emailDB FROM tbl_users WHERE email = '$userEmail'";
        $executeQuerySelect = mysqli_query($con, $querySelect);

        $emailInfo = mysqli_fetch_assoc($executeQuerySelect);

        $emailDB = $emailInfo["emailDB"];

        if($emailDB > 0) {
            //Make token
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);

            //There are 2 version for the online and offline
            //Currently using offline or localhose version
            //Change the localhost to another url if you have an online website
            $url = "localhost/github/Group8_System/email/passwordReset.php?selector=" . $selector . "&validator=" . bin2hex($token);

            //The token would expires in 1hr
            $expires = date("U") + 1800;

            $queryDelete = "DELETE FROM tbl_email WHERE email=?";
            $stmt = mysqli_stmt_init($con);
            if(!mysqli_stmt_prepare($stmt, $queryDelete)) {
                //Error handling
                echo "Error";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $userEmail);
                mysqli_stmt_execute($stmt);
            }

            //Insert into the database
            $queryInsert = "INSERT INTO tbl_email (email, selector, token, expires) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($con);
            if(!mysqli_stmt_prepare($stmt, $queryInsert)) {
                //Error handling
                echo "Error";
                exit();
            } else {
                $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
                mysqli_stmt_execute($stmt);
            }

            //Close all the connection to save resources
            mysqli_stmt_close($stmt);
            mysqli_close($con);

            //Email format
            $mail = new PHPMailer();
            $mail->isSMTP();
            //$mail->SMTPDebug  = 2;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '465';
            $mail->isHTML();
            $mail->Username = 'restauday@gmail.com';
            $mail->Password = 'restpassword123';
            $mail->SetFrom('no-reply@restauday.com');
            $mail->Subject = "Restauday Password Reset Request";
            $mail->Body = "<p>We recieved an password reset request. The link to reset your email is below if you did not make this request, you can ignore this email</p>";
            $mail->Body .= "<p>Here is your password reset link: </br>";
            $mail->Body .= "<a href='$url'>$url</a></p>";
            $mail->AddAddress("$userEmail");
            $mail->Send();

            header("Location: ../php/forgotPassword.php?verify=success");
            exit();
        } else {
            header("Location: ../php/forgotPassword.php?verify=failed");
            exit();
        }
    } else {
        header("Location: ../php/index.php");
        exit();
    }
?>
