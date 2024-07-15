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
    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
        $_SESSION["username_err"] = $username_err;
        header("location: " . LINK . "registration");
        die();
      } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connection, $sql);
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "s", $param_username);


          $param_username = htmlspecialchars(trim($_POST['username']));


          if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
              $username_err = "This username is already taken!";
              $_SESSION["username_err"] = $username_err;
              header("location: " . LINK . "registration");
              die();
            } else {
              $username = trim($_POST['username']);
            }
          } else {
            echo "Something went wrong";
          }
        }
      }

      mysqli_stmt_close($stmt);

      if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
        $_SESSION["password_err"] = $password_err;
        header("location: " . LINK . "registration");
        die();
      } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters!";
        $_SESSION["password_err"] = $password_err;
        header("location: " . LINK . "registration");
        die();
      } else {
        $password = trim($_POST['password']);
      }

      if (trim($_POST['password']) !=  trim($_POST['confirm_password'])) {
        $password_err = "Passwords should match!";
        $_SESSION["password_err"] = $password_err;
        header("location: " . LINK . "registration");
        die();
      }

      if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $username = strtolower($username);
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($connection, $sql);
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
          $param_username = $username;
          $param_password = password_hash($password, PASSWORD_DEFAULT);
          if (mysqli_stmt_execute($stmt)) {
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
                          <h1>Verification Needed</h1>
                          <h3>Please confirm your sign-in request</h3>
                          <p>We have detected an account sign-in request from a device we don\'t recognize.</p>
                          <ul>
                            <li>Account: <b>' . $username . '</b></li>
                          </ul>
                          <p>To verify your account is safe, please use the following code to enable your new device —</p>
                          <h1 class="otpcode">' . $otp . '</h1>
                          <h3>How do I know this email is from Server IT Studio?</h3>
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

            $from = "Macro School <macroschool.academy@gmail.com>";
            $headers = "From: " . $from . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8" . "\r\n";

            $to_email = $username;
            $subject = "Verification Code From Macro School";

            if (mail($to_email, $subject, $body, $headers)) {
              //echo "Email successfully sent to $to_email...";
            } else {
              // echo "Email sending failed...";
            }
            $verifysql = "insert into verification(otp,email) values('$otp','$username')";
            $query = $connection->query($verifysql);
            header("location: " . LINK . "verification/$username");
          } else {
            echo "Something went wrong... cannot redirect!";
          }
        }
        mysqli_stmt_close($stmt);
      }
      mysqli_close($connection);
    }
  }
} else {
  header("location: " . LINK . "registration");
  die();
}
