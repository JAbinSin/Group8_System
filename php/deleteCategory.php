<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Only the admin can access this webpage
    if(!($_SESSION['userType'] == "admin")) {
        header("Location: ../index.php");
    }

    //Check if the current session allowed the user to acces this site and redirect if not
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    $category = filter_input(INPUT_POST, 'category');
    $exploded_value = explode('|', $category);
    $categoryId = $exploded_value[0];
    $categoryName = $exploded_value[1];
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Delete Category</title>

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
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the confirmation of deletion -->
        <div class="container p-3 mb-2 bg-normal-92 text-white rounded-3 w-25">
            <h1 class="text-center mb-2">Delete Category</h1>
            <div class="alert alert-danger text-center overflow-auto h2" role="alert">
                <?php
                    echo "
                        Delete Category: <strong>" . $categoryName . "</strong>"
                    ;
                ?>
            </div>

            <div class="col text-center">
                <!-- Form used to pass the data to the deleteCategoryHandler.php -->
                <form action="deleteCategoryHandler.php" method="post">
                    <input class="btn btn-primary btn-danger rounded-pill" type="submit" value="DELETE">
                    <input type="hidden" name="categoryId" value="<?php echo $categoryId?>">
                </form>
                <a class='btn btn-primary mt-2' href='categorySelector.php?op=delete' role='button'>CANCEL</a>
            </div>
        </div>
    </body>
</html>
