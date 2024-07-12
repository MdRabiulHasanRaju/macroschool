<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://kit.fontawesome.com/8a0fad0de8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="website icon" type="png" href="public/images/logo.jpg">

</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="<?=LINK;?>"><img src="public/images/logo-removebg-preview.png" id="IMAGE" ></a>
            <ul class="nav__menu" class="slidebar">
                <li><a href="<?=LINK;?>">Home</a></li>
                <li><a href="about">About</a></li>
                <li><a href="courses">Courses</a></li>
                <li><a href="contact">Contact</a></li>
            </ul>
            
            <button id='open-menu-btn'><i class="fa-solid fa-bars"></i></button>
            <button id='close-menu-btn'><i class="fa-solid fa-xmark"></i></button>
        </div>
    </nav>