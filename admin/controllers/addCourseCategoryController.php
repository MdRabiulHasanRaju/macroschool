<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
            isset($_POST['name']) &&
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


            $name = validate($_POST['name']);


			$insert_sql = "INSERT INTO `course_category`(`cat_name`) VALUES (?)";


			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param(
                $insert_stmt, 
                "s", 
                $param_name,
            );
                $param_name = $name;
			if (mysqli_stmt_execute($insert_stmt)) {
				header("location: " . ADMIN_LINK."course-category");
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