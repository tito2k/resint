<?php

/*

  :::::
::::
::   ***    Terminar Sesion.
::  *****
::   ***    Toma los datos mediante POST e invoca el SP terminarSesion()
::          que se encarga de actualizar la base de datos.
::
::          $idSesion                   Identificador de sesion
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion      = $_POST["idSesion"];

// Termina la sesion
terminarSesion("$idSesion");

?>
