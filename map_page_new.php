<!-- 
	===========================================================
	This page is the map page that displaying data on the map. 
	It contains a filter that getting input form user.
	It can also shows the filtered results below the map.
	===========================================================
 -->
<?php session_start(); 
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
	
// for each time the page is reloaded,
// clear the table that map gets data from
// to make sure there is nothing displayed on the map 
// and ready for a new search 
// $sql = "DELETE FROM submitted_checked_311 ;";
 //          if (mysqli_query($conn, $sql)) {
 //         //   echo "New record created successfully";
 //          //  echo "\n";
 //          } else {
 //            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 //            echo "\n";
 //          }
		  
	// $sql = "DELETE FROM submitted_checked_bylaw;";
 //          if (mysqli_query($conn, $sql)) {
 //         //   echo "New record created successfully";
 //          //  echo "\n";
 //          } else {
 //            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 //            echo "\n";
 //          }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Map and Filter</title>
		<!-- page style -->
		<link rel="stylesheet" type="text/css" href="./css/style.css" media="all">
	</head>
	<body background="./img/edmonton.jpg">
		<div class = "transparency_filter"></div>
		<!-- nevigation section -->
		<div class = "menu">
			<ul>
				<li><a href='main_new.php'>HOME</a></li>
				<li><a href='knn_new.php'>ALGORITHM</a></li>
				<li><a href='map_page_new.php'>MAP</a></li>
				<li><a href='charts/chart_page_new.php'>CHARTS</a></li>
			</ul>
		</div>
		<div class = "right_content">
			<!-- map division -->
			<div id = "map" style = "width:100%"></div>
			<!-- filter division -->
			<div id = "checklist" style = "margin-left:62.5%">
				<div id = "checklist_title">
					<button type = "button" class id = "button">
						<img  id = "max" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
					</button>
				</div>
				<!-- division that can be minimized -->
				<div id = "checklist_content">
					<button id='clear_button' style = 'width:100%' type="button" >Clear Selection</button>
					<button id='submit_button' style = 'width:100%' type="submit" onclick="reload_page()">Submit Selection</button>
					<!-- service category section -->
					<?php
					//select service category data from database
					$sql = "SELECT DISTINCT service_category FROM 311_Explorer
					WHERE service_category = '1' OR service_category = '2';";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
						echo "
						<div class = 'checklist_subtitle'>
						<button type = 'button' class id = 'f1_button'>
							<img  id = 'max_f1' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

						</button>
						Service Category
						</div>
						<div id = 'service_category'>
						<form class = 'checklist_form' action='' method='post'>";

					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	if($row["service_category"] != null){
					    		//change the category name back
					    		if($row["service_category"] == '1'){
					    			$the_row = 'Snow & Ice Maintenance';
					    			$the_category_num = '1';
					    		}
					    		else if($row["service_category"] == '2') {
					    			$the_row = 'Vandalism/Graffiti';
					    			$the_category_num = '2';
					    		}
					    		?>
					    		<!-- create a checkbox -->
					    		<input type='checkbox' onchange = "store_service_category('<?php echo $the_category_num; ?>', this)" class = 'filter1' name='service_category' value= '<?php echo $the_category_num;?>'><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}
					    }
					    echo "</form>
						</div>";
					}
					
					//ward section
					//select ward data from database
					$sql = "SELECT DISTINCT 311_ward FROM 311_Explorer ORDER BY 311_ward;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    		<input type="checkbox" onchange = "store_ward('<?php echo $the_row; ?>', this)" class = 'filter2' name = 'ward' value = '<?php echo $the_row;?>'><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}
					    	
					    }
					    echo "</form>\n";
					    echo "</div>\n";
					}

					//311 neighbourhood section
					//select 311 neighbourhood data from database
					$sql = "SELECT DISTINCT 311_neighbourhood FROM 311_explorer ORDER BY 311_neighbourhood;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    		<input type='checkbox' onchange = "store_311_neighbourhood('<?php echo $the_row; ?>', this)" class = 'filter3' name='neighbourhood' value= '<?php echo $the_row;?>' ><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}					    	
					    }
					    echo "</form>
						</div>\n";
					}

					//request status section
					//select request status data from database
					$sql = "SELECT DISTINCT 311_request_status FROM 311_Explorer ORDER BY 311_request_status;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    		<input type='checkbox' onchange = "store_311_request_status('<?php echo $the_row; ?>', this)" class = 'filter4' name='311_request_status' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}
					    }
					    echo "</form>
					</div>";
					}

					//complaint month section
					//select complaint month data from database
					$sql = "SELECT DISTINCT month FROM Bylaw ORDER BY month;";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    	<input type='checkbox' onchange = "store_month('<?php echo $the_row; ?>', this)" class = 'filter5' name='month' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					    	}
					    }
					    echo "</form>
					</div>";
					}

					//complaint year section
					//select complaint year data from database
					$sql = "SELECT DISTINCT bylaw_year FROM Bylaw ORDER BY bylaw_year;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    		<input type='checkbox' onchange = "store_bylaw_year('<?php echo $the_row; ?>', this)" class = 'filter6' name='bylaw_year' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    		<br>
					    		<?php
					    	}
					    }
					    echo "</form>
					</div>";
					}

					//complaint type section
					//select complaint typw data from database
					$sql = "SELECT DISTINCT complaint FROM Bylaw
					WHERE complaint = '1' OR complaint = '2';";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		//change the complaint type back from number
					    		if($row["complaint"] == '1'){
					    			$the_row = 'Snow/Ice On Walk';
					    			$the_type_num = '1';
					    		}
					    		else if($row["complaint"] == '2') {
					    			$the_row = 'Graffiti and Nuisance Property';
					    			$the_type_num = '2';
					    		}
					    		?>
					    	<input type='checkbox' onchange = "store_complaint('<?php echo $the_type_num; ?>', this)" class = 'filter7' name='complaint' value= '<?php echo $the_type_num;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					    	}
					    }
					    echo "</form>
					</div>";
					}

					//complaint status section
					//select complaint status data from database
					$sql = "SELECT DISTINCT bylaw_status FROM Bylaw ORDER BY bylaw_status;";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {//if there is at least one row of data
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
					    		?>
					    	<input type='checkbox' onchange = "store_bylaw_status('<?php echo $the_row; ?>', this)" class = 'filter8' name='bylaw_status' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
					    	<br>
					    	<?php
					    	}
					    }
					    echo "</form>
					</div>";
					}
					?>
					<!-- for sql output message -->
					<div id = "testing_div"></div>
					
				</div><!-- end of filter content -->
			</div><!-- end of filter division -->
			<!-- filter result table for requests-->
			<div id = 'detail'></div>
			<!-- filter result table for complaints -->
			<div id = 'detail2'></div>
		</div>
		<!-- footer -->
		<div class = "bottom_bar">
			<a href="http://www.edmonton.ca/"><img src="./img/logo.png"></a>
			<p>Copyright: MM811-course project &copy; 2016 All rights Reseverd by Queenie Luc & Sweta Bedmutha & Ruyi Wang</p>
			<ul>Quick links:
				<li><a href="https://data.edmonton.ca/Indicators/311-Explorer/ukww-xkmj#column-menu">311 Explorer</a></li>
				||
				<li><a href="https://data.edmonton.ca/Community-Services/Bylaw-Infractions/xgwu-c37w#column-menu">Bylaw Infractions</a></li>
				||
				<li><a href="https://data.edmonton.ca/Administrative/City-of-Edmonton-Ward-Boundaries/yhng-294h">Ward Boundaries</a></li>
			</ul>
		</div>
	</body>

	<!-- scripts for map and table -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script type="text/javascript" src="js/loadMap.js"> </script>

	<!-- scripts for jquery -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src = "./js/jquery-ui.js"></script>
	
	<!-- scripts for filter -->
	<script language="JavaScript" type="text/javascript" src="js/min_max_checklist.js"></script>
	<script type="text/javascript" src="js/filter_buttons.js"></script>
	<script type="text/javascript" src="js/renew_checklist.js"></script>
	
	<!-- scripts for displaying results -->
	<script type="text/javascript" src="js/tableResults.js"></script>
	<script type="text/javascript" src="js/tableResultsBylaw.js"></script>
	




<?php 
	//close connection to database
	$conn->close();
?>
</html>