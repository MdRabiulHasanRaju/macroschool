<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/macroschool";
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['id']) && isset($_POST['submit'])) {

			include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            $id = validate($_POST['id']);
			$get_order_sql = "select id,status from `order` where coupon_code='$id'";
			$get_order_stmt = fetch_data($connection,$get_order_sql);
			if(mysqli_stmt_num_rows($get_order_stmt)!=0){
			mysqli_stmt_bind_result($get_order_stmt,$order_id,$order_status);
				while(mysqli_stmt_fetch($get_order_stmt)){
					if($order_status == 1){
						$del_order_sql = "DELETE FROM `order` WHERE id='$order_id'";
						$del_order_stmt = mysqli_prepare($connection, $del_order_sql);
						mysqli_stmt_execute($del_order_stmt);
					}
				}
			}
		
			$sql = "DELETE FROM `coupon` WHERE id=?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "i", $param_id);
			$param_id = $id;

			if (mysqli_stmt_execute($stmt)) {
				header("location: " . ADMIN_LINK."coupon");
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
