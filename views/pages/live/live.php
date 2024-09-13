<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Live Class";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "live";

include("../../inc/header.php");

?>
<?php
$liveSql = "SELECT `name`,`title`,`link` FROM `live`";
$liveStmt = fetch_data($connection, $liveSql);
if ($liveStmt) {
    if (mysqli_stmt_num_rows($liveStmt) != 0) {
        mysqli_stmt_bind_result($liveStmt, $name, $title,$link);
        mysqli_stmt_fetch($liveStmt);
?>
<style>
    .live_container {
        padding: 10px;
        background: #f6f6f6;
        margin-top: 10px;
        text-align: center;
    }
    .facebook-live-link{
            width: 1000px;
            height: 600px;
        }

    @media screen and (max-width:600px) {
        .facebook-live-link{
            width: auto;
            height: auto;
        }
    }
</style>
<div class="container" style="background: #ededed;border-radius: 0;padding: 10px;text-align:center;">
    <h4> <?= $name ?> - <?= $title ?></h4>
</div>
<section class="container facebook-live">
    <div class="live_container">
    <iframe class="facebook-live-link" src="<?=$link;?>" width="" height="" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>
    </div>
</section>

<?php
    }else{
        header("location: 404");
    }
} ?>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>