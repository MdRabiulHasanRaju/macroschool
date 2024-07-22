<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/macroschool";
session_start();

// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST['teacher_id']) &&
        isset($_POST['prev_image']) &&
        isset($_POST['name']) &&
        isset($_POST['department']) && 
        isset($_FILES['image']) &&
        isset($_POST['facebookLink']) && 
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


        $teacher_id = validate($_POST['teacher_id']);
        $prev_image = validate($_POST['prev_image']);
        $name = validate($_POST['name']);
        $department = validate($_POST['department']);
        $image = $_FILES['image'];
        $facebookLink = validate($_POST['facebookLink']); 

        if (isset($_FILES['image'])) {
            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $imageName = $_POST['prev_image'];
            }else{
                $data = $_FILES['image']["tmp_name"];
                $imageName = "$name-$department-" . rand(9999, 999999) . time() . '.jpg';
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


        $update_sql = "UPDATE `faculties` SET
            `name`=?,
            `department`=?,
            `image`=?,
            `link`=?
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "ssssi", 
            $param_name,
            $param_department ,
            $param_image,
            $param_link,
            $param_id
        );

        $param_name = $name;
        $param_department  = $department;
        $param_image = $imageName;
        $param_link = $facebookLink;
        $param_id = $teacher_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "all-teachers");
        }
    } else {
        echo "Req data eror!";
    }
} else {
    echo "Post method not working!";
}
// } else {
// 	header("location: " . ADMIN_LINK . "login");
// 	die();
// }
