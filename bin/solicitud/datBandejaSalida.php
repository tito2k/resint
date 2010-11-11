<?php
	// Bibliotecas y Globales
	require_once("../../etc/globales.php");

    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);

	$buscar = $_GET['_search'];
	$idSesion = $_GET['idSesion'];
	$estado = $_GET['_field_D_descestado'];
	
	// De no haber sesion, adios ...
	if ( !sesionValida($idSesion) ) return;

	// Obtener datos del Usuario
	$datosUsuario = datosUsuario($idSesion);
	$idUsuario = $datosUsuario['idUsuario'];

	$db  = dbConnect("resint");
 
	// Obtener la sección del usuario
	$qs  = "SELECT idseccion FROM usuarioseccion WHERE idusuario='$idUsuario';";
	$rs  = $db->query($qs);
	$row = $rs->fetchAll(PDO::FETCH_ASSOC);
	// Generar los datos para jqgrid
	foreach ( $row as $tpla )
	{
		$secciones .= $tpla['idseccion'] .','; 
	}
	$secciones = substr($secciones,0,strlen($secciones)-1);
   
   
   
	$filtro = " WHERE t.idorigen IN ($secciones)";
	
	if ($buscar == 'true')	
		$filtro .= " AND t.idestado = $estado";
	 
	require_once ("../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM transaccion";
    $sql_data = "SELECT t.idtransaccion, t.fechainicio, t.fechaactual, e.idestado AS idestado, e.descripcion AS descestado, 
    			s.descripcion AS idseccion, a.descripcion AS idalmacen, '' as edit, '' as view,
    			concat('idtransaccion=',t.idtransaccion) AS id 
                FROM transaccion t
                INNER JOIN seccion a ON a.idseccion = t.idalmacen 
                INNER JOIN seccion s ON s.idseccion = t.idorigen 
                INNER JOIN estadotransaccion e ON e.idestado = t.idestado ".$filtro;

    $generica = new Generica();
    if ($generica->_search == "false"){
        // Es un select sin filtro 
        echo $generica->select($sql_count,$sql_data);
    }
    else{
        // Es un select con filtro 
        echo $generica->search($sql_count,$sql_data);        
    }
    $generica = null;


?>