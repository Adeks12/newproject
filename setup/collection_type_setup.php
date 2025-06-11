<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$sql = "SELECT * FROM collection_category";
$r   = $dbobject->db_query($sql);
if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $operation  = 'edit';
    $id  = $_REQUEST['id'];
    $sql_collection_type = "SELECT * FROM collection_type WHERE id = '$id'";
    $collection_type     = $dbobject->db_query($sql_collection_type);
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
    <h4 class="modal-title" style="font-weight:bold">Collection Type Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Collection.saveCollectionType">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="id" value="<?php echo $id; ?>">
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Collection Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $collection_type[0]['name']; ?>" placeholder="" autocomplete="off">
                </div>
           </div>
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Category </label>
                    <select name="category_id" class="form-control" id="">
                        <?php
                        foreach($r as $row)
                        {
                            $selected = ($collection_type[0]['category_id'] == $row['id'])?"selected":"";
                            echo "<option $selected value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
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
            if(re.response_code == 0)
                {
                    alert(re.response_message);
                    getpage('collection_type_list.php','page');
                    setTimeout(()=>{
                        $('#defaultModalPrimary').modal('hide');
                    },1000)
                }
            else
            regenerateCORS();
                alert(re.response_message)
        },'json')
    }
    
            
  
</script>