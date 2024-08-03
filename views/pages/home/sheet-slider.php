<section style="display:none;" class="slider-swiper-sheet" id="sheet-slider">
    <style>
        @media screen and (max-width:600px) {
            #sheet-slider {
                display: grid !important;
            }

            #sheet-desktop {
                display: none;
            }

            .swiper-sheet {
                margin-top: 1rem;
                width: 300px;
                text-align: center
            }

            .slider-swiper-sheet {
                padding: 20px 0;
                display: grid;
                justify-content: center
            }

            .swiper-pagination-sheet {
                color: #dc555b
            }

            .sheet {
                display: flex;
                align-items: center;
                background-color: #ededed;
                border-radius: 7px;
            }

            .sheet__image {
                padding: 5px;
            }
            
            .share {
                padding: 8px 10px !important;
            }

            .sheet__image>img {
                width: 100%;
                border: 2px solid #ededed;
            }
        }
    </style>
    <div class="container">
        <h2 style="text-align: center;margin-bottom: 10px;font-size: 20px;color: #dc555b;padding: 5px 0;box-shadow: 0px 3px 11px -11px black;">Our Popular Sheets</h2>
        <div class="swiper-sheet">
            <div class="swiper-wrapper">
                <?php
                $sheetSql = "SELECT `id`,`main_image`,`sheet_title`,`sheet_details`,`sheet_hide`,regular_price,offer_price FROM `sheets` ORDER BY id DESC";
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
                            <div class="swiper-slide">
                                <article class="sheet">
                                    <div class="sheet__image">
                                        <img src="public/images/<?= $main_image; ?>">
                                    </div>
                                    <div class="course__info">
                                        <h4><?= $sheet_title; ?></h4>
                                        <?php if ($offer_price) { ?>
                                            <h4>TK. <del style="color:red"><?= $regular_price; ?>৳</del> <span style="color:green"><?= $offer_price; ?>৳</span></h4>
                                        <?php } else { ?>
                                            <h4>TK. <span style="color:green"><?= $regular_price; ?>৳</span></h4>
                                        <?php } ?>
                                        <a href="sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>" class='my-btn green my-btn-course'>View Details</a>
                                        <div class="my-btn share">
                                            <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                            Share with
                                            <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share - marcoschool"></a>

                                            <a target="" href="https://api.whatsapp.com/send?text=Sheet - <?= $sheet_title; ?>%0Ahttps://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share - marcoschool"></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                <?php
                        }
                    }
                } ?>

            </div>
            <div class="swiper-pagination-sheet"></div>
        </div>
    </div>

</section>
<script type="text/javascript">
    const swiperSheet = new Swiper('.swiper-sheet', {
        effect: 'cube',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',

        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination-sheet',
        },

        autoplay: {
            delay: 5000,
        },

    });
</script>