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
mysql_query("set names utf8;");

?>