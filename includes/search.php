<?php
/**
 * Name:       Resource Management Database Search Tool
 * Programmer: Liam Kelly
 * Date:       7/18/13
 */

//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}

//Includes
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');


?>
<form action="./" method="get" class="search">
    <input type="hidden" name="p" value="search" />
    <input type="search"
           name="q"
           value="<?php if(isset($_REQUEST['q'])){ echo $_REQUEST['q']; }?>"
           placeholder="Search here!"
        />
    <input type="submit" value=" " />
</form>

<?php

//Search Section

    //Connect to the database
    $dbc = new db;
    $dbc->connect();
    $search = $dbc->sanitize($_REQUEST['q']);

        //Algorithm

            //Step 1: Determine if the search is only numbers
            if(!(is_numeric($search))){

                //Lets see if it is a name
                $results = $dbc->query('SELECT * FROM people WHERE name = \''.$search.'\'');

                if(count($results) > '0'){

                    //Okay it's a name, let's pull up their assigned projects, requests, and assignees projects

                    $results["resource"]  = $dbc->query('SELECT * FROM jobs WHERE resource  = \''.$results[0]["index"].'\'');
                    $results["manager"]   = $dbc->query('SELECT * FROM jobs WHERE manager   = \''.$results[0]["index"].'\'');
                    $results["requestor"] = $dbc->query('SELECT * FROM jobs WHERE requestor = \''.$results[0]["index"].'\'');
                }
            }else{

                //Search is a number therefore it must be a project id
                $query = 'SELECT * FROM jobs WHERE project_id = \''.$search.'\'';
                $results = $dbc->query($query);

            }



    //Spit out the results
    echo '<pre>'.$query.var_dump($results).'</pre>';
    echo count($results["requestor"]);

    //Close the connection
    $dbc->close();
?>