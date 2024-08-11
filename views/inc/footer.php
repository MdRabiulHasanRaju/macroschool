<footer>
    <?php
    $contact_sql = "select phone,address,fb_link,yt_link,email from contact";
    $contact_stmt = fetch_data($connection, $contact_sql);
    mysqli_stmt_bind_result($contact_stmt, $phone, $address, $fb_link, $yt_link, $email);
    mysqli_stmt_fetch($contact_stmt);
    ?>
    <div class="container footer__container">
        <div class="footer__1">
            <a href="http://www.youtube.com/@macroschool158" class='footer__logo'>
                <h4>MACRO SCHOOL</h4>
            </a>
            <p>We believe in the implementation of Dreams.</p>
        </div>
        <div class="footer__2">
            <h4>Permalinks</h4>
            <ul class="permalinks">
                <li><a href="<?= LINK; ?>">Home</a></li>
                <li><a href="<?= LINK; ?>about">About</a></li>
                <li><a href="<?= LINK; ?>course">Course</a></li>
                <li><a href="<?= LINK; ?>sheet">Sheet</a></li>
                <li><a href="<?= LINK; ?>contact">Contact</a></li>
                <li><a href="<?= LINK; ?>dashboard">Dashboard</a></li>
            </ul>
        </div>
        <div class="footer__3">
            <h4>Privacy</h4>
            <ul class="privacy">
                <li>Privacy Policy</li>
                <li>Terms & Conditions</li>
                <li>Refund Policy</li>
            </ul>
        </div>
        <div class="footer__4">
            <h4>Contact Us</h4>
            <div>
                <p><?=$phone;?></p>
                <p><?=$email;?></p>
            </div>
            <ul class="footer__socials">
                <li><a target="_blank" href="<?=$fb_link;?>"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a target="_blank" href="<?=$yt_link;?>"><i class="fa-brands fa-youtube"></i></a></li>
            </ul>
        </div>

    </div>
    <div class="footer__copyright">
        <small>Copyrights &copy; MACRO SCHOOL ONLINE PLATFORM</small> <br>
        <small>Developed By &copy;<a target="_blank" href="https://www.linkedin.com/in/mdrabiulhasanraju">Md Rabiul Hasan</a></small>
    </div>
    </div>
</footer>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>