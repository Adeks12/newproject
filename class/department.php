<?php
// include_once("dbobject.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);   

class Department extends dbobject
{
    public function departmentList($data)
    {
        $table_name    = "department";
        $primary_key   = "department.depmt_id";
        $columner = array(
            array( 'db' => 'department.depmt_id', 'dt' => 0 ),
            array( 'db' => 'department.depmt_name', 'dt' => 1 ),
            array( 'db' => 'depmt_code', 'dt' => 2 ),
            array(
                'db' => 'd.staff_first_name',
                'dt' => 3,
                'formatter' => function($d, $row) {
                    $firstname = $this->getitemlabel('staff', 'staff_id', $row['depmt_head'], 'staff_first_name');
                    $lastname = $this->getitemlabel('staff', 'staff_id', $row['depmt_head'], 'staff_last_name');
                    return $firstname." " . $lastname;
                }
            ),
            array(
                'db' => 'depmt_status',
                'dt' => 4,
                'formatter' => function( $d, $row ) {
                    return $d == '1' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                }
            ),
            array( 'db' => 'department.created_at', 'dt' => 5 ),
            array(
                'db' => 'department.depmt_id',
                'dt' => 6,
                'formatter' => function( $d, $row ) {
                    return '<div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-secondary" onclick="editDepartment('.$d.')"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDepartment('.$d.')"><i class="fas fa-trash-alt"></i></button>
                    </div>';
                }
            ),
            array('db' => 'department.depmt_head'),
        );

        $join = [
            ["staff d" => ["department.depmt_head", "d.staff_id"]]
        ];

        $join_type = "LEFT JOIN";
        
        // Filter by merchant_id for security
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = " AND department.merchant_id = '$merchant_id'";

        $datatableEngine = new engine();
        echo $datatableEngine->generic_multi_table($data, $table_name, $columner, $primary_key, $join, $filter,
        $join_type);
    }

    private function generateDepartmentCode($departmentName, $merchantId) {
        // Get first 3 letters of department name, convert to uppercase
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $departmentName), 0, 3));
        
        // If department name has less than 3 letters, pad with 'X'
        $prefix = str_pad($prefix, 3, 'X');
        
        // Generate unique code
        do {
            $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNumber;
            
            // Check if this code already exists for this merchant
            $checkCode = $this->db_query("SELECT depmt_id FROM department WHERE depmt_code = '$code' AND merchant_id = '$merchantId'", true);
        } while ($checkCode && count($checkCode) > 0);
        
        return $code;
    }

    public function createDepartment($data)
    {
        try {
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_officer'] = $_SESSION['username_sess'];
            
            // Auto-generate department code
            if($data['operation'] == 'new') {
                $data['depmt_code'] = $this->generateDepartmentCode($data['depmt_name'], $data['merchant_id']);
            }
            
            // Validation rules - removed depmt_code from required fields
            $validation = $this->validate($data,
                array(
                    'depmt_name' => 'required',
                    'depmt_head' => 'required',
                    'depmt_status' => 'required'
                ),
                array(
                    'depmt_name' => 'Department Name',
                    'depmt_head' => 'Department Head', 
                    'depmt_status' => 'Department Status'
                )
            );
            
            if(!$validation['error'])
            {
                if($data['operation'] == 'new')
                {
                    // Check for duplicate department name within same merchant
                    $checkName = $this->db_query("SELECT depmt_id FROM department WHERE depmt_name = '{$data['depmt_name']}' AND merchant_id = '{$data['merchant_id']}'", true);
                    if($checkName && count($checkName) > 0) {
                        return json_encode(array("response_code" => 22, "response_message" => "Department name already exists"));
                    }
                    
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doInsert('department', $data, $excluded_keys);
                    
                    if($res == "1")
                    {
                        return json_encode(array(
                            "response_code" => 0, 
                            "response_message" => "Department created successfully with code: " . $data['depmt_code']
                        ));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 78, "response_message" => "Failed to create department"));
                    }
                }
                elseif($data['operation'] == 'edit')
                {
                    // Check for duplicate department name within same merchant (excluding current record)
                    $checkName = $this->db_query("SELECT depmt_id FROM department WHERE depmt_name = '{$data['depmt_name']}' AND merchant_id = '{$data['merchant_id']}' AND depmt_id != '{$data['depmt_id']}'", true);
                    if($checkName && count($checkName) > 0) {
                        return json_encode(array("response_code" => 22, "response_message" => "Department name already exists"));
                    }
                    
                    $data['updated_at'] = date("Y-m-d H:i:s");
                    $data['updated_officer'] = $_SESSION['username_sess'];
                    $merchant_id = $data['merchant_id'];
                    $depmt_id = $data['depmt_id'];
                   
                    
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    // $whereClause = [depmt_id = '{$data['depmt_id']}' AND merchant_id = '{$data['merchant_id']}'];
                    $res = $this->doUpdate('department', $data, $excluded_keys, ['depmt_id' => $depmt_id, 'merchant_id' => $merchant_id]);                   
                                      
                    if($res == "1" || $res === true)
                    {
                        return json_encode(array("response_code" => 0, "response_message" => "Department updated successfully"));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 79, "response_message" => "Failed to update department"));
                    }
                }
            }
            else
            {
                return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
            }
        }
        catch(Exception $e)
        {
            error_log("Department Creation Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
    
    public function getDepartment($data)
    {
        try {
            $department_id = $data['depmt_id'] ?? $data['department_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $sql = "SELECT * FROM department WHERE depmt_id='$department_id' AND merchant_id='$merchant_id' LIMIT 1";

            $dept = $this->db_query($sql, true);
            
            if($dept && count($dept) > 0) {
                return json_encode(array("response_code" => 0, "data" => $dept[0]));
            } else {
                return json_encode(array("response_code" => 404, "response_message" => "Department not found"));
            }
        }
        catch(Exception $e)
        {
            error_log("Get Department Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching department"));
        }
    }
    
    public function deleteDepartment($data)
    {
        try {
            $department_id = $data['depmt_id'] ?? $data['department_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];

            // // Check if department is being used by any employees/members
            // $checkUsage = $this->db_query("SELECT COUNT(*) as count FROM employees WHERE department_id = '$department_id'", true);
            // if($checkUsage && $checkUsage[0]['count'] > 0) {
            //     return json_encode(array("response_code" => 23, "response_message" => "Cannot delete department. It is currently assigned to employees."));
            // }

            $sql = "DELETE FROM department WHERE depmt_id = '$department_id' AND merchant_id = '$merchant_id'";
            $result = $this->db_query($sql, false);

            if($result) {
                return json_encode(array("response_code" => 0, "response_message" => "Department deleted successfully"));
            } else {
                return json_encode(array("response_code" => 80, "response_message" => "Failed to delete department"));
            }
        }
        catch(Exception $e)
        {
            error_log("Delete Department Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
    
    public function getAllDepartments($data)
    {
        try {
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $sql = "SELECT depmt_id as id, depmt_name as department_name, depmt_code as department_code FROM department WHERE merchant_id = '$merchant_id' AND depmt_status = '1' ORDER BY depmt_name";
            $result = $this->db_query($sql, true);

            return json_encode(array("response_code" => 0, "data" => $result));
        }
        catch(Exception $e)
        {
            error_log("Get All Departments Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching departments"));
        }
    }
}