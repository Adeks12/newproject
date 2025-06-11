<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);   

class inventory extends dbobject
{
    public function inventoryList($data)
    {
        $primary_key = "i.item_id";
        $columner = array(
            array('db' => 'i.item_id', 'dt' => 0),
            array('db' => 'i.item_code', 'dt' => 1),
            array('db' => 'i.item_cond', 'dt' => 2),
            array('db' => 'i.item_color', 'dt' => 3),
            array('db' => 'ic.item_cat_name', 'dt' => 4),
            array('db' => 'i.allocation_status', 'dt' => 5, 'formatter' => function($d, $row) {
                $status_colors = [
                    'Available' => 'success',
                    'Allocated' => 'primary',
                    'Reserved' => 'warning'
                ];
                $color = $status_colors[$d] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . $d . '</span>';
            }),
            array('db' => 'i.usage_status', 'dt' => 6, 'formatter' => function($d, $row) {
                $status_colors = [
                    'Active' => 'success',
                    'Inactive' => 'secondary',
                    'Maintenance' => 'warning',
                    'Retired' => 'danger'
                ];
                $color = $status_colors[$d] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . $d . '</span>';
            }),
            // Use the alias 'officer_name' for the concatenated staff name
            array('db' => 'officer_name', 'dt' => 7, 'formatter' => function($d, $row) {
                return (isset($d) && trim((string)$d)) ? trim($d) : '-';
            }),
            array('db' => 'i.allocated_date', 'dt' => 8, 'formatter' => function($d, $row) {
                return $d ? date('Y-m-d', strtotime($d)) : '-';
            }),
            array('db' => 'i.created_at', 'dt' => 9, 'formatter' => function($d, $row) {
                return date('Y-m-d H:i', strtotime($d));
            }),
            array('db' => 'i.item_id', 'dt' => 10, 'formatter' => function($d, $row) {
                return '<div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary" onclick="editInventory('.$d.')">Edit</button>
                            <button class="btn btn-sm btn-success" onclick="allocateInventory('.$d.')">Allocate</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteInventory('.$d.')">Delete</button>
                        </div>';
            })
        );

        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = " AND i.merchant_id = '$merchant_id' AND i.delete_status != '1'";

        if (isset($data['item_cat_id']) && $data['item_cat_id'] !== '' && $data['item_cat_id'] !== 'all') {
            $cat_id = intval($data['item_cat_id']);
            $filter .= " AND i.item_cat_id = '$cat_id'";
        }

        // Use alias officer_name for the concatenated staff name
        $select = "i.item_id, i.item_code, i.item_cond, i.item_color, ic.item_cat_name, i.allocation_status, i.usage_status, CONCAT(COALESCE(s.staff_first_name, ''), ' ', COALESCE(s.staff_last_name, '')) as officer_name, i.allocated_date, i.created_at";
        $from = "inventory i LEFT JOIN item_category ic ON i.item_cat_id = ic.item_cat_id LEFT JOIN staff s ON i.allocated_officer = s.staff_id WHERE 1=1 $filter";

        $group_by = "";

        $engine = new engine();
        return $engine->generic_select_report_table(
            $data,
            $select,
            $from,
            $columner,
            $primary_key,
            $group_by
        );
    }

    private function generateItemCode($merchantId) {
        $prefix = "ITM";
        do {
            $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNumber;
            $checkCode = $this->db_query("SELECT item_id FROM inventory WHERE item_code = '$code' AND merchant_id = '$merchantId'", true);
        } while ($checkCode && count($checkCode) > 0);
        return $code;
    }

