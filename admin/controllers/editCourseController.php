<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/macroschool";
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST['course_id']) &&
        isset($_POST['teachers']) &&
        isset($_POST['courseName']) &&
        isset($_POST['batch']) &&
        isset($_POST['courseDetails']) &&
        isset($_POST['freeClassLink']) &&
        isset($_FILES['image']) &&
        isset($_POST['prev_image']) &&
        isset($_POST['videoLink']) &&
        isset($_POST['startDate']) &&
        isset($_POST['courseDuration']) &&
        isset($_POST['totalNumberofClass']) &&
        isset($_POST['courseFeature']) &&
        isset($_POST['routineLink']) &&
        isset($_POST['materialsLink']) &&
        isset($_POST['facebookPrivateLink']) &&
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


        $course_id = validate($_POST['course_id']);
        $teachers = validate($_POST['teachers']);
        $courseName = validate($_POST['courseName']);
        $batch = validate($_POST['batch']);
        $courseDetails = validate($_POST['courseDetails']);
        $freeClassLink = validate($_POST['freeClassLink']);
        $image = $_FILES['image'];
        $prev_image = $_POST['prev_image'];
        $videoLink = validate($_POST['videoLink']);
        $startDate = validate($_POST['startDate']);
        $courseDuration = validate($_POST['courseDuration']);
        $totalNumberofClass = validate($_POST['totalNumberofClass']);
        $courseFeature = validate($_POST['courseFeature']);
        $routineLink = validate($_POST['routineLink']);
        $materialsLink = validate($_POST['materialsLink']);
        $facebookPrivateLink = validate($_POST['facebookPrivateLink']);
        $regularPrice = validate($_POST['regularPrice']);
        $offerPrice = validate($_POST['offerPrice']);
        $submit = validate($_POST['submit']);

        if (isset($_FILES['image'])) {
            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $imageName = $_POST['prev_image'];
            }else{
                $data = $_FILES['image']["tmp_name"];
                $imageName = "$batch-$courseName-" . rand(9999, 999999) . time() . '.jpg';
                $destination = "../../public/images/" . $imageName;


                $imageLink = "$root/public/images/$prev_image";
                if (file_exists($imageLink)) {
                    $delImage = unlink($imageLink);
                    if (!$delImage) {
                        echo "Image not deleted!";
                        exit();
                    }
                }else{
                    echo "file not found! .$imageLink";
                    exit;
                }


                move_uploaded_file($data,$destination);
            }
        }


        $update_sql = "UPDATE `courses` SET 
            `faculties`=?,
            `course_title`=?,
            `course_sub_title`=?,
            `course_details`=?,
            `free_class_link`=?,
            `image`=?,
            `video_link`=?,
            `start_date`=?,
            `course_duration`=?,
            `total_class`=?,
            `course_feature`=?,
            `routine`=?,
            `regular_price`=?,
            `offer_price`=?,
            `materials_link`=?,
            `facebook_link`=? 
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "ssssssssssssiissi",
            $param_teachers,
            $param_courseName,
            $param_batch,
            $param_courseDetails,
            $param_freeClassLink,
            $param_image,
            $param_videoLink,
            $param_startDate,
            $param_courseDuration,
            $param_totalNumberofClass,
            $param_courseFeature,
            $param_routineLink,
            $param_regularPrice,
            $param_offerPrice,
            $param_materialsLink,
            $param_facebookPrivateLink,
            $param_id,

        );

        $param_teachers = $teachers;
        $param_courseName  = $courseName;
        $param_batch = $batch;
        $param_courseDetails = $courseDetails;
        $param_freeClassLink = $freeClassLink;
        $param_image = $imageName;
        $param_videoLink = $videoLink;
        $param_startDate = $startDate;
        $param_courseDuration = $courseDuration;
        $param_totalNumberofClass = $totalNumberofClass;
        $param_courseFeature = $courseFeature;
        $param_routineLink = $routineLink;
        $param_regularPrice = $regularPrice;
        $param_offerPrice = $offerPrice;
        $param_materialsLink = $materialsLink;
        $param_facebookPrivateLink = $facebookPrivateLink;
        $param_id = $course_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "all-course");
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
