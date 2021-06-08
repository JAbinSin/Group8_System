<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Category</title>

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

    <body class="d-grid gap-5 bg-secondary rounded-3 ">
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the whole list of items -->
        <div class="container p-3 mb-2 bg-normal-92 text-white rounded-3">
            <h1 class="text-center mb-2 text-white">Menu</h1>
            <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
                <?php
                    //Query and Execute for the user information
                    $querySelectCategory = "SELECT * FROM tbl_category";
                    $executeQuerySelectCategory = mysqli_query($con, $querySelectCategory);

                    while($categoryInfo = mysqli_fetch_assoc($executeQuerySelectCategory)){
                        $categoryName = $categoryInfo["name"];
                        $categoryPicture = $categoryInfo["category_picture"];

                        echo "
                        <div class='card mb-3 ms-2 border border-secondary border-3 card-color category-card p-0'>
                            <div class='row g-0'>
                                <div class='col-md-5 d-flex align-items-center'>
                                  <a href='itemList.php?category=$categoryName'><img class='img-fluid category-card-img border-end border-3 border-secondary' src='../img/category/$categoryPicture' alt='Image Unavailable'></a>
                                </div>
                                <div class='col-md-7 d-flex align-items-center'>
                                  <div class='card-body text-wrap text-break'>
                                    <h1 class='card-title line-clamp-category p-1'><a href='itemList.php?category=$categoryName' class='text-reset text-decoration-none'>$categoryName</a></h1>
                                  </div>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </body>
</html>
