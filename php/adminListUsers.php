<?php
    //Include the database to the webpage to access it
    include_once("../inc/database.php");

    //Check if the current user is allowed to access the webpage
    //Only the admin can access this webpage
    if($_SESSION['userType'] != "admin") {
        header("Location: ../index.php");
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Title of the site  is set in SESSION from the database.php -->
        <title><?php echo $_SESSION['siteName']?> | User List</title>

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

        <!-- Container for the table of the user list -->
        <div class="container p-3 mb-2 bg-dark text-white table-responsive rounded-3 opacity-1">
            <h1 class="text-center mb-2">User List</h1>
            <table class="table table-dark table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>Profile Picture</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Cellphone Number</th>
                        <th>User Type</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                        //Query for users in the tbl_users
                        $querySelectInfoUser = "
                                            SELECT *
                                            FROM tbl_users
                                            ORDER BY
                                                CASE user_type
                                                    WHEN 'admin'THEN 1
                                                    WHEN 'client' THEN 2
                                                    ELSE 5
                                                END
                                            ";
                        $executeQuerySelectInfoUser = mysqli_query($con, $querySelectInfoUser);

                        //This is a loop for table body list
                        while($userInfo = mysqli_fetch_assoc($executeQuerySelectInfoUser)){
                            echo "
                            <tr>
                                <td>
                                    <img src='../img/profile/{$userInfo['profile_picture']}' alt='Profile Unavailable' class='rounded-3' style='width: 5rem; height: 5rem;'>
                                </td>
                                <td>
                                    {$userInfo['first_name']}
                                </td>
                                <td>
                                    {$userInfo['last_name']}
                                </td>
                                <td>
                                    {$userInfo['username']}
                                </td>
                                <td>
                                    {$userInfo['email']}
                                </td>
                                <td>
                                    {$userInfo['phone_number']}
                                </td>
                                <td>
                                    {$userInfo['user_type']}
                                </td>";

                                //The admin cannot delete a fellow admin user
                                if(!($userInfo['user_type'] === 'admin')) {
                                    echo"
                                    <td>
                                        <a class='btn btn-danger' href='adminDeleteUser.php?id={$userInfo['id']}' role='button'>Delete</a>
                                    </td>
                                </tr>";
                                } else {
                                    echo"
                                    <td>
                                        <a class='btn btn-secondary disabled' href='#' role='button'>Delete</a>
                                    </td>
                                </tr>";
                                }
                            ;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
