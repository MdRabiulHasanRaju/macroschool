<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
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


            $name = validate($_POST['name']);
            $department = validate($_POST['department']);
            $image = $_FILES['image'];
            $facebookLink = validate($_POST['facebookLink']); 


            if (isset($_FILES['image'])) {
				if (!file_exists($_FILES["image"]["tmp_name"])) {
					$image_err = "Please Choose an Image";
                    echo $image_err;
					exit();
				}
			}
            $data = $_FILES['image']["tmp_name"];
            $imageName = "$name-$department-" . rand(9999, 999999) . time() . '.jpg';
            $destination = "../../public/images/".$imageName ;

			$insert_sql = "INSERT INTO `faculties`(
                                            `name`,
                                            `department`,
                                            `image`,
                                            `link`
                                            ) VALUES (?,?,?,?)";


			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param(
                $insert_stmt, 
                "ssss", 
                $param_name,
                $param_department ,
                $param_image,
                $param_link,
            );

                $param_name = $name;
                $param_department  = $department;
                $param_image = $imageName;
                $param_link = $facebookLink;

			if (mysqli_stmt_execute($insert_stmt)) {
                move_uploaded_file($data,$destination);
				header("location: " . ADMIN_LINK."all-teachers");
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