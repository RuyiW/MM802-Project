<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On the Algorithm page, this file is executed after the user inputs the desired K value in one of the 3 sections //
// (By Days, By Distance, or By Neigbourhood). It finds which table is not empty                                   //
// (3 tables in total in the server's database: "match_resultdays", "match_resultdistance", and                    //
// "match_resultNeighbourhood") and use it to export the table to a CSV file for the script "algorithm_loadMap.js" //
// to read and display the markers on the map.                                                                     //
//                                                                                                                 //
// Note: Before new results are generated for every input the user provides, the tables are first emptied.         //
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

// Names of tables to read and export to CSV file
// These tables are for the Algorithm page. After the user inputs a parameter,
// either from 3 different sections: By Days, By Distance or By Neighbourhood,
// which these 3 sections have the corresponding tables below.

$tables[0] = "match_resultdays";            // Result table for By Days
$tables[1] = "match_resultdistance";        // Result table for By Distance
$tables[2] = "match_resultNeighbourhood";   // Result table for By Neighbourhood

// By default read "match_resultdays"
$tableWanted = $tables[0];

// Find the table that is not empty
for ($i = 0; $i < 3; $i++) {
    
    $sqlgetTable = "SELECT COUNT(*) FROM " . $tables[$i];
    $rowNum = $conn->query($sqlgetTable);
    
    if ($rowNum) {
        while ($rows = $rowNum->fetch_array(MYSQLI_NUM)) {
            if($rows[0] > 0) {
                $tableWanted = $tables[$i];    
            }
        }
    }    
}

// mysql_query("set names utf8;");

// Once we find the table that is not empty, export it to CSV
// If all tables were empty "match_resultdays" would be exported to a CSV file by default

// Open php stream to output to CSV file
$fp = fopen('php://output', 'w');

// Get the names of the attributes/columns to insert into the first row of the CSV file
$sql = "SHOW COLUMNS FROM " . $tableWanted;
$columns = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($columns)){
    echo $row['Field'].",";
}
echo "\n";


// Get the data from the table and insert into the CSV file
$sqlQuery = "SELECT * FROM " . $tableWanted;
$result = $conn->query($sqlQuery);

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