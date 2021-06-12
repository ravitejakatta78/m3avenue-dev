<?php

include('dbconfig.php');

date_default_timezone_set('Asia/Kolkata');

ini_set('display_errors', 'On');

ini_set('log_errors', 'On');

define('SITE_URL','https://m3avenue.com/');

define('EMPLOYEE_IMAGE',SITE_URL.'team/employeeimages/');
define('PAGE_URL',SITE_URL.'admin/');
define('MAILID','info@m3avenue.com');



function insertQuery($query,$table){

	include('dbconfig.php');

	$query['reg_date'] = date('Y-m-d H:i:s');

	$keys = array_keys($query);



$sql = "INSERT INTO ".$table." SET ";



for($e=0;$e<sizeof($keys);$e++) {



$sql .=  $keys[$e].'="'.$query[$keys[$e]].'"';



if($e != sizeof($keys)-1) { $sql .= ','; }



}

//echo $sql;exit;

$result = mysqli_query($conn,$sql);

if(!$result) {

	return $conn->error;

}

}


function insertIDQuery($query,$table){

	include('dbconfig.php');

	$query['reg_date'] = date('Y-m-d H:i:s');

	$keys = array_keys($query);



$sql = "INSERT INTO ".$table." SET ";



for($e=0;$e<sizeof($keys);$e++) {



$sql .=  $keys[$e].'="'.$query[$keys[$e]].'"';



if($e != sizeof($keys)-1) { $sql .= ','; }



}



$result = mysqli_query($conn,$sql);

if($result) {

	return $conn->insert_id;

}

}



function updateQuery($query,$table,$wherec){

	include('dbconfig.php');

	

	$arr_keys = array_keys( $query );

	

	$second_arr_keys = array_keys( $wherec );

	

	$sql = "UPDATE ".$table." SET ";

	

	for($y=0;$y<sizeof($arr_keys);$y++) {

		

		$sql .=  $arr_keys[$y].' = "'.$query[$arr_keys[$y]].'"';



        if($y != sizeof($arr_keys)-1) { $sql .= ','; }

		

	}

	

	$sql .= " WHERE ";

	

	for($x=0;$x<sizeof($second_arr_keys);$x++) {

		

		$sql .=  $second_arr_keys[$x].'="'.$wherec[$second_arr_keys[$x]].'"';



        if($x != sizeof($second_arr_keys)-1) { $sql .= ' AND '; }

		

	}

	$result = mysqli_query($conn,$sql);



	if(!$result) {

return $conn->error;

	}
}

function deleteQuery($wherec,$table){

	include('dbconfig.php');

 $second_arr_keys = array_keys( $wherec );



        $sql = "DELETE FROM ".$table." ";



        $sql .= " WHERE ";



        for($x=0;$x<sizeof($second_arr_keys);$x++) {



            $sql .=  $second_arr_keys[$x].'="'.$wherec[$second_arr_keys[$x]].'"';



            if($x != sizeof($second_arr_keys)-1) { $sql .= ' AND '; }



        }

$result = mysqli_query($conn,$sql);

     

	if(!$result) {



		return $conn->error;

	}

    }

function runQuery($query){

	include('dbconfig.php');

$data = array();

$result = $conn->query($query);



    // output data of each row

    while($row = $result->fetch_assoc()) {

       $data = $row;

    }

      return $data;

}

function runloopQuery($query){

	include('dbconfig.php');

$data = array();

$result = $conn->query($query);



    // output data of each row

    while($row = $result->fetch_assoc()) {

       $data[] = $row;

    }

      return $data;

}

function filter_string($string){

	$string = preg_replace('/\s+/', '-', $string);

	return $string;

}

function unfilter_string($string){

	$string = preg_replace('/-+/', ' ', $string);

	return $string;

}

function current_adminid(){

	$value = "";

if(!empty($_SESSION['m3avenue_adminid'])){

	return $value = $_SESSION['m3avenue_adminid'] ?: "";

	

}

}

function user_adminrole(){

	$value = "";

if(!empty($_SESSION['m3avenue_adminrole'])){

	return $value = $_SESSION['m3avenue_adminrole'] ?: "";

}

}


function current_employeeid(){

	$value = "";
if(!empty($_SESSION['m3avenue_employeeid'])){

	return $value = $_SESSION['m3avenue_employeeid'] ?: "";

	

}

}
function current_teammemberid(){

	$value = "";

if(!empty($_SESSION['m3avenue_teammemberid'])){

	return $value = $_SESSION['m3avenue_teammemberid'] ?: "";

}

}

