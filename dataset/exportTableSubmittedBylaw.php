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
$fp = fopen('php://output', 'w');
//$columns = $conn->query('SHOW COLUMNS FROM 311_explorer');
$sql = "SHOW COLUMNS FROM bylaw";
$columns = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($columns)){
    echo $row['Field'].",";
    //fputcsv($fp, $row['Field']);
}
echo "\n";


//console.log($columns);
//if ($fp && $columns) {
//    header('Content-Type: text/csv');
//    header('Content-Disposition: attachment; filename="exportTest.csv"');
//        //fputcsv($fp, )
//    fputcsv($fp, array_values($columns));
//    die;
//    
//}

// get the names of the attributes to insert into the first row of the csv file
$result = $conn->query('SELECT * FROM submitted_checked_bylaw');

if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exportTest.csv"');
    //console.log($result);
        //fputcsv($fp, )
    //fputcsv($fp, $columns);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

fclose($fp);
$conn->close();

?>