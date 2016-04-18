<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Export the 311_explorer table from the server's database to a CSV file.                                         //
// "algorithm_loadmap.js" calls this script                                                                        //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Parameters used to connect to the server's database
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
// mysql_query("set names utf8;");

// Open php stream to output to CSV file
$fp = fopen('php://output', 'w');

// Get the names of the attributes/columns to insert into the first row of the CSV file
$sql = "SHOW COLUMNS FROM 311_explorer";
$columns = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($columns)){
    echo $row['Field'].",";
}
echo "\n";


// Get the data from the table and insert into the CSV file
$result = $conn->query('SELECT * FROM 311_explorer');

if ($fp && $result) {

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exportTest.csv"');

    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

// Close the php stream and the connection to the server's database. 
fclose($fp);
$conn->close();

?>