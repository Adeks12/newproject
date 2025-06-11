<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$sql = "SELECT DISTINCT(State) as state,stateid FROM lga order by State";
$states = $dbobject->db_query($sql);

$sql2 = "SELECT bank_code,bank_name FROM banks WHERE bank_type = 'commercial' order by bank_name";
$banks = $dbobject->db_query($sql2);

$operation = 'edit';
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
<div style="background:#fff">
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Setup Bank Details</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 " >
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Users.updatePastorBank">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="account_name" id="account_name" value="">
       
        <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Bank Name</label>
                    <select name="bank_name" id="bank_name" class="form-control">
                        <?php
                            foreach($banks as $row)
                            {
                                $selected = ($church[0]['bank_code'] == $row['bank_code'])?"selected":"";
                                echo "<option ".$selected." value='".$row['bank_code']."'>".$row['bank_name']."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="form-label">Account Number</label>
                    <input type="number" onkeyup="fetchAccName(this.value)" name="account_no" value="<?php echo $church[0]['account_no']; ?>" class="form-control" placeholder="" autocomplete="off">
                    <small id="acc_name"></small>
                </div>
                
            </div>
        </div>
        <?php include("form-footer.php"); ?>
          <div id="err"></div>
          <div class="row">
              <div class="col-sm-4">
                  <button id="save_facility" onclick="saveRecord()" class="btn btn-info btn-block mb-1">Submit</button>
              </div>
          </div>
    </form>
</div>
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
                    $("#err").css('color','green');
                    $("#err").html(re.response_message);
                    setTimeout(()=>{
                        window.location = "home.php"; 
                    },'1000')
                    
                }
            else
                {
                    regenerateCORS();
                     $("#err").css('color','red')
                    $("#err").html(re.response_message)
                    $("#warning").val("0");
                }
                
        },'json')
    }
    function automatic()
    {
        if($("#auto").is(':checked'))
        {
            $("#auto_val").val(1)
        }else{
             $("#auto_val").val(0)
        }
    }
    
    function fetchLga(el)
    {
        getRegions(el);
        $("#lga-fds").html("<option>Loading Lga</option>");
        $.post("utilities.php",{op:'Church.getLga',state:el},function(re){
            $("#lga-fds").empty();
            $("#lga-fds").html(re.state);
            
        },'json');
//        $.blockUI();
    }
    function getRegions(state_id)
    {
        $("#church_region_select").html("<option>Loading....</option>");
        $.post("utilities.php",{op:'Church.getRegions',state:state_id},function(re){
            $("#church_region_select").empty();
            $("#church_region_select").html(re);
            
        });
    }
    function church_regions(val)
    {
        if(val == 4)
            {
                $("#church_region").slideDown()
            }else{
                $("#church_region").slideUp()
            }
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