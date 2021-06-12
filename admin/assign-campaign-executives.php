<?php

session_start();

error_reporting(E_ALL);

include('../functions.php');

$userid = current_adminid(); 

if(empty($userid)){

	header("Location: index.php");

}
$campainid = $_GET['campaign'];
if(empty($userid)){

	header("Location: campaigns-list.php");

}
$compaindetails = runQuery("select * from campaigns where ID = '".$campainid."'");
if(empty($compaindetails)){

	header("Location: campaigns-list.php");

}
$message = '';
if(!empty($_POST['submit'])){ 
	   $pagerarray  =	   $pagewhererarray  = array();
	   $pagewhererarray['ID'] = $_POST['submit'];
	$execuitveids = !empty($_POST['executivelist']) ? implode(',',$_POST['executivelist']) : '';
	$pagerarray['executive'] = $execuitveids;  
	
	$result = updateQuery($pagerarray,'campaigns',$pagewhererarray);
	if(!$result){
		header("Location: assign-campaign-executives.php?campaign=".$pagewhererarray['ID']."&success=success");
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
	<!-- begin::Head -->
	<head>
		<!--begin::Base Path (base relative path for assets of this page) -->
		<!--end::Base Path -->
		<meta charset="utf-8" />
		<title>M3  | Dashboard</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<?php include('headerscripts.php');?>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="demo1/index.html">
					<img alt="Logo" src="./assets/media/logos/logo-6.png" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar">
				<button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
			</div>
		</div>

		<!-- end:: Header Mobile -->

		<!-- begin:: Root -->
		<div class="kt-grid kt-grid--hor kt-grid--root">

			
			<!-- begin:: Page -->
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
 
<?php include('header.php');?>
 

				<!-- end:: Aside -->

				<!-- begin:: Wrapper -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->

<?php include('headernav.php');?>
					<!-- end:: Header -->
					<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

					<!-- begin:: Subheader -->

<br>
<!-- end:: Subheader -->

						<!-- begin:: Content -->
	<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                          
		    <div class="kt-portlet kt-portlet--mobile"> 
						<div class="kt-portlet__head">
							<div class="kt-portlet__head-label">
								<div class="col-12">
								<h3 class="kt-portlet__head-title">Select Executives for <?php echo $compaindetails['title'];?></h3>
								</div>  
								<a href="campaigns-list.php" class="btn btn-primary pull-right" >Back to Campaigns</a> 
							</div>
						</div>     
		<div class="kt-portlet__body"> 
		 <?php if(!empty($_GET['success'])){?>
								<div class="alert alert-success">
								Executives Assigned Succussfully
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
			<form method="post" action="">
						<!--begin: Datatable -->
			<table class="table table-bordered table-hover table-checkable" id="kt_table_1">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Executive Id</th>
                            <th>Full Name</th>   
                            <th>Manager</th>   
                            <th>Location</th>  
						</tr> 
							</thead>
								<tbody>
								  <?php
								  
								  $executivearray = explode(',',$compaindetails['executive']);
$sql = runloopQuery("SELECT * FROM executive order by ID desc");

   $x=1;  foreach($sql as $row)
		{
?>
<tr>
<td><input type="checkbox" name="executivelist[]" value="<?php echo $row["ID"];?>" <?php if(in_array($row["ID"],$executivearray)){ echo 'checked';}?>  /></td>
<td><?php echo $row["unique_id"];?></td>
<td><?php echo $row["name"];?> 
<td><?php echo $row['user_role']=='superadmin' ? 'Admin' : ucwords(manager_details($row['user_id'],'name'));?>
<br>
<?php echo  $row['user_role']=='manager' ? ucwords($row['user_role']) : '';?></td>
<td><?php echo $row["location"];?></td>   
</tr>
<?php
     $x++; }
?>
                          </tbody>
					</table>
					
					<div class="">
						<button type="submit" class="btn btn-primary" name="submit" value="<?php echo $compaindetails['ID'];?>" >Submit</button>
					</div>
				<!--end: Datatable --> 
				</form>
	    	</div>
							
			</div>
		</div>
				 
</div>
	    
	    
					<!-- begin:: Footer -->
					<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop">
						<div class="kt-footer__copyright">
							2019&nbsp;&copy;&nbsp;<a href="https://sansdigitals.com" target="_blank" class="kt-link">sansdigitals.com</a>
						</div>
					 
					</div>
					<!-- end:: Footer -->
				</div>

				<!-- end:: Wrapper -->
			</div>

			<!-- end:: Page -->
		</div>

		<!-- end:: Root -->
 
		
	<?php include("footerscripts.php");?>
	</body>

	<!-- end::Body -->
</html>