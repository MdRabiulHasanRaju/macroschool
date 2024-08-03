<style>
    .sheet {
        display: flex;
        align-items: center;
        background-color: #ededed;
        border-radius: 7px;
        padding: 0 10px;
        gap:10px;
    }

    .sheet__image {
        padding: 5px;
    }

    .sheet__info>h4 {
        font-size: 13px;
        margin: 8px 0;
    }

    .sheet__info>a {
        font-size: 12px;
        display: block;
    }

    .share {
        padding: 8px 3px !important;
        font-size: 12px;
    }

    .share.my-btn a img {
        width: 26px;
    }

    .sheet__image>img {
        width: 100%;
        border: 2px solid #ededed;
    }
</style>
<section id="course-desktop" class="courses">
    <h2>Our Popular Sheets</h2>
    <div class="container course__container">
        <?php
        $sheetSql = "SELECT `id`,`main_image`,`sheet_title`,`sheet_details`,`sheet_hide`,regular_price,offer_price FROM `sheets` ORDER BY id DESC limit 3";
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

                    <article class="sheet">
                        <div class="sheet__image">
                            <img src="public/images/<?= $main_image; ?>">
                        </div>
                        <div class="sheet__info">
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
        <div class="container" style="text-align:center;width:200px;padding-top:20px;">
            <a style="display:block" class="my-btn green" href="<?= LINK; ?>sheets">View All Sheets</a>
        </div>

</section>