<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");

	showPage('');


function showPage($msg){

	global $conn;
    
	$fxlt = new fxl_template('pntfamilia.html');

	$fxlt->assign('_-CAPTION-_', 'Familias');
	$fxlt->assign('_-TABLE-_', 'familia');
	

	$fxlt->display();
}


?>
