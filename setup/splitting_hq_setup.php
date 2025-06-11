<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$sql = "SELECT id,name FROM church_type WHERE part_of_split = '1'";
$c_type = $dbobject->db_query($sql);



$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
$banks = $dbobject->db_query($sql2);

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $operation  = 'edit';
    $code  = $_REQUEST['code'];
    $sql_splitting = "SELECT * FROM splitting_state_hq WHERE id = '$code' LIMIT 1";
    $splitting     = $dbobject->db_query($sql_splitting);
//    var_dump($splitting);
    $sql = "SELECT DISTINCT(State) as state,stateid FROM lga  order by State";
    $states = $dbobject->db_query($sql);
}
else
{
    $operation = 'new';
    $sql       = "SELECT DISTINCT(State) as state,stateid FROM lga WHERE stateid NOT IN (select state_id FROM splitting_state_hq) order by State";
    $states    = $dbobject->db_query($sql);
}
?>
 
<script>
    doOnLoad();
    var myCalendar;
function doOnLoad()
{
   myCalendar = new dhtmlXCalendarObject(["start_date"]);
   myCalendar.hideTime();
}
</script>
<style>
    fieldset 
    { 
    display: block;
    margin-left: 2px;
    margin-right: 2px;
    padding-top: 0.35em;
    padding-bottom: 0.625em;
    padding-left: 0.75em;
    padding-right: 0.75em;
    border: 1px solid #ccc;
    }
    
    legend
    {
        font-size: 14px;
        padding: 5px;
        font-weight: bold;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Split Setup <small>(State/HQ)</small></h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Split.saveSplitStateHQ">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="id" value="<?php echo $code; ?>">
       <input type="hidden" name="account_name" id="account_name" value="<?php echo $splitting[0]['account_name']; ?>">
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Remitting State</label>
                    <select name="state_id" id="church_state" class="form-control">
                       <option value="">:: SELECT STATE ::</option>
                        <?php
                        foreach($states as $row)
                        {
                            $selected = ($splitting[0]['state_id'] == $row['stateid'])?"selected":"";
                            echo "<option ".$selected." value='".$row['stateid']."'>".$row['state']."</option>";
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
                        foreach($banks as $row)
                        {
                            $selected = ($splitting[0]['bank_code'] == $row['bank_code'])?"selected":"";
                            echo "<option ".$selected." value='".$row['bank_code']."'>".$row['bank_name']."</option>";
                        }
                    ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Account Number</label>
                    <input type="number" onkeyup="fetchAccName(this.value)"  name="account_number" value="<?php echo $splitting[0]['account_number'] ?>" class="form-control" placeholder="" autocomplete="off">
                    <small id="acc_name"><?php echo $splitting[0]['account_name']; ?></small>
                </div>
            </div>
        </div>
      <div class="row">
          <div class="col-sm-6">
                <div class="form-group">
                <label for="">Headquarters percentage</label>
                <div class="input-group">
                    <input type="number" id="max_amt" value="<?php echo $splitting[0]['hq_share']; ?>" name="hq_share" class="form-control" placeholder="" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            %
                        </div>
                    </div>
                </div>
                </div>
           </div>
           <div class="col-sm-6">
                <div class="form-group">
                <label for="">State percentage</label>
                <div class="input-group">
                    <input type="text" id="max_amt" value="<?php echo $splitting[0]['state_hq_share']; ?>" name="state_hq_share" class="form-control" placeholder="" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            %
                        </div>
                    </div>
                </div>
                </div>
           </div>
      </div>
      <?php include("form-footer.php"); ?>
       <div id="err"></div>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    
    function saveRecord()
    {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        $.post("utilities.php",dd,function(re)
        {
            $("#save_facility").text("Save");
            console.log(re);
            if(re.response_code == 0)
                {
                    $("#err").css('color','green')
                    $("#err").text(re.response_message);
                    getpage('splitting_list_hq.php','page');
                    setTimeout(()=>{
                        $('#defaultModalPrimary').modal('hide');
                    },1000)
                }
            else
                {
                    regenerateCORS();
                    $("#err").css('color','red')
                    $("#err").text(re.response_message)
                }
                
        },'json')
    }
    
        function fetchAccName(acc_no)
    {
        if(acc_no.length == 10)
            {
                var account  = acc_no;
                var bnk_code = $("#bank_name").val();
                $("#acc_name").text("Verifying account number....");
                $("#account_name").val("");
                $.post("utilities.php",{op:"Church.getAccountName",account_no:account,bank_code:bnk_code},function(res){
                    
                    $("#acc_name").text(res);
                    $("#account_name").val(res);
                });
            }else{
                $("#acc_name").text("Account Number must be 10 digits");
            }
        
    }       
  
</script>