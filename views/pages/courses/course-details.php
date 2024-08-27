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
            $course_hide,
            $image,
            $video_link,
            $total_student,
            $start_date,
            $course_duration,
            $total_class,
            $course_feature,
            $routine,
            $regular_price,
            $offer_price,
            $materials_link,
            $facebook_link
        );
        if (mysqli_stmt_fetch($stmt)) { ?>
            <section class="container course-details">
                <div class="course-details-top">
                    <h1>Macro School Shop</h1>
                    <h2><?= $course_title; ?> - <?= $course_sub_title; ?></h2>
                </div>
                <div class="course-details-col">
                    <div class="course-details-col-1">
                        <h3>Teacher - </h3>
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

                            <?php
                            $sql = "select * from course_utility";
                            $stmt = mysqli_prepare($connection, $sql);
                            if (mysqli_stmt_execute($stmt)) {
                                mysqli_stmt_store_result($stmt);
                                if (mysqli_stmt_num_rows($stmt) == 0) {
                                    header("location: " . LINK . "error/404");
                                    die();
                                } else {
                                    mysqli_stmt_bind_result(
                                        $stmt,
                                        $id,
                                        $hlp_name,
                                        $hlp_link,
                                        $hlp_contact,
                                        $buy_course_link,
                                        $bkash_pay
                                    );
                                    if (mysqli_stmt_fetch($stmt)) { ?>

                                        <div class="course-details-faq-box">
                                            <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                                Helpline
                                            </p>
                                            <div class="para" id="para">
                                                <a style="font-weight:bold;display:flex;gap: 10px;align-items: center;margin-bottom: 8px;" href="<?= $hlp_link; ?>" target="_blank">
                                                    <img src="<?= LINK; ?>public/images/icon/facebook.png" class="icon" alt="">
                                                    <?= $hlp_name; ?>
                                                </a>
                                                <p><strong>Contact: </strong><?= $hlp_contact; ?></p>
                                            </div>
                                        </div>

                                        <div class="course-details-faq-box">
                                            <p class="questionClick"><img class="icon" src="<?= LINK; ?>public/images/icon/dropdown.png">
                                                কোর্সটি কীভাবে কিনবো?
                                            </p>
                                            <div class="para" id="para">
                                                <p>বি.দ্র. কেনার পূর্বে অবশ্যই এই ভিডিওটি দেখে নাও : </p>
                                                <a href="<?= $buy_course_link; ?>" target="_blank" rel="noopener noreferrer"><?= $buy_course_link; ?></a>
                                            </div>
                                        </div>
                            <?php }
                                }
                            } ?>

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
                                    <?php
                                    $orderSql = "select id from `order` where status=2 and course_id='$course_id'";
                                    $orderStmt = fetch_data($connection, $orderSql);
                                    $total_student = mysqli_stmt_num_rows($orderStmt);
                                    ?>
                                    <img src="<?= LINK; ?>public/images/icon/student.png" alt="" class="icon">
                                    <p>কোর্সটিতে ভর্তি হয়েছেন <strong><?= $format->englishToBangla($total_student); ?></strong> জন</p>
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
                            <?php if ($offer_price && !(isset($_COOKIE['offer_price_id']) && $course_id == $_COOKIE['offer_price_id'])) { ?>
                                <form style="margin-bottom:10px" id="coupon_form" action="" method="post">
                                    <div style="display:flex;justify-content:center;gap:5px;" class="coupon-code">
                                        <input id="coupon_course_id" class="input-form" type="hidden" name="coupon_course_id" value="<?= $course_id; ?>">

                                        <input id="coupon_code" name="coupon_code" class="input-form" style="border:1px solid #dbdbdb;width:80%;border-radius:5px" type="text" placeholder="Enter Coupon Code" />

                                        <button type="submit" id="coupon_submit" name="submit" class="my-btn blue" style="padding:5px 10px">Apply</button>
                                    </div>
                                </form>
                                <span id="alertMessage"></span>
                                <style>
                                    .coupon-remove-btn {
                                        padding: 5px 8px;
                                        background: red;
                                        color: white;
                                        font-weight: bold;
                                        border-radius: 5px;
                                        display: none;
                                        margin: 0 auto;
                                        margin-bottom: 8px;
                                    }

                                    .coupon-remove-btn:hover {
                                        color: red;
                                        background-color: white;
                                        border: 1px solid red;
                                    }
                                </style>
                                <button id="couponRemoveBtn1" class="coupon-remove-btn">Remove Coupon Code</button>

                            <?php } ?>
                            <?php if ($offer_price) { ?>
                                <?php
                                if (isset($_COOKIE['offer_price_id']) && $course_id == $_COOKIE['offer_price_id']) {
                                    echo "<span id='coupon_applied' style='color:blue;'>Coupon Code Already Applied</span>"; ?>
                                    <br>
                                    <style>
                                        .coupon-remove-btn {
                                            padding: 5px 8px;
                                            background: red;
                                            color: white;
                                            font-weight: bold;
                                            border-radius: 5px;
                                            margin-bottom: 8px;
                                        }

                                        .coupon-remove-btn:hover {
                                            color: red;
                                            background-color: white;
                                            border: 1px solid red;
                                        }
                                    </style>
                                    <button id="couponRemoveBtn2" class="coupon-remove-btn">Remove Coupon Code</button>
                                <?php }
                                ?>
                                <h3 style="margin-bottom: 15px;">Price: <del style="color:red"><?= $regular_price; ?>৳</del>
                                    <span style="color:green">
                                        <span id="offer_price">
                                            <?php
                                            if (isset($_COOKIE['offer_price_id']) && $course_id == $_COOKIE['offer_price_id']) {
                                                echo $_COOKIE['offer_price'];
                                            } else {
                                                echo $offer_price;
                                            }
                                            ?>
                                        </span>৳
                                    </span>
                                </h3>
                            <?php } else { ?>
                                <h3 style="margin-bottom: 15px;">Price: <span style="color:green"><?= $regular_price; ?>৳</span></h3>
                            <?php } ?>
                            <script>
                                function getCookie(cookieName) {
                                    let cookies = document.cookie;
                                    let cookieArray = cookies.split("; ");

                                    for (let i = 0; i < cookieArray.length; i++) {
                                        let cookie = cookieArray[i];
                                        let [name, value] = cookie.split("=");

                                        if (name === cookieName) {
                                            return decodeURIComponent(value);
                                        }
                                    }

                                    return null;
                                }
                                let removeCoupon1 = document.getElementById("couponRemoveBtn1");
                                let removeCoupon2 = document.getElementById("couponRemoveBtn2");
                                let coupon_form1 = document.getElementById("coupon_form");
                                let alertMessage1 = document.getElementById("alertMessage");
                                let offer_price1 = document.getElementById("offer_price");
                                let coupon_applied = document.getElementById("coupon_applied");

                                const couponRemoveHandler = (e) => {
                                    let change_offer_price = Number(offer_price1.childNodes[0].data) + Number(getCookie("discount_price"));
                                    offer_price1.innerHTML = change_offer_price;
                                    document.cookie = `offer_price=; max-age=-1; path=/`;
                                    document.cookie = `offer_price_id=; max-age=-1; path=/`;
                                    document.cookie = `coupon_code=; max-age=-1; path=/`;
                                    document.cookie = `discount_price=; max-age=-1; path=/`;

                                    if (removeCoupon1) removeCoupon1.style.display = "none";
                                    if (removeCoupon2) removeCoupon2.style.display = "none";
                                    if (coupon_applied) coupon_applied.style.display = "none";
                                    if (alertMessage1) alertMessage1.innerHTML = "";
                                    if (coupon_form1) coupon_form1.style.display = "block";

                                }
                                if (removeCoupon1) removeCoupon1.addEventListener("click", couponRemoveHandler);
                                if (removeCoupon2) removeCoupon2.addEventListener("click", couponRemoveHandler);
                            </script>
                            <script src="<?= LINK; ?>views/pages/courses/coupon.js"></script>
                            <div class="course-box-bottom">
                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

                                    $double_ordered_check_sql = "select course_id from `order` where user_id=?";
                                    $double_ordered_check_stmt = mysqli_prepare($connection, $double_ordered_check_sql);
                                    mysqli_stmt_bind_param($double_ordered_check_stmt, "i", $param_double_ordered_check_id);
                                    $param_double_ordered_check_id = $_SESSION['id'];
                                    mysqli_stmt_execute($double_ordered_check_stmt);
                                    mysqli_stmt_store_result($double_ordered_check_stmt);
                                    mysqli_stmt_bind_result($double_ordered_check_stmt, $double_ordered_check_course_id);
                                    if (mysqli_stmt_num_rows($double_ordered_check_stmt) > 0) {
                                        while (mysqli_stmt_fetch($double_ordered_check_stmt)) {
                                            if ($course_id == $double_ordered_check_course_id) {
                                                $ordered_course = "আপনি কোর্সটি অর্ডার করে ফেলেছেন।";
                                            }
                                        }
                                    }

                                    if (isset($ordered_course)) { ?>
                                        <p><?= $ordered_course; ?></p>
                                        <a href="<?= LINK; ?>dashboard" class="my-btn green">Goto Dashboard</a>
                                    <?php } else { ?>
                                        <a href="<?= LINK; ?>order/<?= $course_id; ?>" class="my-btn green">কোর্সটিতে এনরোল করো</a>
                                    <?php }
                                } else { ?>
                                    <a href="<?= LINK; ?>login">
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