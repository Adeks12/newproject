<?php
require_once('libs/dbfunctions.php');
$dbobject = new dbobject();
$crossorigin = 'anonymous';

@session_start();
if (!isset($_SESSION['username_sess'])) {
    header('location: sign_in.php');
    exit;
}

require_once('class/menu.php');
$menu = new Menu();
$menu_list = $menu->generateMenu($_SESSION['role_id_sess']);
$menu_list = $menu_list['data'];

$sql = "SELECT bank_name,account_no,account_name,registration_completed, merchant_id FROM userdata WHERE username = '$_SESSION[username_sess]' LIMIT 1 ";
$user_det = $dbobject->db_query($sql);

$registration_complete = isset($user_det[0]['registration_completed']) ? $user_det[0]['registration_completed'] : 0;
$merchant_id = isset($user_det[0]['merchant_id']) ? $user_det[0]['merchant_id'] : 0;

$sql2 = "SELECT * FROM merchant_reg WHERE merchant_id = '$merchant_id' LIMIT 1";
$user_det2 = $dbobject->db_query($sql2);
$merchant_first_name = isset($user_det2[0]['merchant_business_name']) ? $user_det2[0]['merchant_business_name'] : '';
// $merchant_last_name = isset($user_det2[0]['merchant_last_name']) ? $user_det2[0]['merchant_last_name'] : '';
$merchant_email = isset($user_det2[0]['merchant_email']) ? $user_det2[0]['merchant_email'] : '';

header("Cache-Control: no-cache;no-store, must-revalidate");
header_remove("X-Powered-By");
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');

// Get active department count using your Department class
require_once('class/department.php');
$deptObj = new Department();
$merchant_id = $_SESSION['merchant_id'] ?? '';
$active_dept_count = 0;
if ($merchant_id) {
    $sql = "SELECT COUNT(*) as cnt FROM department WHERE merchant_id='$merchant_id' AND depmt_status='1'";
    $result = $dbobject->db_query($sql);
    $active_dept_count = isset($result[0]['cnt']) ? $result[0]['cnt'] : 0;
}

// Get total number of employed staffs (staff_status = '1')
// $staff_count = 0;
// $sql_staff = "SELECT COUNT(*) as cnt FROM staff WHERE merchant_id='$merchant_id' AND staff_status
// $result_staff = $dbobject->db_query($sql_staff, true);
// $staff_count = isset($result_staff[0]['cnt']) ? $result_staff[0]['cnt'] : 0;

// Add this before your HTML output to get total new inventory count
$total_new_inventory = 0;
$sql_inventory = "SELECT COUNT(*) as cnt FROM inventory WHERE merchant_id='$merchant_id' AND delete_status != '1'";
$result_inventory = $dbobject->db_query($sql_inventory, true);
$total_new_inventory = isset($result_inventory[0]['cnt']) ? $result_inventory[0]['cnt'] : 0;
?>


<!doctype html>
<html lang="en" >

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Qovex - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        
    <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" /> 

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

        <!-- jquery.vectormap css -->
        <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
            type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css"  id="app-style"  rel="stylesheet" type="text/css" />

    </head>

    <body data-layout="detached" data-topbar="colored">



        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">

                          
                          

                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            <div class="dropdown d-inline-block">
                               
                               
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-2.jpg"
                                        alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1"><?php echo $merchant_first_name ?></span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#" onclick="getpage('profile.php','page'); return false;">
    <i class="bx bx-user font-size-16 align-middle me-1"></i> Profile
