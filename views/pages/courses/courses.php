<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Courses";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Courses";

include("../../inc/header.php");

?>

<style>
    .courses {
        margin-top: 1rem;
    }
</style>
<section class="courses">
    <div class="container course-category-list">
        <a href="<?= LINK; ?>courses" class="course-active">All Courses</a>
        <?php
        $cat_sql = "select * from course_category";
        $cat_stmt = fetch_data($connection, $cat_sql);
        mysqli_stmt_bind_result($cat_stmt, $cat_id_, $cat_name_);
        while (mysqli_stmt_fetch($cat_stmt)) { ?>
            <a href="<?= LINK; ?>courses/<?= $cat_id_; ?>/<?= $cat_name_; ?>">
                <?= $cat_name_; ?>
            </a>
        <?php }
        ?>
    </div>
    <div class="container course__container">
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
                $course_title_link = str_replace(" ","-",$course_title);
                if ($course_hide == 1) {
        ?>

                    <article class="course">
                        <div class="course__image">
                            <img src="public/images/<?= $image; ?>">
                        </div>
                        <div class="course__info">
                            <h4><?= $course_sub_title; ?></h4>
                            <h4><?= $course_title; ?></h4>
                            <a href="course-details/<?= $id; ?>/<?= $course_title_link; ?>" class='my-btn'>See Details</a>
                            <div class="my-btn share">
                                <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                Share with
                                <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share- macroschool"></a>

                                <a target="" href="https://api.whatsapp.com/send?text=<?= $course_sub_title; ?>%20<?= $course_title; ?>%0Ahttps://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share- macroschool"></a>
                            </div>
                        </div>
                    </article>
        <?php
                }
            }
        } ?>
    </div>
</section>

<section class="videos">
    <div class="video-gallery-container">
        <h2 class="title">Free Courses</h2>
        <div class="video-gallery">
            <div class="featured-video">
                <div class="responsive-iframe">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/H_EylIzK3Oc?si=oNveFUhuJJmjua1R" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <h3 class="video-title">ম্যাট্রিক্স ও নির্ণায়ক || Matrix and Determinate | Lecture 02 | HSC Math 1st Paper</h3>
            </div>
            <div class="all-videos">
                <div class="video">
                    <img class="thumbnail" data-id="H_EylIzK3Oc?si=oNveFUhuJJmjua1R" data-title="ম্যাট্রিক্স ও নির্ণায়ক || Matrix and Determinate | Lecture 02 | HSC Math 1st Paper" src="public/images/thumbnail1.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="Qx2x8xi-mI0?si=41947hC9Icmtfhsx" data-title="CLASS-01|| ICT || Chapter 3.1 || Lecture - 01|| সংখ্যা পদ্ধতি কী ও এর প্রকারভেদ
                        " src="public/images/thumbnail2.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="ET5bjMFfYt8?si=J9UZm6WYuLZnbty3" data-title="2.01| রাশি ও এর প্রকারভেদ । স্কেলার ও ভেক্টর রাশি । ভেক্টর । পদার্থবিজ্ঞান ১ম পত্র
                    " src="public/images/thumbnail3.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>
                <div class="video">
                    <img class="thumbnail" data-id="wZ9JqLGbgt8?si=zvLYf1kLF5oyfGly" data-title="হাইড্রা - ০১ | Hydra -01 | Hsc Zoology || MACRO School | Mizan Sir" src="public/images/thumbnail4.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="H72tpMtf0Sc?si=bCMz9GWJWPBl68zP" data-title="জটিল সংখ্যা ॥ Lecture 01 ॥ Complex Number ॥ HSC Math- Shahel Hossain" src="public/images/thumbnail5.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="TNfBUeB8dog?si=zj5tIJXTCYuchSF4" data-title="বৃত্ত (Circle) ॥ Lecture 01 ॥ Higher Math 1st Paper ॥ Shahel Hossain" src="public/images/thumbnail6.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="Irbi17AmpWA?si=tcStJAEEvwZzG-zq" data-title="কোষ প্রাচীর | Cell Wall। Chapter-1 | কোষ ও এর গঠন । Biology | HSC Academic" src="public/images/thumbnail7.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>

                <div class="video">
                    <img class="thumbnail" data-id="WRNAz4QGFdw?si=qIo9VlNP0K0HfqwK" data-title="হ্যাপ্লয়েড ও ডিপ্লয়েড | Haploid Deploid ।Bootany। Chapter-1 | কোষ ও এর গঠন । Biology | HSC Academic" src="public/images/thumbnail8.jpg">

                    <div class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>