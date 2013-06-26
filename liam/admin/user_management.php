<?php
/**
 * Name:       Functions for user management
 * Programmer: Liam Kelly
 * Date:       6/21/13
 */

//includes
require_once(ABSPATH.'/data.php');

public class users {

    private $email;
    private $password;
    private $name;
    private $type;
    private $admin;
    private $index;
    public  $force = false;

    //logs a user in
    public function login(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $username = $dbc->sanitize($username);
        $password =$dbc->sanitize(sha1($passwordd));

        //search for user
        $results = $dbc->query("SELECT * FROM people WHERE email='".$username."' AND password='".$password."'");

        //close connection
        $dbc->close();

        //count the number of rows returned
        if(count($results) == '1'){
            return true;
        }else{
            return false;
        }

    }

    //creates a new user
    public function create(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $username = $dbc->sanitize($_REQUEST['username']);
        $password =$dbc->sanitize(sha1($_REQUEST['password']));



    }

    public function force_delete(){
        $force = true;
    }

    //deletes and existing user
    public function delete(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $username = $dbc->sanitize($username);
        $password =$dbc->sanitize(sha1($passwordd));

        //search for user
        $results = $dbc->query("SELECT * FROM people WHERE index=".$index."'");


        //count the number of rows returned
        if(count($results) == '1' or $force == true){

           //go ahead with the delete query
           $dbc->delete("DELETE * FROM people WHERE index=".$index."'");

           return true;

        }else{

           return false;
            
        }

        //close connection
        $dbc->close();


    }

}