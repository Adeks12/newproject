<?php
@session_start();
require_once('libs/dbfunctions.php');
$dbobject = new dbobject();
$merchant_id = $_SESSION['merchant_id'] ?? '';

// Fetch items with available quantity
$items = $dbobject->db_query("SELECT item_id, item_name, quantity FROM inventory WHERE merchant_id='$merchant_id' AND delete_status != '1' AND quantity > 0", true);
// Fetch staff
$staffs = $dbobject->db_query("SELECT staff_id, CONCAT(staff_first_name, ' ', staff_last_name) as staff_name FROM staff WHERE merchant_id='$merchant_id' AND staff_status='1'", true);
// Fetch allocation history
$allocations = $dbobject->db_query("SELECT a.*, i.item_name, s.staff_first_name, s.staff_last_name FROM item_allocation a LEFT JOIN inventory i ON a.item_id = i.item_id LEFT JOIN staff s ON a.staff_id = s.staff_id WHERE a.merchant_id='$merchant_id' ORDER BY a.allocated_date DESC LIMIT 50", true);
?>
<div class="container mt-4">
    <h2>Item Allocation</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form id="allocationForm" autocomplete="off">
                <div class="row">
                    <div class="col-md-4">
                        <label>Item</label>
                        <select name="item_id" class="form-control" required>
                            <option value="">-- Select Item --</option>
                            <?php foreach($items as $item): ?>
                                <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']) . " (Available: " . $item['quantity'] . ")"; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Staff</label>
                        <select name="staff_id" class="form-control" required>
                            <option value="">-- Select Staff --</option>
                            <?php foreach($staffs as $staff): ?>
                                <option value="<?php echo $staff['staff_id']; ?>"><?php echo htmlspecialchars($staff['staff_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label>Allocation Date</label>
                        <input type="date" name="allocated_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label>Notes</label>
                        <input type="text" name="notes" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-success w-100" onclick="allocateItem()">Allocate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Allocation History</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Staff</th>
                            <th>Quantity</th>
                            <th>Allocated Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allocations as $alloc): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alloc['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($alloc['staff_first_name'] . ' ' . $alloc['staff_last_name']); ?></td>
                            <td><?php echo (int)$alloc['quantity']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($alloc['allocated_date'])); ?></td>
                            <td><?php echo htmlspecialchars($alloc['status']); ?></td>
                            <td><?php echo htmlspecialchars($alloc['notes']); ?></td>
                            <td>
                                <?php if($alloc['status'] == 'active'): ?>
                                    <button class="btn btn-warning btn-sm" onclick="returnItem(<?php echo $alloc['allocation_id']; ?>, <?php echo $alloc['item_id']; ?>, <?php echo (int)$alloc['quantity']; ?>)">Return</button>
                                <?php else: ?>
                                    <span class="text-success">Returned</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function allocateItem() {
    var formData = $('#allocationForm').serialize() + '&op=allocation.allocateItem';
    $.post('utilities.php', formData, function(res) {
        alert(res.response_message);
        if(res.response_code == 0) location.reload();
    }, 'json');
}
function returnItem(allocation_id, item_id, quantity) {
    if(confirm('Mark this item as returned?')) {
        $.post('utilities.php', {op: 'allocation.returnItem', allocation_id: allocation_id, item_id: item_id, quantity: quantity}, function(res) {
            alert(res.response_message);
            if(res.response_code == 0) location.reload();
        }, 'json');
    }
}
</script> 