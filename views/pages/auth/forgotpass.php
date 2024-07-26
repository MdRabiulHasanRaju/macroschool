<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Forget Password";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Forget Password";

include("../../inc/header.php");

if (isset($_SESSION['username'])) {
    header("location: " . LINK . "dashboard");
    exit;
}
$username = $err = $otpPage = $newPassPage = "";
$mainPage = true;
if (isset($_GET['otpPage'])) {
    $otpPage = true;
    $mainPage = false;
    $newPassPage = false;
}
if (isset($_GET['newPassPage'])) {
    $newPassPage = true;
    $otpPage = false;
    $mainPage = false;
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['username'])) {
        if (empty(trim($_POST['username']))) {
            $err = "Please enter username";
        } else {
            $username = htmlspecialchars(trim($_POST['username']));
        }


        if (empty($err)) {
            $sql = "SELECT email,id FROM users WHERE email = ?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;


            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $username, $id);
                    $otp = rand(1000, 100000);
                    $body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                      <meta charset="UTF-8">
                      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                      <meta name="creator" content="@Md Rabiul Hasan">
                      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
                      <meta name="title" content="Verification Code - Macro School">
                      <title>Verification Code - Macro School</title>
                      <style>
                        img {
                        width: 140px;
                        margin-top: 15px;
                    }
                    
                    .container {
                        margin: 0 auto;
                        padding: 0;
                        text-align: center;
                        background: #f1f1f1;
                        font-family: arial,sans-serif;
                    }
                    
                    .content-box {
                        width: 50%;
                        margin: 0 auto;
                        background: white;
                        text-align: left;
                        padding: 30px 45px;
                    }
                    
                    .header {
                        height: 63px;
                        background: #fbfbfb;
                        text-align: center;
                    }
                    
                    h1.otpcode {
                        color: white;
                        padding: 10px;
                        background: red;
                        text-align: center;
                    }
                    
                    .footer-box {
                        padding: 10px;
                    }
                    @media (max-width:768px){
                        .container {
                            width: 100%;
                        }
                        .content-box {
                            width: unset;
                        }
                    }
                      </style>
                    </head>
                    <body>
                      <div class="container">
                        <div class="content-box">
                          <div class="header">
                            <img src="' . LINK . 'public/images/logo-removebg-preview.png" alt="LOGO - Macro School">
                          </div>
                          <h1>Verification Needed To Restore Your Password</h1>
                          <h3>Please confirm your password restore request</h3>
                          <p>We have detected an account\'s password restore request from a device we don\'t recognize.</p>
                          <ul>
                            <li>Account: <b>' . $username . '</b></li>
                          </ul>
                          <p>To restore your account, please use the following code to enable your account back —</p>
                          <h1 class="otpcode">' . $otp . '</h1>
                          <h3>How do I know this email is from Macro School?</h3>
                          <p>The link provided in this email starts with https:// and contain macroschool.academy so you know it is from us. To contact customer service you can also simply paste the following link into your browser:</p>
                          <a href="https://www.macroschool.academy/contact" target="_blank">https://www.macroschool.academy/contact</a>
                        </div>
                        <div class="footer-box">
                          <p>Copyright © 2024 Macro School</p>
                        </div>
                      </div>
                    </body>
                    </html>
                    ';
                    $from = "Macro School <info@macroschool.academy>";
                    $headers = "From: " . $from . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type: text/html; charset=utf-8" . "\r\n";

                    $to_email = $username;
                    $subject = "Restore Your Password From Macro School";

                    if (mail($to_email, $subject, $body, $headers)) {
                        $_SESSION['OTP'] = $otp;
                        $_SESSION['recoverEmail'] = $username;
                        $_SESSION['recoverId'] = $id;
                        header("location: " . LINK . "forgot-password?otpPage=true");
                    } else {
                    }
                } else {
                    $err = "Please enter valid email!";
                }
            }
        }
    }
    if (isset($_POST['otpfield'])) {
        $userOTP = htmlspecialchars(trim($_POST['otpfield']));

        if ($userOTP == $_SESSION['OTP']) {
            unset($_SESSION['OTP']);
            header("location: " . LINK . "forgot-password?newPassPage=true");
        } else {
            $err = "Wrong OTP";
        }
    }


    if (isset($_POST['confirmNewPass']) && isset($_POST['newPass'])) {

        if (empty(trim($_POST['newPass']))) {
            $err = "Password cannot be blank";
        } elseif (strlen(trim($_POST['newPass'])) < 5) {
            $err = "Password cannot be less than 5 characters!";
        } else {
            $newPass = trim($_POST['newPass']);
        }

        if (trim($_POST['newPass']) !=  trim($_POST['confirmNewPass'])) {
            $err = "Passwords should match!";
        }

        if (empty($err)) {
            $recoverMail = $_SESSION['recoverEmail'];
            $sql = "UPDATE users SET password=? WHERE email = ?";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);
            $param_username = $recoverMail;
            $param_password = password_hash($newPass, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                session_start();
                unset($_SESSION['recoverEmail']);
                unset($_SESSION['recoverId']);
                header("location: " . LINK . "login");
                die();
            }
        }
    }
}
?>

