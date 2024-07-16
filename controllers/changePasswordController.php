<?php
include $_SERVER['DOCUMENT_ROOT'] . "/serverit/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/serverit/");
$root = $_SERVER['DOCUMENT_ROOT'] . "/serverit";
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['oldPassword']) && isset($_POST['newPass']) && isset($_POST['confirmNewPass'])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . "/serverit/lib/Database.php";

            $oldPassword = $newPassword = $confirmNewPassword = $success = "";
            $oldPassword_err = $newPassword_err = $confirmNewPassword_err = "";

            if (empty(trim($_POST["oldPassword"]))) {
                $oldPassword_err = "Name cannot be blank";
                $_SESSION["oldPassword_err"] = $oldPassword_err;
                header("location: " . LINK . "change-password");
                die();
            }
            if (empty(trim($_POST["newPass"]))) {
                $newPassword_err = "Title cannot be blank";
                $_SESSION["newPassword_err"] = $newPassword_err;
                header("location: " . LINK . "change-password");
                die();
            }
            if (empty(trim($_POST["confirmNewPass"]))) {
                $confirmNewPassword_err = "Address cannot be blank";
                $_SESSION["confirmNewPassword_err"] = $confirmNewPassword_err;
                header("location: " . LINK . "change-password");
                die();
            }

            $oldPassword = htmlspecialchars(trim($_POST['oldPassword']));
            $newPassword = htmlspecialchars(trim($_POST['newPass']));
            $confirmNewPassword = htmlspecialchars(trim($_POST['confirmNewPass']));


            $usersql = "SELECT password FROM users WHERE id = ?";
            $userstmt = mysqli_prepare($connection, $usersql);
            mysqli_stmt_bind_param($userstmt, "i", $param_userid);
            $param_userid = $_SESSION['id'];

            if (mysqli_stmt_execute($userstmt)) {
                mysqli_stmt_store_result($userstmt);
                mysqli_stmt_bind_result($userstmt, $hashed_password);
                if (mysqli_stmt_fetch($userstmt)) {
                    if (password_verify($oldPassword, $hashed_password)) {
                        if ((strlen($newPassword) < 5 || strlen($confirmNewPassword) < 5)) {
                            $newPassword_err = "Password cannot be less than 5 characters!";
                            $_SESSION["newPassword_err"] = $newPassword_err;
                            header("location: " . LINK . "change-password");
                            die();
                        } else {
                            if ($newPassword != $confirmNewPassword) {
                                $confirmNewPassword_err = "Passwords should match!";
                                $_SESSION["confirmNewPassword_err"] = $confirmNewPassword_err;
                                header("location: " . LINK . "change-password");
                                die();
                            } else {
                                $update_sql = "update users set password=? where id = ?";
                                $update_stmt = mysqli_prepare($connection, $update_sql);
                                mysqli_stmt_bind_param($update_stmt, "si", $param_pass, $param_userid);
                                $param_userid = $_SESSION['id'];
                                $param_pass = password_hash($confirmNewPassword, PASSWORD_DEFAULT);
                                if (mysqli_stmt_execute($update_stmt)) {
                                    $success = "Your password has been changed.";
                                    $_SESSION["success"] = $success;
                                    header("location: " . LINK . "change-password");
                                } else {
                                    $confirmNewPass = "Something went wrong!";
                                    $_SESSION["confirmNewPass"] = $confirmNewPass;
                                    header("location: " . LINK . "change-password");
                                    die();
                                }
                            }
                        }
                    } else {
                        $oldPassword_err = "Old password is incorrect!";
                        $_SESSION["oldPassword_err"] = $oldPassword_err;
                        header("location: " . LINK . "change-password");
                        die();
                    }
                }
            }
        } else {
            echo "Req data eror!";
        }
    } else {
        echo "Post method not working!";
    }
} else {
    header("location: " . LINK . "auth?p=1");
    die();
}
