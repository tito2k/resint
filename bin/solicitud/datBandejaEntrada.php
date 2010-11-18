<?php
	// Bibliotecas y Globales
	require_once("../../etc/globales.php");

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
	$qs  = "SELECT idalmacen FROM usuarioalmacen WHERE idusuario='$idUsuario';";
	$rs  = $db->query($qs);
	$row = $rs->fetchAll(PDO::FETCH_ASSOC);
	// Generar los datos para jqgrid
	foreach ( $row as $tpla )
	{
		$secciones .= $tpla['idalmacen'] .','; 
	}
	$secciones = substr($secciones,0,strlen($secciones)-1);
   
   
   
	$filtro = " WHERE t.idalmacen IN ($secciones) AND t.idestado > ".ETR_BORRADOR;
	
	if ($buscar == 'true')	
		$filtro .= " AND t.idestado = $estado";
	 
	require_once ("../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM transaccion t ".$filtro;
    $sql_data = "SELECT t.idtransaccion, date_format(t.fechainicio,'%d/%m/%Y') as fechainicio, 
    			date_format(t.fechaactual,'%d/%m/%Y') as fechaactual, e.idestado AS idestado, e.descripcion AS descestado, 
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
