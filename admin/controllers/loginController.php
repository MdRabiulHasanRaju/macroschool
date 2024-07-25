<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['submit'])) {

		include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

		$username = $password = "";
		$err = "";

		if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
			$err = "Please enter username and password";
			$_SESSION["err"] = $err;
			header("location: " . ADMIN_LINK . "login");
			die();
		} else {
			$username = htmlspecialchars(trim($_POST['username']));
			$password = trim($_POST['password']);
		}

		if (empty($err)) {
			$sql = "SELECT id, email, password FROM users_admin WHERE email = ?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = strtolower($username);

			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if (mysqli_stmt_fetch($stmt)) {
						if (password_verify($password, $hashed_password)) {

								$_SESSION["admin_username"] = $username;
								$_SESSION["admin_id"] = $id;
								$_SESSION["admin_loggedin"] = true;
							    header("location: " . ADMIN_LINK );

						} else {
							$err = "Wrong password!";
							$_SESSION["err"] = $err;
							header("location: " . ADMIN_LINK . "login");
							die();
						}
					}
				} else {
					$err = "Please enter valid email!";
					$_SESSION["err"] = $err;
					header("location: " . ADMIN_LINK . "login");
					die();
				}
			}
		}
	}
} else {

	header("location: " . ADMIN_LINK . "login");
	die();
}
