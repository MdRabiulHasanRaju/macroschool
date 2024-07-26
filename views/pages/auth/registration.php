<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Registration";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Registration";

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
        <h3>Create A New Account</h3>
        <span>Sign Up Now</span>
    </div>
    <div class="main-form">
        <form action="<?= LINK; ?>controllers/signupController.php" method="POST">
            <div class="singel-form">
                <input class="" type="email" name="username" id="email" value="" type="email" placeholder="Your Email">
                <div class="invalid-feedback">
                    <span style="color:red"><?php echo $username_err;
                                            unset($_SESSION['username_err']) ?></span>
                </div>
            </div>
            <div class="singel-form">
                <input class="" type="password" name="password" id="password" value="" placeholder="Your Password">
                <div id="password_view">
                    <img id="password_view_img" src="<?=LINK;?>public/images/icon/password-view.png" alt="password-view">
                </div>
                <div class="invalid-feedback">
                    <span id="StrengthDisp" class="strength">Weak password</span>
                </div>
            </div>
            <div class="singel-form">
                <input class="" type="password" name="confirm_password" id="confirm_password" value="" placeholder="Confirm Your Password">
                <div class="invalid-feedback">
                    <span style="color:red"><?php echo $password_err;
                                            unset($_SESSION['password_err']) ?></span>
                </div>
            </div>
            <div class="singel-form">
                <button name="submit" class="main-btn" type="submit">SIGN UP</button>
            </div>
            <div class="singel-form">
            <a href="<?=$client->createAuthUrl();?>" name="submit" class="main-btn google-btn"><img src="<?= LINK; ?>public/images/icon/google.png" alt="">Sign up with Google</a>
            </div>
            <a href="<?= LINK; ?>login" class="loginBtn my-3 text-center">Already have an account? Login Here</a>
        </form>
    </div>
    </div>

</section>

<?php
include("../../inc/footer.php");
?>
  <script>
    let password = document.getElementById("password");
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