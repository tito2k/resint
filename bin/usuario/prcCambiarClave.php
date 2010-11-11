<?php

/*

  :::::
::::
::   ***    Cambiar Clave.
::  *****
::   ***    Toma los datos mediante POST e invoca el SP iniciarSesion()
::          y de acuerdo a su resultado da inicio a la sesion o reporta ERROR.
::
::          $idSesion                   Identificador de sesion
::          $claveActual                La clave actual del Usuario
::          $claveNueva                 La nueva clave
::          $claveVerifica              La verificacion de la clave
::          $dataSet                    El paquete de datos json a devolver
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion      = $_POST["idSesion"];
$claveActual   = $_POST["claveActual"];
$claveNueva    = $_POST["claveNueva"];
$claveVerifica = $_POST["claveVerifica"];

// Datos de prueba ------------------------

$idSesion      = '12345';
$claveActual   = '12345';
$claveNueva    = '12345';
$claveVerifica = '12345';

// Datos de prueba ------------------------

// Sesion Inalida ?
if ( sesionValida($idSesion) )
{
   $dataSet['estadoSesion'] = SESION_OK;

   // Verifico bien ?
   if ( $claveNueva == $claveVerifica )
   {
      if ( cambiarClave($idSesion,$claveActual,$claveNueva) )
      {
         $dataSet['resultadoCambio'] = CAMBIO_OK;
         $dataSet['mensaje'] = MSG_CAMBIO_OK;
      }
      else
      {
         $dataSet['resultadoCambio'] = CAMBIO_ERROR;
         $dataSet['mensaje'] = MSG_CAMBIO_ERROR;
      }
   }
   else
   {
      $dataSet['resultadoCambio'] = CAMBIO_ERROR;
      $dataSet['mensaje'] = MSG_CLAVE_NO_VERIFICA;
   }
}
else
{
   $dataSet['estadoSesion'] = SESION_ERROR;
}

// Devolver los datos
echo json_encode($dataSet);
?>
