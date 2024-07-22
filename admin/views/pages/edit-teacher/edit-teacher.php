<?php
$title = "Macro School Admin - Pain Oder";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "All Teachers";
?>
<?php
include("../../inc/header.php");
if(isset($_GET['id'])){
    $teacher_id = $_GET['id'];
}
else{
    header("location: ".LINK."error/404");
}
?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Edit Teacher</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Teacher's Information</h5>
                </div>
                <?php
                $sql = "select * from faculties where id=?";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                $param_id = $teacher_id;
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 0) {
                        header("location: " . LINK . "error/404");
                        die();
                    } else {
                        mysqli_stmt_bind_result(
                            $stmt,
                            $id,
                            $name,
                            $department,
                            $image,
                            $link
                        );
                        if (mysqli_stmt_fetch($stmt)) {?>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/editTeacherController.php" method="post" enctype="multipart/form-data">

                    <input name="teacher_id" type="hidden" value="<?=$teacher_id;?>">

                        <div class="form-group">
                            <label for="name">Name <span style="color:red;">*</span></label>
                            <input value="<?=$name;?>" id="name" name="name" type="text" class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label for="department">Department <span style="color:red;">*</span></label>
                            <input value="<?=$department;?>" id="department" name="department" type="text" class="form-control" placeholder="Enter Department" required>
                        </div>


                        <div class="form-group">
                            <label for="image">Teacher Image </label>
                            <img src="<?=IMAGE_LINK;?><?=$image;?>" alt="">
                            <input type="hidden" value="<?=$image;?>" name="prev_image">
                            <input id="image" name="image" type="file" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="facebookLink">Facebook Link of Tearcher <span style="color:red;">*</span></label>
                            <input value="<?=$link;?>" id="facebookLink" name="facebookLink" type="text" class="form-control" placeholder="Enter Facebook Link" required>
                        </div>


                        <div class="form-group">
                            <input value="Save Changes" id="submit" class="form-control my-btn" name="submit" type="submit">
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
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
</body>

</html>