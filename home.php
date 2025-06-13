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
$merchant_first_name = isset($user_det2[0]['merchant_first_name']) ? $user_det2[0]['merchant_first_name'] : '';
$merchant_last_name = isset($user_det2[0]['merchant_last_name']) ? $user_det2[0]['merchant_last_name'] : '';
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
$staff_count = 0;
$sql_staff = "SELECT COUNT(*) as cnt FROM staff WHERE merchant_id='$merchant_id' AND staff_status='1'";
$result_staff = $dbobject->db_query($sql_staff, true);
$staff_count = isset($result_staff[0]['cnt']) ? $result_staff[0]['cnt'] : 0;

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

                            <div class="dropdown d-inline-block d-lg-none ms-2">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="dropdown d-none d-sm-inline-block">
                                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img class="" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span
                                            class="align-middle">Spanish</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span
                                            class="align-middle">German</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span
                                            class="align-middle">Italian</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span
                                            class="align-middle">Russian</span>
                                    </a>
                                </div>
                            </div>

                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span class="badge rounded-pill bg-danger ">3</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-notifications-dropdown">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0"> Notifications </h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#!" class="small"> View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 230px;">
                                        <a href="" class="text-reset notification-item">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="bx bx-cart"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1">Your order is placed</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="d-flex align-items-start">
                                                <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1">James Lemire</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">It will seem like simplified English.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="" class="text-reset notification-item">
                                            <div class="d-flex align-items-start">
                                                <img src="assets/images/users/avatar-4.jpg" class="me-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-2 border-top d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 " href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
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
                                    <a class="dropdown-item" href="javascript:getpage('profile.php','page')"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>
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
                            <form class="app-search d-none d-lg-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form>

                            <div class="dropdown dropdown-mega d-none d-lg-inline-block ms-2">
                                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                                    aria-haspopup="false" aria-expanded="false">
                                    Mega Menu
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu dropdown-megamenu">
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5 class="font-size-14 mt-0">UI Components</h5>
                                                    <ul class="list-unstyled megamenu-list text-muted">
                                                        <li>
                                                            <a href="javascript:void(0);">Lightbox</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Range Slider</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Sweet Alert</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Rating</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Forms</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Tables</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Charts</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-4">
                                                    <h5 class="font-size-14 mt-0">Applications</h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <a href="javascript:void(0);">Ecommerce</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Calendar</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Email</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Projects</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Tasks</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Contacts</a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-4">
                                                    <h5 class="font-size-14 mt-0">Extra Pages</h5>
                                                    <ul class="list-unstyled megamenu-list">
                                                        <li>
                                                            <a href="javascript:void(0);">Light Sidebar</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Compact Sidebar</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Horizontal layout</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Maintenance</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Coming Soon</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Timeline</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">FAQs</a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5 class="font-size-14 mt-0">Components</h5>
                                                    <div class="px-lg-2">
                                                        <div class="row g-0">
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/github.png" alt="Github">
                                                                    <span>GitHub</span>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                                                    <span>Bitbucket</span>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                                                    <span>Dribbble</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="row g-0">
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                                                    <span>Dropbox</span>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                                                    <span>Mail Chimp</span>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                <a class="dropdown-icon-item" href="#">
                                                                    <img src="assets/images/brands/slack.png" alt="slack">
                                                                    <span>Slack</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div>
                                                        <div class="card text-white mb-0 overflow-hidden text-white-50"
                                                            style="background-image: url('assets/images/megamenu-img.png');background-size: cover;">
                                                            <div class="card-img-overlay"></div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <h4 class="text-white mb-3">Sale</h4>

                                                                        <h5 class="text-white-50">Up to <span
                                                                                class="font-size-24 text-white">50 %</span> Off</h5>
                                                                        <p>At vero eos accusamus et iusto odio.</p>
                                                                        <div class="mb-4">
                                                                            <a href="#" class="btn btn-success btn-sm">View more</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
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

                <a href="#" class="text-body fw-medium font-size-16"><?php echo $merchant_first_name.' '. $merchant_last_name ?></a>
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
                // Enhanced icon mapping with more modern icons
                $icon_map = [
                    'dashboard' => 'mdi-view-dashboard',
                    'users' => 'mdi-account-multiple',
                    'user' => 'mdi-account',
                    'customers' => 'mdi-account-group',
                    'customer' => 'mdi-account-check',
                    'orders' => 'mdi-cart',
                    'order' => 'mdi-cart-outline',
                    'products' => 'mdi-package-variant',
                    'product' => 'mdi-cube-outline',
                    'reports' => 'mdi-chart-bar',
                    'report' => 'mdi-chart-pie',
                    'settings' => 'mdi-cog',
                    'profile' => 'mdi-account-circle',
                    'finance' => 'mdi-credit-card',
                    'wallet' => 'mdi-wallet',
                    'transactions' => 'mdi-swap-horizontal',
                    'transaction' => 'mdi-arrow-left-right',
                    'messages' => 'mdi-message',
                    'support' => 'mdi-lifebuoy',
                    'analytics' => 'mdi-chart-line',
                    'calendar' => 'mdi-calendar',
                    'notifications' => 'mdi-bell',
                    'files' => 'mdi-file-document',
                    'file manager' => 'mdi-folder',
                    'department' => 'mdi-office-building',
                    'items category' => 'mdi-layers',
                    'staff' => 'mdi-account-plus',
                    'inventory' => 'mdi-archive',
                    'tasks' => 'mdi-checkbox-marked-outline',
                    'task' => 'mdi-clipboard-check',
                    'projects' => 'mdi-briefcase',
                    'project' => 'mdi-folder-outline',
                    'invoice' => 'mdi-receipt',
                    'pricing' => 'mdi-tag',
                    'email' => 'mdi-email',
                    'chat' => 'mdi-chat',
                    'apps' => 'mdi-apps',
                    'tools' => 'mdi-wrench',
                    'components' => 'mdi-layers',
                    'pages' => 'mdi-file-document-multiple',
                    'auth' => 'mdi-shield-account',
                    'logout' => 'mdi-logout',
                    'default' => 'mdi-circle'
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
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-sm font-size-20 me-3">
                                        <span class="avatar-title bg-soft-primary text-primary rounded">
                                            <i class="mdi mdi-account-multiple-outline"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-size-16 mt-2">Employed Staff</div>
                                    </div>
                                </div>
                                <h4 class="mt-4"><?php echo $staff_count; ?></h4>
                                <div class="row">
                                    <div class="col-7">
                                        <p class="mb-0"><span class="text-success me-2">
                                                <?php echo $staff_count > 0 ? '100%' : '0%'; ?>
                                                <i class="mdi mdi-arrow-up"></i> </span></p>
                                    </div>
                                    <div class="col-5 align-self-center">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-5">Statistics Overview</h4>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div id="donut-chart" class="apex-charts"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="py-3">
                                                        <p class="mb-1 text-truncate"><i
                                                                class="mdi mdi-circle text-primary me-1"></i> Active
                                                            Departments</p>
                                                        <h5><?php echo $active_dept_count; ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="py-3">
                                                        <p class="mb-1 text-truncate"><i
                                                                class="mdi mdi-circle text-success me-1"></i> Employed
                                                            Staff</p>
                                                        <h5><?php echo $staff_count; ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="py-3">
                                                        <p class="mb-1 text-truncate"><i
                                                                class="mdi mdi-circle text-warning me-1"></i> New
                                                            Inventory</p>
                                                        <h5><?php echo $total_new_inventory; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Card and Mini Inventory Table -->
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Staff Chat</h4>
                                <ul class="inbox-wid list-unstyled">
                                    <?php
                        $staffs = $dbobject->db_query("SELECT staff_first_name, staff_last_name FROM staff WHERE merchant_id='$merchant_id' AND staff_status='1' LIMIT 4", true);
                        foreach ($staffs as $staff) {
                            echo '<li class="inbox-list-item">
                                <a href="#">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3 align-self-center">
                                            <img src="assets/images/users/avatar-3.jpg" alt="" class="avatar-sm rounded-circle">
                                        </div>
                                        <div class="flex-1 overflow-hidden">
                                            <h5 class="font-size-16 mb-1">'.htmlspecialchars($staff['staff_first_name']).'</h5>
                                            <p class="text-truncate mb-0">Staff member</p>
                                        </div>
                                        <div class="font-size-12 ms-auto"></div>
                                    </div>
                                </a>
                            </li>';
                        }
                        ?>
                                </ul>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary btn-sm">Load more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Mini Inventory Table</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered">
                                        <thead>
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Condition</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                $inv = $dbobject->db_query("SELECT item_code, item_cond, item_cat_id, allocation_status, created_at FROM inventory WHERE merchant_id='$merchant_id' AND delete_status != '1' ORDER BY created_at DESC LIMIT 5", true);
                                foreach ($inv as $item) {
                                    echo '<tr>
                                        <td>' . htmlspecialchars($item['item_code']) . '</td>
                                        <td>' . htmlspecialchars($item['item_cond']) . '</td>
                                        <td>' . htmlspecialchars($item['item_cat_id']) . '</td>
                                        <td>' . htmlspecialchars($item['allocation_status']) . '</td>
                                        <td>' . date('Y-m-d', strtotime($item['created_at'])) . '</td>
                                    </tr>';
                                }
                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
                <!-- End Page-content -->

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

    </body>

</html>

