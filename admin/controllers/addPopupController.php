<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
			isset($_FILES['pop_image']) &&
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


			if (isset($_FILES['pop_image'])) {
				if (!file_exists($_FILES["pop_image"]["tmp_name"])) {
					$image_err = "Please Choose an Image";
					echo $image_err;
					exit();
				}
				list($width, $height) = getimagesize($_FILES["pop_image"]["tmp_name"]);
				if ($width != 720 && $height != 720) {
					echo "Width and Height Doesn't Match!<br><br>";
					echo "Width Should be : 720px<br>";
					echo "Height Should be : 720px<br>";
					exit();
				}
			}


			$data = $_FILES['pop_image']["tmp_name"];
			$imageName = "Popup-Notification-" . rand(9999, 999999) . time() . '.jpg';
			$destination = "../../public/images/" . $imageName;

            $cookie = "popup-".time();

			$insert_sql = "INSERT INTO `pop_up`(`image`,`current_cookie`) VALUES (?,?)";


			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param(
				$insert_stmt,
				"ss",
				$param_image,
				$param_current_cookie,
			);
			$param_image = $imageName;
			$param_current_cookie = $cookie;
			if (mysqli_stmt_execute($insert_stmt)) {
				move_uploaded_file($data,$destination);
				header("location: " . ADMIN_LINK . "popup");
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
