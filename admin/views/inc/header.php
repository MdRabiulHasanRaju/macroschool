<?php
if (!isset($connection)) {
  include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";
}
if (!isset($baseurl)) {
  include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
  $baseurl = new Baseurl;
  define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
  define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");
}
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Format.php";
$format = new Format;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <script src="https://kit.fontawesome.com/8a0fad0de8.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?= ADMIN_LINK; ?>public/css/app.css">
  <link rel="stylesheet" href="<?= ADMIN_LINK; ?>style.css">
  <link rel="stylesheet" href="<?= ADMIN_LINK; ?>responsive.css">
  <link rel="website icon" type="png" href="<?= ADMIN_LINK; ?>public/images/logo.jpg">

</head>

<body>

  <div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
      <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?=ADMIN_LINK;?>">
          <span class="align-middle">Macro School Admin</span>
        </a>

        <ul class="sidebar-nav">
          <li class="sidebar-header">
            Manage Orders - Courses
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Home") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>">
              <i class="align-middle" data-feather="sliders"></i>
              <span class="align-middle">Order - Courses</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Paid Order") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>paid-order">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Paid Order</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Unpaid Order") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>unpaid-order">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Unpaid Order</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Coupon") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>coupon">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Coupon</span>
            </a>
          </li>

          <li class="sidebar-header">
            Manage Orders - Sheets
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "All Order Sheets") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>all-sheet-order">
              <i class="align-middle" data-feather="sliders"></i>
              <span class="align-middle">Order - Sheets</span>
            </a>
          </li>
          
            <?php
            $admin_id = $_SESSION['admin_id'];
            $account_sql = "select role from users_admin where id='$admin_id'";
            $account_stmt = fetch_data($connection,$account_sql);
            mysqli_stmt_bind_result($account_stmt,$role);
            mysqli_stmt_fetch($account_stmt);
            if($role=="admin"){
            ?>

          <li class="sidebar-header">
            Course Management
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "All Course") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>all-course">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">All Courses</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Add Course") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>add-course">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Add Course</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Archive Course") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>archive-course">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Archive Course</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Free Course") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>free-course">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Free Course</span>
            </a>
          </li>

          <li class="sidebar-header">
            Sheet Management
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "All Sheets") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>all-sheets">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">All Sheets</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Add Sheet") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>add-sheet">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Add Sheet</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Archive Sheets") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>archive-sheets">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Archive Sheets</span>
            </a>
          </li>

          <li class="sidebar-header">
            Manage Notice Board
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Notice") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>all-notice">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">All Notice</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Add Notice") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>add-notice">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Add Notice</span>
            </a>
          </li>

          <li class="sidebar-header">
            Manage Teachers
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "All Teachers") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>all-teachers">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">All Teachers</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Add Teacher") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>add-teacher">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Add Teacher</span>
            </a>
          </li>

          <li class="sidebar-header">
            Utility
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Live") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>live">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Go Live</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "popup") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>popup">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Pop Up Notification</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Banner") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>slider">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Banner</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Course Category") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>course-category">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Category</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Course Utility") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>course-utility">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Course Utility</span>
            </a>
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Contact") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>contact">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Contact</span>
            </a>
          </li>

          <li class="sidebar-header">
            Student's
          </li>

          <li class="sidebar-item <?php
                    if (isset($header_active) && $header_active == "Registered Users") {
                      echo 'myactive';
                    }?>">
            <a class="sidebar-link" href="<?=ADMIN_LINK;?>registered-users">
              <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Registered Users</span>
            </a>
          </li>
          <?php }?>

        </ul>

      </div>
    </nav>

    <div class="main">
      <nav id="adminTopBar" class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
          <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

              <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?=ADMIN_LINK;?>public/images/logo.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                <span class="text-dark">Macro School Admin</span>
              </a>

              <div class="dropdown-menu dropdown-menu-end">
                <!-- <a class="dropdown-item" href="">
                  <i class="align-middle me-1" data-feather="user"></i>
                  Profile
                </a> -->

                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" href="<?=ADMIN_LINK;?>/controllers/logoutController.php">
                  Log out
                </a>

              </div>
            </li>
          </ul>
        </div>
      </nav>
      <main class="content">