</a>
                                     <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="logout.php"  onclick="event.preventDefault();confirmLogout();"><i
                                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                                </div>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button  type="button" class="btn header-item noti-icon right-bar-toggle waves-effect" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class="mdi mdi-settings-outline"></i>
                                </button>
                            </div>

                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="index.html" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/images/logo-dark.png" alt="" height="17">
                                    </span>
                                </a>

                                <a href="index.html" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/images/logo-light.png" alt="" height="19">
                                    </span>
                                </a>
                            </div>

                            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->
                            <!-- <form class="app-search d-none d-lg-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form> -->

                         </div>

                    </div>
                </div>
            </header> <!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-md mx-auto rounded-circle">
            </div>

            <div class="mt-3">

                <a href="#" class="text-body fw-medium font-size-16"><?php echo $merchant_first_name?></a>
                <p class="text-muted mt-1 mb-0 font-size-13"><?php echo $merchant_email ?></p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'home.php') ? 'active' : '';?>">
                    <a href="home.php" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php
                $icon_map = [
                        // Dashboard & Overview
                        'dashboard' => 'mdi-view-dashboard',
                        'overview cards' => 'mdi-view-dashboard-outline',
                        'total items' => 'mdi-format-list-bulleted',
                        'allocated' => 'mdi-checkbox-marked-circle',
                        'available' => 'mdi-checkbox-blank-circle',
                        'quick charts' => 'mdi-chart-donut',
                        'recent stock movement' => 'mdi-chart-line',

                        // Company Management
                        'company management' => 'mdi-domain',
                        'profile' => 'mdi-account-circle-outline',
                        'settings' => 'mdi-settings-outline',

                        // Staff & Accounts
                        'staff & accounts' => 'mdi-account-group-outline',
                        'manage staff' => 'mdi-account-plus-outline',
                        'manage sub-accounts' => 'mdi-account-multiple-outline',
                        'manage departments' => 'mdi-office-building',

                        // Inventory
                        'inventory' => 'mdi-archive-outline',
                        'item categories' => 'mdi-format-list-bulleted-type',
                        'all items' => 'mdi-cube-outline',
                        'replenish' => 'mdi-truck-fast-outline',
                        'restock/ replenish' => 'mdi-truck-fast-outline',
                        'damaged items' => 'mdi-delete-forever-outline',

                        // Allocation
                        'allocation' => 'mdi-swap-horizontal',
                        'allocate items' => 'mdi-arrow-right-bold-box-outline',
                        'view allocations' => 'mdi-eye-outline',
                        'return items' => 'mdi-undo-variant',

                        // Reports
                        'reports' => 'mdi-file-chart-outline',
                        'allocation reports' => 'mdi-file-chart-outline',
                        'stock movement logs' => 'mdi-history',
                        'staff usage reports' => 'mdi-account-clock-outline',
                        'export csv/pdf' => 'mdi-file-export-outline',

                        // Audit Logs
                        'audit logs' => 'mdi-file-document-outline',
                        'all user actions' => 'mdi-account-search-outline',
                        'inventory logs' => 'mdi-clipboard-list-outline',

                        // Settings
                        'roles & permission' => 'mdi-account-key-outline',
                        'change password' => 'mdi-lock-reset',
                        'system preferences' => 'mdi-tune',

                        // Logout
                        'logout' => 'mdi-logout',

                        // Default fallback
                        'default' => 'mdi-layers-outline',
                    ];

                function get_icon($name, $icon_map) {
                    $key = strtolower(trim($name));
                    return $icon_map[$key] ?? $icon_map['default'];
                }
                ?>

