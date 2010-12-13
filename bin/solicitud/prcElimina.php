<?php

/*

  :::::
::::
::   000    Elimina Solicitud
::  00000
::   000    Elimina completamente la solicitud a partir de su numero.
::          Borra la informacion de las tablas involucradas.
::
::          $idSesion         Identificador de sesion
;;          $idSolicitud      Numero de la Transaccion
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion      = $_GET['idSesion'];
$idSolicitud   = $_POST['id'];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener estado de la transaccion
$db  = dbConnect("resint");
$qs  = "SELECT idestado from transaccion WHERE idtransaccion=$idSolicitud";
$rs  = $db->query($qs);
$row = $rs->fetchObject();
$idEstado = $row->idestado;

// Si no es borrador
if ( $idEstado != ETR_BORRADOR )
{
	echo("{errors:['" . MSG_NO_BORRADOR . "']}");
	exit;
}


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::         LIMPIADO DE LAS TABLAS         ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */


// Iniciar la Transaccion
$db = dbConnect("resint");
$db->beginTransaction();

// Borramos los articulosIn
$qs = "DELETE FROM transaccionarticulo WHERE idtransaccion='$idSolicitud'";
$db->exec($qs);

// Borramos el seguimiento
$qs = "DELETE FROM seguimiento WHERE idtransaccion='$idSolicitud'";
$db->exec($qs);

// Borramos la transaccion
$qs = "DELETE FROM transaccion WHERE idtransaccion='$idSolicitud'";
$db->exec($qs);

// Finalizar Transaccion
$db->commit();


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::               DIAGNOSTICO              ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Devolver el resultado
echo("{success:['true']}");

?>
