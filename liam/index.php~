<?php
	include('data.php');
	
	$dbc = new db;
	$dbc->connect();
	$result = $dbc->query('SELECT * FROM people');
	  

?>
<html>

 <head>
 
  <title>Bluetent Resource Management</title>
  
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
   
  <script>
  $(function() {                                
      $( "#start_date" ).datepicker();
  });
  $(function() {
      $( "#end_date" ).datepicker();
  });
  function test(){
      document.getElementById("end_date").style.display='block'; 
      document.getElementById("test").style.display='block'; 
      document.getElementById("days").style.display='none'; 
      document.getElementById("multi").style.display='none'; 
  }
  </script>

 <head>
 
 <body>
 
  <form action="insert.php" method="post" onsubmit="return validate()" name="form">
  
   <fieldset>
   
    <legend>Resource Request Form:</legend>
	
    <span id="error"><label for="sales_status">Sales Status: </label>
	
	 <select name="sales_status">
	  <option value="">Select One:</option>
	  <option value="1">Sold</option>
	  <option value="0">Opportunity</option>
	 </select><b id="error2"></b></span>
	 <br />
	 
    <label for="manager">Project Manager: </label> 
	
	<select name="manager" id="manager">
	  <option value="">Select One:</option>
	  <?php
		foreach($result as $result){
			//print_r($result);
			if($result['type'] == '0' or $result['type'] == '1'){
		 	 echo '<option value="',$result['index'],'">',$result['name'],'</option>';
		 	}
		}
	  ?>
	</select>
	<br />
	
    <span id="error"><label for="project_id">Project ID: </label>
	
	<input type="text" name="project_id" /><b id="error2"></b></span>
	<br />
	
    <label for="resource">Desired Resource: </label>
	
	<select name="resource" id="resource">
	  <option value="">Select One:</option>
	  <?php
	  	$result = $dbc->query('SELECT * FROM people');
	  	foreach($result as $result){
	  		if($result['type'] == '0' or $result['type'] >= '2'){
	  			echo '<option value="',$result['index'],'">',$result['name'],'</option>';
	  		}
		}
		$dbc->close();
	  ?>
	</select>
	<br />
	
	<p>
	<label>Week of: <!--Start Date:--></label><br /><input type="text" id="start_date" name="start_date" /> <label id="days"><!--More than one day?</label> <input type="checkbox" id="multi" onclick="test()"/><br />
  	<label id="test" style="display: none;">End Date:</label><input type="text" id="end_date" name="end_date"  style="display: none;" /><br />-->
	<br /><br />
	<label>Hours:</label>
	<br />
	<table border="1">
	 <tr>
	  <td>Sun: </td>
	  <td>Mon: </td>
	  <td>Tues:</td>
	  <td>Wed: </td>
	  <td>Thur:</td>
	  <td>Fri: </td>
	  <td>Sat: </td>
	 </tr>
	 
	 <tr>
	  <td><input type="text" name="sunday"    value="0" size="4" maxlength="4" /></td>
	  <td><input type="text" name="monday"    value="0" size="4" maxlength="4" /></td>
	  <td><input type="text" name="tuesday"   value="0" size="4" maxlength="4" /></td>
	  <td><input type="text" name="wednesday" value="0" size="4" maxlength="4"  /></td>
	  <td><input type="text" name="thursday"  value="0" size="4" maxlength="4"  /></td>
	  <td><input type="text" name="friday"    value="0" size="4" maxlength="4"  /></td>
	  <td><input type="text" name="saturday"  value="0" size="4" maxlength="4"  /></td>
	 </tr>
	 
	</table>
  	</p>
  	
  	<label>Priority</label>
  	<select name="priority">
  	   <option value="3">Low</option>
  	   <option value="2">Medium</option>
  	   <option value="1">High</option>
  	   <option value="0">Very High</option>
  	</select>
  	<br />

	<input type="submit" value="Request" />
	
	<?php
	//Echo out errors for improper data:
	
	//Sales_Status issues
	if(isset($_REQUEST['bool'])){
		echo '<span style="color: red">You must input a valid Sales Status.</span>';
	}
	
	//Project Manager issues
	if(isset($_REQUEST['manager'])){
		echo '<span style="color: red">You must input a valid Manager.</span>';
	}
	
	//Project_id issues
	if(isset($_REQUEST['projectid'])){
		echo '<span style="color: red">You must input a valid Project ID.</span>';
	}
	
	//Project Resource Issues
	if(isset($_REQUEST['resource'])){
		echo '<span style="color: red">You must input a valid Resource.</span>';
	}
	
	//Time issues
	if(isset($_REQUEST['time'])){
		echo '<span style="color: red">You must input a valid Time.</span>';
	}
	
	//No Start Date
	if(isset($_REQUEST['nodate'])){
		echo '<span style="color: red">You must input a Start Date.</span>';
	}

	//No Start Date
	if(isset($_REQUEST['priority'])){
		echo '<span style="color: red">You must input a Priority Level.</span>';
	}
	
	?>
	
   </fieldset>
   <a href="list.php">See current resource usage</a>
   
  </form>
  
 </body>

</html>
