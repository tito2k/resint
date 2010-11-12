<?php

/*

  :::::
::::
::    0     Siguiente tarea en la secuancia de la Transaccion
::   000
::  00000   A partir del estado actual de la Solicitud y del Nivel del usuario
::          determina cual es la siguiente tarea en la secuancia.
::          La tarea siguiente esta registrada en una matriz de doble entrada
::          con indices idEstado (de la tarea) y nivelAcceso (del usuario).
::          Dado el idTarea asi obtenido, se devuelve el mismo junto con la URL
::          almacenada en la base de datos para esa tarea.
::
::          $idSesion         Identificador de Sesion
::          $idEstado         Estado actual de la Solicitu
::
::          $tareaSiguiente   Matriz con los idTarea siguientes
::          $datosUsuario      Datos del usuario, de aqui tomamos el nivelAcceso
::          $datosSiguiente   Aqui devolvemos el idTarea u su URL
::
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Obtener los datos
$idSesion = $_GET["idSesion"];
$idEstado = $_GET["idEstado"];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Matriz de tarea sguiente
$tareaSiguiente[NA_OPERADOR_UNIDAD]  = array(ETR_BORRADOR => 409, ETR_RATIFICADA => 409, ETR_AUTORIZADA => 409, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 409, ETR_ENTREGA_TOTAL => 409);
$tareaSiguiente[NA_OPERADOR_ALMACEN] = array(ETR_BORRADOR => 409, ETR_RATIFICADA => 409, ETR_AUTORIZADA => 406, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 406, ETR_ENTREGA_TOTAL => 409);
$tareaSiguiente[NA_ENCARGADO]        = array(ETR_BORRADOR => 405, ETR_RATIFICADA => 409, ETR_AUTORIZADA => 409, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 409, ETR_ENTREGA_TOTAL => 409);
$tareaSiguiente[NA_SUPERVISOR]       = array(ETR_BORRADOR => 405, ETR_RATIFICADA => 407, ETR_AUTORIZADA => 406, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 406, ETR_ENTREGA_TOTAL => 409);
$tareaSiguiente[NA_GERENTE]          = array(ETR_BORRADOR => 405, ETR_RATIFICADA => 407, ETR_AUTORIZADA => 406, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 406, ETR_ENTREGA_TOTAL => 409);
$tareaSiguiente[NA_ADMIN]            = array(ETR_BORRADOR => 405, ETR_RATIFICADA => 407, ETR_AUTORIZADA => 406, ETR_DENEGADA => 409, ETR_ENTREGA_PARCIAL => 406, ETR_ENTREGA_TOTAL => 409);

// Obtener los datos
$datosUsuario = datosUsuario($idSesion);

// La tarea Siguiente ...
$idTarea = $tareaSiguiente[$datosUsuario['idNivel']][$idEstado];
$datosSiguiente['idTarea'] = $idTarea;

// La url correspondiente ...
$db  = dbConnect("resint");
$rs  = $db->query( "SELECT idtarea,url FROM tarea WHERE idtarea=$idTarea" );
$row = $rs->fetchObject();
$datosSiguiente['idTarea'] = $row->idtarea;
$datosSiguiente['url'] = $row->url;

// Devolver los datos
echo json_encode($datosSiguiente);

?>
