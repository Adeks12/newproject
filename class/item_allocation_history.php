<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class item_allocation_history extends dbobject
{
    // List all allocation history for an item
    public function allocationHistoryList($data)
    {
        $item_id = intval($data['item_id']);
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $sql = "SELECT h.*, s.staff_first_name, s.staff_last_name, d.depmt_name FROM item_allocation_history h
                LEFT JOIN staff s ON h.staff_id = s.staff_id
                LEFT JOIN department d ON h.department_id = d.depmt_id
                WHERE h.item_id = '$item_id' AND (h.merchant_id = '$merchant_id' OR '$merchant_id' = '') ORDER BY h.allocated_date DESC";
        $rows = $this->db_query($sql, true);
        $html = '<table class="table table-bordered"><thead><tr><th>Staff</th><th>Department</th><th>Allocated Date</th><th>Returned Date</th><th>Status</th><th>Notes</th></tr></thead><tbody>';
        if($rows && count($rows) > 0) {
            foreach($rows as $row) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars(($row['staff_first_name'] ?? '') . ' ' . ($row['staff_last_name'] ?? '')) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['depmt_name'] ?? '-') . '</td>';
                $html .= '<td>' . htmlspecialchars($row['allocated_date']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['returned_date'] ?? '-') . '</td>';
                $html .= '<td>' . htmlspecialchars($row['status']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['notes'] ?? '-') . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="6">No allocation history found.</td></tr>';
        }
        $html .= '</tbody></table>';
        echo $html;
    }
} 