function current_managerid(){

	$value = "";

if(!empty($_SESSION['m3avenue_managerid'])){

	return $value = $_SESSION['m3avenue_managerid'] ?: "";

}

}

function current_userid(){

	$value = "";

if(!empty($_SESSION['m3avenue_id'])){

	return $value = $_SESSION['m3avenue_id'] ?: "";

	}

}

function user_role(){

	$value = "";

if(!empty($_SESSION['m3avenue_role'])){

	return $value = $_SESSION['m3avenue_role'] ?: "";
}

}
function reg_date($date){
	return date('d/m/Y H:i:s',strtotime($date));
}

$admindata = runQuery("select ID from superadmin where email='info@m3avenue.com'");

if(empty($admindata)){

$password = password_hash("123456", PASSWORD_DEFAULT);

mysqli_query($conn,"insert into superadmin (username,email,password,reg_date) values('m3avenue','info@m3avenue.com','".$password."','".date('Y-m-d H:i:s')."')");

}

function get_option($optionname){

include("dbconfig.php");

$optionvalue = runQuery("select option_value from options where option_name='".$optionname."'");
if(!empty($optionvalue['option_value'])){
return $optionvalue['option_value'];

}
}

function update_option($optionname,$newdata){

include("dbconfig.php");

$optionvalue = runQuery("select ID from options where option_name='".$optionname."'");

if(!empty($optionvalue['ID'])){

mysqli_query($conn,"update options set option_value = '".$newdata."' where ID = ".$optionvalue['ID']."");

}else{

mysqli_query($conn,"insert into options (option_name,option_value)values('".$optionname."','".$newdata."')");

}

}

function get_campaignuser_options($campaignuserid,$optionname){

include("dbconfig.php");

$optionvalue = runQuery("select value from campaign_options where name='".$optionname."' and user_id='".$campaignuserid."'");
if(!empty($optionvalue['value'])){
return $optionvalue['value'];

}
}

function update_campaignuser_options($campaignuserid,$optionname,$newdata){

include("dbconfig.php");

$optionvalue = runQuery("select ID from campaign_options where name='".$optionname."' and user_id = '".$campaignuserid."'");

if(!empty($optionvalue['ID'])){

mysqli_query($conn,"update campaign_options set value = '".$newdata."' where ID = ".$optionvalue['ID']."");

}else{

mysqli_query($conn,"insert into campaign_options (user_id,name,value,reg_date)values('".$campaignuserid."','".$optionname."','".$newdata."','".date('Y-m-d H:i:s')."')");

}

}
 

