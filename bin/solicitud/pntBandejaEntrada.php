<?php

	// Bibliotecas y Globales
	require_once ("../../lib/template.php");
	require_once("../../etc/globales.php");

	// Recuperar los datos
	$idSesion = $_POST['idSesion'];


	// De no haber sesion, adios ...
	if ( !sesionValida($idSesion) ) return;

	// Obtener datos del Usuario
	$datosUsuario = datosUsuario($idSesion);

	$db  = dbConnect("resint");
 
	// Obtener los tipos de servicio
	$qs  = "SELECT idestado, descripcion FROM estadotransaccion ORDER BY descripcion;";
	$rs  = $db->query($qs);
	$row = $rs->fetchAll(PDO::FETCH_ASSOC);
	// Generar los datos para jqgrid
	$opEstados = '0:Todos;';
	foreach ( $row as $tpla )
	{
		$opEstados .= $tpla['idestado'] .':'. utf8_encode($tpla['descripcion']) .';'; 
	}
	$opEstados = substr($opEstados,0,strlen($opEstados)-1);
   
	$fxlt = new fxl_template('pntBandejaEntrada.html');

	$fxlt->assign('_-CAPTION-_', 'Bandeja de entrada');
	$fxlt->assign('_-TABLE-_', 'transaccion');
	$fxlt->assign('_-ESTADOS-_', $opEstados);	
	$fxlt->assign('idSesion', $idSesion);	

	$fxlt->display();

?>
