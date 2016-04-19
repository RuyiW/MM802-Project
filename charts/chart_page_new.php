<!-- 
	===========================================================
	This page is for displaying highcharts for datasets 
	311 Explorer and Bylaw Infractions.
	The charts shows their relations and connections.
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
		<title>Charts of Relations</title>
		<!-- page styles -->
		<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>
	<body background="../img/edmonton.jpg">
		<div class = "transparency_filter"></div>
		<!-- nevigation section -->
		<div class = "menu">
			<ul>
				<li><a href='../main_new.php'>HOME</a></li>
				<li><a href='../knn_new.php'>ALGORITHM</a></li>
				<li><a href='../map_page_new.php'>MAP</a></li>
				<li><a href='chart_page_new.php'>CHARTS</a></li>
			</ul>
		</div>
		<div class = "right_content">
			<!-- displaying charts -->
			<h2>Highcharts</h2>
			<ul class="nav nav-tabs">
				<li class="active" id = "chart_1"><a data-toggle="tab" href="#chart1">Request count</a></li>
				<li id = "chart_2"><a data-toggle="tab" href="#chart2">Complaint count</a></li>
				<li id = "chart_3"><a data-toggle="tab" href="#chart3">Snow and Ice Sidewalk Maintenance</a></li>
				<li id = "chart_4"><a data-toggle="tab" href="#chart4">Graffiti and Vandalism Requests</a></li>
			</ul>
			

			<div class="tab-content">
				<!-- content in first tab -->
				<div id="chart1" class="tab-pane fade in active">
					<!-- sub tab -->
					<ul class="nav nav-tabs">
						<li id = "chart_1_bar" class="active"><a data-toggle="tab" href="#chart1_bar">Bar Chart</a></li>
						<li id = "chart_1_pie" ><a data-toggle="tab" href="#chart1_pie">Pie Chart</a></li>
				    </ul>
				    <!-- content in sub tab -->
					<div class="tab-content">
						<div id="chart1_bar" class="tab-pane fade in active">
							<h3>Bar chart for Neighbourhood vs Request count</h3>
							<div id="for_chart1"></div>
						</div>
						<div id="chart1_pie" class="tab-pane fade">
							<h3>Pie chart for Neighbourhood vs Request count</h3>
							<div id="for_chart2"></div>
						</div>
					</div>
				</div>
				<!-- content in second tab -->
				<div id="chart2" class="tab-pane fade">
					<!-- sub tab -->
					<ul class="nav nav-tabs">
						<li id = "chart_2_bar" class="active"><a data-toggle="tab" href="#chart2_bar">Bar Chart</a></li>
						<li id = "chart_2_pie" ><a data-toggle="tab" href="#chart2_pie">Pie Chart</a></li>
				    </ul>
				    <!-- content in sub tab -->
					<div class="tab-content">
						<div id="chart2_bar" class="tab-pane fade in active">
							<h3>Bar chart for Neighbourhood vs Complaint count</h3>
							<div id="for_chart3"></div>
						</div>
						<div id="chart2_pie" class="tab-pane fade">
							<h3>Pie chart for Neighbourhood vs Complaint count</h3>
							<div id="for_chart4"></div>
						</div>
					</div>
				</div>
				<!-- content in third tab -->
				<div id="chart3" class="tab-pane fade">
					<h3>Neighbourhood vs Snow and Ice Sidewalk Maintenance</h3>
					<div id="for_chart5"></div>
				</div>
				<!-- content in fourth tab -->
				<div id="chart4" class="tab-pane fade">
					<h3>Neighbourhood vs Graffiti and Vandalism Requests</h3>
					<div id="for_chart6"></div>
				</div>
				
			</div>	
		</div>
		<!-- footer -->
		<div class = "bottom_bar">
			<a href="http://www.edmonton.ca/"><img src="../img/logo.png"></a>
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
	
	<!-- scripts for table and map -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script> <!-- using d3 for filtering the dataset-->
	<script type="text/javascript" src="../js/loadMap.js"> </script>

	<!-- scripts for charts -->
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-3d.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript" src="../js/display_charts.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


	<!-- scripts of jquerys -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src = "../js/jquery-ui.js"></script>
	
	<!-- others (might not used in this page but in other page. keep them in case) -->
	<script language="JavaScript" type="text/javascript" src="../js/min_max_checklist.js"></script>
	<script type="text/javascript" src="../js/filter_buttons.js"></script>
	<script type="text/javascript" src="../js/renew_checklist.js"></script>
	<script type="text/javascript" src="../js/k_value.js"></script>

<?php 
	//close connection to database
	$conn->close();
?>
</html>