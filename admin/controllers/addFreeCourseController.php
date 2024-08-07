<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
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

			$yt_link = validate($_POST['yt_link']);

			$insert_sql = "INSERT INTO `free_course`(`yt_link`) VALUES (?)";

			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param(
				$insert_stmt,
				"s",
				$param_yt_link,
			);
			$param_yt_link = $yt_link;
			if (mysqli_stmt_execute($insert_stmt)) {
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
