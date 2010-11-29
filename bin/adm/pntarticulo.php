<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	// Bibliotecas y Globales
	require_once("../../etc/globales.php");

	$idSesion      = $_POST['idSesion'];
	

	// De no haber sesion, adios ...
	if ( !sesionValida($idSesion) ) return;

	showPage('',$idSesion);


function showPage($msg,$idSesion){

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
	$fxlt->assign('_-FAMILIAS-_', $json);
	
	$json = '';
	$sql = "SELECT idseccion, descripcion FROM seccion WHERE idtipo=1 ORDER BY descripcion;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idseccion"].':'.$row["descripcion"].';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	$fxlt->assign('_-SECCIONES-_', $json);	

	mysql_free_result($res);

	$fxlt->assign('idSesion', $idSesion);

	
	$fxlt->display();

}


?>
