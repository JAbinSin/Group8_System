<?php 
    //Include the database to the webpage to access it
    include_once("../inc/database.php");
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Home</title>

        <!-- The meta tags used in the webpage -->
        <!-- charset="utf-8" to use almost all the character and symbol in the world -->
        <!-- viewport to make the webpage more responsive -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Link the boostrap5 to the webpage -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <!-- Link the boostrap icon 1.4 to the webpage -->
        <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

        <!-- Link the local css to the webpage -->
        <link href="../bootstrap/local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary rounded-3">
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the whole list of items -->
        <div class="container p-3 mb-2 bg-dark text-dark rounded-3">
            <h1 class="text-center mb-2 text-white">Menu</h1>
            
            <!-- Spotlight would be implemented later
            <div id="carouselExampleCaptions" class="carousel slide mb-5 rounded-3" data-bs-ride="carousel" style="height:35rem;">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded-3" style="height: 35rem;">
                    <div class="carousel-item active">
                        <img src="../img/items/spotlight.png" class="d-block w-100 rounded-3" alt="Image Unavailable" style="height: 35rem;">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/items/spotlight2.png" class="d-block w-100 rounded-3" alt="Image Unavailable" style="height: 35rem;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            -->


            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php 
                    //Query and Execute for the user information
                    $querySelectItem = "SELECT * FROM tbl_items";
                    $executeQuerySelectItem = mysqli_query($con, $querySelectItem);

                    while($itemInfo = mysqli_fetch_assoc($executeQuerySelectItem)){
                        $itemId = $itemInfo["id"];
                        $itemName = $itemInfo["name"];
                        $itemPrice = $itemInfo["price"];
                        $itemPicture = $itemInfo["picture"];
                        
                        if(@$_SESSION['userType'] == "admin") {
                            echo"
                                <div class='col text-center mx-auto itemList-card-admin'>
                                    <div class='card h-100 border border-primary border-3'>
                                        <div class='card-footer'>
                                            <a href='itemEdit.php?id=$itemId' class='link-primary'>Edit</a> |
                                            <a href='itemDelete.php?id=$itemId' class='link-danger'> Delete</a>
                                        </div>
                                            <a href='item.php?id=$itemId'><img src='../img/items/$itemPicture' class='card-img-top m-2 rounded-3 itemList-card-image-admin' alt='Image Unavailable'></a>
                                        <div class='card-body text-break'>
                                            <h5 class='card-title module line-clamp p-1'><a href='item.php?id=$itemId' class='text-reset text-decoration-none'>$itemName</a></h5>
                                        </div>
                                        <div class='card-footer'>
                                            <strong>₱$itemPrice</strong>
                                        </div>
                                    </div>
                                </div>
                            ";
                        } else {
                            echo"
                                <div class='col text-center mx-auto itemList-card-client'>
                                    <div class='card h-100 border border-primary border-3'>
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
                    
                ?>
            </div>
        </div>
    </body>
</html>