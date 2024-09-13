<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {


	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (
            isset($_POST['author']) &&
            isset($_POST['headline']) && 
            isset($_POST['link']) && 
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


            $author = validate($_POST['author']);
            $headline = $_POST['headline'];
            $link = $_POST['link']; 


			$insert_sql = "INSERT INTO `live`(
                                            `name`,
                                            `title`,
                                            `link`
                                            ) VALUES (?,?,?)";


			$insert_stmt = mysqli_prepare($connection, $insert_sql);
			mysqli_stmt_bind_param(
                $insert_stmt, 
                "sss", 
                $param_author,
                $param_title ,
                $param_link,
            );

                $param_author = $author;
                $param_title  = $headline;
                $param_link = $link;

			if (mysqli_stmt_execute($insert_stmt)) {
				header("location: " . ADMIN_LINK."live");
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