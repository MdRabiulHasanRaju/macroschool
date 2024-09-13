<?php
$title = "Macro School Admin - Live";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Live";
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
        <h1 class="h3 mb-3">Go Live</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Setup Your Live</h5>
                    </div>
                    <div class="card-body all-order">
                    <?php
                                $Sql = "SELECT `id`,`name`,`title`,`link` FROM `live`";
                                $Stmt = fetch_data($connection, $Sql);
                                if (mysqli_stmt_num_rows($Stmt) != 0) {

                                    mysqli_stmt_bind_result(
                                        $Stmt,
                                        $id,
                                        $name,
                                        $title,
                                        $link
                                    );
                                    mysqli_stmt_fetch($Stmt);
                                    $live_id = $id; ?>
                        <table class="all-order-table">
                            <tbody>
                                <tr>
                                    <th>Teacher Name</th>
                                    <th>Headline</th>
                                    <th>Live Link</th>
                                    <th>Action</th>
                                </tr>
                                    <tr>
                                        <td><?= $name; ?></td>
                                        <td><?= $title; ?></td>
                                        <td><?= $link; ?></td>
                                        <td>
                                            <div class="actionBtn">
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteLiveController.php">
                                                    <input type="hidden" name="id" value="<?= $live_id; ?>">
                                                    <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Delete">
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr><h1 style="color: red;">*Live On</h1></tr>
                            </tbody>
                        </table>
                    <?php
                                } else { ?>
                        <div style="padding-top:60px;padding-left: 0;" class="card-header">
                            <h4 class="card-title mb-0">Create Live</h4>
                        </div>
                        <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addLiveController.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="author">Teacher Name <span style="color:red;">*</span></label>
                            <input id="author" name="author" type="text" class="form-control" placeholder="Enter Teacher Name" required>
                        </div>

                        <div class="form-group">
                            <label for="headline">Headline <span style="color:red;">*</span></label>
                            <input id="headline" name="headline" type="text" class="form-control" placeholder="Enter Headline" required>
                        </div>

                        <div class="form-group">
                            <label for="link">Live Link <span style="color:red;">*</span></label>
                            <textarea class="form-control" name="link" id="link" placeholder="Enter Facebook Live Link" required></textarea>
                        </div>


                            <div class="form-group">
                                <input value="Go Live" id="submit" class="form-control my-btn" name="submit" type="submit">
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