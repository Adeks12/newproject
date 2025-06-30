<?php
@session_start();
require_once('libs/dbfunctions.php');
$dbobject = new dbobject();
$merchant_id = $_SESSION['merchant_id'] ?? '';

// Fetch inventory items with category
$items = $dbobject->db_query("SELECT i.*, ic.item_cat_name FROM inventory i LEFT JOIN item_category ic ON i.item_cat_id = ic.item_cat_id WHERE i.merchant_id='$merchant_id' AND i.delete_status != '1'", true);
// Fetch allocations (active)
$allocs = $dbobject->db_query("SELECT item_id, SUM(quantity) as allocated_qty FROM item_allocation WHERE merchant_id='$merchant_id' AND status='active' GROUP BY item_id", true);
$alloc_map = [];
foreach($allocs as $a) $alloc_map[$a['item_id']] = (int)$a['allocated_qty'];
// Category stats
$cat_stats = [];
foreach($items as $item) {
    $cat = $item['item_cat_name'];
    if(!isset($cat_stats[$cat])) $cat_stats[$cat] = ['total'=>0,'allocated'=>0,'available'=>0];
    $cat_stats[$cat]['total'] += (int)$item['quantity'];
    $cat_stats[$cat]['allocated'] += $alloc_map[$item['item_id']] ?? 0;
    $cat_stats[$cat]['available'] += ((int)$item['quantity'] - ($alloc_map[$item['item_id']] ?? 0));
}
?>
<div class="container mt-4">
    <h2>Inventory Management</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4>Category Summary</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Quantity</th>
                            <th>Allocated</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cat_stats as $cat=>$stat): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cat); ?></td>
                            <td><?php echo $stat['total']; ?></td>
                            <td><?php echo $stat['allocated']; ?></td>
                            <td><?php echo $stat['available']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Inventory Items</h4>
            <div class="table-responsive">
                <table class="table table-striped" id="inventoryTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Total Quantity</th>
                            <th>Allocated</th>
                            <th>Available</th>
                            <th>Condition</th>
                            <th>Color</th>
                            <th>Location</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item):
                            $allocated = $alloc_map[$item['item_id']] ?? 0;
                            $available = (int)$item['quantity'] - $allocated;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['item_cat_name']); ?></td>
                            <td><?php echo (int)$item['quantity']; ?></td>
                            <td><?php echo $allocated; ?></td>
                            <td><?php echo $available; ?></td>
                            <td><?php echo htmlspecialchars($item['item_cond']); ?></td>
                            <td><?php echo htmlspecialchars($item['item_color']); ?></td>
                            <td><?php echo htmlspecialchars($item['location']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($item['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary mt-3" onclick="exportInventory()">Export CSV</button>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#inventoryTable').DataTable();
});
function exportInventory() {
    window.location = 'export_inventory.php';
}
</script>