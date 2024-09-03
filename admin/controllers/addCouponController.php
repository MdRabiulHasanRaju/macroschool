<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
            isset($_POST['course']) &&
            isset($_POST['coupon']) &&
            isset($_POST['discount']) &&
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


            $course_id = validate($_POST['course']);
            $coupon = validate($_POST['coupon']);
            $discount = validate($_POST['discount']);

            $duplicate_coupon = false;
            $get_coupon_sql = "select coupon_code from coupon where course_Id='$course_id'";
            $get_coupon_stmt = fetch_data($connection,$get_coupon_sql);
            if(mysqli_stmt_num_rows($get_coupon_stmt)!=0){
                mysqli_stmt_bind_result($get_coupon_stmt,$get_coupon_code);
                while(mysqli_stmt_fetch($get_coupon_stmt)){
                    if($get_coupon_code==$coupon){
                        $duplicate_coupon = true;
                    }
                }
            }
            if($duplicate_coupon == true){
                echo "<span style='color:red;font-weight:bold;font-size:20px'>".$coupon." is already registered for this course!</span>";
            }else if($duplicate_coupon == false){
                $insert_sql = "INSERT INTO `coupon`(`course_id`,`coupon_code`,`discount`) VALUES (?,?,?)";
                $insert_stmt = mysqli_prepare($connection, $insert_sql);
                mysqli_stmt_bind_param(
                    $insert_stmt, 
                    "iss", 
                    $param_course_id,
                    $param_coupon_code,
                    $param_discount
                );
                    $param_course_id = $course_id;
                    $param_coupon_code = $coupon;
                    $param_discount = $discount;
                if (mysqli_stmt_execute($insert_stmt)) {
                    header("location: " . ADMIN_LINK."coupon");
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