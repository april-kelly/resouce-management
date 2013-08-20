<?php
/**
 * Name:       Resource Management Group Security Class
 * Programmer: Liam Kelly
 * Date:       8/20/13
 */

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

    //Add a user to group
    public function add_user($group_id, $user_id){

    }

    //Remove a user from a group
    public function remove_user($group_id, $user_id){

    }

    //Create a security group
    public function create_group($name){

    }

    //Delete a security group
    public function delete_group($group_id){

    }

    //Looks up a group by name
    public function lookup_group($name){

    }

    //Changes a user's security group
    public function update_user($user_id, $group_id){

    }

    //Changes a variable in the security class
    public function change($key, $value){

    }
}
