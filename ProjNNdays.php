<?php session_start(); 
  //include_once './dataset/read_data.php';
  $host="localhost";
  $db_user="root";
  $db_pass="";
  $db_name="db_relations_short";
  // Create connection
  $conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
?>

<?php
//HTML Table 
echo "<html><head><link rel='stylesheet' type='text/css' href='./css/style.css' media='all'></head><body><table id = 'sweta' border=1>";

//Read attributes from 311 explorer dataset
$get_data_sql = "SELECT ticket_number, date_created, 311_request_status, service_category, 311_neighbourhood,311_latitude, 311_longtitude FROM 311_Explorer";
$result = $conn->query($get_data_sql);

//Copy the attributes in an array
if ($result->num_rows > 0) {
  $index = 1;
  while($row = $result->fetch_assoc()) {
      if($row["service_category"] != null){
        $array_ticket_number[$index] = $row["ticket_number"];
        $array_date_created[$index] = $row["date_created"];
        $array_request_status[$index] = $row["311_request_status"];
        $array_service_category[$index] = $row["service_category"];
        $array_311_neighbourhood[$index] = $row["311_neighbourhood"];
        $array_311_latitude[$index] = $row["311_latitude"];
        $array_311_longitude[$index] = $row["311_longtitude"];
        $index++;
      }
    }
}

//Read attributes from Bylaw dataset
$get_data_sql1 = "SELECT bylaw_year, month_number, bylaw_neighbourhood, complaint, bylaw_status, bylaw_latitude,bylaw_longtitude FROM Bylaw";
$result1 = $conn->query($get_data_sql1);

//Copy the attributes in array
if ($result1->num_rows > 0) {
  $index = 1;
  while($row = $result1->fetch_assoc()) {
      if($row["complaint"] != null){
        $complaint_bylaw_year[$index] = $row["bylaw_year"];
        $complaint_month_number[$index] = $row["month_number"];
        $complaint_bylaw_neighbourhood[$index] = $row["bylaw_neighbourhood"];
        $complaint_type[$index] = $row["complaint"];
        $complaint_bylaw_status[$index] = $row["bylaw_status"];
        $complaint_bylaw_latitude[$index] = $row["bylaw_latitude"];
        $complaint_bylaw_longtitude[$index] = $row["bylaw_longtitude"];
        $index++;
      }
    }
}


//Delete the match result days table
$sql = "DELETE FROM match_resultdays ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
  //Delete the match result distance table        
$sql = "DELETE FROM match_resultdistance ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
 //Delete the match result neighbourhood table         
$sql = "DELETE FROM match_resultNeighbourhood ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
          
//$k = 1;
//get the value of k from user
$k = $_GET['k_value'];
//get the days apart value from user
$daysapart = $_GET['day_value'];
//$daysapart = 7;
$count = 0;

//head of the table
echo "<thead>";
echo "<tr>";
echo "<th>Complaint Number</th>";
echo "<th>Ticket Number</th>";
echo "</tr>";
echo "</thead>";

//Loop for all the complaints

