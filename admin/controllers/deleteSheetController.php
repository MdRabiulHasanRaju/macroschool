<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/macroschool";
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['id']) && isset($_POST['prev_main_image']) && isset($_POST['prev_free_image']) && isset($_POST['submit'])) {

			include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $id = validate($_POST['id']);
			$prev_main_image = validate($_POST['prev_main_image']);
			$prev_free_image = validate($_POST['prev_free_image']);
		
			$sql = "DELETE FROM `sheets` WHERE id=?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;

			if (mysqli_stmt_execute($stmt)) {
				$imageLink = "$root/public/images/$prev_main_image";

				if (file_exists($imageLink)) {
					$delImage = unlink($imageLink);
					if (!$delImage) {
						echo "Main Image not deleted!";
						exit();
					}
				}else{
					echo "file not found! .$imageLink";
					exit;
				}
				
				$prev_free_image = explode(",",$prev_free_image);
				foreach($prev_free_image as $free_img){
					$free_img_link = "$root/public/images/$free_img";
					if (file_exists($free_img_link)) {
						$delFreeImage = unlink($free_img_link);
						if (!$delFreeImage) {
							echo "Free Image not deleted!";
							exit();
						}
					}else{
						echo "file not found! .$free_img_link";
						exit;
					}
				}
				
				header("location: " . ADMIN_LINK."all-sheets");
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
