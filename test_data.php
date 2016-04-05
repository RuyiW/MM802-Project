<?php


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



  $id = $_GET['id'];
//$new_ward = str_replace('%20', ' ', $ward);
echo "in data.php";
$data_sql = "SELECT para FROM content WHERE  para_id='$id'"; //select data that matches
$data_result = $conn->query($data_sql);//get returned result

if ($data_result->num_rows > 0) {
	while($row = $data_result->fetch_assoc()) {
		echo $row["para"];

	}
}
?>