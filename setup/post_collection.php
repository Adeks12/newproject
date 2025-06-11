<?php
include_once("../libs/dbfunctions.php");
$dbobject = new dbobject();

$sql_collection_type = "SELECT id,name FROM collection_type order by collection_order";
$collection_type = $dbobject->db_query($sql_collection_type);

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
    myCalendar.setSensitiveRange(null, "<?php echo date('Y-m-d') ?>");
   myCalendar.hideTime();
}
</script>
<div class="modal-header">
    <h4 class="modal-title" style="font-weight:bold">Post Collection</h4>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body m-3 ">
    <form id="form1" onsubmit="return false" autocomplete="off">
       <input type="hidden" name="op" value="Collection.collectionPosting">
       <input type="hidden" name="operation" value="<?php echo $operation; ?>">
<!--       <input type="hidden" name="id" value="<?php //echo $id; ?>">-->
<!--
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                   <label class="form-label">Type of Collection</label>
                   <select name="collection_id" id="" class="form-control">
                      <option value="">:: SELECT COLLECTION ::</option>
                       <?php
//                        foreach($collection_type as $row)
//                        {
//                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
//                        }
                       ?>
                   </select>
               </div>
           </div>
           <div class="col-sm-6">
               <div class="form-group">
                   <label class="form-label">Amount Collected</label>
                   <input type="number" name="amount" class="form-control">
               </div>
           </div>
       </div>
-->
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                   <label class="form-label">Date of Collection</label>
                   <input type="text" id="start_date" name="date_of_collection" autocomplete="off" class="form-control">
               </div>
           </div>
           <div class="col-sm-6">
               <div class="form-group">
                   <label class="form-label">Total:</label>
                   <p style="margin-bottom:0"><span id="total_amt" style="font-size:38px; color:green; font-weight:bold">0</span></p>
                   <small id="amt_to_words"></small>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-sm-6">
               <div class="form-group">
                   <label class="form-label">Filter by Category</label>
                   <select id="" onchange="displayHtml(this.value)" class="form-control">
                       <option value="">:: ALL Categories ::</option>
                       <?php
                        $sql = "SELECT * FROM collection_category";
                        $result = $dbobject->db_query($sql);
                        foreach($result as $row)
                        {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                       ?>
                   </select>
               </div>
           </div>
        </div>
       <fieldset class="form-group">
          <legend>Collection Basket (&#x20A6;) <span id="spinner" style="display:none"><img src="img/loading2.gif" width="15px" height="15px" alt=""><small style="color:blue"> loading..</small></span></legend>
           <div id="display_content">
            <?php
                $row_count = 0;
                foreach($collection_type as $row)
                {
                   if($row_count == 0)
                   {
                       echo '<div class="row">';
                   }
                    echo '<div class="col-sm-4">
                               <div class="form-group">
                                   <label class="form-label">'.$row['name'].'</label>
                                   <input type="hidden"  id="k'.$row['id'].'" name="collection['.$row['id'].']" placeholder="" value="0" class="form-control variable" autocomplete="off" />
                                   <input type="text" autocomplete="off" onkeyup="convert_to_w(this)" id="z'.$row['id'].'"  placeholder="" value="" class="form-control" />
                                   <div style="font-size:12px" class="hh"></div>
                               </div>
                           </div>';
                    if($row_count == 2)
                    {
                        echo '</div>';
                         $row_count = 0;
                    }else
                    {
                        $row_count++;
                    }
                }
           ?>
            </div>
       </fieldset>
       <?php include("form-footer.php"); ?>
        <button style="margin-top:10px" id="save_facility" onclick="saveRecord()" class="btn btn-primary">Submit</button>
    </form>
</div>
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
<script src="node_modules/number-to-words/numberToWords.js"></script>
<script>
    
    function convert_to_w(el)
    {
        let g = el.value
        if(g == "")
            {
                g = 0;
            }
//        g = g.toString();
//        console.log(formatNumber(g));
//        console.log(g.replace(",", ""));
        $("#"+el.id ).val(formatNumber(g.replace(/,/g, "")));
        $("#"+el.id ).siblings( "div" ).text(toWords(g.replace(/,/g, "")));
        $("#"+el.id ).siblings( ".variable" ).val(g.replace(/,/g, ""));
//         console.log($('.variable'));
        totalAmount();
    }
    function formatNumber(num) 
    {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }
    function totalAmount()
    {
        total = 0;
        $.each($('.variable'),function(i,val){
            console.log(val.value)
            total = total + parseInt(val.value);
            
        })
        $("#total_amt").html("&#8358;"+formatNumber(total))
        $("#amt_to_words").text("("+toWords(total)+")");
    }
    function displayHtml(el)
    {
        $("#spinner").show();
        $.post("utilities.php?op=Collection.getCollectionTypeFormList&category_id="+el,{},function(re)
        {
            $("#spinner").hide();
            console.log(re);
            if(re.response_code == 0)
            {
                $("#display_content").html(re.data.html);
            }
            else
            {
                alert(re.response_message)
            }  
        },'json')
        
    }
    function saveRecord()
    {
        $("#save_facility").text("Loading......");
        var dd = $("#form1").serialize();
        console.log(dd);
        $.post("utilities.php",dd,function(re)
        {
            $("#save_facility").text("Save");
            console.log(re);
            if(re.response_code == 0)
            {
                alert(re.response_message)
                getpage('post_collections_list.php','page');
                setTimeout(()=>{
                    $('#defaultModalPrimary').modal('hide');
                },1000)
            }
            else
            {
                regenerateCORS();
                alert(re.response_message)
            }
                
        },'json')
    }
</script>