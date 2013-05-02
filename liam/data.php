<?php

/*
	Object Oriented MySQLi Interface
	By: Liam Kelly
	12/05/12
*/

class db
{
	
	//Login related
	private $settings;
	private $settings_location = 'settings.bin';
	private $db_host;
	private $db_user;
    private $db_pass;
	private $db_database;
	private $user_defined = FALSE;
	
	//mysqli object
	private $dbc;
	
	//variable to indicate the connection has failed
	private $fail = FALSE;

	//change database login info temporarily
	public function credentials($new_host, $new_user, $new_pass, $new_database)
	{
	
		if(isset($new_host))
        {

			$this->db_host = $new_host;

		}
		
		if(isset($new_user))
        {

			$this->db_user = $new_user;

		}
		
		if(isset($new_pass))
        {

			$this->db_pass = $new_pass;

		}
		
		if(isset($new_host))
        {

			$this->db_database = $new_database;

		}
		
		$this->user_defined = TRUE;
	
	}
	
	//connect to the database
	public function connect()
	{
		//fetch the credentials
		if($this->user_defined == FALSE)
        {

            //get the settings from file
			$this->settings = unserialize(file_get_contents($this->settings_location));

			$this->db_host     = $this->settings['db_host'];
			$this->db_user     = $this->settings['db_user'];
			$this->db_pass     = $this->settings['db_pass'];
			$this->db_database = $this->settings['db_database'];
			
		}
		
		//connect to the database
		$this->dbc = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database) or die($this->fail = TRUE);
		
	}

    //save the database login info to file
    public function update_creds()
    {

        $this->settings['db_host']      = $this->db_host;
        $this->settings['db_user']      = $this->db_user;
        $this->settings['db_pass']      = $this->db_pass;
        $this->settings['db_database']  = $this->db_database;

        file_put_contents($this->settings_location, serialize($this->settings));


    }

	//query the database
	public function query($db_query)
	{
		if($this->fail = FALSE)
        {

			$result = $this->dbc->query($db_query);	//query the database
			
			
			if(is_object($result))
            {
					
				while($row = $result->fetch_assoc()) {	//fetch assoc array
						$array[] = $row;
				}
				
			}
            else
            {

				return FALSE;
			}
			
			if(!(empty($array)))
            {

				return $array;	//return results

			}
            else
            {
			
			    return FALSE;

            }

		}
        else
        {

            return FALSE;

        }

	}
	
	//insert into the database
	public function insert($db_query)
	{

		if($this->fail = FALSE)
        {

			if(is_object($this->dbc))
            {
		
				$this->dbc->query($db_query);	//query the database

                return TRUE;

			}

		}
		else
        {

            return FALSE;

        }
	}
	
	//delete from the database
	public function delete($db_query)
	{
		if($this->fail = FALSE)
        {

			if(is_object($this->dbc))
            {
		
				$this->dbc->query($db_query);	//query the database

                return TRUE;

			}

		}
        else
        {

            return FALSE;

        }
		
	}
	
	//disconnect from the database
	public function close()
	{

		if($this->fail = FALSE)
        {
		
			if($this->dbc->close())
			{
			
				return TRUE;	//connection closed
				
			}
			else
			{
		
				return FALSE;	//connection not closed
				
			}
			
		}
		else
		{
		
			return FALSE;	//no connection
			
		}

	}
	
	//allow user to sanitize data
	public function sanitize($input)
	{

        if($this->fail = FALSE)
        {

		       return $this->dbc->real_escape_string($input);

        }

	}

    //allow the user to verify that a piece of data is in the database
    public function verify($table, $field, $data){

        if($this->fail == FALSE)
        {

            //sanitize the user inputs
            $table  = $this->sanitize($table);
            $field  = $this->sanitize($field);
            $data   = $this->sanitize($data);

            $result = $this->dbc->query("SELECT * FROM ".$table." WHERE `".$field."` = ".$data."");

            if(count($result) == '1')
            {

               return TRUE;

            }
            else
            {

               return FALSE;

            }

        }
        else
        {

            return FALSE;

        }

    }

	
	
}
