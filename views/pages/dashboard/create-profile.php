<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Dashboard";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Dashboard";

include("../../inc/header.php");

require_once '../auth/vendor/autoload.php';
require_once '../auth/config/config.php';


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();

    $name = $google_account_info->name;
    $email = $google_account_info->email;
    $image = $google_account_info->picture;
    $Token = $google_account_info->id;

    $_SESSION["google-Token"] = $Token;
    $_SESSION["google-image"] = $image;

    $account_loggedin = "";

    if (isset($email)) {
        $sql = "select id from users where email = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $param_login_email);
        $param_login_email = $email;
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_store_result($stmt)) {
                if (mysqli_stmt_num_rows($stmt) == 0) {
                    $account_loggedin = false;
                } else {
                    $account_loggedin = true;
                    mysqli_stmt_bind_result($stmt, $id);
                    if (mysqli_stmt_fetch($stmt)) {
                        $_SESSION["username"] = $email;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        $login_userInfo_sql = "select name,mobile,image from users_info where user_id = ?";
                        $login_userInfo_stmt = mysqli_prepare($connection, $login_userInfo_sql);
                        mysqli_stmt_bind_param($login_userInfo_stmt, "i", $param_id);
                        $param_id = $_SESSION['id'];
                        if (mysqli_stmt_execute($login_userInfo_stmt)) {
                            if (mysqli_stmt_store_result($login_userInfo_stmt)) {
                                if (mysqli_stmt_num_rows($login_userInfo_stmt) == 0) {
                                } else {
                                    mysqli_stmt_bind_result($login_userInfo_stmt, $name, $mobile, $image);
                                    mysqli_stmt_fetch($login_userInfo_stmt);
                                    $_SESSION['name'] = $name;
                                    $_SESSION['mobile'] = $mobile;
                                    $_SESSION['image'] = $image;
                                    header("location: " . LINK . "dashboard");
                                    die();
                                }
                            }
                        }
                    }
                }
            }
        }
    } 

    if($account_loggedin==false){
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($connection, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $email;
            $param_password = password_hash($Token, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
    
                $u_sql = "SELECT id FROM users WHERE email = ?";
                $u_stmt = mysqli_prepare($connection, $u_sql);
                mysqli_stmt_bind_param($u_stmt, "s", $param_email);
                $param_email = strtolower($email);
                mysqli_stmt_execute($u_stmt);
                mysqli_stmt_store_result($u_stmt);
                mysqli_stmt_bind_result($u_stmt, $id);
                mysqli_stmt_fetch($u_stmt);
                $_SESSION['loggedin'] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $email;
            }
        }
    }

}

?>


<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_SESSION['mobile'])) {
        header("location: " . LINK . "dashboard");
        die();
    }

    $name_err  = $phone_err  = "";
    if (isset($_SESSION["name_err"])) {
        $name_err = $_SESSION["name_err"];
    } elseif (isset($_SESSION["phone_err"])) {
        $phone_err = $_SESSION["phone_err"];
    }
?>
    <style>
        label {
            font-size: 13px;
        }

        input::placeholder {
            font-size: 12px;
        }

        input:focus {
            font-size: 13px;
        }

        input {
            font-size: 13px !important;
        }
    </style>
    <section class="container profile-box">
        <div class="profile-page-link">
            <h1>Account Info</h1>
        </div>
        <div class="create-profile-data">
            <form action="<?= LINK; ?>controllers/createProfileController.php" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="name">Full Name <span style="color:red;">*</span></label>
                    <input id="name" name="name" class="form-control" value="<?php
                                                                                if (isset($_SESSION['google-name'])) {
                                                                                    echo $_SESSION['google-name'];
                                                                                } ?>" type="text" placeholder="Enter Your Full Name" required>
                    <span style="color:red">
                        <?php echo $name_err;
                        unset($_SESSION['name_err']); ?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="mobile">Phone Number <span style="color:red;">*</span></label>
                    <input id="mobile" name="mobile" class="form-control" type="text" placeholder="Enter Your Phone Number" required>
                    <span style="color:red">
                        <?php echo $phone_err;
                        unset($_SESSION['phone_err']); ?>
                    </span>
                </div>
                <input type="submit" name="submit" class="my-btn profile-btn" value="Save">
            </form>
        </div>
    </section>

<?php
    include("../../inc/footer.php");
} else {
    header("location: " . LINK . "login");
    die();
}
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>