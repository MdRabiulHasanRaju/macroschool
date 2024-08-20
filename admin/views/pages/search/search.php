<?php
$title = "Macro School Admin - Search";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Search Order";
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
    <?php if (isset($_GET['order']) && $_GET['order'] == 'sheet') { ?>
        <h1 class="h3 mb-3">Search Result For Sheets</h1>
        <?php }else{?>
        <h1 class="h3 mb-3">Search Result For Courses</h1>
            <?php }?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php
                    if (isset($_GET['order']) && $_GET['order'] == 'sheet') { ?>
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order List</h5>
                        <form class="search-form" action="<?= ADMIN_LINK; ?>search?order=sheet" method="post">
                            <input type="text" name="search" placeholder="Search with Ref ID / Phone" required>
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
                        <div class="card-body all-order">
                            <table class="all-order-table">
                                <tbody>
                                    <tr>
                                        <th>SL</th>
                                        <th>Student Name</th>
                                        <th>Sheet Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Regular Price</th>
                                        <th>Offer Price</th>
                                        <th>Ref ID</th>
                                        <th>Status</th>
                                        <th>Drive Access</th>
                                    </tr>
                                    <?php

                                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                        if (isset($_POST['search']) && isset($_POST['submit'])) {

                                            include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

                                            function validate($data)
                                            {
                                                $data = trim($data);
                                                $data = stripslashes($data);
                                                $data = htmlspecialchars($data);
                                                return $data;
                                            }
                                            $search = validate($_POST['search']);

                                            $orderSql = "SELECT * FROM `sheet_order` WHERE id='$search' or mobile='$search' order by id desc";
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
                                                    $sheet_id,
                                                    $sheet_title,
                                                    $faculties,
                                                    $mobile,
                                                    $email,
                                                    $regular_price,
                                                    $offer_price,
                                                    $status,
                                                    $drive_access,
                                                    $date
                                                );
                                                $i = 1;
                                                while (mysqli_stmt_fetch($orderStmt)) { ?>
                                                    <tr>
                                                        <<td><?= $i; ?></td>
                                                            <td>
                                                                <?php
                                                                $stdn_sql = "select name from users_info where user_id='$user_id'";
                                                                $stdn_stmt = fetch_data($connection, $stdn_sql);
                                                                mysqli_stmt_bind_result($stdn_stmt, $stdn_name);
                                                                mysqli_stmt_fetch($stdn_stmt);
                                                                echo $stdn_name;
                                                                ?>
                                                            </td>
                                                            <td><?= $sheet_title; ?></td>
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
                                                                <form action="<?= ADMIN_LINK; ?>controllers/statusChangeController.php?order=sheet" method="post">
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
                                            <form action="<?= ADMIN_LINK; ?>controllers/driveAccessController.php" method="post">
                                            <input name="refid" type="hidden" value="<?= $id; ?>">
                                                <td><Button name="submit" class="btn my-btn" <?=$status == 1?'disabled':''?>>Give Access</Button></td>
                                            </form>
                                            <?php } else { ?>
                                                <td><Button class="btn my-btn green" disabled>Access Done</Button></td>
                                        <?php }?>
                                                    </tr>
                                    <?php $i++;
                                                }
                                            }
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order List</h5>
                        <form class="search-form" action="<?= ADMIN_LINK; ?>search" method="post">
                            <input type="text" name="search" placeholder="Search with Ref ID / Phone" required>
                            <input type="submit" name="submit" value="Search">
                        </form>
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

                                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                        if (isset($_POST['search']) && isset($_POST['submit'])) {

                                            include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";

                                            function validate($data)
                                            {
                                                $data = trim($data);
                                                $data = stripslashes($data);
                                                $data = htmlspecialchars($data);
                                                return $data;
                                            }
                                            $search = validate($_POST['search']);

                                            $orderSql = "SELECT * FROM `order` WHERE id='$search' or mobile='$search' order by id desc";
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
                                                            <form action="<?= ADMIN_LINK; ?>controllers/statusChangeController.php" method="post">
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
                                            <form action="<?= ADMIN_LINK; ?>controllers/driveAccessController.php" method="post">
                                            <input name="refid" type="hidden" value="<?= $id; ?>">
                                                <td><Button name="submit" class="btn my-btn" <?=$status == 1?'disabled':''?>>Give Access</Button></td>
                                            </form>
                                            <?php } else { ?>
                                                <td><Button class="btn my-btn green" disabled>Access Done</Button></td>
                                        <?php }?>
                                                    </tr>
                                    <?php $i++;
                                                }
                                            }
                                        }
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
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