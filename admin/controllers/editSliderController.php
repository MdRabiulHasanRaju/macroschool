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
        isset($_POST['slider_id']) &&
        $image = $_FILES['image'] &&
        isset($_POST['prev_image']) &&
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


        $slider_id = validate($_POST['slider_id']);
        $prev_image = validate($_POST['prev_image']);


        if (isset($_FILES['image'])) {
            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $imageName = $prev_image;
            }else{
                list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);
				if ($width != 851 && $height != 315) {
					echo "Width and Height Doesn't Match!<br><br>";
					echo "Width Should be : 851px<br>";
					echo "Height Should be : 315px<br>";
					exit();
				}
                $data = $_FILES['image']["tmp_name"];
                $imageName = "Slider-Banner-" . rand(9999, 999999) . time() . '.jpg';
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

        $update_sql = "UPDATE `slider` SET
            `image`=?
            WHERE id=?";

        $update_stmt = mysqli_prepare($connection, $update_sql);
        mysqli_stmt_bind_param(
            $update_stmt,
            "si", 
            $param_image,
            $param_id
        );

        $param_image = $imageName;
        $param_id = $slider_id;

        if (mysqli_stmt_execute($update_stmt)) {
            header("location: " . ADMIN_LINK . "slider");
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
