<?php

session_start();

error_reporting(E_ALL);

include('../functions.php');



$userid = current_managerid(); 

if(empty($userid)){

	header("Location: index.php");

}

$message = '';
if(!empty($_POST['submit'])){
			if(!empty($_POST['name'])){
	   $pagerarray  = array();

		  if (!file_exists('../executiveimage')) {	
		mkdir('../executiveimage', 0777, true);	
		}
	    $target_dir = '../executiveimage/';									

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
				//adhaarimg
		  
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
				$uniqueusers = (int)runQuery("select max(ID) as id from executive order by ID desc")['id'];
				$newuniquid = $uniqueusers+1;
				 
                $pagerarray['user_id'] = $userid; 
                $pagerarray['user_role'] = 'manager'; 
                $pagerarray['name'] = mysqli_real_escape_string($conn,$_POST['name']); 
                $pagerarray['unique_id'] = 'M3E'.sprintf('%05d',$newuniquid);
                $pagerarray['email'] = mysqli_real_escape_string($conn,$_POST['email']);
                $pagerarray['mobile'] = mysqli_real_escape_string($conn,$_POST['mobile']);
                $pagerarray['password'] = password_hash(trim($_POST['password']),PASSWORD_DEFAULT); 
                $pagerarray['location'] = mysqli_real_escape_string($conn,$_POST['location']);  
                $pagerarray['status'] = 1; 
	            $result = insertQuery($pagerarray,'executive');
				if(!$result){
					header("Location: executive-list.php?success=success");
                    }
	    
		 	}else{

		$message .=" First Name Field is Empty";

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
								Executive Added Succussfully
								</div>
								<?php } ?>
						   <?php if(!empty($_GET['psuccess'])){?>
								<div class="alert alert-success">
								<?php echo $_GET['psuccess'];?>
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
							
						<label for="example-text-input" class="col-2 col-form-label">Enter Name</label>
						<div class="col-3">
							<input class="form-control" name="name" required type="text" placeholder="Enter Name" id="example-text-input">
						</div> 
						</div> 
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-2 col-form-label">Enter Email</label>
						<div class="col-3">
							<input class="form-control" type="email" required name="email" placeholder="Enter executive email" id="example-text-input">
						</div>
						</div>
						
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-2 col-form-label">Enter Mobile Number</label>
						<div class="col-3">
							  <input type="text" class="form-control form-control-line" required onkeypress="return isNumberKey(event)" placeholder="Mobile No"  name="mobile" value="" maxlength="10" pattern="\d{10}"  >
						</div>
						</div>
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-2 col-form-label">Password</label>
						<div class="col-3">
							<input class="form-control" type="password" name="password" placeholder="Enter Password" id="example-text-input">
						</div>   
						</div>	  
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-2 col-form-label">Upload PAN Card</label>
						<div class="col-3">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="panimg" id="customFile">
								<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
						</div>
						</div>
						<div class="form-group col-md-6"> 
						
						<label for="example-text-input" class="col-2 col-form-label">Upload ADHAAR Card</label>
						<div class="col-3">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="adhaarimg" id="customFile">
								<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
						</div>
						</div>
						<div class="form-group col-md-6"> 
						<label for="example-text-input" class="col-2 col-form-label">Location</label>
						<div class="col-3">
							<input class="form-control" type="text" name="location"     placeholder="Enter location" id="example-text-input">
						</div> 
						</div>
						</div>
					
					 <div class="form-group row"> 
					
					   <div class="col-3">
							 <button type="submit" name="submit" value="submit" class="btn btn-brand btn-elevate btn-pill">Add Executive</button>
						</div>
					</div>  
					</form> 
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-12 col-xs-12">
                        <div class="white-box">
                             <a href="csv-executive.php" class="btn btn-brand btn-success btn-pill">Download</a>
                        <div class="table table-responsive">

					 			<!--begin: Datatable -->
			<table class="table table-bordered table-hover table-checkable" id="kt_table_1">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Executive Id</th>
							<th>Campaigns</th>
                            <th>Full Name</th>  
                            <th>Pan Card</th>
                            <th>Adhaar Card</th>
                            <th>Location</th> 
                            <th>Reports</th> 
                            <th>Logs</th>  
                            <th>Reg date</th>
                            <th>Delete</th>
							<!--<th>Status:</th>-->
						</tr>
						
							</thead>
									<tbody>
									  <?php
	$sql = runloopQuery("SELECT * FROM executive where user_id = '".$userid."' and user_role = 'manager' order by ID desc");

	   $x=1;  foreach($sql as $row)
			{
			$campaignnames = runQuery("SELECT group_concat(title) as campname FROM campaigns WHERE  FIND_IN_SET('".$row['ID']."',executive)");
	?>
	<tr>
	<td><?php echo  $x;?></td>
	<td><?php echo $row["unique_id"];?></td>
	<td><?php echo $campaignnames["campname"];?></td>
	<td><?php echo $row["name"];?>
	<br/><?php echo $row["email"];?>
	<br/><?php echo $row["mobile"];?></td> 
	<td><?php if($row["panimg"]){?><a href="../executiveimage/<?php echo $row["panimg"];?>" class="html5lightbox" >View</a><?php }?></td>
	<td><?php if($row["adhaarimg"]){?><a href="../executiveimage/<?php echo $row["adhaarimg"];?>" class="html5lightbox" >View</a><?php }?></td> 
	<td><?php echo $row["location"];?></td> 
	<td><a class="btn btn-warning" href="executive-reports.php?executive=<?php echo $row["ID"];?>">Reports</a></td> 
	<td><a class="btn btn-info" href="executive-logs.php?executive=<?php echo $row["ID"];?>">Logs</a></td>  
	<td><?php echo reg_date($row["reg_date"]);?></td>
	<td><a href="edit-executive-list.php?edit=<?php echo $row["ID"];?>">Edit</a> | <a onclick="return confirm('Are you sure want to delete??');"  href="?delete=<?php echo $row["ID"];?>">Delete</a></td>
	</tr>
	<?php
		 $x++; }
	?>
							  </tbody>
					</table>
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
    <script src="js/html5lightbox.js"></script>
    <script src="js/custom.min.js"></script>
</body>

</html>
