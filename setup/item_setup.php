<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$user = $_SESSION['username_sess'];
$sql = "SELECT merchant_id FROM userdata WHERE username = '$user' LIMIT 1";
$doquery = $dbobject->db_query($sql, true);
$merchant_id = $doquery[0]['merchant_id'];

$operation = "new";
$item = null;
// if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
//     $item_id = $_REQUEST['item_id'] ?? '';
//     if(!empty($item_id)) {
//         // FIX: Use correct table name (items)
//         $sql1 = "SELECT * FROM item WHERE item_id='$item_id' AND merchant_id='$merchant_id' LIMIT 1";
//         // Debugging
//         // var_dump($sql1);
//         $itm_result = $dbobject->db_query($sql1, true);
//         // var_dump($itm_result);
//         if($itm_result && is_array($itm_result) && count($itm_result) > 0) {
//             $item = $itm_result[0];
//             $operation = 'edit';
//         }
//     }
// }

// Fetch categories for dropdown
$cat_sql = "SELECT item_cat_id, item_cat_name FROM item_category WHERE merchant_id='$merchant_id' AND item_status='1' ORDER BY item_cat_name";
$categories = $dbobject->db_query($cat_sql, true);
?>

<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">
        <?php echo ($operation=="edit")?"Edit ":"Create "; ?>Item
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3">
    <form id="itemForm" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="items.createItem">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
        <?php 
      endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Item Name <span class="asterik">*</span></label>
                    <input type="text" name="item_name" class="form-control" required
                        value="<?php echo $item['item_name'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Item Category <span class="asterik">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">:: SELECT CATEGORY ::</option>
                        <?php
                        if($categories) {
                            foreach($categories as $cat) {
                                $selected = ($item && $item['category_id'] == $cat['item_cat_id']) ? "selected" : "";
                                echo "<option value='{$cat['item_cat_id']}' $selected>{$cat['item_cat_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Condition <span class="asterik">*</span></label>
                    <select name="item_condition" class="form-control" required>
                        <option value="">:: SELECT CONDITION ::</option>
                        <option value="New" <?php echo ($item && $item['item_condition']=='New')?'selected':''; ?>>New</option>
                        <option value="Good" <?php echo ($item && $item['item_condition']=='Good')?'selected':''; ?>>Good</option>
                        <option value="Fair" <?php echo ($item && $item['item_condition']=='Fair')?'selected':''; ?>>Fair</option>
                        <option value="Poor" <?php echo ($item && $item['item_condition']=='Poor')?'selected':''; ?>>Poor</option>
                        <option value="Damaged" <?php echo ($item && $item['item_condition']=='Damaged')?'selected':''; ?>>Damaged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" value="<?php echo $item['color'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Quantity <span class="asterik">*</span></label>
                    <input type="number" name="quantity" class="form-control" required value="<?php echo $item['quantity'] ?? ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status <span class="asterik">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="">:: SELECT STATUS ::</option>
                        <option value="Available" <?php echo ($item && $item['status']=='Available')?'selected':''; ?>>Available</option>
                        <option value="Allocated" <?php echo ($item && $item['status']=='Allocated')?'selected':''; ?>>Allocated</option>
                        <option value="Reserved" <?php echo ($item && $item['status']=='Reserved')?'selected':''; ?>>Reserved</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="<?php echo $item['purchase_date'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Warranty</label>
                    <input type="text" name="warranty" class="form-control" value="<?php echo $item['warranty'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" value="<?php echo $item['location'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Item Code</label>
                    <input type="text" class="form-control" value="<?php echo $item['item_code'] ?? 'Auto-generated'; ?>" readonly>
                    <small class="text-muted">Item code is auto-generated and cannot be changed</small>
                </div>
            </div>
        </div>
        <div id="server_mssg"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="save_item" class="btn btn-primary" onclick="saveItem()">
                <?php echo ($operation == "edit") ? "Update Item" : "Create Item"; ?>
            </button>
        </div>
    </form>
</div>

<script>
function showMessage(message, type) {
    $("#server_mssg").html('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') +
        ' alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        message + '</div>');
    if (type === 'success') {
        setTimeout(function () {
            $("#server_mssg").html('');
        }, 3000);
    }
}

function saveItem() {
    var valid = true;
    var firstInvalidField = null;
    $('#itemForm [required]').each(function () {
        if (!$(this).val() || !$(this).val().trim()) {
            $(this).addClass('is-invalid');
            if (!firstInvalidField) firstInvalidField = $(this);
            valid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    if (!valid) {
        showMessage("Please fill all required fields.", "error");
        if (firstInvalidField) firstInvalidField.focus();
        return;
    }
    $("#save_item").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
    $("#save_item").prop('disabled', true);

    var dd = $("#itemForm").serialize();
    $.ajax({
        url: "utilities.php",
        type: "POST",
        data: dd,
        dataType: 'json',
        success: function (re) {
            $("#save_item").html("<?php echo ($operation == 'edit') ? 'Update Item' : 'Create Item'; ?>");
            $("#save_item").prop('disabled', false);
            if (re.response_code == 0) {
                showMessage(re.response_message, "success");
                if (typeof refreshItemList === 'function') {
                    refreshItemList();
                }
                setTimeout(function () {
                    $('#defaultModalPrimary').modal('hide');
                }, 1500);
            } else {
                showMessage(re.response_message, "error");
            }
        },
        error: function () {
            $("#save_item").html("<?php echo ($operation == 'edit') ? 'Update Item' : 'Create Item'; ?>");
            $("#save_item").prop('disabled', false);
            showMessage("An error occurred while processing your request. Please try again.", "error");
        }
    });
}
</script>