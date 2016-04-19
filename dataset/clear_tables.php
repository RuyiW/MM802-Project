<!-- 
	===========================================================
	This is the file used for empty tables. 
	To get ready for the new search.
	===========================================================
 -->
<?php

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
//mysql_query("set names utf8;");

$delete_sql = "DELETE FROM temp_311";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM temp_bylaw";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM checked_311_result";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM checked_bylaw_result";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM 311_neighbourhood";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM 311_request_status";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM 311_ward";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM bylaw_status";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM bylaw_year";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM complaint";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM month";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$delete_sql = "DELETE FROM service_category";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}

//close connection to database
$conn->close();


?>