<style>
    .wholepopup {
        z-index: 20;
    }

    .pop-img {
        display: flex;
        justify-content: center;
    }

    .cross {
    position: relative;
    right: -35%;
    left: 90%;
    font-size: 24px;
    padding: 0;
    margin: 0;
    top: -2px;
}
.popup-noticebox {
    background:none;
    transform: translate(50%, 0%);
}
@media screen and (max-width:600px) {
    .popup-noticebox {
    background: none;
    transform: translate(-4%, 50%)!important;
}
}
</style>
<?php
$pop_upSql = "SELECT `image`,`current_cookie` FROM `pop_up`";
$pop_upStmt = fetch_data($connection, $pop_upSql);
if ($pop_upStmt) {
    if (mysqli_stmt_num_rows($pop_upStmt) != 0) {
        mysqli_stmt_bind_result($pop_upStmt, $image, $current_cookie);
        mysqli_stmt_fetch($pop_upStmt);

if (!isset($_COOKIE[$current_cookie])) {
    setcookie($current_cookie, "pop_up_on", time() + 604800, "/");
?>


    <div class="payment-popup-outside wholepopup">
        <div class="payment-popup popup-noticebox">
            <div class="pop-img">
                <i class="fa-solid fa-rectangle-xmark close-btn cross"></i>
                <img style="width:90%;" src="<?= LINK; ?>public/images/<?=$image;?>" alt="popup-notice">
            </div>
        </div>

    </div>

    <script type="text/javascript">
        var cross = document.getElementsByClassName("cross")[0];
        var wholepopup = document.getElementsByClassName("wholepopup")[0];
        window.onload = setTimeout(function() {

            wholepopup.style.display = "block";
        }, 5000)
        cross.onclick = function() {
            wholepopup.style.display = "none";

        }
        window.onclick = function(event) {
            if (event.target == wholepopup) {
                wholepopup.style.display = "none";
            }
        }
    </script>
<?php  } }} ?>