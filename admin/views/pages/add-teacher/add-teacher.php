<?php
$title = "Macro School Admin - Pain Oder";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Add Teacher";
?>
<?php
include("../../inc/header.php");
?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Add Teacher</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Teacher</h5>
                </div>
                <div class="card-body add-course">
                    <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addTeacherController.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="name">Name <span style="color:red;">*</span></label>
                            <input id="name" name="name" type="text" class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label for="department">Department <span style="color:red;">*</span></label>
                            <input id="department" name="department" type="text" class="form-control" placeholder="Enter Department" required>
                        </div>


                        <div class="form-group">
                            <label for="image">Teacher Image <span style="color:red;">*</span></label>
                            <input id="image" name="image" type="file" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="facebookLink">Facebook Link of Tearcher <span style="color:red;">*</span></label>
                            <input id="facebookLink" name="facebookLink" type="text" class="form-control" placeholder="Enter Facebook Link" required>
                        </div>


                        <div class="form-group">
                            <input value="Add Teacher" id="submit" class="form-control my-btn" name="submit" type="submit">
                        </div>

                    </form>
                </div>
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