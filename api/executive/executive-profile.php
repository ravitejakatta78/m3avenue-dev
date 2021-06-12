<?php
include("../../functions.php");
header("Access-Control-Allow-Origin: ".SITE_URL."api/executive/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../core.php");
include('../../inc/php-jwt-master/src/BeforeValidException.php');
include('../../inc/php-jwt-master/src/ExpiredException.php');
include('../../inc/php-jwt-master/src/SignatureInvalidException.php');
include('../../inc/php-jwt-master/src/JWT.php');
use \Firebase\JWT\JWT;
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json'); 
 
function validate_users($jwttoken){
	
$key = "m3avenue_key";
	if($jwttoken){
 
    // if decode succeed, show user details
    try { 
        $decoded = JWT::decode($jwttoken, $key, array('HS256'));
 
        // set response code
        
  
         return $decoded->data->id;
 
    }
 
	   catch (Exception $e){
	 
			// set response code
			http_response_code(401);
			//echo $e->getMessage();
		}
	}
}
$headerslist = apache_request_headers();
//$usersid = validate_users($headerslist['Authorization']);
$usersid = $_REQUEST['usersid'];
if(!empty($usersid)){ 
$userdetails = runQuery("select * from executive where ID = '".$usersid."'");
	if(!empty($userdetails['ID'])){
		$action = mysqli_real_escape_string($conn,trim($_REQUEST['action']));
		if(!empty($action)){ 
			switch($action){ 
			case 'password':
						if(!empty($_POST['password'])){ 
							$userwherearray = $userarray = array();
							$userarray['password'] = password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
							$userwherearray['ID'] = $userdetails['ID'];
								$result = updateQuery($userarray,'executive',$userwherearray);
								if(!$result){ 
									
									$payload = array("status"=>'1',"text"=>"Password has been updated.");
								}else{
									
									$payload = array("status"=>'0',"text"=>$result);
								} 
							}else{
									
								$payload = array("status"=>'0',"text"=>"Please enter the password");
							}
							
				break;
				case 'pushid':
					if(!empty($_POST['pushid'])){ 
						$userwherearray = $userarray = array();
						$userarray['push_id'] =  $_POST['pushid'];
						$userwherearray['ID'] = $userdetails['ID'];
							$result = updateQuery($userarray,'executive',$userwherearray);
							if(!$result){ 
								
								$payload = array("status"=>'1',"text"=>"Push id has been updated.");
							}else{
								
								$payload = array("status"=>'0',"text"=>$result);
							} 
						}else{
								
							$payload = array("status"=>'0',"text"=>"Please enter the password");
						} 	
				break;
				case 'updation':
					if(!empty($_POST['name'])&&!empty($_POST['email'])&&!empty($_POST['mobile'])){ 
						$userarray = $userwherearray = array();
						$userwherearray['ID'] = $userdetails['ID'];
						$userarray['name'] = mysqli_real_escape_string($conn,trim($_POST['name']));
						$userarray['email'] =  mysqli_real_escape_string($conn,trim($_POST['email']));
						$userarray['mobile'] =  mysqli_real_escape_string($conn,trim($_POST['mobile']));
						
						$row = runQuery("SELECT * FROM executive WHERE email = '".$userarray['email']."' and ID <> '".$userdetails['ID']."'");
					if(empty($row['ID'])){
						$row = runQuery("SELECT * FROM executive WHERE mobile = '".$userarray['mobile']."' and ID <> '".$userdetails['ID']."'");
							if(empty($row['ID'])){  
							
							$result = updateQuery($userarray,'executive',$userwherearray); 
								if(!$result){ 
											
									$payload = array("status"=>'1',"text"=>"Account has been updated");
								}else{
											
									$payload = array("status"=>'1',"text"=>$result);
								}  
						}else{
									
					$payload = array("status"=>'0',"text"=>"Mobile already exists please try another");
						}
					}else{
									
						$payload = array("status"=>'0',"text"=>"Email already exists please try another");
					}
					
					}else{
									
						$payload = array('status'=>'0','message'=>'Invalid Parameters');
					}
				break; 
				case 'executive': 
						  if(!empty($userdetails['ID'])){  
						  $customerdetails = array();
						  $customerdetails['id'] =  $userdetails['ID'];
						  $customerdetails['unique_id'] =  $userdetails['unique_id'];
						  $customerdetails['name'] =  $userdetails['name'];
						  $customerdetails['email'] =  $userdetails['email'];
						  $customerdetails['mobile'] =  $userdetails['mobile']; 
						  $customerdetails['location'] =  $userdetails['location'];
						  $customerdetails['profilepic'] =  executive_image($userdetails['ID']); 
						  if(!empty($userdetails['employee_id'])){
							  $employeedetails = runQuery("select * from employee where ID = '".$userdetails['employee_id']."'");
						  $customerdetails['unique_id'] =  $employeedetails['unique_id'];
						  $customerdetails['leader'] =  $employeedetails['leader'];
						  $customerdetails['fname'] =  $employeedetails['fname'];
						  $customerdetails['lname'] =  $employeedetails['lname'];
						  $customerdetails['employeeemail'] =  $employeedetails['email'];
						  $customerdetails['employeemobile'] =  $employeedetails['mobile'];
						  $customerdetails['bankdetails'] =  $employeedetails['bankdetails'];
						  $customerdetails['accntnum'] =  $employeedetails['accntnum'];
						  $customerdetails['pannum'] =  $employeedetails['pannum'];
						  $customerdetails['dob'] =  $employeedetails['dob']; 
						  $customerdetails['marital_status'] =  $employeedetails['marital_status']; 
						  $customerdetails['occuption'] =  $employeedetails['occuption']; 
						  $customerdetails['income'] =  $employeedetails['income']; 
						  $customerdetails['emergency_contact'] =  $employeedetails['emergency_contact']; 
						  $customerdetails['gender'] =  $employeedetails['gender'];  
						  }
						 $currentdate = date('Y-m');
						$campaignlistid = runQuery("select count(*) as count from campaigns where find_in_set('".$userdetails['ID']."',executive) order by ID asc");
						  $customerdetails['assignedcampaings'] =  !empty($campaignlistid['count']) ? $campaignlistid['count'] : 0;
						$campaigncalls = runQuery("select count(*) as count from campaigns_users where executive_id = '".$userdetails['ID']."' and reg_date >='".$currentdate."-01 00:00:01'and reg_date <='".$currentdate."-31 23:59:59' order by ID asc");
						  $customerdetails['totalcalls'] =  !empty($campaigncalls['count']) ? $campaigncalls['count'] : 0;
						$campaignlistid = runQuery("select count(*) as count from campaigns_users where executive_id = '".$userdetails['ID']."' and callstatus = '1' and reg_date >='".$currentdate."-01 00:00:01'and reg_date <='".$currentdate."-31 23:59:59' order by ID asc");
						  $customerdetails['totalinterested'] =  !empty($campaignlistid['count']) ? $campaignlistid['count'] : 0; 
							$payload = array("status"=>'1',"executive"=>$customerdetails);
						 
					  }else{
							$payload = array("status"=>'0',"text"=>"Invalid executive id");
					  }
				break;
				case 'updatepassword':
					  if(!empty($_REQUEST['usersid'])&&!empty($_REQUEST['password'])){
					  $customer_id = validate_users($_REQUEST['usersid']); 
					  $row = runQuery("SELECT * FROM executive WHERE ID = '".$customer_id."'");
					  if(!empty($row['ID'])){
					$userarray = $userwherearray = array();
							$userwherearray['ID'] = $row['ID'];
				  
							$userarray['password'] = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);
							$result = updateQuery($userarray,'customers',$userwherearray);
							if(!$result){
								
								$payload = array("status"=>'1',"text"=>"Password updated");
								}else{
								
								$payload = array("status"=>'0',"text"=>"Technical issue araised");
							}
				  }else{
								
						$payload = array("status"=>'0',"text"=>"Invalid users");
				  }
				  }else{
								
						$payload = array("status"=>'0',"text"=>"Invalid parameters");
				  }
				break;
				
				case 'updateprofilepic':
					    if(!empty($userdetails['ID'])){  
						  $productarray =  $productwherearray = array(); 
						  	if (!file_exists('../../executiveimage')) {	
									mkdir('../../executiveimage', 0777, true);	
									}																			
								$target_dir = '../../executiveimage/';	 
									$file = $_FILES['profilepic']['name'];
									if($file){
										$extn = pathinfo($file, PATHINFO_EXTENSION);
											$filename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$extn;	
									$target_file = $target_dir.$filename;
										 
									if (move_uploaded_file($_FILES['profilepic']["tmp_name"], $target_file)){			 
										$productarray['profilepic'] =$filename;
										 
									}  
									}  
									 $productwherearray['ID'] =  $userdetails['ID'];
								$result = updateQuery($productarray,'executive',$productwherearray);
							$payload = array("status"=>'1',"text"=>"Profilepic updated","profilepic"=>executive_image($userdetails['ID']));
						 
					  }else{
							$payload = array("status"=>'0',"text"=>"Invalid users id");
					  }
				break;
				default:
				$payload = array('status'=>'0','message'=>'Please specify a valid action');
				break;
			}
		}else{
			$payload = array('status'=>'0','message'=>'Please specify a valid action');
		}
	}else{
	
	$payload = array("status"=>'0',"text"=>"Invalid user");
	}
}else{
	 
	$payload = array('status'=>'0','message'=>'Invalid users details');
}
echo json_encode($payload);
?>