<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();
$sql = "SELECT id,name FROM church_type WHERE part_of_split = '1'";
$c_type = $dbobject->db_query($sql);
//$ss = "SELECT role_id,role_name FROM role WHERE role_id = '003'";
//$ee = $dbobject->db_query($ss);
//$c_type[] = array('id'=>$ee[0]['role_id'],'name'=>$ee[0]['role_name']);
if(isset($_REQUEST['op']) && $_REQUEST['op'] == 'edit')
{
    $operation  = 'edit';
    $code  = $_REQUEST['code'];
    $sql_splitting = "SELECT * FROM splitting WHERE code = '$code'";
    $splitting     = $dbobject->db_query($sql_splitting);
//    var_dump($splitting);
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
    <h4 class="modal-title" style="font-weight:bold">Split Setup</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Split.saveSplit">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
       <input type="hidden" name="code" value="<?php echo $code; ?>">
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                    <label class="form-label">Minimum Amount</label>
                    <input type="number" name="min_amt" class="form-control" value="<?php echo $splitting[0]['min_amt']; ?>" placeholder="" autocomplete="off">
                </div>
           </div>
              <div class="col-sm-6">
                <div class="form-group">
                <label for="">Maximum Amount</label>
                <div class="input-group">
                    <input type="number" id="max_amt" value="<?php echo $splitting[0]['max_amt']; ?>" name="max_amt" class="form-control" placeholder="" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input id="infinite" name="infinite" type="checkbox"><span style="font-weight:bold">&nbsp; &#8734;</span>
                        </div>
                    </div>
                </div>
                </div>
           </div>
       </div>
       <fieldset class="form-group">
          <legend>Splitting Formular (%)</legend>
            <?php
           $row_count = 0;
           if($operation == "new")
           {
                foreach($c_type as $row)
                {
                   if($row_count == 0)
                   {
                       echo '<div class="row">';
                   }
                    echo '<div class="col-sm-6">
                               <div class="form-group">
                                   <label class="form-label">'.$row['name'].'</label>
                                   <input type="number"  id="k'.$row['id'].'" name="church_type['.$row['id'].']" placeholder="" value="0" class="form-control variable" />
                                   
                               </div>
                           </div>';
                    if($row_count == 1)
                    {
                        echo '</div>';
                         $row_count = 0;
                    }else
                    {
                        $row_count++;
                    }
                }
           }else
           {
               foreach($splitting as $row)
                {
                   if($row_count == 0)
                   {
                       echo '<div class="row">';
                   }
                    echo '<div class="col-sm-6">
                               <div class="form-group">
                                   <label class="form-label">'.$dbobject->getitemlabel('church_type','id',$row['church_type'],'name').'</label>
                                   <input type="number"  id="k'.$row['church_type'].'" name="church_type['.$row['church_type'].']" placeholder="" value="'.$row['percentage'].'" class="form-control variable" />
                                   
                               </div>
                           </div>';
                    if($row_count == 1)
                    {
                        echo '</div>';
                         $row_count = 0;
                    }else
                    {
                        $row_count++;
                    }
                }
           }
           ?>
       </fieldset>
       <?php include("form-footer.php"); ?>
       <div id="err"></div>
        <button id="save_facility" onclick="saveRecord()" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    $("#infinite").click(function(){
        if($("#infinite").is(":checked"))
           {
                $("#max_amt").attr('type','text');
                $("#max_amt").attr('disabled',true);
                $("#max_amt").val('infinite amount');
           }else{
               $("#max_amt").attr('type','number');
               $("#max_amt").attr('disabled',false);
                $("#max_amt").val('');
           }
    })
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
                    getpage('splitting_list.php','page');
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
    
            
  
</script>