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


$table_array = Array("bylaw_status", "month", "bylaw_year", "complaint");
$delete_sql = "DELETE FROM temp_bylaw";
if (mysqli_query($conn, $delete_sql)) {
	echo "DELETED temp_bylaw";
	echo "\n";
} else {
	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}
$copy_sql = "INSERT INTO temp_bylaw SELECT * FROM Bylaw;";
if (mysqli_query($conn, $copy_sql)) {
	echo "The previous record copyed successfully";
	echo "\n";
} else {
	echo "Error: " . $copy_sql . "<br>" . mysqli_error($conn);
	echo "\n";
}

//echo "before get";
$bylaw_status = $_GET['bylaw_status'];
$checked = $_GET['checked'];
$bylaw_status = str_replace('%20', ' ', $bylaw_status);
//echo "in data.php";
//echo $ward;

if($checked == '1'){
	$data_sql = "SELECT * FROM Bylaw WHERE bylaw_status = '$bylaw_status'"; //select data that matches
	$data_result = $conn->query($data_sql);//get returned result

	if ($data_result->num_rows > 0) {
		//echo $data_result;
		while($row = $data_result->fetch_assoc()) {
			
			if($row["bylaw_status"] != null){

				//echo $row["311_ward"];
				//$the_value = $row["ward"];
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
				$insert_sql = "INSERT INTO bylaw_status (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, 
					bylaw_neighbourhood_id, complaint, initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y) 
					VALUES ( '$the_complaint_number', '$the_bylaw_year', '$the_month_number', '$the_month', '$the_report_period', '$the_bylaw_neighbourhood', 
						'$the_bylaw_neighbourhood_id', '$the_complaint', '$the_initiated_by', '$the_bylaw_status', '$the_bylaw_count', 
						'$the_bylaw_latitude', '$the_bylaw_longtitude', '$the_bylaw_location_x', '$the_bylaw_location_y')";
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
	$delete_sql = "DELETE FROM bylaw_status WHERE bylaw_status = '$bylaw_status'"; //select data that matches
	if (mysqli_query($conn, $delete_sql)) {
    	echo "The record deleted successfully";
    	echo "\n";
	} else {
    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
    	echo "\n";
	}

	$delete_sql = "DELETE FROM checked_bylaw_result WHERE bylaw_status = '$bylaw_status'"; //select data that matches
	if (mysqli_query($conn, $delete_sql)) {
    	echo "The record deleted successfully";
    	echo "\n";
	} else {
    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
    	echo "\n";
	}

}







//check and join



$check_previous_result = "SELECT COUNT(*) FROM checked_bylaw_result;";
$previous_result = $conn->query($check_previous_result);//get returned result
$previous_count = $previous_result->fetch_assoc();
echo $previous_count['COUNT(*)'];
echo $table_array[0];
if ($previous_count['COUNT(*)'] == 0) {
	if($checked == '1'){
		$copy_sql = "INSERT INTO checked_bylaw_result SELECT * FROM " . $table_array[0] . ";";
		if (mysqli_query($conn, $copy_sql)) {
			echo "The record copyed successfully";
			echo "\n";
		} else {
			echo "Error: " . $copy_sql . "<br>" . mysqli_error($conn);
			echo "\n";
		}
	}
	else{
		$copy_sql = "INSERT INTO checked_bylaw_result SELECT * FROM temp_bylaw;";
		if (mysqli_query($conn, $copy_sql)) {
			echo "The record copyed successfully";
			echo "\n";
		} else {
			echo "Error: " . $copy_sql . "<br>" . mysqli_error($conn);
			echo "\n";
		}
	}
}
else{
	if($checked == '1'){
		$join_count_sql = "SELECT COUNT(*) FROM checked_bylaw_result INNER JOIN " . $table_array[0] . " ON checked_bylaw_result.complaint_number = " . $table_array[0] .".complaint_number";
		$join_count_result = $conn->query($join_count_sql);//get returned result
		$join_count = $join_count_result->fetch_assoc();
		echo "before JOIN";
		echo $join_count['COUNT(*)'];
		if ($join_count['COUNT(*)'] > 0) {
			echo "in the JOIN";
			$join_sql = "SELECT * FROM checked_bylaw_result INNER JOIN " . $table_array[0] . " ON checked_bylaw_result.complaint_number = " . $table_array[0] .".complaint_number";
			$join_result = $conn->query($join_sql);//get returned result
			//empty the checked_bylaw_result
			$delete_sql = "DELETE FROM checked_bylaw_result";
			if (mysqli_query($conn, $delete_sql)) {
		    	echo "DELETED checked_bylaw_result";
		    	echo "\n";
			} else {
		    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}
			//echo $data_result;
			echo "is here before join";
			
			while($row = $join_result->fetch_assoc()) {

				// $the_array = Array();
				// while ($the_array = mysql_fetch_object($join_result)) {
				// 	if (sizeof($the_array) > 0) {
				// 	//echo $data_result;
				// 	//while($row = $_result->fetch_assoc()) {
		
				if($row["bylaw_status"] != null){

					//echo $row["311_ward"];
					//$the_value = $row["ward"];
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
					$insert_sql = "INSERT INTO checked_bylaw_result (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, 
						bylaw_neighbourhood_id, complaint, initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y) 
						VALUES ( '$the_complaint_number', '$the_bylaw_year', '$the_month_number', '$the_month', '$the_report_period', '$the_bylaw_neighbourhood', 
							'$the_bylaw_neighbourhood_id', '$the_complaint', '$the_initiated_by', '$the_bylaw_status', '$the_bylaw_count', 
							'$the_bylaw_latitude', '$the_bylaw_longtitude', '$the_bylaw_location_x', '$the_bylaw_location_y')";
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
		else{
			//empty the checked_bylaw_result
			$delete_sql = "DELETE FROM checked_bylaw_result";
			if (mysqli_query($conn, $delete_sql)) {
		    	echo "DELETED checked_bylaw_result";
		    	echo "\n";
			} else {
		    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}
		}
	}
}


for($i = 1; $i < sizeof($table_array); $i++){

	$check_sql = "SELECT COUNT(*) FROM " . $table_array[$i] .";";
	$check_result = $conn->query($check_sql);//get returned result
	$the_count = $check_result->fetch_assoc();
	echo $the_count['COUNT(*)'];
	if ($the_count['COUNT(*)'] > 0) {
		echo "NOT empty";
		echo $table_array[$i];
		$join_count_sql = "SELECT COUNT(*) FROM checked_bylaw_result INNER JOIN " . $table_array[$i] . " ON checked_bylaw_result.complaint_number = " . $table_array[$i] .".complaint_number";
		$join_count_result = $conn->query($join_count_sql);//get returned result
		$join_count = $join_count_result->fetch_assoc();
		echo "before JOIN";
		echo $join_count['COUNT(*)'];
		if ($join_count['COUNT(*)'] > 0) {
			echo "in the JOIN";
			$join_sql = "SELECT * FROM checked_bylaw_result INNER JOIN " . $table_array[$i] . " ON checked_bylaw_result.complaint_number = " . $table_array[$i] .".complaint_number";
			$join_result = $conn->query($join_sql);//get returned result
			//empty the checked_bylaw_result
			$delete_sql = "DELETE FROM checked_bylaw_result";
			if (mysqli_query($conn, $delete_sql)) {
		    	echo "DELETED checked_bylaw_result";
		    	echo "\n";
			} else {
		    	echo "Error: " . $delete_sql . "<br>" . mysqli_error($conn);
		    	echo "\n";
			}
			//echo $data_result;
			echo "is here before join";
			
			while($row = $join_result->fetch_assoc()) {

				// $the_array = Array();
				// while ($the_array = mysql_fetch_object($join_result)) {
				// 	if (sizeof($the_array) > 0) {
				// 	//echo $data_result;
				// 	//while($row = $_result->fetch_assoc()) {
		
				if($row["bylaw_status"] != null){

					//echo $row["311_ward"];
					//$the_value = $row["ward"];
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
					$insert_sql = "INSERT INTO checked_bylaw_result (complaint_number, bylaw_year, month_number, month, report_period, bylaw_neighbourhood, 
						bylaw_neighbourhood_id, complaint, initiated_by, bylaw_status, bylaw_count, bylaw_latitude, bylaw_longtitude, bylaw_location_x, bylaw_location_y) 
						VALUES ( '$the_complaint_number', '$the_bylaw_year', '$the_month_number', '$the_month', '$the_report_period', '$the_bylaw_neighbourhood', 
							'$the_bylaw_neighbourhood_id', '$the_complaint', '$the_initiated_by', '$the_bylaw_status', '$the_bylaw_count', 
							'$the_bylaw_latitude', '$the_bylaw_longtitude', '$the_bylaw_location_x', '$the_bylaw_location_y')";
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
}

?>