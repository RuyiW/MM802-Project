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




//echo "before get";
$neighbourhood = $_GET['neighbourhood'];
$checked = $_GET['checked'];
//echo $neighbourhood;
$neighbourhood = str_replace('%20', ' ', $neighbourhood);
//echo "in data.php";
//echo $neighbourhood;

if($checked == '1'){
	$data_sql = "SELECT * FROM 311_Explorer WHERE 311_neighbourhood = '$neighbourhood'"; //select data that matches
	$data_result = $conn->query($data_sql);//get returned result

	if ($data_result->num_rows > 0) {
		//echo $data_result;
		while($row = $data_result->fetch_assoc()) {
			
			if($row["311_neighbourhood"] != null){

				//echo $row["311_neighbourhood"];
				//$the_value = $row["ward"];
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
				$insert_sql = "INSERT INTO 311_neighbourhood (ticket_number, date_created, date_closed, 311_request_status, 311_status_detail, service_category, business_unit, 311_neighbourhood,	community_league, 
					311_ward, address, 311_latitude, 311_longtitude, 311_location_x, 311_location_y, ticket_source, calendar_year, 311_count, posse_number, transit_ref_number) 
					VALUES ( '$the_ticket_number', '$the_date_created', '$the_date_closed', '$the_311_request_status', '$the_311_status_detail', '$the_service_category', '$the_business_unit',
						'$the_311_neighbourhood', '$the_community_league', '$the_311_ward', '$the_address', '$the_311_latitude', '$the_311_longtitude', '$the_311_location_x', '$the_311_location_y',
						'$the_ticket_source', '$the_calendar_year', '$the_311_count', '$the_posse_number', '$the_transit_ref_number')";
				if (mysqli_query($conn, $insert_sql)) {
			    	echo "New record created successfully";
			    	echo "\n";
				} else {
			    	echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
			    	echo "\n";
				}
			}
		}
	}
}
else{
	$delete_sql = "DELETE FROM 311_neighbourhood WHERE 311_neighbourhood = '$neighbourhood'"; //select data that matches
	if (mysqli_query($conn, $delete_sql)) {
    	echo "The record deleted successfully";
    	echo "\n";
	} else {
    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
    	echo "\n";
	}
}

$join_sql = "SELECT * FROM service_category INNER JOIN 311_ward, 311_neighbourhood, 311_request_status 
ON 'service_category.ticket_number = 311_ward.ticket_number' AND '311_ward.ticket_number = 311_neighbourhood.ticket_number' 
AND '311_neighbourhood.ticket_number = 311_request_status.ticket_number'";
$join_result = $conn->query($join_sql);//get returned result

if ($join_result['num_rows'] > 0) {
	//echo $data_result;
	while($row = $join_result->fetch_assoc()) {
		
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
			$insert_sql = "INSERT INTO checked_311_result (ticket_number, date_created, date_closed, 311_request_status, 311_status_detail, service_category, business_unit, 311_neighbourhood,	community_league, 
				311_ward, address, 311_latitude, 311_longtitude, 311_location_x, 311_location_y, ticket_source, calendar_year, 311_count, posse_number, transit_ref_number) 
				VALUES ( '$the_ticket_number', '$the_date_created', '$the_date_closed', '$the_311_request_status', '$the_311_status_detail', '$the_service_category', '$the_business_unit',
					'$the_311_neighbourhood', '$the_community_league', '$the_311_ward', '$the_address', '$the_311_latitude', '$the_311_longtitude', '$the_311_location_x', '$the_311_location_y',
					'$the_ticket_source', '$the_calendar_year', '$the_311_count', '$the_posse_number', '$the_transit_ref_number')";
			if (mysqli_query($conn, $insert_sql)) {
		    	echo "New record created successfully";
		    	echo "\n";
			} else {
		    	echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}
		}
	}
}


?>