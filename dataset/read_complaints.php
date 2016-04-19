<!-- 
	===========================================================
	This is the file reads complaints data from json file and 
	store them into tables in database. 
	It should be called at the end of initialization, after 
	making change in php.ini.
	===========================================================
 -->
<?php
// read json file
$str = file_get_contents("Bylaw.json");
$json = json_decode($str, true);

$data = $json['data'];


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
// mysql_query("set names utf8;");

$data_length = count($data);
// only read first 100 matching rows
$short_length = 100;
$a = 0;
$b = 0;
while (($a < $data_length) && ($b < $short_length)){//if not reach the end
	$row = $data[$a];
	// only reads data that matching complaint type
	if(($row[14] == 'Snow/Ice On Walk') || ($row[14] == 'Graffiti') || ($row[14] == 'Nuisance Property')){
		$row = $data[$a];
		$complaint_number = $a + 1;
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
		$sql = "INSERT INTO Bylaw (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, bylaw_neighbourhood_id, complaint, 
			initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y)

		VALUES ( '" . $complaint_number . "', '" . $year . "', '" . $month_number . "', '" . $month . "', '" . $report_period . "', '" . $neighbourhood . "', '" . $neighbourhood_id
		 . "', '" . $complaint . "', '" . $initiated_by . "', '" . $status . "', '" . $count . "', '" . $latitude . "', '" . $longtitude . "', '" . $location_x . "', '" . $location_y . "')";

		if (mysqli_query($conn, $sql)) {
			// keep for debugging
	    	//echo "New record created successfully";
		} else {
			// keep for debugging
	    	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	    	echo "<br>";
		}
		$b++;
	}
	$a++;
}
//update complaint number
$update_sql = "UPDATE Bylaw SET complaint = '1' WHERE complaint = 'Snow/Ice On Walk'"; //select data that matches
if (mysqli_query($conn, $update_sql)) {
	// keep for debugging
	// echo "The record updated successfully";
	// echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$update_sql = "UPDATE Bylaw SET complaint = '2' WHERE complaint = 'Graffiti'"; //select data that matches
if (mysqli_query($conn, $update_sql)) {
	// keep for debugging
	// echo "The record updated successfully";
	// echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$update_sql = "UPDATE Bylaw SET complaint = '2' WHERE complaint = 'Nuisance Property'"; //select data that matches
if (mysqli_query($conn, $update_sql)) {
	// keep for debugging
	// echo "The record updated successfully";
	// echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}


echo "Lines read before find 100 matching data: ". $a;
//close connection to database
$conn->close();


?>
