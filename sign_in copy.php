<?php
session_start();

include_once("libs/dbfunctions.php");

$dbobject = new dbobject();

header("Cache-Control: no-cache, no-store, must-revalidate");
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

    <title>Login - Inventory System</title>

    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">

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
    </style>

    <script src="js/settings.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q3ZYEKLQ68"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-Q3ZYEKLQ68');
    </script>
</head>

<body class="bg-light" style="min-height: 100vh; background:rgb(233, 251, 250)">
    <div class="container-fluid h-100 d-flex justify-content-center align-items-center">
        <div class="row shadow-lg bg-white rounded overflow-hidden w-100" style="max-width: 900px;">
            <!-- Branding Section -->
            <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center bg-primary text-white p-4">
                <div class="text-center">
                    <h2 class="fw-bold">Welcome Back!</h2>
                    <p class="mt-3">Login to your inventory system account.</p>
                    <img src="img/logo.png" alt="Brand Logo" style="max-width: 150px;" class="mt-4">
                </div>
            </div>

            <!-- Login Form Section -->
            <div class="col-md-7 p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Sign In</h3>
                    <p class="text-muted">Enter your credentials to access your account.</p>
                </div>
                <form id="loginForm" onsubmit="return false" autocomplete="off">
                    <input type="hidden" name="op" value="Users.login">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="username" name="username" id="username" placeholder="Enter your email" required />
                    </div>

                    <div class="mb-3 password-container position-relative">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" id="login_password" placeholder="Enter your password" required />
                        <i class="fa fa-eye toggle-password position-absolute" data-target="login_password" style="right: 10px; top: 44px; cursor: pointer;"></i>
                    </div>

                    <div id="login_mssg" class="mb-3"></div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" onclick="sendLogin('loginForm')" id="loginBtn">Sign In</button>
                    </div>

                    <div class="text-center mt-4">
                        Don't have an account? <a href="sign_up.php" class="text-decoration-none">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="js/parsely.js"></script>
    <script src="js/sweet_alerts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/main.js"></script>
    <script>
        function sendLogin(id) {
            var forms = $('#' + id);
            var email = $("#login_email").val();
            forms.parsley().validate();
            if (forms.parsley().isValid()) {
                $.blockUI();
                var data = $("#" + id).serialize();

                $.ajax({
                    type: "post",
                    url: "utilities_default.php",
                    data: data,
                    dataType: "json",
                    beforeSend: function () {
                        $.blockUI({
                            message: "Processing..... Please wait...",
                        });
                    },
                    success: function (data) {
                        $.unblockUI();
                        var response = data;
                        if (response.response_code == 0) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful',
                                text: response.response_message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location = response.data.redirect;
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: response.response_message
                            });
                        }
                    },
                    error: function () {
                        $.unblockUI();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: "Unable to process request at the moment! Please try again"
                        });
                    },
                });
            }
        }

        // Function to toggle password visibility
        function togglePasswordVisibility(inputId, icon) {
            const input = icon.previousElementSibling;
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

        // Add event listeners for password fields
        document.querySelectorAll('.password-container input').forEach(input => {
            const icon = input.nextElementSibling;

            // Show/hide eye icon based on input content
            input.addEventListener('input', function () {
                icon.style.display = this.value ? 'block' : 'none';
            });

            // Toggle password visibility when clicking the eye icon
            icon.addEventListener('click', function () {
                togglePasswordVisibility(this.dataset.target, this);
            });
        });
    </script>
</body>
</html>