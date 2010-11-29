<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");


    showPage($key);

function showPage($key){

  	global $conn;
    mysql_select_db("talos",$conn);

  
    $fxlt = new fxl_template('pntusuarioalmacen.html');
    $fxlt->assign('_-TABLA-_','usuario');
    $fxlt->assign('_-TABLA_SECCION-_','usuarioalmacen');

    $fxlt->assign('_-CAPTION-_', 'Usuarios');
    $fxlt->assign('_-CAPTION-SECCIONES-_', 'Almacenes del usuario');

	$sql = "SELECT idusuario FROM talos.usuario;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= utf8_encode($row["idusuario"]) .':'. utf8_encode($row["idusuario"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-USUARIOS-_', $json);
    
	$sql = "SELECT idseccion, descripcion FROM resint.seccion;";
	$res = mysql_query($sql, $conn);
	$json = "";
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idseccion"] .':'. utf8_encode($row["descripcion"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-ALMACENES-_', $json);

    
    //echo 'datos:'.$sql;
	$fxlt->display();
   
   
}

?>
