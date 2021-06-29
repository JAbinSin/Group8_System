<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Inlclude the PHPMailer
    require_once("../PHPMailer/PHPMailerAutoLoad.php");

    //Email format
    $mail = new PHPMailer();
    $mail->isSMTP();
    //$mail->SMTPDebug  = 2;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML(true);
    $mail->Username = 'restauday@gmail.com';
    $mail->Password = 'restpassword123';
    $mail->SetFrom('no-reply@restauday.com');
    //$mail->Subject = "Restauday Order Status";
    //$mail->Body = "<p>Email</p>";
    //$mail->AddAddress("$userEmail");
    //$mail->Send();
?>
