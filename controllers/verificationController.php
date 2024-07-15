<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/serverit/lib/Database.php";
include $_SERVER['DOCUMENT_ROOT'] . "/serverit/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/serverit/");
?>
<?php ob_start(); ?>
<?php
$wrong_otp = "";
if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $ssql = "select otp from verification where email = '$email'";
    $femail = mysqli_query($connection, $ssql);
    $otp = mysqli_fetch_assoc($femail);
    if (!$otp['otp']) {
        header("location: " . LINK . "views/error/404.php");
    }

    if (isset($_POST['otp']) && isset($_POST['otpsubmit'])) {
        $otp = $_POST['otp'];
        $sql = "select otp from verification where email = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $b_otp);
            if (mysqli_stmt_fetch($stmt)) {
                if ($otp == $b_otp) {
                    header("location: " . LINK . "auth?p=1");
                    $delsql = "delete from verification where otp = $b_otp";
                    $del = $connection->query($delsql);
                } else {
                    $wrong_otp = "Please Enter Right OTP";
                    $_SESSION['wrong_otp'] = $wrong_otp;
                    header("location: " . LINK . "verification/$email");
                }
            } else {
                header("location: " . LINK . "views/error/404.php");
            }
        } else {
            header("location: " . LINK . "views/error/404.php");
        }
    }
} else {
    header("location: " . LINK . "views/error/404.php");
}
?>