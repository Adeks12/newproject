<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$sql = "SELECT DISTINCT(State) as state FROM lga order by State";
$states = $dbobject->db_query($sql);

$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
$banks = $dbobject->db_query($sql2);

$sql_pastor = "SELECT username,firstname,lastname FROM userdata WHERE role_id = '003'";
$pastors = $dbobject->db_query($sql_pastor);

$sql_ch_type = "SELECT id,name FROM church_type";
$church_type = $dbobject->db_query($sql_ch_type);

if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation = 'edit';
    $church_id = $_REQUEST['church_id'];
    $sql_church = "SELECT * FROM church_table WHERE church_id = '$church_id'";
    $church = $dbobject->db_query($sql_church);
} else {
    $operation = 'new';
}
?>

<script>
    doOnLoad();
    var myCalendar;

    function doOnLoad() {
        myCalendar = new dhtmlXCalendarObject(["start_date"]);
        myCalendar.hideTime();
    }
</script>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Pastor Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="Church.savePastor">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="username" value="<?php echo $church_id; ?>">
        <input type="hidden" name="role_id" value="003" />
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Email</label><small style="float:right;color:red">This will be used to login</small>
                    <input type="text" name="username" class="form-control" value="<?php echo $church[0]['username']; ?>" placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" autocomplete="off" name="password" value="<?php echo $church[0]['date_of_inception']; ?>" id="start_date" class="form-control" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="number" name="firstname" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select class="form-control" name="sex" id="">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Bank Name</label>
                    <select name="bank_code" id="bank_name" class="form-control">
                        <?php
                        foreach ($banks as $row) {
                            $selected = ($church[0]['bank_code'] == $row['bank_code']) ? "selected" : "";
                            echo "<option " . $selected . " value='" . $row['bank_code'] . "'>" . $row['bank_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Account Number</label>
                    <input type="number" onchange="fetchAccName(this.value)" name="account_no" value="<?php echo $church[0]['account_no']; ?>" class="form-control" placeholder="" autocomplete="off">
                    <small id="acc_name"><?php echo $church[0]['account_name']; ?></small>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="">Pastoring Church</label>
                    <select name="" id="" class="form-control"></select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for=""><b>Login Days</b></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group" id="login_days">
                    <label class="form-label" id="day1"><input type="checkbox" name="day1"> Sunday</label>
                    <label class="form-label" id="day2"><input type="checkbox" name="day2"> Monday</label>
                    <label class="form-label" id="day3"><input type="checkbox" name="day3"> Tuesday</label>
                    <label class="form-label" id="day4"><input type="checkbox" name="day4"> Wednesday</label>
                    <label class="form-label" id="day5"><input type="checkbox" name="day5"> Thursday</label>
                    <label class="form-label" id="day6"><input type="checkbox" name="day6"> Friday</label>
                    <label class="form-label" id="day7"><input type="checkbox" name="day7"> Saturday</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for=""><b>Security Settings</b></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label" id="day1"><input type="checkbox" id="day1"> Lock User</label>
                    <label class="form-label" id="day1"><input type="checkbox" id="day1"> Change password on first login</label>


                </div>
            </div>

        </div>
        <style>
            #login_days>label {
                margin-right: 10px;
            }
        </style>


        <!--
        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-label">Check me out</span>
            </label>
        </div>
-->
        <?php include("form-footer.php"); ?>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    function saveRecord() {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("utilities.php", dd, function(re) {
            $("#save_facility").text("Save");
            console.log(re);
            if (re == 1)
                alert("record saved")
            else
            regenerateCORS();
                alert("failed to save record")
        })
    }
    if ($("#sh_display").is(':checked')) {

    }

    function fetchLga(el) {
        $("#lga-fd").html("<option>Loading Lga</option>");
        $.post("utilities.php", {
            op: 'Church.getLga',
            state: el
        }, function(re) {
            $("#lga-fd").empty();
            $("#lga-fd").html(re);

        });
        //        $.blockUI();
    }

    function fetchAccName(acc_no) {
        if (acc_no.length == 10) {
            var account = acc_no;
            var bnk_code = $("#bank_name").val();
            $("#acc_name").text("Verifying account number....");
            $("#account_name").val("");
            $.post("utilities.php", {
                op: "Church.getAccountName",
                account_no: account,
                bank_code: bnk_code
            }, function(res) {

                $("#acc_name").text(res);
                $("#account_name").val(res);
            });
        } else {
            $("#acc_name").text("Account Number must be 10 digits");
        }

    }
</script>