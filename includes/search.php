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

    //Settings
    $set = new settings;
    $setting = $set->fetch();

    //Variable definitions
    $user_id = '';
    $type = '';
    $show = $settings['weeks'];

    //Connect to the database
    $dbc = new db;
    $dbc->connect();
    $search = $dbc->sanitize($_REQUEST['q']);

    //build a list of weeks

    //get the current or last sunday
    if(date( "w", date("U")) == '0'){
        $current = date('Y-m-d');
    }else{
        $current = date('Y-m-d', strtotime('Last Sunday', time()));
    }

    $weeks = array();
    $weeks[1] = $current;
    for($i = 2; $i <= $show; $i++){
        $weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
    }
    $count = count($weeks);

        //Algorithm

            //Step 1: Determine if the search is only numbers
            if(!(empty($search))){
                if(!(is_numeric($search))){

                    //Lets see if it is a name
                    $people = $dbc->query('SELECT * FROM people WHERE name = \''.$search.'\'');

                    if(count($people) > '0'){

                        //Okay it's a name, let's pull up their assigned projects, requests, and assignees projects
                        $user_id = $people[0]['index'];

                        $results["resource"]  = $dbc->query('SELECT * FROM jobs WHERE resource  = \''.$people[0]["index"].'\' AND week_of BETWEEN \''.$weeks[1].'\' AND \''.$weeks[$count].'\'');
                        $results["manager"]   = $dbc->query('SELECT * FROM jobs WHERE manager   = \''.$people[0]["index"].'\' AND week_of BETWEEN \''.$weeks[1].'\' AND \''.$weeks[$count].'\'');
                        $results["requestor"] = $dbc->query('SELECT * FROM jobs WHERE requestor = \''.$people[0]["index"].'\' AND week_of BETWEEN \''.$weeks[1].'\' AND \''.$weeks[$count].'\'');

                        //Get rid of empty results
                        if($results["resource"] == false){
                            unset($results["resource"]);
                        }
                        if($results["manager"] == false){
                            unset($results["manager"]);
                        }
                        if($results["requestor"] == false){
                            unset($results["requestor"]);
                        }

                        //While were at it we'll let the rest of the script know how to display this
                        $type = 'name';
                    }
                }else{

                    //Search is a number therefore it must be a project id
                    $query = 'SELECT * FROM jobs WHERE project_id = \''.$search.'\' AND week_of BETWEEN \''.$weeks[1].'\' AND \''.$weeks[$count].'\'';
                    $results = $dbc->query($query);

                    //Let the display section know this is a project
                    $type = 'project';
                }
            }


    //Display Results
    if($type == 'name'){
        foreach($results as $result){

            ?>
            <span id="person">
                <p>
                <img src="./includes/images/blank.jpg" alt="An image" />
                <b class="name"><?php echo $people[0]["name"]; ?></b><br />
            <?php
                if($people[0]["type"] == '0'){
                    echo 'Project Manager/Resource';
                }elseif($people[0]["type"] == '1'){
                    echo 'Project Manager';
                }elseif($people[0]["type"] == '2'){
                    echo 'Project Resource';
                }
            echo '<br>Request(s): '.count($results["requestor"]);
            echo '<br>Managing: '.count($results["manager"]);
            echo '<br>Resource on: '.count($results["resource"]);
            ?>
                </p>
            </span>
            <div id="spacer"><p> </p></div>
            <?php

            //Display the persons projects
            $_SESSION['person'] = $user_id;
            $_SESSION['show_type'] = 'person';

            echo '<div id="results">';
            include_once('week.php');
            echo '</div>';

        }
    }

    if($type == 'project'){

        //Display a project
        $_SESSION['project'] = $search;
        $_SESSION['show_type'] = 'person';

        echo '<div id="results">';
        include_once('week.php');
        echo '</div>';

    }

    if($type == ''){

        //Either no results found or user has not entered a query
        echo '<p class="info">No results were found.</p>';

    }

    //Close the connection
    $dbc->close();
?>