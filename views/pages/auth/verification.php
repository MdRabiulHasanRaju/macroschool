<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Verification";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Verification";

$wrong_otp = '';
if (isset($_GET["email"])) {
  if (isset($_SESSION['wrong_otp'])) {
    $wrong_otp = $_SESSION['wrong_otp'];
  }
  $email = $_GET["email"];
  $ssql = "select otp from verification where email = '$email'";
  $femail = mysqli_query($connection, $ssql);
  $otp = mysqli_fetch_assoc($femail);
  if (!$otp['otp']) {
    header("location: " . LINK . "views/error/404.php");
  }
  include("../../inc/header.php");
?>

<section class="container auth">
    <div class="form-title text-center">
        <h3>Confirm Your Account</h3>
        <span>Check your mail: <b><?= $email; ?></b> for confirm your account. </span>
    </div>
    <div class="main-form">
        <form action="<?= LINK; ?>controllers/loginController.php" method="POST">
        <input type="hidden" name="email" value="<?= $email; ?>">
            <div class="singel-form">
                <input class="" type="text" name="otp" placeholder="OTP" id="password" value="" type="text" required>
                <div class="invalid-feedback">
                <span style="color:red;"><?php echo $wrong_otp;
                                                unset($_SESSION['wrong_otp']); ?></span>
                </div>
            </div>
            <div class="singel-form">
                <button name="otpsubmit" class="main-btn" type="submit">Enter OTP</button>
            </div>
        </form>
    </div>
    </div>

</section>

<?php
include("../../inc/footer.php");
?>
  <?php  } else {
  header("location: " . LINK . "views/error/404.php");
} ?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>