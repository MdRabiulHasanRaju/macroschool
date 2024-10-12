<?php
ob_start();
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/utility/Baseurl.php";
$baseurl = new Baseurl;
define("LINK", "{$baseurl->url()}/macroschool/");
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    include_once $_SERVER['DOCUMENT_ROOT'] . "/macroschool/lib/Database.php";
    isset($_SESSION['id']) ? $userID = $_SESSION['id']:$userID = 0;
    $commentSql = "SELECT * FROM comment WHERE user_id='$userID' order by id desc";
    $result = mysqli_query($connection, $commentSql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['author_name'] == "admin") {
                echo '<div style="display: flex;align-items:center;gap:10px;justify-content:left;padding:10px;flex-direction:row-reverse" class="all-comments">';
            } else {
                echo '<div style="display: flex;align-items:center;gap:10px;justify-content:right;padding:10px;" class="all-comments">';
            }
?>
            <p><?= $row['msg']; ?></p>
            <img style="width: 40px;border: 1px solid #cfcfcf;border-radius: 50%;" src="<?= LINK; ?>public/images/icon/<?= $row['author_image']; ?>" alt="userImg">
            </div>
<?php    }
    } else {
        echo '<div style="display: flex;align-items:center;gap:10px;justify-content:center;padding:10px;" class="all-comments">
            <p>There Are No Questions/Answer!</p>
        </div>';
    }
}else {
    echo '<div style="display: flex;align-items:center;gap:10px;justify-content:center;padding:10px;" class="all-comments">
        <a style="color:#dc555b" href="'.LINK.'login"><b>To ask and answer questions, please Log in!</b></a>
    </div>';
}
?>