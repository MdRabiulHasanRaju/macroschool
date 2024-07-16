<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	if (isset($_SESSION['mobile'])) {
		header("location: " . LINK . "dashboard");
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['mobile'])) {

			include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

			$name = $phone = "";
			$name_err = $phone_err = "";

			if (empty(trim($_POST["name"]))) {
				$name_err = "Name cannot be blank";
				$_SESSION["name_err"] = $name_err;
				header("location: " . LINK . "create-profile");
				die();
			}
			if (empty(trim($_POST["mobile"]))) {
				$phone_err = "Name cannot be blank";
				$_SESSION["phone_err"] = $phone_err;
				header("location: " . LINK . "create-profile");
				die();
			}

			$name = htmlspecialchars($_POST['name']);
			$mobile = htmlspecialchars($_POST['mobile']);
			$image = "profile.png";
			if (isset($_SESSION['google-image'])) {
				$image = $_SESSION['google-image'];
			}

			$insert_sql = "INSERT INTO `users_info` (`user_id`, `name`, `mobile`, `image`) VALUES (?,?,?,?)";
			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param($insert_stmt, "isss", $param_userid, $param_name, $param_mobile, $param_image);
			$param_userid = $_SESSION['id'];
			$param_name = $name;
			$param_mobile = $mobile;
			$param_image = $image;

			if (mysqli_stmt_execute($insert_stmt)) {
				$_SESSION["mobile"] = $mobile;
				$_SESSION["name"] = $name;
				$_SESSION["image"] = $image;
				header("location: " . LINK . "dashboard");
			}
		} else {
			echo "Req data eror!";
		}
	} else {
		echo "Post method not working!";
	}
} else {
	header("location: " . LINK . "login");
	die();
}
