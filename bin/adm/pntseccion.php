<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");

	showPage('');


function showPage($msg){

	global $conn;
    
	$fxlt = new fxl_template('pntseccion.html');

	$fxlt->assign('_-CAPTION-_', 'Seccion');
	$fxlt->assign('_-TABLE-_', 'seccion');

	$fxlt->display();
}


?>
