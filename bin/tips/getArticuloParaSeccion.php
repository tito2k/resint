<?php

/*

  :::::
::::
::   ***    Tip de Articulos para Seccion.
::  *****
::   ***    A partir del idSolicitud, toma los articulos incluidos y muestra
::          las autorizaciones previas de los mismos para esta seccion.
::
::          $idSesion         Identificador de sesion
::          $idSolicitud      Identificador de solicitud
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion    = $_POST['idSesion'];
$idSolicitud = $_POST['idSolicitud'];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;


// Obtener la Seccion que solicita
$db  = dbConnect("resint");
$qs  = "SELECT idorigen from transaccion WHERE idtransaccion=$idSolicitud";
$rs  = $db->query($qs);
$row = $rs->fetch(PDO::FETCH_ASSOC);

$idSeccion     = $row['idorigen'];
$etrRatificada = ETR_RATIFICADA;
$etrAutorizada = ETR_AUTORIZADA;

// Obtener las autorizaciones previas
$db  = dbConnect("resint");
$qs  = "SELECT t.idtransaccion, t.idarticulo, t.idestado, t.cantidad, date_format(max(t.fecha),'%d/%m/%Y') AS fecha, a.nombre
        FROM transaccionarticulo t
        INNER JOIN articulo a ON a.idarticulo=t.idarticulo
        INNER JOIN transaccion r ON r.idtransaccion=t.idtransaccion
        INNER JOIN transaccion r2 ON r2.idorigen=r.idorigen AND r2.idtransaccion=$idSolicitud 
        INNER JOIN transaccionarticulo t2 ON t2.idtransaccion=r2.idtransaccion AND t2.idarticulo = t.idarticulo AND t2.idestado=$etrRatificada 
        AND t.idestado=$etrAutorizada 
        GROUP BY idarticulo
        ORDER BY a.nombre";
$rs   = $db->query($qs);
$tpla = $rs->fetchAll();

// Componer filas
$filas = "";
foreach ( $tpla as $row )
{
   $filas .= "<tr>";
   $filas .= "<td>" . $row['idtransaccion'] . "</td>";
   $filas .= "<td>" . $row['idarticulo'] . "</td>";
   $filas .= "<td>" . $row['nombre'] . "</td>";
   $filas .= "<td>" . $row['cantidad'] . "</td>";
   $filas .= "<td>" . $row['fecha'] . "</td>";
}

// Desplegar
$pntArticulos = new fxl_template("pntArticuloParaSeccion.html");
$pntArticulos->assign("filas",$filas);
$pntArticulos->display();

?>
