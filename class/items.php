<?php
// DEPRECATED: Use class/inventory.php for all item and inventory management.

error_reporting(E_ALL);
ini_set('display_errors', 1);

class items extends dbobject
{
    // List all items
    public function itemsList($data)
    {
        $table_name = "item";
        $primary_key = "item_id";
        $columner = array(
            array('db' => 'item_id', 'dt' => 0),
            array('db' => 'item.item_code', 'dt' => 1),
            array('db' => 'item.item_name', 'dt' => 2),
            array('db' => 'd.item_cat_name', 'dt' => 3),
            array('db' => 'item_condition', 'dt' => 4),
            array('db' => 'color', 'dt' => 5),
            array('db' => 'quantity', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'purchase_date', 'dt' => 8),
            array('db' => 'warranty', 'dt' => 9),
            array('db' => 'location', 'dt' => 10),
            array('db' => 'item.created_at', 'dt' => 11),
            array(
                'db' => 'item_id',
                'dt' => 12,
                'formatter' => function($d, $row) {
                    
                    return
                    '<div class="d-flex gap-1"> <button class="btn btn-sm btn-outline-primary me-1"
                            onclick="editItem('.$d.')">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('.$d.')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                            </div>';
                }
            )
        );
        
        $join = [
            ["item_category d" => ["item.category_id", "d.item_cat_id"]]
        ];

        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = "AND item.merchant_id = '$merchant_id'";
        $join_type = 'LEFT JOIN';
        $engine = new engine();
        return $engine->generic_multi_table(
            $data,
            $table_name,
            $columner,
            $primary_key,
            $join,
            $filter,
            $join_type
        );
    }

    // Generate unique item code
    private function generateItemCode($merchantId) {
        $prefix = "ITM";
        do {
            $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNumber;
            $checkCode = $this->db_query("SELECT item_id FROM item WHERE item_code = '$code' AND merchant_id = '$merchantId'", true);
        } while ($checkCode && count($checkCode) > 0);
        return $code;
    }

    // Create or edit item
    public function createItem($data)
    {
        try {
            if (empty($data['merchant_id'])) {
                return json_encode(array("response_code" => 20, "response_message" => "Merchant ID is required"));
            }
            
            // Validate required fields
            $validation = $this->validate($data,
                array(
                    'item_name' => 'required',
                    'category_id' => 'required',
                    'item_condition' => 'required',
                    'quantity' => 'required',
                    'status' => 'required'
                ),
                array(
                    'item_name' => 'Item Name',
                    'category_id' => 'Category',
                    'item_condition' => 'Condition',
                    'quantity' => 'Quantity',
                    'status' => 'Status'
                )
            );
            
            if(!$validation['error'])
            {
                if($data['operation'] == 'new')
                {
                    $data['item_code'] = $this->generateItemCode($data['merchant_id']);
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $data['created_officer'] = $_SESSION['username_sess'] ?? 'system';
                    
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doInsert('item', $data, $excluded_keys);
                    
                    if($res == "1" || $res === true)
                    {
                        return json_encode(array(
                            "response_code" => 0,
                            "response_message" => "Item created successfully with code: " . $data['item_code']
                        ));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 78, "response_message" => "Failed to create item"));
                    }
                }
                elseif($data['operation'] == 'edit')
                {
                    if (empty($data['item_id'])) {
                        return json_encode(array("response_code" => 20, "response_message" => "Item ID is required for edit operation"));
                    }
                    
                    $data['updated_at'] = date("Y-m-d H:i:s");
                    $data['updated_officer'] = $_SESSION['username_sess'] ?? 'system';
                    $merchant_id = $data['merchant_id'];
                    $item_id = $data['item_id'];
                    
                    // Verify item exists and belongs to merchant
                    $check_sql = "SELECT item_id FROM item WHERE item_id = '$item_id' AND merchant_id = '$merchant_id'";
                    $check_result = $this->db_query($check_sql, true);
                    
                    if (!$check_result || count($check_result) == 0) {
                        return json_encode(array("response_code" => 404, "response_message" => "Item not found or access denied"));
                    }
                    
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doUpdate('item', $data, $excluded_keys, ['item_id' => $item_id, 'merchant_id' => $merchant_id]);
                    
                    if($res == "1" || $res === true)
                    {
                        return json_encode(array("response_code" => 0, "response_message" => "Item updated successfully"));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 79, "response_message" => "Failed to update item"));
                    }
                }
                else
                {
                    return json_encode(array("response_code" => 20, "response_message" => "Invalid operation"));
                }
            }
            else
            {
                return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
            }
        }
        catch(Exception $e)
        {
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred: " . $e->getMessage()));
        }
    }

    // Get item details
    public function getItem($data)
    {
        try {
            $item_id = $data['item_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            
            if (empty($item_id)) {
                return json_encode(array("response_code" => 20, "response_message" => "Item ID is required"));
            }
            
            $sql = "SELECT * FROM item WHERE item_id='$item_id' AND merchant_id='$merchant_id' LIMIT 1";
            $item = $this->db_query($sql, true);
            
            if($item && count($item) > 0) {
                return json_encode(array("response_code" => 0, "data" => $item[0]));
            } else {
                return json_encode(array("response_code" => 404, "response_message" => "Item not found"));
            }
        }
        catch(Exception $e)
        {
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching item"));
        }
    }

    // Delete item
    public function deleteItem($data)
    {
        try {
            $item_id = $data['item_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            
            if (empty($item_id)) {
                return json_encode(array("response_code" => 20, "response_message" => "Item ID is required"));
            }
            
            // Check if item exists and belongs to merchant
            $check_sql = "SELECT item_id FROM item WHERE item_id = '$item_id' AND merchant_id = '$merchant_id'";
            $check_result = $this->db_query($check_sql, true);
            
            if (!$check_result || count($check_result) == 0) {
                return json_encode(array("response_code" => 404, "response_message" => "Item not found or access denied"));
            }
            
            $sql = "DELETE FROM item WHERE item_id = '$item_id' AND merchant_id = '$merchant_id'";
            $result = $this->db_query($sql, false);
            
            if($result) {
                return json_encode(array("response_code" => 0, "response_message" => "Item deleted successfully"));
            } else {
                return json_encode(array("response_code" => 80, "response_message" => "Failed to delete item"));
            }
        }
        catch(Exception $e)
        {
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
}