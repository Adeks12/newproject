<?php
// filepath: c:\xampp1\htdocs\newproject\setup\maintenance_setup.php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

// Check if user is logged in
if (!isset($_SESSION['username_sess'])) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit;
}

$user = $_SESSION['username_sess'];
$sql = "SELECT merchant_id FROM userdata WHERE username = '$user' LIMIT 1";
$doquery = $dbobject->db_query($sql, true);

if (!$doquery || empty($doquery)) {
    echo "<script>alert('User not found'); window.location.href='login.php';</script>";
    exit;
}
$merchant_id = $doquery[0]['merchant_id'];

// Get inventory items for dropdown
$items_sql = "SELECT item_id, item_cat_id FROM inventory WHERE merchant_id = '$merchant_id' ORDER BY item_cat_id";
$items = $dbobject->db_query($items_sql, true);

// If editing, fetch the maintenance log record
$operation = "new";
$log = null;
if (isset($_GET['maintenance_id']) && $_GET['maintenance_id'] != "") {
    $maintenance_id = $_GET['maintenance_id'];
    $log_sql = "SELECT * FROM item_maintenance_log WHERE maintenance_id = '$maintenance_id' AND merchant_id = '$merchant_id' LIMIT 1";
    $log_result = $dbobject->db_query($log_sql, true);
    if ($log_result && is_array($log_result) && count($log_result) > 0) {
        $log = $log_result[0];
        $operation = "edit";
    }
}
?>

<style>
    .asterik {
        color: red;
    }

    .form-group {
        margin-bottom: 1rem;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">
        <?php echo ($operation == "edit") ? "Edit" : "Input"; ?> Maintenance Log
        <div><small style="font-size:12px">All asterik fields are compulsory</small></div>
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body m-3">
    <form id="maintenanceForm" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="inventory.logMaintenanceAction">
        <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
        <input type="hidden" name="maintenance_id" value="<?php echo htmlspecialchars($log['maintenance_id']); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label class="form-label">Item<span class="asterik">*</span></label>
            <select class="form-select" name="item_id" id="item_id" required
                <?php echo ($operation == "edit") ? "disabled" : ""; ?>>
                <option value="">:: SELECT ITEM ::</option>
                <?php
                if($items && is_array($items)) {
                    foreach($items as $item) {
                        $selected = ($operation == "edit" && $log && $log['item_id'] == $item['item_id']) ? "selected" : "";
                        echo "<option value='{$item['item_id']}' $selected>{$item['item_name']}</option>";
                    }
                }
                ?>
            </select>
            <div class="invalid-feedback">Please select the item.</div>
        </div>
        <div class="form-group">
            <label class="form-label">Maintenance Type<span class="asterik">*</span></label>
            <input type="text" name="maintenance_type" id="maintenance_type" class="form-control" required
                value="<?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['maintenance_type']) : ""; ?>">
            <div class="invalid-feedback">Please enter the maintenance type.</div>
        </div>
        <div class="form-group">
            <label class="form-label">Maintenance Date<span class="asterik">*</span></label>
            <input type="date" name="maintenance_date" id="maintenance_date" class="form-control" required
                value="<?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['maintenance_date']) : ""; ?>">
            <div class="invalid-feedback">Please enter the maintenance date.</div>
        </div>
        <div class="form-group">
            <label class="form-label">Notes</label>
            <textarea name="notes" id="notes"
                class="form-control"><?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['notes']) : ""; ?></textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Performed By<span class="asterik">*</span></label>
            <input type="text" name="performed_by" id="performed_by" class="form-control" required
                value="<?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['performed_by']) : htmlspecialchars($user); ?>">
            <div class="invalid-feedback">Please enter who performed the maintenance.</div>
        </div>
        <div class="form-group">
            <label class="form-label">Status<span class="asterik">*</span></label>
            <select class="form-select" name="maintenance_status" id="maintenance_status" required>
                <option value="">:: SELECT STATUS ::</option>
                <option value="Pending"
                    <?php echo ($operation == "edit" && $log && $log['maintenance_status'] == 'Pending') ? "selected" : ""; ?>>
                    Pending</option>
                <option value="In Progress"
                    <?php echo ($operation == "edit" && $log && $log['maintenance_status'] == 'In Progress') ? "selected" : ""; ?>>
                    In Progress</option>
                <option value="Completed"
                    <?php echo ($operation == "edit" && $log && $log['maintenance_status'] == 'Completed') ? "selected" : ""; ?>>
                    Completed</option>
                <option value="Cancelled"
                    <?php echo ($operation == "edit" && $log && $log['maintenance_status'] == 'Cancelled') ? "selected" : ""; ?>>
                    Cancelled</option>
            </select>
            <div class="invalid-feedback">Please select the maintenance status.</div>
        </div>
        <div class="form-group">
            <label class="form-label">Cost</label>
            <input type="number" step="0.01" name="cost" id="cost" class="form-control"
                value="<?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['cost']) : ""; ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Vendor</label>
            <input type="text" name="vendor" id="vendor" class="form-control"
                value="<?php echo ($operation == "edit" && $log) ? htmlspecialchars($log['vendor']) : ""; ?>">
        </div>
        <div id="maintenance_server_mssg"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="save_maintenance" class="btn btn-primary" onclick="saveMaintenanceLog()">
                <?php echo ($operation == "edit") ? "Update Maintenance Log" : "Save Maintenance Log"; ?>
            </button>
        </div>
    </form>
</div>

<script>
    function showMaintenanceMessage(message, type) {
        $("#maintenance_server_mssg").html('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') +
            ' alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            message + '</div>');
        if (type === 'success') {
            setTimeout(function () {
                $("#maintenance_server_mssg").html('');
            }, 3000);
        }
    }

    function saveMaintenanceLog() {
        var valid = true;
        var firstInvalidField = null;
        $('#maintenanceForm [required]').each(function () {
            if (!$(this).val() || !$(this).val().trim()) {
                $(this).addClass('is-invalid');
                if (!firstInvalidField) firstInvalidField = $(this);
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!valid) {
            showMaintenanceMessage("Please fill all required fields.", "error");
            if (firstInvalidField) firstInvalidField.focus();
            return;
        }
        $("#save_maintenance").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $("#save_maintenance").prop('disabled', true);

        var dd = $("#maintenanceForm").serialize();
        $.ajax({
            url: "utilities.php",
            type: "POST",
            data: dd,
            dataType: 'json',
            success: function (re) {
                $("#save_maintenance").html(
                    "<?php echo ($operation == 'edit') ? 'Update Maintenance Log' : 'Save Maintenance Log'; ?>"
                    );
                $("#save_maintenance").prop('disabled', false);
                if (re.response_code == 0) {
                    showMaintenanceMessage(re.response_message, "success");
                    if (typeof refreshInventoryList === 'function') {
                        refreshInventoryList();
                    }
                    setTimeout(function () {
                        $('#defaultModalPrimary').modal('hide');
                    }, 1500);
                } else {
                    showMaintenanceMessage(re.response_message, "error");
                }
            },
            error: function () {
                $("#save_maintenance").html(
                    "<?php echo ($operation == 'edit') ? 'Update Maintenance Log' : 'Save Maintenance Log'; ?>"
                    );
                $("#save_maintenance").prop('disabled', false);
                showMaintenanceMessage("An error occurred while processing your request. Please try again.",
                    "error");
            }
        });
    }
</script>