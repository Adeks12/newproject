<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$merchant_id = $_SESSION['merchant_id'];
?>
<div class="container mt-4">
    <h2>Item Allocation Management</h2>
    <button class="btn btn-primary mb-3" onclick="showAllocateModal()">Allocate Item</button>
    <div id="allocationTable"></div>
</div>

<!-- Allocate Modal -->
<div class="modal fade" id="allocateModal" tabindex="-1" aria-labelledby="allocateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="allocateModalLabel">Allocate Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="allocateForm" autocomplete="off">
          <input type="hidden" name="op" value="item_allocation.allocateItem">
          <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
          <div class="mb-2">
            <label>Item ID</label>
            <input type="number" name="item_id" id="alloc_item_id" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Staff ID</label>
            <input type="number" name="staff_id" id="alloc_staff_id" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Notes</label>
            <textarea name="notes" id="alloc_notes" class="form-control"></textarea>
          </div>
          <button type="button" class="btn btn-success" onclick="saveAllocation()">Allocate</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function loadAllocationTable() {
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: { op: 'item_allocation.allocationList' },
        success: function(data) {
            $('#allocationTable').html(data);
        }
    });
}
function showAllocateModal() {
    $('#allocateForm')[0].reset();
    $('#allocateModal').modal('show');
}
function saveAllocation() {
    var formData = $('#allocateForm').serialize();
    $.ajax({
        url: 'utilities.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(res) {
            alert(res.response_message);
            if (res.response_code === 0) {
                $('#allocateModal').modal('hide');
                loadAllocationTable();
            }
        }
    });
}
function returnItem(allocation_id) {
    if (confirm('Mark this item as returned?')) {
        $.ajax({
            url: 'utilities.php',
            type: 'POST',
            data: { op: 'item_allocation.returnItem', allocation_id: allocation_id },
            dataType: 'json',
            success: function(res) {
                alert(res.response_message);
                if (res.response_code === 0) {
                    loadAllocationTable();
                }
            }
        });
    }
}
$(document).ready(function() {
    loadAllocationTable();
});
</script> 