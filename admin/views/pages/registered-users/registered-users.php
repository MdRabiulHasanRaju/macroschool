<?php
$title = "Macro School Admin - Registered Users";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Registered Users";
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
    table.all-order-table>tbody>tr>th {
    background: #237b63;
}
</style>
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Registered Users</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?php
                        $Sql = "select id, email from `users` order by id desc";
                        $Stmt = fetch_data($connection, $Sql);
                        $total_users = mysqli_stmt_num_rows($Stmt);
                        ?>
                        <h5 class="card-title mb-0">All Users (Total: <?=$total_users;?> Students)</h5>
                    </div>
                    <div class="card-body all-order">
                        <table class="all-order-table">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                                <?php
                                $Sql = "select id, email from `users` order by id desc";
                                $Stmt = fetch_data($connection, $Sql);
                                if (mysqli_stmt_num_rows($Stmt) == 0) {
                                    $noOrder = "Empty Users";
                                } else {
                                    mysqli_stmt_bind_result(
                                        $Stmt,
                                        $id,
                                        $email
                                    );
                                    $i = 1;
                                    while (mysqli_stmt_fetch($Stmt)) {
                                        $user_id = $id;
                                        $info_Sql = "select name, mobile from `users_info` where user_id='$user_id'";
                                        $info_Stmt = fetch_data($connection, $info_Sql);
                                        if (mysqli_stmt_num_rows($info_Stmt) == 0) {
                                        $name = "<span style='color:red'>Blank!</span>";
                                        $mobile = "<span style='color:red'>Blank!</span>";
                                        } else {
                                        mysqli_stmt_bind_result(
                                            $info_Stmt,
                                            $name,
                                            $mobile
                                        );
                                        mysqli_stmt_fetch($info_Stmt);
                                    }
                                ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $name; ?></td>
                                            <td><?= $mobile; ?></td>
                                            <td><?= $email; ?></td>
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
} else {
    header("location: " . ADMIN_LINK . "login");
    die();
}
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
</body>

</html>