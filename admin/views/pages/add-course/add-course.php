<?php
$title = "Macro School Admin - Add Course";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Add Course";
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
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Add Course</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Course</h5>
                </div>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addCourseController.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="teachers">Teachers <span style="color:red;">*</span></label>
                            <select class="form-control" name="teachers" id="teachers">
                                <option selected disabled> - Choose Course Teacher</option>
                                <?php
                                $Sql = "SELECT * FROM `faculties`";
                                $Stmt = fetch_data($connection, $Sql);
                                mysqli_stmt_bind_result($Stmt, $id, $name, $department, $image, $link);
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
                            <input id="courseName" name="courseName" type="text" class="form-control" placeholder="Enter Course Name" required>
                        </div>

                        <div class="form-group">
                            <label for="course_category">Course Category <span style="color:red;">*</span></label>
                            <select class="form-control" name="course_category" id="course_category">
                                <option selected disabled> - Choose Course Category</option>
                                <?php
                                $Sql = "SELECT * FROM `course_category`";
                                $Stmt = fetch_data($connection, $Sql);
                                mysqli_stmt_bind_result($Stmt, $id, $cat_name);
                                while (mysqli_stmt_fetch($Stmt)) {
                                ?>
                                    <option value="<?= $id; ?>">
                                        <?= $cat_name; ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="batch">Batch <span style="color:red;">*</span></label>
                            <input id="batch" name="batch" type="text" class="form-control" placeholder="Enter Batch" required>
                        </div>

                        <div class="form-group">
                            <label for="courseDetails">Course Details <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="courseDetails" id="courseDetails" placeholder="Enter Course Details" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="freeClassLink">Free Youtube Class Link <span style="color:red;">*</span></label>
                            <input id="freeClassLink" name="freeClassLink" type="text" class="form-control" placeholder="Ex: U_pEbb_cX_o" required>
                        </div>

                        <div class="form-group">
                            <label for="image">Course Image <span style="color:red;">*</span></label>
                            <input id="image" name="image" type="file" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="videoLink">Featured Youtube Video Link</label>
                            <input id="videoLink" name="videoLink" type="text" class="form-control" placeholder="Ex: U_pEbb_cX_o">
                        </div>

                        <div class="form-group">
                            <label for="startDate">Start Date <span style="color:red;">*</span></label>
                            <input id="startDate" name="startDate" type="text" class="form-control" placeholder="Ex: ১ আগস্ট" required>
                        </div>

                        <div class="form-group">
                            <label for="courseDuration">Course Duration <span style="color:red;">*</span></label>
                            <input id="courseDuration" name="courseDuration" type="text" class="form-control" placeholder="Ex: ৭ মাস" required>
                        </div>

                        <div class="form-group">
                            <label for="totalNumberofClass">Total Number of Class <span style="color:red;">*</span></label>
                            <input id="totalNumberofClass" name="totalNumberofClass" type="text" class="form-control" placeholder="Ex: ৭৫" required>
                        </div>

                        <div class="form-group">
                            <label for="courseFeature">Course Feature <span style="color:red;">*</span></label>
                            <input id="courseFeature" name="courseFeature" type="text" class="form-control" placeholder="Ex: ক্লাস সংখ্যা ১৪০+,সাপ্তাহিক পরীক্ষা,পেপার ফাইনাল,..." required>
                        </div>

                        <div class="form-group">
                            <label for="routineLink">Routine Link <span style="color:red;">*</span></label>
                            <input id="routineLink" name="routineLink" type="text" class="form-control" placeholder="Enter Routine Link" required>
                        </div>

                        <div class="form-group">
                            <label for="materialsLink">Materials Link <span style="color:red;">*</span></label>
                            <input id="materialsLink" name="materialsLink" type="text" class="form-control" placeholder="Enter Materials Link" required>
                        </div>

                        <div class="form-group">
                            <label for="facebookPrivateLink">Facebook Private Group Link <span style="color:red;">*</span></label>
                            <input id="facebookPrivateLink" name="facebookPrivateLink" type="text" class="form-control" placeholder="Enter Facebook Private Group Link" required>
                        </div>

                        <div class="form-group">
                            <label for="regularPrice">Regular Price <span style="color:red;">*</span></label>
                            <input id="regularPrice" name="regularPrice" type="number" class="form-control" placeholder="Enter Regular Price" required>
                        </div>

                        <div class="form-group">
                            <label for="offerPrice">Offer Price <span style="color:red;">*</span></label>
                            <input id="offerPrice" name="offerPrice" type="number" class="form-control" placeholder="Enter Offer Price" required>
                        </div>

                        <div class="form-group">
                            <input value="Add Course" id="submit" class="form-control my-btn" name="submit" type="submit">
                        </div>

                    </form>
                </div>
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