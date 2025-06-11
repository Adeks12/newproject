<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$sql_ch_type = "SELECT id,name FROM church_type";
$church_type = $dbobject->db_query($sql_ch_type);

$sql = "SELECT DISTINCT(State) as state,stateid FROM lga WHERE stateid NOT IN (select state_id FROM church_state_accounts) order by State";
$states = $dbobject->db_query($sql);

$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
$banks = $dbobject->db_query($sql2);
if (isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit') {
    $operation  = 'edit';
    $id  = $_REQUEST['id'];
    $sql_church = "SELECT * FROM church_type WHERE id = '$id'";
    $church     = $dbobject->db_query($sql_church);
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
    <h4 class="modal-title" style="font-weight:bold">State Account Number Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false">
        <input type="hidden" name="op" value="State.createStateAcccount">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="account_name" id="account_name" value="">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Church State</label>
                    <select name="state_id" id="church_state" class="form-control">
                        <option value="">:: SELECT STATE ::</option>
                        <?php
                        foreach ($states as $row) {
                            $selected = ($church[0]['state'] == $row['stateid']) ? "selected" : "";
                            echo "<option " . $selected . " value='" . $row['stateid'] . "'>" . $row['state'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Bank Name</label>
                    <select name="bank_code" id="bank_name" class="form-control">
                        <option value="">::SELECT A BANK::</option>
                        <?php
                        foreach ($banks as $row) {
                            $selected = ($user[0]['bank_name'] == $row['bank_code']) ? "selected" : "";
                            echo "<option " . $selected . " value='" . $row['bank_code'] . "'>" . $row['bank_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Account Number</label>
                    <input type="number" onkeyup="fetchAccName(this.value)" name="account_number" value="<?php echo $user[0]['account_no'] ?>" class="form-control" placeholder="" autocomplete="off">
                    <small id="acc_name"><?php echo $user[0]['account_name']; ?></small>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="server_mssg"></div>
            </div>
        </div>
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
            if (re.response_code == 0) {
                $("#server_mssg").text(re.response_message);
                $("#server_mssg").css({
                    'color': 'green',
                    'font-weight': 'bold'
                });
                getpage('state_account_list.php', 'page');
                setTimeout(() => {
                    $('#defaultModalPrimary').modal('hide');
                }, 1000)
            } else {
                regenerateCORS();
                $("#server_mssg").text(re.response_message);
                $("#server_mssg").css({
                    'color': 'red',
                    'font-weight': 'bold'
                });
            }
        }, 'json')
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