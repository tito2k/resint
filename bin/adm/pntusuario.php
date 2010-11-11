<?php

	require_once ("../../etc/configPHP.inc"); // Conexi�n as servidor SQL
	require_once ("../../lib/template.php");

    showPage('');

function showPage($msg){

    global $conn;
    mysql_select_db("talos",$conn);
    
    $fxlt = new fxl_template('pntusuario.html');
    
    $fxlt->assign('_-TABLA-_','talos.usuario');

    $fxlt->assign('_-CAPTION-_', 'Usuario');
  
    $sql = "select idseccion, descripcion from seccion";
    $res = mysql_query($sql, $conn);

    while ($lp_row = mysql_fetch_assoc($res)){
        $json .= $lp_row["idseccion"] .':'. utf8_encode($lp_row["descripcion"]) .';'; 
    }
    $json = substr($json,0,strlen($json)-1);
    $fxlt->assign('_-SECCIONES-_', $json); 

/*    
    $sql = "select idnivel, descripcion from nivel";
    $res = mysql_query($sql, $conn);
	$json = "";
    while ($lp_row = mysql_fetch_assoc($res)){
        $json .= $lp_row["idnivel"] .':'. utf8_encode($lp_row["descripcion"]) .';'; 
    }
    $json = substr($json,0,strlen($json)-1);
    $fxlt->assign('_-NIVELES-_', $json); 
*/
	$fxlt->display();
}


?>
