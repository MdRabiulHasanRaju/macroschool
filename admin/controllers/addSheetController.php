<?php

use Google\Service\CloudSearch\PushItem;

include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (
            isset($_POST['teachers']) &&
            isset($_POST['sheetName']) &&
            isset($_POST['course_category']) &&
            isset($_POST['sheetDetails']) &&
            isset($_FILES['mainImage']) &&
            isset($_FILES['freeImage']) &&
            isset($_POST['driveLink']) &&
            isset($_POST['regularPrice']) &&
            isset($_POST['offerPrice']) &&
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


            $teachers = validate($_POST['teachers']);
            $sheetName = validate($_POST['sheetName']);
            $course_category = validate($_POST['course_category']);
            $sheetDetails = validate($_POST['sheetDetails']);
            $image = $_FILES['mainImage'];
            $freeImage = $_FILES['freeImage'];
            $driveLink = validate($_POST['driveLink']);
            $regularPrice = validate($_POST['regularPrice']);
            $offerPrice = validate($_POST['offerPrice']);

            $freeImages = "";
            $freeImageDatas = array();

            if (isset($_FILES['mainImage'])) {
                if (!file_exists($_FILES["mainImage"]["tmp_name"])) {
                    $image_err = "Please Choose an Image";
                    echo $image_err;
                    exit();
                } else {
                    $mainImageData = $_FILES['mainImage']["tmp_name"];
                    $mainImageName = "$sheetName-" . rand(9999, 999999) . time() . '.jpg';
                    $mainImagedestination = "../../public/images/" . $mainImageName;
                }
            }
            if (isset($_FILES['freeImage'])) {
                foreach ($_FILES['freeImage']['tmp_name'] as $fileCheck) {
                    if (!file_exists($fileCheck)) {
                        $image_err = "Please Choose an Image";
                        echo $image_err;
                        exit();
                    }
                }

                foreach ($_FILES['freeImage']['tmp_name'] as $file) {
                    $freeImageData = $file;
                    $freeImageName = "$sheetName-" . rand(9999, 999999) . time() . '.jpg';
                    array_push($freeImageDatas, $freeImageData);
                    $freeImages = $freeImages . $freeImageName . ",";
                }
                $freeImages = rtrim($freeImages, ",");
            }


            $insert_sql = "INSERT INTO `sheets`(
                `cat_id`,
                `faculties`,
                `sheet_title`,
                `sheet_details`,
                `main_image`,
                `free_img`,
                `sheet_link`,
                `regular_price`,
                `offer_price`
                ) VALUES (?,?,?,?,?,?,?,?,?)";


            $insert_stmt = mysqli_prepare($connection, $insert_sql);
            mysqli_stmt_bind_param(
                $insert_stmt,
                "issssssii",
                $param_course_category,
                $param_teachers,
                $param_sheetName,
                $param_sheetDetails,
                $param_mainImage,
                $param_freeImage,
                $param_driveLink,
                $param_regularPrice,
                $param_offerPrice
            );

            $param_course_category = $course_category;
            $param_teachers = $teachers;
            $param_sheetName  = $sheetName;
            $param_sheetDetails = $sheetDetails;
            $param_mainImage = $mainImageName;
            $param_freeImage = $freeImages;
            $param_driveLink = $driveLink;
            $param_regularPrice = $regularPrice;
            $param_offerPrice = $offerPrice;

            if (mysqli_stmt_execute($insert_stmt)) {

                move_uploaded_file($mainImageData, $mainImagedestination);

                $count = 0;
                $freeImages = explode(",", $freeImages);
                foreach ($freeImageDatas as $freeImageData) {
                    $freeImagedestination = "../../public/images/" . $freeImages[$count];
                    $count++;
                    move_uploaded_file($freeImageData, $freeImagedestination);
                }

                header("location: " . ADMIN_LINK . "all-sheets");
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
