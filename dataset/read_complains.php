<?php
$str = file_get_contents("Bylaw.json");
//./dataset/311Explorer.json
$json = json_decode($str, true);
//echo '<pre>' . print_r($json, true) . '</pre>';
//echo "this is what I got:";

$data = $json['data'];


$host="localhost";
$db_user="root";
$db_pass="";
$db_name="db_relations";

// Create connection
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysql_query("set names utf8;");

$data_length = count($data);
for ($a = 0; $a < $data_length; $a++){
	$row = $data[$a];
	$year = $row[8];
	$month_number = $row[9];
	$month = $row[10];
	$report_period = $row[11];
	$neighbourhood = $row[12];
	$neighbourhood_id = $row[13];
	$complaint = $row[14];
	$initiated_by = $row[15];
	$status = $row[16];
	$count = $row[17];
	$latitude = $row[18];
	$longtitude = $row[19];
	$location_x = $row[20][1];
	$location_y = $row[20][2];
	
	// echo $row[22][0];
	// echo "<br>";
	// echo $row[22][1];
	// echo "<br>";
	// echo $row[22][2];
	// echo "<br>";
	// echo $row[22][3];
	// echo "<br>";
	// echo $row[22][4];
	// echo "<br>";
	$sql = "INSERT INTO Bylaw (year, month_number, month, report_period, neighbourhood, neighbourhood_id, complaint, 
		initiated_by,	status, count, latitude, longtitude, location_x, location_y)
	VALUES ( '" . $year . "', '" . $month_number . "', '" . $month . "', '" . $report_period . "', '" . $neighbourhood . "', '" . $neighbourhood_id
	 . "', '" . $complaint . "', '" . $initiated_by . "', '" . $status . "', '" . $count . "', '" . $latitude . "', '" . $longtitude . "', '" . $location_x . "', '" . $location_y . "')";

	if (mysqli_query($conn, $sql)) {
    	//echo "New record created successfully";
	} else {
    	//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    	//echo "<br>";
	}

	//echo "<br>";
}

echo "numbers: ". $a;

$conn->close();


?>
