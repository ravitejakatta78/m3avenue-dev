<?php

session_start();

error_reporting(E_ALL);

include('../functions.php');
 
$userid = current_managerid(); 

if(empty($userid)){

	header("Location: index.php");

}
$executivedetails = runQuery("select * from executive where ID = '".$_GET['edit']."'");
$message = '';
if(!empty($_POST['submit'])){
			if(!empty($_POST['name'])){
	   $pagerarray  = array();

		  if (!file_exists('../executiveimage')) {	
		mkdir('../executiveimage', 0777, true);	
		}
	    $target_dir = '../executiveimage/';									

			 if(!empty($_FILES["panimg"]['name'])){
		$file = $_FILES["panimg"]['name'];				
		$target_file = $target_dir . strtolower($file);		

		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);								

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" )

			{
		$message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
		$uploadOk = 0;						
		}
	    if ($uploadOk == 0) {			
		$message .= "Sorry, your file was not uploaded.";		
		} else {
			if (move_uploaded_file($_FILES["panimg"]["tmp_name"], $target_file)){				
				$pagerarray['panimg'] = strtolower($file);						
				} else {
					$message .= "Sorry, There Was an Error Uploading Your File.";			
					}
				}
				}
			 if(!empty($_FILES["adhaarimg"]['name'])){
		$file = $_FILES["adhaarimg"]['name'];				
		$target_file = $target_dir . strtolower($file);		

		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);								

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" )

			{
		$message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
		$uploadOk = 0;						
		}
	    if ($uploadOk == 0) {			
		$message .= "Sorry, your file was not uploaded.";		
		} else {
			if (move_uploaded_file($_FILES["adhaarimg"]["tmp_name"], $target_file)){				
				$pagerarray['adhaarimg'] = strtolower($file);						
				} else {
					$message .= "Sorry, There Was an Error Uploading Your File.";			
					}
				} 
				} 
				$pagewererarray['ID'] = $executivedetails['ID'];  
                $pagerarray['user_id'] = $userid; 
                $pagerarray['user_role'] = 'manager'; 
                $pagerarray['name'] = mysqli_real_escape_string($conn,$_POST['name']);   
                $pagerarray['email'] = mysqli_real_escape_string($conn,$_POST['email']); 
                $pagerarray['mobile'] = mysqli_real_escape_string($conn,$_POST['mobile']); 
                $pagerarray['location'] = mysqli_real_escape_string($conn,$_POST['location']);  
                $pagerarray['status'] = mysqli_real_escape_string($conn,$_POST['status']); 
	            $result = updateQuery($pagerarray,'executive',$pagewererarray);
				if(!$result){
					header("Location: executive-list.php?success=success");
                    }
	    
		 	}else{

		$message .=" First Name Field is Empty";

	}

}

if(!empty($_POST['password-submit'])){
					if(!empty($_POST['new_pass'])){
						if(!empty($_POST['confirm_pass'])){
							if($_POST['new_pass']===$_POST['confirm_pass']){
								$newepass = mysqli_real_escape_string($conn,$_POST['new_pass']);
								$confirmepass = mysqli_real_escape_string($conn,$_POST['confirm_pass']);
								$id = $executivedetails['ID'];
									$newpass = password_hash($newepass,PASSWORD_DEFAULT);
									$insert_sql = "update executive set password = '".$newpass."' where ID = $id";
									if($conn->query($insert_sql)===TRUE){ 
										header("location: executive-list.php?psuccess=Password Changed successfully");
										}else{
											$message .=$conn->error;
										}
									}else{
									$message .="Password mistach";
									}
								}else{
								$message .="please enter the confirm password";	
								}
							}else{	
							$message .="please enter the new password";	
							}	
			}
			

if(!empty($_GET['delete'])){
	$sql = "DELETE FROM executive WHERE ID=".$_GET['delete']."";

if ($conn->query($sql) === TRUE) {
   
header("Location: executive-list.php?success=success");
   
} else {
    echo "Error deleting record: " . $conn->error;
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
                        <h4 class="page-title">Executive list</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Executive list</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row"> 
                    <div class="col-md-12 col-xs-12">
                        <div class="white-box">
							   <?php if(!empty($_GET['success'])){?>
								<div class="alert alert-success">
								Executive list Added Succussfully
								</div>
								<?php } ?>
								<?php if(!empty($message)){?>
								<div class="alert alert-danger">
								<?=$message?>
								</div>
								<?php } ?>
		 <form  method="post" action="" enctype="multipart/form-data" autocomplete="off" >
					 
						<div class="row"> 
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-3 col-form-label">Enter Name</label>
                        <div class="col-3">
                            <input class="form-control" name="name" type="text" placeholder="Enter Name"  value="<?php echo $executivedetails['name']; ?>" >
                        </div>
                        </div>
						<div class="form-group col-md-6"> 
                        <label for="example-text-input" class="col-3 col-form-label">Enter Email</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="email" placeholder="Enter executive email" id="example-text-input"   value="<?php echo $executivedetails['email']; ?>" readonly  >
                        </div>
						</div>
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-3 col-form-label">Enter Mobile Number</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="mobile" placeholder="Enter mobile number"  value="<?php echo $executivedetails['mobile']; ?>" readonly >
                        </div>
                        </div>
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-3 col-form-label">Status</label>
                        <div class="col-3"> 			
							<select class="form-control" name="status">
								<option value="">--Select--</option> 
								<option value="1" <?php if($executivedetails['status']=='1'){ echo 'selected';}?>>Active</option>
								<option value="0" <?php if($executivedetails['status']=='0'){ echo 'selected';}?>>Inactive</option>
							</select>
                        </div>
						</div>	  
							
						<div class="form-group col-md-6"> 
                        <label for="example-text-input" class="col-3 col-form-label">Location</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="location"   value="<?php echo $executivedetails['location']; ?>" placeholder="Enter location" id="example-text-input">
                        </div> 
						</div>
					
						<div class="form-group col-md-6"> 
                        <label for="example-text-input" class="col-3 col-form-label">Upload PAN Card</label>
                        <div class="col-3">
							<div class="custom-file">
                                <input type="file" class="custom-file-input" name="panimg" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
						</div>
						</div>
						
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-3 col-form-label">Upload ADHAAR Card</label>
                        <div class="col-3">
							<div class="custom-file">
                                <input type="file" class="custom-file-input" name="adhaarimg" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
						</div>
						</div>
						</div>
					
					 <div class="form-group row">  
                       <div class="col-3">
                             <button type="submit" name="submit" value="submit" class="btn btn-brand btn-elevate btn-pill">Update Executive</button>
						</div>
                    </div>  
					</form>
						
						
						<form  method="post" action="" enctype="multipart/form-data" autocomplete="off" >
						<div class="form-group row">
						    
                        <label for="example-text-input" class="col-3 col-form-label">Password</label>
                        <div class="col-3">
                            <input class="form-control" name="new_pass" type="password" placeholder="Enter Password" >
                        </div>
						</div>
					 
						<div class="form-group row">
						    
                        <label for="example-text-input" class="col-3 col-form-label">Confirm password</label>
                        <div class="col-3">
                            <input class="form-control" name="confirm_pass" type="password" placeholder="Enter Leader executive id" >
                        </div>
						</div>
					 
					 <div class="form-group row"> 
                    
                       <div class="col-3">
                             <button type="submit" name="password-submit" value="submit" class="btn btn-brand btn-elevate btn-pill">Update Password</button>
						</div>
                    </div>  
					</form>
					
                         
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-12 col-xs-12">
                        <div class="white-box">
                        <div class="table table-responsive">

					 
	    	</div>
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
