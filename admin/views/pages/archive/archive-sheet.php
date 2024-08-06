<?php
$title = "Macro School Admin - Archive Sheets";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Archive Sheets";
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
    <h1 class="h3 mb-3">Sheets</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">View All Sheets</h5>
                </div>
                <div class="card-body all-order">
                    <table class="all-order-table">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Sheet Name</th>
                                <th>Teacher</th>
                                <th>Regular Price</th>
                                <th>Offer Price</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select id, sheet_title, faculties,regular_price,offer_price,sheet_hide,main_image,free_img from `sheets` order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Course";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $sheet_title,
                                    $faculties,
                                    $regular_price,
                                    $offer_price,
                                    $sheet_hide,
                                    $main_image,
                                    $free_img
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $sheet_id=$id;
                                    if ($sheet_hide == 0) {?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $sheet_title; ?></td>
                                        <td>
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
                                                <p><?= $name; ?>, <?= $department; ?></p>
                                            <?php } ?>

                                        </td>
                                        <td><?= $regular_price; ?></td>
                                        <td><?= $offer_price; ?></td>
                                        <td>
                                            <div class="actionBtn">
                                            
                                            <a style="padding:7px;font-size:12px;" class="my-btn green" target="_blank" href="../sheet-details/<?= $sheet_id; ?>/<?= $sheet_title; ?>">View</a>


                                            <?php if($sheet_hide==0){ ?>
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/visibilityCourseController.php?type=sheet">
                                                <input type="hidden" name="id" value="<?= $sheet_id; ?>">
                                                <input type="hidden" name="visibility" value="1">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Publish">
                                            </form>

                                            <?php }elseif($sheet_hide==1){ ?>
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/visibilityCourseController.php?type=sheet">
                                                <input type="hidden" name="id" value="<?= $sheet_id; ?>">
                                                <input type="hidden" name="visibility" value="0">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn blue" style="padding:7px;font-size:12px;" type="submit" value="Hide">
                                            </form>
                                            <?php }?>
                                            
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteSheetController.php">
                                                <input type="hidden" name="id" value="<?= $sheet_id; ?>">
                                                <input type="hidden" name="prev_main_image" value="<?= $main_image; ?>">
                                                <input type="hidden" name="prev_free_image" value="<?= $free_img; ?>">
                                                <input name="submit" id="sheetDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Delete">
                                            </form>
                                            
                                            </div>
                                        </td>
                                    </tr>
                            <?php $i++;
                                }}
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