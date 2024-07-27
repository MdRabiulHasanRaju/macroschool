<?php
if (!isset($connection)) {
  include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
}
if (!isset($baseurl)) {
  include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
  $baseurl = new Baseurl;
  define("LINK", "{$baseurl->url()}/macroschool/");
}
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Format.php";
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
  <link rel="stylesheet" href="<?= LINK; ?>style.css">
  <link rel="stylesheet" href="<?= LINK; ?>responsive.css">
  <link rel="website icon" type="png" href="<?= LINK; ?>public/images/logo.jpg">

</head>

<body>
  <nav class="header">
    <div class="container nav__container">
      <a href="<?= LINK; ?>"><img src="<?= LINK; ?>public/images/logo-removebg-preview.png" id="IMAGE"></a>

      <a class="my-btn black mobile-dashboard" href="<?= LINK; ?>login"><img src="<?php if (isset($_SESSION['google-image'])) {
                                                                                    echo $_SESSION['google-image'];
                                                                                  } else { ?><?= LINK; ?>public/images/icon/dashboard.png<?php } ?>">Dashboard</a>

      <ul class="nav__menu" class="slidebar">

        <li class="category-menu" <?php
            if (isset($header_active) && $header_active == "Category") {
              echo "class='myactive'";
            } ?>><a onclick="return false;" href=""><i class="fa-solid fa-list"></i>Category</a>

          <ul class="category-option">
            <?php
            $cat_sql = "select * from course_category";
            $cat_stmt = fetch_data($connection, $cat_sql);
            mysqli_stmt_bind_result($cat_stmt, $cat_id, $cat_name);
            while (mysqli_stmt_fetch($cat_stmt)) { ?>
              <a href="<?= LINK; ?>courses/category/<?= $cat_id; ?>">
                <li><i class="fa-solid fa-arrows-turn-right"></i> <?= $cat_name; ?></li>
              </a>
            <?php }
            ?>
          </ul>

        </li>

        <li <?php
            if (isset($header_active) && $header_active == "Home") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>"><i class="fa-solid fa-house"></i>Home</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "About") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>about"><i class="fa-solid fa-circle-info"></i>About</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "Courses") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>courses"><i class="fa-solid fa-book"></i>Courses</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "Contact") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>contact"><i class="fa-solid fa-phone"></i>Contact</a></li>

        <li class="my-btn black dashboard"><a class="dashboard-img-pc" style="color:white" href="<?= LINK; ?>login"><img src="<?php if (isset($_SESSION['google-image'])) {
                                                                                                                                echo $_SESSION['google-image'];
                                                                                                                              } else { ?><?= LINK; ?>public/images/icon/dashboard.png<?php } ?>">Dashboard</a></li>
      </ul>

      <button id='open-menu-btn'><i class="fa-solid fa-bars"></i></button>
      <button id='close-menu-btn'><i class="fa-solid fa-xmark"></i></button>
    </div>
  </nav>