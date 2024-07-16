<?php
include $_SERVER['DOCUMENT_ROOT'] . "/serverit/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/serverit/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/serverit";
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['title']) && isset($_POST['address']) && isset($_POST['mobile'])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/serverit/lib/Database.php";

            $name = $title = $address = $phone = $image = "";
            $name_err = $title_err = $address_err = $phone_err = $image_err = "";

            if (empty(trim($_POST["name"]))) {
                $name_err = "Name cannot be blank";
                $_SESSION["name_err"] = $name_err;
                header("location: " . LINK . "edit-profile");
                die();
            }
            if (empty(trim($_POST["title"]))) {
                $title_err = "Title cannot be blank";
                $_SESSION["title_err"] = $title_err;
                header("location: " . LINK . "edit-profile");
                die();
            }
            if (empty(trim($_POST["address"]))) {
                $address_err = "Address cannot be blank";
                $_SESSION["address_err"] = $address_err;
                header("location: " . LINK . "edit-profile");
                die();
            }
            if (empty(trim($_POST["mobile"]))) {
                $phone_err = "Phone number cannot be blank";
                $_SESSION["phone_err"] = $phone_err;
                header("location: " . LINK . "edit-profile");
                die();
            }

            if (isset($_FILES['image'])) {
                $prev_image = $_SESSION['image'];
                $file = $_FILES['image'];
                $name_img = $file['name'];
                $temporary_file = $file['tmp_name'];
                $imgfile = $_FILES["image"]["name"];

                if (!file_exists($_FILES["image"]["tmp_name"])) {
                    $new_name = $_SESSION['image'];
                }
            }

            $sql = "select * from users_info where user_id = ?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $_SESSION['id'];
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_store_result($stmt)) {
                    if (mysqli_stmt_num_rows($stmt) == 1) {

                        $name = htmlspecialchars($_POST['name']);
                        $title = htmlspecialchars($_POST['title']);
                        $address = htmlspecialchars($_POST['address']);
                        $mobile = htmlspecialchars($_POST['mobile']);
                        $image = htmlspecialchars($_POST['image']);
                        $update_sql = "UPDATE users_info SET name=?,title=?,address=?,mobile=?,image=? WHERE user_id=?";
                        $update_stmt = mysqli_prepare($connection, $update_sql);
                        mysqli_stmt_bind_param($update_stmt, "sssssi", $param_name, $param_title, $param_address, $param_mobile, $param_image, $param_userid);
                        $param_userid = $_SESSION['id'];
                        $param_name = $name;
                        $param_title = $title;
                        $param_address = $address;
                        $param_mobile = $mobile;
                        $param_image = $new_name;
                        if (mysqli_stmt_execute($update_stmt)) {
                            $_SESSION["title"] = $title;
                            $_SESSION["image"] = $new_name;
                            $_SESSION["mobile"] = $mobile;
                            $_SESSION["name"] = $name;
                            $_SESSION["address"] = $address;
                            header("location: " . LINK . "profile");
                        }
                    } else {
                        header("location: " . LINK . "profile");
                    }
                }
            }
        } else {
            echo "Req data eror!";
        }
    } else {
        echo "Post method not working!";
    }
} else {
    header("location: " . LINK . "auth?p=1");
    die();
}