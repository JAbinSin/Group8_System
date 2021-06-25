<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin can access this webpage
    if(($_SESSION['userType'] != "admin") || (empty($_GET["id"]))) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $userId = $_GET["id"];

    //Query and Execute for the user information
    $querySelectHistoryInfo = "SELECT username FROM tbl_users WHERE id = $userId";
    $executeQuerySelectHistoryInfo = mysqli_query($con, $querySelectHistoryInfo);

    $historyInfo = mysqli_fetch_assoc($executeQuerySelectHistoryInfo);

    $userUsername = $historyInfo["username"];

    //Redirect the user if the id is invalid
    if(is_null($userUsername)) {
        header("Location: adminListUsers.php");
    }

    //For the last Order Id
    $querySelectLast = "SELECT MIN(order_id) AS last FROM tbl_history WHERE user = $userId";
    $executeQuerySelectLast = mysqli_query($con, $querySelectLast);
    $Last = mysqli_fetch_assoc($executeQuerySelectLast);
    $lastId = $Last["last"];
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Admin Order Status</title>

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
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container  -->
        <div class="container p-3 mb-2 bg-normal-92 table-responsive text-white rounded-3 w-50">
            <div class="row g-0">
                <div class="col-sm-6 col-md-8 ps-3">
                    <h1><?php echo $userUsername?></h1>
                </div>
                <div class="col-6 col-md-4 text-end pe-3">
                    <h1><a href="adminListUsers.php" class="text-reset text-decoration-none"><i class="bi bi-arrow-counterclockwise"></i>Back</a></h1>
                </div>
            </div>
            <?php
                //Query and Execute for the history information
                $querySelectHistory = "SELECT * FROM tbl_history WHERE user = $userId ORDER BY order_id DESC";
                $executeQuerySelectHistory = mysqli_query($con, $querySelectHistory);

                //Set a null to hold the Order Id
                $historyOrderId = null;
                $isEmpty = true;
                $isFirst = true;
                //Uses loop to echo all the items the user selected
                while($historyInfo = mysqli_fetch_assoc($executeQuerySelectHistory)) {
                    //Variables
                    $historyItem = $historyInfo["item"];
                    $historyPicture = $historyInfo["picture"];
                    $historyQuantity = $historyInfo["quantity"];
                    $historyName = $historyInfo["name"];
                    $historyPrice = $historyInfo["price"];
                    $historyTime = $historyInfo["time"];
                    $historyStatus = $historyInfo["status"];
                    $historyPQ = $historyQuantity * $historyPrice;

                    //To Check if there is Data from the tbl_history
                    $isEmpty = false;

                    //Uses this so that it would be Group by the Order Id
                    if($historyInfo["order_id"] != $historyOrderId) {//1 != null
                        $oldId = $historyOrderId;//null
                        $historyOrderId = $historyInfo["order_id"];//1

                        //The first oldId would always be null so we need to ignore that
                        if($oldId != null) {
                            //For the Grand Total and Total Items
                            $querySelectTotal = "SELECT SUM(price * quantity) AS totalPrice, SUM(quantity) AS totalQuantity FROM tbl_history WHERE order_id = $oldId";
                            $executeQuerySelectTotal = mysqli_query($con, $querySelectTotal);
                            $historyTotal = mysqli_fetch_assoc($executeQuerySelectTotal);
                            $historyTotalPrice = $historyTotal["totalPrice"];
                            $historyTotalQuantity = $historyTotal["totalQuantity"];
                        }

                        if($isFirst == false) {
                            echo "
                                </tbody>
                                <tfoot class='text-center'>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class='text-end h5'>Grand Total:</td>
                                        <td class='h5'>₱ $historyTotalPrice</td>
                                    </tr>
                                </tfoot>
                                <tfoot class='text-center'>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class='text-end h5'>Total Items:</td>
                                        <td class='h5'>$historyTotalQuantity</td>
                                    </tr>
                                </tfoot>
                                </table>

                                <div class='card-footer text-center h5 m-0'>
                                    Time Purchase: $historyTime
                                </div>
                                </div>
                                <br>
                            ";
                        }

                        echo "
                            <div class='card history-color mb-5'>
                                <div class='card-header row'>
                                    <p class='text-start h3 ps-4 m-0 col'>Order Id: $historyOrderId</p>
                                    <p class='text-end h3 pe-4 m-0 col'>Order Status: ". ($historyStatus == 'pending' ? '<span class="badge bg-warning text-dark">Pending</span>' :
                                        ($historyStatus == 'processing' ? '<span class="badge bg-info text-dark">Processing</span>' :
                                            ($historyStatus == 'delivered' ? '<span class="badge bg-success text-dark">Delivered</span>' :
                                                '<span class="badge bg-secondary text-dark">Cancelled</span>')))
                                    ."</p>
                                </div>
                                <form action='adminOrderStatusHandler.php' method='post'>
                                    <div class='d-flex justify-content-center me-4 mt-3 mb-3'>
                                        <div class='order-1'>
                                            <h4 class='text-end'>Update Order Status:</h4>
                                        </div>
                                        <div class='order-2 me-2 ms-2'>
                                            <select class='form-select form-select-sm bg-dark text-white' name='orderStatus' style='width: 11rem;'>
                                              <option ". ($historyStatus == 'pending' ? 'selected' : '') ." value='pending'>Pending</option>
                                              <option ". ($historyStatus == 'processing' ? 'selected' : '') ." value='processing'>Processing</option>
                                              <option ". ($historyStatus == 'delivered' ? 'selected' : '') ." value='delivered'>Delivered</option>
                                              <option ". ($historyStatus == 'canceled' ? 'selected' : '') ." value='canceled'>Canceled</option>
                                            </select>
                                        </div>
                                        <div class='order-3'>
                                            <input type='hidden' name='orderId' value='$historyOrderId'>
                                            <input type='hidden' name='userId' value='$userId'>
                                            <button type='submit' class='btn btn-primary btn-sm' style='width: 10rem;'>Update Status</button>
                                        </div>
                                    </div>
                                </form>
                                <table class='table table-dark  border-white align-middle m-0'>
                                    <thead class='text-center'>
                                        <tr>
                                            <th class='col-1 border'>PICTURE</th>
                                            <th class='col-2 border'>NAME</th>
                                            <th class='col-1 border'>PRICE</th>
                                            <th class='col-1 border'>QUANTITY</th>
                                            <th class='col-1 border'>TOTAL</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                        ";
                    }

                    echo "
                        <tr class='text-center'>
                            <td class='border-start border-end'><a href='item.php?id=$historyItem'><img src='../img/items/$historyPicture' class='rounded mx-auto d-block img-fluid cart-img' alt='$historyName'></a></td>
                            <td class='h5 border-start border-end'><a href='item.php?id=$historyItem' class='text-reset text-decoration-none'>$historyName</a></td>
                            <td class='h5 border-start border-end'>₱ $historyPrice</td>
                            <td class='h5 border-start border-end'>$historyQuantity</td>
                            <td class='h5 border-start border-end'>₱ $historyPQ</td>
                        </tr>
                    ";
                    //Check if the fetch is the first data
                    if($isFirst == true) {
                        $isFirst = false;
                    }
                }
                //Show an Error for History is Empty
                if($isEmpty) {
                    echo "
                        <div class='alert alert-warning text-center h2' role='alert'>
                            History is Empty.
                        </div>";
                } else {
                  $querySelectTotal = "SELECT SUM(price * quantity) AS totalPrice, SUM(quantity) AS totalQuantity FROM tbl_history WHERE order_id = $lastId";
                  $executeQuerySelectTotal = mysqli_query($con, $querySelectTotal);
                  $historyTotal = mysqli_fetch_assoc($executeQuerySelectTotal);
                  $historyTotalPrice = $historyTotal["totalPrice"];
                  $historyTotalQuantity = $historyTotal["totalQuantity"];
                  echo "
                      </tbody>
                      <tfoot class='text-center'>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class='text-end h5'>Grand Total:</td>
                              <td class='h5'>₱ $historyTotalPrice</td>
                          </tr>
                      </tfoot>
                      <tfoot class='text-center'>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class='text-end h5'>Total Items:</td>
                              <td class='h5'>$historyTotalQuantity</td>
                          </tr>
                      </tfoot>
                      </table>
                      <div class='card-footer text-center h5 m-0'>
                          Time Purchase: $historyTime
                      </div>
                  ";
                }
            ?>
        </div>
    </body>
</html>
