<?php

class Transaction extends dbobject
{
   public function transactionList($data)
    {
		$table_name    = "transaction_table";
		$primary_key   = "transaction_id";
		$columner = array(
			array( 'db' => 'transaction_id', 'dt' => 0 ),
			array( 'db' => 'source_acct', 'dt' => 1,'formatter'=>function($d,$row)
              {
                  return $this->getitemlabel('church_table','church_id',$d,'church_name');
              }),
			array( 'db' => 'church_id',  'dt' => 2 ,'formatter'=>function($d,$row)
              {
                  return $this->getitemlabel('church_table','church_id',$d,'church_name');
              }),
			array( 'db' => 'church_type',   'dt' => 3,'formatter'=>function($d,$row)
                  {
                      return $this->getitemlabel('church_type','id',$d,'name');
                  }),
			array( 'db' => 'destination_acct',   'dt' => 4 ),
			array( 'db' => 'destination_bank',   'dt' =>5,'formatter'=>function($d,$row){
                return $this->getitemlabel('banks','bank_code',$d,'bank_name');
            } ),
			array( 'db' => 'account_name',   'dt' => 6 ),
			array( 'db' => 'transaction_amount',   'dt' => 7,'formatter'=>function($d,$row){
                return "&#8358; ".$d;
            } ),
			array( 'db' => 'payment_id',   'dt' => 8 ),
			array( 'db' => 'transaction_desc',   'dt' => 9 ),
            array( 'db' => 'response_code',  'dt' => 10),
            array( 'db' => 'response_message',  'dt' => 11 ),
            array( 'db' => 'percentage',     'dt' => 12, 'formatter' => function( $d,$row ) {
						return $d."%";
					}
				),
            array( 'db' => 'payment_id',     'dt' => 13, 'formatter' => function( $d,$row ) {
                       
                $split_dist = "<button class='btn btn-secondary' onclick=\"loadModal('view_split_distribution.php?payment_id=$d&viewer=general&church_id=$row[source_acct]','modal_div')\" href='javascript:void(0)' data-toggle='modal' data-target='#defaultModalPrimary'>View Remittance</button>";
						return $split_dist;
					}
				),
            array( 'db' => 'created',  'dt' => 14 )
			);
		$filter = "";
       $payment_filter = "";
       if($data['payment'] != "")
       {
           if($data['filter'] == "branch")
           {
               if($data['churches'] != '')
               {
                   $ff = ($data['payment'] == "paid")?" AND source_acct = '$data[churches]' ":" AND church_id = '$data[churches]' ";
                    $payment_filter = $payment_filter.$ff;
               }
           }
           else
           {
               if($data['region'] != '')
               {
                   $ff = ($data['payment'] == "paid")?" AND paying_church_type = '$data[region]' ":" AND receiving_church_type = '$data[region]' ";
                   $payment_filter = $payment_filter.$ff;
               }
           }
           
           if($data['state'] != '')
           {
               $ff = ($data['payment'] == "paid")?" AND paying_state_id = '$data[state]' ":" AND receiving_state_id = '$data[state]' ";
               $payment_filter = $payment_filter.$ff;
           }
           
       }else
       {
           if($data['filter'] == "branch")
           {
               if($data['churches'] != '')
               {
                   $ff = " AND (source_acct = '$data[churches]' OR church_id = '$data[churches]') ";
                    $payment_filter = $payment_filter.$ff;
               }
           }else
           {
               if($data['region'] != '')
               {
                   $ff = " AND (paying_church_type = '$data[region]' OR receiving_church_type = '$data[region]') ";
                   $payment_filter = $payment_filter.$ff;
               }
           }
           if($data['state'] != '')
           {
               $ff = " AND (paying_state_id = '$data[state]' OR receiving_state_id = '$data[state]') ";
               $payment_filter = $payment_filter.$ff;
           }
       }
       $filter = $filter.$payment_filter;
		$datatableEngine = new engine();
	
		echo $datatableEngine->generic_table($data,$table_name,$columner,$filter,$primary_key);
    }
    
}