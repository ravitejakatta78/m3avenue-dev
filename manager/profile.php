<?php
session_start();
error_reporting(E_ALL);
include('../functions.php');
$userid = current_managerid();
if(empty($userid)){
	header("Location:profile.php");
	}
	$message = '';
$usedetails = runQuery("select * from manager where ID = '".$userid."'");
if(empty($userid)){
	header("Location: ../index.php");
}
if(!empty($_POST['submit'])){
          if(!empty($_POST['name'])){ 
					if(!empty($_POST['bankdetails'])){ 
					if(!empty($_POST['accntnum'])){ 
					if(!empty($_POST['ifsccode'])){ 
							 

			$m3avenuearray = array();
		
		
$m3avenuewherearray['ID']=$userid; 
$m3avenuearray['name']=mysqli_real_escape_string($conn,$_POST['name']);  
$m3avenuearray['ifsccode']=mysqli_real_escape_string($conn,$_POST['ifsccode']); 
$m3avenuearray['accntnum']=mysqli_real_escape_string($conn,$_POST['accntnum']); 
$m3avenuearray['bankdetails']=mysqli_real_escape_string($conn,$_POST['bankdetails']); 

			$result= updateQuery($m3avenuearray,'manager',$m3avenuewherearray);
			
 
if(!$result){

 
header("Location:profile.php?success=success");
}

		}else{
		$message .="Ifsc code is empty";
	}
	}else{
		$message .="Account number is empty";
	}
	}else{
		$message .="Bank details is empty";
	} 
	
	}else{
		$message .="Name field is empty";
	}
	
}

if(!empty($_POST['password-submit'])){
	if(!empty($_POST['new_pass'])){
		if(!empty($_POST['confirm_pass'])){
			if($_POST['new_pass']===$_POST['confirm_pass']){
				$newepass = mysqli_real_escape_string($conn,$_POST['new_pass']);
				$confirmepass = mysqli_real_escape_string($conn,$_POST['confirm_pass']);
				$id = $_POST['id'];
					$newpass = password_hash($newepass,PASSWORD_DEFAULT);
					$insert_sql = "update manager set password = '".$newpass."' where ID = $userid";
					if($conn->query($insert_sql)===TRUE){ 
						header("location: profile.php?password=Password Changed successfully");
						}else{
							$loginmessage .=$conn->error;
						}
					}else{
					$loginmessage .="Password mistach";
					}
				}else{
				$loginmessage .="please enter the confirm password";	
				}
			}else{	
			$loginmessage .="please enter the new password";	
			}	
		}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>M3 Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="../plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
   
    <div id="wrapper">
        <!-- Navigation -->
       <?php include('header.php');?>
        <!-- Left navbar-header end -->
		
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Profile page</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Profile page</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                       <div class="white-box">
						
                            <div class="user-bg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="img/m3-logo.png" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-black"> <?php echo ucwords($usedetails['name']);?></h4>
                                        <h5 class="text-black">User Id : <?php echo $usedetails['unique_id'];?></h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-12 col-sm-6 text-center">
									<h5 class="text-black"><span>Call: </span>  <?php echo $usedetails['mobile'];?></h5>
								</div>

								<div class="col-md-12 col-sm-6 text-center">
									<h5 class="text-black"><span>mail: </span>  <?php echo $usedetails['email'];?></h5>
								</div>								
							</div>
						</div>
						  <div class="white-box">
						  <div class="user-btm-box">
	<? if(!empty($_GET['password'])){?>

								<div class="alert alert-success">

								Password Updated Successfully

								</div>

								<? }?>

<h3>Change Password</h3>
                           <form  method="post" action="" enctype="multipart/form-data">
							 
									<div class="col-md-12">
								  <div class="form-group">
										<label>Password</label>
										<input type="password" name="new_pass"  class="form-control form-control-line"> 
										</div> 
								  <div class="form-group">
									<label >Confirm password</label> 
										<input type="password" name="confirm_pass" class="form-control form-control-line"> 
									</div>
								  <div class="form-group"> 
										<button name="password-submit" value="submit" class="btn btn-success">Submit</button>
									</div>
									</div>
									</form>
							
							</div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                          <? if(!empty($_GET['success'])){?>

								<div class="alert alert-success">

								Profile Details Added Successfully

								</div>

								<? }?>

								<? if(!empty($message)){?>

								<div class="alert alert-danger">

								<?=$message;?>

								</div>

								<? }?>

				  <form  method="post" action="" enctype="multipart/form-data">
								 
								  <div class="row"> 
								<div class="form-group col-md-6">
									<label class="col-md-12">Name (As Per Pancard)</label>
									<div class="col-md-12">
										<input type="text" name="name" value="<?php echo !empty($usedetails['name']) ? $usedetails['name'] : ''; ?>" class="form-control form-control-line"> </div>
									</div>  
								<div class="form-group col-md-6">
									<label for="example-email" class="col-md-12">Email</label>
									<div class="col-md-12">
										<input type="text"  class="form-control form-control-line" readonly name="email" value="<?php echo !empty($usedetails['email']) ? $usedetails['email'] : ''; ?>" readonly id="example-email"> </div>
								</div>
								<div class="form-group col-md-6">
									<label for="example-email" class="col-md-12">Mobile Number</label>
									<div class="col-md-12">
										<input type="text"  class="form-control form-control-line" readonly  name="mobile" value="<?php echo !empty($usedetails['mobile']) ? $usedetails['mobile'] : ''; ?>" id="example-email"> </div>
								</div>
								
								<div class="form-group col-md-6">
									<label for="example-email" class="col-md-12">Bank details</label>
									<div class="col-md-12">
										<input type="text" value="<?php echo !empty($usedetails['bankdetails']) ? $usedetails['bankdetails'] : ''; ?>" class="form-control form-control-line" name="bankdetails" id="example-email"> </div>
								</div> 
								<div class="form-group col-md-6">
									<label for="example-email" class="col-md-12">Account number</label>
									<div class="col-md-12">
										<input type="text" value="<?php echo !empty($usedetails['accntnum']) ? $usedetails['accntnum'] : ''; ?>" class="form-control form-control-line" name="accntnum" id="example-email"> </div>
								</div> 
								<div class="form-group col-md-6">
									<label for="example-email" class="col-md-12">Ifsccode</label>
									<div class="col-md-12">
										<input type="text" value="<?php echo !empty($usedetails['ifsccode']) ? $usedetails['ifsccode'] : ''; ?>" class="form-control form-control-line" name="ifsccode" id="example-email"> </div>
								</div> 
								<div class="form-group col-md-6">
									<div class="col-sm-6">
										<button class="btn btn-success" name="submit" value="submit">Update Profile</button>
									</div>
									<div class="col-sm-6">
										<button class="btn btn-success">Discard Changes</button>
									</div>
									
								</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
<?php include('footer.php');?>			
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>
