<?php
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

// Fix: Use correct variable name for staff query
$sql1 = "SELECT staff_id, staff_first_name, staff_last_name FROM staff WHERE merchant_id = '$merchant_id' AND staff_status = '1'";
$staffs = $dbobject->db_query($sql1, true); // Fixed: was using $sql instead of $sql1

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $item_id = $_REQUEST['item_id'] ?? '';
    
    if(empty($item_id)) {
        echo "<script>console.log('Error: item ID is missing');</script>";
        $item = null;
        $operation = 'new';
    } else {
        $sql = "SELECT * FROM inventory WHERE item_id='$item_id' AND merchant_id='$merchant_id' LIMIT 1";
        $item_result = $dbobject->db_query($sql, true);
        
        echo "<script>console.log('Item ID: $item_id');</script>";
        echo "<script>console.log('SQL Query: $sql');</script>";
        echo "<script>console.log('Query Result: " . json_encode($item_result) . "');</script>";
        
        if($item_result && is_array($item_result) && count($item_result) > 0) {
            $item = $item_result[0];
            $operation = 'edit';
            echo "<script>console.log('Item Data: " . json_encode($item) . "');</script>";
        } else {
            echo "<script>console.log('No item found with ID: $item_id');</script>";
            $item = null;
            $operation = 'new';
        }
    }
}
else if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'allocate')
{
    $item_id = $_REQUEST['item_id'] ?? '';
    $operation = 'allocate';
    $item = null;
    if(!empty($item_id)) {
        $sql = "SELECT * FROM inventory WHERE item_id='$item_id' AND merchant_id='$merchant_id' LIMIT 1";
        $item_result = $dbobject->db_query($sql, true);
        if($item_result && is_array($item_result) && count($item_result) > 0) {
            $item = $item_result[0];
        }
    }
}
else
{
    $operation = 'new';
    $item = null;
}

