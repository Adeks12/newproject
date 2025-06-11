<?php
class engine extends dbobject
{
    public $id    = "";
    public $draw   = "";
    public $start  = "";
    public $length = "";
    public $search = "";
    public $order  = "";
    public $dirs    = "";
    public $head   = "";
    public $column   = "";
    
	public function generic_table($data,$table_name,$columner, $pk, $filter = "")
    {
		$table_name    = $table_name;
        $this->draw    = $data['draw'];
        $this->start   = $data['start'];
        $this->length  = $data['length'];
        $this->search  = $data['search']['value'];
        $this->order   = $data['order'][0]['column'];
        $this->dirs    = $data['order'][0]['dir'];
        $this->column  = $data['columns'];
        $start_date    = isset($data['start_date']) ? $data['start_date'] : "";
        $end_date      = isset($data['end_date']) ? $data['end_date'] : "";
		
		$columner     = $columner;
        $fields       = $this->prepare_column($columner);
		
          $sql = "SELECT $fields FROM $table_name WHERE ".$this->prepareSearch($columner,$this->search).$this->date_filter($start_date,$end_date).$filter." order by ".$columner[$this->order]['db']." ".$this->dirs."  LIMIT ".$this->start.", ".$this->length;
		// if($_SESSION['nnpc_username_sess'] == "hr@mail.com")
		// {
			file_put_contents('g_query.txt',$sql);
		// }
		
		$result   = $this->db_query($sql);
		
		$sql_without_limit = "SELECT COUNT({$columner[0]['db']}) AS counter FROM $table_name WHERE ".$this->prepareSearch($columner,$this->search).$this->date_filter($start_date,$end_date).$filter." order by ".$columner[$this->order]['db']." ".$this->dirs;
        file_put_contents('g_query2.txt',$sql_without_limit);
        
		
		$output = $this->display_data($result,$columner,$sql_without_limit,$pk,$this->start);
        
        return json_encode($output);
    }
	
	public function generic_multi_table($data,$table_name,$columner,$pk,$join_arr,$filter = "",$join_type = "JOIN")
	{
	$table_name = $table_name;
	$this->draw = $data['draw'];
	$this->start = $data['start'];
	$this->length = $data['length'];
	$this->search = $data['search']['value'];
	$this->order = $data['order'][0]['column'];
	$this->dirs = $data['order'][0]['dir'];
	$this->column = $data['columns'];
	$start_date = isset($data['start_date']) ? $data['start_date'] : "";
	$end_date = isset($data['end_date']) ? $data['end_date'] : "";

	$join = $this->joinTables($join_arr);
	$columner = $columner;
	$fields = $this->prepare_column($columner);

	// Main query with data
	$sql = "SELECT $fields FROM $table_name $join_type ".$join." WHERE
	".$this->prepareSearch($columner,$this->search).$this->date_filter($start_date,$end_date).$filter." ORDER BY ".$pk."
	".$this->dirs." LIMIT ".$this->start.", ".$this->length;
	file_put_contents('bounty.txt',$sql);
	$result = $this->db_query($sql);

	// Count query - this is the corrected version
	$sql_without_limit = "SELECT COUNT($pk) AS counter FROM $table_name $join_type ".$join." WHERE
	".$this->prepareSearch($columner,$this->search).$this->date_filter($start_date,$end_date).$filter;

	$output = $this->display_data($result,$columner,$sql_without_limit,$pk,$this->start);

	return json_encode($output);
	}
	
	
	public function joinTables($arr)
	{
		$cnt = 0;
		$str = "";
		foreach($arr as $rw)
		{
			if($cnt > 0)
			{
				$str =  rtrim($str,"=");
				$str .= " JOIN ";
			}
			foreach($rw as $key => $val)
			{
				 $str .= $key." ON ";
				foreach($val as $k)
				{
					$str .= $k."=";
				}
			}
			$cnt++;
		}
		
		$str =  rtrim($str,"=");
		return $str;
	}
	
