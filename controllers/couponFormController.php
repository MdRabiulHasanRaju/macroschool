<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['coupon_course_id']) && isset($_POST['coupon_code'])) {

		include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
        function validate($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
        $coupon_course_id = validate($_POST["coupon_course_id"]);

		$msg = "";
		$err = "";

		if (empty($_POST['coupon_code'])) {
			http_response_code(403);
			$err = "*Please Enter Coupon Code!";
			echo json_encode(array('err' => $err));
			die();
		} else {
			$coupon_code = validate($_POST['coupon_code']);
		}

		if (empty($err)) {
			$sql = "SELECT id,discount,coupon_code FROM coupon WHERE course_Id = ?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "i", $param_course_id);
			$param_course_id = $coupon_course_id;

			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt,$id,$discount,$my_coupon_code);
                    while(mysqli_stmt_fetch($stmt)){
                        if($my_coupon_code==$coupon_code){
                            http_response_code(200);
                            $message = "Coupon Code Applied";
                            echo json_encode(array(
								'success' => $message,
								'discount'=> $discount, 
								'coupon_id'=> $id
							));
                            die();
                        }
                    }
                        http_response_code(403);
                        $err = "Invalid Coupon Code!";
                        echo json_encode(array('err' => $err,$coupon_course_id));
                        die();
                    
				} else {
                    http_response_code(403);
                    $err = "Invalid Coupon Code!";
                    echo json_encode(array('err' => $err,$coupon_course_id));
					die();
				}
			}
		}
	}
} 
