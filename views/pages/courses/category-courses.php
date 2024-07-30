<?php ob_start();
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Course Category";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Courses";

include("../../inc/header.php");
if (isset($_GET['cat_name']) && isset($_GET['cat_id'])) {
    $cat_id = htmlspecialchars($_GET['cat_id']);
    $cat_name = htmlspecialchars($_GET['cat_name']);
} else {
    header("location: " . LINK . "404");
}
?>

<style>
    .courses {
        margin-top: 1rem;
    }
</style>
<section class="courses">
    <div class="container course-category-list">
        <a href="<?= LINK; ?>courses">All Courses</a>
        <?php
        $cat_sql = "select * from course_category";
        $cat_stmt = fetch_data($connection, $cat_sql);
        mysqli_stmt_bind_result($cat_stmt, $cat_id_, $cat_name_);
        while (mysqli_stmt_fetch($cat_stmt)) { ?>
            <a <?php
            if (isset($cat_name) && $cat_name == $cat_name_) {
              echo "class='course-active'";
            } ?> href="<?= LINK; ?>courses/<?= $cat_id_; ?>/<?= $cat_name_; ?>">
                <?= $cat_name_; ?>
            </a>
        <?php }
        ?>
    </div>
    <div class="container course__container">
        <?php
        $courseSql = "SELECT `id`,`image`,`course_title`,`course_sub_title`,`course_details`,`course_hide` FROM `courses`where cat_id='$cat_id' ORDER BY id DESC";
        $courseStmt = fetch_data($connection, $courseSql);
        if ($courseStmt) {
            if (mysqli_stmt_num_rows($courseStmt) == 0) {
                header("location: " . LINK . "404");
                die();
            }
            mysqli_stmt_bind_result($courseStmt, $id, $image, $course_title, $course_sub_title, $course_details, $course_hide);
            while (mysqli_stmt_fetch($courseStmt)) {
                $course_title_link = str_replace(" ","-",$course_title);
                if ($course_hide == 1) {
        ?>

                    <article class="course">
                        <div class="course__image">
                            <img src="<?= LINK; ?>public/images/<?= $image; ?>">
                        </div>
                        <div class="course__info">
                            <h4><?= $course_sub_title; ?></h4>
                            <h4><?= $course_title; ?></h4>
                            <a href="<?= LINK; ?>course-details/<?= $id; ?>/<?= $course_title_link; ?>" class='my-btn'>See Details</a>
                            <div class="my-btn share">
                                <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="">
                                Share with
                                <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/course-details/<?= $id; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt=""></a>

                                <a target="" href="https://api.whatsapp.com/send?text=<?= $course_sub_title; ?>%20<?= $course_title; ?>%0Ahttps://macroschool.academy/course-details/<?= $id; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt=""></a>
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