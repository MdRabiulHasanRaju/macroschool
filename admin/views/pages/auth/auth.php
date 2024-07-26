<?php
session_start();
$title = "Macro School Admin - Login";
$meta_description = "$title - macro school";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "Login";

include $_SERVER['DOCUMENT_ROOT'] . "/macroschool/admin/utility/Baseurl.php";
$baseurl = new Baseurl;
define("ADMIN_LINK", "{$baseurl->url()}/macroschool/admin/");
define("IMAGE_LINK", "{$baseurl->url()}/macroschool/public/images/");


if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] == true) {

	header("location: " . ADMIN_LINK);
	exit;
} else {
	include("../../inc/header.php");
	$err = "";
	if (isset($_SESSION["err"])) {
		$err = $_SESSION["err"];
	}

?>

	<style>
		#sidebar {
			display: none;
		}

		#adminTopBar {
			display: none;
		}
	</style>
	<div class="container d-flex flex-column">
		<div class="row vh-100">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="text-center mt-4">
						<h1 class="h2">Macro School, Admin</h1>
						<p class="lead">
							Log in to your admin account to continue
						</p>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="m-sm-4">
								<div class="text-center">
									<img src="<?= IMAGE_LINK; ?>logo.jpg" alt="Charles Hall" class="img-fluid " width="132" height="132" />
								</div>
								<form method="post" action="<?= ADMIN_LINK; ?>controllers/loginController.php">
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input class="form-control form-control-lg" type="email" name="username" placeholder="Enter your email" />
									</div>
									<div class="mb-3">
										<label class="form-label">Password</label>
										<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter your password" />
										<div id="password_view">
											<img id="password_view_img" src="<?= IMAGE_LINK; ?>icon/password-view.png" alt="password-view">
										</div>
										<span style="color:red"><?php echo $err;
																unset($_SESSION['err']); ?></span>
									</div>
									<div class="text-center mt-3">
										<button name="submit" type="submit" class="btn btn-lg btn-primary">Log in</button>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php
	include("../../inc/footer.php");
}
?>
<script src="<?= ADMIN_LINK; ?>public/js/app.js"></script>
<script src="<?= ADMIN_LINK; ?>main.js"></script>
</body>

</html>