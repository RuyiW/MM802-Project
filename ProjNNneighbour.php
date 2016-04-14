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
  //$link_address = 'dataset/exportTable.php';
//echo "<a href='dataset/exportTable.php' download></a>";
//echo "<a href= $link_address >Link</a>";
?>

 <?php

echo "<html><head><link rel='stylesheet' type='text/css' href='./css/style.css' media='all'></head><body><table id = 'sweta' border=1>";
$get_data_sql = "SELECT ticket_number, date_created, 311_request_status, service_category, 311_neighbourhood,311_latitude, 311_longtitude FROM 311_Explorer";
$result = $conn->query($get_data_sql);

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


$get_data_sql1 = "SELECT bylaw_year, month_number, bylaw_neighbourhood, complaint, bylaw_status, bylaw_latitude,bylaw_longtitude FROM Bylaw";
$result1 = $conn->query($get_data_sql1);

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


$sql = "DELETE FROM match_resultNeighbourhood ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }

$sql = "DELETE FROM match_resultdays ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
      
$sql = "DELETE FROM match_resultdistance ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
      
      
      
$NumrowBylaw = 0;

//set the value of k
//$k = 1;
$k = $_GET['k_value'];
$count = 0;
echo "<thead>";
echo "<tr>";
echo "<th>Complaint Number</th>";
echo "<th>Ticket Number</th>";
echo "</tr>";
echo "</thead>";

for ($j = 1; $j < 101 ; $j++) {
   
    $distance = INF;
    $year = $complaint_bylaw_year[$j];
    $month =  $complaint_month_number[$j];
    $typeofComplaint = $complaint_type[$j];
    $Neighbourhood = $complaint_bylaw_neighbourhood[$j];
    $bylawstatus = $complaint_bylaw_status[$j];
    $compare_bylawstatus = strcasecmp($bylawstatus, 'Under Investigation');
    if($compare_bylawstatus == 0){   
       for ($i = 1; $i <  101 ; $i++) {
         
        $NeighbourhoodReq = $array_311_neighbourhood[$i];
         // echo $NeighbourhoodReq . "<br />\n";
        $CompareStr = strcasecmp($Neighbourhood , $NeighbourhoodReq);

        $dateValue = $array_date_created[$i];

        $Req_status = $array_request_status[$i];

        $CompareReq_Status = strcasecmp($Req_status , 'Open');

        $time  = strtotime($dateValue);
        $d  = date('d',$time);
        $m  = date('m',$time);
        $y  = date('Y',$time);

         if ($typeofComplaint ==  $array_service_category[$i] && ($CompareReq_Status == 0) && ($year <= $y) && ($CompareStr == 0)){
              //If request month and complaint month is similar
              if ($m == $month && ($year == $y)){
                  $distance = $d;

               }
               else if($m == $month && ($year < $y)){
                  $diffyear = ($y - $year)*365;
                  $distance = $d +  $diffyear;
               }
               //If request month is greater than complaint month
               else if ($m > $month && ($year == $y)){
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

       //  echo $distance ."<br />\n";
         $distarray[$i] = $distance;
         $distance = INF;
        // echo  $distarray[$i] . "<br />\n";
       }
      
       for ($kval=0; $kval <= $k; $kval++){
           // echo "I am in the loop";
            //[val(kval),idx] = min(distarray);
            $val = min($distarray);
            
        //  echo "The value is " . $val . "<br />\n"; 
            if ($val < INF) {
              $idx = array_search($val, $distarray);
              echo "<tbody>";
              echo "<tr>";
              echo "<td>".$j."</td>";
              echo "<td>".$array_ticket_number[$idx]."</td>";
              echo "</tr>";
              echo "</tbody>";
               $count = $count + 1;
               $distarray[$idx] = INF;
               $sql = "INSERT INTO match_resultNeighbourhood (complaint_number,matched_ticket_number, service_category,311_latitude,311_longtitude) 
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
echo "</table></body></html>";
echo $count;
?>