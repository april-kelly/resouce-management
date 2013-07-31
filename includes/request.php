<?php

    //set the session
    if(!(isset($_SESSION))){
        session_start();
    }

    //includes
	require_once(ABSPATH.'includes/data.php');

    //database connection
	$dbc = new db;
	$dbc->connect();

	$result = $dbc->query('SELECT * FROM `people`');


	unset($result[0]);

?>

  <h3>Request a resource:</h3>

    <?php

        if(!(isset($_SESSION['userid']))){
            echo '<span class="info">Alert you are not logged in. Please login.</span><br /><br />';
        }

    ?>

  <form action="./includes/insert.php" method="post" onsubmit="return validate()" name="form" class="request">
	
    <label for="sales_status">Sales Status: </label>
	
	 <select name="sales_status">
	  <option value="">Select One:</option>
	  <option value="1">Sold</option>
	  <option value="0">Opportunity</option>
	 </select><b id="error2"></b>
	 <br />
	 
    <label for="manager">Project Manager: </label> 
	
	<select name="manager" id="manager">
	  <option value="">Select One:</option>
	  <?php
		foreach($result as $result){
			//print_r($result);
			if($result['type'] == '0' or $result['type'] == '1'){
		 	 echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';
		 	}
		}
	  ?>
	</select>
	<br />
	
    <label for="project_id">Project ID: </label>
	
	<input type="text" name="project_id" /><b id="error2"></b>
	<br />
	
    <label for="resource">Desired Resource: </label>
	
	<select name="resource" id="resource">
	  <option value="">Select One:</option>
	  <?php
	  	$result = $dbc->query('SELECT * FROM people');
	  	foreach($result as $result){
	  		if($result['type'] == '0' or $result['type'] == '2'){
	  			echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';
            }
		}
		$dbc->close();
	  ?>
	</select>
    <br />

    <!--
    <br />
    <label>Requesting: </label>
    <input type="text" value="<?php if(isset($_SESSION['name'])){ echo $_SESSION['name']; }else{ echo 'Anonymous'; } ?>" />
    <br />
    -->

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
    if(isset($_SESSION['form'])){
    switch($_SESSION['form']){

	    //Sales_Status issues
        case 'bool':
		    echo '<span style="color: red">You must input a valid Sales Status.</span>';
        break;
	
	    //Project Manager issues
        case 'manager':
		    echo '<span style="color: red">You must input a valid Manager.</span>';
	    break;
	
	    //Project Manager existance issues
        case 'manager_db':
		    echo '<span style="color: red">Manager does not exist in database.</span>';
	    break;
	
	    //Project_id issues
        case 'projectid':
		    echo '<span style="color: red">You must input a valid Project ID.</span>';
	    break;
	
	    //Project Resource Issues
        case'resource':
		    echo '<span style="color: red">You must input a valid Resource.</span>';
	    break;
	
	    //Project Resource existance issues
        case 'resource_db':
		    echo '<span style="color: red">Resource does not exist in database.</span>';
	    break;
	
	    //Time issues
        case 'time':
		    echo '<span style="color: red">You must input a valid Time.</span>';
	    break;
	
	    //No Start Date
        case 'nodate':
		    echo '<span style="color: red">You must input a Start Date.</span>';
        break;

	    //No Priority Level
        case 'priority':
		    echo '<span style="color: red">You must input a Priority Level.</span>';
	    break;
	
        //The day selected is not a sunday (ie start of the week)
        case 'weekstart':
            echo '<span style="color: red">The date you selected is not the start of a week.</span>';
        break;
        
        //SQL Injection alert
        case 'sql':
		    echo '<span style="color: red">You are going to have to try harder than that. ;)</span>';
	    break;

        default:
            //do nothing
        break;

    }

    //make sure to unset the error so it does not continue to be displayed
    unset($_SESSION['form']);
    }

	?>

  </form>