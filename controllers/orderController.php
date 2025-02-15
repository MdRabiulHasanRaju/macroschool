<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (!isset($_SESSION['mobile'])) {
		header("location: " . LINK . "dashboard");
		exit;
	}
    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
    if(isset($_GET["id"])){
        
        $course_id = htmlspecialchars(trim($_GET["id"]));
        $s_course_sql = "select id from courses where id=?";
        $s_course_stmt = mysqli_prepare($connection,$s_course_sql);
        mysqli_stmt_bind_param($s_course_stmt, "i", $param_s_course_id);
        $param_s_course_id = $course_id;
        mysqli_stmt_execute($s_course_stmt);
        mysqli_stmt_store_result($s_course_stmt);
        mysqli_stmt_bind_result($s_course_stmt,$s_course_id);
        if(mysqli_stmt_num_rows($s_course_stmt)==0){
            header("location: " . LINK . "404");
            exit;
        }else{
            mysqli_stmt_fetch($s_course_stmt);
            $course_id=$s_course_id;

            $double_ordered_check_sql = "select course_id from `order` where user_id=?";
            $double_ordered_check_stmt = mysqli_prepare($connection,$double_ordered_check_sql);
            mysqli_stmt_bind_param($double_ordered_check_stmt, "i", $param_double_ordered_check_id);
            $param_double_ordered_check_id = $_SESSION['id'];
            mysqli_stmt_execute($double_ordered_check_stmt);
            mysqli_stmt_store_result($double_ordered_check_stmt);
            mysqli_stmt_bind_result($double_ordered_check_stmt,$double_ordered_check_course_id);
            if(mysqli_stmt_num_rows($double_ordered_check_stmt)>0){
                while(mysqli_stmt_fetch($double_ordered_check_stmt)){
                    if($course_id==$double_ordered_check_course_id){
                        header("location: " . LINK . "dashboard");
                        exit;
                    }
                }
            }

        }
    }else{header("location: " . LINK . "404");exit;}

            $id = $_SESSION['id'];
            $course_id = $s_course_id;
            $mobile = $_SESSION['mobile'];

            $course_sql = "select course_title, course_sub_title,regular_price, offer_price from courses where id=?";
            $course_stmt = mysqli_prepare($connection,$course_sql);
            mysqli_stmt_bind_param($course_stmt, "i", $param_course_id);
            $param_course_id = $course_id;
            mysqli_stmt_execute($course_stmt);
            mysqli_stmt_store_result($course_stmt);
            mysqli_stmt_bind_result($course_stmt,$course_title,$course_sub_title,$regular_price, $offer_price);
            mysqli_stmt_fetch($course_stmt);
            $status = 1;
            $drive_access = 0;
            $coupon_code = '';
            if($regular_price==0 && $offer_price==0){
                $status = 2;
                $drive_access = 1;
            }
            if(isset($_COOKIE['offer_price']) && isset($_COOKIE['offer_price_id']) && $_COOKIE['offer_price_id']==$course_id) {
                $offer_price = $_COOKIE['offer_price'];
                if($offer_price==0){
                    $status = 2;
                }
                $coupon_code = $_COOKIE['coupon_code'];
                unset($_COOKIE['offer_price']);
                unset($_COOKIE['offer_price_id']);
                unset($_COOKIE['coupon_code']);
                setcookie('offer_price', '', -1, '/'); 
                setcookie('offer_price_id', '', -1, '/'); 
                setcookie('coupon_code', '', -1, '/'); 
                setcookie('discount_price', '', -1, '/'); 
            }

            $order_sql = "insert into `order`(user_id,course_id,course_title,course_sub_title,mobile,email,regular_price, offer_price, status,drive_access,coupon_code) values(?,?,?,?,?,?,?,?,?,?,?)";
            $order_stmt = mysqli_prepare($connection,$order_sql);
            mysqli_stmt_bind_param($order_stmt,"iissssiiiis",$param_user_id,$param_course_id,$param_course_title,$param_course_sub_title,$param_mobile,$param_email,$param_regular_price, $param_offer_price,$param_status,$param_drive_access,$param_coupon_code);
            $param_user_id = $_SESSION['id'];
            $param_course_id = htmlspecialchars(trim($course_id));
            $param_course_title = htmlspecialchars(trim($course_title));
            $param_course_sub_title = htmlspecialchars(trim($course_sub_title));
            $param_mobile = htmlspecialchars(trim($mobile));
            $param_email = $_SESSION['username'];
            $param_regular_price = $regular_price;
            $param_offer_price = $offer_price;
            $param_status = $status;
            $param_drive_access = $drive_access;
            $param_coupon_code = $coupon_code;

            if(mysqli_stmt_execute($order_stmt)){
                header("location: " . LINK . "dashboard");
            }else{
                echo "An Error Occured!";
            }


} else {
    header("location: " . LINK . "login");
    die();
}
