<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Get the Choice from the user
    for($i=0; $i < (1 + @max(array_keys($_SESSION["cartItemId"]))); $i++){
      unset($_SESSION['cartItemId'][$i]); //Clear All the Session for cartItemId
      unset($_SESSION['cartItemQuantity'][$i]); //Clear All the Session for cartItemQuantity
    }

	header("Location: cart.php");
 ?>
