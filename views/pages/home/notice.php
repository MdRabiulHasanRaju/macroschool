<style>
.mobile-notice-bar{
    display: none;
}
.desktop-notice-bar{
    display: block;
}
.notice_container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 10px;
}
.notice-box{
    padding: 10px;
    border: 1px solid #ededed;
    box-shadow: 1px 1px 31px -23px black;
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
    .mobile-notice-bar{
    display: block;
}
.desktop-notice-bar{
    display: none;
}
    .notice_container {
    grid-template-columns: 1fr;
}
.notice-box>h3 {
    font-size: 18px;
}
}
</style>
<section class="courses desktop-notice-bar" style="margin-bottom:0">
    <h2>Notice Board</h2>
</section>
<div class="container notice_container">
<h2 class="mobile-notice-bar" style="text-align: center;margin-bottom: 10px;font-size: 20px;color: #dc555b;padding: 5px 0;box-shadow: 0px 3px 11px -11px black;">Notice Board</h2>

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
            <h6><?=$format->formatDate($date);?> <br/> Posted By <span style="color:#dc555b;font-size:14px"><?=$author;?></span></h6>
            <p style="border-top:1px solid #ededed"><?=$des;?></p>
        </div>

        <?php
            }
        } ?>
        
</div>
<div class="container" style="text-align:center;width:200px;margin-bottom: 20px">
            <a style="display:block;font-size:14px;padding:5px 10px;" class="my-btn green" href="<?= LINK; ?>notice">View All Notice</a>
    </div>