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
        
        $sheet_id = htmlspecialchars(trim($_GET["id"]));
        $s_sheet_sql = "select id from sheets where id=?";
        $s_sheet_stmt = mysqli_prepare($connection,$s_sheet_sql);
        mysqli_stmt_bind_param($s_sheet_stmt, "i", $param_s_sheet_id);
        $param_s_sheet_id = $sheet_id;
        mysqli_stmt_execute($s_sheet_stmt);
        mysqli_stmt_store_result($s_sheet_stmt);
        mysqli_stmt_bind_result($s_sheet_stmt,$s_sheet_id);
        if(mysqli_stmt_num_rows($s_sheet_stmt)==0){
            header("location: " . LINK . "404");
            exit;
        }else{
            mysqli_stmt_fetch($s_sheet_stmt);
            $sheet_id=$s_sheet_id;

            $double_ordered_check_sql = "select sheet_id from `sheet_order` where user_id=?";
            $double_ordered_check_stmt = mysqli_prepare($connection,$double_ordered_check_sql);
            mysqli_stmt_bind_param($double_ordered_check_stmt, "i", $param_double_ordered_check_id);
            $param_double_ordered_check_id = $_SESSION['id'];
            mysqli_stmt_execute($double_ordered_check_stmt);
            mysqli_stmt_store_result($double_ordered_check_stmt);
            mysqli_stmt_bind_result($double_ordered_check_stmt,$double_ordered_check_sheet_id);
            if(mysqli_stmt_num_rows($double_ordered_check_stmt)>0){
                while(mysqli_stmt_fetch($double_ordered_check_stmt)){
                    if($sheet_id==$double_ordered_check_sheet_id){
                        header("location: " . LINK . "dashboard");
                        exit;
                    }
                }
            }

        }
    }else{header("location: " . LINK . "404");exit;}

            $id = $_SESSION['id'];
            $sheet_id = $s_sheet_id;
            $mobile = $_SESSION['mobile'];

            $sheet_sql = "select sheet_title, faculties,regular_price, offer_price from sheets where id=?";
            $sheet_stmt = mysqli_prepare($connection,$sheet_sql);
            mysqli_stmt_bind_param($sheet_stmt, "i", $param_sheet_id);
            $param_sheet_id = $sheet_id;
            mysqli_stmt_execute($sheet_stmt);
            mysqli_stmt_store_result($sheet_stmt);
            mysqli_stmt_bind_result($sheet_stmt,$sheet_title,$faculties,$regular_price, $offer_price);
            mysqli_stmt_fetch($sheet_stmt);
            $status = 1;
            $drive_access = 0;
            if($regular_price==0 && $offer_price==0){
                $status = 2;
                $drive_access = 1;
            }

            $sheet_order_sql = "insert into `sheet_order`(user_id,sheet_id,sheet_title,faculties,mobile,email,regular_price, offer_price, status,drive_access) values(?,?,?,?,?,?,?,?,?,?)";
            $sheet_order_stmt = mysqli_prepare($connection,$sheet_order_sql);
            mysqli_stmt_bind_param($sheet_order_stmt,"iissssiiii",$param_user_id,$param_sheet_id,$param_sheet_title,$param_faculties,$param_mobile,$param_email,$param_regular_price, $param_offer_price,$param_status,$param_drive_access);
            $param_user_id = $_SESSION['id'];
            $param_sheet_id = htmlspecialchars(trim($sheet_id));
            $param_sheet_title = htmlspecialchars(trim($sheet_title));
            $param_faculties = htmlspecialchars(trim($faculties));
            $param_mobile = htmlspecialchars(trim($mobile));
            $param_email = $_SESSION['username'];
            $param_regular_price = $regular_price;
            $param_offer_price = $offer_price;
            $param_status = $status;
            $param_drive_access = $drive_access;

            if(mysqli_stmt_execute($sheet_order_stmt)){
                header("location: " . LINK . "dashboard");
            }else{
                echo "An Error Occured!";
            }


} else {
    header("location: " . LINK . "login");
    die();
}
