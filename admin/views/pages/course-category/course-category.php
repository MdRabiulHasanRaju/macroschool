<?php
$title = "Macro School Admin - Course Category";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Course Category";
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
<style>
    form.add-course-form {
    width: 50%;
}
@media screen and (max-width: 600px) {
    form.add-course-form {
    width: 100%;
}
}

</style>
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Course Category</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Courses Category</h5>
                </div>
                <div class="card-body all-order">
                    <table class="all-order-table">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select * from course_category order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Teacher";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $name,
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $cat_id=$id;?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td>
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/editCourseCategoryController.php">
                                                <input name="name" type="text" value="<?= $name; ?>">
                                        </td>
                                        <td>
                                            <div class="actionBtn">
                                                <input type="hidden" name="cat_id" value="<?= $cat_id; ?>">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn black" style="padding:7px;font-size:12px;" type="submit" value="Save Change">
                                            </form>

                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteCourseCategoryController.php">
                                                <input type="hidden" name="id" value="<?= $cat_id; ?>">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Delete">
                                            </form>
                                            
                                            </div>
                                        </td>
                                    </tr>
                            <?php $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div style="padding-top:60px;padding-left: 0;" class="card-header">
                        <h4 class="card-title mb-0">Add New Course Category</h4>
                    </div>
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addCourseCategoryController.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name">Category Name <span style="color:red;">*</span></label>
                            <input id="name" name="name" type="text" class="form-control" placeholder="Enter Category Name" required>
                        </div>


                        <div class="form-group">
                            <input value="Add Category" id="submit" class="form-control my-btn" name="submit" type="submit">
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