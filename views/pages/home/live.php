<style>
.live_container{
    display: grid;
    place-items: center;
    justify-content: Center;
    background: url(public/images/icon/live-background.gif);
    padding: 10px 0;
    border-radius: 40px;
    box-shadow: 1px 1px 11px -8px black;
    background-position: bottom;
}
    .live-button{
        padding: 5px 10px;
        border-radius: 20px;
        /*background: #dc555b;*/
        /*color: white;*/
        font-size: 18px;
    }
@media screen and (max-width:600px) {
    .live_container{
    background: unset;
    box-shadow: 1px 24px 18px -35px black;
}
        .live-button{
        font-size: 11px;
    }
}
</style>
<?php
$liveSql = "SELECT `name`,`title` FROM `live`";
$liveStmt = fetch_data($connection, $liveSql);
if ($liveStmt) {
    if (mysqli_stmt_num_rows($liveStmt) != 0) {
        mysqli_stmt_bind_result($liveStmt, $name, $title);
        mysqli_stmt_fetch($liveStmt);
?>
        <a href="<?= LINK; ?>live" class="container live_container">
            <img style="width: 60px;min-height:60px;" src="<?= LINK; ?>public/images/icon/live.gif" alt="live class icon">
            <h3 class="live-button" style=""><?= $name ?> - <?= $title ?></h3>
        </a>
<?php
    }
} ?>