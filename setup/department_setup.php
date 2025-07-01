<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$user = $_SESSION['username_sess'];
$sql = ("SELECT merchant_id FROM userdata WHERE username = '$user' LIMIT 1");
$doquery= $dbobject->db_query($sql, true);
$merchant_id = $doquery[0]['merchant_id'];



// $sql1 = ("SELECT username, first_name, last_name FROM userdata WHERE merchant_id='$merchant_id' AND
// depmt_head=1");
// $doquery1 = $dbobject->db_query($sql1, true);
// $heads = $doquery1;

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    // Fixed: Use consistent parameter name and add debugging
    $department_id = $_REQUEST['depmt_id'] ?? $_REQUEST['department_id'] ?? '';
    
    // Debug: Add error checking
    if(empty($department_id)) {
        echo "<script>console.log('Error: Department ID is missing');</script>";
        $dept = null;
        $operation = 'edit';
    } else {
        // Fixed: Add proper error handling and debugging
        $sql = "SELECT * FROM department WHERE depmt_id='$department_id' AND merchant_id='$merchant_id' LIMIT 1";
        $dept_result = $dbobject->db_query($sql, true);
        
        // Debug output
        echo "<script>console.log('Department ID: $department_id');</script>";
        echo "<script>console.log('SQL Query: $sql');</script>";
        echo "<script>console.log('Query Result: " . json_encode($dept_result) . "');</script>";
        
        if($dept_result && is_array($dept_result) && count($dept_result) > 0) {
            $dept = $dept_result[0];
            $operation = 'edit';
            echo "<script>console.log('Department Data: " . json_encode($dept) . "');</script>";
        } else {
            echo "<script>console.log('No department found with ID: $department_id');</script>";
            $dept = null;
            $operation = 'new';
        }
    }
}
else
{
    $operation = 'new';
    $dept = null;
}
?>

<style>
    #login_days>label {
        margin-right: 10px;
    }

    .asterik {
        color: red;
    }

    .form-group {
        margin-bottom: 1rem;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?>Department Setup
        <div><small style="font-size:12px">All asterik fields are compulsory</small></div>
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="Department.createDepartment">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
        <input type="hidden" name="depmt_id" value="<?php echo $department_id; ?>">
        
        <?php var_dump($department_id);
     endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="depmt_name">Department Name <span class="asterik">*</span></label>
                    <input type="text" class="form-control" id="depmt_name" name="depmt_name" required
                        value="<?php echo isset($dept['depmt_name']) ? $dept['depmt_name'] : ''; ?>" placeholder="Enter Department Name">
                </div>
            </div>
            
            
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">Department Code</label>
                        <input type="text" name="depmt_code" class="form-control"
                            value="<?php echo ($operation == "edit" && $dept && isset($dept['depmt_code'])) ? htmlspecialchars($dept['depmt_code']) : ""; ?>"
                            placeholder="Enter Department Code">
                        <small class="asterik">Department code will be generate automatically if this field is empty</small>
                    </div>
                </div>
            
        </div>
        <?php if($operation == "edit"): ?>
            <div class="row">
        
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label" style="display:block !important">Department Status<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <select class="form-select" name="depmt_status" id="depmt_status" required>
                            <option value="">:: SELECT STATUS ::</option>
                            <option value="1"
                                <?php echo ($operation == "edit" && $dept && isset($dept['depmt_status']) && $dept['depmt_status'] == '1') ? 'selected' : ''; ?>>
                                Active</option>
                            <option value="0"
                                <?php echo ($operation == "edit" && $dept && isset($dept['depmt_status']) && $dept['depmt_status'] == '0') ? 'selected' : ''; ?>>
                                Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select the department status.</div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Department Code</label>
                    <input type="text" class="form-control" value="Auto-generated from department name" readonly>
                    <small class="text-muted">Department code will be auto-generated based on department name</small>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label" style="display:block !important">Department Status<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <select class="form-select" name="depmt_status" id="depmt_status" required>
                            <option value="">:: SELECT STATUS ::</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Please select the department status.</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label">Department Description</label>
                    <textarea name="depmt_description" class="form-control" rows="3"
                        placeholder="Enter department description (optional)"><?php echo ($operation == "edit" && $dept && isset($dept['depmt_description'])) ? htmlspecialchars($dept['depmt_description']) : ""; ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="server_mssg"></div>
            </div>
        </div>

        <?php include("form-footer.php"); ?>
        <button type="button" id="save_facility" class="btn btn-primary" onclick="saveRecord()">
            <?php echo ($operation == "edit") ? "Update Department" : "Create Department"; ?>
        </button>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Debug: Log form data on page load
        console.log('Operation: <?php echo $operation; ?>');
        console.log('Department Name Value: ' + $('#depmt_name').val());
        console.log('Department Head Value: ' + $('#depmt_head').val());

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

        // Additional validation for department name
        var deptName = $("#depmt_name").val().trim();
        if (deptName.length < 2) {
            showMessage("Department name must be at least 2 characters long.", "error");
            $("#depmt_name").focus();
            return;
        }

        $("#save_facility").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $("#save_facility").prop('disabled', true);

        var dd = $("#form1").serialize();

        $.post("utilities.php", dd, function (re) {
            console.log(re);
            $("#save_facility").html("<?php echo ($operation == 'edit') ? 'Update Department' : 'Create Department'; ?>");
            $("#save_facility").prop('disabled', false);

            if (re.response_code == 0) {
                showMessage(re.response_message, "success");

                // Refresh the table after successful operation
                if (typeof refreshDepartmentList === 'function') {
                    refreshDepartmentList();
                } else if (typeof getpage === 'function') {
                    getpage('user_list.php', 'page');
                }

                // Clear form for new entries
                if ("<?php echo $operation; ?>" === "new") {
                    $("#form1")[0].reset();
                    $("#depmt_status").val('1'); // Reset to Active
                }

                setTimeout(function () {
                    $('#defaultModalPrimary').modal('hide');
                }, 1500);

            } else {
                showMessage(re.response_message, "error");
            }
        }, 'json').fail(function (xhr, status, error) {
            console.log("Ajax Error:", xhr.responseText);
            $("#save_facility").html("<?php echo ($operation == 'edit') ? 'Update Department' : 'Create Department'; ?>");
            $("#save_facility").prop('disabled', false);
            showMessage("An error occurred while processing your request. Please try again.", "error");
        });
    }
</script>