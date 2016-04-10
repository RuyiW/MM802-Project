<?php
//// output headers so that the file is downloaded rather than displayed
//header('Content-Type: text/csv; charset=utf-8');
//header('Content-Disposition: attachment; filename=data.csv');
//
//// create a file pointer connected to the output stream
//$output = fopen('php://output', 'w');
//
//// output the column headings
//fputcsv($output, array('Column 1', 'Column 2', 'Column 3'));
//
//// fetch the data
//mysql_connect('localhost', 'username', 'password');
//mysql_select_db('database');
//$rows = mysql_query('SELECT field1,field2,field3 FROM table');
//
//// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

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
//mysql_query("set names utf8;");
//$fp = fopen('php://output', 'w');
//$columns = $conn->query('SHOW COLUMNS FROM 311_explorer');
//$sql = "SHOW COLUMNS FROM 311_explorer";
//$columns = mysqli_query($conn,$sql);
//while($row = mysqli_fetch_array($columns)){
//    echo $row['Field'].",";
//    //fputcsv($fp, $row['Field']);
//}
//echo "\n";


//console.log($columns);
//if ($fp && $columns) {
//    header('Content-Type: text/csv');
//    header('Content-Disposition: attachment; filename="exportTest.csv"');
//        //fputcsv($fp, )
//    fputcsv($fp, array_values($columns));
//    die;
//    
//}

// drop the submitted tables if they exist
$drop311 = $conn->query('DROP TABLE IF EXISTS submitted_checked_311');
$dropBylaw = $conn->query('DROP TABLE IF EXISTS submitted_checked_bylaw');
if ($drop311) {
    
    echo "submitted 311 table dropped";
}

if ($dropBylaw) {
    
    echo "submitted byLaw table dropped";
}


$copyTable311 = $conn->query('CREATE TABLE IF NOT EXISTS submitted_checked_311 SELECT * FROM checked_311_result');
$copyTableBylaw = $conn->query('CREATE TABLE IF NOT EXISTS submitted_checked_bylaw SELECT * FROM checked_bylaw_result');
if ($copyTable311) {
    
    echo "copy 311 results success";
}

if ($copyTableBylaw) {
    
    echo "copy Bylaw results success";
}

// get the names of the attributes to insert into the first row of the csv file
$result = $conn->query('SELECT * FROM checked_311_result');


//fclose($fp);
$conn->close();

?>