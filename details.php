<!-- 
	===========================================================
	This page is the result page of displaying the filtered data. 
	It shows a table of result.
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
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Filter Result Details</title>
		<!-- page style -->
		<link rel="stylesheet" type="text/css" href="./css/style.css" media="all">
	</head>
	<body background="./img/edmonton.jpg">
		<div class = "transparency_filter"></div>
		<div id = "header">
			<a href="http://www.edmonton.ca/"><img src="./img/logo.png"></a>
		</div>
		<!-- nevigation section -->
		<div class='nav'>
			<ul>
				<li><a href='main.php'>HOME</a></li>
				<li class='active'><a href='details.php'>RESULTS</a></li>
				<li><a href='knn.php'>ALGORITHM</a></li>
				<li><a href='map_page.php'>MAP</a></li>
				<li><a href='charts/chart_page.php'>CHARTS</a></li>
			</ul>
		</div>

		<div class = "wrap">
			<!-- division of displaying result details -->
			<div id = 'detail'></div>
		</div><!--clossing tag for wrap-->
		<footer>
			<div class = "foot_wrap">
			<!-- <h1>This is the section for footer</h1> -->
				<div class = "quick_link">
					<ul>Quick links:
						<li><a href="https://data.edmonton.ca/Indicators/311-Explorer/ukww-xkmj#column-menu">311 Explorer</a></li>
						<li><a href="https://data.edmonton.ca/Community-Services/Bylaw-Infractions/xgwu-c37w#column-menu">Bylaw Infractions</a></li>
						<li><a href="https://data.edmonton.ca/Administrative/City-of-Edmonton-Ward-Boundaries/yhng-294h">Ward Boundaries</a></li>
					</ul>
				</div>
				<p>Copyright: MM811-course project &copy; 2016 All rights Reseverd by Queenie Luc & Sweta Bedmutha & Ruyi Wang</p>
			</div>
		</footer>

	</body>
	
	<!-- scripts for table and map -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script type="text/javascript" src="js/loadMap.js"> </script>

	<!-- scripts of jquerys -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src = "./js/jquery-ui.js"></script>
	
	<!-- scripts of showing results -->
	<script type="text/javascript" src="js/showing_result.js"></script>
	<script type="text/javascript" src="js/tableResults.js"></script>

	<!-- others (might not used in this page but in other page. keep them in case) -->
	<script language="JavaScript" type="text/javascript" src="js/min_max_checklist.js"></script>
	<script type="text/javascript" src="js/filter_buttons.js"></script>
	<script type="text/javascript" src="js/renew_checklist.js"></script>

<?php 
	//close connection to database
	$conn->close();
?>
</html>

