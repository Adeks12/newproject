<?php
session_start();

include_once("libs/dbfunctions.php");

$dbobject = new dbobject();

// echo $dbobject->generateHTTP();

header("Cache-Control:  no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');

$crossorigin = 'anonymous';
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">
	<meta http-equiv="Cache-control" content="no-cache;no-store">

	<title>Vuvaa Lifestyle</title>
	<link class="js-stylesheet" href="css/light.css" rel="stylesheet" integrity="<?php echo $dbobject->CORS('css/light.css') ?>" crossorigin="<?php echo $crossorigin ?>">
	<link rel="preconnect" href="http://fonts.gstatic.com/" crossorigin>
	<link rel="icon" href="img/icon.png" sizes="32x32" />

	<style>
		body {
			opacity: 0;
		}
	</style>
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
								Forgot Password
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<img src="img/icon.png" alt="Chris Wood" class="img-fluid rounded" width="132" height="132" />
									</div>
									<form id="form1" autocomplete="off">
										<input type="hidden" name="op" value="Users.generatePwdLink">
										<div class="form-group">
											<label>Enter Username</label>
											<input class="form-control form-control-lg" type="text" name="username" required placeholder="Enter your username" autocomplete="off" />
										</div>

										<div>


										</div>

										<div id="server_mssg"></div>
										<div class="text-center mt-3 mb-2">
											<a href="javascript:sendLogin('form1')" class="btn btn-lg btn-primary btn-block">Send Reset Link</a>
											<a href="index.php">I remember now.</a>
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
				$.blockUI();
				var data = $("#" + id).serialize();
				$.post("utilities_default.php", data, function(res) {
					$.unblockUI();
					var response = JSON.parse(res);
					if (response.response_code == 0) {
						$("#server_mssg").html(response.response_message);

					} else {
						regenerateCORS();
						$("#server_mssg").html(response.response_message);
					}
				});
			}
		}
	</script>
</body>

</html>