//Form validation function
function validate (){
	
	//Turn form data into variables
	var sales_status = document.forms['form']['sales_status'].value;
	var num = document.forms['form']['project_id'].value;
	var start_date = document.forms['from']['start_date'].value;
	
	//Check for boolean sales status
	if(!(sales_status)){
		alert("ERROR: The sales status must be boolean.");
		return false;
	}
	
	//ensure project_id is a number
	if(!(num >=0 || num < 0)){
		alert('ERROR: The project id must be a number.');
		return false;
	}
	
	//ensure the user has at least specified a start date
	/*if(!(start_date)){	
		alert('ERROR: You must be a input a date.');
		return false;
	}
	
	//HALT25
	if(start_date == "02/25/2011" ){	
		alert('ERROR: HALT25, The worse day.');
		return false;
	}*/
}
