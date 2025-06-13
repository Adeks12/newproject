<?php
if (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') {
    ini_set('session.cookie_secure', true);
} else {
    ini_set('session.cookie_httponly', true);
}
include_once("libs/dbfunctions.php");

$dbobject = new dbobject();

// echo $dbobject->generateHTTP();

header("Cache-Control: no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');

$crossorigin = 'anonymous';
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">
	<meta http-equiv="Cache-control" content="no-cache;no-store">
	
	<title>Vuvaa Lifestyle</title>
	<link rel="stylesheet" href="css/parsley.css" integrity="<?php echo $dbobject->CORS('css/parsley.css') ?>" crossorigin="<?php echo $crossorigin ?>">
	<link rel="preconnect" href="http://fonts.gstatic.com/" crossorigin>
	<link rel="icon" href="img/icon.png" sizes="32x32" />
	
	<style>
		body {
			opacity: 0;
		}
	</style>
	<link class="js-stylesheet" href="css/light.css" rel="stylesheet" integrity="<?php echo $dbobject->CORS('css/light.css') ?>" crossorigin="<?php echo $crossorigin ?>">
	<script src="js/settings.js" integrity="<?php echo $dbobject->CORS('js/settings.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>

</head>

<body style="background: #64d18c">
	<main class="main d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2" style="color:#000">Welcome to The Vuvaa Lifestyle Website</h1>
							<p class="lead">
								Change Password
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<img src="img/icon.png" alt="Chris Wood" class="img-fluid rounded" width="132" height="132" />
									</div>
									<form id="form1" autocomplete="off">
										<input type="hidden" name="op" value="Users.doPasswordChange">
										<input type="hidden" name="page" value="first_login">
										<input type="hidden" name="username" value="<?php echo $_REQUEST['username']; ?>">
										<div class="form-group py-2">
											<label>Enter current password</label>
											<input class="form-control form-control-lg" type="password" name="current_password" required placeholder="Enter your current password" autocomplete="off" />
										</div>
										<div class="form-group py-2">
											<label>Enter new password</label>
											<input class="form-control form-control-lg" type="password" name="password" required placeholder="Enter your new password" autocomplete="off" />
										</div>
										<div class="form-group py-2">
											<label>Confirm Password</label>
											<input class="form-control form-control-lg" name="confirm_password" type="password" required placeholder="Confirm your password" autocomplete="off" />
											<small>
											</small>
										</div>
										<div>


										</div>
										<div id="server_mssg"></div>
										<div class="text-center mt-3">
											<a href="javascript:sendLogin('form1')" class="btn btn-lg btn-primary btn-block">Change Password</a>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- <script src="js/app.js"></script> -->
	<script src="js/jquery-3.6.0.min.js" integrity="<?php echo $dbobject->CORS('js/jquery-3.6.0.min.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
	<script src="js/jquery.blockUI.js" integrity="<?php echo $dbobject->CORS('js/jquery.blockUI.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
	<script src="js/parsely.js" integrity="<?php echo $dbobject->CORS('js/parsely.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>

	<script src="js/sweet_alerts.js" integrity="<?php echo $dbobject->CORS('js/sweet_alerts.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
	<script src="js/main.js" integrity="<?php echo $dbobject->CORS('js/main.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>

	<script>
		function sendLogin(id) {
			var forms = $('#' + id);
			forms.parsley().validate();
			if (forms.parsley().isValid()) {
				var data = $("#" + id).serialize();
				$.post("utilities_default.php", data, function(res) {
					var response = JSON.parse(res);
					if (response.response_code == 0) {
						$("#server_mssg").html(response.response_message);
						//						setTimeout(() => {
						//							window.location = 'home.php';
						//						}, 2000);
					} else {
						regenerateCORS();
						$("#server_mssg").html(response.response_message);
					}
				});
			}
		}
	</script>
</body>


<!-- Mirrored from appstack.bootlab.io/pages-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Jul 2019 15:57:14 GMT -->

</html>