<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class item_maintenance extends dbobject
{
    // List all maintenance logs for an item
    public function maintenanceLogList($data)
    {
        $item_id = intval($data['item_id']);
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $sql = "SELECT * FROM item_maintenance_log WHERE item_id = '$item_id' AND (merchant_id = '$merchant_id' OR '$merchant_id' = '') ORDER BY reported_date DESC";
        $rows = $this->db_query($sql, true);
        $html = '<table class="table table-bordered"><thead><tr><th>Reported By</th><th>Reported Date</th><th>Issue</th><th>Repair Date</th><th>Cost</th><th>Status</th><th>Notes</th></tr></thead><tbody>';
        if($rows && count($rows) > 0) {
            foreach($rows as $row) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($row['reported_by']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['reported_date']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['issue_description']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['repair_date'] ?? '-') . '</td>';
                $html .= '<td>' . htmlspecialchars($row['repair_cost'] ?? '-') . '</td>';
                $html .= '<td>' . htmlspecialchars($row['maintenance_status']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['notes'] ?? '-') . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="7">No maintenance log found.</td></tr>';
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    // Add a maintenance log
    public function addMaintenanceLog($data)
    {
        $fields = [
            'item_id', 'reported_by', 'reported_date', 'issue_description', 'repair_date', 'repair_cost', 'maintenance_status', 'notes'
        ];
        $insert = [];
        foreach ($fields as $field) {
            $insert[$field] = $data[$field] ?? null;
        }
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['merchant_id'] = $_SESSION['merchant_id'] ?? $data['merchant_id'];
        $res = $this->doInsert('item_maintenance_log', $insert, []);
        if($res == "1" || $res === true) {
            return json_encode(["response_code" => 0, "response_message" => "Maintenance log created successfully"]);
        } else {
            return json_encode(["response_code" => 80, "response_message" => "Failed to create maintenance log"]);
        }
    }
} 