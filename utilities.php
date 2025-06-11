<?php
session_start();
$params = session_get_cookie_params();
setcookie("PHPSESSID", session_id(), 0, $params["path"], $params["domain"],
    true, 
    true 
);

if(!isset($_SESSION['username_sess']))
{
    header('location: logout.php');
}
if($_SESSION['username_sess'] == "")
{
    header('location: logout.php');
}

include_once("libs/dbfunctions.php");
include_once("libs/SecurityService.php");

$dbobject = new dbobject();

// if(isset($_REQUEST['nrfa-csrf-token-label'])){

//     $antiCSRF = new \NRFA\SecurityService\securityService();
//     $csrfResponse = json_decode($antiCSRF->validate(), true);

//     if ($csrfResponse['valid'] == false) {
//         echo json_encode(array('response_code' => 504, 'response_message' => $csrfResponse['response_message']));
//         exit;
//     }
// }

// $response = $dbobject->gateway($_REQUEST);
// $permission = (isset($response) ? json_decode($response, true) : []);
// // $permission = json_decode($response, true);
// if (isset($permission['response_code'])) {
//     echo json_encode(array('response_code' => $permission['response_code'], 'response_message' => $permission['response_message']));
//     exit;
// }


foreach (glob("class/*.php") as $filename) {
	include_once($filename);
}

// User.login
$op = $_REQUEST['op'];
//user.register
//$op =  $dbobject->DecryptData("pacific",$op);
$operation  = array();
$operation = explode(".", $op);


// getting data for the class method
$params = array();
$params = $_REQUEST;
$data = [$params];


//////////////////////////////
/// callling the method of  the class
$foo = new $operation[0];
echo call_user_func_array(array($foo, trim($operation[1])), $data);
//}else
//{
//	echo "invalid token";
//}