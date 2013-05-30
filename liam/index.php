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
  <link rel="stylesheet" href="./styles/styles.css" />

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

 <div id="header">

     <img src="./images/logo.gif" style="center"/>

     <ul>
         <li><a href="./dashboard.php">Overview</a></li>
         <li><a href="./index.php">Request</a></li>
         <li><a href="./admin/index.php">Login</a></li>
         <li><a href="./admin/admin.php">Settings</a></li>
     </ul>

 </div>

  <div id="main">

  <h3>Request a resource:</h3>

  <form action="insert.php" method="post" onsubmit="return validate()" name="form" class="request">
	
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
	<label>Priority</label>
  	<select name="priority">
  	   <option>Select One:</option>
  	   <option value="3">Low</option>
  	   <option value="2">Medium</option>
  	   <option value="1">High</option>
  	   <option value="0">Very High</option>
  	</select>
  	<br />
  	<label>Week of: </label><input type="text" id="start_date" name="start_date" /><br />

	 
	
	<p>   
	<label>Hours:</label><br />
	<br />
	<table border="0">
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
	  <td><input type="text" name="sunday"    id="sunday" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="monday"    id="monday" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="tuesday"   id="tuesday" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="wednesday" id="wed" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="thursday"  id="thur" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="friday"    id="fri" value="0" size="4" maxlength="4" /><br /></td>
	  <td><input type="text" name="saturday"  id="sat" value="0" size="4" maxlength="4" /><br /></td>
	 </tr>
	 
	 </table>
	 <br />

	 
  	</p>

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
	
	//Project Manager existance issues
	if(isset($_REQUEST['manager_db'])){
		echo '<span style="color: red">Manager does not exist in database.</span>';
	}
	
	//Project_id issues
	if(isset($_REQUEST['projectid'])){
		echo '<span style="color: red">You must input a valid Project ID.</span>';
	}
	
	//Project Resource Issues
	if(isset($_REQUEST['resource'])){
		echo '<span style="color: red">You must input a valid Resource.</span>';
	}
	
	//Project Resource existance issues
	if(isset($_REQUEST['resource_db'])){
		echo '<span style="color: red">Resource does not exist in database.</span>';
	}
	
	//Time issues
	if(isset($_REQUEST['time'])){
		echo '<span style="color: red">You must input a valid Time.</span>';
	}
	
	//No Start Date
	if(isset($_REQUEST['nodate'])){
		echo '<span style="color: red">You must input a Start Date.</span>';
	}

	//No Priority Level
	if(isset($_REQUEST['priority'])){
		echo '<span style="color: red">You must input a Priority Level.</span>';
	}
	
        //The day selected is not a sunday (ie start of the week)
        if(isset($_REQUEST['weekstart'])){
                echo '<span style="color: red">The date you selected is not the start of a week.</span>';
        }
        
        //SQL Injection alert
	if(isset($_REQUEST['sql'])){
		echo '<span style="color: red">You are going to have to try harder than that. ;)</span>';
	}
        
	?>

  </form>

  </div>
  
 </body>

</html>
