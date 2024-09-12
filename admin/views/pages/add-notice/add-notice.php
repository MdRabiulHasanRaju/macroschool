<?php
$title = "Macro School Admin - Add Notice";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Add Notice";
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

    <h1 class="h3 mb-3">Add Notice</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Notice</h5>
                </div>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addNoticeController.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="author">Author <span style="color:red;">*</span></label>
                            <input id="author" name="author" type="text" class="form-control" placeholder="Enter Author Name" required>
                        </div>

                        <div class="form-group">
                            <label for="headline">Headline <span style="color:red;">*</span></label>
                            <input id="headline" name="headline" type="text" class="form-control" placeholder="Enter Headline" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description" required></textarea>
                        </div>

                        <div class="form-group">
                            <input value="Add Notice" id="submit" class="form-control my-btn" name="submit" type="submit">
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