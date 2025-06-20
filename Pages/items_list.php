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
          <input type="hidden" name="op" value="items.createItem">
          <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
          <input type="hidden" name="operation" id="item_operation" value="new">
          <input type="hidden" name="item_id" id="item_id">
          <div class="mb-2">
            <label>Item Name</label>
            <input type="text" name="item_name" id="item_name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Category ID</label>
            <input type="number" name="category_id" id="category_id" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Condition</label>
            <input type="text" name="condition" id="condition" class="form-control" required>
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
            <label>Status</label>
            <input type="text" name="status" id="status" class="form-control" required>
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
        data: { op: 'items.itemsList' },
        success: function(data) {
            // Add action buttons for allocation history and maintenance log
            var table = $('<div>').html(data);
            table.find('tr').each(function() {
                var row = $(this);
                var itemId = row.find('td').eq(0).text();
                if (!isNaN(parseInt(itemId))) {
                    var actions = '<button class="btn btn-info btn-sm me-1" onclick="showAllocationHistory(' + itemId + ')">History</button>' +
                                  '<button class="btn btn-warning btn-sm me-1" onclick="showMaintenanceLog(' + itemId + ')">Maintenance</button>' +
                                  '<button class="btn btn-secondary btn-sm" onclick="editItem(' + itemId + ')">Edit</button>';
                    row.find('td').last().append(actions);
                }
            });
            $('#itemsTable').html(table.html());
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
        data: { op: 'items.getItem', item_id: item_id },
        dataType: 'json',
        success: function(res) {
            if (res.response_code === 0) {
                var d = res.data;
                $('#item_operation').val('edit');
                $('#item_id').val(d.item_id);
                $('#item_name').val(d.item_name);
                $('#category_id').val(d.category_id);
                $('#condition').val(d.condition);
                $('#color').val(d.color);
                $('#quantity').val(d.quantity);
                $('#status').val(d.status);
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