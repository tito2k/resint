<?php

/*

  :::::
::::
::   ***    Autocompletar.
::  *****
::   ***    Resuelve los datos para realizar la busqueda que coresponda de modo
::          de presentar al usuario una lista de posibles coincidencias con lo
::          que va ingresando.
::
::          $idSesion         Identificador de la sesion
::          $tabla            Tabla en la cual buscar
::          $buscarPor        Campo por el cual buscar ['clave'|'descripcion']
::          $campoClave       Nombre del campo clave
::          $campoDesc        Nombre del campo descripcion
::          $valor            Valor ingresado por el usuario
::          $tplas            Tuplas devueltas
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion   = $_GET["idSesion"];
$tabla      = $_GET["tabla"];
$buscarPor  = $_GET["buscar"];
$campoClave = $_GET["campoClave"];
$campoDesc  = $_GET["campoDesc"];
$valor      = $_GET["term"];


// Datos de prueba ---------------------
/*
$idSesion   = '12345';
$tabla      = 'tarea';
$buscarPor  = 'clave';
$campoClave = 'titulo';
$campoDesc  = 'subtitulo';
$valor      = 'cam';
*/
// Datos de prueba ---------------------


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Resolver nombre del campo por el cual buscar y ordenar
$campoBuscar = ($buscarPor == 'clave') ? $campoClave : $campoDesc;

// Buscar y retornar lista de valores
$tplas = autocompletar($campoClave,$campoDesc,$campoBuscar,$tabla,$valor);

// Armando el resultado
$result = array();
foreach ( $tplas as $tpla )
{
	array_push($result, array("id"=>$tpla[$campoClave], "label"=>"#" . $tpla[$campoClave] . " " . $tpla[$campoDesc], "value" => strip_tags($tpla[$campoDesc])));
}

/*
$result = array();
foreach ($tplas as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	}
	if (count($result) > 11)
		break;
}
*/

// Enviar en formato json
echo json_encode($result);
?>
