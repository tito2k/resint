<?php

/*

  :::::
::::
::   ***    Genera la Pantala de una Nueva Solicitud
::  *****
::   ***    A partir del idSesion toma los datos del usuario para generar.
::          la lista de secciones que este puede representar (es decir, que
::          puede solicitar en nombre de ellas). Luego genera la lista de
::          almacenes a las cuales se les puede solicitar articulos.
::
::          $idSesion         Identificador de sesion (POST)
::          $datosUsuario     Arreglo con los datos del Usuario
::          $opSecciones      Lista de secciones en formato <OPTION>
::          $opAlmacenes      Lista de almacenes en formato <OPTION>
::          $pntNuevaSol      El template para la pantalla
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion = $_POST['idSesion'];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener datos del Usuario
$datosUsuario = datosUsuario($idSesion);

// Obtener las Secciones que puede representar este usuario
$db  = dbConnect("resint");
$qs  = "SELECT s.idseccion AS idSeccion, s.descripcion AS Seccion ";
$qs .= "FROM seccion s ";
$qs .= "INNER JOIN usuarioseccion us ON us.idseccion=s.idseccion ";
$qs .= "WHERE us.idusuario='" . $datosUsuario['idUsuario'] . "' ";
$qs .= "ORDER BY s.descripcion;";
$rs  = $db->query($qs);
$row = $rs->fetchAll(PDO::FETCH_ASSOC);

// Generar las marcas <OPTION>
$opSecciones = "";
foreach ( $row as $tpla )
{
   $opSecciones .= '<OPTION value="' . $tpla['idSeccion'] . '">';
   $opSecciones .= $tpla['Seccion'];
   $opSecciones .= '</OPTION>';
}

// Obtener todos los Almacenes
$db  = dbConnect("resint");
$qs  = "SELECT s.idseccion AS idSeccion, s.descripcion AS Seccion ";
$qs .= "FROM seccion s ";
$qs .= "WHERE s.idtipo=" . SEC_ALMACEN . " ";
$qs .= "ORDER BY s.descripcion;";
$rs  = $db->query($qs);
$row = $rs->fetchAll(PDO::FETCH_ASSOC);

// Generar las marcas <OPTION>
$opAlmacenes = "";
foreach ( $row as $tpla )
{
   $opAlmacenes .= '<OPTION value="' . $tpla['idSeccion'] . '">';
   $opAlmacenes .= $tpla['Seccion'];
   $opAlmacenes .= '</OPTION>';
}

// Procesar el template y desplegar
$pntNuevaSol = new fxl_template("pntNueva.html");
$pntNuevaSol->assign("secciones",$opSecciones);
$pntNuevaSol->assign("almacenes",$opAlmacenes);
$pntNuevaSol->assign("fechaactual",date("d/m/Y"));
$pntNuevaSol->display();


?>
