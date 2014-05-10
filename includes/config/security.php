<?php
/**
 * Name:       Resource Management Group Security Class
 * Programmer: Liam Kelly
 * Date:       8/20/13
 */

//Includes
//include_once('../../path.php');
include_once(ABSPATH.'includes/data.php');

interface security_class{

    /*
     * public function add_user()
     * Adds a users to a security class
     * $group_id: The security group's id.
     * $user_id:  The user's index.
     */
    public function add_user($group_id, $user_id);

    /*
     * public function remove_user
     * Removes a user from a security group
     * $group_id: The security group's id.
     * $user_id:  The user's index.
     */
    public function remove_user($group_id, $user_id);

    /*
     * public function create_group
     * Creates a security group
     * $name:   The name of the security group
     */
    public function create_group($name);

    /*
     * public function delete_group
     * Deletes a security group
     * $delete_group: Deletes a security group
     */
    public function delete_group($group_id);

    /*
     * public function lookup_group
     * Looks up a security group by name
     * $name:   The name of the security group
     */
    public function lookup_group($name);

    /*
     * public function update_user
     * Update a user's security class
     * $group_id: The security group's id.
     * $user_id:  The user's index.
     */
    public function update_user($user_id, $group_id);

    /*
     * public function change
     * Changes a value in the security class
     * $key:   The variable's name
     * $value: The value of the variable
     */
    public function change($key, $value);

}

class security implements security_class {

    //Security Group
    public $index      = '';
    public $name       = '';
    public $users      = '';
    public $dbc;

    public function __constructor(){


    }

    //Add a user to group
    public function add_user($group_id, $user_id){

        //connect to the database
        $this->dbc = new db;
        $this->dbc->connect();

        //Sanitize input(s)
        $group_id = $this->dbc->sanitize($group_id);
        $user_id  = $this->dbc->sanitize($user_id);

        //The Query
        $query = "INSERT INTO `resources`.`security_groups` (`index`, `name`, `users`)
                  VALUES ('".$this->index."',
                          '".$this->name."',
                          '".$this->users."')";

        //close connection
        $this->dbc->close();


    }

    //Remove a user from a group
    public function remove_user($group_id, $user_id){


    }

    //Create a security group
    public function create_group($name){



    }

    //Delete a security group
    public function delete_group($group_id){

        //connect to the database
        $this->dbc = new db;
        $this->dbc->connect();

        //Sanitize input(s)
        $group_id = $this->dbc->sanitize($group_id);

        //Query
        $query = "DELETE * FROM `security_groups` WHERE `index` = '".$group_id."'";

        //Run the Query
        $results = $this->dbc->query($query);

        //Define the class
        $this->index = $results[0]['index'];
        $this->name  = $results[0]['name'];
        $this->users = $results[0]['users'];

        //close connection
        $this->dbc->close();

    }

    //Looks up a group by name
    public function lookup_group($name){

        //connect to the database
        $this->dbc = new db;
        $this->dbc->connect();

        //Sanitize input(s)
        $name = $this->dbc->sanitize($name);

        //Query
        $query = "SELECT * FROM `security_groups` WHERE `name` = '".$name."'";

        //Run the Query
        $results = $this->dbc->query($query);

        //Define the class
        $this->index = $results[0]['index'];
        $this->name  = $results[0]['name'];
        $this->users = $results[0]['users'];

        //close connection
        $this->dbc->close();

        return $results;

    }

    //Changes a user's security group
    public function update_user($user_id, $group_id){



    }

    //Changes a variable in the security class
    public function change($key, $value){

        if(isset($this->$key)){
            $this->$key = $value;
            return true;
        }else{
            return false;
        }

    }

    public function __destruct(){

        echo 'Object self destructed';

    }

}
