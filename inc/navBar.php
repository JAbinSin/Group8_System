<!-- This is the navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <?php 
    //Check for the quantity of the cart
    $cartQuantity = isset($_SESSION["cartItemId"]) ? count($_SESSION["cartItemId"]) : 0; 

    //Check the SESSION of what type of user is currently signed in
    if(isset($_SESSION['userType'])) {

      //This is the navbar for the ADMIN
      if($_SESSION['userType'] == "admin") {
        echo "
          <div class='container-fluid'>
            <a class='navbar-brand ms-4' href='itemList.php'>
              <img src='../img/logo/logo-test.jpg' alt='Restauday Logo' width='30' height='inherit' class='d-inline-block align-text-top'>
              RestauDay
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>
              <ul class='navbar-nav mb-2 mb-lg-0'>
                <li class='nav-item dropdown'>
                  <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Admin Control
                  </a>
                  <ul class='dropdown-menu dropdown-menu-dark' aria-labelledby='navbarDropdown'>
                    <li><a class='dropdown-item' href='adminListUsers.php'><i class='bi bi-person-lines-fill'></i></i> User List</a></li>
                    <li><a class='dropdown-item' href='addItem.php'><i class='bi bi-bag-plus'></i> Add Item</a></li>
                  </ul>
                </li>
                <li class='nav-item dropdown'>
                  <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Items
                  </a>
                  <ul class='dropdown-menu dropdown-menu-dark' aria-labelledby='navbarDropdown'>
                    <li><a class='dropdown-item' href='cart.php'><i class='bi bi-cart'></i> Cart <span class='badge bg-secondary'>$cartQuantity</span></a></li>
                    <li><a class='dropdown-item' href='history.php'><i class='bi bi-bookmarks'></i> History</a></li>
                  </ul>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='profile.php'><i class='bi bi-person-circle'></i> Profile</i></a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link me-2' href='logout.php'><i class='bi bi-box-arrow-in-right'></i> Logout</i></a>
                </li>
              </ul>
          </div>
        ";
      } else {
        //This is the navbar for the CLIENT
        echo "
          <div class='container-fluid'>
            <a class='navbar-brand ms-4' href='itemList.php'>
              <img src='../img/logo/logo-test.jpg' alt='Restauday Logo' width='30' height='inherit' class='d-inline-block align-text-top'>
              RestauDay
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>
              <ul class='navbar-nav  mb-2 mb-lg-0'>
                <li class='nav-item dropdown'>
                  <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                    Items
                  </a>
                  <ul class='dropdown-menu dropdown-menu-dark' aria-labelledby='navbarDropdown'>
                    <li><a class='dropdown-item' href='cart.php'><i class='bi bi-cart'></i> Cart <span class='badge bg-secondary'>$cartQuantity</span></a></li>
                    <li><a class='dropdown-item' href='history.php'><i class='bi bi-bookmarks'></i> History</a></li>
                  </ul>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='profile.php'><i class='bi bi-person-circle'></i> Profile</i></a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link me-2' href='logout.php'><i class='bi bi-box-arrow-in-right'></i> Logout</i></a>
                </li>
              </ul>
          </div>
        ";
      }
    } else {
      //This is the navbar for the guest or unsign user
      echo "
        <div class='container-fluid'>
        <a class='navbar-brand ms-4' href='itemList.php'>
          <img src='../img/logo/logo-test.jpg' alt='Restauday Logo' width='30' height='inherit' class='d-inline-block align-text-top'>
          RestauDay
        </a>
          <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
          </button>
          <div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>
            <ul class='navbar-nav  mb-2 mb-lg-0'>
              <li class='nav-item'>
                <a class='nav-link' href='login.php'><i class='bi bi-person-check'></i> Login</i></a>
              </li>
              <li class='nav-item'>
                <a class='nav-link me-2' href='register.php'><i class='bi bi-person-plus'></i> Register</i></a>
              </li>
            </ul>
        </div>
      ";
    }

  ?>
</nav>