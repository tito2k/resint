<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");

	showPage('');


function showPage($msg){

	global $conn;
    mysql_select_db("resint",$conn);
    
	$fxlt = new fxl_template('pnttarea.html');

	$fxlt->assign('_-CAPTION-_', 'Tareas');
	$fxlt->assign('_-TABLE-_', 'tarea');
	
	$sql = "SELECT idtarea, descripcion FROM tarea;";
	$res = mysql_query($sql, $conn);
	while ($row = mysql_fetch_assoc($res)){
		$json .= $row["idtarea"] .':'. utf8_encode($row["descripcion"]) .';'; 
	} 
	$json = substr($json,0,strlen($json)-1);
	
	mysql_free_result($res);
	$fxlt->assign('_-TAREAS-_', $json);

	$fxlt->display();
}


?>
