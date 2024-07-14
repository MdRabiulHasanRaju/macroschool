<section class="courses">
    <h2>Our Popular Courses</h2>
    <div class="container course__container">
        <?php
        $courseSql = "SELECT `id`,`image`,`course_title`,`course_details` FROM `courses` ORDER BY id DESC";
        $courseStmt = fetch_data($connection, $courseSql);
        if ($courseStmt) {
            if (mysqli_stmt_num_rows($courseStmt) == 0) {
                header("location: " . LINK . "error/404");
                die();
            }
            mysqli_stmt_bind_result($courseStmt, $id, $image, $course_title, $course_details);
            while (mysqli_stmt_fetch($courseStmt)) { ?>

                <article class="course">
                    <div class="course__image">
                        <img src="public/images/<?= $image; ?>">
                    </div>
                    <div class="course__info">
                        <h4><?= $course_title; ?></h4>
                        <p>
                            <?= $format->short_text($course_details, 200); ?>
                        </p>
                        <a href="course-details/<?=$id;?>" class='my-btn'>Enroll Now</a>
                    </div>
                </article>
        <?php
            }
        } ?>
    </div>
</section>