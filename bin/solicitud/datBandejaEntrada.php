<?php
	// Bibliotecas y Globales
	require_once("../../etc/globales.php");

	$buscar = $_GET['_search'];
	$idSesion = $_GET['idSesion'];
	$idestado = $_GET['_field_D_idestado'];
	
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
   
   

	$filtro = " t.idalmacen IN ($secciones) AND t.idestado > ".ETR_BORRADOR;
	
	if ($buscar == 'true' && $idestado != 0)	
		$filtro .= " AND t.idestado = $idestado";
	 
	require_once ("../../lib/generica.class.php");

		$sql_count = "SELECT COUNT(*) FROM
										(SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Seccion' AS destino, s.descripcion AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN seccion s ON s.idseccion=t.iddestino
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='S'
									union
										SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Funcionario' AS destino, t.iddestino AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='F'
									union
										SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Vehiculo' AS destino, t.iddestino AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='V'
										) u";
	
	$sql_data = "SELECT *,u.idtransaccion as id FROM
										(SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Seccion' AS destino, s.descripcion AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN seccion s ON s.idseccion=t.iddestino
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='S'
									union
										SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Funcionario' AS destino, t.iddestino AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='F'
									union
										SELECT t.idtransaccion,
														concat((t.idtransaccion - (t.idtransaccion DIV 10000) * 10000),'/',(t.idtransaccion DIV 10000)) AS nroSolicitud,
														o.descripcion AS origen,
														date_format(t.fechainicio,'%d/%m/%Y') AS Inicio,
														'Vehiculo' AS destino, t.iddestino AS identificacion,
														t.idestado AS estado, e.descripcion AS idestado, date_format(t.fechaactual,'%d/%m/%Y') AS Fecha, a.descripcion AS almacen
										FROM transaccion t
										INNER JOIN seccion o ON o.idseccion=t.idorigen
										INNER JOIN seccion a ON a.idseccion=t.idalmacen
										INNER JOIN estadotransaccion e ON e.idestado=t.idestado
										WHERE $filtro and t.destino='V'
										) u";

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
