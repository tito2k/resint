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

// Obtener los datos
$db = dbConnect("resint");
$rs = $db->query( "CALL resint.datosVehiculo('$Matricula')" );
$row = $rs->fetchObject();

$datosVehiculo['Tipo']   = $row->tipo;
$datosVehiculo['Marca']  = $row->marca;
$datosVehiculo['Modelo'] = $row->modelo;

// Devolver los datos
//echo json_encode($datosVehiculo);
printf("%s: %s, %s", $datosVehiculo['Tipo'], $datosVehiculo['Marca'], $datosVehiculo['Modelo']);
?>
