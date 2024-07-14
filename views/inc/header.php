<?php
if (!isset($connection)) {
    include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
  }
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Format.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
$format = new Format;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://kit.fontawesome.com/8a0fad0de8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= LINK; ?>style.css">
    <link rel="stylesheet" href="<?= LINK; ?>responsive.css">
    <link rel="website icon" type="png" href="<?= LINK; ?>public/images/logo.jpg">

</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="<?=LINK;?>"><img src="<?= LINK; ?>public/images/logo-removebg-preview.png" id="IMAGE" ></a>
            <a class="my-btn black mobile-dashboard" href="<?= LINK; ?>login">Dashboard</a>
            <ul class="nav__menu" class="slidebar">
                <li><a href="<?=LINK;?>">Home</a></li>
                <li><a href="<?= LINK; ?>about">About</a></li>
                <li><a href="<?= LINK; ?>courses">Courses</a></li>
                <li><a href="<?= LINK; ?>contact">Contact</a></li>
                <li class="my-btn black dashboard" ><a style="color:white" href="<?= LINK; ?>login">Dashboard</a></li>
            </ul>
            
            <button id='open-menu-btn'><i class="fa-solid fa-bars"></i></button>
            <button id='close-menu-btn'><i class="fa-solid fa-xmark"></i></button>
        </div>
    </nav>