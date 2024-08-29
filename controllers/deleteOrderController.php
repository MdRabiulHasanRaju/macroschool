<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['course_id'])) {

		include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
        function validate($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
        $course_id = validate($_POST["course_id"]);

		$msg = "";
		$err = "";


		if (empty($err)) {
			$sql = "DELETE FROM `order` WHERE id=?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "i", $param_course_id);
			$param_course_id = $course_id;
			if (mysqli_stmt_execute($stmt)) {
				http_response_code(200);
                $message = '<p style="text-align:center;border: 1px solid green;padding:10px 10px;font-size: 15px;" >Order Deleted Successfully<br> <a href="'.LINK.'courses" id="bkash_pay_notice_close" style="padding:7px 8px;font-weight:400;" class="my-btn">Buy Another Course</a></p>';
                echo json_encode(array('success' => $message));
                die();
			}else{
                http_response_code(403);
                $message = '<p style="text-align:center;background:#ffd600;padding:10px 10px;font-size: 15px;" >Order Not Deleted <button onclick="bkashNoticeCloseFunc()" id="bkash_pay_notice_close" style="padding:7px 8px;font-weight:400;" class="my-btn">X Close</button></p>';
                echo json_encode(array('err' => $message));
            }
		}
	}
} 
