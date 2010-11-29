<?php

/*

  :::::
::::
::    0     Datos del Vehiculo
::   000
::  00000   Recibe una Matricula y devuelve los datos del Vehiculo
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Obtener la cedula
$idSesion  = $_POST["idSesion"];
$Matricula = $_POST["Matricula"];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Consulta
$db = dbConnect("resint");
$rs = $db->query( "CALL resint.datosVehiculo('$Matricula')" );

// Hay info ?
if ( $rs->rowCount() )
{
   // Obtener los datos
   $row = $rs->fetchObject();
   $datosVehiculo['Tipo']   = $row->tipo;
   $datosVehiculo['Marca']  = $row->marca;
   $datosVehiculo['Modelo'] = $row->modelo;

   // Devolver los datos
   printf("%s: %s, %s", $datosVehiculo['Tipo'], $datosVehiculo['Marca'], $datosVehiculo['Modelo']);
}
else
   printf('<span class="errorMessage" style="color: red;">%s</span>',MSG_NO_MATRICULA);

?>
