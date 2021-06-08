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
            <h1 class="text-center mb-2">Edit Category</h1>
            <!-- This is the form that would need inputs that would be passed to the editCategoryHandler.php -->
            <form action="editCategoryHandler.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryPicture" class="form-label">Category Picture</label>
                    <input class="form-control text-light bg-dark" type="file" accept="image/*" name="categoryPicture">
                </div>
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name (Only Characters and Number Are Allowed)</label>
                    <input type="text" class="form-control text-light bg-dark" name="categoryName" placeholder="<?php echo "$categoryName";?>" pattern="[A-z0-9À-ž\s]+" value="<?php echo "$categoryName";?>" required>
                </div>
                <div class="col text-center">
                    <input type="hidden" name="categoryId" value="<?php echo "$categoryId";?>">
                    <button type="submit" class="btn btn-primary mt-2">EDIT CATEGORY</button>
                </div>
                <div class="col text-center">
                    <a class='btn btn-danger mt-2' href='categorySelector.php?op=edit' role='button'>CANCEL</a>
                </div>
            </form>
        </div>
    </body>
</html>
