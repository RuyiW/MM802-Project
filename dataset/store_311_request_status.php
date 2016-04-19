<!-- 
	===========================================================
	This is the file used for store selected data into 
	311 request status table.
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
$table_array = Array("311_request_status", "service_category", "311_ward", "311_neighbourhood");
//clear temp table
$delete_sql = "DELETE FROM temp_311";
if (mysqli_query($conn, $delete_sql)) {
	// keep for debugging
	//echo "DELETED temp_311";
	//echo "\n";
} else {
	// keep for debugging
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}//copy data from checked result to temp table
$copy_sql = "INSERT INTO temp_311 SELECT * FROM checked_311_result;";
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
$request_status = $_GET['request_status'];
$request_status = str_replace('%20', ' ', $request_status);

$data_sql = "SELECT * FROM 311_Explorer WHERE 311_request_status = '$request_status'"; //select data that matches
$data_result = $conn->query($data_sql);//get returned result

if ($data_result->num_rows > 0) {
	while($row = $data_result->fetch_assoc()) {
		
		if($row["311_request_status"] != null){

			$the_ticket_number = $row["ticket_number"];
			$the_date_created = $row["date_created"];
			$the_date_closed = $row["date_closed"];
			$the_311_request_status = $row["311_request_status"];
			$the_311_status_detail = $row["311_status_detail"];
			$the_service_category = $row["service_category"];
			$the_business_unit = $row["business_unit"];
			$the_311_neighbourhood = $row["311_neighbourhood"];
			$the_community_league = $row["community_league"];
			$the_311_ward = $row["311_ward"];
			$the_address = $row["address"];
			$the_311_latitude = $row["311_latitude"];
			$the_311_longtitude = $row["311_longtitude"];
			$the_311_location_x = $row["311_location_x"];
			$the_311_location_y = $row["311_location_y"];
			$the_ticket_source = $row["ticket_source"];
			$the_calendar_year = $row["calendar_year"];
			$the_311_count = $row["311_count"];
			$the_posse_number = $row["posse_number"];
			$the_transit_ref_number = $row["transit_ref_number"];
			//insert data into table
			$insert_sql = "INSERT INTO 311_request_status (ticket_number, date_created, date_closed, 311_request_status, 311_status_detail, service_category, business_unit, 311_neighbourhood,	community_league, 
				311_ward, address, 311_latitude, 311_longtitude, 311_location_x, 311_location_y, ticket_source, calendar_year, 311_count, posse_number, transit_ref_number) 
				VALUES ( '$the_ticket_number', '$the_date_created', '$the_date_closed', '$the_311_request_status', '$the_311_status_detail', '$the_service_category', '$the_business_unit',
					'$the_311_neighbourhood', '$the_community_league', '$the_311_ward', '$the_address', '$the_311_latitude', '$the_311_longtitude', '$the_311_location_x', '$the_311_location_y',
					'$the_ticket_source', '$the_calendar_year', '$the_311_count', '$the_posse_number', '$the_transit_ref_number')";
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
$delete_sql = "DELETE FROM checked_311_result";
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
$copy_sql = "INSERT INTO checked_311_result SELECT * FROM " . $table_array[0] . ";";
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
		$join_count_sql = "SELECT COUNT(*) FROM checked_311_result INNER JOIN " . $table_array[$i] . " ON checked_311_result.ticket_number = " . $table_array[$i] .".ticket_number";
		$join_count_result = $conn->query($join_count_sql);//get returned result
		$join_count = $join_count_result->fetch_assoc();
		if ($join_count['COUNT(*)'] > 0) {
			$join_sql = "SELECT * FROM checked_311_result INNER JOIN " . $table_array[$i] . " ON checked_311_result.ticket_number = " . $table_array[$i] .".ticket_number";
			$join_result = $conn->query($join_sql);//get returned result
			//empty the checked_311_result
			$delete_sql = "DELETE FROM checked_311_result";
			if (mysqli_query($conn, $delete_sql)) {
				// keep for debugging
		    	//echo "DELETED checked_311_result";
		    	//echo "\n";
			} else {
				// keep for debugging
		    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}

			while($row = $join_result->fetch_assoc()) {//if not reach the end
		
				if($row["service_category"] != null){
					$the_ticket_number = $row["ticket_number"];
					$the_date_created = $row["date_created"];
					$the_date_closed = $row["date_closed"];
					$the_311_request_status = $row["311_request_status"];
					$the_311_status_detail = $row["311_status_detail"];
					$the_service_category = $row["service_category"];
					$the_business_unit = $row["business_unit"];
					$the_311_neighbourhood = $row["311_neighbourhood"];
					$the_community_league = $row["community_league"];
					$the_311_ward = $row["311_ward"];
					$the_address = $row["address"];
					$the_311_latitude = $row["311_latitude"];
					$the_311_longtitude = $row["311_longtitude"];
					$the_311_location_x = $row["311_location_x"];
					$the_311_location_y = $row["311_location_y"];
					$the_ticket_source = $row["ticket_source"];
					$the_calendar_year = $row["calendar_year"];
					$the_311_count = $row["311_count"];
					$the_posse_number = $row["posse_number"];
					$the_transit_ref_number = $row["transit_ref_number"];
					// insert the instersected data into result table
					$insert_sql = "INSERT INTO checked_311_result (ticket_number, date_created, date_closed, 311_request_status, 311_status_detail, service_category, business_unit, 311_neighbourhood,	community_league, 
						311_ward, address, 311_latitude, 311_longtitude, 311_location_x, 311_location_y, ticket_source, calendar_year, 311_count, posse_number, transit_ref_number) 
						VALUES ( '$the_ticket_number', '$the_date_created', '$the_date_closed', '$the_311_request_status', '$the_311_status_detail', '$the_service_category', '$the_business_unit',
							'$the_311_neighbourhood', '$the_community_league', '$the_311_ward', '$the_address', '$the_311_latitude', '$the_311_longtitude', '$the_311_location_x', '$the_311_location_y',
							'$the_ticket_source', '$the_calendar_year', '$the_311_count', '$the_posse_number', '$the_transit_ref_number')";
					if (mysqli_query($conn, $insert_sql)) {
						// keep for debugging
				    	//echo "New temp JOIN created successfully";
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