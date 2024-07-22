<?php
$title = "Macro School Admin - Pain Oder";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "All Teachers";
?>
<?php
include("../../inc/header.php");
?>

<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Add Course</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">See All Courses</h5>
                </div>
                <div class="card-body all-order">
                    <table class="all-order-table">
                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Facebook Link</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select * from faculties order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Teacher";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $name,
                                    $department,
                                    $image,
                                    $link
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $teacher_id=$id;?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td>
                                            <img style="width:60px;border-radius:50%;" src="<?=IMAGE_LINK;?><?= $image; ?>" alt="">
                                        </td>
                                        <td><?= $name; ?></td>
                                        <td><?= $department; ?></td>
                                        <td><?= $link; ?></td>
                                        <td>
                                            <div class="actionBtn">
                                            <a style="padding:7px;font-size:12px;" class="my-btn black" href="<?=ADMIN_LINK;?>edit-teacher/<?= $teacher_id; ?>">Edit</a>
                                            
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteTeacherController.php">
                                                <input type="hidden" name="id" value="<?= $teacher_id; ?>">
                                                <input type="hidden" name="prev_image" value="<?= $image; ?>">
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
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
</body>

</html>