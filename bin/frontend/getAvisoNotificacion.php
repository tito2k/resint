
<?php

/*

  :::::
::::
::   ***    Advierte si existen notificaciones.
::  *****
::   ***    Verifica una serie de situaciones que ameritan notificar al usuario
::          y de presentarse alguna de ellas despliega en pantalla un aviso.
::
::          $idSesion                   Identificador de sesion
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");
require_once("../../lib/notificaciones.php");

// Recuperar los datos del formulario
$idSesion = $_POST["idSesion"];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener los datos
$arrNotificacion = getNotificaciones();

// Desplegar
if ( count($arrNotificacion) )
   readfile("pntAvisoNotificacion.html");
else
   echo "";

?>
