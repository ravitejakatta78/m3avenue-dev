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

$usersid = $_REQUEST['usersid'];
if(!empty($usersid)){ 
$userdetails = runQuery("select * from employee where ID = '".$usersid."'");
	if(!empty($userdetails['ID'])){
		$action = mysqli_real_escape_string($conn,trim($_REQUEST['action']));
		if(!empty($action)){ 
			switch($action){
			    case 'profile':
			        	  $employeedetails = runQuery("select * from employee where ID = '".$userdetails['ID']."'");
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
						  if(!empty($customerdetails)){
						    $payload = array("status"=>'1',"employee"=>$customerdetails);    
						  }
						  else{
						      $payload = array("status"=>'1',"message" => 'No details found',"employee"=>[]);
						  }
				break;
                case 'track-work':
                    $sql = runloopQuery("SELECT * FROM track_work where employee_id = '".$userdetails['ID']."' order by ID desc");
                    $trackwork = $trackworkarray = array();
                    foreach($sql as $row)
                	{
                	    $trackwork["clientname"] =     $row["clientname"];
                        $trackwork["selecttype"] = $row["selecttype"];
                        $trackwork["mobile"] = $row["mobile"];
                        $trackwork["email"] = $row["email"];
                        $trackwork["amount"] = number_format((float)$row["amount"],2);
                        $trackwork["address"] = $row["address"];
                        $trackwork["remark"] = $row["remark"];
                        $trackwork["company"] = $row["company"];
                        $trackwork["income"] = number_format((float)$row["income"],2);
                        $trackwork["followup"] = date('d F Y',strtotime($row["followup"]));
                        $trackwork["assingedto"] = $row["assingedto"];
                        $trackwork["source"] = $row["source"];
                        $trackwork["reg_date"] = reg_date($row["reg_date"]); 
                        $trackworkarray[] = $trackwork;
                    }
                	if(!empty($trackworkarray)){
						    $payload = array("status"=>'1',"trackwork"=>$trackworkarray);    
						  }
						  else{
						      $payload = array("status"=>'1',"message" => 'No details found',"trackwork"=>[]);
						  }
                	break;
                	case 'assignedwork':
                    $sql = runloopQuery("SELECT * FROM track_work where assingedto = '".$userdetails['unique_id']."' order by ID desc");
                    $trackwork = $trackworkarray = array();
                    foreach($sql as $row)
                	{
                	    $trackwork["clientname"] =     $row["clientname"];
                        $trackwork["selecttype"] = $row["selecttype"];
                        $trackwork["mobile"] = $row["mobile"];
                        $trackwork["email"] = $row["email"];
                        $trackwork["amount"] = number_format((float)$row["amount"],2);
                        $trackwork["address"] = $row["address"];
                        $trackwork["remark"] = $row["remark"];
                        $trackwork["company"] = $row["company"];
                        $trackwork["income"] = number_format((float)$row["income"],2);
                        $trackwork["followup"] = date('d F Y',strtotime($row["followup"]));
                        $trackwork["assingedto"] = $row["assingedto"];
                        $trackwork["source"] = $row["source"];
                        $trackwork["reg_date"] = reg_date($row["reg_date"]); 
                        $trackworkarray[] = $trackwork;
                    
                	}
                	if(!empty($trackworkarray)){
						    $payload = array("status"=>'1',"trackwork"=>$trackworkarray);    
						  }
						  else{
						      $payload = array("status"=>'1',"message" => 'No details found',"trackwork"=>[]);
						  }
                	break;
                	case 'trackclients':
                    $sql = runloopQuery("SELECT * FROM clients where employee_id = '".$userdetails['ID']."' order by ID desc");
                    $trackclients = $trackclientsarray = array();
                    foreach($sql as $row)
                	{
                	    $trackclients["clientname"] =     $row["clientname"];
                        $trackclients["reg_date"] = reg_date($row["reg_date"]); 
                        $trackclients["mobile"] = $row["mobile"];
                        $trackclients["companyname"] = $row["companyname"];                        
                        $trackclients["bankname"] = $row["bankname"];
                        $trackclients["servicetype"] = $row["servicetype"];
                        $trackclients["status"] = $row["status"];
                       
                    $trackclientsarray[] = $trackclients;
                    
                	    
                	}
                	if(!empty($trackclientsarray)){
						    $payload = array("status"=>'1',"trackwork"=>$trackclientsarray);    
						  }
						  else{
						      $payload = array("status"=>'1',"message" => 'No details found',"trackwork"=>[]);
						  }
                	break;
                	case 'followup': 
    						if(!empty($_REQUEST['followup'])){
    							$datee = date('Y-m-d',strtotime($_REQUEST['followup']));
	    					}else{
		        				$datee = date('Y-m-d');
							}
                            $sql = runloopQuery("SELECT * FROM track_work where employee_id = '".$userdetails['ID']."' and followup >='".$datee."' and followup <='".$datee."'  order by ID desc");
                            $trackwork = $trackworkarray = array();
                            foreach($sql as $row)
                        	{
                        	    $trackwork["clientname"] =     $row["clientname"];
                                $trackwork["selecttype"] = $row["selecttype"];
                                $trackwork["mobile"] = $row["mobile"];
                                $trackwork["email"] = $row["email"];
                                $trackwork["amount"] = number_format((float)$row["amount"],2);
                                $trackwork["address"] = $row["address"];
                                $trackwork["remark"] = $row["remark"];
                                $trackwork["company"] = $row["company"];
                                $trackwork["income"] = number_format((float)$row["income"],2);
                                $trackwork["followup"] = date('d F Y',strtotime($row["followup"]));
                                $trackwork["reg_date"] = reg_date($row["reg_date"]); 
                                $trackworkarray[] = $trackwork;
                            
                        	}
                        	if(!empty($trackworkarray)){
					    	    $payload = array("status"=>'1',"trackwork"=>$trackworkarray);    
						    }
						    else{
						      $payload = array("status"=>'1',"message" => 'No details found',"trackwork"=>[]);
						    }

                	break;
                	case 'interestusers': 
					if(!empty($_REQUEST['name'])&&!empty($_REQUEST['selecttype'])&&!empty($_REQUEST['mobile'])&&!empty($_REQUEST['amount'])
					&&!empty($_REQUEST['address'])&&!empty($_REQUEST['income'])){
					    
							$pagerarray['employee_id'] = $userdetails['ID'];
							$pagerarray['clientname'] = mysqli_real_escape_string($conn,$_REQUEST['name']);
							$pagerarray['selecttype'] = mysqli_real_escape_string($conn,$_REQUEST['selecttype']);
							$pagerarray['mobile'] = mysqli_real_escape_string($conn,$_REQUEST['mobile']); 
							$pagerarray['email'] = mysqli_real_escape_string($conn,$_REQUEST['email']); 
							$pagerarray['amount'] = mysqli_real_escape_string($conn,$_REQUEST['amount']);
							$pagerarray['address'] = mysqli_real_escape_string($conn,$_REQUEST['address']);
							$pagerarray['company'] = mysqli_real_escape_string($conn,$_REQUEST['company']);
							$pagerarray['income'] = mysqli_real_escape_string($conn,$_REQUEST['income']); 
							$pagerarray['source'] = mysqli_real_escape_string($conn,$_REQUEST['source']);
							$pagerarray['status'] = 'Yes';
							$result = insertQuery($pagerarray,'track_work');
							if(!$result){
								$payload = array('status'=>'1','message'=>'Client updated');
							}else{
								$payload = array('status'=>'0','message'=>"Technical error found.");
							} 
					}else{
						$payload = array('status'=>'0','message'=>'Invalid Parameters.');
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