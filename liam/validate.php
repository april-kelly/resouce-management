<?php

/*
	Name:Object Oriented User Data Validator
	Description: This object provides functions for user data verification.
	Programmer: Liam Kelly
	Date Created: 1/2/13
	Date Last Modified: 1/29/13
*/

class validate {
	
	public function verify ($data, $type, $length) {
		
		//verify data based upon type
		switch ($type) {
			
			//check for a number
			case "n":
			 if(is_numeric($data)){
			   if($length == strlen($data)){
			    $error = false;
			   }else{
			    $error = "":
			   }
			 }
			break;
			
			//check for a boolean number
			case "b":
			 return is_bool($data);
			break;
			
			//check for a string
			case "s":
			 return is_string($data);
			break;
			
			//return false if the $type provided is not valid
			default:
			 return false;
			break;
			
		}
		
		return $error;
	}
	

}

?>
