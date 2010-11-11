<?php

/*

  :::::
::::
::   ***    Diagrama de Estado de la Solicitud.
::  *****
::   ***    Recibe el estado de la transaccion y construye el diagrama de
::          estado para el usuario y lo despliega.
::
::          Construye el diagrama con los iconos color o grisados segun el
::          estado. En caso de estar denegada, todo ediagrama esta grisado,
::          en los otros casos segun el estado es la secuencia de iconos color.
::
::          $idSesion                   Identificador de sesion
::          $idEstado                   Identificador del estado
::
::          $icnInicio                  Icono para ETR_BORRADOR
::          $icnRatificada              Icono para ETR_RATIFICADA
::          $icnAutorizada              Icono para ETR_AUTORIZADA
::          $icnEstado                  Icono para ETR_ENTREGA_PARCIAL
::          $icnFinal                   Icono para ETR_ENTREGA_TOTAL
::
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$idSesion = $_POST["idSesion"];
$idEstado = $_POST["idEstado"];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// En principio todo grisado
$icnInicio     = "grayInicio";
$icnRatificada = "grayEstado";
$icnAutorizada = "grayEstado";
$icnEntregada  = "grayEstado";
$icnFinal      = "grayFinal";

// Construccion de los estados
if ( $idEstado != ETR_DENEGADA )               // Si es Denegada ya esta.
{
   if( $idEstado >= ETR_BORRADOR ) $icnInicio = "colorInicio";
   if( $idEstado >= ETR_RATIFICADA ) $icnRatificada = "colorRatificada";
   if( $idEstado >= ETR_AUTORIZADA ) $icnAutorizada = "colorAutorizada";
   if( $idEstado >= ETR_ENTREGA_PARCIAL ) $icnEntregada = "colorEntregada";
   if( $idEstado == ETR_ENTREGA_TOTAL ) $icnFinal = "colorFinal";
}

// Desplegar
$pntDiagrama = new fxl_template("pntDiagrama.html");
$pntDiagrama->assign("Inicio",$icnInicio);
$pntDiagrama->assign("Ratificada",$icnRatificada);
$pntDiagrama->assign("Autorizada",$icnAutorizada);
$pntDiagrama->assign("Entregada",$icnEntregada);
$pntDiagrama->assign("Final",$icnFinal);
$pntDiagrama->display();

?>
