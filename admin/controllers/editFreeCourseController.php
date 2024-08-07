<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/macroschool";
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST['video_id']) &&
        isset($_POST['yt_link']) &&
        isset($_POST['submit'])
    ) {

        include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        $video_id = validate($_POST['video_id']);
        $yt_link = validate($_POST['yt_link']);


        $update_sql = "UPDATE `free_course` SET
            `yt_link`=?
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "si", 
            $param_yt_link,
            $param_id
        );

        $param_yt_link = $yt_link;
        $param_id = $video_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "free-course");
        }
    } else {
        echo "Req data eror!";
    }
} else {
    echo "Post method not working!";
}
} else {
	header("location: " . ADMIN_LINK . "login");
	die();
}
