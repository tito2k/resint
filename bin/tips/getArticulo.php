<?php

/*

  :::::
::::
::   ***    Tip de Articulo.
::  *****
::   ***    A partir del idArticulo construye una ficha con los datos mas
::          importantes de dicho articulo para ser mostrado en un tip.
::
::          $idSesion            Identificador de sesion
::          $idArticulo          Identificador del articulo
::
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion    = $_POST["idSesion"];
$idArticulo  = $_POST["idArticulo"];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener las los datos del Articulo
$db  = dbConnect("resint");
$qs  = "SELECT a.nombre, a.stock, a.stockminimo,
               s.descripcion AS almacen, f.nombre AS familia,
               m.nombre AS magnitud
        FROM articulo a
        INNER JOIN seccion s ON a.idseccion=s.idseccion
        INNER JOIN magnitud m ON a.idmagnitud=m.idmagnitud
        INNER JOIN familia f ON a.idfamilia=f.idfamilia
        WHERE a.idarticulo=$idArticulo";
$rs  = $db->query($qs);
$row = $rs->fetch(PDO::FETCH_ASSOC);

// Desplegar
$pntArticulo = new fxl_template("pntArticulo.html");
$pntArticulo->assign("articulo",$idArticulo);
$pntArticulo->assign("nombre",$row["nombre"]);
$pntArticulo->assign("stock",$row["stock"]);
$pntArticulo->assign("stockminimo",$row["stockminimo"]);
$pntArticulo->assign("almacen",$row["almacen"]);
$pntArticulo->assign("familia",$row["familia"]);
$pntArticulo->assign("magnitud",$row["magnitud"]);
$pntArticulo->display();

?>
