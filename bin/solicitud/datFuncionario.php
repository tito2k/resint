<?php

/*

  :::::
::::
::    0     Datos del Funcionario
::   000
::  00000   Recibe una CI y devuelve los datos del funcionario
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Obtener la cedula
$idSesion = $_POST["idSesion"];
$Cedula   = $_POST["Cedula"];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener los datos
$db = dbConnect("personal");
$rs = $db->query( "CALL personal.datosFuncionario('$Cedula')" );

// Hay info ?
if ( $rs->rowCount() )
{
   // Obtener los datos
   $row = $rs->fetchObject();
   $datosFuncionario['Legajo']    = $row->legajo;
   $datosFuncionario['pNombre']   = $row->pNombre;
   $datosFuncionario['sNombre']   = $row->sNombre;
   $datosFuncionario['pApellido'] = $row->pApellido;
   $datosFuncionario['sApellido'] = $row->sApellido;
   $datosFuncionario['Grado']     = $row->grado;

   // Devolver los datos
   printf("%s: %s, %s",$datosFuncionario['Grado'],$datosFuncionario['pApellido'],$datosFuncionario['pNombre']);
}
else
   printf('<span class="errorMessage" style="color: red;">%s</span>',MSG_NO_DOCUMENTO);

?>
