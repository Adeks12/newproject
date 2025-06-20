<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class items extends dbobject
{
    // List all items
    public function itemsList($data)
    {
        $primary_key = "item_id";
        $columner = array(
            array('db' => 'item_id', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'category_id', 'dt' => 3),
            array('db' => 'condition', 'dt' => 4),
            array('db' => 'color', 'dt' => 5),
            array('db' => 'quantity', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'purchase_date', 'dt' => 8),
            array('db' => 'warranty', 'dt' => 9),
            array('db' => 'location', 'dt' => 10),
            array('db' => 'created_at', 'dt' => 11),
            array('db' => 'item_id', 'dt' => 12, 'formatter' => function($d, $row) {
                return '<div class="d-flex gap-1">
                    <button class="btn btn-sm btn-outline-secondary" onclick="editItem('.$d.')"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('.$d.')"><i class="fas fa-trash-alt"></i></button>
                </div>';
            })
        );
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = " AND merchant_id = '$merchant_id'";
        $select = "item_id, item_code, item_name, category_id, `condition`, color, quantity, status, purchase_date, warranty, location, created_at";
        $from = "items WHERE 1=1 $filter";
        $engine = new engine();
        return $engine->generic_select_report_table(
            $data,
            $select,
            $from,
            $columner,
            $primary_key,
            ''
        );
    }

    // Generate unique item code
    private function generateItemCode($merchantId) {
        $prefix = "ITM";
        do {
            $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNumber;
            $checkCode = $this->db_query("SELECT item_id FROM items WHERE item_code = '$code' AND merchant_id = '$merchantId'", true);
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
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_officer'] = $_SESSION['username_sess'] ?? 'system';
            if($data['operation'] == 'new') {
                $data['item_code'] = $this->generateItemCode($data['merchant_id']);
            }
            $validation = $this->validate($data,
                array(
                    'item_name' => 'required',
                    'category_id' => 'required',
                    'condition' => 'required',
                    'quantity' => 'required',
                    'status' => 'required'
                ),
                array(
                    'item_name' => 'Item Name',
                    'category_id' => 'Category',
                    'condition' => 'Condition',
                    'quantity' => 'Quantity',
                    'status' => 'Status'
                )
            );
            if(!$validation['error'])
            {
                if($data['operation'] == 'new')
                {
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doInsert('items', $data, $excluded_keys);
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
                    $data['updated_at'] = date("Y-m-d H:i:s");
                    $data['updated_officer'] = $_SESSION['username_sess'] ?? 'system';
                    $merchant_id = $data['merchant_id'];
                    $item_id = $data['item_id'];
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doUpdate('items', $data, $excluded_keys, ['item_id' => $item_id, 'merchant_id' => $merchant_id]);
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
            $sql = "SELECT * FROM items WHERE item_id='$item_id' AND merchant_id='$merchant_id' LIMIT 1";
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
            $sql = "DELETE FROM items WHERE item_id = '$item_id' AND merchant_id = '$merchant_id'";
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