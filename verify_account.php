<?php
session_start();
include_once("libs/dbfunctions.php");
include_once("libs/encryption.php"); 
include_once("class/users.php");
$users = new Users();
$dbobject = new dbobject();

$email = '';
$is_valid = false;
$error_message = '';

if (!isset($_SESSION['pending_verification_email'])) {
    $error_message = "Invalid verification request. Session expired.";
    header("Location: sign_up.php?error=" . urlencode("Please register first to verify your account."));
    exit;
} else {
    $email = $_SESSION['pending_verification_email'];
    $masked = $users->mask_email($email);
    $is_valid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify Account - Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-tr from-cyan-50 to-cyan-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-xl">
        <?php if (!$is_valid): ?>
            <div class="text-center text-red-600 font-semibold">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <div class="text-center mt-4">
                <a href="sign_up.php" class="text-blue-600 hover:underline">Back to Registration</a>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-700 mb-1">Verify your email</h1>
                        <p class="text-sm text-gray-600 mb-2">
                            Enter the 6-digit code sent to
                            <strong class="text-gray-900"><?php echo htmlspecialchars($masked); ?></strong>
                        </p>
                    </div>
                    <div class="phone-anim-container">
                        <div class="phone-anim">
                            <div class="phone-body"></div>
                            <div class="phone-screen">
                                <div class="phone-buttons">
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                    <div class="phone-btn"></div>
                                </div>
                            </div>
                            <div class="asterisk asterisk1">*</div>
                            <div class="asterisk asterisk2">*</div>
                            <div class="asterisk asterisk3">*</div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="verificationForm" onsubmit="return false" autocomplete="off" class="space-y-4">
                <input type="hidden" name="op" value="Users.verifyOTP">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="hidden" name="code" id="verification_code_combined" />

                <div class="flex justify-center gap-2">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="text" maxlength="1"
                            class="w-12 h-12 text-2xl text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 code-input"
                            inputmode="numeric" pattern="[0-9]*">
                    <?php endfor; ?>
                </div>

                <div id="verification_mssg" class="text-center text-red-500 text-sm mt-2"></div>

                <div class="mt-6">
                    <button onclick="verifyCode('verificationForm')"
                        class="w-full bg-cyan-600 hover:bg-cyan-700 text-white py-2 rounded-lg font-medium">
                        Verify Account
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="javascript:void(0)" onclick="resendCode()" class="text-blue-600 hover:underline">Didn't receive a code? Resend</a>
            </div>
            <div class="text-center mt-2">
                <a href="sign_up.php" class="text-gray-500 hover:underline text-sm">Back to registration</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script>
        function verifyCode(formId) {
            var form = $('#' + formId);
            var otp = '';
            $('.code-input').each(function () {
                otp += $(this).val();
            });
            $('#verification_code_combined').val(otp);

            $.blockUI({
                message: 'Verifying... Please wait...'
            });

            $.ajax({
                type: 'POST',
                url: 'utilities_default.php',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $.unblockUI();
                    if (response.response_code === 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Verification Successful',
                            text: response.response_message,
                            timer: 2500,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location = 'home.php?verified=true';
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Verification Failed',
                            text: response.response_message
                        });
                    }
                },
                error: function () {
                    $.unblockUI();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to process request at the moment. Please try again.'
                    });
                }
            });
        }

        function resendCode() {
            $.blockUI({
                message: 'Resending code... Please wait...'
            });

            $.ajax({
                type: 'POST',
                url: 'utilities_default.php',
                data: {
                    op: 'Users.resendVerificationCode'
                },
                dataType: 'json',
                success: function (response) {
                    $.unblockUI();
                    if (response.response_code === 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Code Resent',
                            text: 'A new verification code has been sent to your email.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Resend',
                            text: response.response_message
                        });
                    }
                },
                error: function () {
                    $.unblockUI();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not resend verification code.'
                    });
                }
            });
        }

		const inputs = document.querySelectorAll('.code-input');
		inputs.forEach((input, idx, arr) => {
		input.addEventListener('input', () => {
		if (input.value.length === 1 && idx < arr.length - 1) { arr[idx + 1].focus(); } // Check if all fields are filled let
			allFilled=Array.from(arr).every(i=> i.value.length === 1);
			if (allFilled) {
			verifyCode('verificationForm');
			}
			});

			input.addEventListener('keydown', (e) => {
			// Allow backspace to move to previous input
			if (e.key === "Backspace" && input.value === '' && idx > 0) {
			arr[idx - 1].focus();
			}
			});
			});
    </script>
    <style>
        /* Phone animation styles */
        .phone-anim-container {
            width: 70px;
            height: 90px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .phone-anim {
            position: relative;
            width: 48px;
            height: 80px;
        }
        .phone-body {
            width: 48px;
            height: 80px;
            background: rgb(205, 234, 240);
            border: 2px rgb(3, 5, 9);
            border-radius: 16px;
            position: absolute;
            left: 0;
            top: 0;
            box-shadow: 0 4px 12px rgba(214, 221, 230, 0.08);
        }
        .phone-screen {
            width: 36px;
            height: 56px;
            background: #fff;
            border-radius: 8px;
            position: absolute;
            left: 6px;
            top: 12px;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.04);
        }
        .phone-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 3px;
            position: absolute;
            top: 10px;
            left: 5px;
            width: 26px;
            height: 36px;
        }
        .phone-btn {
            width: 7px;
            height: 7px;
            background: rgb(159, 238, 217);
            border: 1px rgb(12, 21, 34);
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(13, 110, 253, 0.07);
        }
        .asterisk {
            position: absolute;
            font-size: 1.3rem;
            color: rgb(10, 10, 10);
            font-weight: bold;
            opacity: 0.85;
            animation: popasterisk 1.8s infinite;
            pointer-events: none;
            user-select: none;
        }
        .asterisk1 {
            left: 17px;
            top: -18px;
            animation-delay: 0s;
        }
        .asterisk2 {
            left: -10px;
            top: -18px;
            animation-delay: 0.5s;
        }
        .asterisk3 {
            left: 38px;
            top: -18px;
            animation-delay: 1s;
        }
        @keyframes popasterisk{
            0% {
                transform: scale(0.7) translateY(0);
                opacity: 0.7;
            }
            20% {
                transform: scale(1.1) translateY(-18px);
                opacity: 1;
            }
            40% {
                transform: scale(0.9) translateY(-10px);
                opacity: 0.8;
            }
            60% {
                transform: scale(0.7) translateY(0);
                opacity: 0.7;
            }
            100% {
                transform: scale(0.7) translateY(0);
                opacity: 0.7;
            }
        }
    </style>
</body>
</html>
