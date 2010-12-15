<?php

/*

  :::::
::::
::   ***    Tip de Notificacion.
::  *****
::   ***    A partir del arreglo de notificaciones, muestra un tip con la lista
::          de las notificaciones registradas.
::
::          $idSesion         Identificador de sesion
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");
require_once("../../lib/notificaciones.php");

// Recuperar los datos del formulario
$idSesion    = $_POST['idSesion'];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;


// Obtener notificaciones
$arrNotificacion = getNotificaciones();

// Componer filas
$filas = "";
foreach ( $arrNotificacion as $row )
{
   $filas .= "<tr>";
   $filas .= "<td class='unaNotificacion'>&#187;&nbsp;&nbsp;&nbsp;" . $row . "</td>";
}

// Desplegar
$pntNotificaciones = new fxl_template("pntNotificacion.html");
$pntNotificaciones->assign("filas",$filas);
$pntNotificaciones->display();

?>
