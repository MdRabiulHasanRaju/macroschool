<?php
$title = "Macro School Admin - Coupon";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Coupon";
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
table.all-order-table>tbody>tr>th {
    background: #ff8401;
}
@media screen and (max-width: 600px) {
    form.add-course-form {
    width: 100%;
}
}

</style>
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Coupons</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Course Coupon</h5>
                </div>
                <div class="card-body all-order">
                    <table class="all-order-table">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Coupon Code</th>
                                <th>Discount</th>
                                <th>Total Sell</th>
                                <th>Course Name</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select id, course_Id,coupon_code,discount from coupon order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Coupon";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $course_Id,
                                    $coupon_code,
                                    $discount
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $coupon_id=$id;?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><b> <?= $coupon_code; ?> </b></td>
                                        <td><?= $discount; ?></td>
                                        <td>
                                            <?php
                                                 $Sql_coupon = "select coupon_code from `order` where coupon_code='$coupon_id' and status=2";
                                                 $Stmt_coupon = fetch_data($connection, $Sql_coupon);
                                                 if (mysqli_stmt_num_rows($Stmt_coupon) == 0) {
                                                    echo 0;
                                                 }else{
                                                    echo mysqli_stmt_num_rows($Stmt_coupon);
                                                 }
                                            ?>

                                        </td>
                                        <td>
                                            <?php
                                                $Sql_course = "SELECT id, course_title FROM `courses` where id='$course_Id'";
                                                $Stmt_course = fetch_data($connection, $Sql_course);
                                                mysqli_stmt_bind_result($Stmt_course, $id,$course_title);
                                                while (mysqli_stmt_fetch($Stmt_course)) {
                                                    echo $course_title;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="actionBtn">
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteCouponController.php">
                                                <input type="hidden" name="id" value="<?= $coupon_id; ?>">
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
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addCouponController.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                            <label for="course">Select Course <span style="color:red;">*</span></label>
                            <select class="form-control" name="course" id="course">
                                <option selected disabled> - Choose Course For Coupon</option>
                                <?php
                                $Sql_course = "SELECT id, course_title FROM `courses`";
                                $Stmt_course = fetch_data($connection, $Sql_course);
                                mysqli_stmt_bind_result($Stmt_course, $id,$course_title);
                                while (mysqli_stmt_fetch($Stmt_course)) {
                                ?>
                                    <option value="<?= $id; ?>">
                                        <?= $course_title; ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="coupon">Coupon Code <span style="color:red;">*</span></label>
                            <input id="coupon" name="coupon" type="text" class="form-control" placeholder="Enter Coupon Code" required>
                        </div>

                        <div class="form-group">
                            <label for="discount">Discount <span style="color:red;">*</span></label>
                            <input id="discount" name="discount" type="number" class="form-control" placeholder="Enter Discount Price" required>
                        </div>


                        <div class="form-group">
                            <input value="Create New Coupon" id="submit" class="form-control my-btn green" name="submit" type="submit">
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