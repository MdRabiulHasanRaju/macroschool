<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Login";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Login";

include("../../inc/header.php");

require_once '../auth/vendor/autoload.php';
require_once '../auth/config/config.php';

if (isset($_SESSION['username'])) {
    header("location: " . LINK . "dashboard");
    exit;
  }
  $username_err = $password_err = $confirm_password_err = $err = "";
  if (isset($_SESSION["username_err"])) {
    $username_err = $_SESSION["username_err"];
  } elseif (isset($_SESSION["password_err"])) {
    $password_err = $_SESSION["password_err"];
  }
  if (isset($_SESSION["err"])) {
    $err = $_SESSION["err"];
  }

?>

<section class="container auth">
    <div class="form-title text-center">
        <h3>Login To Your Account!</h3>
        <span>Login now </span>
    </div>
    <div class="main-form">
        <form action="<?= LINK; ?>controllers/loginController.php" method="POST">
            <div class="singel-form">
                <input class="" type="email" name="username" id="email" value="" type="email" placeholder="Your Email">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="singel-form">
                <input class="" type="password" name="password" id="password" value="" placeholder="Your Password">
                <span id="password_view">
                    <img id="password_view_img" src="<?=LINK;?>public/images/icon/password-view.png" alt="password-view">
                </span>
                <div class="invalid-feedback">
                <span style="color:red"><?php echo $err;
                                            unset($_SESSION['err']); ?></span>
                </div>
            </div>
            <div class="singel-form">
                <button name="submit" class="main-btn" type="submit">LOG IN</button>
            </div>
            <div class="singel-form">
                <a href="<?=$client->createAuthUrl();?>" name="submit" class="main-btn google-btn"><img src="<?= LINK; ?>public/images/icon/google.png" alt="">Sign in with Google</a>
            </div>
            <div class="forgotpass">
                <a href="<?=LINK;?>forgot-password" class="loginBtn my-3 text-center">Forgot Your Password?</a>
            </div>
            <a href="<?=LINK;?>registration" class="loginBtn my-3 text-center">Don't have an Account? Create One</a> 
        </form>
    </div>
    </div>

</section>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>