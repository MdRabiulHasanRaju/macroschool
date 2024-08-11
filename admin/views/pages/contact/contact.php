<?php
$title = "Macro School Admin - Contact";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Contact";
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

    <h1 class="h3 mb-3">Contact</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"> Contact - Information</h5>
                </div>
                <?php
                $sql = "select * from contact";
                $stmt = mysqli_prepare($connection, $sql);
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 0) {
                        header("location: " . LINK . "error/404");
                        die();
                    } else {
                        mysqli_stmt_bind_result(
                            $stmt,
                            $id,
                            $phone,
                            $email,
                            $address,
                            $fb_link,
                            $yt_link
                        );
                        if (mysqli_stmt_fetch($stmt)) {?>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/contactController.php" method="post" enctype="multipart/form-data">

                    <input name="contact_id" type="hidden" value="<?=$id;?>">

                        <div class="form-group">
                            <label for="email">Contact - Email <span style="color:red;">*</span></label>
                            <input value="<?=$email;?>" id="email" name="email" type="text" class="form-control" placeholder="Enter Email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Contact - Phone <span style="color:red;">*</span></label>
                            <input value="<?=$phone;?>" id="phone" name="phone" type="text" class="form-control" placeholder="Enter Phone Number" required>
                        </div>


                        <div class="form-group">
                            <label for="fb_link">Facebook Link<span style="color:red;">*</span></label>
                            <input value="<?=$fb_link;?>" id="fb_link" name="fb_link" type="text" class="form-control" placeholder="Enter Facebook Link" required>
                        </div>

                        <div class="form-group">
                            <label for="yt_link">Youtube Link<span style="color:red;">*</span></label>
                            <input value="<?=$yt_link;?>" id="yt_link" name="yt_link" type="text" class="form-control" placeholder="Ex - https://www.youtube.com/@macroschool158" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Contact - Address <span style="color:red;">*</span></label>
                            <input value="<?=$address;?>" id="address" name="address" type="text" class="form-control" placeholder="Enter Bkash Number" required>
                        </div>


                        <div class="form-group">
                            <input value="Save Changes" id="submit" class="form-control my-btn green" name="submit" type="submit">
                        </div>

                    </form>
                </div>
                
                <?php   }
                    }
                } ?>
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