<?php
ob_start();
session_start();
if (isset($_GET['id'])) {
    $sheet_id = $_GET["id"];
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

$title_sql = "select sheet_title from sheets where id=$sheet_id";
$title_stmt = mysqli_prepare($connection, $title_sql);
mysqli_stmt_execute($title_stmt);
mysqli_stmt_store_result($title_stmt);
mysqli_stmt_bind_result($title_stmt, $sheet_title);
mysqli_stmt_fetch($title_stmt);

$title = "$sheet_title - Macro School";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Sheets";

include("../../inc/header.php");

?>

<style>
    section.sheets {
        padding: 20px 0;
        background: white;
    }

    .sheet-container-left {
        width: 78%;
    }

    .sheet-container-right {
        width: 19%;
        text-align: center;
        border: 1px solid #ededed;
        background: white;
        padding: 10px;
    }

    .sheet-container {
        display: flex;
        background: #f7f7f7;
        justify-content: space-between;
    }

    .sheet-container-left-top {
        display: flex;
        gap: 55px;
        padding: 10px;
    }

    .sheet-info {
        text-align: center;
    }

    .sheet-img>img {
        width: 300px;
        padding: 15px;
        border: 1px solid #e5e5e5;
    }

    .sheet-info>h3 {
        margin: 25px 0;
        font-size: 19px;
        font-weight: 400;
    }

    .sheet-info>a {
        display: block;
    }

    .sheet-details {
        padding: 15px 10px;
        text-align: justify;
    }

    .free-sheet-img>img {
        width: 70px;
        padding: 5px;
        border: 1px solid #dfdfdf;
        display: grid;
        place-items: center;
    }

    .sheet-free-page {
        display: grid;
        gap: 10px;
        place-items: center;
    }

    .sheet-container-right>h4 {
        margin-bottom: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #409d91;
        color: #409d91;
    }

    .free-sheet-img {
        display: flex;
        gap: 10px;
    }

    .free-sheet-img>label {
        font-size: 12px;
    }

    .free-sheet-img:hover {
        box-shadow: 1px 1px 10px -5px #000000;
        transform: scale(1.1);
    }

    .course-category-list {
        background: #ededed;
        border-radius: 0;
    }

    /* Popup page */
    .sheet-page-view>img {
        width: 400px;
    }

    .sheet-page-view {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: grid;
        justify-content: center;
        background: gray;
        padding: 13px;
    }

    .sheet-page-view-popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%);
        background: rgb(0, 0, 0, 0.6);
        z-index: 11;
    }

    .sheet-page-view>button {
        padding: 10px 5px;
        background-color: #e73b3b;
        color: white;
        font-size: 13px;
        font-weight: bold;
    }

    .sheet-page-view>button:hover {
        background-color: white;
        color: #e73b3b;
        border: 1px solid #e73b3b;
    }


    @media screen and (max-width:600px) {
        .sheet-container {
            display: grid;
        }

        .sheet-container-left-top {
            display: grid;
            gap: 0;
            justify-content: center;
        }

        .sheet-container-left {
            width: 100%;
        }

        .sheet-container-right {
            width: 100%;
        }

        .free-sheet-img>img {
            width: 120px;
        }

        .sheet-page-view>img {
            width: 330px;
        }

        .sheet-free-page {
            display: block;
        }

        .free-sheet-img {
            display: inline-flex;
            margin-bottom: 10px;
        }

    }
