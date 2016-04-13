
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
				<li class='active'><a href='main.php'>HOME</a></li>
				<li><a href='details.php'>RESULTS</a></li>
				<li><a href='knn.php'>ALGORITHM</a></li>
				<li><a href='map_page.php'>MAP</a></li>
				<li><a href='#'>CHARTS</a></li>
			</ul>
		</div>

		<div class = "wrap">
			<!-- <div id = "menu">
				<h1>This is the section for possible menu</h1>
			</div> -->
			<div id = 'introduction'>
				<h2>Overview of our project</h2>
				<p>
					In this project, we propose to create an application that can provide better visualization of the issues that occur in the city of Edmonton, 
					by using the data from the 311 explorer. We are only interested in the open requests as they have not been resolved. The requests can be categorized by Ward areas, 
					or neighbourhoods, which can be broken down to service categories for that selected area. These service categories are then assigned to respective Business Units. 
					We want to combine the 311 Explorer dataset with the Bylaw Infractions dataset, and try to find any connections between the reports from the 311 Explorer and 
					the complaints reported in the Bylaw Infractions. For example, if there was a graffiti complaint that was still under investigation, we want to find if the 
					reports of recent vandalism/graffiti might be linked to the complaint. Ideally, our application could help with the further investigations of unresolved complaints, 
					by providing possible connections to the causes of the complaints. As for finding the possible connections, we are still a little unsure. 
					</p><p>
					However we do have some ideas, 
					such as mapping from 311 Explorer dataset to the Bylaw Infractions dataset by the date, based on the service/complaint type. The dates from 311 Explorer starting from the same 
					month that the complaint was posted (from the Bylaw Infractions dataset) to present day dates, would be considered. The neighbourhood is considered first, 
					then we would consider nearby neighbours, checking if there has been an increase in the same requests. As of now, there are only these two data sets that seem to have possible connections. 
					We have yet to find other datasets that could possibly help find more of the connections related to the complaints, but we will further investigate as we continue on with this project. 

				</p>
			</div>
			
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
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>




<?php 
	$conn->close();
?>
</html>