function user_status(){

	include('dbconfig.php');

	$userid =   current_adminid();

	$user_role = user_adminrole();

		if($user_role){

			$table = $user_role=='superadmin' ? 'superadmin' : 'user';

		$student_name = runQuery("select status from $table where ID = $userid");

		$name = $student_name['status'];

		 

		if($name=='Active'){

	return $name;

		} 

		}

}
function encrypt($string) {
	$action= 'encrypt';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
function decrypt($string) {
    $output = false;
	$action= 'decrypt';
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
function admin_id($id,$role=false){

	include('dbconfig.php');

	$userid =   $id;

	$user_role = $role ?: 'student';

		$adminid = runQuery("select user_id,user_role from user where role='".$user_role."' and ID = ".$userid."");

		$name = $adminid['user_role']=='admin' ? $adminid['user_id'] : '';

	return $name;

}

function lecturer_id($id=false){

	include('dbconfig.php');

	$userid =   $id ?: current_userid();

	$user_role = user_role();

		$adminid = runQuery("select user_id from user where role='student' and ID = $userid");

		$name = $adminid['user_id'];

		 $lecturerid = runloopQuery("select ID from user where role='lecturer' and user_id = $name and user_role = 'admin'");

		$lecturer = array_column($lecturerid, 'ID');

		

	return implode(',',$lecturer);

}

function user_image($id=false){

	include('dbconfig.php');

	$userid =   $id ?: current_userid();

	$user_role = user_role();

		if(!empty($userid)){

			 $lecturer_name = runQuery("select profilepic,role from user where ID = $userid");

		

		if($lecturer_name['profilepic']){

			if($lecturer_name['role']=='student'){

			$name = SITE_URL.$lecturer_name['profilepic'];

				

			}else{

			$name = PAGE_URL.$lecturer_name['profilepic'];

				

			}

		}else{

			$name = SITE_URL.'images/studentimage.jpeg';

		}

	}else{

		$name = SITE_URL.'images/studentimage.jpeg';

	}

	return $name;

}
function executive_image($id=false){

	include('dbconfig.php');

	$userid =   $id ?: current_userid();

	$user_role = user_role();

		if(!empty($userid)){

			 $lecturer_name = runQuery("select profilepic from executive where ID = $userid");
 
		if($lecturer_name['profilepic']){
 
			$name = SITE_URL.'executiveimage/'.$lecturer_name['profilepic'];
 
		}else{

			$name = SITE_URL.'images/studentimage.jpeg';

		}

	}else{

		$name = SITE_URL.'images/studentimage.jpeg';

	}

	return $name;

}

function employee_id($unique_id){

	include('dbconfig.php');
 $name = '';
		if(!empty($unique_id)){
 
		$student_name = runQuery("select ID from employee where unique_id = '".$unique_id."'");
		if(!empty($student_name['ID'])){
		$name = $student_name['ID'];
		} 
		} 
	return $name;

}
function user_id($unique_id){

	include('dbconfig.php');
 
		if(!empty($unique_id)){
 
		$student_name = runQuery("select ID from user where unique_id = '".$unique_id."'");

		$name = $student_name['ID'];
 

		}

	return $name;

}
function employee_details($id,$type){

	include('dbconfig.php');
 
		if(!empty($id)){
 
		$student_name = runQuery("select * from employee where ID = $id");

		$name = $student_name[$type];
 

		}

	return $name;

}
function user_details($id,$type){

	include('dbconfig.php');
 $name='';
		if(!empty($id)){
 
		$student_name = runQuery("select * from user where ID = $id");
		if(!empty($student_name[$type])){
		$name = $student_name[$type];
		} 
		}

	return $name;

}
function campaign_details($id,$type){

	include('dbconfig.php');
 $name='';
		if(!empty($id)){ 
		$student_name = runQuery("select * from campaigns where ID = $id");
		if(!empty($student_name[$type])){
		$name = $student_name[$type];
		} 
		}

	return $name;

}
function pointset_details($id,$type){

	include('dbconfig.php');
 $name='';
		if(!empty($id)){ 
		$student_name = runQuery("select * from pointset where ID = $id");
		if(!empty($student_name[$type])){
		$name = $student_name[$type];
		} 
		} 
	return $name;

}

function user_email($id=false){

	include('dbconfig.php');

	$userid =   $id ?: current_userid();

	$user_role = $role ?: user_role();

		if(!empty($userid)){

		$student_name = runQuery("select email from user where ID = $userid");

		$name = $student_name['email'];

	return $name;

	 }

}
function manager_details($userid,$type){

	include('dbconfig.php'); 

		if(!empty($userid)){

		$student_name = runQuery("select * from manager where ID = $userid");

		$name = $student_name[$type];

	return $name;

	 }

}

function user_mobile($id=false){

	include('dbconfig.php');

	$userid =   $id ?: current_userid();

	$user_role = $role ?: user_role();

		if(!empty($userid)){

		$student_name = runQuery("select mobilenumber from user where ID = $userid");

		$name = $student_name['mobilenumber'];

	return $name;

	 }

}
function status_details($status){
 $value= '';
	 switch($status){
		 case '0':
		 $value= 'Pending';
		 break;
		 case '1':
		 $value = 'Active';
		 break;
		 case '2':
		 $value = 'In active';
		 break;
	 } 
	 return  $value;
}
function feedbackstatus($status){
 $value= '';
	 switch($status){ 
		 case '1':
		 $value = 'Interested';
		 break;
		 case '2':
		 $value = 'Not Interested';
		 break;
		 case '3':
		 $value = 'Switched OFF';
		 break;
		 case '4':
		 $value = 'Not Lifting';
		 break;
		 case '5':
		 $value = 'Call Back';
		 break;
		 case '6':
		 $value = 'Not Reachable';
		 break;
		 case '8':
		 $value = 'Not Working';
		 break;
		 case '9':
		 $value = 'Invalid Number';
		 break;
	 } 
	 return  $value;
}

function home_page(){

	include('dbconfig.php');

	$userid = current_userid();

	if(!empty($userid)){

	$user_role = user_role();

		if($user_role=='superadmin'){

			$page = "superadmin-dashboard.php";

		}elseif($user_role=='admin'){

			$page = "admin-dashboard.php";

		}elseif($user_role=='lecturer'){

			$page = "add-course.php";

		}elseif($user_role=='student'){

			$page = "user-exam-instacks.php";

		}

		}else{

			$page = SITE_URL.'index.php';

		}

	return $page;

}

function unique_id(){

	include('dbconfig.php');

	$userid = current_userid();

	$user_role = user_role();

	if($userid){

		$lecturer_name = runQuery("select unique_id from user where ID = $userid");

		$name = $lecturer_name['unique_id'];

	return $name;

	}

}

function txn_id(){

	include('dbconfig.php');

		$lecturer_name = runQuery("select MAX(ID) as id from transactions");

		$id = $lecturer_name['id']+1;

		$name = "INSTXN".$id;

	return $name;

}


function wallet($uid=false,$urole=false){

	include('dbconfig.php');

	$userid = $uid ?: current_userid();

	$user_role = $urole ?: user_role();

	$walletamt = runQuery("select amount from wallet where user_id = ".$userid." and user_role='".$user_role."'");

	return (int)$walletamt['amount'] ?: 0;

}

function wallet_update($id=false,$role=false,$amt){

	include('dbconfig.php');

	$userid = $id ?: current_userid();

	$user_role = $role ?: user_role();

	$amt = (int)$amt;

	$wallet_amt = runQuery("select * from wallet where user_id = ".$userid." and user_role = '".$user_role."'");

	if(!empty($wallet_amt['ID'])){

		$total_amt = (int)$wallet_amt['amount'] + $amt;

		$result = mysqli_query($conn,"update wallet set amount = ".$total_amt." where ID = ".$wallet_amt['ID']."");

	}else{

		$result =  mysqli_query($conn,"insert into wallet (user_id,user_role,amount,reg_date)values(".$userid.",'".$user_role."',".$amt.",'".date('Y-m-d H:i:s')."')");

	}

	if(!$result){

	echo $conn->error;

	}

}

function wallet_deduct($id=false,$role=false,$amt){

	include('dbconfig.php');

	$userid = $id ?: current_userid();

	$user_role = $role ?: user_role();

	$wallet_amt = runQuery("select * from wallet where user_id = ".$userid." and user_role = '".$user_role."'");

	if(!empty($wallet_amt['ID'])){

		if((int)$wallet_amt['amount']>=$amt){

		$amount = $wallet_amt['amount'] - $amt;

		mysqli_query($conn,"update wallet set amount = ".$amount." where ID = ".$wallet_amt['ID']."");

		}else{

		$message = 'Insufficient funds';

		return $message;

		}

	}else{

		$message = 'Wallet amt does not exits';

		return $message;

	}

}

function referralamount($uid=false,$urole=false){

	include('dbconfig.php');

	$userid = $uid ?: current_userid();

	$user_role = $urole ?: user_role();

	$referralamount = runQuery("select amount from referralamount where user_id = ".$userid." and user_role='".$user_role."'");

	return (int)$referralamount['amount'] ?: 0;

}

function referralamount_update($id=false,$role=false,$amt){

	include('dbconfig.php');

	$userid = $id ?: current_userid();

	$user_role = $role ?: user_role();

	$amt = (int)$amt;

	$referral_amt = runQuery("select * from referralamount where user_id = ".$userid." and user_role = '".$user_role."'");

	if(!empty($referral_amt['ID'])){

		$total_amt = (int)$referral_amt['amount'] + $amt;

		$result = mysqli_query($conn,"update referralamount set amount = ".$total_amt." where ID = ".$referral_amt['ID']."");

	}else{

		$result =  mysqli_query($conn,"insert into referralamount (user_id,user_role,amount,reg_date)values(".$userid.",'".$user_role."',".$amt.",'".date('Y-m-d H:i:s')."')");

	}

	if(!$result){

	echo $conn->error;

	}

}

function referralamount_deduct($id=false,$role=false,$amt){

	include('dbconfig.php');

	$userid = $id ?: current_userid();

	$user_role = $role ?: user_role();

	$referral_amt = runQuery("select * from referralamount where user_id = ".$userid." and user_role = '".$user_role."'");

	if(!empty($referral_amt['ID'])){

		if((int)$referral_amt['amount']>=$amt){

		$amount = $referral_amt['amount'] - $amt;

		mysqli_query($conn,"update referralamount set amount = ".$amount." where ID = ".$referral_amt['ID']."");

		}else{

		$message = 'Insufficient funds';

		return $message;

		}

	}else{

		$message = 'referralamount amt does not exits';

		return $message;

	}

}
function points($amount,$pointstype=false){
	include('dbconfig.php');
	$value = 0;
	if(!empty($pointstype)){
		$pointsarray = runQuery("select * from pointset where ID = '".$pointstype."'");
		if($pointsarray){
				$cutofamount = (int)$pointsarray['amount'];
			if($amount>0&&$amount<$cutofamount){
			$value = 1;
			}else{ 
			$value = ceil($amount/$cutofamount);
			}
		}
	}
	return $value;
}

function getUserIP()

{

    $client  = @$_SERVER['HTTP_CLIENT_IP'];

    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];

    $remote  = $_SERVER['REMOTE_ADDR'];



    if(filter_var($client, FILTER_VALIDATE_IP))

    {

        $ip = $client;

    }

    elseif(filter_var($forward, FILTER_VALIDATE_IP))

    {

        $ip = $forward;

    }

    else

    {

        $ip = $remote;

    }



    return $ip;

}
 
function limit_words($string) {

	$string = strip_tags($string);

	$words = explode(' ', strip_tags($string));

	$return = trim(implode(' ', array_slice($words, 0, 10)));

	if(strlen($return) < strlen($string)){

	$return .= '...';

	}

	return $return;

}
 function m3admin_nav($page,$total,$per_page,$getarray=false){
						
include('dbconfig.php');
	$adjacents = "2"; 
	 
	$prevlabel = "&lsaquo; Prev";
	$nextlabel = "Next &rsaquo;";
	$lastlabel = "Last &rsaquo;&rsaquo;";
	 
	$page = ($page == 0 ? 1 : $page);  
	$start = ($page - 1) * $per_page;                               
	 
	$prev = $page - 1;                          
	$next = $page + 1;
	 
	$lastpage = ceil($total/$per_page);
	 
	$lpm1 = $lastpage - 1; // //last page minus 1
	 
	$pagination = "";
	if($lastpage > 1){   
			   $pagination.='<ul class="pagination">';
			 
			if ($page > 1) $pagination.= "<li class='page-item'><a class='page-link' href='?page={$prev}' aria-label='Previous'><i class='fa fa-angle-left'></i> {$prevlabel}</a></li>";
			 
		if ($lastpage < 7 + ($adjacents * 2)){   
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page)
					$pagination.= "<li class='page-item active'><a class='page-link' ><span>{$counter}</span></a></li>";
				else
					$pagination.= "<li class='page-item'><a class='page-link' href='?page={$counter}'><span>{$counter}</span></a></li>";                    
			}
		 
		} elseif($lastpage > 5 + ($adjacents * 2)){
			 
			if($page < 1 + ($adjacents * 2)) {
				 
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $page)
						$pagination.= "<li class='page-item active'><a class='page-link' ><span>{$counter}</span></a></li>";
					else
						$pagination.= "<li class='page-item' ><a class='page-link'  href='?page={$counter}'><span>{$counter}</span></a></li>";                    
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$lpm1}'><span>{$lpm1}</span></a></li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$lastpage}'><span>{$lastpage}</span></a></li>";  
					 
			} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				 
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page=1'><span>1</span></a></li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page=2'><span>2</span></a></li>";
				$pagination.= "<li class='page-item dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination.= "<li class='active'><a class='page-link'><span>{$counter}</span></a></li>";
					else
						$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$counter}'><span>{$counter}</span></a></li>";                    
				}
				$pagination.= "<li class='page-item dot'>..</li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$lpm1}'><span>{$lpm1}</span></a></li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$lastpage}'><span>{$lastpage}</span></a></li>";      
				 
			} else {
				 
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page=1'><span>1</span></a></li>";
				$pagination.= "<li class='page-item' ><a class='page-link' href='?page=2'><span>2</span></a></li>";
				$pagination.= "<li class='page-item dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination.= "<li class='page-item active' ><a class='page-link' ><span>{$counter}</span></a></li>";
					else
						$pagination.= "<li class='page-item' ><a class='page-link' href='?page={$counter}'><span>{$counter}</span></a></li>";                    
				}
			}
		}
		 
			if ($page < $counter - 1) {
				$pagination.= "<li class='page-item'><a class='page-link' href='?page={$next}' aria-label='Previous'><i class='fa fa-angle-right'></i> {$nextlabel}</a></li>";
			}
			   $pagination.='</ul>';
	}
	 echo $pagination;


		
		}      

?>