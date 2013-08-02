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

<!-- from http://www.w3schools.com/ajax/ajax_aspphp.asp -->
<script>
    function showHint(str)
    {
        var xmlhttp;
        if (str.length==0)
        {
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","./includes/xhr.php?q="+str,true);
        xmlhttp.send();
    }
</script>
<!-- end from w3schools -->

  <form action="./includes/insert.php" method="post" onsubmit="return validate()" name="form" class="request">
	
    <label for="sales_status">Sales Status: </label>
	
	 <select name="sales_status">
	  <option value="" <?php if(empty($_SESSION['input']['sales_status'])){ echo "selected='1'"; }?>>Select One:</option>
	  <option value="1" <?php if($_SESSION['input']['sales_status'] == 1){ echo "selected='1'"; }?>>Sold</option>
	  <option value="0" <?php if($_SESSION['input']['sales_status'] == 0){ echo "selected='1'"; }?>>Opportunity</option>
	 </select><b id="error2"></b>
	 <br />
	 
    <label for="manager">Project Manager: </label> 
	
	<select name="manager" id="manager">
	  <option value="">Select One:</option>
	  <?php
      foreach($result as $result){

          if($result['type'] == '0' or $result['type'] == '1'){

              if(isset($_SESSION['input']['manager'])){

                  if($_SESSION['input']['manager'] == $result['index']){

                      if($result['index'] == $_SESSION['input']['manager']){

                          echo '<option value="',$result['index'],'" selected="1">',$result['firstname'],' ',$result['lastname'],'</option>';

                      }

                  }else{

                      echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';

                  }

              }else{

                  echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';

              }

          }

      }
      ?>
	</select>
	<br />
	
    <label for="project_id">Project ID: </label>
	
	<input type="text" id="txt1" name="project_id" onkeyup="showHint(this.value)" <?php if(isset($_SESSION['input']['project_id'])){ echo 'value="'.$_SESSION['input']['project_id'].'" '; }?>/><b id="error2"></b>
    <span id="txtHint" class='info'></span>
    <br />
	
    <label for="resource">Desired Resource: </label>
	
	<select name="resource" id="resource">
	  <option value="">Select One:</option>
	  <?php
        $result = $dbc->query('SELECT * FROM people');
		foreach($result as $result){

            if($result['type'] == '2'){

                if(isset($_SESSION['input']['manager'])){

                    if($_SESSION['input']['manager'] == $result['index']){

                        if($result['index'] == $_SESSION['input']['manager']){

                            echo '<option value="',$result['index'],'" selected="1">',$result['firstname'],' ',$result['lastname'],'</option>';

                        }

                    }else{

                        echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';

                    }

                }else{

                    echo '<option value="',$result['index'],'">',$result['firstname'],' ',$result['lastname'],'</option>';

                }

            }

        }
	  ?>
    </select>
    <br />

	<label>Priority</label>
  	<select name="priority">
  	   <option <?php if(empty($_SESSION['input']['priority'])){ echo "selected='1'"; }?>>>Select One:</option>
  	   <option value="3" <?php if($_SESSION['input']['priority'] == 3){ echo "selected='1'"; }?>>Low</option>
  	   <option value="2" <?php if($_SESSION['input']['priority'] == 2){ echo "selected='1'"; }?>>Medium</option>
  	   <option value="1" <?php if($_SESSION['input']['priority'] == 1){ echo "selected='1'"; }?>>High</option>
  	   <option value="0" <?php if($_SESSION['input']['priority'] == 0){ echo "selected='1'"; }?>>Very High</option>
  	</select>
  	<br />

  	<label>Week of: </label>
    <input type="text" id="start_date" name="start_date" <?php if(isset($_SESSION['input']['start_date'])){ echo 'value="'.$_SESSION['input']['start_date'].'" '; }?>/><br />

	 
	
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
	  <td><input type="text" name="sunday"    id="sunday"  <?php if(isset($_SESSION['input']['sunday'])){ echo 'value="'.$_SESSION['input']['sunday'].'" '; }else{ echo 'value="0"'; }?>        size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="monday"    id="monday"  <?php if(isset($_SESSION['input']['monday'])){ echo 'value="'.$_SESSION['input']['monday'].'" '; }else{ echo 'value="0"'; }?>        size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="tuesday"   id="tuesday" <?php if(isset($_SESSION['input']['tuesday'])){ echo 'value="'.$_SESSION['input']['tuesday'].'" '; }else{ echo 'value="0"'; }?>      size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="wednesday" id="wed"     <?php if(isset($_SESSION['input']['wednesday'])){ echo 'value="'.$_SESSION['input']['wednesday'].'" '; }else{ echo 'value="0"'; }?>  size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="thursday"  id="thur"    <?php if(isset($_SESSION['input']['thursday'])){ echo 'value="'.$_SESSION['input']['thursday'].'" '; }else{ echo 'value="0"'; }?>    size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="friday"    id="fri"     <?php if(isset($_SESSION['input']['friday'])){ echo 'value="'.$_SESSION['input']['friday'].'" '; }else{ echo 'value="0"'; }?>        size="5" maxlength="5" /><br /></td>
	  <td><input type="text" name="saturday"  id="sat"     <?php if(isset($_SESSION['input']['saturday'])){ echo 'value="'.$_SESSION['input']['saturday'].'" '; }else{ echo 'value="0"'; }?>    size="5" maxlength="5" /><br /></td>
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

        //Project Overage alert
        case 'nooverage':
            echo '<span style="color: red">This project is overbudget, and you can\'t request any more hours.</span>';
        break;

        //Project does not exist
        case 'badproject':
            echo '<span style="color: red">That project id does not exist.</span>';
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

    //We will also unset the $_SESSION['input'] variable so data does not persist for to long
    unset($_SESSION['input']);

    }

	?>

  </form>

<br /><a href="?p=project">Or create a new project here</a>