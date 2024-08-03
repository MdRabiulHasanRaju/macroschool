<section style="display:none;" class="slider-swiper-course" id="course-slider">
    <style>
        @media screen and (max-width:600px) {
            #course-slider {
                display: grid !important;
            }

            #course-desktop {
                display: none;
            }

            .course,
            .swiper-course {
                width: 300px;
                text-align: center
            }

            .slider-swiper-course {
                padding: 20px 0;
                display: grid;
                justify-content: center
            }

            .swiper-wrapper {
                text-align: center
            }

            .swiper-slide {
                background-position: center;
                background-size: cover
            }

            .swiper-pagination-course {
                color: #dc555b
            }

            .course {
                border-radius: 8px;
                background: #ededed;
            }

            .course__info>h4 {
                font-size: 10px !important
            }

            .my-btn-course {
                padding: 10px;
                font-size: 10px
            }

            .share.my-btn a img {
                width: 20px
            }

            .course__image>img {
                width: 200px;
                height: 200px
            }

            .course__image {
                display: grid;
                justify-content: center;
                padding: 10px
            }

            .course__info {
                padding: 1rem
            }
        }
    </style>
    <div class="container">
        <h2 style="text-align: center;margin-bottom: 10px;font-size: 20px;color: #dc555b;padding: 5px 0;box-shadow: 0px 3px 11px -11px black;">Our Popular Courses</h2>
        <div class="swiper-course">
            <div class="swiper-wrapper">
                <?php
                $courseSql = "SELECT `id`,`image`,`course_title`,`course_sub_title`,`course_details`,`course_hide` FROM `courses` ORDER BY id DESC";
                $courseStmt = fetch_data($connection, $courseSql);
                if ($courseStmt) {
                    if (mysqli_stmt_num_rows($courseStmt) == 0) {
                        header("location: " . LINK . "error/404");
                        die();
                    }
                    mysqli_stmt_bind_result($courseStmt, $id, $image, $course_title, $course_sub_title, $course_details, $course_hide);
                    while (mysqli_stmt_fetch($courseStmt)) {
                        $course_title_link = str_replace(" ", "-", $course_title);
                        if ($course_hide == 1) {
                ?>
                            <div class="swiper-slide">
                                <article class="course">
                                    <div class="course__image">
                                        <img src="public/images/<?= $image; ?>">
                                    </div>
                                    <div class="course__info">
                                        <h4><?= $course_sub_title; ?></h4>
                                        <h4><?= $course_title; ?></h4>
                                        <a href="course-details/<?= $id; ?>/<?= $course_title_link; ?>" class='my-btn my-btn-course'>See Details</a>
                                        <div class="my-btn share">
                                            <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                            Share with
                                            <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share- macroschool"></a>

                                            <a target="" href="https://api.whatsapp.com/send?text=<?= $course_sub_title; ?>%20<?= $course_title; ?>%0Ahttps://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share- macroschool"></a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                <?php
                        }
                    }
                } ?>

            </div>
            <div class="swiper-pagination-course"></div>
        </div>
    </div>

</section>
<script type="text/javascript">
    const swiperCourse = new Swiper('.swiper-course', {
        effect: 'cards',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',

        // Optional parameters
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination-course',
        },

        autoplay: {
            delay: 5000,
        },

    });
</script>