</style>
<section class="sheets">
    <div class="container course-category-list">
        <h4> - Sheets / <?= $sheet_title; ?></h4>
    </div>
    <div class="container sheet-container">
        <?php
        $sheetSql = "SELECT `id`,`cat_id`,`faculties`,`main_image`,`free_img`,`sheet_title`,`sheet_details`,`sheet_hide`,regular_price,offer_price FROM `sheets` where id='$sheet_id'";
        $sheetStmt = fetch_data($connection, $sheetSql);
        if ($sheetStmt) {
            if (mysqli_stmt_num_rows($sheetStmt) == 0) {
                header("location: " . LINK . "error/404");
                die();
            }
            mysqli_stmt_bind_result($sheetStmt, $id, $cat_id, $faculties_id, $main_image, $free_img, $sheet_title, $sheet_details, $sheet_hide, $regular_price, $offer_price);
            while (mysqli_stmt_fetch($sheetStmt)) {
                //get teecher name
                $faculties_sql = "select name from faculties where id=$faculties_id";
                $faculties_stmt = fetch_data($connection, $faculties_sql);
                mysqli_stmt_bind_result($faculties_stmt, $teacher_name);
                mysqli_stmt_fetch($faculties_stmt);
                //get category name
                $category_sql = "select cat_name from course_category where id=$cat_id";
                $category_stmt = fetch_data($connection, $category_sql);
                mysqli_stmt_bind_result($category_stmt, $cat_name);
                mysqli_stmt_fetch($category_stmt);
                //filter route link
                $sheet_title_link = str_replace(" ", "-", $sheet_title);
                if ($sheet_hide == 1) {
        ?>
                    <div class="sheet-container-left">
                        <div class="sheet-container-left-top">
                            <div class="sheet-img">
                                <img src="<?= LINK; ?>public/images/<?= $main_image; ?>" alt="Macro School - sheet image">
                            </div>
                            <div class="sheet-info">
                                <h3><?= $sheet_title; ?></h3>
                                <h3>By - <?= $teacher_name; ?></h3>
                                <h3>Category - <?= $cat_name; ?></h3>
                                <?php if ($offer_price) { ?>
                                    <h3>TK. <del style="color:red"><?= $regular_price; ?>৳</del> <span style="color:green"><b><?= $offer_price; ?>৳</b></span></h3>
                                <?php } else { ?>
                                    <h3>TK. <span style="color:green"><b><?= $regular_price; ?>৳</b></span></h3>
                                <?php } ?>


                                <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                                    $double_ordered_check_sql = "select sheet_id from `sheet_order` where user_id=?";
                                    $double_ordered_check_stmt = mysqli_prepare($connection, $double_ordered_check_sql);
                                    mysqli_stmt_bind_param($double_ordered_check_stmt, "i", $param_double_ordered_check_id);
                                    $param_double_ordered_check_id = $_SESSION['id'];
                                    mysqli_stmt_execute($double_ordered_check_stmt);
                                    mysqli_stmt_store_result($double_ordered_check_stmt);
                                    mysqli_stmt_bind_result($double_ordered_check_stmt, $double_ordered_check_sheet_id);
                                    if (mysqli_stmt_num_rows($double_ordered_check_stmt) > 0) {
                                        while (mysqli_stmt_fetch($double_ordered_check_stmt)) {
                                            if ($sheet_id == $double_ordered_check_sheet_id) {
                                                $ordered_sheet = "আপনি শিটটি অর্ডার করে ফেলেছেন।";
                                            }
                                        }
                                    }

                                    if (isset($ordered_sheet)) {?>
                                    <p><?= $ordered_sheet; ?></p>
                                        <a href="<?= LINK; ?>dashboard" class="my-btn green">Goto Dashboard</a>
                                    <?php } else { ?>
                                        <a href="<?= LINK; ?>sheet-order/<?= $sheet_id; ?>" class="my-btn green">Buy Sheet</a>
                                    <?php }
                                } else { ?>
                                    <a href="<?= LINK; ?>login">
                                        <button class="my-btn green">শিট কিনতে লগইন করো</button>
                                    </a>
                                <?php } ?>
                                

                                <div class="my-btn share">
                                    <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="share icon- macroschool">
                                    Share with
                                    <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt="facebook share - marcoschool"></a>

                                    <a target="" href="https://api.whatsapp.com/send?text=Sheet - <?= $sheet_title; ?>%0Ahttps://macroschool.academy/sheet-details/<?= $id; ?>/<?= $sheet_title_link; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt="whatsapp share - marcoschool"></a>
                                </div>

                            </div>
                        </div>
                        <div class="sheet-container-left-bottom">
                            <div class="sheet-details">
                                উচ্চ মাধ্যমিক (HSC) ও বিশ্ববিদ্যালয় ভর্তি পরীক্ষায় পদার্থবিজ্ঞানের প্রয়োজনীয় সকল সূত্রাবলি একত্রে।উচ্চ মাধ্যমিক (HSC) ও বিশ্ববিদ্যালয় ভর্তি পরীক্ষায় পদার্থবিজ্ঞানের প্রয়োজনীয় সকল সূত্রাবলি একত্রে।উচ্চ মাধ্যমিক (HSC) ও বিশ্ববিদ্যালয় ভর্তি পরীক্ষায় পদার্থবিজ্ঞানের প্রয়োজনীয় সকল সূত্রাবলি একত্রে।
                            </div>
                        </div>
                    </div>
                    <div class="sheet-container-right">
                        <h4>Free Page</h4>
                        <div class="sheet-free-page">
                            <?php
                            //get all free img
                            $free_img = explode(',', $free_img);
                            $i = 1;
                            foreach ($free_img as $img) { ?>
                                <div id="free-sheet-img" class="free-sheet-img">
                                    <label for="sheet-img"><?= $i; ?></label>
                                    <img id="sheet-img" src="<?= LINK; ?>public/images/<?= $img; ?>" alt="Macro School - sheet image">
                                </div>
                            <?php $i++;
                            } ?>
                        </div>
                    </div>
        <?php
                }
            }
        } ?>
    </div>

    <div id="sheet-page-view-popup" class="sheet-page-view-popup">
        <div class="sheet-page-view">
            <button id="sheet-img-close">Close Page</button>
            <img id="popup-img-sheet" src="" alt="Sheet Page Popup">
        </div>
    </div>


</section>


<?php
include("../../inc/footer.php");
?>
<script>
    let img = document.querySelectorAll(".free-sheet-img");
    let popup_img = document.querySelectorAll(".sheet-page-view-popup")[0];
    let popup_img_sheet = document.getElementById("popup-img-sheet");
    let sheet_img_close = document.getElementById("sheet-img-close");

    img.forEach((e) => {
        e.addEventListener("click", () => {
            img_link = e.childNodes[3].getAttribute("src");

            popup_img.style.display = "block";
            popup_img_sheet.src = img_link;


            sheet_img_close.onclick = function() {
                popup_img.style.display = "none";
            }

        })
    })
</script>

<script src="<?= LINK; ?>main.js"></script>
</body>

</html>