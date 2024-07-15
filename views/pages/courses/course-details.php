<?php
ob_start();
session_start();
if (isset($_GET['id'])) {
    $course_id = $_GET["id"];
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

$title_sql = "select course_title from courses where id=$course_id";
$title_stmt = mysqli_prepare($connection, $title_sql);
mysqli_stmt_execute($title_stmt);
mysqli_stmt_store_result($title_stmt);
mysqli_stmt_bind_result($title_stmt, $course_title);
mysqli_stmt_fetch($title_stmt);

$title = "$course_title - Macro School";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Courses";

include("../../inc/header.php");

// include $_SERVER['DOCUMENT_ROOT']."/macroschool/views/pages/courses/admission-form.php";
?>

<style>
    .para {
        display: none;
    }
    .collapsed {
        display: block;
    }
</style>

<?php
$sql = "select * from courses where id=?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $param_id);
$param_id = $course_id;
if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: " . LINK . "error/404");
        die();
    } else {
        mysqli_stmt_bind_result(
            $stmt,
            $id,
            $cat_id,
            $faculties,
            $course_title,
            $course_sub_title,
            $course_details,
            $free_class_link,
            $faq,
            $image,
            $video_link,
            $total_student,
            $start_date,
            $course_duration,
            $total_class,
            $course_feature,
            $routine,
            $regular_price,
            $offer_price
        );
        if (mysqli_stmt_fetch($stmt)) { ?>
            <section class="container course-details">
                <div class="course-details-top">
                    <h1>Macro School Shop</h1>
                    <h2><?= $course_title; ?> - <?= $course_sub_title; ?></h2>
                </div>
                <div class="course-details-col">
                    <div class="course-details-col-1">
                        <h3>Faculties</h3>
                        <div class="course-details-faculties">
                            <?php
                            $teachers_link = array();
                            $teachers_name = array();
                            $faculties = explode(',', $faculties);
                            foreach ($faculties as $member_id) {
                                $faculties_sql = "select * from faculties where id=$member_id";
                                $faculties_stmt = mysqli_prepare($connection, $faculties_sql);
                                mysqli_stmt_execute($faculties_stmt);
                                mysqli_stmt_store_result($faculties_stmt);
                                mysqli_stmt_bind_result($faculties_stmt, $id, $name, $department, $faculties_image, $link);
                                mysqli_stmt_fetch($faculties_stmt);
                                array_push($teachers_name, $name);
                                array_push($teachers_link, $link);
                            ?>
                                <div class="faculti-member">
                                    <img src="<?= LINK; ?>public/images/<?= $faculties_image; ?>" id="faculti-image">
                                    <h5 class="teacher-name"><?= $name; ?></h5>
                                    <h5 class="teacher-department"><?= $department; ?></h5>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="course-details-about">
                            <h3>কোর্সটি সম্পর্কে</h3>
                            <p><?= $course_details; ?></p>
                        </div>
                        <div class="course-details-faq">
                            <h3>সচরাচর জিজ্ঞাসা :</h3>

                            <div class="course-details-faq-box">
                                <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                    কোর্সের ফিয়েচার
                                </p>
                                <div class="para" id="para">
                                    <div class="course-box-feature">
                                        <?php
                                        $course_feature = explode(',', $course_feature);
                                        foreach ($course_feature as $course_feature_data) { ?>
                                            <p><img src="<?= LINK; ?>public/images/icon/ok.png" alt="" class="icon"> <?= $course_feature_data; ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="course-details-faq-box">
                                <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                    কোর্স শিক্ষকের কাছে কোনো প্রশ্ন
                                </p>
                                <div class="para" id="para">
                                    <?php
                                    $i = 0;
                                    foreach ($teachers_link as $teacher_link) { ?>
                                        <a style="font-weight:bold;display:flex;gap: 10px;align-items: center;margin-bottom: 8px;" href="<?= $teacher_link; ?>" target="_blank">
                                            <img src="<?= LINK; ?>public/images/icon/facebook.png" class="icon" alt="">
                                            Click to Connect With
                                            <?= $teachers_name[$i]; ?>
                                            Sir
                                            <br>
                                        </a>
                                    <?php
                                        $i++;
                                    } ?>
                                </div>
                            </div>

                            <div class="course-details-faq-box">
                                <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                    Helpline
                                </p>
                                <div class="para" id="para">
                                    <a style="font-weight:bold;display:flex;gap: 10px;align-items: center;margin-bottom: 8px;" href="" target="_blank">
                                        <img src="<?= LINK; ?>public/images/icon/facebook.png" class="icon" alt="">
                                        Noyon
                                    </a>
                                    <p><strong>Contact: </strong>01879586258</p>
                                </div>
                            </div>

                            <div class="course-details-faq-box">
                                <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                    কোর্সটি কীভাবে কিনবো?
                                </p>
                                <div class="para" id="para">
                                    <p>বি.দ্র. কেনার পূর্বে অবশ্যই এই ভিডিওটি দেখে নাও : </p>
                                    <a href="https://www.youtube.com/@macroschool158" target="_blank" rel="noopener noreferrer">https://www.youtube.com/@macroschool158</a>
                                </div>
                            </div>

                            <div class="course-details-faq-box">
                                <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                    ফ্রি যাচাই ক্লাস
                                </p>
                                <div class="para" id="para">
                                    <iframe width="100%" height="230px" src="https://www.youtube-nocookie.com/embed/<?= $free_class_link; ?>?si=W1FHj9ufehV8p6jW&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="course-details-col-2">
                        <div class="course-box">
                            <?php
                            if (!trim($video_link)) { ?>
                                <img src="<?= LINK; ?>public/images/<?= $image; ?>" alt="course-details-image">
                            <?php } else { ?>
                                <iframe width="100%" height="230px" src="https://www.youtube-nocookie.com/embed/<?= $video_link; ?>?autoplay=1&amp;si=W1FHj9ufehV8p6jW&amp;controls=0" title="YouTube video player" frameborder="0" allow="autoplay ; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <?php  }
                            ?>


                            <div class="course-box-top">
                                <div class="total">
                                    <img src="<?= LINK; ?>public/images/icon/student.png" alt="" class="icon">
                                    <p>কোর্সটিতে ভর্তি হয়েছেন <strong><?= $total_student; ?></strong> জন</p>
                                </div>
                                <div class="time">
                                    <img src="<?= LINK; ?>public/images/icon/alarm.png" alt="" class="icon">
                                    <p>ক্লাস শুরু <?= $start_date; ?></p>
                                </div>
                            </div>
                            <div class="course-box-top">
                                <div class="total">
                                    <img src="<?= LINK; ?>public/images/icon/hourglass.png" alt="" class="icon">
                                    <p>কোর্স সময়কাল <?= $course_duration; ?></p>
                                </div>
                                <div class="time">
                                    <img src="<?= LINK; ?>public/images/icon/abacus.png" alt="" class="icon">
                                    <p>ক্লাস সংখ্যা <?= $total_class; ?></p>
                                </div>
                            </div>

                            <div class="course-box-bottom">
                                <a href="<?= $routine; ?>" class="my-btn">Download Class Routine</a>
                            </div>
                        </div>
                        <div class="price-box">
                            <h3>Price: <del style="color:red"><?= $regular_price; ?>৳</del> <span style="color:green"><?= $offer_price; ?>৳</span></h3>
                            <div class="course-box-bottom">
                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                                    <button class="my-btn green">কোর্সটিতে এনরোল করো</button>
                                <?php } else { ?>
                                    <a href="<?= LINK; ?>admission">
                                        <button class="my-btn green">কোর্স কিনতে লগইন করো</button>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php
        }
    }
}
?>

<?php
include("../../inc/footer.php");
ob_end_flush();
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>