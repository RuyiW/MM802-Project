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
 // $link_address = 'dataset/exportTable.php';
//echo "<a href='dataset/exportTable.php' download></a>";
//echo "<a href= $link_address >Link</a>";
?>

<?php
// $con = mysql_connect("localhost","root","");

// if (!$con) {
//   die('Could not connect: ' . mysql_error());
// }

//mysql_select_db("highcharts", $conn);

// $get_data_sql = "SELECT bylaw_status,complaint FROM Bylaw";
// $result = $conn->query($get_data_sql);
// $rows = array();
// $rows['name'] = 'Bylaw Status';

// // while($r = mysql_fetch_array($get_data_sql)) {
// //     $rows['data'][] = ($r['bylaw_status']);
// // }
// if ($result->num_rows > 0) {
//   $index = 1;
//   while($r = $result->fetch_assoc()) {
//       if(($r["complaint"] != null) && ($r["bylaw_status"] == 'Under Investigation')){
//         $rows['data'][] = ($r["bylaw_status"]);
//       }
//     }
// }

$get_data_sql1 = "SELECT bylaw_neighbourhood,complaint,bylaw_status FROM Bylaw";
$result1 = $conn->query($get_data_sql1);
$rows1 = array();
$rows1['name'] = 'Bylaw Neighbourhood';

// while($r = mysql_fetch_array($get_data_sql)) {
//     $rows['data'][] = ($r['bylaw_status']);
// }
if ($result1->num_rows > 0) {
  $index = 1;
  while($rr = $result1->fetch_assoc()) {
      if(($rr["complaint"] != null) && ($rr["bylaw_status"] == 'Under Investigation')){
        $rows1['data'][] = $rr["bylaw_neighbourhood"];
      }
    }
}

$get_data_sql = "SELECT bylaw_status,complaint,bylaw_count FROM Bylaw";
$result = $conn->query($get_data_sql);
$rows = array();
$rows['name'] = 'Complaint Count';

// while($r = mysql_fetch_array($get_data_sql)) {
//     $rows['data'][] = ($r['bylaw_status']);
// }
if ($result->num_rows > 0) {
  $index = 1;
  while($r = $result->fetch_assoc()) {
      if(($r["complaint"] != null) && ($r["bylaw_status"] == 'Under Investigation')){
        $rows['data'][] = (int)($r["bylaw_count"]);
      }
    }
}
// $sth = mysql_query("SELECT bylaw_neighbourhood FROM Bylaw");
// $rows1 = array();
// $rows1['name'] = 'bylaw_neighbourhood';
// while($rr = mysql_fetch_assoc($sth)) {
//     $rows1['data'][] = ($rr['bylaw_neighbourhood']);
// }

$result2 = array();
array_push($result2,$rows1);
array_push($result2,$rows);

print json_encode($result2);

//mysql_close($conn);
?>