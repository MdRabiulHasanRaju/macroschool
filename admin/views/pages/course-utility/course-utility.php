<?php
$title = "Macro School Admin - Course Utility";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Course Utility";
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

    <h1 class="h3 mb-3">Course Utility</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"> Helpline and How to Buy a Course - Information</h5>
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
                        if (mysqli_stmt_fetch($stmt)) {?>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/courseUtilityController.php" method="post" enctype="multipart/form-data">

                    <input name="utility_id" type="hidden" value="<?=$id;?>">

                        <div class="form-group">
                            <label for="hlp_name">Name - Helpline <span style="color:red;">*</span></label>
                            <input value="<?=$hlp_name;?>" id="hlp_name" name="hlp_name" type="text" class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label for="hlp_contact">Contact - Helpline <span style="color:red;">*</span></label>
                            <input value="<?=$hlp_contact;?>" id="hlp_contact" name="hlp_contact" type="text" class="form-control" placeholder="Enter Phone Number" required>
                        </div>


                        <div class="form-group">
                            <label for="hlp_link">Facebook Link - Helpline <span style="color:red;">*</span></label>
                            <input value="<?=$hlp_link;?>" id="hlp_link" name="hlp_link" type="text" class="form-control" placeholder="Enter Facebook Link" required>
                        </div>

                        <div class="form-group">
                            <label for="buy_course_link">How to Buy a Course Link<span style="color:red;">*</span></label>
                            <input value="<?=$buy_course_link;?>" id="buy_course_link" name="buy_course_link" type="text" class="form-control" placeholder="Ex - https://www.youtube.com/@macroschool158" required>
                        </div>

                        <div class="form-group">
                            <label for="bkash_pay">Payment Number - Bkash <span style="color:red;">*</span></label>
                            <input value="<?=$bkash_pay;?>" id="bkash_pay" name="bkash_pay" type="text" class="form-control" placeholder="Enter Bkash Number" required>
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