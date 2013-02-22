<?php
	echo "<pre>";
	
	//make the sales_status be boolean
	$sales_status = 1;
	if($_REQUEST['sales_status'] == '1'){
		$sales_status = true;
	}
	
	if($_REQUEST['sales_status'] == '0'){
		$sales_status = false;
	}
	
	//check for a valid sales status
	if(!(is_bool($sales_status))){
		header("Location: ./index.php?&bool");
		//echo "Sales Status Issue\r\n";
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
		header("Location: ./index.php?&manager");
		//echo "Manager Issue\r\n";
	}
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
		header("Location: ./index.php?&projectid");
		//echo $_REQUEST['project_id'].strlen($_REQUEST['project_id']);
		//echo "Project_ID issue\r\n";
	}
	
	//check for a valid resource
	if(!(is_numeric($_REQUEST['resource'])) && !(strlen($_REQUEST['resource']) >= '11' )){
		header("Location: ./index.php?&resource");
		//echo "Resource Issue\r\n";
	}
	
	//check for a time
	if(!(isset($_REQUEST['time']))){
		header("Location: ./index.php?&time");
		//echo "Time Issue\r\n";
	}
	
	//check for an empty start date
	if($_REQUEST['start_date'] == ''){	//Note: Set back to $start_date in insert.php
		header("Location: ./index.php?&nodate");
		//echo "No Start Date";
	}
	
	echo "</pre>";
?>