for ($j = 1; $j < 101 ; $j++) {
   
    $distance = INF;
    //Get year, month and type of complaint 
    $year = $complaint_bylaw_year[$j];
    $month =  $complaint_month_number[$j];
    $typeofComplaint = $complaint_type[$j];
   //Check if the complaint is under investigation
    $bylawstatus = $complaint_bylaw_status[$j];
    $compare_bylawstatus = strcasecmp($bylawstatus, 'Under Investigation');
    //Check if the bylaw status is under investigation
    if($compare_bylawstatus == 0){  
    //Loop through all the requests  
       for ($i = 1; $i <  101 ; $i++) {
         //Get the date when the request was created
        $dateValue = $array_date_created[$i];
        // Check if the request status is open 
        $Req_status = $array_request_status[$i];

        $CompareReq_Status = strcasecmp($Req_status , 'Open');
        // Parse the date
        $time  = strtotime($dateValue);
        $d  = date('d',$time);
        $m  = date('m',$time);
        $y  = date('Y',$time);
         //Condition to check if the type of complaint and request is equal, the request status is open 
        //the complaint year is less that or eual to request year 
         if ($typeofComplaint ==  $array_service_category[$i] && ($CompareReq_Status == 0) && ($year <= $y)){
              //If request month and complaint month is similar also the year when they were reported
              if ($m == $month && ($year == $y)){
                //Calculate distance in days 
                  $distance = $d;

               }
               //If request month and complaint month is similar and the complaint year is less than request year
               else if($m == $month && ($year < $y)){
                //Calculate distance in days 
                  $diffyear = ($y - $year)*365;
                  $distance = $d +  $diffyear;
               }
               //If request month is more than complaint month and the complaint year is equal request year
               else if ($m > $month && ($year == $y)){
                //Calculate distance in days 
                  $distance = 0;
                  for($mon = $month; $mon <$m ; $mon++){
                     if($mon == 1 || $mon == 3 || $mon== 5 || $mon== 7 || $mon== 8 || $mon== 10 || $mon == 12){
                        $distance += 31;
                      } 
                    else{
                        if($mon == 2){
                          if((($y % 4) == 0 && (($y % 100) != 0)) || ($y % 400) == 0)
                          {
                            $distance +=  29; 
                          }
                          else{
                            $distance +=  28; 
                          }
                          
                        }
                        else{
                           $distance +=  30 ; 
                        }
                       
                      }
                  }
                 $distance += $d;
              }
              else{
                //If request month is more or less than complaint month, and complaint year is less than request year
                $distance = 0;
                for ($mon = $month; $mon<=12 ; $mon++)
                {
                   if($mon == 1 || $mon == 3 || $mon== 5 || $mon== 7 || $mon== 8 || $mon== 10 || $mon == 12){
                        $distance += 31;
                      } 
                    else{
                        if($mon == 2){
                          if((($year % 4) == 0 && (($year % 100) != 0)) || ($year % 400) == 0)
                          {
                            $distance +=  29; 
                          }
                          else{
                            $distance +=  28; 
                          }
                          
                        }
                        else{
                           $distance +=  30 ; 
                        }
                       
                    }
                }
                for ($newmon = 1; $newmon < $m ; $newmon++)
                {
                   if($newmon == 1 || $newmon == 3 || $newmon == 5 || $newmon == 7 || $newmon == 8 || $newmon == 10 || $newmon == 12){
                        $distance += 31;
                      } 
                    else{
                        if($mon == 2){
                          if((($y % 4) == 0 && (($y % 100) != 0)) || ($y % 400) == 0)
                          {
                            $distance +=  29; 
                          }
                          else{
                            $distance +=  28; 
                          }
                          
                        }
                        else{
                           $distance +=  30 ; 
                        }
                       
                    }
                }
                $distance += $d;

              }
         }
       // Copy all the distances in an array
         $distarray[$i] = $distance;
         $distance = INF;
        
       }
       //Initialize the minimum value to 0
       $minval = 0;
       //Loop for k values. Find all the k minimum values
       for ($kval=0; $kval <= $k; $kval++){
              //Take the minimum value from the distarray
            $val = min($distarray);
         //Check if the minimum value is less than inf
            if ($val < INF){
              //Calculate the days apart from the minimum value
              if ($kval ==0){
              $minval = $val;
              //Get the index
              $idx = array_search($val, $distarray);
              //Add to HTML table
              echo "<tbody>";
              echo "<tr>";
              echo "<td>".$j."</td>";
              echo "<td>".$array_ticket_number[$idx]."</td>";
              echo "</tr>";
              echo "</tbody>";
               $count = $count + 1;
               $distarray[$idx] = INF;
               //Update the SQL table
               $sql = "INSERT INTO match_resultdays (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude) 
               VALUES (' $j  ',' " . $array_ticket_number[$idx] . " ' , ' " . $array_service_category[$idx] . " ',' " . $array_311_latitude[$idx] . " ',' " . $array_311_longitude[$idx] . " ' )";
                 if (mysqli_query($conn, $sql)) {
                  //echo "New record created successfully";
                 // echo "\n";
                } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                  echo "\n";
                }
              }
              else
              {
                //All the distances will be calculated from the first minimum value.
                //Daysapart is a threshold. All the values less than equal to threshold are displayed in HTML table
                //and added to SQL table
                if(($val - $minval) <=  $daysapart)
                {
                  $idx = array_search($val, $distarray);
                  //Add to html table
                  echo "<tbody>";
                  echo "<tr>";
                  echo "<td>".$j."</td>";
                  echo "<td>".$array_ticket_number[$idx]."</td>";
                  echo "</tr>";
                  echo "</tbody>";
                   $count = $count + 1;
                   $distarray[$idx] = INF;
                   //Update the sql table
                   $sql = "INSERT INTO match_resultdays (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude) 
                   VALUES (' $j  ',' " . $array_ticket_number[$idx] . " ' , ' " . $array_service_category[$idx] . " ',' " . $array_311_latitude[$idx] . " ',' " . $array_311_longitude[$idx] . " ' )";
                     if (mysqli_query($conn, $sql)) {
                      //echo "New record created successfully";
                     // echo "\n";
                    } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                      echo "\n";
                    }
                }
              }

            }
        }

    }
}
//Close the body of HTML table
echo "</table></body></html>";
//echo $count;
?>