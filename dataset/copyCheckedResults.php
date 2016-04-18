<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On the Map page, this script is executed after the user has submitted their filtered options. It copies the     //
// "checked_311_result" and the "checked_bylaw_result" tables to the "submitted_checked_311" and                   //
// "submitted_checked_bylaw".                                                                                      //
// The "checked_311_result" and the "checked_bylaw_result" tables are the results from the user's filter selection //
// and the "submitted_checked_311" and "submitted_checked_bylaw" tables are used to display the information on the //
// map and to display the table on the page.                                                                       //
//                                                                                                                 //
// Note: All these tables mentioned are stored on the server's database.                                           //
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


// Before copying drop "submitted_checked_311 and "submitted_checked_bylaw" tables if they exist
$drop311 = $conn->query('DELETE FROM submitted_checked_311');
$dropBylaw = $conn->query('DELETE FROM submitted_checked_bylaw');
if ($drop311) {
    
    echo "submitted 311 table deleted";
}

if ($dropBylaw) {
    
    echo "submitted byLaw table deleted";
}


// Copy the checked tables to the subbitted tables 
$copyTable311 = $conn->query('INSERT INTO submitted_checked_311 SELECT * FROM checked_311_result');
$copyTableBylaw = $conn->query('INSERT INTO submitted_checked_bylaw SELECT * FROM checked_bylaw_result');
if ($copyTable311) {
    
    echo "copy 311 results success";
}

if ($copyTableBylaw) {
    
    echo "copy Bylaw results success";
}

// Close the connection to the server's database. 
$conn->close();

?>