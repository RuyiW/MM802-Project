<!-- 
	===========================================================
	This is the file reads request data from json file and 
	store them into tables in database. 
	It should be called at the end of initialization, after 
	making change in php.ini.
	===========================================================
 -->
<?php
// read json file
$str = file_get_contents("311Explorer.json");
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
	// only reads data that matching service categories
	if(($row[13] == "Snow & Ice Maintenance") || ($row[13] == "Vandalism/Graffiti")){
		
		$ticket_num = $row[8];
		$date_created = $row[9];
		$date_closed = $row[10];
		$request_status = $row[11];
		$status_detail = $row[12];
		$service_category = $row[13];
		$service_details = $row[14];
		$business_unit = $row[15];
		$neighbourhood = $row[16];
		$community_league = $row[17];
		$ward = $row[18];
		$address = $row[19];
		$latitude = $row[20];
		$longtitude = $row[21];
		$location_x = $row[22][1];
		$location_y = $row[22][2];
		$ticket_source = $row[23];
		$calendar_year = $row[24];
		$count = $row[25];
		$posse_number = $row[26];
		$transit_ref_number = $row[27];
		$sql = "INSERT INTO 311_Explorer (ticket_number, date_created, date_closed, 311_request_status, 311_status_detail, service_category, business_unit, 
			311_neighbourhood,	community_league, 311_ward, address, 311_latitude, 311_longtitude, 311_location_x, 311_location_y, ticket_source, calendar_year, 311_count, posse_number, transit_ref_number)
		VALUES ( '" . $ticket_num . "', '" . $date_created . "', '" . $date_closed . "', '" . $request_status . "', '" . $status_detail . "', '" . $service_category
		 . "', '" . $business_unit . "', '" . $neighbourhood . "', '" . $community_league . "', '" . $ward . "', '" . $address . "', '" . $latitude . "', '" . 
		 $longtitude . "', '" . $location_x . "', '" . $location_y . "', '" . $ticket_source . "', '" . $calendar_year . "', '" . $count . "', '" . $posse_number . "', '" . $transit_ref_number . "')";

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
//update service category number
$update_sql = "UPDATE 311_Explorer SET service_category = '1' WHERE service_category = 'Snow & Ice Maintenan'"; //select data that matches
if (mysqli_query($conn, $update_sql)) {
	// keep for debugging
	// echo "The record updated successfully";
	// echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$update_sql = "UPDATE 311_Explorer SET service_category = '2' WHERE service_category = 'Vandalism/Graffiti'"; //select data that matches
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
