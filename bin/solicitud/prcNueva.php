<?php

/*

  :::::
::::
::   000    Nueva Solicitud
::  00000
::   000    Graba la nueva solicitud a partir de los datos del formulario.
::          El identificador unico se genera a partir del SP de la base.
::          Se genera la nueva transaccion y los articulos correpondientes.
::          Segun el nivel de acceso del operador queda ratificada o simplemente
::          ingresada para su posterior ratificacion.
::
::          $idSesion         Identificador de sesion
::          $fecha            Fecha de la solicitud
::          $destino          A donde van los articulos S | F | V
::                            S -> Unidad Organisativa (Seccion)
::                            F -> Funcionario
::                            V -> Vehiculo
::          $idDestino        S: idSeccion, F: Cedula, V: Matricula
::          $almacen          Almaces (seccion) a la que se le solicita
::          $datos            json de los articulos {id:valor,cant:valor}, ...
::          $observaciones    Observaciones ;-)
::
::          $articulos        Arreglo de articulos como objetos.
::          $idSolicitud      Numero de Solicitud generado en la base.
::          $nivelAcceso      Privilegios del usuario
::          $idUsuario        Identificador del usuaro.
::          $estado           Estado de la transaccion (Borrador|Ratificada)
::          $tipo             Tipo de Transaccion (Solicitud)
::          $dataSet          El paquete de datos json a devolver
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion      = $_POST['idSesion'];
$fecha         = $_POST['fecha'];
$destino       = $_POST['destino'];
$idSeccion     = $_POST['idSeccion'];
$idFuncionario = $_POST['idFuncionario'];
$idVehiculo    = $_POST['idVehiculo'];
$almacen       = $_POST['almacen'];
$datos         = $_POST['datos'];
$observaciones = $_POST['observaciones'];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::          RESOLUCION DE DATOS           ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Resolución del destino
switch ( $destino )
{
   case 'S':
      $idDestino = $idSeccion;
      break;

   case 'F':
      $idDestino = $idFuncionario;
      break;

   case 'V':
      $idDestino = $idVehiculo;
      break;
}

// Convertir fecha a formato AAAA-MM-DD
ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $fecha, $regs );
$fecha = "$regs[3]-$regs[2]-$regs[1]";

// Convertir los datos a un arreglo de objetos
$articulos = json_decode(stripcslashes($datos));

// Obtener los datos del Usuario
$datosUsuario = datosUsuario($idSesion);
$idUsuario   = $datosUsuario['idUsuario'];
$nivelAcceso = $datosUsuario['idNivel'];

// Obtener un idUnico para esta transaccion de tipo solicitud
$db = dbConnect("resint");
$rs = $db->query( "CALL resint.nuevaSolicitud()" );
$row = $rs->fetchObject();
$idSolicitud = $row->idSolicitud;

// El tipo de Transaccion
$tipo = TRS_SOLICITUD;

// El estado depende del nivel del operador
if ( $nivelAcceso < NA_ENCARGADO )
   $estado = ETR_BORRADOR;
else
   $estado = ETR_RATIFICADA;


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::         GRABADO DE LAS TABLAS          ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Iniciar la Transaccion
$db = dbConnect("resint");
$db->beginTransaction();

// Grabar el Seguimiento
$qs = "INSERT INTO seguimiento
       VALUES ($idSolicitud,$estado,'$fecha','$idUsuario')";
$db->exec($qs);

// Grabar datos del cabezal
$qs = "INSERT INTO transaccion
       VALUES ($idSolicitud,$estado,$tipo,'$idDestino',$almacen,'$fecha','$fecha','$observaciones','$destino')";
$db->exec($qs);

// Grabar la lista de articulos
foreach ( $articulos as $renglon )
{
   $qs = "INSERT INTO transaccionarticulo
          VALUES (sysdate(),$idSolicitud,$estado,$renglon->idarticulo,$renglon->cantidad)";
   $db->exec($qs);
}

// Finalizar Transaccion
$db->commit();


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::   DIAGNOSTICO Y NUMERO DE SOLICITUD    ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

$anio = floor($idSolicitud / 10000);
$numero = $idSolicitud - ($anio * 10000);
$msgNumSol = sprintf("%s %04d/%d",MSG_NRO_SOLICITUD,$numero,$anio);

// Devolver el resultado
$dataSet['resultadoOperacion'] = TAREA_OK;
$dataSet['mensaje'] = $msgNumSol;

echo json_encode($dataSet);

?>
