<?php
include_once("libs/dbfunctions.php");
include_once("class/users.php");

$dbobject = new dbobject();
// echo $dbobject->generateHTTP();
header("Cache-Control: no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');

$crossorigin = 'anonymous';

$user = new Users();
$result = json_decode($user->verifyLink($_REQUEST['ga']), TRUE);

if ($result['response_code'] != 0) {
    echo "<h3>" . $result['response_message'] . "</h3>";
} else {

?>
    <!DOCTYPE html>
    <html lang="en">


    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
        <meta name="author" content="Bootlab">
        <meta http-equiv="Cache-control" content="no-cache;no-store">
        <title>Vuvaa Lifestyle</title>
        <link rel="stylesheet" href="css/parsley.css" integrity="<?php echo $dbobject->CORS('css/parsley.css') ?>" crossorigin="<?php echo $crossorigin ?>">
        <link rel="preconnect" href="http://fonts.gstatic.com/" crossorigin>
        <link rel="icon" href="img/icon.png" sizes="32x32" />
        <!-- PICK ONE OF THE STYLES BELOW -->
        <link href="css/light.css" rel="stylesheet" integrity="<?php echo $dbobject->CORS('css/light.css') ?>" crossorigin="<?php echo $crossorigin ?>">

        <style>
            body {
                opacity: 0;
            }
        </style>
        <script src="js/settings.js" integrity="<?php echo $dbobject->CORS('js/settings.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>

        <script>
            doOnLoad();
            var myCalendar;

            function doOnLoad() {
                myCalendar = new dhtmlXCalendarObject(["start_date"]);
                myCalendar.hideTime();
            }
        </script>
        <body">
            <main class="main d-flex w-100">
                <div class="container d-flex flex-column">
                    <div class="row">
                        <div class="col-sm-12 col-md-8 col-lg-6 mx-auto d-table h-100">
                            <div class="d-table-cell align-middle">

                                <div class="text-center mt-4">
                                    <h1 class="h2">Welcome <?php echo $result['data']['lastname'] . " " . $result['data']['firstname'] ?> to Welcome to The Vuvaa Lifestyle Website</h1>
                                    <p class="lead">
                                        Sign in to your account
                                    </p>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Password Reset</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="form1">
                                            <input type="hidden" name="op" value="Users.doForgotPasswordChange">
                                            <input type="hidden" name="username" value="<?php echo $result['data']['username'] ?>">

                                            <div class="form-group">
                                                <label>Enter password</label>
                                                <input class="form-control form-control-lg" type="password" name="password" required placeholder="Enter your new password" autocomplete="off" />
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input class="form-control form-control-lg" name="confirm_password" type="password" required placeholder="Confirm your password" autocomplete="off" />
                                                <small>
                                                </small>
                                            </div>
                                            <div>


                                            </div>
                                            <div id="server_mssg"></div>
                                            <div class="text-center mt-3">
                                                <a href="javascript:saveRecord()" class="btn btn-lg btn-primary btn-block">Change Password</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <script src="js/jquery-3.6.0.min.js" integrity="<?php echo $dbobject->CORS('js/jquery-3.6.0.min.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
                                <script src="js/jquery.blockUI.js" integrity="<?php echo $dbobject->CORS('js/jquery.blockUI.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
                                <script src="js/parsely.js" integrity="<?php echo $dbobject->CORS('js/parsely.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>

                                <script src="js/sweet_alerts.js" integrity="<?php echo $dbobject->CORS('js/sweet_alerts.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
                                <script src="js/main.js" integrity="<?php echo $dbobject->CORS('js/main.js') ?>" crossorigin="<?php echo $crossorigin ?>"></script>
                                <script>
                                    function saveRecord() {
                                        $("#save_facility").text("Loading......");
                                        var dd = $("#form1").serialize();
                                        $.post("utilities_default.php", dd, function(re) {
                                            $("#save_facility").text("Save");
                                            // console.log(re);
                                            if (re.response_code == 0) {
                                                alert(re.response_message);
                                                setTimeout(() => {
                                                    window.location = 'logout.php';
                                                }, 2000);
                                            } else
                                                regenerateCORS();
                                            alert(re.response_message)
                                        }, 'json')
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            </body>
        <?php
    }
        ?>