<?php
session_start();
$title = "Macro School - All Order";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Home";
?>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");

if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {
	include "views/inc/header.php";
?>

	<?php
	include "views/pages/home/home.php";
	?>

	<?php
	include "views/inc/footer.php";
	?>

	<script src="public/js/app.js"></script>

	</body>

	</html>
<?php
} else {
	header("location: " . ADMIN_LINK . "login");
	die();
}
?>