<?php
$title = "Macro School Admin - Order";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Order";
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
        <h1 class="h3 mb-3">Specific Course Order</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?php
                        $title_id = isset($_GET['courseID']) ? $_GET['courseID'] : $_POST['courseName'];
                        $courseSql = "select course_title from `courses` where id='$title_id'";
                        $courseStmt = fetch_data($connection, $courseSql);
                        if (mysqli_stmt_num_rows($courseStmt) > 0) {
                            mysqli_stmt_bind_result($courseStmt, $c_name);
                            while (mysqli_stmt_fetch($courseStmt)) { ?>
                                <h5 class="card-title mb-0" style="font-size:20px;color:orange"><?= $c_name; ?></h5>
                        <?php  }
                        }
                        ?>

                        <div style="padding-top:10px;" class="filter-course">
                            <form action="<?= ADMIN_LINK; ?>specific-course-order" method="post">
                                <select style="padding:10px;border: 1px solid #ebebeb;" name="courseName" id="courseName" required>
                                    <option value="" selected disabled>Select Course</option>
                                    <?php
                                    $courseSql = "select id,course_title from `courses`";
                                    $courseStmt = fetch_data($connection, $courseSql);
                                    if (mysqli_stmt_num_rows($courseStmt) > 0) {
                                        mysqli_stmt_bind_result($courseStmt, $c_id, $c_name);
                                        while (mysqli_stmt_fetch($courseStmt)) { ?>
                                            <option value="<?= $c_id; ?>"><?= $c_name; ?></option>
                                    <?php  }
                                    }
                                    ?>

                                </select>
                                <input style="padding:10px;border: 1px solid #ebebeb;" type="submit" name="submit" value="Choose Course">
                            </form>
                        </div>
                    </div>
                    <div class="card-body all-order">
                        <table class="all-order-table">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Student Name</th>
                                    <th>Course Name</th>
                                    <th>Batch</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Regular Price</th>
                                    <th>Offer Price</th>
                                    <th>Ref ID</th>
                                    <th>Status</th>
                                    <th>Drive Access</th>
                                </tr>
                                <?php
                                if (isset($_GET['courseID']) || isset($_POST['courseName']) || isset($_POST['submit'])) {

                                    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

                                    function validate($data)
                                    {
                                        $data = trim($data);
                                        $data = stripslashes($data);
                                        $data = htmlspecialchars($data);
                                        return $data;
                                    }
                                    if (isset($_GET['courseID'])) {
                                        $c_id = validate($_GET['courseID']);
                                    } else {
                                        $c_id = validate($_POST['courseName']);
                                    }


                                    $orderSql = "SELECT * FROM `order` WHERE course_id='$c_id' order by id desc";
                                    $orderStmt = fetch_data($connection, $orderSql);
                                    if (mysqli_stmt_num_rows($orderStmt) == 0) { ?>
                                        <tr>
                                            <td style="padding:100px" colspan="10">
                                                <h2>Empty Order!</h2>
                                            </td>
                                        </tr>
                                        <?php } else {
                                        mysqli_stmt_bind_result(
                                            $orderStmt,
                                            $id,
                                            $user_id,
                                            $course_id,
                                            $course_title,
                                            $course_sub_title,
                                            $mobile,
                                            $email,
                                            $regular_price,
                                            $offer_price,
                                            $status,
                                            $drive_access,
                                            $coupon_code,
                                            $date
                                        );
                                        $i = 1;
                                        while (mysqli_stmt_fetch($orderStmt)) { ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td>
                                                    <?php
                                                    $stdn_sql = "select name from users_info where user_id='$user_id'";
                                                    $stdn_stmt = fetch_data($connection, $stdn_sql);
                                                    mysqli_stmt_bind_result($stdn_stmt, $stdn_name);
                                                    mysqli_stmt_fetch($stdn_stmt);
                                                    echo $stdn_name;
                                                    ?>
                                                </td>
                                                <td><?= $course_title; ?></td>
                                                <td><?= $course_sub_title; ?></td>
                                                <td><?= $mobile; ?></td>
                                                <td><?= $email; ?></td>
                                                <td><?= $regular_price; ?></td>
                                                <td><?= $offer_price; ?></td>
                                                <td><?= $id; ?></td>
                                                <?php
                                                $admin_id = $_SESSION['admin_id'];
                                                $account_sql = "select role from users_admin where id='$admin_id'";
                                                $account_stmt = fetch_data($connection, $account_sql);
                                                mysqli_stmt_bind_result($account_stmt, $role);
                                                mysqli_stmt_fetch($account_stmt);
                                                if ($role == "admin") {
                                                ?>
                                                    <td>
                                                        <form action="<?= ADMIN_LINK; ?>controllers/statusChangeController.php?specific_course=<?= $c_id; ?>" method="post">
                                                            <input name="refid" type="hidden" value="<?= $id; ?>">
                                                            <select <?= ($status == 1) ? "style='background:red;color:white;'" : "style='background:green;color:white;'"; ?> name="status" id="status">
                                                                <option selected value="<?= ($status == 1) ? 1 : 2; ?>">
                                                                    <?php if ($status == 1) { ?>
                                                                        Unpaid
                                                                    <?php } elseif ($status == 2) { ?>
                                                                        Paid
                                                                    <?php } ?>
                                                                </option>

                                                                <option value="<?= ($status == 1) ? 2 : 1; ?>">
                                                                    <?php if ($status == 1) { ?>
                                                                        Paid
                                                                    <?php } elseif ($status == 2) { ?>
                                                                        Unpaid
                                                                    <?php } ?>
                                                                </option>

                                                            </select>
                                                            <input type="submit" name="" id="changeStatus" value="Change Status">
                                                        </form>
                                                    </td>
                                                    <?php } else {
                                                    if ($status == 1) { ?>
                                                        <td style='color:white;background:red;'>Unpaid</td>
                                                    <?php } else { ?>
                                                        <td style='color:white;background:green;'>Paid</td>
                                                <?php }
                                                } ?>

                                                <?php
                                                if ($drive_access == 0) { ?>
                                                    <form action="<?= ADMIN_LINK; ?>controllers/driveAccessController.php?specific_course=<?= $c_id; ?>" method="post">
                                                        <input name="refid" type="hidden" value="<?= $id; ?>">
                                                        <td><Button name="submit" class="btn my-btn" <?= $status == 1 ? 'disabled' : '' ?>>Give Access</Button></td>
                                                    </form>
                                                <?php } else { ?>
                                                    <td><Button class="btn my-btn green" disabled>Access Done</Button></td>
                                                <?php } ?>
                                            </tr>
                                <?php $i++;
                                        }
                                    }
                                }
                                ?>


                            </tbody>
                        </table>
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