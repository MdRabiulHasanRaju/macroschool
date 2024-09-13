<?php
$title = "Macro School Admin - Pop Up Notification";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "popup";
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
        <h1 class="h3 mb-3">Pop Up Notification</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Pop Up</h5>
                    </div>
                    <div class="card-body all-order">
                        <?php
                        $Sql = "SELECT `id`, `image`,`current_cookie` FROM `pop_up`";
                        $Stmt = fetch_data($connection, $Sql);
                        if (mysqli_stmt_num_rows($Stmt) != 0) {

                            mysqli_stmt_bind_result(
                                $Stmt,
                                $id,
                                $image,
                                $current_cookie
                            );
                            mysqli_stmt_fetch($Stmt);
                            $popup_id = $id; ?>
                            <table class="all-order-table">
                                <tbody>
                                    <tr>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="width:150px;" src="<?= IMAGE_LINK; ?><?= $image; ?>" alt="popupimage">
                                        </td>
                                        <td>
                                            <div class="actionBtn">
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/deletePopupController.php">
                                                    <input type="hidden" name="id" value="<?= $popup_id; ?>">
                                                    <input type="hidden" name="prev_image" value="<?= $image; ?>">
                                                    <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Delete">
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <h1 style="color: green;">*Notification ON</h1>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                        } else { ?>
                            <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addPopupController.php" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="pop_image">Image (720 x 720)px <span style="color:red;">*</span></label>
                                    <input id="pop_image" name="pop_image" type="file" class="form-control" required>
                                </div>


                                <div class="form-group">
                                    <input value="Set Popup Notificaton" id="submit" class="form-control my-btn blue" name="submit" type="submit">
                                </div>

                            </form>
                        <?php }
                        ?>
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