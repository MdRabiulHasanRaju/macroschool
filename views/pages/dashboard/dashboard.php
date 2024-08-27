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
  <div class="dashboard-menu">
    <div style="margin-bottom: 0;padding: 20px 0;text-align: center;background: white;border-radius: 10px;">
      <p id="view-courses-btn" style="margin-bottom:10px;display:block;" class='my-btn green'>View Your Ordered Courses <i class="fa-solid fa-circle-chevron-down"></i></p>
      <p id="view-sheets-btn" style="margin-bottom:10px;display:block;" class='my-btn blue'>View Your Ordered Sheets <i class="fa-solid fa-circle-chevron-down"></i></p>
    </div>
  </div>

  <div id="user-ordered-courses" class="dashboard-body">

    <?php
    $order_check_sql = "select id, course_id, offer_price, status from `order` where user_id=? ORDER by id DESC";
    $order_check_stmt = mysqli_prepare($connection, $order_check_sql);
    mysqli_stmt_bind_param($order_check_stmt, "i", $param_user_id);
    $param_user_id = $_SESSION['id'];
    mysqli_stmt_execute($order_check_stmt);
    mysqli_stmt_store_result($order_check_stmt);
    mysqli_stmt_bind_result($order_check_stmt, $order_id, $course_id, $offer_price, $status);
    if (mysqli_stmt_num_rows($order_check_stmt) == 0) { ?>

      <div class="browse-course">
        <a href="<?= LINK; ?>courses" class="my-btn green">কোর্স কিনুন </a>
      </div>

      <?php } else {

      while (mysqli_stmt_fetch($order_check_stmt)) {

        $course_sql = "select course_title, course_sub_title, image, routine,  materials_link, facebook_link,regular_price from courses where id=?";
        $course_stmt = mysqli_prepare($connection, $course_sql);
        mysqli_stmt_bind_param($course_stmt, "i", $param_course_id);
        $param_course_id = $course_id;
        mysqli_stmt_execute($course_stmt);
        mysqli_stmt_store_result($course_stmt);
        mysqli_stmt_bind_result($course_stmt, $course_title, $course_sub_title, $image, $routine, $materials_link, $facebook_link, $regular_price);
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
                    <!-- <tr>
                      <?php
                      // $sql = "select bkash_pay from course_utility";
                      // $stmt = mysqli_prepare($connection, $sql);
                      // if (mysqli_stmt_execute($stmt)) {
                      //   mysqli_stmt_store_result($stmt);
                      //   if (mysqli_stmt_num_rows($stmt) == 0) {
                      //     header("location: " . LINK . "404");
                      //     die();
                      //   } else {
                      //     mysqli_stmt_bind_result(
                      //       $stmt,
                      //       $bkash_pay
                      //     );
                      //     if (mysqli_stmt_fetch($stmt)) { ?>
                      //       <td>Bkash Personal Number: </td>
                      //       <td><input type="text" value="<? //$bkash_pay; ?>" id="Bkash_number" disabled></td>
                      //       <td><button id="copyBtn" onclick="copyBkash()">Copy Number</button></td>
                      // <?php  // }
                      //   }
                      // } ?>
                    </tr> -->
                    <tr>
                      <td>Order ID: </td>
                      <td><input type="text" value="CRS<?= $order_id; ?>" id="ref_id" disabled></td>
                      <td><button id="copyBtn_ref" onclick="ref_id()">Copy ID</button></td>
                    </tr>
                  </table>
                </div>
                <div class="payment-footer">
                  <!-- <p>উপরে দেওয়া নাম্বারটিতে বিকাশ একাউন্টে গিয়ে সেন্ড মানি অপশন থেকে টাকা পাঠাবেন এবং রেফারেন্স এ উপরে দেওয়া রেফারেন্স ID টি দিয়ে দিবেন। </p>
                  <p>উপরে দেওয়া নাম্বারটিতে কল দিয়ে ভেরিফাই করে নিতে পারেন। </p> -->
                  <form style="display:grid;" action="<?=LINK;?>controllers/bkashPayController.php" method="post">
                    <input name="user_id" type="hidden" value="<?= $_SESSION['id']; ?>">
                    <input name="course_id" type="hidden" value="CRS<?= $course_id; ?>">
                    <input name="order_id" type="hidden" value="CRS<?= $order_id; ?>">
                    <input name="amount" type="hidden" value="<?= $offer_price ? $offer_price : $regular_price; ?>">
                    <button name="submit" style="display: flex; justify-content:center;align-items:center;gap:5px; border:1px solid #dc555b;padding:5px 10px;font-weight:bold;cursor:pointer;" >Pay With<img style="width:70px;" src="<?=LINK;?>/public/images/icon/bkash.png" alt="Bkash Icon"></button>
                  </form>
                </div>
              </div>
            </div>
          </div>
    <?php }
      }
    }
    ?>

  </div>

  <style>
    .courses {
      margin-top: 1rem;
    }

    .course {
      display: flex;
      align-items: center;
    }

    .course__image {
      padding: 5px;
    }

    .course__info>h4 {
      font-size: 13px;
    }

    .course__info>a {
      font-size: 12px;
    }

    .share {
      padding: 8px 3px !important;
      font-size: 12px;
    }

    .share.my-btn a img {
      width: 26px;
    }

    .course__image>img {
      width: 100px;
      border: 2px solid #ededed;
    }

    #user-ordered-sheets {
      grid-template-columns: repeat(3, 1fr);
    }

    #sheet-pay-btn {
      font-size: 12px;
      display: block;
    }
  </style>


  <div id="user-ordered-sheets" class="dashboard-body">
    <?php
    $sheet_order_check_sql = "select id, sheet_id, status from `sheet_order` where user_id=? ORDER by id DESC";
    $sheet_order_check_stmt = mysqli_prepare($connection, $sheet_order_check_sql);
    mysqli_stmt_bind_param($sheet_order_check_stmt, "i", $param_user_id);
    $param_user_id = $_SESSION['id'];
    mysqli_stmt_execute($sheet_order_check_stmt);
    mysqli_stmt_store_result($sheet_order_check_stmt);
    mysqli_stmt_bind_result($sheet_order_check_stmt, $sheet_order_id, $sheet_id, $sheet_status);
    if (mysqli_stmt_num_rows($sheet_order_check_stmt) == 0) { ?>

      <div class="browse-course">
        <a href="<?= LINK; ?>sheets" class="my-btn green">শিট কিনুন </a>
      </div>

      <?php } else {

      while (mysqli_stmt_fetch($sheet_order_check_stmt)) {

        $sheet_sql = "SELECT `id`,`main_image`,`sheet_title`,`sheet_details`,`sheet_hide`,regular_price,offer_price,sheet_link FROM `sheets` where id=?";
        $sheet_stmt = mysqli_prepare($connection, $sheet_sql);
        mysqli_stmt_bind_param($sheet_stmt, "i", $param_course_id);
        $param_course_id = $sheet_id;
        mysqli_stmt_execute($sheet_stmt);
        mysqli_stmt_store_result($sheet_stmt);
        mysqli_stmt_bind_result($sheet_stmt, $id, $main_image, $sheet_title, $sheet_details, $sheet_hide, $regular_price, $offer_price,$sheet_link);
        while (mysqli_stmt_fetch($sheet_stmt)) { ?>

          <article class="course">
            <div class="course__image">
              <img src="public/images/<?= $main_image; ?>">
            </div>
            <div class="course__info">
              <h4><?= $sheet_title; ?></h4>
              <?php if ($offer_price) { ?>
                <h4>TK. <del style="color:red"><?= $regular_price; ?>৳</del> <span style="color:green"><?= $offer_price; ?>৳</span></h4>
              <?php } else { ?>
                <h4>TK. <span style="color:green"><?= $regular_price; ?>৳</span></h4>
              <?php } ?>
              <h4>By - Sajjad</h4>
              <?php
              if ($sheet_status == 1) { ?>
                <button id="sheet-pay-btn" class="my-btn warning read_btn" href=""><i class="fa-solid fa-bangladeshi-taka-sign"></i>Pay To Unlock Read Option</button>
              <?php   } elseif ($sheet_status == 2) { ?>
                <a target="_blank" class="my-btn green" href="<?= $sheet_link; ?>"><i class="fa-solid fa-box"></i> Read</a>

              <?php  }
              ?>
            </div>
            <div class="payment-popup-outside">
              <div class="payment-popup">
                <div class="payment-head">
                  <h2>Pay Now <i class="fa-solid fa-rectangle-xmark close-btn"></i></h2>
                </div>
                <div class="payment-body">
                  <h3><i class="fa-solid fa-book"></i> <?= $sheet_title; ?> Sheet - <strong><?= $offer_price ? $offer_price : $regular_price; ?>৳</strong></h3>

                  <table class="bkash-ref">
                    <tr>
                      <?php
                      $sql = "select bkash_pay from course_utility";
                      $stmt = mysqli_prepare($connection, $sql);
                      if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_store_result($stmt);
                        if (mysqli_stmt_num_rows($stmt) == 0) {
                          header("location: " . LINK . "404");
                          die();
                        } else {
                          mysqli_stmt_bind_result(
                            $stmt,
                            $bkash_pay
                          );
                          if (mysqli_stmt_fetch($stmt)) { ?>
                            <td>Bkash Personal Number: </td>
                            <td><input type="text" value="<?= $bkash_pay; ?>" id="Bkash_number" disabled></td>
                            <td><button id="copyBtn" onclick="copyBkash()">Copy Number</button></td>
                      <?php   }
                        }
                      } ?>
                    </tr>
                    <tr>
                      <td>Reference ID: </td>
                      <td><input type="text" value="<?= $sheet_order_id; ?>" id="ref_id" disabled></td>
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
          </article>
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
<script>
  let view_courses_btn = document.getElementById("view-courses-btn");
  let view_sheets_btn = document.getElementById("view-sheets-btn");
  let viewCourses = document.getElementsByClassName("dashboard-body")[0];
  let viewSheets = document.getElementsByClassName("dashboard-body")[1];

  view_courses_btn.addEventListener("click", () => {
    viewSheets.classList.remove("dashboard-active");
    setTimeout(function() {
      viewCourses.classList.toggle("dashboard-active");
      //viewSheets.classList.remove("dashboard-active");

    }, 300)
  })
  view_sheets_btn.addEventListener("click", () => {
    viewCourses.classList.remove("dashboard-active");
    setTimeout(function() {
      //viewCourses.classList.remove("dashboard-active");
      viewSheets.classList.toggle("dashboard-active");
    }, 300)
  })

  let read_btn = document.querySelectorAll(".read_btn");

  let Paymentmodalfunction_sheet = (btn) => {
    btn.forEach((e) => {
      e.addEventListener("click", () => {
        payment_popup = e.parentNode.parentNode.childNodes[5];
        closebtn = e.parentNode.parentNode.childNodes[5].childNodes[1].childNodes[1].childNodes[1].childNodes[1];
        payment_popup.style.display = "block";
        closebtn.onclick = function() {
          payment_popup.style.display = "none";
        };

        window.onclick = function(event) {
          if (event.target == payment_popup) {
            payment_popup.style.display = "none";
          }
        };

        copynumberBtn =
          payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
          .childNodes[0].childNodes[5].childNodes[0];

        copyIdBtn =
          payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
          .childNodes[2].childNodes[5].childNodes[0];

        copynumberBtn.onclick = () => {
          Bkash_number =
            payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
            .childNodes[0].childNodes[3].childNodes[0];
          Bkash_number.select();
          Bkash_number.setSelectionRange(0, 99999);
          navigator.clipboard.writeText(Bkash_number.value);
          copynumberBtn.innerHTML = "Copied";
        };

        copyIdBtn.onclick = () => {
          ref_id_number =
            payment_popup.childNodes[1].childNodes[3].childNodes[3].childNodes[1]
            .childNodes[2].childNodes[3].childNodes[0];
          ref_id_number.select();
          ref_id_number.setSelectionRange(0, 99999);
          navigator.clipboard.writeText(ref_id_number.value);
          copyIdBtn.innerHTML = "Copied";
        };
      });
    });
  };
  Paymentmodalfunction_sheet(read_btn);
</script>
</body>

</html>