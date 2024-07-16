<?php
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_POST['submit'])) {
		if (isset($_SESSION['username'])) {
			header("location: " . LINK . "dashboard");
			exit;
		}
		include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

		$username = $password = "";
		$err = "";

		if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
			$err = "Please enter username and password";
			$_SESSION["err"] = $err;
			header("location: " . LINK . "login");
			die();
		} else {
			$username = htmlspecialchars(trim($_POST['username']));
			$password = trim($_POST['password']);
		}

		if (empty($err)) {
			$sql = "SELECT id, email, password FROM users WHERE email = ?";
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = strtolower($username);

			if (mysqli_stmt_execute($stmt)) {
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) == 1) {
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
					if (mysqli_stmt_fetch($stmt)) {
						if (password_verify($password, $hashed_password)) {
							$ssql = "select otp from verification where email = ?";
							$sstmt = mysqli_prepare($connection, $ssql);
							mysqli_stmt_bind_param($sstmt, "s", $sparam_username);
							$sparam_username = $username;
							mysqli_stmt_execute($sstmt);
							mysqli_stmt_store_result($sstmt);
							mysqli_stmt_bind_result($sstmt, $otp);
							mysqli_stmt_fetch($sstmt);
							if ($otp) {
								header("location: " . LINK . "verification/$username");
								die();
							} else {
								$_SESSION["username"] = $username;
								$_SESSION["id"] = $id;
								$_SESSION["loggedin"] = true;

								$sql = "select * from users_info where user_id = ?";
								$stmt = mysqli_prepare($connection, $sql);
								mysqli_stmt_bind_param($stmt, "i", $param_id);
								$param_id = $_SESSION['id'];
								if (mysqli_stmt_execute($stmt)) {
									if (mysqli_stmt_store_result($stmt)) {
										if (mysqli_stmt_num_rows($stmt) == 0) {
											header("location: " . LINK . "create-profile");
											die();
										} else {
											mysqli_stmt_bind_result($stmt,$id, $userID, $name,$mobile, $image);
											mysqli_stmt_fetch($stmt);
											$_SESSION['name'] = $name;
											$_SESSION['mobile'] = $mobile;
											$_SESSION['image'] = $image;
											header("location: " . LINK . "dashboard");
											die();
										}
									}
								}
							}
						} else {
							$err = "Wrong password!";
							$_SESSION["err"] = $err;
							header("location: " . LINK . "login");
							die();
						}
					}
				} else {
					$err = "Please enter valid email!";
					$_SESSION["err"] = $err;
					header("location: " . LINK . "login");
					die();
				}
			}
		}
	}
} else {

	header("location: " . LINK . "login");
	die();
}
