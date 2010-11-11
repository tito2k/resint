<?php

/*

  :::::
::::
::   ***    Validar Sesion.
::  *****
::   ***    Verifica si la sesion es valida o no y retorna un diagnostico
::          en formato json.
::
::          $idSesion                   Identificador de sesion
::          $dataSet                    El paquete de datos json a devolver
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion = $_POST["idSesion"];

// Sesion Inalida ?
if ( sesionValida($idSesion) )
{
   $dataSet['estadoSesion'] = SESION_OK;
}
else
{
   $dataSet['estadoSesion'] = SESION_ERROR;
}

// Devolver los datos
echo json_encode($dataSet);

?>
