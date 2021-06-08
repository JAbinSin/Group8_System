<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Only the admin can access this webpage
    if(!($_SESSION['userType'] == "admin")) {
        header("Location: ../index.php");
    }

    //Check if the current session allowed the user to acces this site and redirect if not
    if(empty($_GET["op"])) {
        header("Location: ../index.php");
    }

    //Get the id from the url
    $operation = $_GET["op"];


?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Edit Category</title>

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

        <!-- Container for the input form of the add item -->
        <div class="container p-3 mb-2 bg-normal-92 text-white rounded-3 w-25">
            <?php
                //This is the form for the edit operation
                if($operation == 'edit') {
                    echo "
                        <h1 class='text-center mb-2'>Edit Category</h1>
                        <form action='editCategory.php' method='post'>
                    ";
                } else {
                    //This is the form for the delete operation
                    echo "
                        <h1 class='text-center mb-2'>Delete Category</h1>
                        <form action='deleteCategory.php' method='post'>
                    ";
                }
            ?>
                <div class="mb-3">
                    <label for="category" class="form-label">Category Name</label>
                    <select class='form-select bg-dark text-white mt-1' name='category' required>
                        <option value="" disabled selected hidden>Please Choose...</option>
                        <?php
                            //Query and Execute for the category
                            $querySelectCategoryInfo = "SELECT id, name FROM tbl_category ORDER BY name";
                            $executeQuerySelectCategoryInfo = mysqli_query($con, $querySelectCategoryInfo);

                            while($categoryInfo = mysqli_fetch_assoc($executeQuerySelectCategoryInfo)) {
                                $categoryName = $categoryInfo["name"];
                                $categoryId = $categoryInfo["id"];

                                echo "
                                    <option value='$categoryId|$categoryName'>$categoryName</option>
                                ";
                            }
                          ?>
                      </select>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary mt-2">SELECT CATEGORY</button>
                </div>
            </form>
        </div>
    </body>
</html>