<section class="container auth">
    <?php
    if ($mainPage == true) { ?>
        <div class="form-title text-center">
            <h3>Forgot Password</h3>
            <span>Recover Your Account</span>
        </div>
        <div class="main-form">
            <form action="" method="POST">
                <div class="singel-form">
                    <span>Enter your email below in the input box. We will send to you an OTP to recover your account.</span>
                    <input class="" type="email" name="username" id="email" value="" placeholder="Your Email" required>
                    <div class="invalid-feedback">
                        <span style="color:red"><?php echo $err; ?></span>
                    </div>
                </div>

                <div class="singel-form">
                    <button name="submit" class="main-btn" type="submit">Send OTP</button>
                </div>
                <div class="singel-form">
                </div>
                <a href="<?= LINK; ?>login" class="loginBtn my-3 text-center">Back To Login Page</a>
            </form>
        </div>
    <?php }
    if ($newPassPage == true) { ?>
        <div class="form-title text-center">
            <h3>Confim Your New Password</h3>
            <span>Add New Password For Your Account</span>
        </div>
        <div class="main-form">
            <form action="" method="POST">
                <div class="singel-form">
                    <input class="" type="password" name="newPass" id="password" value="" placeholder="Enter New Password" required>
                    <div id="password_view">
                    <img id="password_view_img" src="<?=LINK;?>public/images/icon/password-view.png" alt="password-view">
                </div>
                </div>

                <div class="singel-form">
                <input class="" type="password" name="confirmNewPass" id="confirmNewPass" value=""  placeholder="Confirm Your New Password" required>
                    <div class="invalid-feedback">
                        <span style="color:red"><?php echo $err; ?></span>
                    </div>
                </div>

                <div class="singel-form">
                    <button name="submit" class="main-btn" type="submit">Change</button>
                </div>
                <div class="singel-form">
                </div>
                <a href="<?= LINK; ?>login" class="loginBtn my-3 text-center">Back To Login Page</a>
            </form>
        </div>
    <?php }

    if ($otpPage == true) { ?>
        <div class="form-title text-center">
            <h3>Forgot Password</h3>
            <span>Recover Your Account</span>
        </div>
        <div class="main-form">
            <form action="" method="POST">
                <div class="singel-form">
                    <input class="" type="text" name="otpfield" id="email" value="" placeholder="Enter The OTP" required>
                    <div class="invalid-feedback">
                        <span style="color:red"><?php echo $err; ?></span>
                    </div>
                </div>

                <div class="singel-form">
                    <button name="submit" class="main-btn" type="submit">Confirm</button>
                </div>
                <div class="singel-form">
                </div>
                <a href="<?= LINK; ?>login" class="loginBtn my-3 text-center">Back To Login Page</a>
            </form>
        </div>
    <?php }
    ?>

</section>

<?php
include("../../inc/footer.php");
?>
<script>
    let password = document.getElementById("PassEntry");
    let strengthBadge = document.getElementById("StrengthDisp");

    let strongPassword = new RegExp(
        "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"
    );
    let mediumPassword = new RegExp(
        "((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))"
    );

    function StrengthChecker(PasswordParameter) {
        if (strongPassword.test(PasswordParameter)) {
            strengthBadge.style.color = "#25e825";
            strengthBadge.textContent = "Strong password";
        } else if (mediumPassword.test(PasswordParameter)) {
            strengthBadge.style.color = "#0c9db5";
            strengthBadge.textContent = "Medium password";
        } else {
            strengthBadge.style.color = "#ff6363";
            strengthBadge.textContent = "Weak password";
        }
    }

    password.addEventListener("input", () => {
        strengthBadge.style.display = "block";

        StrengthChecker(password.value);

        if (password.value.length == 0) {
            strengthBadge.style.display = "none";
        }
    });
</script>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>