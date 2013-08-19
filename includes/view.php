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
        public $temp_hours = array();

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
        public function build_table($page_offset, $page_count){

            //Setup the data object
            $dbc = new db;
            $dbc->connect();
            $people_query = 'SELECT * FROM people LIMIT '.$page_offset.','.$page_count;
            $people = $dbc->query($people_query);
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
                                    $current = time();

                                    $times = array(
                                        "sunday"    => $job['sunday'],
                                        "monday"    => $job['monday'],
                                        "tuesday"   => $job['tuesday'],
                                        "wednesday" => $job['wednesday'],
                                        "thursday"  => $job['thursday'],
                                        "friday"    => $job['friday'],
                                        "saturday"  => $job['saturday']
                                    );

                                    $this->hours = implode(':', $this->add_times($times));

                                    //Figure out if we are adding or not
                                    if($this->hours > 0){

                                        //Okay we are adding
                                        if(isset($table[$person['index']][$week])){
                                            $this->temp_hours[1] = $table[$person['index']][$week];
                                            $this->temp_hours[2] = $this->hours;
                                        }


                                        $table[$person['index']][$week] = implode(':', $this->add_times($this->temp_hours));

                                        //$table[$person['index']][$week] = $table[$person['index']][$week] + $this->hours;

                                    }else{

                                        $table[$person['index']][$week] = 0;

                                    }

                                    //This flags the item as high priority
                                    if($job['priority'] == 0){

                                       $table[$person['index']][$week] = $table[$person['index']][$week].'h';

                                    }



                                }else{

                                    //No Job
                                    if(empty($table[$person['index']][$week])){

                                        if(isset($table[$person['index']][$week])){

                                            $table[$person['index']][$week] = $table[$person['index']][$week] + 0;

                                        }


                                    }

                                }



                        }else{

                            //Person has no job(s) or job(s) have not been found yet
                            if(empty($table[$person['index']][$week])){

                                //Set hours to 0
                                if(isset($table[$person['index']][$week])){

                                    $table[$person['index']][$week] = $table[$person['index']][$week] + 0;;

                                }else{

                                    $table[$person['index']][$week] = '0';

                                }

                            }

                        }

                        //Handle user locking
                        if(!($person['lock_start'] == '0000-00-00')){

                            //Indefinite locking (e.g the person quit or was fired)
                            if($person['lock_start'] <= $week && $person['lock_end'] == '0000-00-00'){

                                if(isset($table[$person['index']][$week])){

                                    if($table[$person['index']][$week] == '0'){

                                        $table[$person['index']][$week] = '--';

                                    }

                                }
                            }

                            if($person['lock_start'] <= $week && $person['lock_end'] >= $week){

                                //Temporary locking (e.g the person is on vacation)
                                if($table[$person['index']][$week] == '0'){

                                    $table[$person['index']][$week] = '--';

                                }
                                if($table[$person['index']][$week] > '0' && !(preg_match('/-/', $table[$person['index']][$week]))){

                                    $table[$person['index']][$week] = $table[$person['index']][$week].'--';

                                }


                            }


                        }


                    }

                    //empty the hours variable
                    $this->hours = 0;

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


        public function add_times($hours){

            $totals = array(0 => 00,1 => 00,2 => 00);

            foreach($hours as $day){

                $day = explode(':', $day);


                if(isset($day[0])){

                    $totals[0] = $totals[0] + $day[0];


                }

                if(isset($day[1])){

                    $totals[1] = $totals[1] + $day[1];


                }

                if(isset($day[2])){

                    $totals[2] = $totals[2] + $day[2];


                }

            }


            if(!(strlen($totals[1]) == 2)){

                $totals[1] = $totals[1].'0';

            }

            if(!(strlen($totals[2]) == 2)){

                $totals[2] = $totals[2].'0';

            }

            //Throw away the seconds
            unset($totals[2]);

            //$total = implode(':', $totals);

            return $totals;

        }

        public function colors ($table_row){

                    //Save the time before it is modified
                    $temp = $table_row;

                    //Get rid of the :00 (or other numbers) at the end of the time
                    $table_row = rtrim($table_row, '0123456789');
                    $table_row = rtrim($table_row, ':');


                    //Echo out the style for the color

                    if(preg_match('/h/', $table_row)){

                        echo '<span class="colors highpriority" >';
                        $temp = trim($temp, '-');

                    }elseif(preg_match('/--/', $table_row)){

                        echo '<span class="colors locked" >';
                        if($temp > '0'){
                            $temp = trim($temp, '-');
                        }

                    }else{

                        if($table_row == 0) {

                            echo '<span class="colors zero" >';

                        }

                        if($table_row <= '15' && $table_row >= '1'){

                            echo '<span class="colors low" >';
                        }

                        if($table_row <= '25' && $table_row >= '16'){

                            echo '<span class="colors medium" >';

                        }

                        if($table_row <= '40' && $table_row >= '26'){

                            echo '<span class="colors high" >';

                        }

                        if($table_row >= '41'){

                            echo '<span class="colors veryhigh" >';

                        }



                    }


                    //echo out the time
                    echo trim($temp, 'h');

                    //end the span
                    echo '</span>';
                    echo "\r\n";


        }


}

