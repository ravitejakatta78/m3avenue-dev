<?php

 include("../../functions.php");
 
	$checked = $_POST['checked'];
	$changestatus = $_POST['changestatus'];
	
		$roderarray = $roderwharray=  array();
		$roderwharray['ID'] = $checked;
	$resellaramount = runQuery("select status from clients where ID = ".$checked." order by ID desc");
	 $roderarray['status'] = $changestatus;
		 
		updateQuery($roderarray,'clients',$roderwharray)

?>