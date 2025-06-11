<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$user = $_SESSION['username_sess'];
$sql = ("SELECT merchant_id FROM userdata WHERE username = '$user' LIMIT 1");
$doquery= $dbobject->db_query($sql, true);
$merchant_id = $doquery[0]['merchant_id'];

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $item_cat_id = $_REQUEST['item_cat_id'] ?? '';
    
    if(empty($item_cat_id)) {
        echo "<script>console.log('Error: Item Category ID is missing');</script>";
        $item_cat = null;
        $operation = 'new';
    } else {
        $sql = "SELECT * FROM item_category WHERE item_cat_id='$item_cat_id' AND merchant_id='$merchant_id' LIMIT 1";
        $item_cat_result = $dbobject->db_query($sql, true);
        
        echo "<script>console.log('Item Cat ID: $item_cat_id');</script>";
        echo "<script>console.log('SQL Query: $sql');</script>";
        echo "<script>console.log('Query Result: " . json_encode($item_cat_result) . "');</script>";
        
        if($item_cat_result && is_array($item_cat_result) && count($item_cat_result) > 0) {
            $item_cat = $item_cat_result[0];
            $operation = 'edit';
            echo "<script>console.log('Item Cat Data: " . json_encode($item_cat) . "');</script>";
        } else {
            echo "<script>console.log('No item category found with ID: $item_cat_id');</script>";
            $item_cat = null;
            $operation = 'new';
        }
    }
}
else
{
    $operation = 'new';
    $item_cat = null;
}

// Fetch main categories for dropdown (excluding current category if editing)
$main_cat_sql = "SELECT item_cat_id, item_cat_name FROM item_category WHERE merchant_id='$merchant_id' AND (parent_cat_id = 0 OR parent_cat_id IS NULL)";
if ($operation == "edit" && !empty($item_cat_id)) {
    $main_cat_sql .= " AND item_cat_id != '$item_cat_id'";
}
$main_cat_sql .= " ORDER BY item_cat_name";
$main_categories = $dbobject->db_query($main_cat_sql, true);
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
    <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?>Item Category Setup
        <div><small style="font-size:12px">All asterik fields are compulsory</small></div>
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="item_cat.createitem_cat">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
        <input type="hidden" name="item_cat_id" value="<?php echo $item_cat_id; ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Category Name<span class="asterik">*</span></label>
                    <input type="text" name="item_cat_name" id="item_cat_name" class="form-control"
                        value="<?php echo ($operation == "edit" && $item_cat && isset($item_cat['item_cat_name'])) ? htmlspecialchars($item_cat['item_cat_name']) : ""; ?>"
                        placeholder="Enter category name" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter the category name.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php if($operation == "edit"): ?>
                <div class="form-group">
                    <label class="form-label">Item Code</label>
                    <input type="text" name="item_code" class="form-control"
                        value="<?php echo ($item_cat && isset($item_cat['item_code'])) ? htmlspecialchars($item_cat['item_code']) : ""; ?>"
                        placeholder="Auto-generated" readonly>
                    <small class="text-muted">Item code is auto-generated and cannot be changed</small>
                </div>
                <?php else: ?>
                <div class="form-group">
                    <label class="form-label">Item Code</label>
                    <input type="text" class="form-control" value="Auto-generated from company name" readonly>
                    <small class="text-muted">Item code will be auto-generated based on company name</small>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label" style="display:block !important">Category Status<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <select class="form-select" name="item_status" id="item_status" required disabled>
                            <option value="">:: SELECT STATUS ::</option>
                            <option value="1"
                                <?php echo ($operation == "edit" && $item_cat && isset($item_cat['item_status']) && $item_cat['item_status'] == '1') ? 'selected' : (($operation == "new") ? 'selected' : ''); ?>>
                                Active</option>
                            <option value="0"
                                <?php echo ($operation == "edit" && $item_cat && isset($item_cat['item_status']) && $item_cat['item_status'] == '0') ? 'selected' : ''; ?>>
                                Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select the category status.</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_cat_id" id="parent_cat_id" class="form-select">
                        <option value="0">-- No Parent (Main Category) --</option>
                        <?php
                        if (is_array($main_categories)) {
                            foreach ($main_categories as $cat) {
                                $selected = ($operation == "edit" && isset($item_cat['parent_cat_id']) && $item_cat['parent_cat_id'] == $cat['item_cat_id']) ? "selected" : "";
                                echo "<option value=\"{$cat['item_cat_id']}\" $selected>{$cat['item_cat_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <small class="text-muted">Select a parent to make this a subcategory, or leave as main
                        category.</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label">Category Description</label>
                    <textarea name="item_cat_description" class="form-control" rows="3"
                        placeholder="Enter category description (optional)"><?php echo ($operation == "edit" && $item_cat && isset($item_cat['item_cat_description'])) ? htmlspecialchars($item_cat['item_cat_description']) : ""; ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="server_mssg"></div>
            </div>
        </div>

        <?php include("form-footer.php"); ?>
        <button type="button" id="save_facility" class="btn btn-primary" onclick="saveRecord()">
            <?php echo ($operation == "edit") ? "Update Category" : "Create Category"; ?>
        </button>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Debug: Log form data on page load
        console.log('Operation: <?php echo $operation; ?>');
        console.log('Category Name Value: ' + $('#item_cat_name').val());

        // Form validation styling
        $('#form1 input, #form1 select, #form1 textarea').on('blur change', function () {
            if ($(this).prop('required') && !$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

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
            if (!$(this).val().trim()) {
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

        // Additional validation for category name
        var categoryName = $("#item_cat_name").val().trim();
        if (categoryName.length < 2) {
            showMessage("Category name must be at least 2 characters long.", "error");
            $("#item_cat_name").focus();
            return;
        }

        $("#save_facility").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $("#save_facility").prop('disabled', true);

        var dd = $("#form1").serialize();

        $.post("utilities.php", dd, function (re) {
            console.log(re);
            $("#save_facility").html(
                "<?php echo ($operation == 'edit') ? 'Update Category' : 'Create Category'; ?>");
            $("#save_facility").prop('disabled', false);

            if (re.response_code == 0) {
                showMessage(re.response_message, "success");

                // Refresh the table after successful operation
                if (typeof refreshItemCatList === 'function') {
                    refreshItemCatList();
                } else if (typeof getpage === 'function') {
                    getpage('item_cat_list.php', 'page');
                }

                // Clear form for new entries
                if ("<?php echo $operation; ?>" === "new") {
                    $("#form1")[0].reset();
                    $("#item_status").val('1'); // Reset to Active
                }

                setTimeout(function () {
                    $('#defaultModalPrimary').modal('hide');
                }, 1500);

            } else {
                showMessage(re.response_message, "error");
            }
        }, 'json').fail(function (xhr, status, error) {
            console.log("Ajax Error:", xhr.responseText);
            $("#save_facility").html(
                "<?php echo ($operation == 'edit') ? 'Update Category' : 'Create Category'; ?>");
            $("#save_facility").prop('disabled', false);
            showMessage("An error occurred while processing your request. Please try again.", "error");
        });
    }
</script>