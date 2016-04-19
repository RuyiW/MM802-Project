<!-- 
	===========================================================
	This is the file used for store selected data into 
	complaint year table.
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

// array of tables names that needs to join
$table_array = Array("bylaw_year", "complaint", "bylaw_status", "month");
//clear temp table
$delete_sql = "DELETE FROM temp_bylaw";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_bylaw";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
//copy data from checked result to temp table
$copy_sql = "INSERT INTO temp_bylaw SELECT * FROM Bylaw;";
if (mysqli_query($conn, $copy_sql)) {
	// keep for debugging
	//echo "The previous record copyed successfully";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $copy_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}

// get selected data
$bylaw_year = $_GET['bylaw_year'];
$bylaw_year = str_replace('%20', ' ', $bylaw_year);

$data_sql = "SELECT * FROM Bylaw WHERE bylaw_year = '$bylaw_year'"; //select data that matches
$data_result = $conn->query($data_sql);//get returned result

if ($data_result->num_rows > 0) {
	while($row = $data_result->fetch_assoc()) {
		
		if($row["bylaw_year"] != null){

			$the_complaint_number = $row["complaint_number"];
			$the_bylaw_year = $row["bylaw_year"];
			$the_month_number = $row["month_number"];
			$the_month = $row["month"];
			$the_report_period = $row["report_period"];
			$the_bylaw_neighbourhood = $row["bylaw_neighbourhood"];
			$the_bylaw_neighbourhood_id = $row["bylaw_neighbourhood_id"];
			$the_complaint = $row["complaint"];
			$the_initiated_by = $row["initiated_by"];
			$the_bylaw_status = $row["bylaw_status"];
			$the_bylaw_count = $row["bylaw_count"];
			$the_bylaw_latitude = $row["bylaw_latitude"];
			$the_bylaw_longtitude = $row["bylaw_longtitude"];
			$the_bylaw_location_x = $row["bylaw_location_x"];
			$the_bylaw_location_y = $row["bylaw_location_y"];
			//insert data into table
			$insert_sql = "INSERT INTO bylaw_year (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, 
				bylaw_neighbourhood_id, complaint, initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y) 
				VALUES ( '$the_complaint_number', '$the_bylaw_year', '$the_month_number', '$the_month', '$the_report_period', '$the_bylaw_neighbourhood', 
					'$the_bylaw_neighbourhood_id', '$the_complaint', '$the_initiated_by', '$the_bylaw_status', '$the_bylaw_count', 
					'$the_bylaw_latitude', '$the_bylaw_longtitude', '$the_bylaw_location_x', '$the_bylaw_location_y')";
			if (mysqli_query($conn, $insert_sql)) {
				// keep for debugging
		    	//echo "New record created successfully";
		    	//echo "\n";
			} else {
				// keep for debugging
		    	echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}
		}
	}
}


//empty the checked_311_result
$delete_sql = "DELETE FROM checked_bylaw_result";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED checked_311_result";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
//put everything from current table to result table
$copy_sql = "INSERT INTO checked_bylaw_result SELECT * FROM " . $table_array[0] . ";";
if (mysqli_query($conn, $copy_sql)) {
	// keep for debugging
	//echo "The record copyed successfully";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $copy_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
// for each table that storing selection result
for($i = 1; $i < sizeof($table_array); $i++){
	//check if there is any data in the table
	$check_sql = "SELECT COUNT(*) FROM " . $table_array[$i] .";";
	$check_result = $conn->query($check_sql);//get returned result
	$the_count = $check_result->fetch_assoc();
	if ($the_count['COUNT(*)'] > 0) {//the table is not empty, can join
		//check if there is any intersection between these two tables
		//if there is no intersection, just skip this table and check next
		$join_count_sql = "SELECT COUNT(*) FROM checked_bylaw_result INNER JOIN " . $table_array[$i] . " ON checked_bylaw_result.complaint_number = " . $table_array[$i] .".complaint_number";
		$join_count_result = $conn->query($join_count_sql);//get returned result
		$join_count = $join_count_result->fetch_assoc();
		if ($join_count['COUNT(*)'] > 0) {

			$join_sql = "SELECT * FROM checked_bylaw_result INNER JOIN " . $table_array[$i] . " ON checked_bylaw_result.complaint_number = " . $table_array[$i] .".complaint_number";
			$join_result = $conn->query($join_sql);//get returned result
			//empty the checked_bylaw_result
			$delete_sql = "DELETE FROM checked_bylaw_result";
			if (mysqli_query($conn, $delete_sql)) {
				// keep for debugging
		    	//echo "DELETED checked_bylaw_result";
		    	//echo "\n";
			} else {
				// keep for debugging
		    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}

			while($row = $join_result->fetch_assoc()) {//if not reach the end
		
				if($row["bylaw_year"] != null){

					$the_complaint_number = $row["complaint_number"];
					$the_bylaw_year = $row["bylaw_year"];
					$the_month_number = $row["month_number"];
					$the_month = $row["month"];
					$the_report_period = $row["report_period"];
					$the_bylaw_neighbourhood = $row["bylaw_neighbourhood"];
					$the_bylaw_neighbourhood_id = $row["bylaw_neighbourhood_id"];
					$the_complaint = $row["complaint"];
					$the_initiated_by = $row["initiated_by"];
					$the_bylaw_status = $row["bylaw_status"];
					$the_bylaw_count = $row["bylaw_count"];
					$the_bylaw_latitude = $row["bylaw_latitude"];
					$the_bylaw_longtitude = $row["bylaw_longtitude"];
					$the_bylaw_location_x = $row["bylaw_location_x"];
					$the_bylaw_location_y = $row["bylaw_location_y"];
					// insert the instersected data into result table
					$insert_sql = "INSERT INTO checked_bylaw_result (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, 
						bylaw_neighbourhood_id, complaint, initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y) 
						VALUES ( '$the_complaint_number', '$the_bylaw_year', '$the_month_number', '$the_month', '$the_report_period', '$the_bylaw_neighbourhood', 
							'$the_bylaw_neighbourhood_id', '$the_complaint', '$the_initiated_by', '$the_bylaw_status', '$the_bylaw_count', 
							'$the_bylaw_latitude', '$the_bylaw_longtitude', '$the_bylaw_location_x', '$the_bylaw_location_y')";
					if (mysqli_query($conn, $insert_sql)) {
						// keep for debugging
				    	//echo "New record created successfully";
				    	//echo "\n";
					} else {
						// keep for debugging
				    	echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
				    	echo "\n";
					}
				}
			}
		}
	}
}
//close connection to database
$conn->close();
?>