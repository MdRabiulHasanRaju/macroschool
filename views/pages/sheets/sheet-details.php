<?php
ob_start();
session_start();
if (isset($_GET['id'])) {
    $course_id = $_GET["id"];
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";

$title_sql = "select course_title from sheets where id=$course_id";
$title_stmt = mysqli_prepare($connection, $title_sql);
mysqli_stmt_execute($title_stmt);
mysqli_stmt_store_result($title_stmt);
mysqli_stmt_bind_result($title_stmt, $course_title);
mysqli_stmt_fetch($title_stmt);

require_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
$title = "$course_title - Macro School";
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
        width: 90px;
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
    }
</style>
<section class="sheets">
    <div class="container course-category-list">
        <h4> - Sheets / <?= $course_title; ?></h4>
    </div>
    <div class="container sheet-container">
        <div class="sheet-container-left">
            <div class="sheet-container-left-top">
                <div class="sheet-img">
                    <img src="<?= LINK; ?>public/images/sheet1.jpg" alt="Macro School - sheet image">
                </div>
                <div class="sheet-info">
                    <h3>Physics 1st Paper</h3>
                    <h3>By - Sajjad Alom</h3>
                    <h3>Category - Physics</h3>

                    <h3>TK. <del style="color:red">100৳</del> <span style="color:green"><b>30৳</b></span></h3>

                    <a href="" class="my-btn green">Buy Sheet</a>

                    <div class="my-btn share">
                        <img style="width:15px" src="<?= LINK; ?>public/images/icon/share.png" alt="">
                        Share with
                        <a target="_blank" href="https://facebook.com/sharer/sharer.php?u=https://macroschool.academy/course-details/<?= $id; ?>"><img src="<?= LINK; ?>public/images/icon/facebook.png" alt=""></a>

                        <a target="" href="https://api.whatsapp.com/send?text=<?= $course_sub_title; ?>%20<?= $course_title; ?>%0Ahttps://macroschool.academy/course-details/<?= $id; ?>"><img src="<?= LINK; ?>public/images/icon/whatsapp.png" alt=""></a>
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
                <div id="free-sheet-img" class="free-sheet-img">
                    <label for="sheet-img">1</label>
                    <img id="sheet-img" src="<?= LINK; ?>public/images/sheet1.jpg" alt="Macro School - sheet image">
                </div>
                <div class="free-sheet-img">
                    <label for="sheet-img">2</label>
                    <img id="sheet-img" src="<?= LINK; ?>public/images/sheet2.jpg" alt="Macro School - sheet image">
                </div>
                <div class="free-sheet-img">
                    <label for="sheet-img">3</label>
                    <img id="sheet-img" src="<?= LINK; ?>public/images/sheet3.jpg" alt="Macro School - sheet image">
                </div>
            </div>
        </div>
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