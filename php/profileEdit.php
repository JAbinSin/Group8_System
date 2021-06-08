<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Only the client can access this webpage
    if(!($_SESSION["userType"] == "client")) {
        header("Location: ../index.php");
    }

    //Query and Execute for the user information
    $querySelectInfo = "SELECT * FROM tbl_users WHERE id =" . $_SESSION['userId'];
    $executeQuerySelectInfo = mysqli_query($con, $querySelectInfo);

    $userInfo = mysqli_fetch_assoc($executeQuerySelectInfo);

    $userProfilePicture = $userInfo["profile_picture"];
    $userFirstName = $userInfo["first_name"];
    $userLastName = $userInfo["last_name"];
    $userEmail = $userInfo["email"];
    $userUsername = $userInfo["username"];
    $userPhoneNumber = $userInfo["phone_number"];

    //Redirect the user if the id is invalid
    if(is_null($userFirstName)) {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Profile Edit</title>

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

        <!-- Container for the profile edit -->
        <div class="container p-3 mb-2 bg-normal-92 text-white w-25 rounded-3">
            <form action="profileEditHandler.php" method="post" enctype="multipart/form-data">
                <h1 class="text-center mb-2">Update Profile Info</h1>
                <div class="mb-3">
                    <label for="profilePicture" class="form-label">Profile Picture</label>
                    <input class="form-control text-light bg-dark" type="file" accept="image/*" name="profilePicture">
                </div>
                <div class="mb-3">
                    <label for="userFirstName" class="form-label">First Name</label>
                    <input type="text" class="form-control text-light bg-dark" name="userFirstName" placeholder="<?php echo "$userFirstName"?>" value="<?php echo "$userFirstName"?>" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userLastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control text-light bg-dark" name="userLastName" placeholder="<?php echo "$userLastName"?>" value="<?php echo "$userLastName"?>" pattern="[A-zÀ-ž\s]+" required>
                </div>
                <div class="mb-3">
                    <label for="userUsername" class="form-label">Username</label>
                    <input type="text" class="form-control text-light bg-dark" name="userUsername" placeholder="<?php echo "$userUsername"?>" value="<?php echo "$userUsername"?>" minlength="8" pattern="[a-zA-Z0-9]+" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email</label>
                    <input type="text" class="form-control text-light bg-dark" name="userEmail" placeholder="<?php echo "$userEmail"?>" value="<?php echo "$userEmail"?>" required>
                </div>
                <div class="mb-3">
                    <label for="userPhoneNumber" class="form-label">Cellphone Number (11-Digit)</label>
                    <input type="text" class="form-control text-light bg-dark" name="userPhoneNumber" placeholder="<?php echo "$userPhoneNumber"?>" value="<?php echo "$userPhoneNumber"?>" pattern="[0-9]{11}" maxlength="11" minlength="11" required>
                </div>
                <div class="col text-center">
                    <input class="btn btn-primary btn-success" type="submit" value="UPDATE">
                    <br>
                    <a class='btn btn-secondary mt-2' href='profile.php' role='button'>CANCEL</a>
                </div>
            </form>
        </div>
    </body>
</html>
