<?php

/*

  :::::
::::
::   000    Genera la Pantala para consultar articulos de una Solicitud
::  00000
::   000    A partir del numero de Solicitud recibido recupera los datos
::          de la misma y los substituye en la plantilla HTML.
::
::          $idSesion            Identificador de sesion (POST)
::          $idSolicitud         Numero de la solicitud a ratificar
::
::          $row['fchInicio']    Fecha de Inicio de la Transaccion
::          $row['desOrigen']    Seccion donde se origino la solicitud
::          $row['tipoDestino']  Tipo del destino S | F | V
::          $row['idDestino']    idSeccion | CI | Matreicula
::          $row['desAlmacen']   Seccion Proveedora
::          $row['idEstado']     idEstado de la transaccion
::          $row['desEstado']    Descripcion del Estado
::          $row['fchActual']    Fecha en la que pasa a este estado
::          $row['idUsuario']    El usuario que la puso en este estado
::
::          $pntNuevaSol         El template para la pantalla
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion    = $_POST['idSesion'];
$idSolicitud = $_POST['idSolicitud'];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener las los datos de la Solicitud
$db  = dbConnect("resint");
$qs  = "SELECT t.fechainicio AS fchInicio, t.destino AS tipoDestino,
               t.iddestino AS idDestino, t.observaciones AS Observaciones,
               o.descripcion AS desOrigen, a.descripcion AS desAlmacen,
               e.idestado AS idEstado, e.descripcion AS desEstado
         FROM transaccion t
         INNER JOIN seccion o ON t.idorigen=o.idseccion
         INNER JOIN seccion a ON t.idalmacen=a.idseccion
         INNER JOIN estadotransaccion e ON t.idestado=e.idestado
         WHERE t.idtransaccion=$idSolicitud";
$rs  = $db->query($qs);
$row = $rs->fetch(PDO::FETCH_ASSOC);

// Arreglamos las fechas
$fchInicio = substr($row['fchInicio'],0,10);
ereg( "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $fchInicio, $regs );
$fchInicio = "$regs[3]/$regs[2]/$regs[1]";

$fchActual = substr($row['fchActual'],0,10);
ereg( "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $fchActual, $regs );
$fchActual = "$regs[3]/$regs[2]/$regs[1]";

// El numero de Solicitud
$nroSolicitud = nroSolicitud($idSolicitud);

// Resolución del destino
switch($row['tipoDestino'])
{
   case "F":
         $row['tipoDestino'] = "Funcionario";
         break;
   case "V":
         $row['tipoDestino'] = "Veh&iacute;culo";
         break;
   case "S":
         $row['tipoDestino'] = "Unidad Organizativa";
         $db  = dbConnect("resint");
         $qs  = "SELECT s.descripcion as desSeccion FROM seccion s WHERE s.idseccion=".$row['idDestino'];
         $rs  = $db->query($qs);
         $sec = $rs->fetch(PDO::FETCH_ASSOC);
         $row['idDestino'] = $sec['desSeccion'];
         break;
}

// Procesar el template y desplegar
$pntNuevaSol = new fxl_template("pntConsulta.html");
$pntNuevaSol->assign("idSesion"     , $idSesion);
$pntNuevaSol->assign("idSolicitud"  , $idSolicitud);
$pntNuevaSol->assign("nroSolicitud" , $nroSolicitud);
$pntNuevaSol->assign("fchInicio"    , $fchInicio);
$pntNuevaSol->assign("idOrigen"     , $row['desOrigen']);
$pntNuevaSol->assign("tipoDestino"  , $row['tipoDestino']);
$pntNuevaSol->assign("idDestino"    , $row['idDestino']);
$pntNuevaSol->assign("desAlmacen"   , $row['desAlmacen']);
$pntNuevaSol->assign("idEstado"     , $row['idEstado']);
$pntNuevaSol->assign("desEstado"    , $row['desEstado']);
$pntNuevaSol->assign("observaciones", $row['Observaciones']);
$pntNuevaSol->display();

?>
