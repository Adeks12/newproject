<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();


$user = $_SESSION['username_sess'];
$sql = ("SELECT merchant_id FROM userdata WHERE username = '$user' LIMIT 1");
$doquery= $dbobject->db_query($sql, true);
$merchant_id = $doquery[0]['merchant_id'];
$sql1 = ("SELECT depmt_id, depmt_name FROM department WHERE merchant_id = '$merchant_id' ORDER BY
depmt_name");
$departments = $dbobject->db_query($sql1, true);

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $staff_id = $_REQUEST['staff_id'] ?? '';
    
    if(empty($staff_id)) {
        echo "<script>console.log('Error: staff ID is missing');</script>";
        $staff = null;
        $operation = 'new';
    } else {
        $sql = "SELECT * FROM staff WHERE staff_id='$staff_id' AND merchant_id='$merchant_id' LIMIT 1";
        $staff_result = $dbobject->db_query($sql, true);
        
        echo "<script>console.log('Staff ID: $staff_id');</script>";
        echo "<script>console.log('SQL Query: $sql');</script>";
        echo "<script>console.log('Query Result: " . json_encode($staff_result) . "');</script>";
        
        if($staff_result && is_array($staff_result) && count($staff_result) > 0) {
            $staff = $staff_result[0];
            $operation = 'edit';
            echo "<script>console.log('Staff Data: " . json_encode($staff) . "');</script>";
        } else {
            echo "<script>console.log('No staff found with ID: $staff_id');</script>";
            $staff = null;
            $operation = 'new';
        }
    }
}
else
{
    $operation = 'new';
    $staff = null;
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
    <h4 class="modal-title" style="font-weight:bold"><?php echo ($operation=="edit")?"Edit ":""; ?>Staff Setup
        <div><small style="font-size:12px">All asterik fields are compulsory</small></div>
    </h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="staff.createStaff">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo $merchant_id; ?>">
        <?php if($operation == "edit"): ?>
        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">First Name<span class="asterik">*</span></label>
                    <input type="text" name="staff_first_name" id="staff_first_name" class="form-control"
                        value="<?php echo ($operation == "edit" && $staff && isset($staff['staff_first_name'])) ? htmlspecialchars($staff['staff_first_name']) : ""; ?>"
                        placeholder="Enter first name" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter the first name.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Last Name<span class="asterik">*</span></label>
                    <input type="text" name="staff_last_name" id="staff_last_name" class="form-control"
                        value="<?php echo ($operation == "edit" && $staff && isset($staff['staff_last_name'])) ? htmlspecialchars($staff['staff_last_name']) : ""; ?>"
                        placeholder="Enter last name" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter the last name.</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Email<span class="asterik">*</span></label>
                    <input type="email" name="staff_email" id="staff_email" class="form-control"
                        value="<?php echo ($operation == "edit" && $staff && isset($staff['staff_email'])) ? htmlspecialchars($staff['staff_email']) : ""; ?>"
                        placeholder="Enter email" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter the email.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Phone Number<span class="asterik">*</span></label>
                    <input type="text" name="staff_phone_no" id="staff_phone_no" class="form-control"
                        value="<?php echo ($operation == "edit" && $staff && isset($staff['staff_phone_no'])) ? htmlspecialchars($staff['staff_phone_no']) : ""; ?>"
                        placeholder="Enter phone number" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter the phone number.</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Staff Address</label>
                    <input type="text" name="staff_address" id="staff_address"
                        value="<?php echo ($operation == "edit" && $staff && isset($staff['staff_address'])) ? htmlspecialchars($staff['staff_address']) : "" ?>"
                        class="form-control" placeholder="Enter staff address" autocomplete="off">
                    <div class="invalid-feedback">Please enter the staff address.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Department<span class="asterik">*</span></label>
                    <select name="depmt_id" id="depmt_id" class="form-select" required>
                        <option value="">:: SELECT DEPARTMENT ::</option>
                        <?php
                        if (is_array($departments)) {
                            foreach ($departments as $dept) {
                                $selected = ($operation == "edit" && $staff && isset($staff['depmt_id']) && $staff['depmt_id'] == $dept['depmt_id']) ? "selected" : "";
                                echo "<option value=\"{$dept['depmt_id']}\" $selected>{$dept['depmt_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Please select a department.</div>
                </div>
            </div>
        </div>

        <?php if($operation == "edit"): ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Staff Code</label>
                    <input type="text" name="staff_code" class="form-control"
                        value="<?php echo ($staff && isset($staff['staff_code'])) ? htmlspecialchars($staff['staff_code']) : ""; ?>"
                        placeholder="Auto-generated" readonly>
                    <small class="text-muted">Staff code is auto-generated and cannot be changed</small>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label" style="display:block !important">Staff Status<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <select class="form-select" name="staff_status" id="staff_status" required>
                            <option value="">:: SELECT STATUS ::</option>
                            <option value="1"
                                <?php echo ($operation == "edit" && $staff && isset($staff['staff_status']) && $staff['staff_status'] == '1') ? 'selected' : ''; ?>>
                                Still employed</option>
                            <option value="0"
                                <?php echo ($operation == "edit" && $staff && isset($staff['staff_status']) && $staff['staff_status'] == '0') ? 'selected' : ''; ?>>
                                No longer employed</option>
                        </select>
                        <div class="invalid-feedback">Please select the staff status.</div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Staff Code</label>
                    <input type="text" class="form-control" value="Auto-generated from company name" readonly>
                    <small class="text-muted">Staff code will be auto-generated based on company name</small>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label" style="display:block !important">Staff Status<span
                            class="asterik">*</span></label>
                    <div class="input-group">
                        <select class="form-select" name="staff_status" id="staff_status" required>
                            <option value="">:: SELECT STATUS ::</option>
                            <option value="1" selected>Still employed</option>
                            <option value="0">No longer employed</option>
                        </select>
                        <div class="invalid-feedback">Please select the staff status.</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label">Staff Description</label>
                    <textarea name="staff_description" class="form-control" rows="3"
                        placeholder="Enter staff description (optional)"><?php echo ($operation == "edit" && $staff && isset($staff['staff_description'])) ? htmlspecialchars($staff['staff_description']) : ""; ?></textarea>
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
            <?php echo ($operation == "edit") ? "Update Staff" : "Create Staff"; ?>
        </button>
    </form>
</div>

<script>
    $(document).ready(function () {
        // Debug: Log form data on page load
        console.log('Operation: <?php echo $operation; ?>');
        console.log('Staff First Name Value: ' + $('#staff_first_name').val());
        console.log('Staff Last Name Value: ' + $('#staff_last_name').val());

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

        // Additional validation for staff name
        var staffFirstName = $("#staff_first_name").val().trim();
        var staffLastName = $("#staff_last_name").val().trim();
        if (staffFirstName.length < 2) {
            showMessage("Staff first name must be at least 2 characters long.", "error");
            $("#staff_first_name").focus();
            return;
        }
        if (staffLastName.length < 2) {
            showMessage("Staff last name must be at least 2 characters long.", "error");
            $("#staff_last_name").focus();
            return;
        }

        $("#save_facility").html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        $("#save_facility").prop('disabled', true);

        var dd = $("#form1").serialize();

        $.post("utilities.php", dd, function (re) {
            console.log(re);
            $("#save_facility").html("<?php echo ($operation == 'edit') ? 'Update Staff' : 'Create Staff'; ?>");
            $("#save_facility").prop('disabled', false);

            if (re.response_code == 0) {
                showMessage(re.response_message, "success");

                // Refresh the table after successful operation
                if (typeof refreshStaffList === 'function') {
                    refreshStaffList();
                } else if (typeof getpage === 'function') {
                    getpage('staff_list.php', 'page');
                }

                // Clear form for new entries
                if ("<?php echo $operation; ?>" === "new") {
                    $("#form1")[0].reset();
                    $("#staff_status").val('1'); // Reset to Active
                }

                setTimeout(function () {
                    $('#defaultModalPrimary').modal('hide');
                }, 1500);

            } else {
                showMessage(re.response_message, "error");
            }
        }, 'json').fail(function (xhr, status, error) {
            console.log("Ajax Error:", xhr.responseText);
            $("#save_facility").html("<?php echo ($operation == 'edit') ? 'Update Staff' : 'Create Staff'; ?>");
            $("#save_facility").prop('disabled', false);
            showMessage("An error occurred while processing your request. Please try again.", "error");
        });
    }
</script>