<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/views/pages/auth/vendor/autoload.php";
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/views/pages/auth/config/config.php";
session_start();

// $client->revokeToken();

session_destroy();
header("location: ".LINK."login");
