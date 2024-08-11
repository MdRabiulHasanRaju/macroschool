<?php
$title= "Macro School - Contact";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Contact";
?>
<?php
include("../../inc/header.php");
$contact_sql = "select phone,address,fb_link,yt_link,email from contact";
$contact_stmt = fetch_data($connection,$contact_sql);
mysqli_stmt_bind_result($contact_stmt,$phone,$address,$fb_link,$yt_link,$email);
mysqli_stmt_fetch($contact_stmt);
?>

<section class="contact">
        <div class="container contact__container">
            <aside class="contact__aside">
                <div class="aside__iamge">
                    <img src="public/images/contact.svg">
                </div>
                <h2>Contact us</h2>
                <p>
                We believe in the implementation of Dreams.
                </p>
                <ul class="contact__details">
                     <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <h5><?=$phone?></h5>
                     </li>
                     <li>
                        <i class="fa-solid fa-envelope"></i>
                        <h5><?=$email?></h5>
                     </li>
                     <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <h5><?=$address?></h5>
                     </li>
                </ul>
                <ul class="contact__socials">
                <li><a target="_blank" href="<?=$fb_link?>"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a target="_blank" href="<?=$yt_link?>"><i class="fa-brands fa-youtube"></i></a></li>
                
                </ul>
            </aside>

            <form action='' method='POST' class='contact__form'>
                <div class="form__name">
                    <input type="text" name='First Name' placeholder='First Name' required>
                    <input type="text" name='Last Name' placeholder='Last Name' required>
                </div>
                <input type="email" name='Email Address' placeholder='Your Email' required>
                <textarea name="Message" placeholder='Send Message' rows="7" required></textarea>
                <button type='submit' class='btn btn-primary'>Send Message</button>
            </form>
        </div>
      </section>


<?php
include("../../inc/footer.php");
?>
<script src="<?=LINK;?>main.js"></script>
</body>

</html>