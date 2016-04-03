
<?php session_start(); 
	//include_once './dataset/read_data.php';
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
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>311 Web Explore</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css" media="all">


		<div id = "header">
			<h1>Maybe add a logo image here</h1>
		</div>
	</head>
	<body>
		<div id = "menu">
			<h1>This is the section for possible menu</h1>
		</div>
		<div id = "map"></div>
		<div id = "checklist">
			<div id = "checklist_title">
				<button type = "button" class id = "button">
					<img  id = "max" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
				</button>
				<!--<div id = "min_max">-</div>-->
			</div>
			<div id = "checklist_content">

				<form>
					<input type="checkbox" onchange="check_all(this)" name = "selection" value="all">Select all<br>
				</form>
				<?php
				//echo "something before if";
				$sql = "SELECT DISTINCT service_category FROM 311_explorer ORDER BY service_category;";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<div class = 'checklist_subtitle'>
					<button type = 'button' class id = 'f1_button'>
						<img  id = 'max_f1' style = 'width: 2em; height: 2em;'' src='./img/plus-78.png'>
					</button>
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter1' name='filter' value='service_category'>Service Category<br>
					</form>
					</div>
					<div id = 'service_category'>
					<form action='' method=''>";


				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    	if($row["service_category"] != null){
				    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
				    	//}
				    	//else{
				    	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". $row["service_category"] . ">" . $row["service_category"] . "<br>";
				        //echo "service_category: " . $row["service_category"] . "<br>";
				    	}
				    }
				    echo "</form>
				</div>";
				} else {
				    //echo "0 results";
				}

				?>
				<!--<div class = "checklist_subtitle">
					<button type = "button" class id = "f1_button">
						<img  id = "max_f1" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
					</button>
					<form>
						<input type="checkbox" onchange="check_subs(this)" class = "filter1" name="filter" value="service_category">Service Category<br>
					</form>
					<div id = "min_max">-</div>-->
				<!--</div>
				<div id = "service_category">
					<form action="" method="">
						<input type="checkbox" class = "filter1" name="service_category" value="dead_animal">Dead Animal Removal<br>
						<input type="checkbox" class = "filter1" name="service_category" value="drainage">Drainage Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="litter_waste">Litter & Waste<br>
						<input type="checkbox" class = "filter1" name="service_category" value="parks_sportsfield">Parks & Sportsfield Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="pest_management">Pest Management<br>
						<input type="checkbox" class = "filter1" name="service_category" value="pothole">Pothole<br>
						<input type="checkbox" class = "filter1" name="service_category" value="road_sidewalk">Road/Sidewalk Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="snow_ice">Snow & Ice Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="structure">Structure Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="traffic_lights_signs">Traffic Lights & Signs<br>
						<input type="checkbox" class = "filter1" name="service_category" value="tree">Tree Maintenance<br>
						<input type="checkbox" class = "filter1" name="service_category" value="vandalism_graffiti">Vandalism/Graffiti<br>
					</form>
				</div>-->
				<?php
				//echo "something before if";
				$sql = "SELECT DISTINCT ward FROM 311_explorer ORDER BY ward;";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<div class = 'checklist_subtitle'>
					<button type = 'button' class id = 'f2_button'>
						<img  id = 'max_f2' style = 'width: 2em; height: 2em;'' src='./img/plus-78.png'>
					</button>
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter2' name='filter' value='ward'>Ward<br>
					</form>
					</div>
					<div id = 'ward'>
					<form action='' method=''>";


				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    	if($row["ward"] != null){
				    	//	echo "<input type='checkbox' class = 'filter2' name='ward' value=". null . ">" . "N/A" . "<br>";
				    	//}
				    	//else{
				    	echo "<input type='checkbox' class = 'filter2' name='ward' value=". $row["ward"] . ">" . $row["ward"] . "<br>";
				        //echo "service_category: " . $row["service_category"] . "<br>";
				    	}
				    }
				    echo "</form>
				</div>";
				} else {
				    //echo "0 results";
				}

				?>

				<!--<div class = "checklist_subtitle">
					<button type = "button" class id = "f2_button">
						<img  id = "max_f2" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
					</button>
					<form>
						<input type="checkbox" onchange="check_subs(this)" class = "filter2" name="filter" value="ward">Ward<br>
					</form>
					<div id = "min_max">-</div>-->
				<!--</div>
				<div id = "ward">
					<form action="" method="">
						<input type="checkbox" class = "filter2" name="ward" value="ward01">WARD 01<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward02">WARD 02<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward03">WARD 03<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward04">WARD 04<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward05">WARD 05<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward06">WARD 06<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward07">WARD 07<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward08">WARD 08<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward09">WARD 09<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward10">WARD 10<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward11">WARD 11<br>
						<input type="checkbox" class = "filter2" name="ward" value="ward12">WARD 12<br>
					</form>
				</div>-->
				<?php
				//echo "something before if";
				$sql = "SELECT DISTINCT neighbourhood FROM 311_explorer ORDER BY neighbourhood;";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "<div class = 'checklist_subtitle'>
					<button type = 'button' class id = 'f3_button'>
						<img  id = 'max_f3' style = 'width: 2em; height: 2em;'' src='./img/plus-78.png'>
					</button>
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter3' name='filter' value='neighbourhood'>Neighbourhood<br>
					</form>
					</div>
					<div id = 'neighbourhood'>
					<form action='' method=''>";


				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    	if($row["neighbourhood"] != null){
				    	//	echo "<input type='checkbox' class = 'filter3' name='neighbourhood' value=". null . ">" . "N/A" . "<br>";
				    	//}
				    	//else{
				    		echo "<input type='checkbox' class = 'filter3' name='neighbourhood' value=". $row["neighbourhood"] . ">" . $row["neighbourhood"] . "<br>";
				    	}
				        //echo "service_category: " . $row["service_category"] . "<br>";
				    }
				    echo "</form>
				</div>";
				} else {
				    //echo "0 results";
				}

				?>

				<!--<div class = "checklist_subtitle">
					<button type = "button" class id = "f3_button">
						<img  id = "max_f3" style = "width: 2em; height: 2em;" src="./img/plus-78.png">
					</button>
					<form>
						<input type="checkbox" onchange="check_subs(this)" class = "filter3" name="filter" value="neighbourhood">Neighbourhood<br>
					</form>
					<div id = "min_max">-</div>-->
				<!--
				</div>
				<div id = "neighbourhood">
					<form action="" method="">
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Alberta_Avenue">Alberta Avenue<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Aldergrove">Aldergrove<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Allendale">Allendale<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Balwin">Balwin<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Baturyn">Baturyn<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Beacon_Heights">Beacon Heights<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Beaumaris">Beaumaris<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Bellevue">Bellevue<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Belmead">Belmead<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Belmont">Belmont<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Belvedere">Belvedere<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Beverly_Heights">Beverly Heights<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Bonnie_Doon">Bonnie Doon<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Boyle_Street">Boyle Street<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Britannia_Yongstown">Britannia Yongstown<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Caernarvon">Caernarvon<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Calder">Calder<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Callingwood_North">Callingwood North<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Capilano">Capilano<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Central_Mcdougall">Central Mcdougall<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Crestwood">Crestwood<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Cumberland">Cumberland<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Delton">Delton<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Delwood">Delwood<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Downtown">Downtown<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Duggan">Duggan<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Dunluce">Dunluce<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Eastwood">Eastwood<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Elmwood">Elmwood<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Evansdale">Evansdale<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Forest_Heights">Forest Heights<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Garneau">Garneau<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Glastonbury">Glastonbury<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Glengarry">Glengarry<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Glenora">Glenora<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Glenwood">Glenwood<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Greenfield">Greenfield<br>
						<input type="checkbox" class = "filter3" name="neighbourhood" value="Grovenor">Grovenor<br>
					</form>
				</div>
				-->
				<p>here is something inside the check list box</p>
			</div>
		</div>
		<div id = "detail">
			<h1>This is the section for selection display</h1>
		</div>
		<footer>
			<h1>This is the section for footer</h1>
			<div id = "quick_link">
				<h1>Quick link goes here</h1>
				<a href="https://data.edmonton.ca/Indicators/311-Explorer/ukww-xkmj#column-menu">311 dataset</a>
			</div>
			<p>copyright goes here</p>
		</footer>

	</body>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script language="JavaScript" type="text/javascript" src="js/min_max_checklist.js"></script>
	<script type="text/javascript" src="js/check_all.js"></script>
	<script type="text/javascript" src="js/get_check_result.js"></script>
	<script type="text/javascript" src="js/loadMap.js"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>

</html>
