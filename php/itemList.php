<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    if(empty($_GET["category"])) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $categoryName = $_GET["category"];

    //Error handling
    $itemEmpty = true;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Items</title>

        <!-- Add a logo for the title head -->
        <link rel="icon" href="../img/logo/logo-test.ico" type="image/ico">

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

    <body class="d-grid gap-5 bg-secondary rounded-3">
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the whole list of items -->
        <div class="container p-3 mb-2 bg-normal-92 text-white rounded-3">
            <div class="row g-0">
                <div class="col-sm-6 col-md-8 ps-3">
                    <h1><?php echo $categoryName?></h1>
                </div>
                <div class="col-6 col-md-4 text-end pe-3">
                    <h1><a href="categoryList.php" class="text-reset text-decoration-none"><i class="bi bi-arrow-counterclockwise"></i>Back</a></h1>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-4 g-4 row justify-content-md-center">
                <?php
                    //Query and Execute for the item information
                    if($categoryName == "All") {
                        $querySelectItem = "SELECT * FROM tbl_items ORDER BY name";
                    } else {
                        $querySelectItem = "SELECT * FROM tbl_items WHERE category = '$categoryName' ORDER BY name";
                    }
                    $executeQuerySelectItem = mysqli_query($con, $querySelectItem);

                    while($itemInfo = mysqli_fetch_assoc($executeQuerySelectItem)){
                        $itemEmpty = false;
                        $itemId = $itemInfo["id"];
                        $itemName = $itemInfo["name"];
                        $itemPrice = $itemInfo["price"];
                        $itemPicture = $itemInfo["picture"];

                        //Make variable to Number Format
                        $itemPrice = number_format($itemPrice, 2, '.', ',');

                        if(@$_SESSION['userType'] == "admin") {
                            echo"
                                <div class='col text-center itemList-card-admin'>
                                    <div class='card h-100 border border-secondary border-3 card-color'>
                                            <a href='item.php?id=$itemId'><img src='../img/items/$itemPicture' class='card-img-top m-2 rounded-3 itemList-card-image-admin' alt='Image Unavailable'></a>
                                        <div class='card-body text-break'>
                                            <h5 class='card-title module line-clamp p-1'><a href='item.php?id=$itemId' class='text-reset text-decoration-none'>$itemName</a></h5>
                                        </div>
                                        <div class='card-footer'>
                                            <strong>₱$itemPrice</strong>
                                        </div>
                                        <div class='card-footer'>
                                            <a href='itemEdit.php?id=$itemId' class='link-primary'>Edit</a> |
                                            <a href='itemDelete.php?id=$itemId' class='link-danger'> Delete</a>
                                        </div>
                                    </div>
                                </div>
                            ";
                        } else {
                            echo"
                                <div class='col text-center itemList-card-client'>
                                    <div class='card h-100 border border-secondary border-3 card-color'>
                                            <a href='item.php?id=$itemId'><img src='../img/items/$itemPicture' class='card-img-top m-2 rounded-3 itemList-card-image-client' alt='Image Unavailable'></a>
                                        <div class='card-body text-break'>
                                            <h5 class='card-title module line-clamp p-1'><a href='item.php?id=$itemId' class='text-reset text-decoration-none'>$itemName</a></h5>
                                        </div>
                                        <div class='card-footer'>
                                            <strong>₱$itemPrice</strong>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    if($itemEmpty) {
                        echo "
                          <div class='alert alert-warning text-center w-100' role='alert'>
                              <h2>No Available Item Yet.</h2>
                          </div>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
