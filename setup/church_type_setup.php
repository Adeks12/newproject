<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$sql_ch_type = "SELECT id,name FROM church_type";
$church_type = $dbobject->db_query($sql_ch_type);

if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $operation  = 'edit';
    $id  = $_REQUEST['id'];
    $sql_church = "SELECT * FROM church_type WHERE id = '$id'";
    $church     = $dbobject->db_query($sql_church);
}else
{
    $operation = 'new';
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
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Church Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Church.saveChurchType">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="id" value="<?php echo $id; ?>">
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Type Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $church[0]['name']; ?>" placeholder="" autocomplete="off">
                </div>
           </div>
       </div>
       <?php include("form-footer.php"); ?>
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
            if(re == 1)
                alert("record saved")
            else
            regenerateCORS();
                alert("failed to save record")
        })
    }
    
            
  
</script>