<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/views/pages/auth/vendor/autoload.php";
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/views/pages/auth/config/config.php";
session_start();

setcookie('username', '', -1, '/'); 
setcookie('id', '', -1, '/'); 
setcookie('loggedin', '', -1, '/'); 
setcookie('name', '', -1, '/'); 
setcookie('mobile', '', -1, '/'); 
setcookie('image', '', -1, '/'); 
setcookie('google-image', '', -1, '/'); 

// $client->revokeToken();

session_destroy();
header("location: ".LINK."login");
