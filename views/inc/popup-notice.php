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
if (!isset($_COOKIE["user"])) {
    setcookie("user", "usersetcookie", time() + 604800, "/");
?>
    <div class="payment-popup-outside wholepopup">
        <div class="payment-popup popup-noticebox">
            <div class="pop-img">
                <i class="fa-solid fa-rectangle-xmark close-btn cross"></i>
                <img style="width:90%;" src="<?= LINK; ?>public/images/popup-notice.jpg" alt="popup-notice">
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
<?php  }  ?>