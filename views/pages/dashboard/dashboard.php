<?php ob_start();
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "Macro School - Dashboard";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Dashboard";

include("../../inc/header.php");
?>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $sql = "select mobile from users_info where user_id = ?";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, "i", $param_id);
  $param_id = $_SESSION['id'];
  if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_store_result($stmt)) {
      mysqli_stmt_bind_result($stmt, $mobile);
      if (mysqli_stmt_fetch($stmt)) {
        if (empty($mobile)) {
          unset($_SESSION["mobile"]);
          header("location: " . LINK . "create-profile");
          die();
        }
      }
      if (mysqli_stmt_num_rows($stmt) == 0) {
        header("location: " . LINK . "create-profile");
        die();
      }
    }
  }
} else {
  header("location: " . LINK . "login");
  die();
}
?>
<section class="container dashboard-page">
    <center><h1>Dashboard</h1></center>
    <ul>
        <li>Name: <?=$_SESSION['name'];?></li>
        <li>email: <?=$_SESSION['username'];?></li>
        <li>Phone: <?=$_SESSION['mobile'];?></li>
        <li><a href="<?=LINK;?>controllers/logoutController.php">Logout</a></li>
    </ul>

</section>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>