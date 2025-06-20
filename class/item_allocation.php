<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class item_allocation extends dbobject
{
    // List all allocations
    public function allocationList($data)
    {
        $primary_key = "allocation_id";
        $columner = array(
            array('db' => 'allocation_id', 'dt' => 0),
            array('db' => 'item_id', 'dt' => 1),
            array('db' => 'staff_id', 'dt' => 2),
            array('db' => 'allocated_date', 'dt' => 3),
            array('db' => 'status', 'dt' => 4),
            array('db' => 'notes', 'dt' => 5),
            array('db' => 'allocation_id', 'dt' => 6, 'formatter' => function($d, $row) {
                $btns = '<div class="d-flex gap-1">';
                if ($row['status'] === 'active') {
                    $btns .= '<button class="btn btn-sm btn-outline-success" onclick="returnItem('.$d.')">Return</button>';
                }
                $btns .= '</div>';
                return $btns;
            })
        );
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = " AND merchant_id = '$merchant_id'";
        $select = "allocation_id, item_id, staff_id, allocated_date, status, notes";
        $from = "item_allocation WHERE 1=1 $filter";
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

    // Allocate item to staff
    public function allocateItem($data)
    {
        try {
            $data['allocated_date'] = date("Y-m-d H:i:s");
            $data['status'] = 'active';
            $data['merchant_id'] = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
            $res = $this->doInsert('item_allocation', $data, $excluded_keys);
            if($res == "1" || $res === true) {
                // Update item availability
                $this->doUpdate('items', ['status' => 'Allocated'], [], ['item_id' => $data['item_id']]);
                return json_encode(["response_code" => 0, "response_message" => "Item allocated successfully"]);
            } else {
                return json_encode(["response_code" => 80, "response_message" => "Failed to allocate item"]);
            }
        } catch(Exception $e) {
            return json_encode(["response_code" => 500, "response_message" => $e->getMessage()]);
        }
    }

    // Return item
    public function returnItem($data)
    {
        try {
            $allocation_id = $data['allocation_id'];
            $item_id = $data['item_id'];
            $this->doUpdate('item_allocation', ['status' => 'returned'], [], ['allocation_id' => $allocation_id]);
            // Update item availability
            $this->doUpdate('items', ['status' => 'Available'], [], ['item_id' => $item_id]);
            return json_encode(["response_code" => 0, "response_message" => "Item returned successfully"]);
        } catch(Exception $e) {
            return json_encode(["response_code" => 500, "response_message" => $e->getMessage()]);
        }
    }

    // View allocations per item
    public function allocationsByItem($data)
    {
        $item_id = $data['item_id'];
        $sql = "SELECT * FROM item_allocation WHERE item_id = '$item_id' ORDER BY allocated_date DESC";
        $rows = $this->db_query($sql, true);
        return json_encode(["response_code" => 0, "data" => $rows]);
    }

    // View allocations per staff
    public function allocationsByStaff($data)
    {
        $staff_id = $data['staff_id'];
        $sql = "SELECT * FROM item_allocation WHERE staff_id = '$staff_id' ORDER BY allocated_date DESC";
        $rows = $this->db_query($sql, true);
        return json_encode(["response_code" => 0, "data" => $rows]);
    }

    // View allocations per department (if department_id is in staff table)
    public function allocationsByDepartment($data)
    {
        $department_id = $data['department_id'];
        $sql = "SELECT ia.* FROM item_allocation ia JOIN staff s ON ia.staff_id = s.staff_id WHERE s.department_id = '$department_id' ORDER BY ia.allocated_date DESC";
        $rows = $this->db_query($sql, true);
        return json_encode(["response_code" => 0, "data" => $rows]);
    }
} 