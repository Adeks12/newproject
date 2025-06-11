<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$sql = "SELECT DISTINCT(State) as state,stateid FROM lga order by State";
$states = $dbobject->db_query($sql);

$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
$banks = $dbobject->db_query($sql2);

$sql_pastor = "SELECT username,firstname,lastname FROM userdata WHERE role_id = '003'";
$pastors = $dbobject->db_query($sql_pastor);

$sql_ch_type = "SELECT id,name FROM church_type WHERE id <> '5'";
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
    <h4 class="modal-title" style="font-weight:bold">Church Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="op" value="Church.saveChurch">
        <input type="hidden" name="operation" value="<?php echo $operation; ?>">
        <input type="hidden" name="church_id" value="<?php echo $church_id; ?>">
        <input type="hidden" name="warning" id="warning" value="0">
        <input type="hidden" name="account_name" id="account_name" value="<?php echo $church[0]['account_name']; ?>">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Church Name</label>
                    <input type="text" name="church_name" class="form-control" value="<?php echo $church[0]['church_name']; ?>" placeholder="" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Date of Inception</label>
                    <input type="text" autocomplete="off" name="date_of_inception" value="<?php echo $church[0]['date_of_inception']; ?>" id="start_date" class="form-control" autocomplete="off" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">State</label>
                    <select name="state" id="church_state" onchange="fetchLga(this.value)" class="form-control">
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Local Government Area</label>
                    <select name="lga" id="lga-fds" class="form-control">
                        <?php
                        if ($operation == "edit") {
                            echo "<option value='" . $church[0]['lga'] . "'>" . $dbobject->getitemlabel('lga', 'Lgaid', $church[0]['lga'], 'Lga') . "</option>";
                        } ?>
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
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Church Type</label>
                    <select onchange="church_regions(this.value)" name="church_type" required id="church_type" class="form-control">
                        <?php
                        foreach ($church_type as $row) {
                            $selected = ($church[0]['church_type'] == $row['id']) ? "selected" : "";
                            echo "<option " . $selected . " value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Church Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $church[0]['address']; ?>" autocomplete="off" />
                </div>
            </div>
        </div>
        <div class="row" id="church_region" style="display:none">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="">Under which region does this church belong?</label>
                    <select name="church_region" id="church_region_select" class="form-control">

                    </select>
                </div>
            </div>
        </div>


        <!--
        <div class="form-group">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input">
                <span class="custom-control-label">Check me out</span>
            </label>
        </div>
-->
        <?php include("form-footer.php"); ?>
        <div id="err"></div>
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
                $("#err").css('color', 'green')
                $("#err").text(re.response_message)
                getpage('church_list_admin.php', 'page');
                setTimeout(() => {
                    $('#defaultModalPrimary').modal('hide');
                }, 1000)
            } else if (re.response_code == 410) {
                regenerateCORS();
                //                    $("#err").css('color','red')
                $("#err").html(re.response_message)
                $("#warning").val("1");
            } else {
                regenerateCORS();
                $("#err").css('color', 'red')
                $("#err").html(re.response_message)
                $("#warning").val("0");
            }

        }, 'json')
    }
    if ($("#sh_display").is(':checked')) {

    }

    function fetchLga(el) {
        getRegions(el);
        $("#lga-fds").html("<option>Loading Lga</option>");
        $.post("utilities.php", {
            op: 'Church.getLga',
            state: el
        }, function(re) {
            $("#lga-fds").empty();
            $("#lga-fds").html(re.state);

        }, 'json');
        //        $.blockUI();
    }

    function getRegions(state_id) {
        $("#church_region_select").html("<option>Loading....</option>");
        $.post("utilities.php", {
            op: 'Church.getRegions',
            state: state_id
        }, function(re) {
            $("#church_region_select").empty();
            $("#church_region_select").html(re);

        });
    }

    function church_regions(val) {
        if (val == 4) {
            $("#church_region").slideDown()
        } else {
            $("#church_region").slideUp()
        }
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