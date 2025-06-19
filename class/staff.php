<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);   

class Staff extends dbobject
{
    public function staffList($data)
    {
        $table_name = "staff";
        $primary_key   = "staff_id";
        $columner = array(
            array( 'db' => 'staff_id', 'dt' => 0 ),
            array( 'db' => 'staff_first_name', 'dt' => 1 ),
            array( 'db' => 'staff_last_name', 'dt' => 2 ),
            array( 'db' => 'staff_code', 'dt' => 3 ),
            array( 'db' => 'staff_email', 'dt' => 4 ),
            array( 'db' => 'staff_phone_no', 'dt' => 5 ),
            array( 'db' => 'depmt_name', 'dt' => 6 ), // Add this line (adjust dt as needed)
            array( 
                'db' => 'staff_status', 
                'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return $d == '1' ? '<span class="badge bg-success">Still employed</span>' : '<span class="badge bg-danger">No longer employed</span>';
                }
            ),
            array( 'db' => 'staff.created_at', 'dt' => 8 ),
            array( 
                'db' => 'staff_id', 
                'dt' => 9,
                'formatter' => function( $d, $row ) {
                    return '<div class="d-flex gap-1">
                               <button class="btn btn-sm btn-outline-secondary" onclick="editstaff('.$d.')"><i
                      class="fas fa-pencil-alt"></i></button>
            
              <button class="btn btn-sm btn-outline-danger" onclick="deletestaff('.$d.')"><i
                      class="fas fa-trash-alt"></i></button>
                            </div>';
                }
            )
        );
        
        $join = [
        ["department d" => ["staff.depmt_id", "d.depmt_id"]]
        ];
        
        // Filter by merchant_id for security
        $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'] ?? '';
        $filter = "AND staff.merchant_id = '$merchant_id'";

