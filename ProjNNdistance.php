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
//Delete the match result distance table
$sql = "DELETE FROM match_resultdistance;";
          if (mysqli_query($conn, $sql)) {
          //  echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
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
//Delete the match result neighbourhood           
$sql = "DELETE FROM match_resultNeighbourhood ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
//Funtion To calculate distance based on latitude an longitude
function CalculateDistance($latitude,$longitude,$lat,$long){
$R = 6371;
$dlon = deg2rad($long - $longitude) ;
$dlat = deg2rad($lat - $latitude) ;
$a = pow(sin($dlat/2),2) + cos(deg2rad($latitude)) * cos(deg2rad($lat)) * pow(sin($dlon/2),2);
$c = 2 * atan2(sqrt($a), sqrt(1-$a));
$distkm = $R * $c; 
//return distance in km
return $distkm;
} 

//$thresdist = 5;
//Get the distance from user input
$thresdist = $_GET['distance_value'];
//set the value of k
$k = 1;
$count = 0;
//head of the table
echo "<thead>";
echo "<tr>";
echo "<th>Complaint Number</th>";
echo "<th>Ticket Number</th>";
echo "<th>DistanceinKm</th>";
echo "</tr>";
echo "</thead>";
//Loop for all the complaints
for ($j = 1; $j < 101; $j++){
   
    $distance = INF;
     //Get year, month and type of complaint 
    $year = $complaint_bylaw_year[$j];
    $month =  $complaint_month_number[$j];
    $typeofComplaint = $complaint_type[$j];
    $bylawstatus = $complaint_bylaw_status[$j];
    //Check if the complaint is under investigation
    $compare_bylawstatus = strcasecmp($bylawstatus, 'Under Investigation');
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
     //Calculate the length of an array
      $arraylength = count($distarray);
      //Get the minimum value from the distarray
        $val = min($distarray);
        //Check if the minimum value is less than inf
          if ($val < INF) {
            //get the ndex where the value is minimum
             $idx = array_search($val, $distarray);
             //Get the latitude nad longitude present at that index
             $latitudebase  = $array_311_latitude[$idx];
             $longitudebase = $array_311_longitude[$idx];
             //HTML body
              echo "<tbody>";
              echo "<tr>";
              echo "<td>".$j."</td>";
              echo "<td>".$array_ticket_number[$idx]."</td>";
              echo "<td>" .'0'."</td>";
              echo "</tr>";
              echo "</tbody>";
              //insert attributes in SQL table
              $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, service_category, 311_latitude,311_longtitude , distkm) 
               VALUES (' $j  ',' " . $array_ticket_number[$idx] . " ' , ' " . $array_service_category[$idx] . " ',' " . $latitudebase . " ',' " . $longitudebase . "', '0')";
               if (mysqli_query($conn, $sql)) {
                //echo "New record created successfully";
               // echo "\n";
              } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                echo "\n";
              }
             $count = $count + 1;
             //All the distances will be calculated from the first closest request 
             //Condition to check if the obtained index is between 1st and last location
          if ($idx > 1 && $idx < $arraylength){
            //Claculate distance for all values less than the index
              for ($i = 1 ; $i < $idx ; $i++){
                //Get the value from distance array
                  $val = $distarray[$i];
                  if ($val < INF){
                    //Get the latitude and longitude
                      $latitude  = $array_311_latitude[$i];
                      $longitude = $array_311_longitude[$i];
                      //calculate the distance in km
                      $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                      //check if the distance is less than or equal to threshold distance
                      if ($distkm <= $thresdist){
                        //HTML table body
                          echo "<tbody>";
                          echo "<tr>";
                          echo "<td>".$j."</td>";
                          echo "<td>".$array_ticket_number[$i]."</td>";
                          echo "<td>".$distkm ."</td>";
                          echo "</tr>";
                          echo "</tbody>";
                          //Insert data into SQL table
                          $sql = "INSERT INTO match_resultdistance (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude , distkm) 
                          VALUES (' $j  ',' " . $array_ticket_number[$i] . " ' , ' " . $array_service_category[$i] . " ',' " . $array_311_latitude[$i] . " ',' " . $array_311_longitude[$i] . "', '$distkm')";
                         if (mysqli_query($conn, $sql)) {
                          //echo "New record created successfully";
                         // echo "\n";
                        } else {
                          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                          echo "\n";
                        }
                        $count = $count + 1;
                      }
                  }
              }
              //Claculate distance for all values greater than the index and less than equal to array length
              for ($i = ($idx + 1); $i <= $arraylength; $i++){
                 //Get the value from distance array
                  $val = $distarray[$i];
                  if ($val < INF){
                    //Get the latitude and longitude
                      $latitude  = $array_311_latitude[$i];
                      $longitude = $array_311_longitude[$i]; 
                      //calculate the distance in km
                      $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                      //check if the distance is less than or equal to threshold distance
                      if ($distkm <= $thresdist){
                        //HTML table body
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<td>".$j."</td>";
                        echo "<td>".$array_ticket_number[$i]."</td>";
                        echo "<td>".$distkm ."</td>";
                        echo "</tr>";
                        echo "</tbody>";
                        //Insert data into SQL table
                         $sql = "INSERT INTO match_resultdistance (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude , distkm) 
                         VALUES (' $j  ',' " . $array_ticket_number[$i] . " ' , ' " . $array_service_category[$i] . " ',' " . $array_311_latitude[$i] . " ',' " . $array_311_longitude[$i] . "', '$distkm')";
                         if (mysqli_query($conn, $sql)) {
                          //echo "New record created successfully";
                         // echo "\n";
                        } else {
                          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                          echo "\n";
                        }
                                  $count = $count + 1;
                      }
                  }
               }
            }
          else {
            //Condition to check if the obtained index is on 1st location
               if ($idx == 1){ 
                //Calculate distance for all values greater than the index and less than equal to array length
                  for ($i = 2; $i <= $arraylength; $i++){
                    //Get the value from distance array
                      $val = $distarray[$i];
                      if ($val < INF){
                        //Get the latitude and longitude
                          $latitude  = $array_311_latitude[$i];
                          $longitude = $array_311_longitude[$i]; 
                           //calculate the distance in km
                          $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                          //check if the distance is less than or equal to threshold distance
                          if ($distkm <= $thresdist){
                            //HTML table body
                              echo "<tbody>";
                              echo "<tr>";
                              echo "<td>".$j."</td>";
                              echo "<td>".$array_ticket_number[$i]."</td>";
                              echo "<td>".$distkm."</td>";
                              echo "</tr>";
                              echo "</tbody>";
                              //Insert data into SQL table
                               $sql = "INSERT INTO match_resultdistance (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude , distkm) 
                               VALUES (' $j  ',' " . $array_ticket_number[$i] . " ' , ' " . $array_service_category[$i] . " ',' " . $array_311_latitude[$i] . " ',' " . $array_311_longitude[$i] . "', '$distkm')";
                               if (mysqli_query($conn, $sql)) {
                                //echo "New record created successfully";
                               // echo "\n";
                              } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                echo "\n";
                              }
                              $count = $count + 1;
                          }
                      }
                  }
                }
               else {
                //Calculate distance for all values greater than the index and less than array length
                   for ($i = 1; $i <= $arraylength - 1; $i++){
                    //Get the value from distance array
                        $val = $distarray[$i];
                        if ($val < INF){
                          //Get the latitude and longitude
                          $latitude  = $array_311_latitude[$i];
                          $longitude = $array_311_longitude[$i]; 
                          //calculate the distance in km
                          $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                          //check if the distance is less than or equal to threshold distance
                          if ($distkm <= $thresdist){
                            //HTML table body
                            echo "<tbody>";
                            echo "<tr>";
                            echo "<td>".$j."</td>";
                            echo "<td>". $array_ticket_number[$i]."</td>";
                            echo "<td>".$distkm ."</td>";
                            echo "</tr>";
                            echo "</tbody>";
                            //Insert data into SQL table
                            $sql = "INSERT INTO match_resultdistance (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude , distkm) 
                            VALUES (' $j  ',' " . $array_ticket_number[$i] . " ' , ' " . $array_service_category[$i] . " ',' " . $array_311_latitude[$i] . " ',' " . $array_311_longitude[$i] . "', '$distkm')";
                            if (mysqli_query($conn, $sql)) {
                              //echo "New record created successfully";
                             // echo "\n";
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                              echo "\n";
                            }
                            $count = $count + 1;
                          }
                      }
                   }
               }
            }  
        }
   }
}
//Close the body of HTML table
echo "</table></body></html>";
echo $count;
?>