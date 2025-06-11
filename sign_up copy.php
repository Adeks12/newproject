<?php
session_start();

include_once("libs/dbfunctions.php");

$dbobject = new dbobject();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


//Get default role for registration
$sql = "SELECT role_id FROM role WHERE role_name = 'Merchant' LIMIT 1";
$default_role = $dbobject->db_query($sql);
$role_id = isset($default_role[0]['role_id']) ? $default_role[0]['role_id'] : 002; // Default role ID for Merchant

//Check if user is already logged in

header("Cache-Control: no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove('X-Frame-Options: SAMEORIGIN');

$crossorigin = 'anonymous';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title>Register - Inventory System</title>

	<link rel="canonical" href="auth-sign-up-2.html" />
	<link rel="shortcut icon" href="img/favicon.ico">

	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">

	<link href="css/app.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

	<style>
		.password-container {
			position: relative;
			width: 100%;
		}

		.password-container input {
			width: 100%;
			padding-right: 40px;
		}

		.toggle-password {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			display: none;
			color: #666;
		}

		.toggle-password:hover {
			color: #333;
		}

		.loading-spinner {
			display: none;
			width: 20px;
			height: 20px;
			border: 2px solid #f3f3f3;
			border-top: 2px solid #3498db;
			border-radius: 50%;
			animation: spin 1s linear infinite;
			margin-right: 10px;
		}

		@keyframes spin{
			0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
		}

		.btn:disabled {
			opacity: 0.6;
			cursor: not-allowed;
		}

		.alert {
			padding: 12px 16px;
			margin-bottom: 20px;
			border: 1px solid transparent;
			border-radius: 4px;
		}

		.alert-success {
			color: #155724;
			background-color: #d4edda;
			border-color: #c3e6cb;
		}

		.alert-danger {
			color: #721c24;
			background-color: #f8d7da;
			border-color: #f5c6cb;
		}

		.alert-info {
			color: #0c5460;
			background-color: #d1ecf1;
			border-color: #bee5eb;
		}
	</style>

	<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q3ZYEKLQ68"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-Q3ZYEKLQ68');
	</script>
</head>

<body class="bg-light" style="min-height: 100vh; background:rgb(233, 251, 250)">
	<div class="container-fluid h-100 d-flex justify-content-center align-items-center">
		<div class="row shadow-lg bg-white rounded overflow-hidden w-100" style="max-width: 900px;">
			<!-- Branding Section -->
			<div
				class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center bg-primary text-white p-4">
				<div class="text-center">
					<h2 class="fw-bold">Welcome!</h2>
					<p class="mt-3">Join our inventory system and unlock a world of possibilities.</p>
					<img src="img/logo.png" alt="Brand Logo" style="max-width: 150px;" class="mt-4">
				</div>
			</div>

			<!-- Registration Form Section -->
			<div class="col-md-7 p-5">
				<div class="text-center mb-4">
					<h3 class="fw-bold">Create Account</h3>
					<p class="text-muted">Fill in the form to register.</p>
				</div>

				<!-- Alert Messages -->
				<div id="alertContainer"></div>

				<form id="registerForm" onsubmit="return false" autocomplete="off">
					<input type="hidden" name="op" value="Users.register">
					<input type="hidden" name="role_id" value="<?php echo $role_id; ?>">

					<div class="mb-3">
						<label class="form-label">Email <span class="text-danger">*</span></label>
						<input class="form-control" type="email" name="email" id="email" placeholder="Enter your email"
							required />
					</div>

					<div class="mb-3 password-container position-relative">
						<label class="form-label">Password <span class="text-danger">*</span></label>
						<input class="form-control" type="password" name="password" id="password"
							placeholder="Enter your password" required />
						<i class="fa fa-eye toggle-password position-absolute" data-target="password"
							style="right: 10px; top: 44px; cursor: pointer;"></i>
					</div>

					<div class="mb-3 password-container position-relative">
						<label class="form-label">Confirm Password <span class="text-danger">*</span></label>
						<input class="form-control" type="password" name="confirm_password" id="confirm_password"
							placeholder="Confirm your password" required />
						<i class="fa fa-eye toggle-password position-absolute" data-target="confirm_password"
							style="right: 10px; top: 44px; cursor: pointer;"></i>
					</div>

					<div class="d-grid gap-2">
						<button class="btn btn-success btn-lg" onclick="sendRegister('registerForm')" id="registerBtn">
							<span class="loading-spinner" id="loadingSpinner"></span>
							<span id="buttonText">Sign Up</span>
						</button>
					</div>

					<div class="text-center mt-4">
						Already have an account? <a href="auth-sign-in.html" class="text-decoration-none">Log In</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/parsely.js"></script>

	<script>
		// Global variables
		let isSubmitting = false;

		function showAlert(message, type = 'info') {
			const alertContainer = document.getElementById('alertContainer');
			const alertClass = type === 'success' ? 'alert-success' :
				type === 'error' ? 'alert-danger' : 'alert-info';

			alertContainer.innerHTML = `
				<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
					${message}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			`;

			// Auto-hide after 10 seconds
			setTimeout(() => {
				const alert = alertContainer.querySelector('.alert');
				if (alert) {
					alert.remove();
				}
			}, 10000);
		}

		function setButtonLoading(isLoading) {
			const button = document.getElementById('registerBtn');
			const spinner = document.getElementById('loadingSpinner');
			const buttonText = document.getElementById('buttonText');

			if (isLoading) {
				button.disabled = true;
				spinner.style.display = 'inline-block';
				buttonText.textContent = 'Creating Account...';
			} else {
				button.disabled = false;
				spinner.style.display = 'none';
				buttonText.textContent = 'Sign Up';
			}
		}

		function validateForm() {
			const email = document.getElementById('email').value.trim();
			const password = document.getElementById('password').value;
			const confirmPassword = document.getElementById('confirm_password').value;

			if (!email) {
				showAlert('Email is required', 'error');
				return false;
			}

			if (!password) {
				showAlert('Password is required', 'error');
				return false;
			}

			if (password.length < 6) {
				showAlert('Password must be at least 6 characters long', 'error');
				return false;
			}

			if (password !== confirmPassword) {
				showAlert('Passwords do not match', 'error');
				return false;
			}

			// Email validation
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(email)) {
				showAlert('Please enter a valid email address', 'error');
				return false;
			}

			return true;
		}

		function sendRegister(formId) {
			// Prevent double submission
			if (isSubmitting) {
				return false;
			}

			// Clear previous alerts
			document.getElementById('alertContainer').innerHTML = '';

			// Validate form
			if (!validateForm()) {
				return false;
			}

			isSubmitting = true;
			setButtonLoading(true);

			const formData = $("#" + formId).serialize();

			$.ajax({
				type: "POST",
				url: "utilities_default.php",
				data: formData,
				dataType: "json",
				timeout: 30000, // 30 seconds timeout
				success: function (response) {
					isSubmitting = false;
					setButtonLoading(false);

					if (response.response_code === 0) {
						// Success - show success message and redirect
						showAlert(response.response_message, 'success');

						// Show success alert with SweetAlert
						Swal.fire({
							icon: 'success',
							title: 'Registration Successful!',
							text: response.response_message,
							timer: 3000,
							showConfirmButton: false,
							allowOutsideClick: false
						});

						// Redirect after 3 seconds
						setTimeout(() => {
							if (response.data && response.data.redirect) {
								window.location.href = response.data.redirect;
							} else {
								window.location.href = 'verify_account.php';
							}
						}, 3000);

					} else if (response.response_code === 77) {
						// Email already exists and verified
						showAlert(response.response_message, 'error');
						Swal.fire({
							icon: 'error',
							title: 'Email Already Registered',
							text: response.response_message +
								' Please use a different email or try logging in.',
							confirmButtonText: 'OK'
						});

					} else {
						// Other errors
						showAlert(response.response_message, 'error');
						Swal.fire({
							icon: 'error',
							title: 'Registration Failed',
							text: response.response_message,
							confirmButtonText: 'Try Again'
						});
					}
				},
				error: function (xhr, status, error) {
					isSubmitting = false;
					setButtonLoading(false);

					let errorMessage = 'Unable to process request at the moment. Please try again.';

					if (status === 'timeout') {
						errorMessage = 'Request timed out. Please check your connection and try again.';
					} else if (xhr.status === 500) {
						errorMessage = 'Server error occurred. Please try again later.';
					}

					showAlert(errorMessage, 'error');
					Swal.fire({
						icon: 'error',
						title: 'Connection Error',
						text: errorMessage,
						confirmButtonText: 'OK'
					});
				}
			});

			return false;
		}

		// Password visibility toggle functionality
		function togglePasswordVisibility(inputId, icon) {
			const input = document.getElementById(inputId);
			if (input.type === 'password') {
				input.type = 'text';
				icon.classList.remove('fa-eye');
				icon.classList.add('fa-eye-slash');
			} else {
				input.type = 'password';
				icon.classList.remove('fa-eye-slash');
				icon.classList.add('fa-eye');
			}
		}

		// Initialize password toggle functionality
		document.addEventListener('DOMContentLoaded', function () {
			// Handle password field visibility
			document.querySelectorAll('.password-container input').forEach(input => {
				const icon = input.nextElementSibling;

				// Show/hide eye icon based on input content
				input.addEventListener('input', function () {
					icon.style.display = this.value ? 'block' : 'none';
				});

				// Toggle password visibility when clicking the eye icon
				icon.addEventListener('click', function () {
					togglePasswordVisibility(input.id, this);
				});
			});

			// Handle form submission with Enter key
			document.getElementById('registerForm').addEventListener('keypress', function (e) {
				if (e.key === 'Enter') {
					e.preventDefault();
					sendRegister('registerForm');
				}
			});

			// Real-time password confirmation validation
			document.getElementById('confirm_password').addEventListener('input', function () {
				const password = document.getElementById('password').value;
				const confirmPassword = this.value;

				if (confirmPassword && password !== confirmPassword) {
					this.setCustomValidity('Passwords do not match');
					this.classList.add('is-invalid');
				} else {
					this.setCustomValidity('');
					this.classList.remove('is-invalid');
				}
			});

			// Clear validation on password change
			document.getElementById('password').addEventListener('input', function () {
				const confirmPassword = document.getElementById('confirm_password');
				if (confirmPassword.value) {
					confirmPassword.dispatchEvent(new Event('input'));
				}
			});
		});

		// Prevent form resubmission on page refresh
		window.addEventListener('beforeunload', function () {
			if (isSubmitting) {
				return 'Registration is in progress. Are you sure you want to leave?';
			}
		});
	</script>
</body>

</html>