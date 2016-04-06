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

$sql = "DELETE FROM match_result;";
          if (mysqli_query($conn, $sql)) {
          //  echo "New record created successfully";
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


$Numrow311Data = 0;

while (!feof($file_handle1) ) {

$line_of_text1[] = fgetcsv($file_handle1, 1024);
$Numrow311Data = $Numrow311Data + 1;
//print $line_of_text[1] . $line_of_text[2]. $line_of_text[3]. $line_of_text[4] . $line_of_text[5]. $line_of_text[6]. "<BR>";
}
//echo $Numrow311Data ."<br />\n";


//set the value of k
$k = 1;
$count = 0;
$varcount = 0;
//$distarray = [];
//echo $NumrowBylaw;
for ($j = 1; $j < (101); $j++) {
   
   $distance = INF;
   //Take the year of complaint
   $year = $line_of_text[$j][0];
 
   //Month
    $month = $line_of_text[$j][1];
 //echo $month . "<br />\n";
   //type of complaint
    $typeofComplaint = $line_of_text[$j][6];
 //echo $typeofComplaint . "<br />\n";

   for ($i = 1; $i < 101 ; $i++) {
   	 
   
   	$dateValue = $line_of_text1[$i][1];

    $time  = strtotime($dateValue);
    $d  = date('d',$time);
    $m  = date('m',$time);
    $y  = date('Y',$time);
  
   	if ($typeofComplaint ==  $line_of_text1[$i][5] && ($year <= $line_of_text1[$i][16])){
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
        	//echo $idx . "<br />\n"; 
           // remove for the next iteration the last smallest value:
          // $Match[$count][0] = $j;
          // echo "here is some thing";
          // echo "The value of j is " . $Match[$count][0] . "<br />\n"; 
          // $Match[$count][1] = $line_of_text1[$idx][0];
           //echo $line_of_text1[$idx][0];
          // echo $Match[$count][1]. "<br />\n"; 
           $count = $count + 1;
           $distarray[$idx] = INF;
           $sql = "INSERT INTO match_result (matched_ticket_number, complaint_number) VALUES (' " . $line_of_text1[$idx][0] . " ' ,  ' $j  ')";
          if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
            //echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
        }
    }
}

echo $count;
fclose($file_handle);
fclose($file_handle1);
$conn->close();
?>