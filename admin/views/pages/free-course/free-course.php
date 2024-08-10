<?php
$title = "Macro School Admin - Free Course";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Free Course";
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
            background: #dd8e29;
        }

        @media screen and (max-width: 600px) {
            form.add-course-form {
                width: 100%;
            }
        }
    </style>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Free Course</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Youtube Videos</h5>
                    </div>
                    <div class="card-body all-order">
                        <table class="all-order-table">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Video</th>
                                    <th>Change Video</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                $Sql = "select * from free_course";
                                $Stmt = fetch_data($connection, $Sql);
                                if (mysqli_stmt_num_rows($Stmt) == 0) {
                                    $noOrder = "Empty Teacher";
                                } else {
                                    mysqli_stmt_bind_result(
                                        $Stmt,
                                        $id,
                                        $yt_link,
                                    );
                                    $i = 1;
                                    while (mysqli_stmt_fetch($Stmt)) {
                                        $video_id = $id; ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td>
                                                <img style="width:150px;" src="http://img.youtube.com/vi/<?= $yt_link; ?>/hqdefault.jpg">
                                            </td>
                                            <td>
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/editFreeCourseController.php" enctype="multipart/form-data">
                                                    <input class="form-control" name="yt_link" type="text" placeholder="Ex: U_pEbb_cX_o">
                                            </td>
                                            <td>
                                                <div class="actionBtn">
                                                    <input type="hidden" name="video_id" value="<?= $video_id; ?>">

                                                    <input name="submit" id="courseDeleteBtn" class="form-control my-btn black" style="padding:7px;font-size:12px;" type="submit" value="Save Change">
                                                    </form>

                                                    <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteFreeCourseController.php">
                                                        <input type="hidden" name="id" value="<?= $video_id; ?>">
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
                            <h4 class="card-title mb-0">Add New Video</h4>
                        </div>
                        <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addFreeCourseController.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="yt_link">Youtube Link <span style="color:red;">*</span></label>
                                <input id="yt_link" name="yt_link" type="text" class="form-control" placeholder="Ex: U_pEbb_cX_o" required>
                            </div>


                            <div class="form-group">
                                <input value="Add New Video" id="submit" class="form-control my-btn green" name="submit" type="submit">
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