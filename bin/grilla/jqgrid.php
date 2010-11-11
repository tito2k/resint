<?php

// include("dbconfig.php");

	$fileContainer = "resource.txt";
	$filePointer = fopen($fileContainer, "a+");
   $logMsg = print_r($_REQUEST, true) . "\n";
   fputs($filePointer, $logMsg);
   fclose($filePointer);

$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction
if(!$sidx) $sidx =1;

// connect to the database
// $db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
// mysql_select_db($database) or die("Error conecting to db.");

// $result = mysql_query("SELECT COUNT(*) AS count FROM invheader a, clients b WHERE a.client_id=b.client_id".$wh);
// $row = mysql_fetch_array($result,MYSQL_ASSOC);
// $count = $row['count'];

// if( $count >0 ) {
//    $total_pages = ceil($count/$limit);
// } else {
//     $total_pages = 0;
// }

// if ($page > $total_pages) $page=$total_pages;
// $start = $limit*$page - $limit; // do not put $limit*($page - 1)
// if ($start<0) $start = 0;

// $SQL = "SELECT invid,invdate,amount,tax,total,note FROM invheader ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
// $result = mysql_query( $SQL ) or die("Could not execute query.".mysql_error());

// Construct the json data
$response->page = 1; // $page; // current page
$response->total = 1; // $total_pages; // total pages
$response->records = 10; // $count; // total records

// $i=0;
// while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
//    $response->rows[$i]['id']=$row[invid]; //id
//    $response->rows[$i]['cell']=array($row[invid],$row[invdate],$row[amount],$row[tax],$row[total],$row[note]);
//    $i++;
// }

$response->rows[0]['id'] = 'x0';
$response->rows[0]['cell'] = array('x0','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx;TN:TNT','Cero');

$response->rows[1]['id'] = 'x1';
$response->rows[1]['cell'] = array('x1','01/01/10','Cero','Cero','Cero','Cero','Yes','FedEx','Cero');

$response->rows[2]['id'] = 'x2';
$response->rows[2]['cell'] = array('x2','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[3]['id'] = 'x3';
$response->rows[3]['cell'] = array('x3','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[4]['id'] = 'x4';
$response->rows[4]['cell'] = array('x4','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[5]['id'] = 'x5';
$response->rows[5]['cell'] = array('x5','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[6]['id'] = 'x6';
$response->rows[6]['cell'] = array('x6','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[7]['id'] = 'x7';
$response->rows[7]['cell'] = array('x7','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[8]['id'] = 'x8';
$response->rows[8]['cell'] = array('x8','01/01/10','Cero','Cero','Cero','Cero','Yes','FE:FedEx','Cero');

$response->rows[9]['id'] = 'x9';
$response->rows[9]['cell'] = array('x9','01/01/10','Cero','Cero','Cero','Cero','No','TNT','Cero');


echo json_encode($response);

?>
