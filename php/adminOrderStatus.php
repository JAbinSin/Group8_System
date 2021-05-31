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
    $querySelectHistoryInfo = "SELECT user FROM tbl_history WHERE user = $userId";
    $executeQuerySelectHistoryInfo = mysqli_query($con, $querySelectHistoryInfo);

    $historyInfo = mysqli_fetch_assoc($executeQuerySelectHistoryInfo);

    $userDump = $historyInfo["user"];

    //Redirect the user if the id is invalid
    if(is_null($userDump)) {
        header("Location: adminListUsers.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Admin Order Status</title>

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
        <div class="container p-3 mb-2 bg-dark text-white rounded-3 w-50 opacity-1">
            <h1 class="text-center mb-2">Admin Order Status</h1>
            <?php
                //Query and Execute for the history information
                $querySelectHistory = "SELECT * FROM tbl_history WHERE user = $userId ORDER BY order_id DESC";
                $executeQuerySelectHistory = mysqli_query($con, $querySelectHistory);

                //Set a null to hold the Order Id and Change
                $historyOrderId = null;
                $isEmpty = true;
                $isFirst = true;
                $change = null;
                //Uses loop to echo all the items the user selected
                while($historyInfo = mysqli_fetch_assoc($executeQuerySelectHistory)) {
                    //To Check if there is Data from the tbl_history
                    $isEmpty = false;

                    //Uses this so that it would be Group by the Order Id
                    if($historyInfo["order_id"] != $historyOrderId) {//1 != null
                        $oldId = $historyOrderId;//null
                        $historyOrderId = $historyInfo["order_id"];//1

                        if($isFirst == false) {
                            echo "
                                <div class='card-footer text-muted text-center'>
                                    Time Purchase: $historyTime
                                </div>
                                </div>
                            ";
                        }

                        echo "
                            <div class='card history-color mb-5'>
                                <div class='card-header text-center'>
                                    Order Id: $historyOrderId
                                </div>
                        ";
                    }

                    $historyId = $historyInfo["id"];
                    $historyItem = $historyInfo["item"];
                    $historyPicture = $historyInfo["picture"];
                    $historyQuantity = $historyInfo["quantity"];
                    $historyName = $historyInfo["name"];
                    $historyPrice = $historyInfo["price"];
                    $historyTime = $historyInfo["time"];
                    $historyStatus = $historyInfo["status"];

                    echo "
                        <div class='card-body'>
                            <div class='card text-dark bg-transparent mx-auto' style='max-width: 50rem; border: 0;'>
                                <div class='row g-0 border border-secondary border-2' style='margin-bottom: 1rem;'>
                                    <div class='col-md-4 p-0 bg-transparent' style='max-height: 18rem; min-height: 18rem;'>
                                        <a href='item.php?id=$historyItem'>
                                            <img src='../img/items/$historyPicture' alt='Image Unavailable' style='width: 100%; height: 100%;'>
                                        </a>
                                    </div>
                                    <div class='col-md-8'>
                                        <div class='card-body text-break text-white pb-0'>
                                            <h2 class='card-title text-primary'>$historyName</h2>
                                            <hr>
                                            <div class='row'>
                                                <h5>Item Total Price: ₱$historyPrice</h5>
                                                <h5>Item Quantity: $historyQuantity</h5>
                                                <h5>Status Update: ".
                                                    ($historyStatus == 'pending' ? '<span class="badge bg-warning text-dark">Pending</span>' :
                                                        ($historyStatus == 'processing' ? '<span class="badge bg-info text-dark">Processing</span>' :
                                                            ($historyStatus == 'delivered' ? '<span class="badge bg-success text-dark">Delivered</span>' :
                                                                '<span class="badge bg-secondary text-dark">Canceled</span>')))
                                                ."</h5>
                                                <div class='border border-secondary'>
                                                    <h5 class='mt-2'>
                                                        <form action='adminOrderStatusHandler.php' method='post'>
                                                            Update Order Status:
                                                            <div class='row mt-1'>
                                                                <div class='col'>
                                                                    <select class='form-select form-select-sm bg-dark text-white mt-1' name='orderStatus' style='width: 11rem;'>
                                                                      <option ". ($historyStatus == 'pending' ? 'selected' : '') ." value='pending'>Pending</option>
                                                                      <option ". ($historyStatus == 'processing' ? 'selected' : '') ." value='processing'>Processing</option>
                                                                      <option ". ($historyStatus == 'delivered' ? 'selected' : '') ." value='delivered'>Delivered</option>
                                                                      <option ". ($historyStatus == 'canceled' ? 'selected' : '') ." value='canceled'>Canceled</option>
                                                                    </select>
                                                                </div>
                                                                <div class='col'>
                                                                    <input type='hidden' name='orderId' value='$historyId'>
                                                                    <input type='hidden' name='userId' value='$userId'>
                                                                    <button type='submit' class='btn btn-primary btn-sm' style='width: 10rem;'>Update Status</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                }

            ?>
            <div class='card-footer text-muted text-center'>
                Time Purchase: <?php echo $historyTime?>
            </div>
        </div>
    </body>
</html>