// Get item categories for dropdown
$categories_sql = "SELECT item_cat_id, item_cat_name FROM item_category WHERE merchant_id = '$merchant_id' AND item_status = '1' ORDER BY item_cat_name";
$categories = $dbobject->db_query($categories_sql, true);
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
    <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?>Inventory Setup
        <div><small style="font-size:12px">All asterik fields are compulsory</small></div>
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="inventory.allocateInventory">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "allocate"): ?>
            <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
            <div class="form-group mb-3">
                <label for="allocated_officer" class="form-label">Allocate To (Staff)<span class="asterik">*</span></label>
                <select name="allocated_officer" id="allocated_officer" class="form-select" required>
                    <option value="">-- Select Officer --</option>
                    <?php
                    if(is_array($staffs)) {
                        foreach($staffs as $staff) {
                            echo "<option value=\"{$staff['staff_id']}\">{$staff['staff_first_name']} {$staff['staff_last_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="allocated_by" class="form-label">Allocated By</label>
                <input type="text" name="allocated_by" id="allocated_by" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username_sess']); ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="allocated_date" class="form-label">Allocated Date</label>
                <input type="date" name="allocated_date" id="allocated_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="save_inventory" class="btn btn-success" onclick="saveRecord()">
                    Allocate
                </button>
            </div>
        <?php else: ?>
        <input type="hidden" name="op" value="inventory.createInventory">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Item Condition<span class="asterik">*</span></label>
                    <select class="form-select" name="item_cond" id="item_cond" required>
                        <option value="">:: SELECT CONDITION ::</option>
                        <option value="New"
                            <?php echo ($operation == "edit" && $item && isset($item['item_cond']) && $item['item_cond'] == 'New') ? 'selected' : ''; ?>>
                            New</option>
                        <option value="Good"
                            <?php echo ($operation == "edit" && $item && isset($item['item_cond']) && $item['item_cond'] == 'Good') ? 'selected' : ''; ?>>
                            Good</option>
                        <option value="Fair"
                            <?php echo ($operation == "edit" && $item && isset($item['item_cond']) && $item['item_cond'] == 'Fair') ? 'selected' : ''; ?>>
                            Fair</option>
                        <option value="Poor"
                            <?php echo ($operation == "edit" && $item && isset($item['item_cond']) && $item['item_cond'] == 'Poor') ? 'selected' : ''; ?>>
                            Poor</option>
                        <option value="Damaged"
                            <?php echo ($operation == "edit" && $item && isset($item['item_cond']) && $item['item_cond'] == 'Damaged') ? 'selected' : ''; ?>>
                            Damaged</option>
                    </select>
                    <div class="invalid-feedback">Please select the item condition.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Item Category<span class="asterik">*</span></label>
                    <select class="form-select" name="item_cat_id" id="item_cat_id" required>
                        <option value="">:: SELECT CATEGORY ::</option>
                        <?php 
                        if($categories && is_array($categories)) {
                            foreach($categories as $cat) {
                                $selected = ($operation == "edit" && $item && isset($item['item_cat_id']) && $item['item_cat_id'] == $cat['item_cat_id']) ? 'selected' : '';
                                echo "<option value='{$cat['item_cat_id']}' $selected>{$cat['item_cat_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Please select the item category.</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Item Color</label>
                    <input type="text" name="item_color" id="item_color" class="form-control"
                        value="<?php echo ($operation == "edit" && $item && isset($item['item_color'])) ? htmlspecialchars($item['item_color']) : ""; ?>"
                        placeholder="Enter item color" autocomplete="off">
                    <div class="invalid-feedback">Please enter the item color.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Allocation Status<span class="asterik">*</span></label>
                    <select class="form-select" name="allocation_status" id="allocation_status" required>
                        <option value="">:: SELECT STATUS ::</option>
                        <option value="Available"
                            <?php echo ($operation == "edit" && $item && isset($item['allocation_status']) && $item['allocation_status'] == 'Available') ? 'selected' : (($operation == "new") ? 'selected' : ''); ?>>
                            Available</option>
                        <option value="Allocated"
                            <?php echo ($operation == "edit" && $item && isset($item['allocation_status']) && $item['allocation_status'] == 'Allocated') ? 'selected' : ''; ?>>
                            Allocated</option>
                        <option value="Reserved"
                            <?php echo ($operation == "edit" && $item && isset($item['allocation_status']) && $item['allocation_status'] == 'Reserved') ? 'selected' : ''; ?>>
                            Reserved</option>
                    </select>
                    <div class="invalid-feedback">Please select the allocation status.</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Usage Status<span class="asterik">*</span></label>
                    <select class="form-select" name="usage_status" id="usage_status" required>
                        <option value="">:: SELECT STATUS ::</option>
                        <option value="Active"
                            <?php echo ($operation == "edit" && $item && isset($item['usage_status']) && $item['usage_status'] == 'Active') ? 'selected' : (($operation == "new") ? 'selected' : ''); ?>>
                            Active</option>
                        <option value="Inactive"
                            <?php echo ($operation == "edit" && $item && isset($item['usage_status']) && $item['usage_status'] == 'Inactive') ? 'selected' : ''; ?>>
                            Inactive</option>
                        <option value="Maintenance"
                            <?php echo ($operation == "edit" && $item && isset($item['usage_status']) && $item['usage_status'] == 'Maintenance') ? 'selected' : ''; ?>>
                            Maintenance</option>
                        <option value="Retired"
                            <?php echo ($operation == "edit" && $item && isset($item['usage_status']) && $item['usage_status'] == 'Retired') ? 'selected' : ''; ?>>
                            Retired</option>
                    </select>
                    <div class="invalid-feedback">Please select the usage status.</div>
                </div>
            </div>
            <div class="col-sm-6" id="allocation_fields" style="display: none;">
                <div class="form-group">
                    <label for="allocated_officer" class="form-label">Allocated Officer</label>
                    <select name="allocated_officer" id="allocated_officer" class="form-select">
                        <option value="">-- Select Officer --</option>
                        <?php
                        if(is_array($staffs)) {
                            foreach($staffs as $staff) {
                                // Fix: Use correct variable name
                                $selected = ($operation == "edit" && $item && isset($item['allocated_officer']) && $item['allocated_officer'] == $staff['staff_id']) ? "selected" : "";
                                echo "<option value=\"{$staff['staff_id']}\" $selected>{$staff['staff_first_name']} {$staff['staff_last_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <?php if($operation == "edit"): ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Allocated Date</label>
                    <input type="date" name="allocated_date" id="allocated_date" class="form-control"
                        value="<?php echo ($item && isset($item['allocated_date']) && $item['allocated_date']) ? date('Y-m-d', strtotime($item['allocated_date'])) : ""; ?>">
                    <div class="invalid-feedback">Please enter the allocated date.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Allocated By</label>
                    <input type="text" name="allocated_by" id="allocated_by" class="form-control"
                        value="<?php echo ($item && isset($item['allocated_by'])) ? htmlspecialchars($item['allocated_by']) : ""; ?>"
                        placeholder="Enter allocated by" autocomplete="off">
                    <div class="invalid-feedback">Please enter who allocated the item.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <div id="server_mssg"></div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="save_inventory" class="btn btn-primary" onclick="saveRecord()">
                <?php echo ($operation == "edit") ? "Update Item" : "Create Item"; ?>
            </button>
        </div>
        <?php endif; ?>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Debug: Log form data on page load
        console.log('Operation: <?php echo $operation; ?>');
        console.log('Item Condition Value: ' + $('#item_cond').val());
        console.log('Item Category Value: ' + $('#item_cat_id').val());

        // Show/hide allocation fields based on allocation status
        toggleAllocationFields();
        $('#allocation_status').on('change', toggleAllocationFields);

        // Form validation styling
        $('#form1 input, #form1 select, #form1 textarea').on('blur change', function () {
            if ($(this).prop('required') && !$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

    function toggleAllocationFields() {
        var allocationStatus = $('#allocation_status').val();
        if (allocationStatus === 'Allocated') {
            $('#allocation_fields').show();
            $('#allocated_officer').prop('required', true);
        } else {
            $('#allocation_fields').hide();
            $('#allocated_officer').prop('required', false);
            $('#allocated_officer').val('');
        }
    }

    function showMessage(message, type) {
        $("#server_mssg").html('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') +
            ' alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
            message + '</div>');

        // Auto-hide success messages
        if (type === 'success') {
            setTimeout(function () {
                $("#server_mssg").html('');
            }, 3000);
        }
    }

    // Save record function
    function saveRecord() {
        // Client-side validation
        var valid = true;
        var firstInvalidField = null;

        $('#form1 [required]').each(function () {
            if (!$(this).val() || !$(this).val().trim()) {
                $(this).addClass('is-invalid');
                if (!firstInvalidField) {
                    firstInvalidField = $(this);
                }
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            showMessage("Please fill all required fields.", "error");
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
            return;
        }

        $("#save_inventory").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $("#save_inventory").prop('disabled', true);

        var dd = $("#form1").serialize();
        console.log('Form data being sent:', dd);

        $.ajax({
            url: "utilities.php",
            type: "POST",
            data: dd,
            dataType: 'json',
            success: function (re) {
                console.log('Response received:', re);
                $("#save_inventory").html(
                    "<?php echo ($operation == 'edit') ? 'Update Item' : 'Create Item'; ?>");
                $("#save_inventory").prop('disabled', false);

                if (re.response_code == 0) {
                    showMessage(re.response_message, "success");

                    // Refresh the table after successful operation
                    if (typeof refreshInventoryList === 'function') {
                        refreshInventoryList();
                    } else if (typeof getpage === 'function') {
                        getpage('inventory_list.php', 'page');
                    }

                    // Clear form for new entries
                    if ("<?php echo $operation; ?>" === "new") {
                        $("#form1")[0].reset();
                        $("#allocation_status").val('Available');
                        $("#usage_status").val('Active');
                        toggleAllocationFields();
                    }

                    setTimeout(function () {
                        $('#defaultModalPrimary').modal('hide');
                    }, 1500);

                } else {
                    showMessage(re.response_message, "error");
                }
            },
            error: function (xhr, status, error) {
                console.log("Ajax Error:", xhr.responseText);
                console.log("Status:", status);
                console.log("Error:", error);
                $("#save_inventory").html(
                    "<?php echo ($operation == 'edit') ? 'Update Item' : 'Create Item'; ?>");
                $("#save_inventory").prop('disabled', false);
                showMessage("An error occurred while processing your request. Please try again.", "error");
            }
        });
    }
</script>