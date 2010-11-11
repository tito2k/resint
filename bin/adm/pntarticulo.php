<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");

	showPage('');


function showPage($msg){

	global $conn;
    mysql_select_db("resint",$conn);

	$fxlt = new fxl_template('pntarticulo.html');

	$fxlt->assign('_-CAPTION-_', 'Art&iacute;culos');
	$fxlt->assign('_-TABLE-_', 'articulo');
	
	$sql = "SELECT idmagnitud, nombre FROM magnitud ORDER BY idmagnitud;";
	$res = mysql_query($sql, $conn);
	$json = "";
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idmagnitud"] .':'. utf8_encode($row["nombre"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	mysql_free_result($res);
	$fxlt->assign('_-MAGNITUDES-_', $json);

	$json = "";
	$sql = "SELECT idfamilia, nombre FROM familia ORDER BY nombre;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idfamilia"] .':'. utf8_encode($row["nombre"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
/*
	$sql = "SELECT idnivel, descripcion FROM talos.nivel;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idnivel"].':'.$row["descripcion"].';'; 
	} 
*/

	mysql_free_result($res);
	$fxlt->assign('_-FAMILIAS-_', $json);
	
	$fxlt->display();

}


?>
