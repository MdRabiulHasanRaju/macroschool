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
                mysqli_stmt_fetch($double_ordered_check_stmt);
                if($double_ordered_check_course_id==$course_id){
                    header("location: " . LINK . "dashboard");
                exit;
                }
            }


        }
    }else{header("location: " . LINK . "404");exit;}

            $id = $_SESSION['id'];
            $course_id = $s_course_id;
            $mobile = $_SESSION['mobile'];

            $course_sql = "select course_title, course_sub_title from courses where id=?";
            $course_stmt = mysqli_prepare($connection,$course_sql);
            mysqli_stmt_bind_param($course_stmt, "i", $param_course_id);
            $param_course_id = $course_id;
            mysqli_stmt_execute($course_stmt);
            mysqli_stmt_store_result($course_stmt);
            mysqli_stmt_bind_result($course_stmt,$course_title,$course_sub_title);
            mysqli_stmt_fetch($course_stmt);

            $order_sql = "insert into `order`(user_id,course_id,course_title,course_sub_title,mobile,email) values(?,?,?,?,?,?)";
            $order_stmt = mysqli_prepare($connection,$order_sql);
            mysqli_stmt_bind_param($order_stmt,"iissss",$param_user_id,$param_course_id,$param_course_title,$param_course_sub_title,$param_mobile,$param_email);
            $param_user_id = $_SESSION['id'];
            $param_course_id = htmlspecialchars(trim($course_id));
            $param_course_title = htmlspecialchars(trim($course_title));
            $param_course_sub_title = htmlspecialchars(trim($course_sub_title));
            $param_mobile = htmlspecialchars(trim($mobile));
            $param_email = $_SESSION['username'];

            if(mysqli_stmt_execute($order_stmt)){
                header("location: " . LINK . "dashboard");
            }else{
                echo "An Error Occured!";
            }


} else {
    header("location: " . LINK . "login");
    die();
}
