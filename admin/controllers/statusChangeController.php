<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['status']) && isset($_POST['refid'])) {

			include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $status = validate($_POST['status']);
            $refid = validate($_POST['refid']);

			

			$insert_sql = "UPDATE `order` SET status=? WHERE id=?";
			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param($insert_stmt, "ii", $param_status, $param_id);
			$param_status = $status;
			$param_id = $refid;

			if (mysqli_stmt_execute($insert_stmt)) {
				header("location: " . ADMIN_LINK);
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
