<?php 
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Get the Choice from the user

    unset($_SESSION["cartItemId"]); //Clear All the Session for cartItemId
    unset($_SESSION["cartItemQuantity"]); //Clear All the Session for cartItemQuantity

	header("Location: cart.php");
 ?>