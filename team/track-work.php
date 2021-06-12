<?php
session_start(); 
error_reporting(0);
include('../functions.php');
$userid = current_employeeid();
if(empty($userid)){
	header("Location:index.php");
	}
$usedetails = runQuery("select * from employee where ID = '".$userid."'");
$message = '';
if(!empty($_POST['submit'])){
			if(!empty($_POST['clientname'])){
	   $pagerarray  = array(); 
	   $processform = true;
               $assingedto = mysqli_real_escape_string($conn,$_POST['assingedto']);
			   if(!empty($assingedto)){
				$prevuser = runQuery("select * from employee where unique_id = '".$assingedto."'");
				if(empty($prevuser)){ 
					$processform = false;
					$invalidme = "Empoyee id does not exists";
				}
			   }
			   if($processform){
					$pagerarray['employee_id'] = $userid;
					$pagerarray['clientname'] = mysqli_real_escape_string($conn,$_POST['clientname']);
					$pagerarray['selecttype'] = mysqli_real_escape_string($conn,$_POST['selecttype']);
					$pagerarray['mobile'] = mysqli_real_escape_string($conn,$_POST['mobile']); 
					$pagerarray['email'] = mysqli_real_escape_string($conn,$_POST['email']); 
					$pagerarray['amount'] = mysqli_real_escape_string($conn,$_POST['amount']);
					$pagerarray['address'] = mysqli_real_escape_string($conn,$_POST['address']);
					$pagerarray['remark'] = mysqli_real_escape_string($conn,$_POST['remark']);
					$pagerarray['company'] = mysqli_real_escape_string($conn,$_POST['company']);
					$pagerarray['income'] = mysqli_real_escape_string($conn,$_POST['income']);
					$pagerarray['assingedto'] = $assingedto;
					$pagerarray['source'] = mysqli_real_escape_string($conn,$_POST['source']);
					$pagerarray['followup'] = date('Y-m-d',strtotime($_POST['followup']));
					$pagerarray['status'] = 'Yes';
					$result = insertQuery($pagerarray,'track_work');
					if(!$result){
						header("Location: track-work.php?success=success");
						}
				
		 	}else{

		$message .= $invalidme;

	}
		 	}else{

		$message .=" Client Name Field is Empty";

	}

}

if(!empty($_GET['delete'])){
	$sql = "DELETE FROM track_work WHERE ID=".$_GET['delete']."";

if ($conn->query($sql) === TRUE) {
   
header("Location: track-work.php?success=success");
   
} else {
    echo "Error deleting record: " . $conn->error;
}
}
if(!empty($_GET['status'])){
	$statuscontent = $_GET['statuscontent']=='Yes' ? 'No' : 'Yes';
	$sql = "UPDATE track_work set status = '".$statuscontent."' WHERE ID=".$_GET['status']."";

if ($conn->query($sql) === TRUE) {
   
header("Location: track-work.php?statusupdate=success");
   
} else {
    echo "Error deleting record: " . $conn->error;
}
}
if(!empty($_POST['remarksubmit'])){
	$statuscontent = mysqli_real_escape_string($conn,$_POST['remark']);
	$followup = date('Y-m-d',strtotime($_POST['followup']));
	$sql = "UPDATE track_work set remark = '".$statuscontent."',followup = '".$followup."' WHERE ID=".$_POST['remarksubmit']."";

if ($conn->query($sql) === TRUE) {
   
header("Location: track-work.php?statusupdate=success");
   
} else {
    echo "Error deleting record: " . $conn->error;
}
}


