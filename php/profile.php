<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin and client can access this webpage
    if(!isset($_SESSION['userType'])) {
        header("Location: ../index.php");
    }

    //Query and Execute for the user information
    $querySelectInfoUser = "SELECT * FROM tbl_users WHERE id =" . $_SESSION['userId'];
    $executeQuerySelectInfoUser = mysqli_query($con, $querySelectInfoUser);

    $userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUser);

    $userProfilePicture = $userInfo["profile_picture"];
    $userFirstName = $userInfo["first_name"];
    $userLastName = $userInfo["last_name"];
    $userEmail = $userInfo["email"];
    $userUsername = $userInfo["username"];
    $userAddress = $userInfo["address"];
    $userZipCode = $userInfo["zip_code"];
    $userPhoneNumber = $userInfo["phone_number"];
    $userValidated = $userInfo["validated"];
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Profile</title>

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

        <!-- Container for the profile information -->
        <div class="container p-3 mb-2 text-white w-75 overflow-auto">
            <div class="row justify-content-center text-break">
                <div class="col-4 text-center border-end-0 bg-normal-92">
                    <img src="<?php echo "../img/profile/$userProfilePicture"?>" class="img-fluid rounded-circle mx-auto d-block mt-4 profile-picture border border-5" alt="Picture Unavailable">
                    <p class="mt-3 mb-3 h5">@<?php echo $userUsername?></p>
                    <p class="m-0 display-6"><?php echo $userFirstName?></p>
                    <p class="display-6"><?php echo $userLastName?></p>
                </div>
                <div class="col-7 border-end-0 bg-dark">
                    <p class="h3">Personal Details:</p>
                    <div>
                        <dl class="row h5">
                            <dt class="col-sm-4 mt-3">Address: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userAddress?></dd>
                            <dt class="col-sm-4 mt-3">Zip Code: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userZipCode?></dd>
                            <dt class="col-sm-4 mt-3">Cellphone: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userPhoneNumber?></dd>
                            <dt class="col-sm-4 mt-3">Email: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userEmail?></dd>
                            <dt class="col-sm-4 mt-3">Email Status: </dt>
                            <dd class="col-sm-8 mt-3 text-light"><?php echo $userValidated == 'verified' ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-danger">Not Yet Verified</span>' ?></dd>
                        </dl>
                    </div>
                <div>
            </div>
        </div>
    </body>
</html>
