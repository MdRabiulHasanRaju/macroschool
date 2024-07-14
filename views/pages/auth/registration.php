<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Registration";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Registration";

include("../../inc/header.php");

?>

<section class="container auth">
    <div class="form-title text-center">
        <h3>Create A New Account</h3>
        <span>Sign Up Now</span>
    </div>
    <div class="main-form">
        <form action="/auth/login" method="POST">
            <div class="singel-form">
                <input class="" type="email" name="email" id="email" value="" type="email" placeholder="Your Email">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="singel-form">
                <input class="" type="password" name="password" id="password" value="" type="text" placeholder="Your Password">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="singel-form">
                <input class="" type="password" name="password" id="password" value="" type="text" placeholder="Confirm Your Password">
                <div class="invalid-feedback">
                    
                </div>
            </div>
            <div class="singel-form">
                <button class="main-btn" type="submit">SIGN UP</button>
            </div>
            <div class="singel-form">
                <button class="main-btn google-btn" type="submit"><img src="<?= LINK; ?>public/images/icon/google.png" alt="">Sign up with Google</button>
            </div>
            <a href="<?=LINK;?>login" class="loginBtn my-3 text-center">Already have an account? Login Here</a>
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