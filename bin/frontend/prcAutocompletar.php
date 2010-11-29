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
::          Se decide por cual campo buscar ya sea de manera explicita, porque
::          viene indicado su nombre en $buscarPor; o de manera implicita por
::          la presencia de un caracter ' #' al inicio de $valor. La presencia
::          de '#' tiene mayor precedencia que $buscarPor.
::
::          $idSesion         Identificador de la sesion
::          $tabla            Tabla en la cual buscar
::          $buscarPor        Campo por el cual buscar ['clave'|'descripcion']
::          $campoClave       Nombre del campo clave
::          $campoDesc        Nombre del campo descripcion
::          $valor            Valor ingresado por el usuario
::          $campoFiltro      Campo para el filtro adicional sobre la tabla
::          $valorFiltro      Valor para el filtro adicional sobre la tabla
::          $tplas            Tuplas devueltas
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion    = $_GET["idSesion"];
$tabla       = $_GET["tabla"];
$buscarPor   = $_GET["buscar"];
$campoClave  = $_GET["campoClave"];
$campoDesc   = $_GET["campoDesc"];
$valor       = $_GET["term"];
$campoFiltro = $_GET["campoFiltro"];
$valorFiltro = $_GET["valorFiltro"];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Resolver nombre del campo por el cual buscar y ordenar
if ( substr($valor,0,1) == '#' )
{
   $campoBuscar = $campoClave;
   $valor = substr($valor,1);
}
else
   $campoBuscar = ($buscarPor == 'clave') ? $campoClave : $campoDesc;

// Construir el Filtro
$filtro = "";
if ( $campoFiltro && $valorFiltro )
   $filtro = " AND $campoFiltro = $valorFiltro ";

// Buscar y retornar lista de valores
$tplas = autocompletar($campoClave,$campoDesc,$campoBuscar,$tabla,$valor,$filtro);

// Armando el resultado
$result = array();
foreach ( $tplas as $tpla )
{
   array_push($result, array("id"=>$tpla[$campoClave], "label"=>"#" . $tpla[$campoClave] . " " . $tpla[$campoDesc], "value" => strip_tags($tpla[$campoDesc])));
}

// Enviar en formato json
echo json_encode($result);
?>
