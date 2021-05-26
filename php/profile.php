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
    $userPhoneNumber = $userInfo["phone_number"];
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
        <script  type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <!-- Link the boostrap icon 1.4 to the webpage -->
        <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

        <!-- Link the local css to the webpage -->
        <link href="../bootstrap/local_css/stylesheet.css" rel="stylesheet">
    </head>

    <body class="d-grid gap-5 bg-secondary">
        <!-- Include the navigation bar to the webpage -->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the profile information -->
        <div class="container p-3 mb-2 bg-dark text-white text-center w-25 rounded-3 overflow-auto opacity-1">
            <!-- This is an edit button to change some information -->
            <?php
                //Only the clients can change their profile
                //The admin cannot change their profile
                //Change directly in the database for the admin
                if($_SESSION['userType'] == "admin") {
                    echo "
                    <div class='col text-center'>
                        <a class='btn btn-primary disabled' href='profileEdit.php' role='button'>EDIT</a>
                    </div>
                    ";
                } else {
                    echo "
                    <div class='col text-center'>
                        <a class='btn btn-primary' href='profileEdit.php' role='button'>EDIT</a>
                    </div>
                    ";
                }
            ?>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">Profile Picture:</h2>
                <img src="<?php echo "../img/profile/$userProfilePicture"?>" class="overflow-auto img-fluid rounded-circle mx-auto d-block mt-4 profile-picture" alt="Picture Unavailable">
            </div>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">First Name:</h2>
                <h3 class="mt-2"><?php echo "$userFirstName"?></h3>
            </div>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">Last Name:</h2>
                <h3 class="mt-2"><?php echo "$userLastName"?></h3>
            </div>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">Username:</h2>
                <h3 class="mt-2"><?php echo "$userUsername"?></h3>
            </div>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">Email:</h2>
                <h3 class="mt-2"><?php echo "$userEmail"?></h3>
            </div>
            <div class="text-break">
                <h2 class="mt-4 fw-bold text-info">Cellphone Number:</h2>
                <h3 class="mt-2"><?php echo "$userPhoneNumber"?></h3>
            </div>
        </div>
    </body>
</html>
