<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {

    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $msg = validate($_POST["data"]);
    $userID = validate($_POST["userId"]);
    $name = validate($_POST["authorName"]);
    $image = validate($_POST["authorImage"]);

    $commentSql = "INSERT INTO `comment` (`user_id`, `author_name`, `author_image`, `msg`) VALUES ('$userID', '$name', '$image', '$msg');";
    $result = mysqli_query($connection, $commentSql);
}else {
    header("location: ".ADMIN_LINK."login");
}
?>