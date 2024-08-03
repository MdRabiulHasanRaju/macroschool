<section id="course-desktop" class="courses">
    <h2>Our Popular Courses</h2>
    <div class="container course__container">
        <?php
        $courseSql = "SELECT `id`,`image`,`course_title`,`course_sub_title`,`course_details`,`course_hide` FROM `courses` ORDER BY id DESC limit 3";
        $courseStmt = fetch_data($connection, $courseSql);
        if ($courseStmt) {
            if (mysqli_stmt_num_rows($courseStmt) == 0) {
                header("location: " . LINK . "error/404");
                die();
            }
            mysqli_stmt_bind_result($courseStmt, $id, $image, $course_title,$course_sub_title, $course_details,$course_hide);
            while (mysqli_stmt_fetch($courseStmt)) {
                $course_title_link = str_replace(" ","-",$course_title);
                if($course_hide==1){
                ?>

                <article class="course">
                    <div class="course__image">
                        <img src="public/images/<?= $image; ?>">
                    </div>
                    <div class="course__info">
                        <h4><?= $course_sub_title; ?></h4>
                        <h4><?= $course_title; ?></h4>
                        <a href="course-details/<?=$id;?>/<?=$course_title_link;?>" class='my-btn'>See Details</a>
                        <div class="my-btn share">
                                <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                Share with
                                <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share- macroschool"></a>

                                <a target="" href="https://api.whatsapp.com/send?text=<?= $course_sub_title; ?>%20<?= $course_title; ?>%0Ahttps://macroschool.academy/course-details/<?= $id; ?>/<?= $course_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share- macroschool"></a>
                            </div>
                    </div>
                </article>
        <?php
            }}
        } ?>
    </div>
    <div class="container" style="text-align:center;width:200px;padding-top:20px;">
            <a style="display:block" class="my-btn green" href="<?= LINK; ?>courses">View All Courses</a>
    </div>
</section>