<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Get the input from the POST
    $orderStatus = $_POST["orderStatus"];
    $orderId = $_POST["orderId"];
    $userId = $_POST["userId"];

    //Update the order status of the selected item
    $queryUpdate = "UPDATE
                        tbl_history
                    SET
                        status = '$orderStatus'
                    WHERE
                        order_id = '$orderId'
                    ";

    $executeQuery = mysqli_query($con, $queryUpdate);

    if(executeQuery) {
        header("Location: adminOrderStatus.php?id=$userId");
    } else {
        echo "<h1>Unexpected Error Please go Back.<h1>";
    }
?>
