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
  <div class="dashboard-head">
    <div class="dashboard-head-left">
      <img alt="user-profile-image" src="<?php if (isset($_SESSION['google-image'])) {
                                            echo $_SESSION['google-image'];
                                          } else { ?><?= LINK; ?>public/images/icon/profile.png<?php } ?>">
      <div class="account-info">
        <h3><?= $_SESSION['name']; ?></h3>
        <p><?= $_SESSION['username']; ?></p>
        <p><?= $_SESSION['mobile']; ?></p>
      </div>
    </div>
    <div class="dashboard-head-right">
      <a class="my-btn" href="<?= LINK; ?>logout">LOGOUT</a>
    </div>
  </div>
  <div class="dashboard-body">

    <?php
    $order_check_sql = "select id, course_id, status from `order` where user_id=? ORDER by id DESC";
    $order_check_stmt = mysqli_prepare($connection, $order_check_sql);
    mysqli_stmt_bind_param($order_check_stmt, "i", $param_user_id);
    $param_user_id = $_SESSION['id'];
    mysqli_stmt_execute($order_check_stmt);
    mysqli_stmt_store_result($order_check_stmt);
    mysqli_stmt_bind_result($order_check_stmt, $order_id, $course_id, $status);
    if (mysqli_stmt_num_rows($order_check_stmt) == 0) { ?>

      <div class="browse-course">
        <a href="<?= LINK; ?>courses" class="my-btn green">কোর্স কিনুন </a>
      </div>

      <?php } else {

      while (mysqli_stmt_fetch($order_check_stmt)) {

        $course_sql = "select course_title, course_sub_title, image, routine,  materials_link, facebook_link,regular_price,offer_price from courses where id=?";
        $course_stmt = mysqli_prepare($connection, $course_sql);
        mysqli_stmt_bind_param($course_stmt, "i", $param_course_id);
        $param_course_id = $course_id;
        mysqli_stmt_execute($course_stmt);
        mysqli_stmt_store_result($course_stmt);
        mysqli_stmt_bind_result($course_stmt, $course_title, $course_sub_title, $image, $routine, $materials_link, $facebook_link, $regular_price, $offer_price);
        while (mysqli_stmt_fetch($course_stmt)) { ?>

          <div class="course-ordered-box">
            <div class="course-ordered-box-body">
              <img src="<?= LINK; ?>public/images/<?= $image; ?>" alt="">
              <div class="course-ordered-box-body-content">

                <?php
                if ($status == 1) { ?>

                  <button class="my-btn warning materials-pay-btn" href="<?= $materials_link; ?>"><i class="fa-solid fa-bangladeshi-taka-sign"></i>Pay To Unlock Materials</button>

                  <button class="my-btn warning facebook-pay-btn" href="<?= $facebook_link; ?>"><i class="fa-solid fa-bangladeshi-taka-sign"></i>Pay to Unlock Private Facebook Group</button>

                <?php   } elseif ($status == 2) { ?>

                  <a target="_blank" class="my-btn green" href="<?= $materials_link; ?>"><i class="fa-solid fa-box"></i>MATERIALS</a>

                  <a target="_blank" class="my-btn blue" href="<?= $facebook_link; ?>"><i class="fa-brands fa-facebook"></i>JOIN FACEBOOK</a>

                <?php  }
                ?>

                <a target="_blank" class="my-btn" href="<?= $routine; ?>"><i class="fa-solid fa-calendar-days"></i>ROUTINE</a>
              </div>
            </div>
            <div class="course-ordered-box-title">
              <h3><i class="fa-solid fa-book"></i> <?= $course_title; ?> - <?= $course_sub_title; ?></h3>
            </div>

            


            <div class="payment-popup-outside">
            <div class="payment-popup">
              <div class="payment-head">
                <h2>Pay Now <i class="fa-solid fa-rectangle-xmark close-btn"></i></h2>
              </div>
              <div class="payment-body">
                <h3><i class="fa-solid fa-book"></i> <?= $course_title; ?> - <?= $course_sub_title; ?> - <strong><?= $offer_price ? $offer_price : $regular_price; ?>৳</strong></h3>

                <table class="bkash-ref">
                  <tr>
                    <td>Bkash Personal Number: </td>
                    <td><input type="text" value="01878177772" id="Bkash_number" disabled></td>
                    <td><button id="copyBtn" onclick="copyBkash()">Copy Number</button></td>
                  </tr>
                  <tr>
                    <td>Reference ID: </td>
                    <td><input type="text" value="<?= $order_id; ?>" id="ref_id" disabled></td>
                    <td><button id="copyBtn_ref" onclick="ref_id()">Copy ID</button></td>
                  </tr>
                </table>
              </div>
              <div class="payment-footer">
                <p>উপরে দেওয়া নাম্বারটিতে বিকাশ একাউন্টে গিয়ে সেন্ড মানি অপশন থেকে টাকা পাঠাবেন এবং রেফারেন্স এ উপরে দেওয়া রেফারেন্স ID টি দিয়ে দিবেন। </p>
                <p>উপরে দেওয়া নাম্বারটিতে কল দিয়ে ভেরিফাই করে নিতে পারেন। </p>
              </div>
            </div>
          </div>





          </div>
    <?php }
      }
    }
    ?>

  </div>

</section>

<?php
include("../../inc/footer.php");
?>
<script src="<?= LINK; ?>main.js"></script>
</body>

</html>