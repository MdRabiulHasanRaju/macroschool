<?php

use Google\Service\CloudSearch\Resource\Query;

ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Live Class";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "live";

include("../../inc/header.php");

?>
<style>
    .facebook-live {
        display: flex;
    }

    .live_container {
        padding: 10px;
        background: #f6f6f6;
        margin-top: 10px;
        text-align: center;
        width: 70%;
    }

    .comment {
        width: 30%;
        margin:10px 0;
        height: 100%;
    }

    .facebook-live-link {
        width: 100%;
        height: 600px;
    }

    @media screen and (max-width:600px) {
        .facebook-live {
            flex-direction: column;
        }

        .live_container {
            padding: 0px;
            width: 100%;
        }

        .comment {
            width: 100%;
        }

        .facebook-live-link {
            width: 100%;
            height: 250px;
        }
    }

    @media screen and (max-width:900px) {
        .sticky-bar {
            position: relative !important;
        }

        .header {
            position: unset !important;
        }

        footer {
            background: #000000;
            color: #a9a9a9 !important;
        }

        .footer__container>div h4 {
            color: #a9a9a9;
        }

        .footer__1 p {
            color: #a9a9a9;
        }

        footer ul li {
            color: #a9a9a9;
        }

        footer ul li a {
            color: #a9a9a9;
        }

        .footer__copyright {
            color: #a9a9a9;
        }

        a {
            color: #a9a9a9;
        }

        p {
            color: #a9a9a9;
        }

        .my-btn {
            background: #343434;
            color: #a9a9a9;
        }

        .facebook-live-link {
            background: black;
            width: 100%;
        }

        .live_container {
            padding: 0px;
            background: black;
        }

        body {
            background: black;
        }

        #open-menu-btn {
            color: #a9a9a9;
        }

        #IMAGE {
            filter: drop-shadow(1px 1px 0px white);
        }

        .live-heading {
            color: #a9a9a9;
            background: #151515 !important;
        }

        .nav__container {
            border-bottom: none;
        }

        .mobile-dashboard {
            border: 1px solid #777777;
            background: black;
        }
        .comment {
            background: black!important;
            color: #a9a9a9;
        }
        input#comment {
            background: #a9a9a9;
        }

    }
</style>
<?php
$liveSql = "SELECT `name`,`title`,`link` FROM `live`";
$liveStmt = fetch_data($connection, $liveSql);
if ($liveStmt) {
    if (mysqli_stmt_num_rows($liveStmt) != 0) {
        mysqli_stmt_bind_result($liveStmt, $name, $title, $link);
        mysqli_stmt_fetch($liveStmt);
?>
        <div class="container live-heading" style="background: #ededed;border-radius: 0;padding: 10px;text-align:center;">
            <h4> <?= $name ?> - <?= $title ?></h4>
        </div>
        <section class="container facebook-live">
            <div class="live_container">
                <iframe class="facebook-live-link" src="<?= $link; ?>" width="" height="" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>
            </div>
            <div class="comment" style="background:#f6f6f6;">
                <form id="commentForm" style="margin:10px 20px;padding:20px 0" action="">
                    <label for="comment">Ask Question</label>
                    <input <?= ((isset($_SESSION['loggedin'])) ? '' : 'readonly'); ?> style="margin: 10px 0;" name="comment" id="comment" height="40px" required/>
                    <div id="showtyping"></div>
                    <input <?= ((isset($_SESSION['loggedin'])) ? '' : 'disabled'); ?> id="commentSubmit" type="submit" value="Sent" class="my-btn">
                </form>

                <div id="viewComments" style="margin:10px;border:1px solid #cfcfcf;">

                </div>
            </div>
        </section>

<?php
    } else {
        header("location: 404");
    }
} ?>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
<script src="<?= LINK; ?>public/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#viewComments").load("<?= LINK; ?>views/pages/live/comment.php");
        }, 1000)


        $("#commentForm").submit(function(event) {
            event.preventDefault();
            let msg = $("#comment").val();
            $.ajax({
                url:"/macroschool/controllers/postCommentController.php",
                type:"POST",
                data:{data:msg},
                success:function(data){
                    $("#comment").val('')
                }
            })
        })

    })
</script>
</body>

</html>