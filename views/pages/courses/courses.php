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
        while (mysqli_stmt_fetch($cat_stmt)) {
            $get_cat_name = str_replace(" ", "_", $cat_name_); ?>
            <a href="<?= LINK; ?>courses/<?= $cat_id_; ?>/<?= $get_cat_name; ?>">
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
                $course_title_link = str_replace(" ", "-", $course_title);
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
            <?php
            $Sql = "select * from free_course";
            $Stmt = fetch_data($connection, $Sql);
            if (mysqli_stmt_num_rows($Stmt) == 0) {
            } else {
                mysqli_stmt_bind_result(
                    $Stmt,
                    $id,
                    $yt_link,
                ); 
                mysqli_stmt_fetch($Stmt);?>
                <div class="featured-video">
                    <div class="responsive-iframe">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?= $yt_link; ?>?si=W1FHj9ufehV8p6jW&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="all-videos">
                    <?php while (mysqli_stmt_fetch($Stmt)) { ?>

                        <div class="video">
                            <img class="thumbnail" data-id="<?= $yt_link; ?>" src="http://img.youtube.com/vi/<?= $yt_link; ?>/hqdefault.jpg">

                            <div class="play-icon">
                                <i class="fa-solid fa-play"></i>
                            </div>
                        </div>
                <?php }
                } ?>

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