    public function createInventory($data)
    {
        try {
            // Validate merchant_id is present
            if (empty($data['merchant_id'])) {
                return json_encode(array("response_code" => 20, "response_message" => "Merchant ID is required"));
            }

            // Add timestamps and audit fields
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_officer'] = $_SESSION['username_sess'] ?? 'system';
            $data['delete_status'] = '0'; // Not deleted

            // Auto-generate item code for new items
            if($data['operation'] == 'new') {
                $data['item_code'] = $this->generateItemCode($data['merchant_id']);
            }

            // Set allocation date and by if item is being allocated
            if($data['allocation_status'] == 'Allocated' && $data['operation'] == 'new') {
                $data['allocated_date'] = date("Y-m-d H:i:s");
                $data['allocated_by'] = $_SESSION['username_sess'] ?? 'system';
            }

            // Validation rules
            $validation = $this->validate($data,
                array(
                    'item_cond' => 'required',
                    'item_cat_id' => 'required',
                    'allocation_status' => 'required',
                    'usage_status' => 'required'
                ),
                array(
                    'item_cond' => 'Item Condition',
                    'item_cat_id' => 'Item Category',
                    'allocation_status' => 'Allocation Status',
                    'usage_status' => 'Usage Status'
                )
            );

            // Additional validation for allocated items
            if($data['allocation_status'] == 'Allocated' && empty($data['allocated_officer'])) {
                return json_encode(array("response_code" => 20, "response_message" => "Allocated officer is required when allocation status is 'Allocated'"));
            }

            if(!$validation['error'])
            {
                if($data['operation'] == 'new')
                {
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doInsert('inventory', $data, $excluded_keys);

                    if($res == "1" || $res === true)
                    {
                        return json_encode(array(
                            "response_code" => 0,
                            "response_message" => "Inventory item created successfully with code: " . $data['item_code']
                        ));
                    }
                    else
                    {
                        error_log("Insert failed with result: " . print_r($res, true));
                        return json_encode(array("response_code" => 78, "response_message" => "Failed to create inventory item"));
                    }
                }
                elseif($data['operation'] == 'edit')
                {
                    // Check if item exists and belongs to merchant
                    $current_item = $this->db_query("SELECT allocation_status FROM inventory WHERE item_id = '{$data['item_id']}' AND merchant_id = '{$data['merchant_id']}'", true);
                    
                    if (!$current_item || empty($current_item)) {
                        return json_encode(array("response_code" => 404, "response_message" => "Inventory item not found"));
                    }

                    // Set allocation date and by if status changed to allocated
                    if($current_item[0]['allocation_status'] != 'Allocated' && $data['allocation_status'] == 'Allocated') {
                        $data['allocated_date'] = date("Y-m-d H:i:s");
                        $data['allocated_by'] = $_SESSION['username_sess'] ?? 'system';
                    }

                    $data['updated_at'] = date("Y-m-d H:i:s");
                    $data['updated_officer'] = $_SESSION['username_sess'] ?? 'system';
                    $merchant_id = $data['merchant_id'];
                    $item_id = $data['item_id'];
                   
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doUpdate('inventory', $data, $excluded_keys, ['item_id' => $item_id, 'merchant_id' => $merchant_id]);                   
                                      
                    if($res == "1" || $res === true)
                    {
                        return json_encode(array("response_code" => 0, "response_message" => "Inventory item updated successfully"));
                    }
                    else
                    {
                        error_log("Update failed with result: " . print_r($res, true));
                        return json_encode(array("response_code" => 79, "response_message" => "Failed to update inventory item"));
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
            error_log("Inventory Creation Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred: " . $e->getMessage()));
        }
    }
    
    public function getInventory($data)
    {
        try {
            $item_id = $data['item_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $sql = "SELECT i.*, ic.item_cat_name 
                    FROM inventory i 
                    LEFT JOIN item_category ic ON i.item_cat_id = ic.item_cat_id 
                    WHERE i.item_id='$item_id' AND i.merchant_id='$merchant_id' AND i.delete_status != '1' 
                    LIMIT 1";

            $item = $this->db_query($sql, true);
            
            if($item && count($item) > 0) {
                return json_encode(array("response_code" => 0, "data" => $item[0]));
            } else {
                return json_encode(array("response_code" => 404, "response_message" => "Inventory item not found"));
            }
        }
        catch(Exception $e)
        {
            error_log("Get Inventory Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching inventory item"));
        }
    }
    
    public function deleteInventory($data)
    {
        try {
            $item_id = $data['item_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];

            // Soft delete - set delete_status to 1
            $sql = "UPDATE inventory SET delete_status = '1', deleted_at = NOW(), deleted_by = '{$_SESSION['username_sess']}' 
                    WHERE item_id = '$item_id' AND merchant_id = '$merchant_id'";
            $result = $this->db_query($sql, false);

            if($result) {
                return json_encode(array("response_code" => 0, "response_message" => "Inventory item deleted successfully"));
            } else {
                return json_encode(array("response_code" => 80, "response_message" => "Failed to delete inventory item"));
            }
        }
        catch(Exception $e)
        {
            error_log("Delete Inventory Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }

    public function allocateInventory($data)
    {
        try {
            $item_id = $data['item_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $allocated_officer = $data['allocated_officer'];
            $allocated_by = $_SESSION['username_sess'];
            $allocated_date = $data['allocated_date'];

            if(empty($item_id) || empty($allocated_officer) || empty($allocated_by) || empty($allocated_date)) {
                return json_encode(array("response_code" => 20, "response_message" => "All fields are required"));
            }

            $sql = "UPDATE inventory SET allocation_status='Allocated', allocated_officer='$allocated_officer', allocated_by='$allocated_by', allocated_date='$allocated_date' WHERE item_id='$item_id' AND merchant_id='$merchant_id'";
            $result = $this->db_query($sql, false);

            if($result) {
                return json_encode(array("response_code" => 0, "response_message" => "Inventory item allocated successfully"));
            } else {
                return json_encode(array("response_code" => 80, "response_message" => "Failed to allocate inventory item"));
            }
        } catch(Exception $e) {
            error_log("Allocate Inventory Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
}