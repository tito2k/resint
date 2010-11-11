
<?php

/*

  :::::
::::
::   ***    Titulo de la Tarea.
::  *****
::   ***    Toma los datos mediante POST e invoca titTarea de la biblioteca
::          con el idTarea, parsea el html con los datos obtenidos y despliega.
::
::          $idSesion                   Identificador de sesion
::          $idTarea                    Identificador de la tarea en curso
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion = $_POST["idSesion"];
$idTarea  = $_POST["idTarea"];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener los datos
$row = getTitulo($idTarea);

// Desplegar
putTitulo($row);

?>