        $datatableEngine = new engine();
        return $datatableEngine->generic_multi_table($data, $table_name, $columner, $primary_key, $join, $filter,
        $join_type = 'LEFT JOIN');
        
    }

    private function generateStaffCode($staffFirstName, $merchantId) {
        $merchantId = $_SESSION['merchant_id'] ?? $merchantId;
        $sql = "SELECT merchant_business_name FROM merchant_reg WHERE merchant_id = '$merchantId' LIMIT 1";
        $company = $this->db_query($sql, true);
        $companyName = isset($company[0]['merchant_business_name']) ? $company[0]['merchant_business_name'] : 'STAFF';
        // Get first 3 letters of company name, convert to uppercase
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $companyName), 0, 3));
        $prefix = str_pad($prefix, 3, 'X');

        // Generate unique code
        do {
            $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $code = $prefix . $randomNumber;
            $checkCode = $this->db_query("SELECT staff_id FROM staff WHERE staff_code = '$code' AND merchant_id = '$merchantId'", true);
        } while ($checkCode && count($checkCode) > 0);

        return $code;
    }

    public function createStaff($data)
    {
        try {
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_officer'] = $_SESSION['username_sess'];

            // Auto-generate staff code
            if($data['operation'] == 'new') {
                $data['staff_code'] = $this->generateStaffCode($data['staff_first_name'], $data['merchant_id']);
            }

            // Validation rules
            $validation = $this->validate($data,
                array(
                    'staff_first_name' => 'required',
                    'staff_last_name' => 'required',
                    'staff_email' => 'required',
                    'staff_phone_no' => 'required',
                    'staff_status' => 'required',
                    'depmt_id' => 'required' 
                ),
                array(
                    'staff_first_name' => 'First Name',
                    'staff_last_name' => 'Last Name',
                    'staff_email' => 'Email',
                    'staff_phone_no' => 'Phone Number',
                    'staff_status' => 'Status',
                    'depmt_id' => 'Department' 
                )
            ); // <-- Add this line

            if(!$validation['error'])
            {
                if($data['operation'] == 'new')
                {
                    // Check for duplicate staff email within same merchant
                    $checkEmail = $this->db_query("SELECT staff_id FROM staff WHERE staff_email = '{$data['staff_email']}' AND merchant_id = '{$data['merchant_id']}'", true);
                    if($checkEmail && count($checkEmail) > 0) {
                        return json_encode(array("response_code" => 22, "response_message" => "Staff email already exists"));
                    }

                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doInsert('staff', $data, $excluded_keys);

                    if($res == "1")
                    {
                        return json_encode(array(
                            "response_code" => 0,
                            "response_message" => "Staff created successfully with code: " . $data['staff_code']
                        ));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 78, "response_message" => "Failed to create staff"));
                    }
                }
                elseif($data['operation'] == 'edit')
                {
                    // Check for duplicate staff email within same merchant (excluding current record)
                    $checkEmail = $this->db_query("SELECT staff_id FROM staff WHERE staff_email = '{$data['staff_email']}' AND merchant_id = '{$data['merchant_id']}' AND staff_id != '{$data['staff_id']}'", true);
                    if($checkEmail && count($checkEmail) > 0) {
                        return json_encode(array("response_code" => 22, "response_message" => "Staff email already exists"));
                    }

                    $data['updated_at'] = date("Y-m-d H:i:s");
                    $data['updated_officer'] = $_SESSION['username_sess'];
                    $merchant_id = $data['merchant_id'];
                    $staff_id = $data['staff_id'];
                   
                    
                    $excluded_keys = ['op', 'operation', 'nrfa-csrf-token-label'];
                    $res = $this->doUpdate('staff', $data, $excluded_keys, ['staff_id' => $staff_id, 'merchant_id' => $merchant_id]);                   
                                      
                    if($res == "1" || $res === true)
                    {
                        return json_encode(array("response_code" => 0, "response_message" => "Staff updated successfully"));
                    }
                    else
                    {
                        return json_encode(array("response_code" => 79, "response_message" => "Failed to update staff"));
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
            error_log("Staff Creation Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
    
    public function getStaff($data)
    {
        try {
            $staff_id = $data['staff_id'] ?? $data['staff_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            $sql = "SELECT * FROM staff WHERE staff_id='$staff_id' AND merchant_id='$merchant_id' LIMIT 1";

            $staff = $this->db_query($sql, true);
            
            if($staff && count($staff) > 0) {
                return json_encode(array("response_code" => 0, "data" => $staff[0]));
            } else {
                return json_encode(array("response_code" => 404, "response_message" => "staff not found"));
            }
        }
        catch(Exception $e)
        {
            error_log("Get staff Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching staff"));
        }
    }
    
    public function deleteStaff($data)
    {
        try {
            $staff_id = $data['staff_id'] ?? $data['staff_id'];
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];

            // Check if staff is being used by any employees/members
            // $checkUsage = $this->db_query("SELECT COUNT(*) as count FROM employees WHERE staff_id = '$staff_id'", true);
            // if($checkUsage && $checkUsage[0]['count'] > 0) {
            //     return json_encode(array("response_code" => 23, "response_message" => "Cannot delete staff. It is currently assigned to employees."));
            // }

            $sql = "DELETE FROM staff WHERE staff_id = '$staff_id' AND merchant_id = '$merchant_id'";
            $result = $this->db_query($sql, false);

            if($result) {
                return json_encode(array("response_code" => 0, "response_message" => "staff deleted successfully"));
            } else {
                return json_encode(array("response_code" => 80, "response_message" => "Failed to delete staff"));
            }
        }
        catch(Exception $e)
        {
            error_log("Delete staff Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => $e->getMessage()));
        }
    }
    
    public function getAllStaffs($data)
    {
        try {
            $merchant_id = $_SESSION['merchant_id'] ?? $data['merchant_id'];
            // Fixed: Changed staff_name to CONCAT(staff_first_name, ' ', staff_last_name) as staff_name
            $sql = "SELECT staff_id as id, CONCAT(staff_first_name, ' ', staff_last_name) as staff_name, staff_code as staff_code FROM staff WHERE merchant_id = '$merchant_id' AND staff_status = '1' ORDER BY staff_first_name";
            $result = $this->db_query($sql, true);

            return json_encode(array("response_code" => 0, "data" => $result));
        }
        catch(Exception $e)
        {
            error_log("Get All staffs Error: " . $e->getMessage());
            return json_encode(array("response_code" => 500, "response_message" => "An error occurred while fetching staffs"));
        }
    }
}