<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title">Menu</li>
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    foreach ($menu_list as $value):
        $menu_name = $value['menu_name'] ?? '';
        $icon = get_icon($menu_name, $icon_map);
        $menu_url = $value['menu_url'] ?? '#';
        $is_active = ($current_page == $menu_url) ? 'active' : '';
    ?>
    <?php if (empty($value['has_sub_menu'])): ?>
    <li class="<?php echo $is_active; ?>">
        <a href="javascript:getpage('<?php echo $menu_url; ?>','page')" class="waves-effect">
            <i class="mdi <?php echo htmlspecialchars($icon); ?>"></i>
            <span><?php echo ucfirst($menu_name); ?></span>
        </a>
    </li>
    <?php else: ?>
    <?php
            // Check if any sub-menu is active
            $sub_active = '';
            foreach ($value['sub_menu'] as $sub) {
                if ($current_page == ($sub['menu_url'] ?? '')) {
                    $sub_active = 'active';
                    break;
                }
            }
            ?>
    <li class="<?php echo $sub_active; ?>">
        <a href="javascript:void(0);" class="has-arrow waves-effect">
            <i class="mdi <?php echo htmlspecialchars($icon); ?>"></i>
            <span><?php echo ucfirst($menu_name); ?></span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <?php foreach ($value['sub_menu'] as $sub): 
                        $sub_menu_name = $sub['name'] ?? '';
                        $sub_icon = get_icon($sub_menu_name, $icon_map);
                        $sub_url = $sub['menu_url'] ?? '#';
                        $is_sub_active = ($current_page == $sub_url) ? 'active' : '';
                    ?>
            <li class="<?php echo $is_sub_active; ?>">
                <a href="javascript:getpage('<?php echo $sub_url; ?>','page')">
                    <i class="mdi <?php echo htmlspecialchars($sub_icon); ?>"></i>
                    <?php echo ucfirst($sub_menu_name); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content" >

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Welcome to Qovex Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php if ($registration_complete != 1) {
                include('complete_onboarding.php');
            } else { ?>
                              
            <div id="page">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-sm font-size-20 me-3">
                                        <span class="avatar-title bg-soft-primary text-primary rounded">
                                            <i class="mdi mdi-office-building"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-size-16 mt-2">Active Departments</div>
                                    </div>
                                </div>
                                <h4 class="mt-4"><?php echo $active_dept_count; ?></h4>
                                <div class="row">
                                    <div class="col-7">
                                        <p class="mb-0"><span class="text-success me-2">
                                                <?php echo $active_dept_count > 0 ? '100%' : '0%'; ?>
                                                <i class="mdi mdi-arrow-up"></i> </span></p>
                                    </div>
                                    <div class="col-5 align-self-center">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                   
                

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Qovex.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->

    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body rightbar">
            <div class="right-bar">
                <div data-simplebar class="h-100">
                    <div class="rightbar-title px-3 py-4">
                        <a href="javascript:void(0);" class="right-bar-toggle float-end" data-bs-dismiss="offcanvas" aria-label="Close" >
                            <i class="mdi mdi-close noti-icon"></i>
                        </a>
                        <h5 class="m-0">Settings</h5>
                    </div>
        
                    <!-- Settings -->
                    <hr class="mt-0" />
                    <h6 class="text-center mb-0">Choose Layouts</h6>
        
                    <div class="p-4">
                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>
        
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                            <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                        </div>
        
                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>
        
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"  />
                            <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                        </div>
        
                        <div class="mb-2">
                            <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                        </div>
                        <div class="form-check form-switch mb-5">
                            <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                            <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                        </div>
        
                    </div>
        
                </div>
                <!-- end slimscroll-menu-->
            </div>
        </div>
   
    </div>

<?php } ?>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sweet_alerts.js"></script>

        
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> 
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

   


    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>


    <!-- jquery.vectormap map -->
    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
         function confirmLogout() {
        if (typeof Swal === 'undefined') {
            if (confirm('Are you sure you want to sign out?')) {
                window.location.href = 'logout.php';
            }
            return;
        }
        Swal.fire({
            title: 'Sign Out?',
            text: 'Are you sure you want to sign out of your account?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Sign Out',
            cancelButtonText: 'Cancel',
            customClass: { popup: 'logout-confirmation' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Signing Out...',
                    text: 'Please wait while we sign you out.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => { Swal.showLoading(); }
                });
                setTimeout(() => { window.location.href = 'logout.php'; }, 1000);
            }
        }).catch(() => {
            window.location.href = 'logout.php';
        });
    }
    window.confirmLogout = confirmLogout;


     // If you use getpage() or loadNavPage(), call setActiveMenuByUrl(url) after loading
     function getpage(url, target) {
     $("#" + target).html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
     $.get(url, function(data) {
     $("#" + target).html(data);
     setActiveMenuByUrl(url);
     });
     }
    
     function loadNavPage(url, target, menu_id) {
     $("#" + target).html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
     $.get(url, function(data) {
     $("#" + target).html(data);
     setActiveMenuByUrl(url);
     });
     }

     function loadModal(url, target) {
    $("#" + target).html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>');
    $.get(url, function(data) {
        $("#" + target).html(data);
        $('#defaultModalPrimary').modal('show');
    });
}
        function get_icon($name, $icon_map) {
        $key = is_string($name) ? strtolower(trim($name)) : '';
        return $icon_map[$key] ?? $icon_map['default'];
        }

        document.addEventListener("DOMContentLoaded", function () {
        if (typeof ApexCharts !== "undefined") {
        var options = {
        chart: {
        type: 'donut',
        height: 240
        },
        // Remove or comment out the labels line
        labels: ['Active Departments', 'Employed Staff', 'New Inventory'],
        series: [
        <?php echo $active_dept_count; ?>,
        <?php echo $staff_count; ?>,
        <?php echo $total_new_inventory; ?>
        ],
        colors: ['#007bff', '#34c38f',  '#ffc107'], // green, blue, yellow
        legend: { show: false },
        dataLabels: { enabled: true },
        tooltip: { enabled: true }
        };

        var chart = new ApexCharts(document.querySelector("#donut-chart"), options);
        chart.render();
        }
        });
    </script>

    <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-labelledby="defaultModalPrimaryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal_div">
                   
        
                   </div>
                </div>
            </div>
        </div>
    </div> <!--end modal-->

    <script>
    $(document).ready(function() {
        // Only initialize once on #side-menu
        $('#side-menu').metisMenu();
    });
</script>

    </body>

</html>

