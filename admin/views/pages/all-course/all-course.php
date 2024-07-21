<?php
$title = "Macro School Admin - Pain Oder";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "All Course";
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
                                <th>Course Name</th>
                                <th>Batch</th>
                                <th>Teachers</th>
                                <th>Regular Price</th>
                                <th>Offer Price</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $Sql = "select id, course_title, course_sub_title,faculties,regular_price,offer_price,course_hide from `courses` order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Course";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $course_title,
                                    $course_sub_title,
                                    $faculties,
                                    $regular_price,
                                    $offer_price,
                                    $course_hide
                                );
                                $i = 1;
                                while (mysqli_stmt_fetch($Stmt)) { $course_id=$id;?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $course_title; ?></td>
                                        <td><?= $course_sub_title; ?></td>
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
                                            
                                            <a style="padding:7px;font-size:12px;" class="my-btn green" target="_blank" href="../course-details/<?= $course_id; ?>">View</a>
                                            <?php if($course_hide==0){ ?>
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/visibilityCourseController.php">
                                                <input type="hidden" name="id" value="<?= $course_id; ?>">
                                                <input type="hidden" name="visibility" value="1">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Publish">
                                            </form>
                                            <?php }elseif($course_hide==1){ ?>
                                                <form method="post" action="<?= ADMIN_LINK; ?>controllers/visibilityCourseController.php">
                                                <input type="hidden" name="id" value="<?= $course_id; ?>">
                                                <input type="hidden" name="visibility" value="0">
                                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn blue" style="padding:7px;font-size:12px;" type="submit" value="Hide">
                                            </form>
                                            <?php }?>
                                            <!-- 
                                            <form method="post" action="<?= ADMIN_LINK; ?>controllers/deleteCourseController.php">
                                                <input type="hidden" name="id" value="<?= $course_id; ?>">
                                                <input name="submit" onclick="alertDel()" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Delete">
                                            </form> -->
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
<script>
    function alertDel(){
        alert("Are You Sure?");
    }
</script>
<?php
include("../../inc/footer.php");
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
</body>

</html>