if(!empty($_POST['uploaddata'])){
	$uploadtrackwork = $_POST['uploadtrackwork'];
    if(!empty(array_filter($_FILES['uploadedfile']['name']))) {
		foreach ($_FILES['uploadedfile']['tmp_name'] as $key => $value) {
			$file_tmpname = $_FILES['uploadedfile']['tmp_name'][$key];
            $file_name = $_FILES['uploadedfile']['name'][$key];
            $file_size = $_FILES['uploadedfile']['size'][$key];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);		
			$newname = date('YmdHis',time()).mt_rand().'.'.$file_ext;
			$path = './../upload_documents/'.$uploadtrackwork;
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
			}

			move_uploaded_file($file_tmpname,$path.'/'.$newname);
			$trackerdocarray['doc_name'] = $newname;
			$trackerdocarray['employee_id'] = $userid;
			$trackerdocarray['track_work_id'] = $uploadtrackwork;
			$trackerdocarray['reg_date'] = date('Y-m-d');
			$trackerdocarray['created_on'] = date('Y-m-d H:i:s A');
			$result = insertQuery($trackerdocarray,'track_work_documents');
		}
	}

	$sql = "UPDATE track_work set doc_status = '1' WHERE ID=".$_POST['uploadtrackwork']."";

	if ($conn->query($sql) === TRUE) {
	   
	header("Location: track-work.php?statusupdate=success");
	   
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
    
   <?php include("headerscripts.php");?>
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
                        <h4 class="page-title">TRACK MY WORK</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
					<ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">TRACK  My Work</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div> 
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Track  My Work</h3>
                            <div class="table-responsive">
                             
						
							<div class="white-box">
								<? if(!empty($_GET['statusupdate'])){?>

									<div class="alert alert-success">

									Status updated Successfully

									</div>

								<? }?>
                          <? if(!empty($_GET['success'])){?>

								<div class="alert alert-success">

								Track Work Details Added Successfully

								</div>

								<? }?>

								<? if(!empty($message)){?>

								<div class="alert alert-danger">

								<?=$message;?>

								</div>

								<? }?>

				  
				<form  method="post" action="" enctype="multipart/form-data">	
                          <div class="form-group row">			 
								<label class="col-md-2">Client Name*</label>
								<div class="col-md-4">
									<input type="text" placeholder="Client Name" name="clientname" class="form-control form-control-line" value="<?php echo $_POST['clientname'];?>" required> 
                               </div>
						
								<label class="col-md-2">Service Type*</label>
                                    <div class="col-md-4">
                                    <input type="text" placeholder="Service Type" name="selecttype" class="form-control form-control-line" value="<?php echo $_POST['selecttype'];?>"  required>  
                                    </div>
                         </div>
						 
						<div class="form-group row">
                                <label class="col-md-2">Mobile No *</label>
                             <div class="col-md-4">
							 
							    <input type="text" class="form-control form-control-line"  onkeypress="return isNumberKey(event)" placeholder="Mobile No"  name="mobile" required maxlength="10" pattern="\d{10}"  value="<?php echo $_POST['mobile'];?>"  >
								 
                             </div> 
                                <label class="col-md-2">Email Id</label>
                             <div class="col-md-4">
								<input type="email" placeholder="Email Id" name="email" class="form-control form-control-line" value="<?php echo $_POST['email'];?>" > 
                             </div>
                          </div> 
					   <div class="form-group row">
							<label class="col-md-2">Deal Amount *</label>
								<div class="col-md-4">
										<input type="text" placeholder="Deal Amount"  onkeypress="return isNumberKey(event)"  name="amount" class="form-control form-control-line" required value="<?php echo $_POST['amount'];?>" > 
                                </div> 
							<label class="col-md-2">Location *</label>
								<div class="col-md-4">
										<input type="text" placeholder="Enter Address" name="address" class="form-control form-control-line" required value="<?php echo $_POST['address'];?>" > 
                                </div> 
                                </div> 
							<div class="form-group row">
                                    	<label class="col-md-2">Company Name</label>
                                    <div class="col-md-4">
                          <input type="text" placeholder="Company Name" name="company" class="form-control form-control-line"  value="<?php echo $_POST['company'];?>" > 
                                       </div>
                                    	<label class="col-md-2">Salary / income *</label>
                                    <div class="col-md-4">
                          <input type="text" placeholder="Salary / income" name="income" onkeypress="return isNumberKey(event)" class="form-control form-control-line" required value="<?php echo $_POST['income'];?>" > 
                                       </div>
                                </div>
							<div class="form-group row">
                                    	<label class="col-md-2">Follow up date *</label>
                                    <div class="col-md-4">
                          <input type="date" placeholder="Follow up date" name="followup" class="form-control form-control-line" required value="<?php echo $_POST['followup'];?>" > 
                                       </div>
                                    	<label class="col-md-2">Remark *</label>
                                    <div class="col-md-4">
                          <input type="text" placeholder="Write Remark" name="remark" class="form-control form-control-line" required value="<?php echo $_POST['remark'];?>" > 
                                       </div>
                                </div>
							<div class="form-group row">
                                    	<label class="col-md-2">Assingn to</label>
                                    <div class="col-md-4">
                          <input type="text" placeholder="Employee id" name="assingedto" class="form-control form-control-line" value="<?php echo $_POST['assingedto'];?>" > 
                                       </div>
                                    	<label class="col-md-2">Source *</label>
                                    <div class="col-md-4"> 
										<select class="form-control" required name="source" >
											<option value="">--select--</option>
											<?php $pointsetarray = runloopQuery("select * from worksource order by ID desc");
												foreach($pointsetarray as $pointset){
											?>
											<option value="<?php echo $pointset['title'];?>" <?php if($pointset['title']==$_POST['source']){ echo 'selected';}?>><?php echo $pointset['title'];?></option>
												<?php }?>
										</select> 
                                       </div>
                                </div>
								<br>
                                  <div class="col-md-6">
                                        <button type="submit" class="btn btn-success" name="submit" value="submit">Update</button>
                            </div>
                                </form>
                                </div>
                              
                                
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Track My Work</h3>
                            <div class="table-responsive">
                                <table class="table" id="kt_table_1" >
                                    <thead>
                                        <tr>
											<th>S.NO</th>
												<th>Client Name</th>
												<th>Service Type</th>
												<th>Mobile No</th>
												<th>Email Id</th>
												<th>Amount</th>
												<th>Address</th>
												<th>Remark</th>
												<th>Company</th>
												<th>Salary</th>
												<th>Follow up</th>
												<th>Assingned</th>
												<th>Source</th>
												<th>Reg date</th>
												<th>Upload Data</th>
												<!--<th>Status</th>-->
												<th>Remark edit</th>
											</tr>
                                    </thead>
                                    <tbody>
                                         <?php
$sql = runloopQuery("SELECT * FROM track_work where employee_id = '".$userid."' order by ID desc");


   $x=1;  foreach($sql as $row)
		{
?>
<tr>
<td><?php echo  $x;?></td>
<td><?php echo $row["clientname"];?></td>
<td><?php echo $row["selecttype"];?></td>
<td><?php echo $row["mobile"];?></td>
<td><?php echo $row["email"];?></td>
<td><?php echo number_format((float)$row["amount"],2);?></td>
<td><?php echo $row["address"];?></td>
<td><?php echo $row["remark"];?></td>
<td><?php echo $row["company"];?></td>
<td><?php echo number_format((float)$row["income"],2);?></td>
<td><?php echo date('d F Y',strtotime($row["followup"]));?></td>
<td><?php echo $row["assingedto"];?></td>
<td><?php echo $row["source"];?></td>
<td><?php echo reg_date($row["reg_date"]);?></td> 
<td>
<?php if($row['doc_status'] == '1' ) { ?>
	<button type="button" class="btn btn-success" onclick="preview_doc(<?php echo $row['ID'];?>)">
  Preview Documents
</button>
<?php  } else {?>
<button type="button" class="btn btn-success" onclick="upload_doc(<?php echo $row['ID'];?>)">
  Upload
</button>
<?php } ?>
</td>
<!--<td><a href="?status=<?php echo $row["ID"];?>&statuscontent=<?php echo $row["status"];?>"><i class="fa fa-pencil"></i></a></td>-->
<td><a href="?remark=<?php echo $row["ID"];?>"><i class="fa fa-pencil"></i></a></td>
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
	
   <?php include("footerscripts.php");?>
    
	<!--end::Page Scripts -->
	<?php if(!empty($_GET['remark'])){ 
$sql = runQuery("SELECT * FROM track_work where ID = '".$_GET['remark']."' order by ID desc");

	?>
		<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Remark</h4>
      </div>
      <div class="modal-body">
       <form method="post" action="" >
			<div class="form-group">
				<label>Follow up date</label>
				<input type="date" placeholder="Follow up date" name="followup" value="<?php echo $sql['followup'];?>" class="form-control form-control-line" required> 
			</div>
			<div class="form-group">
				<label>Remark</label>
				<textarea class="form-control"  name="remark" ><?php echo $sql['remark'];?></textarea>
			</div>
			<div class="form-group">
			 <button type="submit" class="btn btn-success" value="<?php echo $sql['ID'];?>" name="remarksubmit" >Submit</button>
			</div>
	   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




	<script>
			$("#myModal").modal('show');
		</script>
	<?php }?>


<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Documents</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="" id="upload-data-form-id" enctype="multipart/form-data">
		<input type="hidden"  id="uploadtrackworkid" name="uploadtrackwork">
			<table id="tblAddRow" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>File</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
						<input type="file" name="uploadedfile[]" class="form-control">
						</td>
					</tr>
				</tbody>
			</table>

			<div class="modal-footer">
					<button id="btnAddRow" class="btn btn-add btn-xs" type="button">Add Row</button>
					<input type="submit" id="uploadData" class="btn btn-add btn-xs" name="uploaddata" value="Upload Data">
			</div>
		</form>
      </div>
    </div>

  </div>
</div>


<div id="myModal3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Documents</h4>
      </div>
      <div class="modal-body" id="docbody">

	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</div>
	
  </div>
</div>

<script>
$('#tblAddRow tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>');


// Add row the table
$('#btnAddRow').on('click', function() {
    var lastRow = $('#tblAddRow tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRow tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRow tbody tr:last input').val('');
});
// Delete row on click in the table
$('#tblAddRow').on('click', 'tr a', function(e) {
    var lenRow = $('#tblAddRow tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});

function upload_doc(trackworkid)
{
	$("#uploadtrackworkid").val(trackworkid);
	$("#myModal2").modal('show');

}

function preview_doc(trackworkid){
	$("#myModal3").modal('show');
	$.ajax({				
	 url : '_ajaxtrackworkdocs.php',		
	 
	 type: "POST",		
	 data: {			
		trackworkid:trackworkid			
	 },				
	 success: function(res){	
		var result = JSON.parse(res);
		$("#docbody").html('');
		for(i=0; i < result.length ; i++) {
			$("#docbody").append(`<a target="_blank" href="./../upload_documents/${trackworkid}/${result[i]['doc_name']}"><img src="./../upload_documents/${trackworkid}/${result[i]['doc_name']}"
			 class="borders" style="display: inline-block;width: 70px;height: 70px;margin: 6px;"></a>`);
		}
	 }					
	 });

}

</script>

</body>

</html>
