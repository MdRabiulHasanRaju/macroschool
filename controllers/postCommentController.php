<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $msg = validate($_POST["data"]);
    $userID = $_SESSION['id'];

    $sql = "select name, image from users_info where user_id='$userID'";
    $stmt = mysqli_query($connection,$sql);
    $user = mysqli_fetch_assoc($stmt);
    $name = $user['name'];
    $image = $user['image'];

    $commentSql = "INSERT INTO `comment` (`user_id`, `author_name`, `author_image`, `msg`) VALUES ('$userID', '$name', '$image', '$msg');";
    $result = mysqli_query($connection, $commentSql);
}else {
    header("location: ".LINK."login");
}
?>