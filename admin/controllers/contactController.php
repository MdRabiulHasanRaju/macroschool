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
        isset($_POST['contact_id']) &&
        isset($_POST['email']) &&
        isset($_POST['phone']) &&
        isset($_POST['fb_link']) &&
        isset($_POST['yt_link']) &&
        isset($_POST['address'])
    ) {

        include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        $contact_id = validate($_POST['contact_id']);
        $email = validate($_POST['email']);
        $phone = validate($_POST['phone']);
        $fb_link = validate($_POST['fb_link']);
        $yt_link = validate($_POST['yt_link']); 
        $address = validate($_POST['address']); 



        $update_sql = "UPDATE `contact` SET
            `email`=?,
            `phone`=?,
            `fb_link`=?,
            `yt_link`=?,
            `address`=?
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "sssssi", 
            $param_email,
            $param_phone ,
            $param_fb_link,
            $param_yt_link,
            $param_address,
            $param_id
        );

        $param_email = $email;
        $param_phone  = $phone;
        $param_fb_link = $fb_link;
        $param_yt_link = $yt_link;
        $param_address = $address;
        $param_id = $contact_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "contact");
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
