<!-- 
	===========================================================
	This is the connection file that creates connection with database. 
	It is not been called by any file. Just keep it in case.
	===========================================================
 -->
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

?>