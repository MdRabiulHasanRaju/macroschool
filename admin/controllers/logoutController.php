<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");

session_start();
unset($_SESSION["admin_loggedin"]);
unset($_SESSION["admin_username"]);
unset($_SESSION["admin_id"]);
// session_destroy();
header("location: ".ADMIN_LINK."login");
