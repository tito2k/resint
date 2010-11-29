<?php

	// Bibliotecas y Globales
	require_once("../../etc/globales.php");
	
	$idSesion      = $_GET['idSesion'];
	// De no haber sesion, adios ...
	if ( !sesionValida($idSesion) ) return;

  require_once ("../../lib/generica.class.php");

    
	// Obtener los datos del Usuario
	$datosUsuario = datosUsuario($idSesion);
	$idUsuario   = $datosUsuario['idUsuario'];
  
    
  $sql_count = "SELECT COUNT(*) AS count FROM articulo
  							WHERE idseccion IN (SELECT idalmacen FROM usuarioalmacen
																		WHERE idusuario = '$idUsuario') 
								OR idseccion=0";
  
  $sql_data = "SELECT a.idarticulo, a.nombre, s.descripcion AS idseccion,
  								 f.nombre AS idfamilia, stock, stockminimo, 
                m.nombre as idmagnitud,concat('idarticulo=',a.idarticulo) AS id 
                FROM articulo a
                LEFT JOIN magnitud m ON m.idmagnitud = a.idmagnitud 
								LEFT JOIN familia f ON f.idfamilia = a.idfamilia 
								LEFT JOIN seccion s ON s.idseccion = a.idseccion
								WHERE a.idseccion IN (SELECT idalmacen FROM usuarioalmacen
																		WHERE idusuario = '$idUsuario') 
								OR a.idseccion=0";
//die($sql_data);
  $generica = new Generica();
  echo $generica->select($sql_count,$sql_data);
  $generica = null;


?>
