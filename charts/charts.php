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
//Get the distinct neighbourhood values from bylaw dataset
$get_data_sql1 = "SELECT DISTINCT bylaw_neighbourhood,bylaw_status FROM Bylaw";
$result1 = $conn->query($get_data_sql1);
$rows1 = array();
if ($result1->num_rows > 0) {
  $index = 0;
  while($rr = $result1->fetch_assoc()) {
    //Check if the bylaw status is under investigation
    $CompareReq_Status = strcasecmp($rr["bylaw_status"]  , 'Under Investigation');
      if(($CompareReq_Status == 0)){
        //Copy the names of the neighbourhood in an array
         $rows1[$index] = $rr["bylaw_neighbourhood"];
         $index++;
      }
    }
}

//Get the neighbourhood, bylaw status, complaint, bylaw count values from bylaw dataset
$get_data_sql = "SELECT bylaw_neighbourhood,bylaw_status,complaint,bylaw_count FROM Bylaw";
$result = $conn->query($get_data_sql);
$rows = array();
if ($result->num_rows > 0) {
  $i = 0;
  while($r = $result->fetch_assoc()) {
    //Copy all the values that are under investigation
    $CompareReq_Status = strcasecmp($r["bylaw_status"]  , 'Under Investigation');
      if(($r["complaint"] != null) && ($CompareReq_Status == 0)){
         $rowsneighbour[$i] = ($r["bylaw_neighbourhood"]);
         $rowsbylawcount[$i] = ($r["bylaw_count"]);
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
      //Add the number of complaint count in that neighbourhood
        $count +=  $rowsbylawcount[$jj];
      //Add the count to the array
        $rows[$ii] = (int)($count);
   }
}
$result2 = array();
//Push the name of neighbourhood and the complaint count in the new array
array_push($result2,$rows1);
array_push($result2,$rows);
//Json encode the array
print json_encode($result2);

?>