<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");


    showPage($key);

function showPage($key){

	global $conn;
    mysql_select_db("talos",$conn);
  
    $fxlt = new fxl_template('pntusuarioaplicacion.html');
    $fxlt->assign('_-TABLA-_','usuario');
    $fxlt->assign('_-TABLA_APLICACION-_','talos.usuarioaplicacion');

    $fxlt->assign('_-CAPTION-_', 'Usuarios');
    $fxlt->assign('_-CAPTION-APLICACIONES-_', 'Aplicaciones del usuario');

	$sql = "SELECT idusuario FROM talos.usuario;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= utf8_encode($row["idusuario"]) .':'. utf8_encode($row["idusuario"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-USUARIOS-_', $json);

	$sql = "SELECT idaplicacion, descripcion FROM aplicacion;";
	$res = mysql_query($sql, $conn);
	$json = "";
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idaplicacion"] .':'. utf8_encode($row["descripcion"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-APLICACIONES-_', $json);


	$sql = "SELECT idnivel, descripcion FROM nivel;";
	$res = mysql_query($sql, $conn);
	$json = "";
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idnivel"] .':'. utf8_encode($row["descripcion"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-NIVELES-_', $json);
    
    
    //echo 'datos:'.$sql;
	$fxlt->display();
   
   
}

?>
