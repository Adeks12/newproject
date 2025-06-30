<?php
class allocation extends dbobject
{
    // Allocate item to staff
    public function allocateItem($data)
    {
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
        $item_id = $data['item_id'];
        $staff_id = $data['staff_id'];
        $quantity = (int)$data['quantity'];
        $allocated_date = $data['allocated_date'] ?? date('Y-m-d');
        $notes = $data['notes'] ?? '';
        $status = 'active';

        // Check available quantity
        $item = $this->db_query("SELECT quantity FROM inventory WHERE item_id='$item_id' AND merchant_id='$merchant_id' AND delete_status != '1'", true);
        if(!$item || $item[0]['quantity'] < $quantity) {
            return json_encode(["response_code"=>20, "response_message"=>"Not enough quantity available for allocation."]);
        }

        // Decrement available quantity
        $this->db_query("UPDATE inventory SET quantity = quantity - $quantity WHERE item_id='$item_id' AND merchant_id='$merchant_id'", false);

        // Create allocation record
        $insert = [
            'item_id' => $item_id,
            'staff_id' => $staff_id,
            'quantity' => $quantity,
            'allocated_date' => $allocated_date,
            'status' => $status,
            'notes' => $notes,
            'merchant_id' => $merchant_id
        ];
        $this->doInsert('item_allocation', $insert, []);

        return json_encode(["response_code"=>0, "response_message"=>"Item allocated successfully."]);
    }

    // Return item
    public function returnItem($data)
    {
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
        $allocation_id = $data['allocation_id'];
        $item_id = $data['item_id'];
        $quantity = (int)$data['quantity'];

        // Update allocation record
        $this->db_query("UPDATE item_allocation SET status='returned', returned_date=NOW() WHERE allocation_id='$allocation_id' AND merchant_id='$merchant_id'", false);
        // Increment available quantity
        $this->db_query("UPDATE inventory SET quantity = quantity + $quantity WHERE item_id='$item_id' AND merchant_id='$merchant_id'", false);

        return json_encode(["response_code"=>0, "response_message"=>"Item returned successfully."]);
    }
} 