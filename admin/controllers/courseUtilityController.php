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
        isset($_POST['utility_id']) &&
        isset($_POST['hlp_name']) &&
        isset($_POST['hlp_contact']) &&
        isset($_POST['hlp_link']) &&
        isset($_POST['buy_course_link'])
    ) {

        include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        $utility_id = validate($_POST['utility_id']);
        $hlp_name = validate($_POST['hlp_name']);
        $hlp_contact = validate($_POST['hlp_contact']);
        $hlp_link = validate($_POST['hlp_link']);
        $buy_course_link = validate($_POST['buy_course_link']); 



        $update_sql = "UPDATE `course_utility` SET
            `hlp_Name`=?,
            `hlp_fb_link`=?,
            `hlp_contact`=?,
            `buy_course_link`=?
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "ssssi", 
            $param_hlp_Name,
            $param_hlp_fb_link ,
            $param_hlp_contact,
            $param_buy_course_link,
            $param_id
        );

        $param_hlp_Name = $hlp_name;
        $param_hlp_fb_link  = $hlp_link;
        $param_hlp_contact = $hlp_contact;
        $param_buy_course_link = $buy_course_link;
        $param_id = $utility_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "course-utility");
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
