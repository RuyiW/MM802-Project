<?php session_start(); 
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

$index = 0;
$get_data_sql1 = "SELECT DISTINCT 311_neighbourhood,311_request_status,service_category FROM 311_Explorer";
$result1 = $conn->query($get_data_sql1);
$rows1 = array();
if ($result1->num_rows > 0) {
  $index = 0;
  while($rr = $result1->fetch_assoc()) {
      $CompareReq_Status = strcasecmp($rr["311_request_status"] , 'Close');
      $Compare_ServiceCategory = strcasecmp($rr["service_category"] , '1');
      if(($CompareReq_Status == 0) && ($Compare_ServiceCategory == 0)){
         $rows1[$index] = $rr["311_neighbourhood"];
         $index++;
      }
    }
}

$get_data_sql = "SELECT 311_neighbourhood,311_request_status,service_category,311_count,date_created,date_closed FROM 311_Explorer";
$result = $conn->query($get_data_sql);
$rows = array();
if ($result->num_rows > 0) {
  $i = 0;
  while($r = $result->fetch_assoc()) {
    $CompareReq_Status = strcasecmp($r["311_request_status"] , 'Close');
     $Compare_ServiceCategory = strcasecmp($r["service_category"] , '1');
      if(($CompareReq_Status == 0) && ($Compare_ServiceCategory ==0)){
         $rowsneighbour[$i] = ($r["311_neighbourhood"]);
         $rowsbylawcount[$i] = ($r["311_count"]);
         $rowsdatecreated[$i] = ($r["date_created"]);
         $rowsdateclosed[$i] = ($r["date_closed"]);
         $i++;
      }
    }
}
//print $i;
for($ii = 0; $ii < $index; $ii++){
    $neighbour = $rows1[$ii];
    $count = 0;
    $tempcount = 0;
   for($jj = 0; $jj < $i; $jj++){
    $neighbour1 = $rowsneighbour[$jj];
    $compare_neighbourhood = strcasecmp($neighbour, $neighbour1);
    if($compare_neighbourhood == 0){
            $dateValue = $rowsdatecreated[$jj];
      $dateValue1 = $rowsdateclosed[$jj];
      //Date created
      $time  = strtotime($dateValue);
       $d  = date('d',$time);
     //  echo $d . "<br />\n";
        $m  = date('m',$time);
      //   echo $m . "<br />\n";
        $y  = date('Y',$time);
        //Date closed
      $time1  = strtotime($dateValue1);
        $d1  = date('d',$time1);
        $m1  = date('m',$time1);
    //     echo $m1 . "<br />\n";
        $y1  = date('Y',$time1);
        if ($m == $m1 ){
             $count += ($d1-$d);
        }
        else
        {
          $distance = 0;
          if($m1 > $m){
            for($mon = $m; $mon <$m1 ; $mon++){
               if($mon == 1 || $mon == 3 || $mon== 5 || $mon== 7 || $mon== 8 || $mon== 10 || $mon == 12){
                  $distance += 31 - $d;
                } 
              else{
                  if($mon == 2){
                    if((($y % 4) == 0 && (($y % 100) != 0)) || ($y % 400) == 0)
                    {
                      $distance +=  29 - $d; 
                    }
                    else{
                      $distance +=  28 - $d; 
                    }
                    
                  }
                  else{
                     $distance +=  30 - $d; 
                  }
                 
                }
            }
            $count += ($distance + $d1);
          }
        }
        $tempcount++;
        $rows[$ii] = (int)($count/$tempcount);
    }

   }
}
$result2 = array();
array_push($result2,$rows1);
array_push($result2,$rows);

print json_encode($result2);

?>