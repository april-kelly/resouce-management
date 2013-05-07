<?php

include_once('new_month.php');
include_once('settings.php');

$results = table();
$table = $results['table'];
$weeks = $results['weeks'];
$colors = fetch(8);
$color_enable = true;


?>
<html>

 <head>
  <title>Bluetent Resource Management: Dashboard</title>
 </head>

 <body>

  <table border="1">

      <tr class="header">
          <td>Resource</td>

<?php

    foreach($weeks as $weeks){
        echo '          <td>'.$weeks.'</td>'."\r\n";
    }

?>


</tr>
<?php
          //echo out each of the rows in the table
          $count = count($weeks);
          $i = 0;

          foreach($table as $table){

          echo "\t".'<tr>'."\r\n";
          echo "\t\t".'<td><a href="./week.php?p='.$table['id'].'">'.$table['name'].'</a></td>'."\r\n";

          for($i = 1; $i <= $count; $i++){
          echo "\t\t".'<td>';

              if($color_enable == true){

              if($table[$i] == 0) { echo '<span class="1">'.$table[$i].'</span>'; }
              if($table[$i] <= $colors[0]['high'] && $table[$i] >= $colors[0]['low']) { echo '<span class="2">'.$table[$i].'</span>'; }
              if($table[$i] <= $colors[1]['high'] && $table[$i] >= $colors[1]['low']) { echo '<span class="3">'.$table[$i].'</span>'; }
              if($table[$i] <= $colors[2]['high'] && $table[$i] >= $colors[2]['low']) { echo '<span class="4">'.$table[$i].'</span>'; }
              if($table[$i] >= $colors[3]['low']) { echo '<span class="5">'.$table[$i].'</span>'; }

              }else{
              echo $table[$i];
              }
              echo '</td>'."\r\n";
          }

          echo "\t".'</tr>'."\r\n\r\n";

      }
      ?>


  </table>

 </body>

</html>