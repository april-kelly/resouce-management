<?php

/**
 * Name:       Builds an Overview
 * Programmer: Liam Kelly
 * Date:       7/24/13
 */

//Make sure the ABSPATH constant is defined
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}

//Needed to execute
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');


//Views Class
class views {

        //Variable Definitions
        public $weeks = array();
        public $show  = '';
        public $hours;

        function __construct(){

            //Get the settings
            $set = new settings;
            $settings = $set->fetch();

            //Define settings
            $this->show	      = $settings['weeks'];

            //Build a list of weeks
            //get the current or last sunday
            if(date( "w", date("U")) == '0'){
                $current = date('Y-m-d');
            }else{
                $current = date('Y-m-d', strtotime('Last Sunday', time()));
            }

            $this->weeks = array();
            $this->weeks[1] = $current;
            for($i = 2; $i <=  $this->show; $i++){
                $this->weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
            }

        }

        //Table build function
        public function build_table(){

            //Setup the data object
            $dbc = new db;
            $dbc->connect();
            $people = $dbc->query('SELECT * FROM people');
            $query = "SELECT * FROM jobs WHERE week_of BETWEEN '". $this->weeks[1]."' AND '". $this->weeks[count($this->weeks)]."' ";
            $jobs = $dbc->query($query);

            foreach($people as $person){

                //Build the table
                $table[$person['index']]['id'] = $person['index'];
                $table[$person['index']]['name'] = $person['firstname'];

                foreach($jobs as $job){

                    foreach($this->weeks as $week){

                        if($job['resource'] == $person['index']){

                                if($job['week_of'] == $week){

                                    //Process the hours

                                    //add everything up
                                    $this->hours =  $this->hours + $job['sunday']
                                        + $job['monday']
                                        + $job['tuesday']
                                        + $job['wednesday']
                                        + $job['thursday']
                                        + $job['friday']
                                        + $job['saturday'];

                                    if($this->hours > 0){

                                        $table[$person['index']][$week] = $this->hours;

                                    }else{

                                        $table[$person['index']][$week] = 0;

                                    }

                                    //empty the hours variable
                                    $this->hours = 0;

                                }else{

                                    if(empty($table[$person['index']][$week])){

                                        $table[$person['index']][$week] = 0;

                                    }

                                }



                        }else{

                            //Person has no job(s) or job(s) have not been found yet
                            if(empty($table[$person['index']][$week])){

                                //Set hours to 0
                                $table[$person['index']][$week] = 0;

                            }

                        }

                    }

                }

            }


            $dbc->close();
            if(empty($table)){
                $table = false;
            }
            return $table;
        }

        public function build_list_weeks($person, $sort){

            //connect to the database
            $dbc = new db;
            $dbc->connect();

            //Query the database
            $query = "SELECT * FROM jobs WHERE `resource` = ".$person." AND week_of BETWEEN '".$this->weeks[1]."' AND '".$this->weeks[count($this->weeks)]."' ".$sort;
            $list = $dbc->query($query);

            //close the connection
            $dbc->close();

            var_dump($this->weeks);
            return $list;


        }

        public function fix_times($value){

            $time = '0:00';

            if(preg_match('/[0-9][0-9][:][0-9][0-9]/', $value)){

                //String is perfect, Do nothing
                $time = $value;

            }else{

                //Make sure that the string does not contain :
                if(!(preg_match('/[:]/', $value))){

                    //String is H, Add :00
                    $time = $value.':00';

                }

            }

            return $time;

        }



}

