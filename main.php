
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

				$sql = "SELECT DISTINCT service_category FROM 311_Explorer ORDER BY service_category;";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					echo "
					<div class = 'checklist_subtitle'>
					<button type = 'button' class id = 'f1_button'>
						<img  id = 'max_f1' style = 'width: 2em; height: 2em;' src='./img/plus-78.png'>

					</button>
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter1' name='filter' value='service_category'>Service Category<br>
					</form>
					</div>
					<div id = 'service_category'>
					<form class = 'checklist_form' action='' method='post'>";



				    // output data of each row
				    while($row = $result->fetch_assoc()) {
				    	if($row["service_category"] != null){

				    		$the_row = $row["service_category"];
				    	//	echo "<input type='checkbox' class = 'filter1' name='service_category' value=". null . ">" . "N/A" . "<br>";
				    	//}
				    	//else{
				    		?>
				    	<input type='checkbox' onchange = "store_service_category('<?php echo $the_row; ?>', this)" class = 'filter1' name='service_category' value= '<?php echo $the_row;?>'><?php echo $the_row;?>
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
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter2' name='filter' value='ward'>Ward<br>
					</form>
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
					<form>
						<input type='checkbox' onchange='check_subs(this)' class = 'filter3' name='filter' value='neighbourhood'>Neighbourhood<br>
					</form>
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
				}?>

				

				<p>SQL result message:</p><br>
				<div id = "testing_div">
					
				</div>
				
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
	<script type="text/javascript" src="js/renew_checklist.js"></script>
	<script type="text/javascript" src="js/loadMap.js"> </script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>




<?php 
	$conn->close();
?>
</html>

