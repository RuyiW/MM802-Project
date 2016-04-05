
<?php
$str = file_get_contents("Ward_boundaries.json");
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
	$ward = $row[8];
	$area_km2 = $row[10];

	$sql = "INSERT INTO Ward_Boundaries (ward, area_km2)
	VALUES ( '" . $ward . "', '" . $area_km2 . "')";

	if (mysqli_query($conn, $sql)) {
    	//echo "New record created successfully";
	} else {
    	//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    	//echo "<br>";
	}

	//echo "<br>";
}

echo "numbers: ". $a;
//=====================================================================

$str = file_get_contents("Neighbourhood_boundaries.json");
//./dataset/311Explorer.json
$json = json_decode($str, true);
//echo '<pre>' . print_r($json, true) . '</pre>';
//echo "this is what I got:";

$data = $json['data'];

$data_length = count($data);
for ($a = 0; $a < $data_length; $a++){
	$row = $data[$a];
	$neighbourhood = $row[8];
	$neighbourhood_id = $row[10];
	$area_km2 = $row[11];

	$sql = "INSERT INTO Neighbourhood_Boundaries (neighbourhood, neighbourhood_id, area_km2)
	VALUES ( '" . $neighbourhood . "', '" . $neighbourhood_id . "', '" . $area_km2 . "')";

	if (mysqli_query($conn, $sql)) {
    	//echo "New record created successfully";
	} else {
    	//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    	//echo "<br>";
	}

	//echo "<br>";
}

echo "numbers: ". $a;
//====================================================================
$str = file_get_contents("Neighbourhood_centroids.json");
//./dataset/311Explorer.json
$json = json_decode($str, true);
//echo '<pre>' . print_r($json, true) . '</pre>';
//echo "this is what I got:";

$data = $json['data'];

$data_length = count($data);
for ($a = 0; $a < $data_length; $a++){
	$row = $data[$a];
	$neighbourhood_id = $row[8];
	$neighbourhood = $row[9];
	$latitude = $row[10];
	$longtitude = $row[11];
	$location_x = $row[12][1];
	$location_y = $row[12][2];

	$sql = "INSERT INTO Neighbourhood_Centroid (neighbourhood_id, neighbourhood, latitude, longtitude, location_x, location_y)
	VALUES ( '" . $neighbourhood_id . "', '" . $neighbourhood . "', '" . $latitude . "', '" . $longtitude . "', '" . $location_x . "', '" . $location_y . "')";

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