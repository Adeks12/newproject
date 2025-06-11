<?php
include_once("libs/dbfunctions.php");
$dbobject = new dbobject();

// echo $dbobject->generateHTTP();
header("Cache-Control: no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');

$crossorigin = 'anonymous';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
	$operation  = 'edit';
	$id  = $_REQUEST['id'];
	$sql_collection_type = "SELECT * FROM collection_type WHERE id = '$id'";
	$collection_type     = $dbobject->db_query($sql_collection_type);
} else {
	$operation = 'new';
}
$username  = $_SESSION['username_sess'];
$user      = $dbobject->db_query("SELECT * FROM userdata WHERE username='$username'");
?>

<script>
	doOnLoad();
	var myCalendar;

	function doOnLoad() {
		myCalendar = new dhtmlXCalendarObject(["start_date"]);
		myCalendar.hideTime();
	}
</script>
<style>
	.asterik {
		color: red;
	}

	.ajax-upload-dragdrop,
	.ajax-file-upload-container {
		width: auto !important;
	}

	.ajax-file-upload-progress {
		width: 15px
	}

	.ajax-file-upload-container {
		overflow-x: hidden;
		/*        display: none;*/
		text-align: left;
	}

	.ajax-file-upload-statusbar {
		font-size: 12px;
	}
</style>
<div class="">
	<!--
    <div class="card-header">
        <h5 class="card-title mb-0">Change Password</h5>
    </div>
-->
	<!--    <div class= "card-body">-->
	<div class="row">
		<div class="col-md-4 col-xl-3" id="photo_display">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title mb-0">Profile Photo</h5>
				</div>
				<div class="card-body text-center">
					<img src="<?php echo $_SESSION['photo_path_sess']; ?>" id="avatar_profile" alt="Stacie Hall" class="img-fluid rounded-circle mb-2" width="128" height="128" />

					<h5 class="card-title mb-0"><?php echo $user[0]['firstname'] . " " . $user[0]['lastname'] ?></h5>
					<div class="text-muted mb-2"><?php echo $_SESSION['role_id_name'] ?></div>
					<div>
						<div id="fileuploader"></div>
						<div id="photo_response" style="color:green;display:none">Click on 'Save Changes' button to accept changes</div>
						<!--										<a class="btn btn-primary btn-block" href="#"><span data-feather="message-square"></span> Upload Photo</a>-->
					</div>

				</div>
				<hr class="my-0" />


			</div>
		</div>

		<div class="col-md-8 col-xl-9">
			<div class="card">
				<div class="card-header">
					<div class="card-actions float-right">
						<div class="dropdown show">
							<a href="javascript:saveRecord()" class="btn btn-sm btn-success" style="color:#fff">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle mr-2">
									<path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
								</svg>Save Changes
							</a>
						</div>
					</div>
					<h5 class="card-title mb-0">Bio Data</h5>
				</div>
				<div class="card-body h-100">
					<form action="" id="form1" autocomplete="off">
						<input type="hidden" name="op" value="Users.profileEdit">
						<input type="hidden" name="username" value="<?php echo $username; ?>">
						<input type="hidden" name="photo" id="photo" value="<?php echo $_SESSION['photo_file_sess'] ?>">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">First Name<span class="asterik">*</span></label>
									<input type="text" name="firstname" value="<?php echo $user[0]['firstname'] ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">Last Name<span class="asterik">*</span></label>
									<input type="text" name="lastname" value="<?php echo $user[0]['lastname'] ?>" class="form-control" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">Phone Number<span class="asterik">*</span></label>
									<input type="number" name="mobile_phone" value="<?php echo $user[0]['mobile_phone'] ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="form-label">Gender<span class="asterik">*</span></label>
									<select class="form-control" name="sex" id="sex">
										<option value="male" <?php echo ($user[0]['sex'] == "male") ? "selected" : ""; ?>>Male</option>
										<option value="female" <?php echo ($user[0]['sex'] == "female") ? "selected" : ""; ?>>Female</option>
									</select>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<?php
			if ($_SESSION['role_id_sess'] != 001) {
			?>
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Church Information</h5>
					</div>
					<div class="card-body h-100">
						<form action="">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Church Name</label>
										<div><?php echo $_SESSION['church_name_sess']; ?></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Church ID</label>
										<div><?php echo $_SESSION['church_id_sess']; ?></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Church Address</label>
										<div><?php echo $dbobject->getitemlabel('church_table', 'church_id', $_SESSION['church_id_sess'], 'address'); ?></div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="form-label">Category</label>
										<div><?php echo $dbobject->getitemlabel('church_type', 'id', $_SESSION['church_type_id_sess'], 'name'); ?></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</div>
	<!--    </div>-->
</div>
<link rel="stylesheet" href="css/uploadfile.css" integrity="<?php echo $dbobject->CORS('css/uploadfile.css') ?>" crossorigin="<?php echo $crossorigin ?>">
<script src="js/jquery.uploadfile.min.js" integrity="<?php echo $dbobject->CORS('js/jquery.uploadfile.min.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
<script>
	$(document).ready(function() {
		$("#fileuploader").uploadFile({
			url: "upload.php",
			fileName: "upfile",
			showPreview: false,
			uploadStr: "Upload Photo",
			statusBarWidth: "50%",
			previewHeight: "100px",
			previewWidth: "100px",
			allowedTypes: "jpg,png",
			maxFileSize: 1000000,
			onSelect: function(files) {
				$("#photo_response").css('display', 'none');
				return true; //to allow file submission.
			},
			onSubmit: function(files) {
				$("#photo_display").block({
					message: 'processing image'
				});

				//files : List of files to be uploaded
				//return flase;   to stop upload
			},
			onSuccess: function(files, data, xhr, pd) {
				$("#photo_display").unblock();
				var resss = JSON.parse(data);
				if (resss.response_code == 0) {
					$("#photo").val(resss.data.file + "." + resss.data.ext);
					$("#avatar_profile").attr('src', 'img/profile_photo/' + resss.data.file + "." + resss.data.ext);
					$("#photo_response").css('display', 'block');
				} else {
					$("#photo_response").css('display', 'block');
					$("#photo_response").css('color', 'red');
					$("#photo_response").text(resss.response_message);
				}
			}
		});
	});

	function saveRecord() {
		$.blockUI();
		$("#save_facility").text("Loading......");
		var dd = $("#form1").serialize();
		$.post("utilities.php", dd, function(re) {
			$.unblockUI();
			$("#save_facility").text("Save");
			console.log(re);
			if (re.response_code == 0) {
				alert(re.response_message);
			} else
				regenerateCORS();
			alert(re.response_message)
		}, 'json')
	}
</script>