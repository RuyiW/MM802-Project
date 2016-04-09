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
  $link_address = 'dataset/exportTable.php';
//echo "<a href='dataset/exportTable.php' download></a>";
echo "<a href= $link_address >Link</a>";
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



$sql = "DELETE FROM match_resultNeighbourhood ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
$NumrowBylaw = 0;

//Read both csv files
$file_handle = fopen("Bylaw.csv", "r");
$file_handle1 = fopen("311Data.csv", "r");

//Copy all the data untill end of file
while (!feof($file_handle) ) {

$line_of_text[] = fgetcsv($file_handle, 1024);
$NumrowBylaw = $NumrowBylaw + 1;
//print $line_of_text[1] . $line_of_text[2]. $line_of_text[3]. $line_of_text[4] . $line_of_text[5]. $line_of_text[6]. "<BR>";
}
//echo $NumrowBylaw ."<br />\n";
//close the file


// $Numrow311Data = 0;

// while (!feof($file_handle1) ) {

// $line_of_text1[] = fgetcsv($file_handle1, 1024);
// $Numrow311Data = $Numrow311Data + 1;
// //print $line_of_text[1] . $line_of_text[2]. $line_of_text[3]. $line_of_text[4] . $line_of_text[5]. $line_of_text[6]. "<BR>";
// }
//echo $Numrow311Data ."<br />\n";


//set the value of k
$k = 1;
$count = 0;
echo "<thead>";
echo "<tr>";
echo "<th>Complaint Number</th>";
echo "<th>Ticket Number</th>";
echo "</tr>";
echo "</thead>";

for ($j = 1; $j < $NumrowBylaw -1 ; $j++) {
   
   $distance = INF;
   //Take the year of complaint
   $year = $line_of_text[$j][0];
 
   //Month
    $month = $line_of_text[$j][1];
 //echo $month . "<br />\n";
   //type of complaint
    $typeofComplaint = $line_of_text[$j][6];
 //echo $typeofComplaint . "<br />\n";
    //neighbourhoodname
    $Neighbourhood = $line_of_text[$j][4];
 //echo $Neighbourhood . "<br />\n";
    $CompMatchReq = 0;
   for ($i = 1; $i <  101 ; $i++) {
   	 
   	$NeighbourhoodReq = $array_311_neighbourhood[$i];
   	 // echo $NeighbourhoodReq . "<br />\n";
   	$CompareStr = strcasecmp($Neighbourhood , $NeighbourhoodReq);

   	$dateValue = $array_date_created[$i];

    $Req_status = $array_request_status[$i];

    $CompareReq_Status = strcasecmp($Req_status , 'Open');

   	// $parts = explode(" ", $dateValue);
    // echo $parts;
    // $month = $parts("month");
    // $d = $parts("day");
    // $y = $parts("year");

    // $m = date("m", strtotime($month));

    $time  = strtotime($dateValue);
    $d  = date('d',$time);
    $m  = date('m',$time);
    $y  = date('Y',$time);
    // $time=strtotime($dateValue);
    // $m=date("F",$time);
   // echo $m . "<br />\n"; 
    // $y=date("Y",$time);
  //  echo $y . "<br />\n";
    // $d=date("j",$time);
  //  echo $d . "<br />\n";
 // echo $line_of_text1[$i][4]; 
   

   	 if ($typeofComplaint ==  $array_service_category[$i] && ($CompareReq_Status == 0) && ($year <= $y) && ($CompareStr == 0)){
          //If request month and complaint month is similar
          if ($m == $month ){
              $distance = $d;

           }
          else{
          	//If request month is greater than complaint month
              if ($m > $month ){
                  if($m == 1 || $m == 3 || $m== 5 || $m== 7 || $m== 8 || $m== 10 || $m == 12){
                  $distance = 31 + $d;
                  }
                  else{
                  $distance =  30 + $d;  
                  }
              }

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
   	//	echo "The value is " . $val . "<br />\n"; 
        if ($val < INF) {
        	$idx = array_search($val, $distarray);
          echo "<tbody>";
           echo "<tr>";
        	//echo $idx . "<br />\n"; 
           // remove for the next iteration the last smallest value:
          // $Match[$count][0] = $j;
          // echo "The value of j is " . $Match[$count][0] . "<br />\n"; 
            echo "<td>".$j."</td>";
            echo "<td>".$array_ticket_number[$idx]."</td>";
         //  $Match[$count][1] = $line_of_text1[$idx][0];
          // echo $Match[$count][1]. "<br />\n"; 
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
echo "</table></body></html>";

echo $count;
fclose($file_handle);
fclose($file_handle1);
?>