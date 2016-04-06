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
$sql = "DELETE FROM match_resultdistance;";
          if (mysqli_query($conn, $sql)) {
          //  echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }

function CalculateDistance($latitude,$longitude,$lat,$long){
$R = 6371;
$dlon = deg2rad($long - $longitude) ;
$dlat = deg2rad($lat - $latitude) ;
//$a = (sin($dlat/2))^2 + cos(deg2rad($latitude)) * cos(deg2rad($lat)) * (sin($dlon/2))^2;
$a = pow(sin($dlat/2),2) + cos(deg2rad($latitude)) * cos(deg2rad($lat)) * pow(sin($dlon/2),2);
$c = 2 * atan2(sqrt($a), sqrt(1-$a));
$distkm = $R * $c; //%(where R is the radius of the Earth)
return $distkm;
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

$thresdist = 5;
//set the value of k
$k = 1;
$count = 0;
$varcount = 0;
//$distarray = [];
for ($j = 1; $j < 11; $j++) {
   
   $distance = INF;
   //Take the year of complaint
   $year = $line_of_text[$j][0];
 
   //Month
    $month = $line_of_text[$j][1];
 //echo $month . "<br />\n";
   //type of complaint
    $typeofComplaint = $line_of_text[$j][6];
 //echo $typeofComplaint . "<br />\n";

   for ($i = 1; $i < 11 ; $i++) {
   	 
   
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
   $arraylength = count($distarray);
  // echo "array length" . $arraylength ;
        //[val(kval),idx] = min(distarray);
   		$val = min($distarray);
   	//	echo "The value is " . $val . "<br />\n"; 
        if ($val < INF) {
           $idx = array_search($val, $distarray);
        	 $latitudebase  = $line_of_text1[$idx][12];
           $longitudebase = $line_of_text1[$idx][13];
          // $Match[$count][0] = $j;
          // $Match[$count][1] = $line_of_text1[$idx][0];
          //  $Match[$count][2] =0;
             $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, distkm ) VALUES (' $j  ',' " . $line_of_text1[$idx][0] . " ' ,' 0 ')";
          if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
            //echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
           // echo "I am in main loop";
          // echo $Match[$count][0] ."<br />\n";
         // echo $Match[$count][1] ."<br />\n";
         // echo $Match[$count][2] ."<br />\n";
           $count = $count + 1;
        if ($idx > 1 && $idx < $arraylength){
            for ($i = 1 ; $i < $idx ; $i++){
                $val = $distarray[$i];
                if ($val < INF){
                    $latitude  = $line_of_text1[$i][12];
                    $longitude = $line_of_text1[$i][13]; 
                    $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                    if ($distkm <= $thresdist){
                       // $Match[$count][0] = $j;
                      //  $Match[$count][1] = $line_of_text1[$i][0];
                       // $Match[$count][2] = $distkm;
                       // echo "I am in 1st loop";
                      //  echo $Match[$count][0] ."<br />\n";
                      //  echo $Match[$count][1] ."<br />\n";
                      //  echo $Match[$count][2] ."<br />\n";
                           $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, distkm ) VALUES (' $j  ',' " . $line_of_text1[$i][0] . " ' ,' $distkm ')";
                            if (mysqli_query($conn, $sql)) {
                              //echo "New record created successfully";
                              //echo "\n";
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                              echo "\n";
                            }
                        $count = $count + 1;
                    }
                }
            }
            for ($i = ($idx + 1); $i <= $arraylength; $i++){
                $val = $distarray[$i];
                if ($val < INF){
                    $latitude  = $line_of_text1[$i][12];
                    $longitude = $line_of_text1[$i][13]; 
                    $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                    if ($distkm <= $thresdist){
                       // $Match[$count][0] = $j;
                       // $Match[$count][1] = $line_of_text1[$i][0];
                       // $Match[$count][2] = $distkm;
                         $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, distkm ) VALUES (' $j  ',' " . $line_of_text1[$i][0] . " ' ,' $distkm ')";
                            if (mysqli_query($conn, $sql)) {
                              //echo "New record created successfully";
                              //echo "\n";
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                              echo "\n";
                            }
                       // echo "I am in 2nd loop";
                       // echo $Match[$count][0] ."<br />\n";
                       // echo $Match[$count][1] ."<br />\n";
                       // echo $Match[$count][2] ."<br />\n";
                        $count = $count + 1;
                    }
                }
             }
          }
        else {
             if ($idx == 1){ 
                for ($i = 2; $i <= $arraylength; $i++){
                    $val = $distarray[$i];
                    if ($val < INF){
                        $latitude  = $line_of_text1[$i][12];
                        $longitude = $line_of_text1[$i][13]; 
                        $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                        if ($distkm <= $thresdist){
                          //  $Match[$count][0] = $j;
                          //  $Match[$count][1] = $line_of_text1[$i][0];
                           // $Match[$count][2] = $distkm;
                             $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, distkm ) VALUES (' $j  ',' " . $line_of_text1[$i][0] . " ' ,' $distkm ')";
                            if (mysqli_query($conn, $sql)) {
                              //echo "New record created successfully";
                              //echo "\n";
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                              echo "\n";
                            }
                          //   echo "I am in 3rd loop";
                           // echo $Match[$count][0] ."<br />\n";
          //echo $Match[$count][1] ."<br />\n";
         // echo $Match[$count][2] ."<br />\n";
                            $count = $count + 1;
                        }
                    }
                }
              }
             else {
                 for ($i = 1; $i <= $arraylength - 1; $i++){
                      $val = $distarray[$i];
                      if ($val < INF){
                        $latitude  = $line_of_text1[$i][12];
                        $longitude = $line_of_text1[$i][13]; 
                        $distkm = CalculateDistance($latitudebase,$longitudebase,$latitude,$longitude);
                        if ($distkm <= $thresdist){
                            //$Match[$count][0] = $j;
                           // $Match[$count][1] = $line_of_text1[$i][0];
                           // $Match[$count][2] = $distkm;
                             $sql = "INSERT INTO match_resultdistance (complaint_number, matched_ticket_number, distkm ) VALUES (' $j  ',' " . $line_of_text1[$i][0] . " ' ,' $distkm ')";
                            if (mysqli_query($conn, $sql)) {
                              //echo "New record created successfully";
                              //echo "\n";
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                              echo "\n";
                            }
                            // echo "I am in 4th loop";
                           // echo $Match[$count][0] ."<br />\n";
                            // echo $Match[$count][1] ."<br />\n";
                            //  echo $Match[$count][2] ."<br />\n";
                            $count = $count + 1;
                        }
                    }
                 }
             }
          }
          
        }
}
echo $count;
fclose($file_handle);
fclose($file_handle1);
?>



