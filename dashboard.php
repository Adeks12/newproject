<?php
// Fetch dashboard data
$merchant_id = $_SESSION['merchant_id'] ?? '';
$active_dept_count = 0;
$staff_count = 0;
$total_new_inventory = 0;
$maintenance_count = 0;
$recent_inventory = [];

if ($merchant_id) {
    // Active departments
    $sql_dept = "SELECT COUNT(*) as cnt FROM department WHERE merchant_id='$merchant_id' AND depmt_status='1'";
    $result_dept = $dbobject->db_query($sql_dept);
    $active_dept_count = isset($result_dept[0]['cnt']) ? $result_dept[0]['cnt'] : 0;

    // Total staff
    $sql_staff = "SELECT COUNT(*) as cnt FROM staff WHERE merchant_id='$merchant_id' AND staff_status='1'";
    $result_staff = $dbobject->db_query($sql_staff, true);
    $staff_count = isset($result_staff[0]['cnt']) ? $result_staff[0]['cnt'] : 0;

    // Total inventory
    $sql_inventory = "SELECT COUNT(*) as cnt FROM inventory WHERE merchant_id='$merchant_id' AND delete_status != '1'";
    $result_inventory = $dbobject->db_query($sql_inventory, true);
    $total_new_inventory = isset($result_inventory[0]['cnt']) ? $result_inventory[0]['cnt'] : 0;
    
    // Items in maintenance
    $sql_maintenance = "SELECT COUNT(*) as cnt FROM inventory WHERE merchant_id='$merchant_id' AND usage_status='Maintenance' AND delete_status != '1'";
    $result_maintenance = $dbobject->db_query($sql_maintenance, true);
    $maintenance_count = isset($result_maintenance[0]['cnt']) ? $result_maintenance[0]['cnt'] : 0;

    // Recent inventory items
    $recent_inventory = $dbobject->db_query("SELECT i.item_name, i.item_code, ic.item_cat_name, i.allocation_status, i.created_at FROM inventory i LEFT JOIN item_category ic ON i.item_cat_id = ic.item_cat_id WHERE i.merchant_id='$merchant_id' AND i.delete_status != '1' ORDER BY i.created_at DESC LIMIT 5", true);
}
?>
<div class="page-content" id="page">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Qovex</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="assets/images/services-icon/01.png" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Total Inventory</h5>
                        <h4 class="fw-medium font-size-24"><?php echo $total_new_inventory; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="assets/images/services-icon/02.png" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Total Staff</h5>
                        <h4 class="fw-medium font-size-24"><?php echo $staff_count; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="assets/images/services-icon/03.png" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Active Departments</h5>
                        <h4 class="fw-medium font-size-24"><?php echo $active_dept_count; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="mb-4">
                        <div class="float-start mini-stat-img me-4">
                            <img src="assets/images/services-icon/04.png" alt="">
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">In Maintenance</h5>
                        <h4 class="fw-medium font-size-24"><?php echo $maintenance_count; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Recent Inventory Items</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Code</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(is_array($recent_inventory) && count($recent_inventory) > 0) {
                                    foreach ($recent_inventory as $item) {
                                        echo '<tr>
                                            <td>' . htmlspecialchars($item['item_name']) . '</td>
                                            <td>' . htmlspecialchars($item['item_code']) . '</td>
                                            <td>' . htmlspecialchars($item['item_cat_name']) . '</td>
                                            <td><span class="badge bg-success">' . htmlspecialchars($item['allocation_status']) . '</span></td>
                                            <td>' . date('d M, Y', strtotime($item['created_at'])) . '</td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center">No recent inventory items found.</td></tr>';
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