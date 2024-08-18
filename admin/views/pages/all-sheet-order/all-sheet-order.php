<?php
$title = "Macro School Admin - All Order Sheets";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "All Order Sheets";
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

    <h1 class="h3 mb-3">All Order - Sheets</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
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
                            $orderSql = "select * from `sheet_order` order by id desc";
                            $orderStmt = fetch_data($connection, $orderSql);
                            if (mysqli_stmt_num_rows($orderStmt) == 0) {
                                $noOrder = "Empty Order";
                            } else {
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
                                        <td><?= $i; ?></td>
                                        <td>
                                            <?php
                                            $stdn_sql = "select name from users_info where user_id='$user_id'";
                                            $stdn_stmt = fetch_data($connection,$stdn_sql);
                                            mysqli_stmt_bind_result($stdn_stmt,$stdn_name);
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
                                            <form action="<?= ADMIN_LINK; ?>controllers/driveAccessController.php?order=sheet" method="post">
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