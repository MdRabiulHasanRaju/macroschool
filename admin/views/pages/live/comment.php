<?php

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {

    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/lib/Database.php";
    $commentSql = "SELECT * FROM comment order by id desc";
    $result = mysqli_query($connection, $commentSql);
    if (mysqli_num_rows($result) > 0) { ?>

        <tr class="live-comment">
            <th colspan="4">All Questions & Answer</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) { ?>


            <tr>
                <td>
                    <img
                        style="width: 40px;border: 1px solid #cfcfcf;border-radius: 50%;"
                        src="<?= IMAGE_LINK; ?>icon/<?= $row['author_image']; ?>"
                        alt="userImg" />

                    <?php echo $row['author_name']; ?>

                </td>
                <td><?= $row['msg']; ?></td>
                <td>
                    <!-- for answer box -->
                    <?php
                    if ($row['author_name'] == "admin") {
                        $userID = $row['user_id'];
                        $sql_user = "select name,image from users_info where user_id='$userID'";
                        $query = mysqli_query($connection, $sql_user);
                        $user_info = mysqli_fetch_assoc($query);
                        echo "<img 
                    style='width: 40px;border: 1px solid #cfcfcf;border-radius: 50%;' 
                    src=" . IMAGE_LINK . "icon/" . $user_info['image'] . " alt='userImg' />";
                        echo "<br>Reply to <b>(" . $user_info['name'] . ")</b>";
                    } else { ?>
                        <form id="commentForm" method="post" action="">
                            <input style="margin-bottom: 5px;" class="form-control" name="answer" id="comment" placeholder="Write Answer" />

                        <?php  } ?>

                        <!-- for sent/replied -->
                        <?php
                        if ($row['author_name'] == "admin") {
                            echo '<button class="form-control my-btn" style="color:black;padding:7px;font-size:12px;" disabled>Replied</button>';
                        } else { ?>
                            <div class="actionBtn">
                                <input id="userId" type="hidden" name="id" value="<?= $row['user_id']; ?>">
                                <input name="submit" id="courseDeleteBtn" class="form-control my-btn" style="padding:7px;font-size:12px;" type="submit" value="Sent">
                        </form>

                        </div>
                    <?php } ?>

                </td>
            </tr>


<?php    }
    } else {
        echo '<div style="display: flex;align-items:center;gap:10px;justify-content:center;padding:10px;" class="all-comments">
            <p>There Are No Questions/Answer!</p>
        </div>';
    }
} else {
    echo '<div style="display: flex;align-items:center;gap:10px;justify-content:center;padding:10px;" class="all-comments">
        <a style="color:#dc555b" href="' . LINK . 'login"><b>To ask and answer questions, please Log in!</b></a>
    </div>';
}
?>

<script src="<?= ADMIN_LINK; ?>public/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $("#commentForm").submit(function(event) {
            let msg = $("#comment").val();
            let id = $("#userId").val();
            $.ajax({
                url: "/macroschool/admin/controllers/postCommentController.php",
                type: "POST",
                data: {
                    data: msg,
                    userId: id,
                    authorName: "admin",
                    authorImage: "logo.jpg"
                },
                success: function(data) {
                    $("#comment").val('')
                }
            })
        })

    })
</script>