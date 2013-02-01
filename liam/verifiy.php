<?php
	echo "<pre>";
	$sales_status = 1;
	//check for a valid sales status
	if($_REQUEST['sales_status'] == '1'){
		$sales_status = true;
	}
	
	if($_REQUEST['sales_status'] == '0'){
		$sales_status = false;
	}
	echo $sales_status;
	if(!(is_bool($sales_status))){
		//header("Location: ./index.php?&bool");
		echo "Sales Status Issue\r\n";
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
		//header("Location: ./index.php?&manager");
		echo "Manager Issue\r\n";
	}
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
		//header("Location: ./index.php?&projectid");
		//echo $_REQUEST['project_id'].strlen($_REQUEST['project_id']);
		echo "Project_ID issue\r\n";
	}
	
	//check for a valid resource
	if(!(is_numeric($_REQUEST['resource'])) && !(strlen($_REQUEST['resource']) >= '11' )){
		//header("Location: ./index.php?&resource");
		echo "Resource Issue\r\n";
	}
	
	//check for a valid time
	if(!(isset($_REQUEST['']))){
		//header("Location: ./index.php?&time");
		echo "Time Issue\r\n";
	}
	echo "</pre>"

/*
	//check for an empty start date
	if($start_date == ""){
		//header("Location: ./index.php?&nodate");
	}
*/
?>
