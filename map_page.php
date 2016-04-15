
<?php session_start(); 
	//include_once './dataset/read_data.php';
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
	
	$sql = "DELETE FROM submitted_checked_311 ;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
		  
	$sql = "DELETE FROM submitted_checked_bylaw;";
          if (mysqli_query($conn, $sql)) {
         //   echo "New record created successfully";
          //  echo "\n";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>311 Web Explore</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css" media="all">
	</head>
	<body background="./img/edmonton.jpg">
		<div class = "transparency_filter"></div>
		<div id = "header">
			<a href="http://www.edmonton.ca/"><img src="./img/logo.png"></a>
		</div>
		<div class='nav'>
			<ul>
				<li><a href='main.php'>HOME</a></li>
				<li><a href='details.php'>RESULTS</a></li>
				<li><a href='knn.php'>ALGORITHM</a></li>
				<li class='active'><a href='map_page.php'>MAP</a></li>
				<li><a href='charts/chart_page.php'>CHARTS</a></li>
			</ul>
		</div>

		<div class = "wrap">
			<!-- <div id = "menu">
				<h1>This is the section for possible menu</h1>
			</div> -->
			<div id = "map"></div>
			<div id = "checklist">
				<div id = "checklist_title">
					<button type = "button" class id = "button">
						<img  id = "max" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
					</button>
					<!--<div id = "min_max">-</div>-->
				</div>
				<div id = "checklist_content">

					<!-- <form>
						<input type="checkbox" onchange="check_all(this)" name = "selection" value="all">Select all<br>
					</form> -->
					<button id='clear_button' style = 'width:100%' type="button" >Clear Selection</button>
					<button id='submit_button' style = 'width:100%' type="submit" onclick="reload_page()">Submit Selection</button>
					<?php
					//echo "something before if";
					
					$sql = "SELECT DISTINCT service_category FROM 311_Explorer
					WHERE service_category = '1' OR service_category = '2';";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f1_button'>
							<img  id = 'max_f1' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Service Category
						</div>
						<div id = 'service_category'>
						<form class = 'checklist_form' action='' method='post'>";

						// onchange='check_subs(this)'

					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["service_category"] != null){
					    		//echo "i am here here";
					    		if($row["service_category"] == '1'){
					    			$the_row = 'Snow & Ice Maintenance';
					    			$the_category_num = '1';
					    		}
					    		else if($row["service_category"] == '2') {
					    			$the_row = 'Vandalism/Graffiti';
					    			$the_category_num = '2';
					    		}
					    		//$the_row = $row["service_category"];
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_service_category('<?php echo $the_category_num; ?>', this)" class = 'filter1' name='service_category' value= '<?php echo $the_category_num;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}
					

					//echo "something before if";
					$sql = "SELECT DISTINCT 311_ward FROM 311_Explorer ORDER BY 311_ward;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f2_button'>
							<img  id = 'max_f2' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>
						</button>
						Ward
						</div>
						<div id = 'ward'>
						<form class = 'checklist_form' action='' method=''> \n";
					    // output data of each row			    
					    while(($row = $result->fetch_assoc())) {
					    	if($row["311_ward"] != null){
					    		$the_row = $row["311_ward"];
					    		//$the_row = str_replace(' ', '', $row["ward"]);//remove the space in string
					    	//	echo "<input type='checkbox' class = 'filter2' name='ward' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{\
					    		?>
					    	<input type="checkbox" onchange = "store_ward('<?php echo $the_row; ?>', this)" class = 'filter2' name = 'ward' value = '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    	
					    }
					    echo "</form>\n";
					    echo "</div>\n";
					} else {
					    //echo "0 results";
					}
					//echo "something before if";
					$sql = "SELECT DISTINCT 311_neighbourhood FROM 311_explorer ORDER BY 311_neighbourhood;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "<div class = 'checklist_subtitle'>

						<button type = 'button' class id = 'f3_button'>
							<img  id = 'max_f3' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>
						</button>
						Neighbourhood
						</div>
						<div id = 'neighbourhood'>
						<form class = 'checklist_form' action='' method='post'>";
					    // output data of each row
					    
					    while($row = $result->fetch_assoc()) {
					    	if($row["311_neighbourhood"] != null){
					    		$the_row = $row["311_neighbourhood"];
					    	//	echo "<input type='checkbox' class = 'filter3' name='neighbourhood' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    		<input type='checkbox' onchange = "store_311_neighbourhood('<?php echo $the_row; ?>', this)" class = 'filter3' name='neighbourhood' value= '<?php echo $the_row;?>' ><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}
					    	
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    }
					    echo "</form>
					</div>\n";
					} else {
					    //echo "0 results";
					}

					$sql = "SELECT DISTINCT 311_request_status FROM 311_Explorer ORDER BY 311_request_status;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f4_button'>
							<img  id = 'max_f4' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Request Status
						</div>
						<div id = 'request_status'>
						<form class = 'checklist_form' action='' method='post'>";



					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["311_request_status"] != null){

					    		$the_row = $row["311_request_status"];
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_311_request_status('<?php echo $the_row; ?>', this)" class = 'filter4' name='311_request_status' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}

					$sql = "SELECT DISTINCT month FROM Bylaw ORDER BY month;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f5_button'>
							<img  id = 'max_f5' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Reported Month
						</div>
						<div id = 'month'>
						<form class = 'checklist_form' action='' method='post'>";



					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["month"] != null){

					    		$the_row = $row["month"];
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_month('<?php echo $the_row; ?>', this)" class = 'filter5' name='month' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}

					$sql = "SELECT DISTINCT bylaw_year FROM Bylaw ORDER BY bylaw_year;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f6_button'>
							<img  id = 'max_f6' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Reported Year
						</div>
						<div id = 'bylaw_year'>
						<form class = 'checklist_form' action='' method='post'>";



					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["bylaw_year"] != null){

					    		$the_row = $row["bylaw_year"];
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_bylaw_year('<?php echo $the_row; ?>', this)" class = 'filter6' name='bylaw_year' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}

					$sql = "SELECT DISTINCT complaint FROM Bylaw
					WHERE complaint = '1' OR complaint = '2';";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f7_button'>
							<img  id = 'max_f7' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Complaint Type
						</div>
						<div id = 'complaint'>
						<form class = 'checklist_form' action='' method='post'>";



					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["complaint"] != null){
					    		if($row["complaint"] == '1'){
					    			$the_row = 'Snow/Ice On Walk';
					    			$the_type_num = '1';
					    		}
					    		else if($row["complaint"] == '2') {
					    			$the_row = 'Graffiti and Nuisance Property';
					    			$the_type_num = '2';
					    		}
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_complaint('<?php echo $the_type_num; ?>', this)" class = 'filter7' name='complaint' value= '<?php echo $the_type_num;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}

					$sql = "SELECT DISTINCT bylaw_status FROM Bylaw ORDER BY bylaw_status;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f8_button'>
							<img  id = 'max_f8' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Complaint Status
						</div>
						<div id = 'bylaw_status'>
						<form class = 'checklist_form' action='' method='post'>";



					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["bylaw_status"] != null){

					    		$the_row = $row["bylaw_status"];
					    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
					    	//}
					    	//else{
					    		?>
					    	<input type='checkbox' onchange = "store_bylaw_status('<?php echo $the_row; ?>', this)" class = 'filter8' name='bylaw_status' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					        //echo "service_category: " . $row["service_category"] . "<br>";
					    	}
					    }
					    echo "</form>
					</div>";
					} else {
					    //echo "0 results";
					}



					?>

					

					<!-- <p>SQL result message:</p><br> -->
					<div id = "testing_div">
						
					</div>
					
				</div>
			</div>
			<div id = 'detail'></div>
			<div id = 'detail2'></div>
		</div><!--clossing tag for wrap-->
		<footer>
			<div class = "foot_wrap">
			<!-- <h1>This is the section for footer</h1> -->
				<div class = "quick_link">
					<ul>Quick links:
						<li><a href="https://data.edmonton.ca/Indicators/311-Explorer/ukww-xkmj#column-menu">311 Explorer</a></li>
						<li><a href="https://data.edmonton.ca/Community-Services/Bylaw-Infractions/xgwu-c37w#column-menu">Bylaw Infractions</a></li>
					</ul>
					<ul>
						<li><a href="https://data.edmonton.ca/Administrative/City-of-Edmonton-Ward-Boundaries/yhng-294h">Ward Boundaries</a></li>
						<li><a href="https://data.edmonton.ca/Administrative/City-of-Edmonton-Neighbourhood-Boundaries-Map-View/jfvj-x253">Neighbourhood Boundaries</a></li>
					</ul>
				</div>
				<p>Copyright: MM811-course project &copy; 2016 All rights Reseverd by Queenie Luc & Sweta Bedmutha & Ruyi Wang</p>
			</div>
		</footer>

	</body>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src = "./js/jquery-ui.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script language="JavaScript" type="text/javascript" src="js/min_max_checklist.js"></script>
	<!-- <script type="text/javascript" src="js/check_all.js"></script> -->
	<script type="text/javascript" src="js/filter_buttons.js"></script>
	<script type="text/javascript" src="js/renew_checklist.js"></script>
	<script type="text/javascript" src="js/loadMap.js"> </script>
	<script type="text/javascript" src="js/tableResults.js"></script>
	<script type="text/javascript" src="js/tableResultsBylaw.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>




<?php 
	$conn->close();
?>
</html>

