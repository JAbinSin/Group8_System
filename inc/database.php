<?php

    //Variables needed to connect to the database
    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "restaurantdb";

    //Connect to the database
    $con = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);


    //Start the session of the webpage
    session_start();

    //Set the name for the Website
    $_SESSION['siteName'] = "RestauDay ";
?>
