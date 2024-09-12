<?php
$title = "Macro School Admin - Notice";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Notice";
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
    <h1 class="h3 mb-3">Notices</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">View All Notices</h5>
                </div>
                <div class="card-body all-order">
                    <table class="all-order-table">
                        <tbody>
                            <tr>
                                <th>Date</th>
                                <th>Headline</th>
                                <th>Description</th>
                                <th>Author</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select * from notice order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Notice";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $author,
                                    $title,
                                    $des,
                                    $date
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $notice_id=$id;?>
                                    <tr>
                                        <td><?= $format->formatDate($date); ?></td>
                                        <td><?= $title; ?></td>
                                        <td><?= $des; ?></td>
                                        <td><?= $author; ?></td>
                                        <td>
                                            <div class="actionBtn">
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteNoticeController.php">
                                                <input type="hidden" name="id" value="<?= $notice_id; ?>">
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