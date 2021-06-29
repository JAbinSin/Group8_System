<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Include the email system
    include_once("../email/orderEmail.php");

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
    $userEmail = $_POST["userEmail"];
    $userValidated = $_POST["userValidated"];

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

    if($orderStatus == "pending") {
        $status = "Pending";
    } elseif($orderStatus == "processing") {
        $status = "Processing";
    } elseif($orderStatus == "delivered") {
        $status = "Delivered";
    } elseif($orderStatus == "canceled") {
        $status = "Canceled";
    }

    //Email Form 1
    $mail->Subject = "Restauday Order Status";
    $mail->Body = "<p>Order Status: $status</p>";
    $mail->Body .= "<p>Order Id: $orderId</p>";
    $mail->Body .= "<table><tr><th>Name</th><th>Quantity</th><th>Price</th></tr>";

    //Query for the information on the email form
    $querySelectHistory = "SELECT * FROM tbl_history WHERE order_id = $orderId";
    $executeQuerySelectHistory = mysqli_query($con, $querySelectHistory);

    while($historyInfo = mysqli_fetch_assoc($executeQuerySelectHistory)) {
        //Variables
        $historyQuantity = $historyInfo["quantity"];
        $historyName = $historyInfo["name"];
        $historyPrice = $historyInfo["price"];
        $historyPriceFormat = number_format($historyPrice, 2, '.', ',');
        $historyPQ = $historyQuantity * $historyPrice;
        @$historyTotalItem = $historyQuantity + $historyTotalItem;
        @$historyGrandTotal = $historyPQ + $historyGrandTotal;

        //Form data for table
        $mail->Body .= "<tr style='text-align: center'><td style='margin: 5px'>$historyName</td><td style='margin: 5px'>$historyQuantity</td><td style='margin: 5px'>₱ $historyPriceFormat</td></tr>";
    }
    $historyGrandTotalFormat = number_format($historyGrandTotal, 2, '.', ',');

    //Email Form3 Send
    $mail->Body .= "<tr><td style='margin: 5px'></td><td style='margin: 5px text-align:end'>Total Items:</td><td style='margin: 5px'>$historyTotalItem</td></tr>";
    $mail->Body .= "<tr><td style='margin: 5px'></td><td style='margin: 5px text-align:end'>Grand Total:</td><td style='margin: 5px'>₱ $historyGrandTotalFormat</td></tr>";
    $mail->Body .= "</table>";
    $mail->AddAddress("$userEmail");

    //Only send the email if the email is validated
    if($userValidated == "yes") {
        $mail->Send();
    }
?>
