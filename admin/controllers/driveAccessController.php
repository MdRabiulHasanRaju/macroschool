<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['submit']) && isset($_POST['refid'])) {

			include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $refid = validate($_POST['refid']);
            $drive_access=1;

            $sheet_order = "";
			if (isset($_GET['order']) && $_GET['order'] == 'sheet') {
				$sheet_order = true;
				$insert_sql = "UPDATE `sheet_order` SET drive_access=? WHERE id=?";
			}else{
				$insert_sql = "UPDATE `order` SET drive_access=? WHERE id=?";
			}

			

			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param($insert_stmt, "ii", $param_drive_access, $param_id);
			$param_drive_access = $drive_access;
			$param_id = $refid;

			if (mysqli_stmt_execute($insert_stmt)) {
				if($sheet_order==true){
					header("location: " . ADMIN_LINK."all-sheet-order");
				}else{
					header("location: " . ADMIN_LINK."paid-order");
				}
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
