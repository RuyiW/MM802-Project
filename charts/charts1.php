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

//Get the distinct neighbourhood values from 311 dataset
$index = 0;
$get_data_sql1 = "SELECT DISTINCT 311_neighbourhood,311_request_status FROM 311_Explorer";
$result1 = $conn->query($get_data_sql1);
$rows1 = array();
if ($result1->num_rows > 0) {
  $index = 0;
  while($rr = $result1->fetch_assoc()) {
    //Check if the 311 request status is OPEN
      $CompareReq_Status = strcasecmp($rr["311_request_status"] , 'Open');
      if(($CompareReq_Status == 0)){
         $rows1[$index] = $rr["311_neighbourhood"];
         $index++;
      }
    }
}

//Get the 311_neighbourhood, 311_request_status, service_category, 311_count values from 311 dataset
$get_data_sql = "SELECT 311_neighbourhood,311_request_status,service_category,311_count FROM 311_Explorer";
$result = $conn->query($get_data_sql);
$rows = array();
if ($result->num_rows > 0) {
  $i = 0;
  while($r = $result->fetch_assoc()) {
    //Check if the 311 request status is OPEN
    $CompareReq_Status = strcasecmp($r["311_request_status"] , 'Open');
      if(($r["service_category"] != null) && ($CompareReq_Status == 0)){
         $rowsneighbour[$i] = ($r["311_neighbourhood"]);
         $rowsbylawcount[$i] = ($r["311_count"]);
         $i++;
      }
    }
}
//As the dataset has repeated names of neighbourhood. 
//A for loop to add the complaint count for each neighbourhood
//For loop for distinct neighbourhood names
for($ii = 0; $ii < $index; $ii++){
  //Get the name of the neighbourhood.
    $neighbour = $rows1[$ii];
    $count = 0;
    //For loop to check all the neighbourhood that are similar to $neighbour
   for($jj = 0; $jj < $i; $jj++){
    $neighbour1 = $rowsneighbour[$jj];
    $compare_bylawstatus = strcasecmp($neighbour, $neighbour1);
    //Check if the match is found
    if($compare_bylawstatus == 0)
      //Add the number of request count in that neighbourhood
        $count = $count + $rowsbylawcount[$jj];
      //Add the count to the array
        $rows[$ii] = (int)($count);
   }
}
$result2 = array();
//Push the name of neighbourhood and the request count in the new array
array_push($result2,$rows1);
array_push($result2,$rows);
//Json encode the array
print json_encode($result2);

?>