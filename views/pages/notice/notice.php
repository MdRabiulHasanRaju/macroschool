<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Notices";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Notice";

include("../../inc/header.php");

?>

<style>
.notice_container {
    padding: 10px 180px;
    background: #f6f6f6;
    margin-top: 10px;
}
.notice-box{
    margin-bottom: 25px;
    padding: 10px;
    border: 1px solid #ededed;
    box-shadow: 1px 1px 31px -23px black;
    background:white;
    border-radius: 10px;
}
.notice-box>p {
    font-size: 14px;
    text-align: justify;
}

.notice-box>h6 {
    padding: 5px 0px;
    font-size: 12px;
}
@media screen and (max-width:600px) {
    .notice_container {
    padding: 10px 5px;
}
.notice-box>h3 {
    font-size: 18px;
}
}
</style>
<div class="container" style="background: #ededed;border-radius: 0;padding: 10px;text-align:center;">
        <h4> - Notice Board </h4>
</div>
<section class="container notice">
    <div class="notice_container">

<?php
        $noticeSql = "SELECT `id`,`author`,`title`,`des`,`date` FROM `notice` ORDER BY id DESC limit 4";
        $noticeStmt = fetch_data($connection, $noticeSql);
        if ($noticeStmt) {
            if (mysqli_stmt_num_rows($noticeStmt) == 0) {
                header("location: " . LINK . "error/404");
                die();
            }
            mysqli_stmt_bind_result($noticeStmt, $id, $author, $title,$des, $date);
            while (mysqli_stmt_fetch($noticeStmt)) {
                ?>

        <div class="notice-box">
            <img style="width: 30px;min-height: 20px;margin-bottom: 8px;" src="<?=LINK;?>public/images/icon/pin.png" alt="notice-board-pin-image">
            <h3><?=$title;?></h3>
            <h6><?=$format->formatDate($date);?>, Posted By <span style="color:#dc555b;font-size:14px"><?=$author;?></span></h6>
            <p style="border-top:1px solid #ededed"><?=$des;?></p>
        </div>

        <?php
            }
        } ?>
        
    </div>
</section>


<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>