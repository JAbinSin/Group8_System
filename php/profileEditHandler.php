<?php 
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current session allowed the user to acces this site and redirect if not
    //Need input from the previous form
    if (empty($_POST)) {
        header("location: ../index.php");
        exit();
    }

    //Set the variable names for the values receive from the profile.php
    $userFirstName = trim($_POST["userFirstName"]);
    $userLastName = trim($_POST["userLastName"]);
    $userEmail = trim($_POST["userEmail"]);
    $userUsername = trim($_POST["userUsername"]);
    $userPhoneNumber = ($_POST['userPhoneNumber']);

    //Ths is the id from the session, used this style instead of directly using it because of string formatting in conditionals
    $id = $_SESSION["userId"];

    //An array for easier and faster checking if there is an error in the variable
    $arrayPost = array("First Name:" => $userFirstName, "Last Name:" => $userLastName, "Username:" => $userUsername, "Email:" => $userEmail);
    $logsErrorTest = false;
    $uploadedImage = false;
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Profile Edit</title>

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
        <!-- Include the navigation bar to the webpage-->
        <?php include_once("../inc/navBar.php"); ?>

        <!-- Container for the profile edit handler -->
        <div class="container p-3 mb-2 bg-dark text-white w-50 rounded-3">
            <!-- php for the verifications and execution to the database  -->
            <h1 class="text-center mb-2">Update Profile Info</h1>
            <?php 
                //This check if the user input a blank input because space count as an input for some reasons.
                foreach($arrayPost as $label => $value) {
                    if(empty($value)) {
                        echo 
                            "<div class='alert alert-danger text-center h2' role='alert'>" 
                                . $label . " Input Empty/Invalid." .
                            "</div>
                        ";
                        $logsErrorTest = true;
                    }
                }

                //Check if the Email, Username, and Phone Number already exist
                $querySelectInfo = "SELECT id, email, username, phone_number FROM tbl_users";
                $executeQuerySelectInfo = mysqli_query($con, $querySelectInfo);

                while($userInfo = mysqli_fetch_assoc($executeQuerySelectInfo)) {
                    if(($userUsername === $userInfo["username"]) && ($id != $userInfo["id"])) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Username: Already Exist.
                            </div>
                        ";
                    }
                    if(($userEmail === $userInfo["email"]) && ($id != $userInfo["id"])) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Email: Already Exist.
                            </div>
                        ";
                    }
                    if(($userPhoneNumber === $userInfo["phone_number"]) && ($id != $userInfo["id"])) {
                        $logsErrorTest = true;
                        echo "
                            <div class='alert alert-danger text-center h2' role='alert'>
                                Cellphone Number: Already Exist.
                            </div>
                        ";
                    }
                }

                //Check if the file type is an image format and if the user upload an image or not
                //Add an exception so it would not check an empty upload
                if((@exif_imagetype($_FILES["profilePicture"]['tmp_name']) == false) && (@!empty($_FILES["profilePicture"]['tmp_name']))) {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Profile Picture: File Uploaded is not an Image Format.
                        </div>
                    ";
                    $logsErrorTest = true;
                } else if(@empty(exif_imagetype($_FILES["profilePicture"]['tmp_name']))) {
                    $uploadedImage = false;
                } else {
                    $uploadedImage = true;
                }

                //This check and validate the inputs then execute the query if the inputs are valid
                if($logsErrorTest == false) {
                    //Select the profile image then delete the old profile
                    $queryProfile = "SELECT profile_picture FROM tbl_users WHERE id = '$id'";
                    $executeQueryProfile = mysqli_query($con, $queryProfile);
                    $infoProfilePicture = mysqli_fetch_assoc($executeQueryProfile);
                    $path = "../img/profile/" . $infoProfilePicture["profile_picture"];

                    //Delete the profile picture if they change from an image that is not a default
                    //Also stop the user from being able to delete the default profile
                    if(($infoProfilePicture["profile_picture"] != "default.png") && ($uploadedImage == true)) {
                        unlink($path);
                    }

                    //Moving and naming the img to img/profile folder
                    if($uploadedImage == true) {
                        $target_dir = "../img/profile/";
                        @$fileType = pathinfo($_FILES["profilePicture"]["name"])["extension"];
                        $fileName = $id . "_profile." . $fileType;
                        $target_file = $target_dir . $fileName;
                        move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file);
                    }
                    
                    //Query for the Update of the User
                    //This is the Query for the edit with image upload
                    if($uploadedImage == true) {
                        $queryUpdate = "UPDATE 
                                            tbl_users
                                        SET 
                                            first_name = '$userFirstName',
                                            last_name = '$userLastName',
                                            email = '$userEmail',
                                            username = '$userUsername',
                                            phone_number = '$userPhoneNumber',
                                            profile_picture = '$fileName'
                                        WHERE
                                            id = '$id'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center h2' role='alert'>
                                Database: Account Updated.
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-primary' href='profile.php' role='button'>Profile</a>
                            </div>
                        ";
                    } else {
                        //This is the Query for the edit without image upload
                        $queryUpdate = "UPDATE 
                                            tbl_users
                                        SET 
                                            first_name = '$userFirstName',
                                            last_name = '$userLastName',
                                            email = '$userEmail',
                                            phone_number = '$userPhoneNumber',
                                            username = '$userUsername'
                                        WHERE
                                            id = '$id'
                                        ";

                        $executeQuery = mysqli_query($con, $queryUpdate);

                        echo "
                            <div class='alert alert-success text-center h2' role='alert'>
                                Database: Account Updated.
                            </div>
                            <div class='col text-center'>
                                <a class='btn btn-primary' href='profile.php' role='button'>Profile</a>
                            </div>
                        ";
                    }
                } else {
                    echo "
                        <div class='alert alert-danger text-center h2' role='alert'>
                            Database: Account Updated Failed.
                        </div>
                        <div class='col text-center'>
                            <a class='btn btn-primary' href='profileEdit.php' role='button'>Return</a>
                        </div>
                    ";
                }
            ?>
        </div>
    </body>
</html>