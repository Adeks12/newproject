<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$merchant_id = $_SESSION['merchant_id'];
?>
<div class="container mt-4">
    <h2>Item Management</h2>
    <button class="btn btn-primary mb-3" onclick="showItemModal()">Add Item</button>
    <div id="itemsTable"></div>
</div>

<!-- Item Modal (Add/Edit) -->
<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="itemModalLabel">Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="itemForm" autocomplete="off">
          <input type="hidden" name="op" value="inventory.createInventory">
          <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
          <input type="hidden" name="operation" id="item_operation" value="new">
          <input type="hidden" name="item_id" id="item_id">
          <div class="mb-2">
            <label>Item Name</label>
            <input type="text" name="item_name" id="item_name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Category</label>
            <select name="item_cat_id" id="item_cat_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php
                    $cats = $dbobject->db_query("SELECT item_cat_id, item_cat_name FROM item_category WHERE merchant_id = '$merchant_id' AND item_status = '1'", true);
                    foreach($cats as $cat) {
                        echo "<option value='".$cat['item_cat_id']."'>".$cat['item_cat_name']."</option>";
                    }
                ?>
            </select>
          </div>
          <div class="mb-2">
            <label>Condition</label>
            <select name="item_cond" id="item_cond" class="form-control" required>
                <option value="new">New</option>
                <option value="fairly_used">Fairly Used</option>
                <option value="old">Old</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Color</label>
            <input type="text" name="color" id="color" class="form-control">
          </div>
          <div class="mb-2">
            <label>Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Allocation Status</label>
            <select name="allocation_status" id="allocation_status" class="form-control" required>
                <option value="Available">Available</option>
                <option value="Allocated">Allocated</option>
                <option value="Reserved">Reserved</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Usage Status</label>
            <select name="usage_status" id="usage_status" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Retired">Retired</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Purchase Date</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control">
          </div>
          <div class="mb-2">
            <label>Warranty</label>
            <input type="text" name="warranty" id="warranty" class="form-control">
          </div>
          <div class="mb-2">
            <label>Location</label>
            <input type="text" name="location" id="location" class="form-control">
          </div>
          <button type="button" class="btn btn-success" onclick="saveItem()">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Allocation History Modal -->
<div class="modal fade" id="allocationHistoryModal" tabindex="-1" aria-labelledby="allocationHistoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="allocationHistoryModalLabel">Allocation History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="allocation-history-content">
        <!-- Allocation history will be loaded here via AJAX -->
      </div>
    </div>
  </div>
</div>

<!-- Maintenance Log Modal -->
<div class="modal fade" id="maintenanceLogModal" tabindex="-1" aria-labelledby="maintenanceLogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maintenanceLogModalLabel">Maintenance Log</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="maintenance-log-content">
        <!-- Maintenance log will be loaded here via AJAX -->
        <button class="btn btn-primary mb-2" onclick="showAddMaintenanceForm()">Add Maintenance Record</button>
        <div id="add-maintenance-form" style="display:none;">
          <form id="maintenanceForm" onsubmit="return false;">
            <input type="hidden" name="item_id" id="maint_item_id">
            <div class="mb-2">
              <label>Reported By</label>
              <input type="text" name="reported_by" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username_sess']); ?>" required>
            </div>
            <div class="mb-2">
              <label>Reported Date</label>
              <input type="date" name="reported_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="mb-2">
              <label>Issue Description</label>
              <input type="text" name="issue_description" class="form-control" required>
            </div>
            <div class="mb-2">
              <label>Repair Date</label>
              <input type="date" name="repair_date" class="form-control">
            </div>
            <div class="mb-2">
              <label>Repair Cost</label>
              <input type="number" step="0.01" name="repair_cost" class="form-control">
            </div>
            <div class="mb-2">
              <label>Status</label>
              <select name="maintenance_status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div>
            <div class="mb-2">
              <label>Notes</label>
              <textarea name="notes" class="form-control"></textarea>
            </div>
            <button type="button" class="btn btn-success" onclick="submitMaintenanceForm()">Save</button>
            <button type="button" class="btn btn-secondary" onclick="hideAddMaintenanceForm()">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function loadItemsTable() {
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: { op: 'inventory.inventoryList' },
        success: function(data) {
            // This should be a DataTable for better features, will standardize later.
            $('#itemsTable').html(data);
        }
    });
}
function showItemModal() {
    $('#itemForm')[0].reset();
    $('#item_operation').val('new');
    $('#item_id').val('');
    $('#itemModal').modal('show');
}
function editItem(item_id) {
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: { op: 'inventory.getInventory', item_id: item_id },
        dataType: 'json',
        success: function(res) {
            if (res.response_code === 0) {
                var d = res.data;
                $('#item_operation').val('edit');
                $('#item_id').val(d.item_id);
                $('#item_name').val(d.item_name);
                $('#item_cat_id').val(d.item_cat_id);
                $('#item_cond').val(d.item_cond);
                $('#color').val(d.item_color);
                $('#quantity').val(d.quantity);
                $('#allocation_status').val(d.allocation_status);
                $('#usage_status').val(d.usage_status);
                $('#purchase_date').val(d.purchase_date);
                $('#warranty').val(d.warranty);
                $('#location').val(d.location);
                $('#itemModal').modal('show');
            } else {
                alert(res.response_message);
            }
        }
    });
}
function saveItem() {
    var formData = $('#itemForm').serialize();
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res) {
            alert(res.response_message);
            if (res.response_code === 0) {
                $('#itemModal').modal('hide');
                loadItemsTable();
            }
        }
    });
}
function showAllocationHistory(item_id) {
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: { op: 'item_allocation_history.allocationHistoryList', item_id: item_id },
        success: function(html) {
            $('#allocation-history-content').html(html);
            $('#allocationHistoryModal').modal('show');
        }
    });
}
function showMaintenanceLog(item_id) {
    $('#maint_item_id').val(item_id);
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: { op: 'item_maintenance.maintenanceLogList', item_id: item_id },
        success: function(html) {
            $('#maintenance-log-content').html(html);
            $('#maintenanceLogModal').modal('show');
        }
    });
}
function showAddMaintenanceForm() {
    $('#add-maintenance-form').show();
}
function hideAddMaintenanceForm() {
    $('#add-maintenance-form').hide();
}
function submitMaintenanceForm() {
    var formData = $('#maintenanceForm').serialize() + '&op=item_maintenance.addMaintenanceLog';
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res) {
            alert(res.response_message);
            if (res.response_code === 0) {
                hideAddMaintenanceForm();
                showMaintenanceLog($('#maint_item_id').val());
            }
        }
    });
}
$(document).ready(function() {
    loadItemsTable();
});
</script> 