	public function display_data($result,$columner,$sql_without_limit,$pk,$start)
	{
	// Fix the count query to actually count records
	$count_sql = str_replace("SELECT {$pk} FROM", "SELECT COUNT({$pk}) AS counter FROM", $sql_without_limit);
	$pagination = $this->db_query($count_sql, true);
	$pagination = isset($pagination[0]['counter']) ? $pagination[0]['counter'] : 0;

	$big_data = array("draw"=>$this->draw,"recordsFiltered"=>$pagination,"recordsTotal"=>$pagination);

	if(count($result) > 0)
	{
	$rw = array();
	$serial_no = $start;
	foreach($result as $row)
	{
	$serial_no++;
	$cnt = 0;
	$temp_row = array(); // Use temporary array to build each row

	foreach($columner as $inner_rw)
	{
	if(isset($columner[$cnt]['db']))
	{
	$ed = explode(".",$columner[$cnt]['db']);
	$ii = (count($ed) == 2)?1:0;
	$data = $row[$ed[$ii]];
	$index = $columner[$cnt]['dt'];
	}

	// Get primary key value for ID generation
	$pk_parts = explode(".", $pk);
	$pk_column = (count($pk_parts) == 2) ? $pk_parts[1] : $pk;
	$id = $columner[$cnt]['db']."-".$row[$pk_column];

	if($cnt == 0)
	{
	$data = $serial_no;
	}
	else
	{
	// using the callback function :: formatter
	$data = (isset($columner[$cnt]['formatter']))?$columner[$cnt]['formatter']($data,$row):$data;

	$data = (isset($columner[$cnt]['edit']))?$this->doHtml($data,$columner[$cnt],$id,$row):$data;
	}

	$temp_row[$index] = $data;
	$cnt++;
	}
	$big_data['data'][] = array_values($temp_row); // Convert to indexed array
	}
	}else
	{
	$big_data['data'] = array();
	}
	return $big_data;
	}
	public function doHtml($data,$column_data,$id,$row)
	{
		$type = $column_data['edit'];
		$r    = "<div><span>{$data}</span>";
		if($type == 'text' || $type == 'date' || $type == 'tel' || $type == 'number' || $type == 'email')
		{
			$r .= "<input type='hidden' name='{$column_data['db']}' value='{$id}'  />
			<input style='display:none; border:1px solid red' autocomplete='off' type='{$type}' name='{$column_data['db']}'  />";
		}
		elseif($type == 'select')
		{
			$r .= "<input type='hidden' name='{$column_data['db']}' value='{$id}'  />
			<select class='form-control' name='{$column_data['db']}'  style='display:none; border:1px solid red' >
			{$column_data['options']($row)} 
			</select>";
		}
		
		$r .= "</div>";
		return $r;
	}
	
	public function prepare_column($col)
	{
		$coll = "";
		foreach($col as $rr)
		{
			$coll .= $rr['db'].",";
		}
		return substr($coll,0,-1);
	}
	
	public function date_filter($start,$end,$column = "created")
	{
		$date = "";
		if($start != "" && $end != "")
		{
			$date = " and ($column between '$start 00:00' and '$end 23:59')";
		}
		return $date;
	}
	public function prepareSearch($array_search,$search)
    {
        $len = count($array_search);
        $columns = "";
        if($search != "")
        {
            for($x=0; $x<$len; $x++)
            {
                $columns .= $array_search[$x]['db']." LIKE '%".$search."%'  OR ";
            }
        }
		
		for($x=0; $x<$len; $x++)
		{
			$search_value_array = isset($array_search[$x]['search']['value']) ? $array_search[$x]['search']['value'] : "";
			if($search_value_array != "")
			{
				$columns .= $array_search[$x]['name']." LIKE '%".$array_search[$x]['search']['value']."%' AND ";
			}
		}
		$columns = substr($columns,0,-4);
        
        
        return $columns == ""?" 1 = 1 ":"(".$columns.") AND 1 = 1 ";
//        return $columns == ""?" 1 = 1 ":$columns." AND 1 = 1 ";
    }

	public function generic_select_report_table($data, $select, $filter_with_table, $columner,$pk,$filter = "", $groupby_db = "")
    {
		
     	$this->draw    = isset( $data['draw']) ?   $data['draw']  : "";
        $this->start   =  isset($data['start']) ?  $data['start']  : "";
        $this->length  =  isset($data['length']) ?  $data['length']  : "";
        $this->search  = isset( $data['search']['value']) ? $data['search']['value']   : "";
        $this->order   =  isset($data['order'][0]['column']) ? $data['order'][0]['column']   : "";

        //SORT IN DESCENDING ORDER ON FIRST DRAW
        if($this->draw == 1) {
	        $this->dirs    = "desc";
	    }
	    else {
	        $this->dirs    = isset( $data['order'][0]['dir']) ?  $data['order'][0]['dir']  : "";
	    }
        $this->column  =  isset( $data['columns'] ) ? $data['columns']  : "";
        $start_date    =  isset($data['start_date']) ? $data['start_date']   : "";
        $end_date      =  isset($data['end_date']) ?  $data['end_date']  : "";
        $order_db            = isset($columner[$this->order]['db']) ? $columner[$this->order]['db'] : "";
		
		$columner     = $columner;
        $fields       = $this->prepare_column($columner);
		
        $sql = "SELECT $select FROM $filter_with_table  AND ".$this->prepareSearch($columner,$this->search). " " .$groupby_db ." order by ".$order_db." ".$this->dirs."  LIMIT ".$this->start.", ".$this->length;
		
		$result   = $this->db_query($sql);
		
		$sql_without_limit = "SELECT $pk FROM $filter_with_table AND ".$this->prepareSearch($columner,$this->search). " " .$groupby_db . " order by ".$order_db." ".$this->dirs;
 		
 		//logger
 		file_put_contents("logger/datatable_debug.php", "SQL:  $sql ::||:: WITHOUT LIMIT: $sql_without_limit" );
 		//
		//file_put_contents("logger/datatable_debug.php", json_encode($data) );

		$output = $this->display_data($result,$columner,$sql_without_limit,$pk,$this->start);
        
        return json_encode($output);
    }

    
    
    
    
}



