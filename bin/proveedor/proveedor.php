<?php
$page = $_GET['page']; // get the requested page 
$limit = $_GET['rows']; // get how many rows we want to have into the grid 
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
$sord = $_GET['sord']; // get the direction 
if(!$sidx) $sidx =1; 
// connect to the database 
/*
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error()); 
mysql_select_db($database) or die("Error conecting to db."); 
$result = mysql_query("SELECT COUNT(*) AS count FROM invheader a, clients b WHERE a.client_id=b.client_id"); 
$row = mysql_fetch_array($result,MYSQL_ASSOC); 
$count = $row['count']; 
*/
$count = 13;
/*
if( $count >0 ) { 
			$total_pages = ceil($count/$limit); 
} else { 
			$total_pages = 0; 
} 

if ($page > $total_pages) $page=$total_pages; 
$start = $limit*$page - $limit; // do not put $limit*($page - 1) 
$SQL = "SELECT a.id, a.invdate, b.name, a.amount,a.tax,a.total,a.note FROM invheader a, clients b WHERE a.client_id=b.client_id ORDER BY $sidx $sord LIMIT $start , $limit"; 
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error()); 
*/
$responce->page = 1; 
$responce->total = 1; 
$responce->records = 13; 
$responce->rows[0]['id'] = 'x1';
$responce->rows[0]['cell'] = array('x1','2010-09-07','Carlitos',10000,5,10005,'Esto es una prueba');
$responce->rows[1]['id'] = 'x2';
$responce->rows[1]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[2]['id'] = 'x3';
$responce->rows[2]['cell'] = array('x3','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[3]['id'] = 'x4';
$responce->rows[3]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[4]['id'] = 'x5';
$responce->rows[4]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[5]['id'] = 'x6';
$responce->rows[5]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[6]['id'] = 'x7';
$responce->rows[6]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[7]['id'] = 'x8';
$responce->rows[7]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[8]['id'] = 'x9';
$responce->rows[8]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[9]['id'] = 'x10';
$responce->rows[9]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[10]['id'] = 'x11';
$responce->rows[10]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[11]['id'] = 'x12';
$responce->rows[11]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
$responce->rows[12]['id'] = 'x13';
$responce->rows[12]['cell'] = array('x2','2009-01-01','Fernandito',20000,8,20008,'Esto es una prueba 2');
/*
$i=0; 
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$responce->rows[$i]['id']=$row[id];
		$responce->rows[$i]['cell']=array($row[id],$row[invdate],$row[name],$row[amount],$row[tax],$row[total],$row[note]); 
		$i++; 
} 
*/
echo json_encode($responce); 
?>
