<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin and client can access this webpage
    if(!isset($_SESSION['userType'])) {
        header("Location: ../index.php");
    }

    //Set the id from url or session
    $type = $_SESSION['userType'];
    @$id = $_GET["id"];
    if(empty($id)) {
        $id = $_SESSION['userId'];
    }

    //Query and Execute for the user information
    $querySelectInfoUser = "SELECT * FROM tbl_users WHERE id = $id";
    $executeQuerySelectInfoUser = mysqli_query($con, $querySelectInfoUser);

    $userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUser);

    $userId = $userInfo["id"];
    $userType = $userInfo["user_type"];
    $userProfilePicture = $userInfo["profile_picture"];
    $userFirstName = $userInfo["first_name"];
    $userLastName = $userInfo["last_name"];
    $userEmail = $userInfo["email"];
    $userUsername = $userInfo["username"];
    $userAddress = $userInfo["address"];
    $userCity = $userInfo["city"];
    $userRegion = $userInfo["region"];
    $userZipCode = $userInfo["zip_code"];
    $userPhoneNumber = $userInfo["phone_number"];
    $userValidated = $userInfo["validated"];

    //Only the admin can access each person profile
    //Each client can only view their own profile
    if(($type != "admin") && ($userId != $_SESSION['userId'])) {
        header("Location: ../index.php");
        exit();
    }

    //Redirect if user didn't exist
    if(empty($userId)) {
        header("Location: ../index.php");
        exit();
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | Profile</title>

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

        <?php
            if(isset($_GET["verify"])) {
                if($_GET["verify"] == "success") {
                    echo "
                        <div class='alert alert-center alert-success d-flex align-items-center w-25 alert-dismissible fade show' role='alert'>
                            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                            <div>
                                Email Verification Sent, Check your Email
                            </div>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    ";
                }
            }
        ?>

        <!-- Container for the profile information -->
        <div class="container p-3 mb-2 text-white w-75 overflow-auto">
            <div class="row justify-content-center text-break">
                <?php
                    if($_SESSION["userType"] == "admin") {
                        echo "
                            <div class='col-11 text-center border-end-0 bg-dark'>
                                <h1 class='text-end pe-3 pt-1'><a href='#' class='text-reset text-decoration-none' onclick='window.history.go(-1); return false;'><i class='bi bi-arrow-counterclockwise'></i>Back</a></h1>
                                <hr class='m-0'>
                            </div>
                        ";
                    }
                ?>
                <div class="col-4 text-center border-end-0 bg-normal-92">
                    <img src="<?php echo "../img/profile/$userProfilePicture"?>" class="img-fluid rounded-circle mx-auto d-block mt-4 profile-picture border border-5" alt="Picture Unavailable">
                    <p class="mt-3 mb-3 h5">@<?php echo $userUsername?></p>
                    <p class="m-0 display-6"><?php echo $userFirstName?></p>
                    <p class="display-6"><?php echo $userLastName?></p>
                    <?php
                        if($userType == "admin") {
                          echo "
                          <div class='col text-center'>
                              <a class='btn btn-secondary mb-3 rounded-pill shadow-lg disabled' href='profileEdit.php?id=<?php echo $userId ?>' role='button' style='width: 7rem; font-size: 1.1rem;'>Edit</a>
                          </div>
                          ";
                        } elseif($userId != $_SESSION['userId']) {
                          echo "
                          <div class='col text-center'>
                              <a class='btn btn-secondary mb-3 rounded-pill shadow-lg disabled' href='profileEdit.php?id=<?php echo $userId ?>' role='button' style='width: 7rem; font-size: 1.1rem;'>Edit</a>
                          </div>
                          ";
                        } else {
                          echo "
                              <div class='col text-center'>
                                  <a class='btn btn-secondary mb-3 rounded-pill shadow-lg' href='profileEdit.php?id=<?php echo $userId ?>' role='button' style='width: 7rem; font-size: 1.1rem;'>Edit</a>
                              </div>
                          ";
                        }
                    ?>
                </div>
                <div class="col-7 border-end-0 bg-dark">
                    <p class="h3 mt-2">Personal Details:</p>
                    <div>
                        <dl class="row h5">
                            <dt class="col-sm-4 mt-3">Address: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userAddress?></dd>
                            <dt class="col-sm-4 mt-3">City: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userCity?></dd>
                            <dt class="col-sm-4 mt-3">Region: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userRegion?></dd>
                            <dt class="col-sm-4 mt-3">Zip Code: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userZipCode?></dd>
                            <dt class="col-sm-4 mt-3">Cellphone: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userPhoneNumber?></dd>
                            <dt class="col-sm-4 mt-3">Email: </dt>
                            <dd class="col-sm-8 mt-3"><?php echo $userEmail?></dd>
                            <dt class="col-sm-4 mt-3">Email Status: </dt>
                            <dd class="col-sm-8 mt-3 text-light"><?php echo $userValidated == 'yes' ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-danger">Not Yet Verified</span>' ?></dd>
                            <?php
                                if($userValidated == "no" && !isset($_GET["id"])) {
                                    echo "
                                        <form action='../email/verifyEmail.php' method='post'>
                                            <dt class='col-sm-4 mt-3'></dt>
                                            <dd class='col-sm-8 mt-3'>
                                                <div class='col text-center'>
                                                    <button type='submit' name='verifyBtn' class='btn btn-success'>Verify Email</button>
                                                </div>
                                            <dd>
                                            <input type='hidden' name='email' value='$userEmail'>
                                        </form>
                                    ";
                                }
                            ?>
                        </dl>
                    </div>
                <div>
            </div>
        </div>
    </body>
</html>
