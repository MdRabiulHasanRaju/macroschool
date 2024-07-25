<?php
$title = "Macro School Admin - Edit Course";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "All Course";
?>

<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {
    include("../../inc/header.php");
?>

<?php
if(isset($_GET['id'])){
    $course_id = $_GET['id'];
}
else{
    header("location: ".LINK."error/404");
}
?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Edit Course</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Your Course Information</h5>
                </div>

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
                        if (mysqli_stmt_fetch($stmt)) {?>

                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/editCourseController.php" method="post" enctype="multipart/form-data">
                            <input name="course_id" type="hidden" value="<?=$course_id;?>">
                        <div class="form-group">
                            <label for="teachers">Teachers <span style="color:red;">*</span></label>
                            <select class="form-control" name="teachers" id="teachers">
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
                                <option value="<?= $id; ?>" selected><?= $name; ?>, <?= $department; ?></option>
                                            <?php } ?>
                                <?php
                                $Sql = "SELECT * FROM `faculties`";
                                $Stmt = fetch_data($connection, $Sql);
                                mysqli_stmt_bind_result($Stmt, $id, $name, $department, $teacher_image, $link);
                                while (mysqli_stmt_fetch($Stmt)) {
                                ?>
                                    <option value="<?= $id; ?>">
                                        <?= $name; ?>,
                                        <?= $department; ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="courseName">Course Name <span style="color:red;">*</span></label>
                            <input value="<?=$course_title;?>" id="courseName" name="courseName" type="text" class="form-control" placeholder="Enter Course Name" required>
                        </div>

                        <div class="form-group">
                            <label for="batch">Batch <span style="color:red;">*</span></label>
                            <input value="<?=$course_sub_title;?>" id="batch" name="batch" type="text" class="form-control" placeholder="Enter Batch" required>
                        </div>

                        <div class="form-group">
                            <label for="courseDetails">Course Details <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="courseDetails" id="courseDetails" placeholder="Enter Course Details" required><?=$course_details;?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="freeClassLink">Free Youtube Class Link <span style="color:red;">*</span></label>
                                    <input value="<?=$free_class_link;?>" id="freeClassLink" name="freeClassLink" type="text" class="form-control" placeholder="Ex: U_pEbb_cX_o" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Course Image <span style="color:red;">*</span></label>
                            <img src="<?=IMAGE_LINK;?><?=$image;?>" alt="">
                            <input type="hidden" value="<?=$image;?>" name="prev_image">
                            <input id="image" name="image" type="file" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="videoLink">Featured Youtube Video Link</label>
                            <input value="<?=$video_link;?>" id="videoLink" name="videoLink" type="text" class="form-control" placeholder="Ex: U_pEbb_cX_o">
                        </div>

                        <div class="form-group">
                            <label for="startDate">Start Date <span style="color:red;">*</span></label>
                            <input value="<?=$start_date;?>" id="startDate" name="startDate" type="text" class="form-control" placeholder="Ex: ১ আগস্ট" required>
                        </div>

                        <div class="form-group">
                            <label for="courseDuration">Course Duration <span style="color:red;">*</span></label>
                            <input value="<?=$course_duration;?>" id="courseDuration" name="courseDuration" type="text" class="form-control" placeholder="Ex: ৭ মাস" required>
                        </div>

                        <div class="form-group">
                            <label for="totalNumberofClass">Total Number of Class <span style="color:red;">*</span></label>
                            <input value="<?=$total_class;?>" id="totalNumberofClass" name="totalNumberofClass" type="text" class="form-control" placeholder="Ex: ৭৫" required>
                        </div>

                        <div class="form-group">
                            <label for="courseFeature">Course Feature <span style="color:red;">*</span></label>
                            <input value="<?=$course_feature;?>" id="courseFeature" name="courseFeature" type="text" class="form-control" placeholder="Ex: ক্লাস সংখ্যা ১৪০+,সাপ্তাহিক পরীক্ষা,পেপার ফাইনাল,..." required>
                        </div>

                        <div class="form-group">
                            <label for="routineLink">Routine Link <span style="color:red;">*</span></label>
                            <input value="<?=$routine;?>" id="routineLink" name="routineLink" type="text" class="form-control" placeholder="Enter Routine Link" required>
                        </div>

                        <div class="form-group">
                            <label for="materialsLink">Materials Link <span style="color:red;">*</span></label>
                            <input value="<?=$materials_link;?>" id="materialsLink" name="materialsLink" type="text" class="form-control" placeholder="Enter Materials Link" required>
                        </div>

                        <div class="form-group">
                            <label for="facebookPrivateLink">Facebook Private Group Link <span style="color:red;">*</span></label>
                            <input value="<?=$facebook_link;?>" id="facebookPrivateLink" name="facebookPrivateLink" type="text" class="form-control" placeholder="Enter Facebook Private Group Link" required>
                        </div>

                        <div class="form-group">
                            <label for="regularPrice">Regular Price <span style="color:red;">*</span></label>
                            <input value="<?=$regular_price;?>" id="regularPrice" name="regularPrice" type="number" class="form-control" placeholder="Enter Regular Price" required>
                        </div>

                        <div class="form-group">
                            <label for="offerPrice">Offer Price <span style="color:red;">*</span></label>
                            <input value="<?=$offer_price;?>" id="offerPrice" name="offerPrice" type="number" class="form-control" placeholder="Enter Offer Price" required>
                        </div>

                        <div class="form-group">
                            <input value="Save Changes" id="submit" class="form-control my-btn" name="submit" type="submit">
                        </div>

                    </form>
                </div>


                <?php   }
                    }
                } ?>


            </div>
        </div>
    </div>

</div>

<?php
include("../../inc/footer.php");
} else {
	header("location: " . ADMIN_LINK . "login");
	die();
}
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
</body>

</html>