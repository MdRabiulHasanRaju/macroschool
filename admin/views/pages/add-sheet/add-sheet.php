<?php
$title = "Macro School Admin - Add Sheet";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Add Sheet";
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

        <h1 class="h3 mb-3">Add Sheet</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create New Sheet</h5>
                    </div>
                    <div class="card-body add-course">
                        <form class="add-course-form" action="<?= ADMIN_LINK; ?>controllers/addSheetController.php" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="teachers">Teacher <span style="color:red;">*</span></label>
                                <select class="form-control" name="teachers" id="teachers">
                                    <option selected disabled> - Choose Course Teacher</option>
                                    <?php
                                    $Sql = "SELECT * FROM `faculties`";
                                    $Stmt = fetch_data($connection, $Sql);
                                    mysqli_stmt_bind_result($Stmt, $id, $name, $department, $image, $link);
                                    while (mysqli_stmt_fetch($Stmt)) {
                                    ?>
                                        <option value="<?= $id; ?>">
                                            <?= $name; ?>,
                                            <?= $department; ?>
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sheetName">Sheet Name <span style="color:red;">*</span></label>
                                <input id="sheetName" name="sheetName" type="text" class="form-control" placeholder="Enter Sheet Name" required>
                            </div>

                            <div class="form-group">
                                <label for="course_category">Category <span style="color:red;">*</span></label>
                                <select class="form-control" name="course_category" id="course_category">
                                    <option selected disabled> - Choose Course Category</option>
                                    <?php
                                    $Sql = "SELECT * FROM `course_category`";
                                    $Stmt = fetch_data($connection, $Sql);
                                    mysqli_stmt_bind_result($Stmt, $id, $cat_name);
                                    while (mysqli_stmt_fetch($Stmt)) {
                                    ?>
                                        <option value="<?= $id; ?>">
                                            <?= $cat_name; ?>
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sheetDetails">Sheet Details <span style="color:red;">*</span></label>
                                <textarea class="form-control" name="sheetDetails" id="sheetDetails" placeholder="Enter Sheet Details" required></textarea>
                            </div>


                            <div class="form-group">
                                <label for="mainImage">Sheet Cover Image <span style="color:red;">*</span></label>
                                <input id="mainImage" name="mainImage" type="file" class="form-control" required>
                            </div>

                            <div style="border:2px solid #efefef;padding:10px" id="new-input-container" class="form-group">
                                <label for="freeImage">Sheet Demon Image (Max-5) <span style="color:red;">*</span></label> <br>
                                <b>1.</b>
                                <input style="margin-bottom:10px;" id="freeImage" name="freeImage[]" type="file" class="form-control" required>
                            </div>
                            <p id="add-free-img-btn" style="text-align:Center;" class="my-btn green" onclick="createNewInputFields()"><span style="font-size:20px; padding:0px 5px;border-radius:5px;border:1px solid #ededed;">+</span> Add Another Image</p>


                            <div class="form-group">
                                <label for="driveLink">Sheet Drive Link <span style="color:red;">*</span></label>
                                <input id="driveLink" name="driveLink" type="text" class="form-control" placeholder="Enter Sheet Drive Link" required>
                            </div>


                            <div class="form-group">
                                <label for="regularPrice">Regular Price <span style="color:red;">*</span></label>
                                <input id="regularPrice" name="regularPrice" type="number" class="form-control" placeholder="Enter Regular Price" required>
                            </div>

                            <div class="form-group">
                                <label for="offerPrice">Offer Price <span style="color:red;">*</span></label>
                                <input id="offerPrice" name="offerPrice" type="number" class="form-control" placeholder="Enter Offer Price" required>
                            </div>

                            <div class="form-group">
                                <input value="Add Course" id="submit" class="form-control my-btn" name="submit" type="submit">
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
<script>
    let addBtn = document.getElementById("add-free-img-btn");
    let i = 1;

    function createNewInputFields() {
        var container = document.getElementById('new-input-container');

        const newElemb = document.createElement("b");
        newElemb.innerHTML = ++i + ".";
        container.appendChild(newElemb);


        const newElem = document.createElement("input");
        newElem.setAttribute("type", "file");
        newElem.setAttribute("class", "form-control");
        newElem.setAttribute("name", "freeImage[]");
        newElem.setAttribute("style", "margin-bottom:10px");
        container.appendChild(newElem);

        if (i == 5) {
            addBtn.style.display = "none";
        }
    }
</script>
</body>

</html>