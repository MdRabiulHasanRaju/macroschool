<?php ob_start();
session_start();
// if (isset($_GET['id'])) {
//     $course_id = $_GET["id"];
// }
$course_id = 1;
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
    #para {
        display: block;
    }

    .collapsed {
        display: none !important;
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
            $course_details,
            $faq,
            $image,
            $total_student,
            $deadline,
            $course_info,
            $routine,
            $regular_price,
            $offer_price
        );
        if (mysqli_stmt_fetch($stmt)) { ?>
            <section class="container course-details">
                <div class="course-details-top">
                    <h1>Macro School Shop</h1>
                    <h2><?= $course_title; ?></h2>
                </div>
                <div class="course-details-col">
                    <div class="course-details-col-1">
                        <h3>Faculties</h3>
                        <div class="course-details-faculties">
                            <?php
                            $faculties = explode(',', $faculties);
                            foreach ($faculties as $member_id) {
                                $faculties_sql = "select * from faculties where id=$member_id";
                                $faculties_stmt = mysqli_prepare($connection, $faculties_sql);
                                mysqli_stmt_execute($faculties_stmt);
                                mysqli_stmt_store_result($faculties_stmt);
                                mysqli_stmt_bind_result($faculties_stmt, $id, $name, $department, $image);
                                mysqli_stmt_fetch($faculties_stmt); ?>
                                <div class="faculti-member">
                                    <img src="public/images/<?= $image; ?>" id="faculti-image">
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
                            <?php
                            $faq = explode(',', $faq);
                            foreach ($faq as $faq_id) {
                                $faq_sql = "select * from faq where id=$faq_id";
                                $faq_stmt = mysqli_prepare($connection, $faq_sql);
                                mysqli_stmt_execute($faq_stmt);
                                mysqli_stmt_store_result($faq_stmt);
                                mysqli_stmt_bind_result($faq_stmt, $id, $question, $answer);
                                mysqli_stmt_fetch($faq_stmt); ?>
                                <div class="course-details-faq-box">
                                    <p class="questionClick"><img class="icon" src="public/images/icon/dropdown.png"><?= $question; ?></p>
                                    <div class="para" id="para">
                                        <?= $answer; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="course-details-col-2">
                        <div class="course-box">
                            <img src="public/images/Hm course 2.jpg">
                            <div class="course-box-top">
                                <div class="total">
                                    <img src="public/images/icon/people.png" alt="" class="icon">
                                    <p>কোর্সটি করছেন <strong><?= $total_student; ?></strong></p>
                                </div>
                                <div class="time">
                                    <img src="public/images/icon/time.png" alt="" class="icon">
                                    <p><?= $deadline; ?></p>
                                </div>
                            </div>
                            <div class="course-box-middle">
                                <?php
                                $course_info = explode(',', $course_info);
                                foreach ($course_info as $course_info_id) {
                                    $course_info_sql = "select * from course_info where id=$course_info_id";
                                    $course_info_stmt = mysqli_prepare($connection, $course_info_sql);
                                    mysqli_stmt_execute($course_info_stmt);
                                    mysqli_stmt_store_result($course_info_stmt);
                                    mysqli_stmt_bind_result($course_info_stmt, $id, $title, $number);
                                    mysqli_stmt_fetch($course_info_stmt); ?>
                                    <p><img src="public/images/icon/ok.png" alt="" class="icon"> <?= $title; ?> <?= $number; ?></p>
                                <?php } ?>
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