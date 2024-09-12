<?php
//header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60)));
//header("Cache-Control: no-cache");
//header("Pragma: no-cache");
header_remove('x-powered-by');
if(isset($_COOKIE["mobile"])){
  $_SESSION["username"] = $_COOKIE["username"];
  $_SESSION["id"] = $_COOKIE["id"];
  $_SESSION["loggedin"] = true;
  $_SESSION['name'] = $_COOKIE["name"];
  $_SESSION['mobile'] = $_COOKIE["mobile"];
  if(isset($_COOKIE["google-image"])){
      $_SESSION['google-image'] = $_COOKIE["google-image"];
  }
  $_SESSION['image'] = $_COOKIE["image"];
}

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
  <meta name="creator" content="@Md Rabiul Hasan">
  <meta name="description" content="<?php if (!$meta_description) {
                                      header("location:" . LINK . "error/404?metaDataError");
                                    } else {
                                      echo $meta_description;
                                    }; ?>">
  <meta name="keywords" content="<?= $meta_keywords; ?>">
  <meta name="title" content="<?=$title;?>">

  <meta property="og:title" content="MACRO School"/>
  <meta property="og:image" content="<?=LINK;?>public/images/ogImage.png"/>
  <meta data-n-head="ssr" data-hid="og:image:type" property="og:image:type" content="image/png">
  <meta property="og:image:alt" content="Official Logo of MACRO School" />
  <meta property="og:type" content="article"/>
  <meta property="og:description" content="Macroschool is an online store for a prominent online platform. Bangladeshi students are studying and upgrading their abilities using this online education platform."/>
  <meta property="og:url" content="https://macroschoolbd.com"/>
  <meta property="fb:app_id" content="879316245899337"/>

  <title><?= $title; ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <script src="https://kit.fontawesome.com/8a0fad0de8.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="views/inc/slider/swiper.css">
  <script src="views/inc/slider/swiper.js"></script>
  <link rel="stylesheet" href="<?= LINK; ?>style.css">
  <link rel="stylesheet" href="<?= LINK; ?>responsive.css">
  
  <link rel="apple-touch-icon" sizes="180x180" href="<?=LINK;?>public/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?=LINK;?>public/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?=LINK;?>public/images/favicon-16x16.png">
  <link rel="manifest" href="<?=LINK;?>public/images/site.webmanifest">
  <link rel="mask-icon" href="<?=LINK;?>public/images/safari-pinned-tab.svg" color="#5bbad5">

  <style>
/*===== Preloader Style =====*/

.preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #fff;
  z-index: 9999;
}
.preloader .color-1 {
  background-color: #dc555b!important;
}
.rubix-cube {
  border: 1px solid #fff;
  width: 48px;
  height: 48px;
  background-color: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
.rubix-cube .layer {
  width: 14px;
  height: 14px;
  background-color: #07294d;
  border: 1px solid #fff;
  position: absolute;
}
.rubix-cube .layer-1 {
  left: 0px;
  top: 0px;
  -webkit-animation: rubixcube4 2s infinite linear;
  animation: rubixcube4 2s infinite linear;
}
.rubix-cube .layer-2 {
  left: 16px;
  top: 0px;
  -webkit-animation: rubixcube3 2s infinite linear;
  animation: rubixcube3 2s infinite linear;
}
.rubix-cube .layer-3 {
  left: 32px;
  top: 0px;
}
.rubix-cube .layer-4 {
  left: 0px;
  top: 16px;
  -webkit-animation: rubixcube5 2s infinite linear;
  animation: rubixcube5 2s infinite linear;
}
.rubix-cube .layer-5 {
  left: 16px;
  top: 16px;
  -webkit-animation: rubixcube2 2s infinite linear;
  animation: rubixcube2 2s infinite linear;
}
.rubix-cube .layer-6 {
  left: 32px;
  top: 16px;
  -webkit-animation: rubixcube1 2s infinite linear;
  animation: rubixcube1 2s infinite linear;
}
.rubix-cube .layer-7 {
  left: 0px;
  top: 32px;
  -webkit-animation: rubixcube6 2s infinite linear;
  animation: rubixcube6 2s infinite linear;
}
.rubix-cube .layer-8 {
  left: 16px;
  top: 32px;
  -webkit-animation: rubixcube7 2s infinite linear;
  animation: rubixcube7 2s infinite linear;
}
@-webkit-keyframes rubixcube1 {
  20% {
    top: 16px;
    left: 32px;
  }
  30% {
    top: 32px;
    left: 32px;
  }
  40% {
    top: 32px;
    left: 32px;
  }
  50% {
    top: 32px;
    left: 32px;
  }
  60% {
    top: 32px;
    left: 32px;
  }
  70% {
    top: 32px;
    left: 32px;
  }
  80% {
    top: 32px;
    left: 32px;
  }
  90% {
    top: 32px;
    left: 32px;
  }
  100% {
    top: 32px;
    left: 16px;
  }
}
@keyframes rubixcube1 {
  20% {
    top: 16px;
    left: 32px;
  }
  30% {
    top: 32px;
    left: 32px;
  }
  40% {
    top: 32px;
    left: 32px;
  }
  50% {
    top: 32px;
    left: 32px;
  }
  60% {
    top: 32px;
    left: 32px;
  }
  70% {
    top: 32px;
    left: 32px;
  }
  80% {
    top: 32px;
    left: 32px;
  }
  90% {
    top: 32px;
    left: 32px;
  }
  100% {
    top: 32px;
    left: 16px;
  }
}
@-webkit-keyframes rubixcube2 {
  30% {
    left: 16px;
  }
  40% {
    left: 32px;
  }
  50% {
    left: 32px;
  }
  60% {
    left: 32px;
  }
  70% {
    left: 32px;
  }
  80% {
    left: 32px;
  }
  90% {
    left: 32px;
  }
  100% {
    left: 32px;
  }
}
@keyframes rubixcube2 {
  30% {
    left: 16px;
  }
  40% {
    left: 32px;
  }
  50% {
    left: 32px;
  }
  60% {
    left: 32px;
  }
  70% {
    left: 32px;
  }
  80% {
    left: 32px;
  }
  90% {
    left: 32px;
  }
  100% {
    left: 32px;
  }
}

@-webkit-keyframes rubixcube3 {
  30% {
    top: 0px;
  }
  40% {
    top: 0px;
  }
  50% {
    top: 16px;
  }
  60% {
    top: 16px;
  }
  70% {
    top: 16px;
  }
  80% {
    top: 16px;
  }
  90% {
    top: 16px;
  }
  100% {
    top: 16px;
  }
}

@keyframes rubixcube3 {
  30% {
    top: 0px;
  }
  40% {
    top: 0px;
  }
  50% {
    top: 16px;
  }
  60% {
    top: 16px;
  }
  70% {
    top: 16px;
  }
  80% {
    top: 16px;
  }
  90% {
    top: 16px;
  }
  100% {
    top: 16px;
  }
}
@-webkit-keyframes rubixcube4 {
  50% {
    left: 0px;
  }
  60% {
    left: 16px;
  }
  70% {
    left: 16px;
  }
  80% {
    left: 16px;
  }
  90% {
    left: 16px;
  }
  100% {
    left: 16px;
  }
}
@keyframes rubixcube4 {
  50% {
    left: 0px;
  }
  60% {
    left: 16px;
  }
  70% {
    left: 16px;
  }
  80% {
    left: 16px;
  }
  90% {
    left: 16px;
  }
  100% {
    left: 16px;
  }
}
@-webkit-keyframes rubixcube5 {
  60% {
    top: 16px;
  }
  70% {
    top: 0px;
  }
  80% {
    top: 0px;
  }
  90% {
    top: 0px;
  }
  100% {
    top: 0px;
  }
}
@keyframes rubixcube5 {
  60% {
    top: 16px;
  }
  70% {
    top: 0px;
  }
  80% {
    top: 0px;
  }
  90% {
    top: 0px;
  }
  100% {
    top: 0px;
  }
}
@-webkit-keyframes rubixcube6 {
  70% {
    top: 32px;
  }
  80% {
    top: 16px;
  }
  90% {
    top: 16px;
  }
  100% {
    top: 16px;
  }
}
@keyframes rubixcube6 {
  70% {
    top: 32px;
  }
  80% {
    top: 16px;
  }
  90% {
    top: 16px;
  }
  100% {
    top: 16px;
  }
}
@-webkit-keyframes rubixcube7 {
  80% {
    left: 16px;
  }
  90% {
    left: 0px;
  }
  100% {
    left: 0px;
  }
}
@keyframes rubixcube7 {
  80% {
    left: 16px;
  }
  90% {
    left: 0px;
  }
  100% {
    left: 0px;
  }
}

  </style>
</head>

<body>
<div id="preloader" class="preloader">
  <div class="loader rubix-cube">
    <div class="layer layer-1"></div>
    <div class="layer layer-2"></div>
    <div class="layer layer-3 color-1"></div>
    <div class="layer layer-4"></div>
    <div class="layer layer-5"></div>
    <div class="layer layer-6"></div>
    <div class="layer layer-7"></div>
    <div class="layer layer-8"></div>
  </div>
</div>

  <?php include "popup-notice.php";?>
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
            } ?>><a onclick="return false;" href=""><i class="fa-solid fa-list"></i>Category <i class="fa-solid fa-caret-down"></i></a>

          <ul class="category-option">
            <?php
            $cat_sql = "select * from course_category";
            $cat_stmt = fetch_data($connection, $cat_sql);
            mysqli_stmt_bind_result($cat_stmt, $cat_id, $cat_name);
            while (mysqli_stmt_fetch($cat_stmt)) { ?>
              <a href="<?= LINK; ?>courses/<?= $cat_id; ?>/<?= $cat_name; ?>">
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
            if (isset($header_active) && $header_active == "Courses") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>courses"><i class="fa-solid fa-book"></i>Courses</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "Sheets") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>sheets"><i class="fa-solid fa-sheet-plastic"></i>Sheets</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "Notice") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>notice"><i class="fa-solid fa-bullhorn"></i>Notice</a></li>

        <li <?php
            if (isset($header_active) && $header_active == "About") {
              echo "class='myactive'";
            } ?>><a href="<?= LINK; ?>about"><i class="fa-solid fa-circle-info"></i>About</a></li>

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