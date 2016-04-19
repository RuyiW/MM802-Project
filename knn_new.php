<!-- 
	===========================================================
	This page is the algorithm page that taks user input value
	to calculate k nearest neighbour.
	The results is shown on map and in table.
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
	// clear the match result table that map gets data from
	// to make sure it is ready for the next result 
	$sql = "DELETE FROM match_resultNeighbourhood ;";
          if (mysqli_query($conn, $sql)) {
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }

	$sql = "DELETE FROM match_resultdays ;";
          if (mysqli_query($conn, $sql)) {
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
		  
	$sql = "DELETE FROM match_resultdistance ;";
          if (mysqli_query($conn, $sql)) {
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "\n";
          }
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>K Nearest Neighbour</title>
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
			<!-- section of getting input for k value -->
			<div id = 'algorithm_button'>
				<ul>
					<li><a href="ProjNNneighbour.php?k_value=1">By Neighbourhood</a>
						<!-- taking slide bar input and pass to calculation file -->
						<form oninput="current_neighbour_value.value=parseInt(value_for_neighbour.value)" method = "post">
							<p>Please specify the number of neighbours: (1-7)</p>
							<input id = "value_for_neighbour" type="range" name="points" min="1" max="7" value="1" onchange = "callProcedure(this)">
							<output id = "neighbour_output" name = "current_neighbour_value" for="value_for_neighbour" style="color:white"></output>
						</form>
					</li>
					<li><a href="ProjNNdays.php?day_value=1&k_value=1">By Days</a>
						<!-- taking slide bar input and pass to calculation file -->
						<form oninput="current_day_value.value=parseInt(value_for_days.value)" method = "post">
							<p>Please specify the range of days: (1-7)</p>
							<input id = "value_for_days" type="range" name="points" min="1" max="7" value="1" onchange = "callProcedure(this)">
							<output id = "days_output" name = "current_day_value" for="value_for_days" style="color:white"></output>
						</form>
						<!-- taking slide bar input and pass to calculation file -->
						<form oninput="current_day_neighbour_value.value=parseInt(value_for_day_neighbour.value)" method = "post">
							<p>Please specify the number of neighbours: (1-7)</p>
							<input id = "value_for_day_neighbour" type="range" name="points" min="1" max="7" value="1" onchange = "callProcedure(this)">
							<output id = "day_neighbour_output" name = "current_day_neighbour_value" for="value_for_day_neighbour" style="color:white"></output>
						</form>
					</li>
					<li>
						<a href="ProjNNdistance.php?distance_value=1">By Distance</a>
						<!-- taking slide bar input and pass to calculation file -->
						<form oninput="current_distance_value.value=parseInt(value_for_distance.value)" method = "post">
							<p>Please specify the range of distance: (1-7)</p>
							<input id = "value_for_distance" type="range" name="points" min="1" max="7" value = "1" onchange = "callProcedure(this)">
							<output id = "distance_output" name = "current_distance_value" for="value_for_distance" style="color:white"></output>
						</form>
					</li>
				</ul>
			</div>
			<!-- section of displaying results -->
			<div class="tabs">
				<ul id = "nav_tab0">
					<li id = "nav_tab_li0" class="active" onclick="reload()">
						<a>MAP</a>
					</li>
					<li id = "nav_tab_li1" class="" onclick="setTab(0,1)">
						<a>TABLE</a>
					</li>
				</ul>
			</div>
			<section id="result_showing0" class="result_box">
				<ul id  = "result_showing_ul0" class="block" style="display:block">
					<h1>Showing result on map</h1><br>
					<!-- map goes here -->
					<div id = "algorithm_map" style = "width:100%"></div>
				</ul>
				<ul id = "result_showing_ul1" class="block" style="display:none">
					<h1>Showing result in table</h1><br>
					<!-- table goes here -->
					<div id = "empty_div"></div>
				</ul>
			</section>
			
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
	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script type="text/javascript" src="js/algorithm_loadMap.js"> </script>

	<!-- scripts for jquery -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src = "./js/jquery-ui.js"></script>
	
	<!-- script for hadling k values -->
	<script type="text/javascript" src="js/k_value.js"></script>

	<!-- others (might not used in this page but in other page. keep them in case) -->
	<script language="JavaScript" type="text/javascript" src="js/min_max_checklist.js"></script>
	<script type="text/javascript" src="js/filter_buttons.js"></script>
	<script type="text/javascript" src="js/renew_checklist.js"></script>
		

	<!--For loading the Map tab-->
	<script>
	    function callProcedure(k_value) {
		pass_k_value(k_value);
		    setTimeout(function() {
			initMap();
		    }, 1500);
										
	    };
	</script>
	
	<script>
	    function reload() {
	        setTab(0,0);
    		setTimeout(function() {
			initMap();
    		}, 500);
										
	    };
	</script>



<?php 
	//close connection to database
	$conn->close();
?>
</html>