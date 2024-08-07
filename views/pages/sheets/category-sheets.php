<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Sheet Category";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Sheets";

include("../../inc/header.php");
if (isset($_GET['cat_name']) && isset($_GET['cat_id'])) {
    $cat_id = htmlspecialchars($_GET['cat_id']);
    $cat_name = $_GET['cat_name'];
} else {
    header("location: " . LINK . "404");
}
?>

<style>
    .courses {
        margin-top: 1rem;
    }

    .course {
        display: flex;
        align-items: center;
    }

    .course__image {
        padding: 5px;
    }

    .course__info>h4 {
        font-size: 13px;
    }

    .course__info>a {
        font-size: 12px;
    }

    .share {
        padding: 8px 3px !important;
        font-size: 12px;
    }

    .share.my-btn a img {
        width: 26px;
    }

    .course__image>img {
        width: 100%;
        border: 2px solid #ededed;
    }
</style>
<section class="courses">
    <div class="container course-category-list">
        <a href="<?= LINK; ?>sheets">All Sheets</a>
        <?php
        $cat_sql = "select * from course_category";
        $cat_stmt = fetch_data($connection, $cat_sql);
        mysqli_stmt_bind_result($cat_stmt, $cat_id_, $cat_name_);
        while (mysqli_stmt_fetch($cat_stmt)) { 
            $get_cat_name = str_replace(" ", "_", $cat_name_);?>
            <a <?php
            if (isset($cat_name) && $cat_name == $get_cat_name) {
              echo "class='course-active'";
            } ?> href="<?= LINK; ?>sheets/<?= $cat_id_; ?>/<?= $cat_name_; ?>">
                <?= $cat_name_; ?>
            </a>
        <?php }
        ?>
    </div>
    <div class="container course__container">
        <?php
        $sheetSql = "SELECT `id`,`main_image`,`sheet_title`,`sheet_details`,`sheet_hide`,regular_price,offer_price FROM `sheets`where cat_id='$cat_id' ORDER BY id DESC";
        $sheetStmt = fetch_data($connection, $sheetSql);
        if ($sheetStmt) {
            if (mysqli_stmt_num_rows($sheetStmt) == 0) {
                header("location: " . LINK . "error/404");
                die();
            }
            mysqli_stmt_bind_result($sheetStmt, $id, $main_image, $sheet_title, $sheet_details, $sheet_hide, $regular_price, $offer_price);
            while (mysqli_stmt_fetch($sheetStmt)) {
                $sheet_title_link = str_replace(" ", "-", $sheet_title);
                if ($sheet_hide == 1) {
        ?>

                    <article class="course">
                        <div class="course__image">
                            <img src="<?=LINK;?>public/images/<?= $main_image; ?>">
                        </div>
                        <div class="course__info">
                            <h4><?= $sheet_title; ?></h4>
                            <?php if ($offer_price) { ?>
                                <h4>TK. <del style="color:red"><?= $regular_price; ?>৳</del> <span style="color:green"><?= $offer_price; ?>৳</span></h4>
                            <?php } else { ?>
                                <h4>TK. <span style="color:green"><?= $regular_price; ?>৳</span></h4>
                            <?php } ?>
                            <a href="sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>" class='my-btn green'>View Details</a>
                            <div class="my-btn share">
                                <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                Share with
                                <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share - marcoschool"></a>

                                <a target="" href="https://api.whatsapp.com/send?text=Sheet - <?= $sheet_title; ?>%0Ahttps://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share - marcoschool"></a>
                            </div>
                        </div>
                    </article>
        <?php
                }
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