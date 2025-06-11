<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Users extends dbobject
{
    

    // public function login($data)
    // {

    //     $username = $data['username'];
    //     $password = $data['password'];
    //     $validate = $this->validate(
    //         $data,
    //         array('username' => 'required|email', 'password' => 'required'),
    //         array('username' => 'Username', 'password' => 'Password')
    //     );
    //     if ($validate['error']) {
    //         return json_encode(array('response_code' => 13, 'response_message' => $validate['messages'][0]));
    //     }
    //     $sql      = "SELECT username,firstname,lastname,sex,role_id,password,user_locked,user_disabled,pin_missed,day_1,day_2,day_3,day_4,day_5,day_6,day_7,passchg_logon,photo,church_id FROM userdata WHERE username = '$username' LIMIT 1";
    //     $result   = $this->db_query($sql, true);
    //     $count    = count($result);
    //     if ($count > 0) {
    //         if ($result[0]['pin_missed'] < 5) {
    //             $encrypted_password = $result[0]['password'];
    //             $is_locked     = $result[0]['user_locked'];
    //             $is_disabled     = $result[0]['user_disabled'];
    //             // $verify_pass   = password_verify($password,$hash_password);

    //             $desencrypt = new AES();
    //             $key = $username;
    //             // $cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
    //             $str_cipher_password = $desencrypt->encrypt($password);
    //             if ($str_cipher_password == $encrypted_password) {
    //                 if ($is_disabled != 1) {
    //                     if ($is_locked != 1) {
    //                         $work_day = $this->workingDays($result[0]);
    //                         if ($work_day['code'] != "44") {
    //                             if ($result[0]['church_id'] != "99") {
    //                                 $church_details = $this->getItemLabelArr('church_table', array('church_id'), array($result[0]['church_id']), array('church_type', 'state', 'church_name'));
    //                                 $_SESSION['username_sess']   = $result[0]['username'];
    //                                 $_SESSION['firstname_sess']  = $result[0]['firstname'];
    //                                 $_SESSION['lastname_sess']   = $result[0]['lastname'];
    //                                 $_SESSION['sex_sess']        = $result[0]['sex'];
    //                                 $_SESSION['role_id_sess']    = $result[0]['role_id'];
    //                                 $_SESSION['church_id_sess']  = $result[0]['church_id'];
    //                                 $_SESSION['photo_file_sess']  = $result[0]['photo'];
    //                                 $_SESSION['photo_path_sess']  = "img/profile_photo/" . $result[0]['photo'];
    //                                 $_SESSION['church_type_id_sess'] = $church_details['church_type'];
    //                                 $_SESSION['state_id_sess'] = $church_details['state'];;
    //                                 $_SESSION['church_name_sess'] = $church_details['church_name'];;
    //                                 $_SESSION['role_id_name']    = $this->getitemlabel('role', 'role_id', $result[0]['role_id'], 'role_name');


    //                                 //update pin missed and last_login
    //                                 $this->resetpinmissed($username);
    //                                 return json_encode(array("response_code" => 0, "response_message" => "Login Successful"));
    //                             } else {
    //                                 return json_encode(array("response_code" => 779, "response_message" => "You can't login now... A profile transfer is currently ongoing. Try again at a later time or contact the Administrator"));
    //                             }
    //                         } else {
    //                             return json_encode(array("response_code" => 61, "response_message" => $work_day['mssg']));
    //                         }
    //                     } else {
    //                         //inform the user that the account has been locked, and to contact admin, user has to provide useful info b4 he is unlocked
    //                         return json_encode(array("response_code" => 60, "response_message" => "Your account has been locked, kindly contact the administrator."));
    //                     }
    //                 } else {
    //                     return json_encode(array("response_code" => 610, "response_message" => "Your user privilege has been revoked. Kindly contact the administrator"));
    //                 }
    //             } else {
    //                 $this->updatepinmissed($username);

    //                 $remaining = (($result[0]['pin_missed'] + 1) <= 5) ? (5 - ($result[0]['pin_missed'] + 1)) : 0;
    //                 return json_encode(array("response_code" => 90, "response_message" => "Invalid username or password, " . $remaining . " attempt remaining"));
    //             }
    //         } elseif ($result[0]['pin_missed'] == 5) {
    //             $this->updateuserlock($username, '1');
    //             return json_encode(array("response_code" => 64, "response_message" => "Your account has been locked, kindly contact the administrator."));
    //         } else {
    //             return json_encode(array("response_code" => 62, "response_message" => "Your account has been locked, kindly contact the administrator."));
    //         }
    //     } else {
    //         return json_encode(array("response_code" => 20, "response_message" => "Invalid username or password"));
    //     }
    // }

    public function login($data)
{
    $username = $data['username'];
    $password = $data['password'];
    $validate = $this->validate(
        $data,
        array('username' => 'required|email', 'password' => 'required'),
        array('username' => 'Username', 'password' => 'Password')
    );
    if($validate['error'])
    {
        return json_encode(array('response_code'=>13,'response_message'=>$validate['messages'][0]));
    }
    
    // Modified SQL to include registration_completed field
    $sql = "SELECT username,merchant_id,firstname,lastname,sex,role_id,password,user_locked,user_disabled,pin_missed,day_1,day_2,day_3,day_4,day_5,day_6,day_7,passchg_logon,photo,church_id,registration_completed FROM userdata WHERE username = '$username' LIMIT 1";
    $result = $this->db_query($sql,true);
    $count = count($result); 
        
    if($count > 0)
    {
        if($result[0]['pin_missed'] < 5)
        {
            $encrypted_password = $result[0]['password'];
            $is_locked = $result[0]['user_locked'];
            $is_disabled = $result[0]['user_disabled'];
            $registration_completed = $result[0]['registration_completed']; // Get registration status

            $desencrypt = new DESEncryption();
            $key = $username;
            $cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
            $str_cipher_password = $desencrypt->stringToHex ($cipher_password);
            
            if($str_cipher_password == $encrypted_password)
            {
                if($is_disabled != 1)
                {
                    if($is_locked != 1)
                    {
                        $work_day = $this->workingDays($result[0]);
                        if($work_day['code'] != "44")
                        {
                            if($result[0]['church_id'] != "99")
                            {
                                $church_details = $this->getItemLabelArr('church_table',array('church_id'),array($result[0]['church_id']),array('church_type','state','church_name'));
                                $_SESSION['username_sess'] = $result[0]['username'];
                                $_SESSION['firstname_sess'] = $result[0]['firstname'];
                                $_SESSION['lastname_sess'] = $result[0]['lastname'];
                                $_SESSION['sex_sess'] = $result[0]['sex'];
                                $_SESSION['merchant_id'] = $result[0]['merchant_id'];
                                $_SESSION['role_id_sess'] = $result[0]['role_id'];
                                $_SESSION['church_id_sess'] = $result[0]['church_id'];
                                $_SESSION['photo_file_sess'] = $result[0]['photo'];
                                $_SESSION['photo_path_sess'] = "img/profile_photo/".$result[0]['photo'];
                                $_SESSION['church_type_id_sess'] = (isset($church_details['church_type'])) ?$church_details['church_type'] : 0;
                                $_SESSION['state_id_sess'] = (isset($church_details['state'])) ? $church_details['state'] : "FCT";
                                $_SESSION['church_name_sess']= (isset($church_details['church_name'])) ? $church_details['church_name'] : "The lords Chosen";
                                $_SESSION['role_id_name'] = $this->getitemlabel('role','role_id',$result[0]['role_id'],'role_name');

                                //update pin missed and last_login
                                $this->resetpinmissed($username);
                                
                                // Check registration completion status and set redirect URL
                                if($registration_completed == 1) {
                                    $redirect_url = "home.php";
                                } else {
                                    $redirect_url = "complete_onboarding.php";
                                }
                                
                                return json_encode(array(
                                    "response_code" => 0,
                                    "response_message" => "Login Successful",
                                    "data" => [
                                    "redirect" => "home.php"
                                    ]
                                ));
                            }
                            else
                            {
                                return json_encode(array("response_code"=>779,"response_message"=>"You can't login now... A profile transfer is currently ongoing. Try again at a later time or contact the Administrator"));
                            }
                        }
                        else
                        {
                            return json_encode(array("response_code"=>61,"response_message"=>$work_day['mssg']));
                        }
                    }
                    else
                    {
                        //inform the user that the account has been locked, and to contact admin, user has to provide useful info b4 he is unlocked
                        return json_encode(array("response_code"=>60,"response_message"=>"Your account has been locked, kindly contact the administrator."));
                    }
                }
                else
                {
                    return json_encode(array("response_code"=>610,"response_message"=>"Your user privilege has been revoked. Kindly contact the administrator"));
                }
            }
            else	
            {
                $this->updatepinmissed($username);
                
                $remaining = (($result[0]['pin_missed']+1) <= 5)?(5-($result[0]['pin_missed']+1)):0;
                return json_encode(array("response_code"=>90,"response_message"=>"Invalid username or password, ".$remaining." attempt remaining"));
            }
        }
        elseif($result[0]['pin_missed'] == 5)
        {
            $this->updateuserlock($username,'1');
            return json_encode(array("response_code"=>64,"response_message"=>"Your account has been locked, kindly contact the administrator."));
        }
        else
        {
             return json_encode(array("response_code"=>62,"response_message"=>"Your account has been locked, kindly contact the administrator."));
        }
    }
    else
    {
        return json_encode(array("response_code"=>20,"response_message"=>"Invalid username or password"));
    }
}


    public function userlist($data)
    {
        $table_name    = "userdata";
        $primary_key   = "username";
        $columner = array(
            array('db' => 'username', 'dt' => 0),
            array('db' => 'username', 'dt' => 1),
            array('db' => 'firstname',  'dt' => 2),
            array('db' => 'lastname',   'dt' => 3),
            array('db' => 'church_id',   'dt' => 4, 'formatter' => function ($d, $row) {
                return  $this->getitemlabel('church_table', 'church_id', $d, 'church_name');
            }),
            array('db' => 'status',   'dt' => 5, 'formatter' => function ($d, $row) {
                return  $this->getitemlabel('church_table', 'church_id', $row['church_id'], 'address');
            }),
            array('db' => 'mobile_phone',   'dt' => 6),
            array('db' => 'role_id',   'dt' => 7, 'formatter' => function ($d, $row) {
                return  $this->getitemlabel('role', 'role_id', $d, 'role_name');
            }),
            array('db' => 'email',   'dt' => 8),
            array('db' => 'pin_missed',   'dt' => 9),
            array('db' => 'user_disabled',   'dt' => 10, 'formatter' => function ($d, $row) {
                return ($d == 1) ? 'Disabled' : 'Enabled';
            }),
            array('db' => 'username',   'dt' => 11, 'formatter' => function ($d, $row) {
                $locking = ($row['user_disabled'] == 1) ? "Enable User" : "Disable User";
                $locking_class = ($row['user_disabled'] == 1) ? "btn-success" : "btn-danger";
                if ($_SESSION['role_id_sess'] == 001) {
                    $sack = ($row['status'] == "1") ? "<span onclick=\"sackUser('$d','$row[status]')\" style='cursor:pointer' class='badge bg-success'>Recall User</span>" : "<span onclick=\"sackUser('$d','$row[status]')\" style='cursor:pointer' class='badge bg-primary'>Sack User</span>";
                    return  $sack . "<button onclick=\"trigUser('" . $d . "','" . $row['user_disabled'] . "')\" class='btn btn-sm " . $locking_class . "'>" . $locking . "</button><a class='btn btn-sm btn-warning'   onclick=\"loadModal('setup/pastor.php?op=edit&username=" . $d . "','modal_div')\"  href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#defaultModalPrimary\" >EDIT THIS USER</a>";
                } else if ($_SESSION['role_id_sess'] == 003) {
                    return  "<button onclick=\"trigUser('" . $d . "','" . $row['user_disabled'] . "')\" class='btn btn-sm " . $locking_class . "'>" . $locking . "</button>&nbsp;|&nbsp;<a class='btn btn-sm btn-warning'   onclick=\"loadModal('setup/user_edit.php?op=edit&username=" . $d . "','modal_div')\"  href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#defaultModalPrimary\" >EDIT THIS USER</a>";
                }
            }),
            array('db' => 'created',   'dt' => 12)
        );
        $filter = " AND role_id <> '001' AND role_id <> '$_SESSION[role_id_sess]'";
        $church_users_filter = ($_SESSION['role_id_sess'] == '001' || $_SESSION['role_id_sess'] == '005') ? "" : "AND church_id = '$_SESSION[church_id_sess]'";
        $filter = $filter . $church_users_filter;
        $datatableEngine = new engine();

        echo $datatableEngine->generic_table($data, $table_name, $columner, $primary_key, $filter);
    }
    public function generatePwdLink($data)
    {

        $username               = $data['username'];
        $sql                    = "SELECT username,email FROM userdata WHERE username = '$username'";
        $rr                     = $this->db_query($sql);
        if (count($rr) > 0) {
            if (filter_var($rr[0]['email'], FILTER_VALIDATE_EMAIL)) {
                $data                   = $username . "::" . date('Y-m-d h:i:s');
                $desencrypt             = new DESEncryption();
                $key                    = "accessis4life_tlc";
                $cipher_password        = $desencrypt->des($key, $data, 1, 0, null, null);
                $sqltr_cipher_password  = $desencrypt->stringToHex($cipher_password);
                $link                   = $sqltr_cipher_password;
                $val                    = $this->getitemlabelarr("userdata", array('username'), array($username), array('firstname', 'lastname', 'email'));
                $firstname              = (isset($val["firstname"])) ? $val['firstname'] : "";
                $lastname               = (isset($val["lastname"])) ? $val['lastname'] : "";
                $email                  = (isset($val["email"])) ? $val['email'] : "";
                $sql                    = "UPDATE userdata SET reset_pwd_link = '$link' WHERE username = '$username' LIMIT 1";
                
                $this->db_query($sql, false);
                
                mail($email, "Password Reset - The Lord's Chosen", "Dear " . $lastname . ", \n To reset your password kindly follow this link below \n http://accessng.com/tlc/pwd_reset.php?ga=" . $link);
                return json_encode(array('response_code' => 0, 'response_message' => 'Follow the reset link sent to your email'));
            } else {
                return json_encode(array('response_code' => 340, 'response_message' => 'Your email address was not setup properly'));
            }
        } else {
            return json_encode(array('response_code' => 940, 'response_message' => 'Username does not exist'));
        }
    }

    public function verifyLink($link)
    {
        $desencrypt      = new DESEncryption();
        $key             = "accessis4life_tlc";
        $json_value      = $this->DecryptData($key, $link);
        $arr             = explode("::", $json_value);
        $date            = $arr[1];
        $username        = $arr[0];
        $sql = "SELECT reset_pwd_link,firstname,lastname FROM userdata WHERE username = '$username' AND reset_pwd_link = '$link' LIMIT 1";
        $result = $this->db_query($sql);
        $count = (!empty($result)) ? count($result) : 0;
        if ($count > 0) {
            $date1  = strtotime($date);
            $date2  = strtotime(date('Y-m-d h:i:s'));
            // Formulate the Difference between two dates 
            $diff   = abs($date2 - $date1);
            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years  = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $hours  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
            if ($hours > 72) {
                return json_encode(array('response_code' => 88, 'response_message' => 'This link has expired'));
            } else {
                $sql = "UPDATE userdata SET reset_pwd_link = '' WHERE username = '$username' LIMIT 1";
                $this->db_query($sql, false);
                return json_encode(array('response_code' => 0, 'response_message' => 'OK', 'data' => array('username' => $username, 'firstname' => $result[0]['firstname'], 'lastname' => $result[0]['lastname'])));
            }
        } else {
            return json_encode(array('response_code' => 848, 'response_message' => 'This link has already been used or tampared with'));
        }
    }

   // Add this to your Users class

   public function resendVerificationCode()
   {
   // Only allow resending if there's a session
   if (session_status() == PHP_SESSION_NONE) {
   session_start();
   }

   if (!isset($_SESSION['pending_verification_email'])) {
   return json_encode([
   'response_code' => 20,
   'response_message' => 'Invalid session. Please register again.'
   ]);
   }

   $email = $_SESSION['pending_verification_email'];

   // Get user data from userdata table
   $sql = "SELECT * FROM userdata WHERE email = '$email' AND verification_status = '0' LIMIT 1";
   
   $user = $this->db_query($sql, true);
   
   if (!$user || count($user) === 0) {
   return json_encode([
   'response_code' => 20,
   'response_message' => 'User not found or already verified.'
   ]);
   }

   // Generate new verification code
   $verification_code = random_int(100000, 999999);

   // Update code in database
   $update_data = [
   'verification_code' => $verification_code,
   'expiry' => date('Y-m-d H:i:s', time() + 3600) // Reset expiry to 1 hour from now
   ];

   $result = $this->doUpdate('userdata', $update_data, [], ['email' => $email]);

   if ($result) {
   // Send new code via email
   $lastname = $user[0]['lastname'] ?? '';
   $email_result = $this->sendVerificationEmail($email, $verification_code);

   if ($email_result['success']) {
   return json_encode([
   'response_code' => 0,
   'response_message' => 'A new verification code has been sent to your email.'
   ]);
   } else {
   return json_encode(['response_code' => 500, 'response_message' => $email_result['message']]);
   }
   } else {
   return json_encode(['response_code' => 20, 'response_message' => 'Failed to update verification code.']);
   }
   }

   public function verifyOTP()
   {
   if (session_status() == PHP_SESSION_NONE) {
   session_start();
   }

   // Get parameters
   $code = isset($_POST['code']) ? $_POST['code'] : '';
   $email = isset($_SESSION['pending_verification_email']) ? $_SESSION['pending_verification_email'] : '';

   // Validation
   if (empty($code)) {
   return json_encode(["response_code" => 20, "response_message" => "Verification code is required"]);
   }

   if (empty($email)) {
   return json_encode(["response_code" => 20, "response_message" => "Invalid session. Please register again."]);
   }

   // Verify code from userdata table
   $query = "SELECT * FROM userdata WHERE email = '$email' AND verification_code = '$code' AND verification_status = '0'
   AND expiry > NOW() LIMIT 1";
   
   $result = $this->db_query($query);

   if (!$result || count($result) === 0) {
   return json_encode(["response_code" => 20, "response_message" => "Invalid or expired verification code."]);
   }

   // Mark user as verified
   $update_data = [
   'verification_status' => 1,
   'verification_date_created' => date('Y-m-d H:i:s'),
   'verification_code' => '0', // Clear the verification code
   'expiry' => '0' // Clear the expiry
   ];

   $update_result = $this->doUpdate('userdata', $update_data, [], ['email' => $email, 'verification_code' => $code]);

   if ($update_result) {
   // Clear verification session
   unset($_SESSION['pending_verification_email']);

   // Set login session (optional - user is now verified and can be logged in)
   $_SESSION['username_sess'] = $result[0]['username'];

   return json_encode([
   'response_code' => 0,
   'response_message' => 'Email verification successful! You can now access your account.',
   'data' => [
   'redirect' => 'home.php' // or wherever you want to redirect after verification
   ]
   ]);
   } else {
   return json_encode([
   "response_code" => 20,
   "response_message" => "Failed to update verification status."
   ]);
   }
   }

   
        public function register($data)
        {
        // Convert boolean fields
        $data['passchg_logon'] = isset($data['passchg_logon']) ? 1 : 0;
        $data['user_disabled'] = isset($data['user_disabled']) ? 1 : 0;
        $data['user_locked'] = isset($data['user_locked']) ? 1 : 0;

        // Validate required fields
        if (empty($data['role_id'])) {
        return json_encode(["response_code" => 20, "response_message" => "Role ID is required"]);
        }
        if (empty($data['email'])) {
        return json_encode(["response_code" => 20, "response_message" => "Email is required"]);
        }
        if (empty($data['password'])) {
        return json_encode(["response_code" => 20, "response_message" => "Password is required"]);
        }
        if (!isset($data['confirm_password'])) {
        return json_encode(["response_code" => 20, "response_message" => "Confirm Password is required"]);
        }

        $email = $data['email'];
        $lastname = isset($data['lastname']) ? $data['lastname'] : '';

        // Check if role_id exists
        $role_exists = $this->db_query("SELECT role_id FROM role WHERE role_id = '{$data['role_id']}'");
        if (!$role_exists || count($role_exists) === 0) {
        return json_encode(["response_code" => 20, "response_message" => "Invalid Role ID provided"]);
        }

        // Check password match
        if ($data['password'] !== $data['confirm_password']) {
        return json_encode(["response_code" => 20, "response_message" => "Passwords do not match"]);
        }

        // Check if user already exists
        $sql = ("SELECT email, verification_status FROM userdata WHERE email = '{$email}' LIMIT
        1");
        $existing_user = $this->db_query($sql, true);
        
        if ($existing_user) {
        // If user exists but not verified, resend OTP
        if ($existing_user[0]['verification_status'] == 0) {
        return $this->resendVerificationForExistingUser($email);
        } else {
        // User exists and is verified
        return json_encode(["response_code" => 77, "response_message" => 'Email already exists and is verified']);
        }
        }

        // Validate input data
        $validation = $this->validate(
        $data,
        [
        'role_id' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'confirm_password' => 'required|match:password'
        ],
        [
        'email' => 'Email',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'role_id' => 'Role ID'
        ]
        );

        if (!$validation['error']) {
        // Generate 6-digit verification code
        $verification_code = random_int(100000, 999999);

        // DES encryption for password
        $desencrypt = new DESEncryption();
        $key = $email;
        $cipher_password = $desencrypt->des($key, $data['password'], 1, 0, null, null);
        $encrypted_password = $desencrypt->stringToHex($cipher_password);

        // Generate unique merchant ID
        do {
        $merchant_id = 'PRO-' . mt_rand(100000, 999999);
        $merchant_exists = $this->db_query("SELECT merchant_id FROM userdata WHERE merchant_id = '{$merchant_id}' LIMIT
        1", false);
        } while ($merchant_exists);

        // Prepare user data for insertion
        $user_data = [
        'role_id' => $data['role_id'],
        'email' => $email,
        'username' => $email,
        'password' => $encrypted_password,
        'merchant_id' => $merchant_id,
        'verification_code' => $verification_code,
        'verification_status' => 0, // Unverified
        'passchg_logon' => $data['passchg_logon'],
        'user_disabled' => $data['user_disabled'],
        'user_locked' => $data['user_locked'],
        'created' => date('Y-m-d H:i:s'),
        'expiry' => date('Y-m-d H:i:s', time() + 3600) // 1 hour expiry
        ];

        // Insert user data into userdata table
        $excludedKeys = ['op', 'confirm_password', 'operation', 'nrfa-csrf-token-label'];
        $insert_result = $this->doInsert('userdata', $user_data, $excludedKeys);

        if ($insert_result) {
        // Send verification email
        $email_result = $this->sendVerificationEmail($email,  $verification_code);

        if ($email_result['success']) {
        // Start session and store email for verification
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        $_SESSION['pending_verification_email'] = $email;

        return json_encode([
        'response_code' => 0,
        'response_message' => 'Registration successful! Please check your email for verification code.',
        'data' => [
        'email' => $email,
        'redirect' => "verify_account.php"
        ]
        ]);
        } else {
        // Registration succeeded but email failed - still allow verification
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        $_SESSION['pending_verification_email'] = $email;

        return json_encode([
        'response_code' => 0,
        'response_message' => 'Registration successful! However, email could not be sent. Please contact support.',
        'data' => [
        'email' => $email,
        'redirect' => "verify_account.php"
        ]
        ]);
        }
        } else {
        return json_encode(["response_code" => 78, "response_message" => 'Registration failed. Please try again.']);
        }
        } else {
        return json_encode(["response_code" => 20, "response_message" => $validation['messages'][0]]);
        }
        }

        private function resendVerificationForExistingUser($email, )
        {
        // Generate new verification code
        $verification_code = random_int(100000, 999999);

        // Update the existing user with new verification code and expiry
        $update_data = [
        'verification_code' => $verification_code,
        'expiry' => date('Y-m-d H:i:s', time() + 3600) // Reset expiry to 1 hour from now
        ];

        $update_result = $this->doUpdate('userdata', $update_data, [], ['email' => $email]);

        if ($update_result) {
        // Send verification email
        $email_result = $this->sendVerificationEmail($email,  $verification_code);

        if ($email_result['success']) {
        // Start session for verification
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        $_SESSION['pending_verification_email'] = $email;

        return json_encode([
        'response_code' => 0,
        'response_message' => 'A new verification code has been sent to your email.',
        'data' => [
        'email' => $email,
        'redirect' => "verify_account.php"
        ]
        ]);
        } else {
        return json_encode(['response_code' => 500, 'response_message' => 'Failed to send verification email.']);
        }
        } else {
        return json_encode(['response_code' => 20, 'response_message' => 'Failed to update verification code.']);
        }
        }

        private function sendVerificationEmail($email, $verification_code)
        {
        $mail = new PHPMailer(true);

        try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Jesuslovestestimony@gmail.com';
        $mail->Password = 'liuz vikp wzei ggkt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('Jesuslovestestimony@gmail.com', 'The Lord\'s Chosen');
        if (!$mail->addAddress($email)) {
        return ['success' => false, 'message' => 'Invalid email address: ' . $email];
        }

        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code - The Lord\'s Chosen';
        $mail->Body = "Dear " . htmlspecialchars( $email) . ",<br><br>" .
        "Thank you for registering with us.<br><br>" .
        "<strong>Your verification code is: <span style='font-size: 18px;'>{$verification_code}</span></strong><br><br>"
        .
        "Please use this code to complete your registration.<br><br>" .
        "God bless you richly,<br>The Lord's Chosen Team";

        $mail->AltBody = "Dear {$email},\n\nYour verification code is: {$verification_code}\n\nUse it to complete
        your registration.";

        if ($mail->send()) {
        return ['success' => true, 'message' => 'Email sent successfully'];
        } else {
        return ['success' => false, 'message' => 'Failed to send email: ' . $mail->ErrorInfo];
        }
        } catch (Exception $e) {
        return ['success' => false, 'message' => 'Mail Error: ' . $e->getMessage()];
        }
        }

    // Mask email for display
    function mask_email($email) {
    $atPos = strpos($email, '@');
    if ($atPos === false) return $email;
    $name = substr($email, 0, $atPos);
    $domain = substr($email, $atPos);
    if (strlen($name) <= 2) { $masked=substr($name, 0, 1) . str_repeat('*', max(0, strlen($name)-1)); } else {
        $masked=substr($name, 0, 3) . str_repeat('*', max(0, strlen($name)-3)); } return $masked . $domain;
     
    }
    public function getLGA($data)
    {
        
        $state_id = $data['state_id'];
        // Fetch LGAs based on the selected state
        $query = "SELECT Lga, stateid as id FROM lga WHERE stateid = '$state_id' ORDER BY lga";

        $lgas = $this->db_query($query);
        // Return the result as JSON
        $lgas1 = json_encode($lgas);
        
        return $lgas1;
        
    }

    public function complete_registration($data)
    {
        $username = $data['username'] ?? '';
    try {
    // Validate required fields
    $required_fields = [
    'merchant_id' => 'Merchant ID',
    'merchant_first_name' => 'First Name',
    'merchant_last_name' => 'Last Name',
    'merchant_email' => 'Email',
    'merchant_phone' => 'Phone Number',
    'merchant_dob' => 'Date of Birth',
    'merchant_address' => 'Address',
    'merchant_state' => 'State',
    'merchant_lga' => 'LGA',
    'merchant_business_name' => 'Business Name',
    'merchant_business_description' => 'Business Description',
    'merchant_support_email' => 'Business Email',
    'merchant_business_phone' => 'Business Phone',
    'cac_number' => 'CAC Number'
    ];

    foreach ($required_fields as $field => $label) {
    if (empty($data[$field])) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "{$label} is required"
    ]);
    }
    }

    // Validate merchant_id exists and is not already completed
    $merchant_check = $this->db_query("SELECT merchant_id, registration_completed FROM userdata WHERE merchant_id =
    '{$data['merchant_id']}' LIMIT 1");
    if (!$merchant_check || count($merchant_check) === 0) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid merchant ID"
    ]);
    }

    if (isset($merchant_check[0]['registration_completed']) && $merchant_check[0]['registration_completed'] == 1) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Registration has already been completed"
    ]);
    }

    // Validate email format
    if (!filter_var($data['merchant_email'], FILTER_VALIDATE_EMAIL)) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid email format"
    ]);
    }

    if (!filter_var($data['merchant_support_email'], FILTER_VALIDATE_EMAIL)) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid business email format"
    ]);
    }

    // Validate phone numbers (basic validation)
    if (!preg_match('/^[0-9+\-\s\(\)]{10,15}$/', $data['merchant_phone'])) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid phone number format"
    ]);
    }

    if (!preg_match('/^[0-9+\-\s\(\)]{10,15}$/', $data['merchant_business_phone'])) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid business phone number format"
    ]);
    }

    // Validate date of birth
    $dob = DateTime::createFromFormat('Y-m-d', $data['merchant_dob']);
    if (!$dob) {
    return json_encode([
    "response_code" => 20,
    "response_message" => "Invalid date of birth format"
    ]);
    }

    // Check if user is at least 18 years old
    $age = $dob->diff(new DateTime())->y;
    if ($age < 18) { return json_encode([ "response_code"=> 20,
        "response_message" => "You must be at least 18 years old to register"
        ]);
        }

        // Check for duplicate emails
        $email_check = $this->db_query("SELECT merchant_id FROM merchant_reg WHERE (merchant_email = '{$data['merchant_email']}') AND merchant_id != '{$data['merchant_id']}' LIMIT 1");
        if ($email_check && count($email_check) > 0) {
        return json_encode([
        "response_code" => 21,
        "response_message" => "Email address is already in use"
        ]);
        }

        $business_email_check = $this->db_query("SELECT merchant_id FROM merchant_reg WHERE merchant_support_email =
        '{$data['merchant_support_email']}' AND merchant_id != '{$data['merchant_id']}' LIMIT 1");
        if ($business_email_check && count($business_email_check) > 0) {
        return json_encode([
        "response_code" => 21,
        "response_message" => "Business email address is already in use"
        ]);
        }

        // Check for duplicate CAC number
        $cac_check = $this->db_query("SELECT merchant_id FROM merchant_reg WHERE cac_number = '{$data['cac_number']}' AND
        merchant_id != '{$data['merchant_id']}' LIMIT 1");
        if ($cac_check && count($cac_check) > 0) {
        return json_encode([
        "response_code" => 21,
        "response_message" => "CAC number is already registered"
        ]);
        }

        // Handle file uploads
        $upload_dir = 'uploads/merchants/' . $data['merchant_id'] . '/';
        if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
        return json_encode([
        "response_code" => 500,
        "response_message" => "Failed to create upload directory"
        ]);
        }
        }

        $uploaded_files = [];

        // Handle logo upload
        if (isset($_FILES['merchant_logo']) && $_FILES['merchant_logo']['error'] === UPLOAD_ERR_OK) {
        $logo_info = pathinfo($_FILES['merchant_logo']['name']);
        $logo_extension = strtolower($logo_info['extension']);

        // Validate file type
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($logo_extension, $allowed_image_types)) {
        return json_encode([
        "response_code" => 20,
        "response_message" => "Invalid logo file type. Only JPG, JPEG, PNG, and GIF are allowed"
        ]);
        }

        // Validate file size (max 5MB)
        if ($_FILES['merchant_logo']['size'] > 5 * 1024 * 1024) {
        return json_encode([
        "response_code" => 20,
        "response_message" => "Logo file size must be less than 5MB"
        ]);
        }

        $logo_filename = 'logo_' . time() . '.' . $logo_extension;
        $logo_path = $upload_dir . $logo_filename;

        if (move_uploaded_file($_FILES['merchant_logo']['tmp_name'], $logo_path)) {
        $uploaded_files['merchant_logo'] = $logo_path;
        $data['merchant_logo_path'] = $logo_path;
        } else {
        return json_encode([
        "response_code" => 500,
        "response_message" => "Failed to upload logo file"
        ]);
        }
        }

        // Handle CAC document upload
        if (isset($_FILES['cac_document']) && $_FILES['cac_document']['error'] === UPLOAD_ERR_OK) {
        $cac_info = pathinfo($_FILES['cac_document']['name']);
        $cac_extension = strtolower($cac_info['extension']);

        // Validate file type
        $allowed_doc_types = ['pdf', 'jpg', 'jpeg', 'png'];
        if (!in_array($cac_extension, $allowed_doc_types)) {
        return json_encode([
        "response_code" => 20,
        "response_message" => "Invalid CAC document file type. Only PDF, JPG, JPEG, and PNG are allowed"
        ]);
        }

        // Validate file size (max 10MB)
        if ($_FILES['cac_document']['size'] > 10 * 1024 * 1024) {
        return json_encode([
        "response_code" => 20,
        "response_message" => "CAC document file size must be less than 10MB"
        ]);
        }

        $cac_filename = 'cac_' . time() . '.' . $cac_extension;
        $cac_path = $upload_dir . $cac_filename;

        if (move_uploaded_file($_FILES['cac_document']['tmp_name'], $cac_path)) {
        $uploaded_files['cac_document'] = $cac_path;
        $data['cac_document_path'] = $cac_path;
        } else {
        return json_encode([
        "response_code" => 500,
        "response_message" => "Failed to upload CAC document"
        ]);
        }
        }

        // Prepare data for database update
        $update_data = [
        'merchant_id' => $data['merchant_id'],
        'merchant_first_name' => $data['merchant_first_name'],
        'merchant_last_name' => $data['merchant_last_name'],
        'merchant_email' => $data['merchant_email'],
        'merchant_phone' => $data['merchant_phone'],
        'merchant_dob' => $data['merchant_dob'],
        'merchant_address' => $data['merchant_address'],
        'merchant_state' => $data['merchant_state'],
        'merchant_lga' => $data['merchant_lga'],
        'merchant_business_name' => $data['merchant_business_name'],
        'merchant_business_description' => $data['merchant_business_description'],
        'merchant_support_email' => $data['merchant_support_email'],
        'merchant_business_phone' => $data['merchant_business_phone'],
        'cac_number' => $data['cac_number'],
        'registration_completed' => 1,
        'profile_completed_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
        ];

        // Add file paths if uploaded
        if (isset($data['merchant_logo_path'])) {
        $update_data['merchant_logo_path'] = $data['merchant_logo_path'];
        }
        if (isset($data['cac_document_path'])) {
        $update_data['cac_document_path'] = $data['cac_document_path'];
        }

        // Update the user record
        $update_result = $this->doInsert('merchant_reg', $update_data, []);
        
        // Check
        if ($update_result) {
        // Log the completion in userdata
        $log_data = [
        'registration_completed' => 1,
        'profile_completed_at' => date('Y-m-d H:i:s')
        ];
        $answer = $this->doUpdate('userdata', $log_data, [], ['username' => $username]);
        // Optionally, you can log or check $answer for success

        return json_encode([
        'response_code' => 0,
        'response_message' => 'Registration completed successfully! Welcome to our platform.',
        'data' => [
        'merchant_id' => $data['merchant_id'],
        'redirect' => 'home.php'
        ]
        ]);
        } else {
        // Clean up uploaded files if database update failed
        foreach ($uploaded_files as $file_path) {
        if (file_exists($file_path)) {
        unlink($file_path);
        }
        }

        return json_encode([
        "response_code" => 500,
        "response_message" => "Failed to complete registration. Please try again."
        ]);
        }

        } catch (Exception $e) {
        // Clean up uploaded files if there was an error
        if (isset($uploaded_files)) {
        foreach ($uploaded_files as $file_path) {
        if (file_exists($file_path)) {
        unlink($file_path);
        }
        }
        }

        return json_encode([
        "response_code" => 500,
        "response_message" => "An error occurred: " . $e->getMessage()
        ]);
        }
        }

    
    public function updatePastorBank($data)
    {
        $validation = $this->validate(
            $data,
            array(
                'bank_name' => 'required',
                'account_no' => 'required',
                'account_name' => 'required',
            ),
            array('account_name' => 'Account Name', 'account_no' => 'Account Number', 'bank_name' => 'Bank Name')
        );
        if (!$validation['error']) {
            $count = $this->doUpdate("userdata", $data, array('op', 'operation', 'nrfa-csrf-token-label'), array("username" => $_SESSION['username_sess']));
            if ($count > 0) {
                return json_encode(array("response_code" => 0, "response_message" => 'Updated personal information.'));
            } else {
                return json_encode(array("response_code" => 78, "response_message" => 'Failed to save record'));
            }
        } else {
            return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
        }
    }
    public function profileEdit($data)
    {
        $validate = $this->validate($data, array('username' => 'required|email', 'firstname' => 'required', 'lastname' => 'required', 'mobile_phone' => 'required', 'sex' => 'required'), 
        array('username' => 'Username','mobile_phone' => 'Phone Number', 'firstname' => 'First Name', 'lastname' => 'Last Name', 'sex' => 'Gender'));
        if (!$validate['error']) {
            $cnt = $this->doUpdate('userdata', $data, array('op', 'operation', 'nrfa-csrf-token-label'), array('username' => $data['username']));
            if ($cnt == 1) {
                return json_encode(array("response_code" => 0, "response_message" => 'Record saved successfully'));
            } else {
                return json_encode(array("response_code" => 78, "response_message" => 'No update was made'));
            }
        } else {
            return json_encode(array('response_code' => 13, 'response_message' => $validate['messages'][0]));
        }
    }
    public function saveUser($data)
    {
        $role_id = $data['role_id'];
        $data['parish_pastor'] = 1;
        $validation = array();

        if ($role_id == 003) {
            if ($data['parish_pastor'] == "1") {
                $validation = $this->validate(
                    $data,
                    array(
                        'church_id'    => 'required',
                        'bank_name'    => 'required',
                        'account_name' => 'required',
                        'account_no'   => 'required'
                    ),
                    array('account_no' => 'Account Number', 'account_name' => 'Account Name', 'bank_name' => 'Bank Name', 'church_id' => 'church')
                );
                if (!$validation['error']) {
                    if ($data['operation'] == "new") {
                        $sql = "SELECT username,firstname,lastname FROM userdata WHERE role_id = '003' AND parish_pastor='1' AND church_id = '$data[church_id]' LIMIT 1 ";
                        $resu = $this->db_query($sql);
                        if (count($resu) > 0) {
                            $church_name = $this->getitemlabel('church_table', 'church_id', $data['church_id'], 'church_name');
                            $pastor_name = $resu[0]['firstname'] . " " . $resu[0]['lastname'];
                            $validation['error'] = true;
                            $validation['messages'][0] = $church_name . " already has a parish pastor[" . $pastor_name . "] there can only be one parish pastor. ";
                        }
                    }
                }
            } else {
                $validation = $this->validate(
                    $data,
                    array(
                        'church_id'    => 'required'
                    ),
                    array('church_id' => 'church')
                );
            }
        } else {
            $validation['error'] = false;
        }

        if (!$validation['error']) {
            return $this->register($data);
        } else {
            return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
        }
    }
    public function workingDays($dbrow)
    {
        $days_of_week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $db_day       = array('day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7');
        $ddate        = date('w');
        $mssg         = array('code' => 0, 'mssg' => '');
        foreach ($days_of_week as $k => $v) {
            if ($dbrow[$db_day[$k]] == 0 && $ddate == $k) {
                $mssg = array("mssg" => "You are not allowed to login on $days_of_week[$k]", "code" => "44");
            }
        }
        if ($dbrow['passchg_logon'] == '1') {
            $mssg = array("mssg" => "You are required to change your password, follow this link to  <a href='change_psw_logon.php?username={$dbrow['username']}'> change password </a>", "code" => "44");
        }
        return $mssg;
    }
    public function emailPasswordReset($data)
    {
        $email = $data['email'];
        $today = @date("Y-m-d H:i:s");
        $pass_dateexpire = @date("Y-m-d H:i:s", strtotime($today . "+ 24 hours"));
        $upd = $this->db_query("UPDATE userdata SET pwd_expiry='" . $pass_dateexpire . "' WHERE username = '$email'");


        $recordBiodata = $this->getItemLabelArr('userdata', array('email'), array($email), '*');

        $fname = $recordBiodata['first_name'];
        $lname = $recordBiodata['last_name'];


        return json_encode(array("response_code" => 0, "response_message" => 'Check your mail'));
    }

    public function sackUser($data)
    {
        $username = $data['username'];
        $status   = ($data['status'] == 1) ? "0" : "1";
        $sql      = "UPDATE userdata SET status = '$status' WHERE username = '$username' LIMIT 1";
        $cc = $this->db_query($sql, false);
        if ($cc) {
            return json_encode(array('response_code' => 0, 'response_message' => 'Action on user profile is now effective'));
        } else {
            return json_encode(array('response_code' => 432, 'response_message' => 'Action failed'));
        }
    }
    public function notifyChurchUsers($church_id, array $roles, $msg, $notification_type = "email")
    {
        $usersContact = array();
        if ($notification_type == "email") {
            foreach ($roles as $role_value) {
                $sql    = "SELECT email FROM userdata WHERE church_id = '$church_id' AND role_id = '$role_value' ";
                $result = $this->db_query($sql);
                //                $usersContact[] = $result[0]['email'];
                //                $msg    = "Good Day Sir/Madam,\n The Accountant has just posted a collection, and needs your approval.\n Kindly login to the portal to approve collection";
                mail($result[0]['email'], "The Lord's Chosen Charismatic Revival Church::Approval Notification ", $msg);
            }
        } elseif ($notification_type == "sms") {
        }
    }
    public function changeUserStatus($data)
    {
        $username = $data['username'];
        $status = ($data['current_status'] == 1) ? 0 : 1;
        $sql = "UPDATE userdata SET user_disabled = '$status' WHERE username = '$username'";
        $this->db_query($sql, false);
        return json_encode(array("response_code" => 0, "response_message" => "updated successfully"));
    }

    public function doForgotPasswordChange($data)
    {
        $validation = $this->validate(
            $data,
            array(
                'username' => 'required',
                'password' => 'required|min:6',
                'confirm_password' => 'required|matches:password'
            ),
            array('username' => 'Username', 'password' => 'Password', 'confirm_password' => 'Current Password')
        );

        if (!$validation['error']) {
            $username      = $data['username'];
            $user_password = $data['password'];
            $key            = $username;
            $desencrypt             = new DESEncryption();
            $cipher_password = $desencrypt->des($key, $user_password, 1, 0, null, null);
            $str_cipher_password = $desencrypt->stringToHex($cipher_password);
            $query_data = "UPDATE userdata set password='$str_cipher_password', passchg_logon = '0', user_locked = '0' where username= '$username'";
            //                    echo $query_data;
            $result_data = $this->db_query($query_data, false);
            if ($result_data > 0) {
                return json_encode(array('response_code' => 0, 'response_message' => 'Your password was changed successfully'));
            } else {
                return json_encode(array('response_code' => 45, 'response_message' => 'Your password was changed successfully'));
            }
        } else {
            return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
        }
    }
    public function doPasswordChange($data)
    {
        $validation = $this->validate(
            $data,
            array(
                'username' => 'required',
                'current_password' => 'required',
                'password' => 'required|min:6',
                'confirm_password' => 'required|matches:password'
            ),
            array('confirm_password' => 'Confirm password', 'username' => 'Username', 'password' => 'User password', 'current_password' => 'Current Password')
        );
        if ($data['current_password'] == $data['password']) {
            $validation['error'] = true;
            $validation['messages'][0] = "Kindly choose a password that is different from your current one.";
        }
        if (!$validation['error']) {
            $username      = $data['username'];
            $user_password = $data['password'];
            $user_curr_password = $data['current_password'];

            $desencrypt = new DESEncryption();
            $key = $username;
            $cipher_password = $desencrypt->des($key, $user_curr_password, 1, 0, null, null);
            $str_cipher_password = $desencrypt->stringToHex($cipher_password);
            //                $str_cipher_password = $this->EncryptData($username,$user_password);
            $sql = "SELECT username FROM userdata WHERE username = '$username' AND password = '$str_cipher_password'";
            $rr  = $this->db_query($sql, false);
            if ($rr == 1) {

                $cipher_password = $desencrypt->des($key, $user_password, 1, 0, null, null);
                $str_cipher_password = $desencrypt->stringToHex($cipher_password);
                $query_data = "UPDATE userdata set password='$str_cipher_password', passchg_logon = '0' where username= '$username'";
                //                    echo $query_data;
                $result_data = $this->db_query($query_data, false);
                if ($result_data > 0) {
                    if ($data['page'] == 'first_login') {
                        return json_encode(array('response_code' => 0, 'response_message' => 'Your password was changed successfully... <a href="index.php">Proceed to login</a>'));
                    } else {
                        return json_encode(array('response_code' => 0, 'response_message' => 'Your password was changed successfully... logging you out'));
                    }
                } else {
                    return json_encode(array('response_code' => 45, 'response_message' => 'Your password could not be changed'));
                }
            } else {
                return json_encode(array('response_code' => 455, 'response_message' => 'current password is invalid'));
            }
        } else {
            return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
        }
    }
    public function passwordHash($secret)
    {
        $hashvalue = password_hash($secret, PASSWORD_DEFAULT);
        return $hashvalue;
        //		echo "<br/>".password_verify($secret,'$2y$10$s4N.5vNNy5iniEQ2Pycn.uE.OJJ69p.1eT9W6JOce7j9TAgzjrxJS');
        //		var_dump( password_get_info('$2y$10$s4N.5vNNy5iniEQ2Pycn.uE.OJJ69p.1eT9W6JOce7j9TAgzjrxJS') );
    }
}