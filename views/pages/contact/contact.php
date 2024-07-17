<?php
$title= "Macro School - Contact";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Contact";
?>
<?php
include("../../inc/header.php");
?>

<section class="contact">
        <div class="container contact__container">
            <aside class="contact__aside">
                <div class="aside__iamge">
                    <img src="public/images/contact.svg">
                </div>
                <h2>Contact us</h2>
                <p>
                   Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, ex.
                </p>
                <ul class="contact__details">
                     <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <h5>+8801877144472</h5>
                     </li>
                     <li>
                        <i class="fa-solid fa-envelope"></i>
                        <h5>macroschool90@gmail.com</h5>
                     </li>
                     <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <h5>Fatikcharri, Nazirhat and AK khan CTG</h5>
                     </li>
                </ul>
                <ul class="contact__socials">
                <li><a href="https://facebook.com"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="https://facebook.com"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="https://facebook.com"><i class="fa-brands fa-twitter"></i></a></li>  
                <li><a href="https://facebook.com"><i class="fa-brands fa-linkedin"></i></a></li>  
                
                </ul>
            </aside>

            <form action='https://formspree.io/f/xkndogag' method='POST' class='contact__form'>
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