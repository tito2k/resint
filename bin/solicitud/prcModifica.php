<?php

/*

  :::::
::::
::   000    Modifica Solicitud
::  00000
::   000    Modifica la solicitud a partir de los datos del formulario.
::          grabando el seguimiento y los articulos recibidos, previa eliminación de los anteriores.
::
::          $idSesion         Identificador de sesion
;;          $idSolicitud      Numero de la Transaccion
::          $datos            Articulos ratificados {id:valor,cant:valor}, ...
::          $observaciones    Observaciones ;-)
::
::          $articulos        Arreglo de articulos como objetos.
::          $idSolicitud      Numero de Solicitud
::          $nivelAcceso      Privilegios del usuario
::          $idUsuario        Identificador del usuaro.
::          $estado           Estado de la transaccion (Ratificada)
::          $dataSet          El paquete de datos json a devolver
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion      = $_POST['idSesion'];
$idSolicitud   = $_POST['idsolicitud'];
$datos         = $_POST['datos'];
$observaciones = $_POST['observaciones'];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::          RESOLUCION DE DATOS           ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Convertir los datos a un arreglo de objetos
$articulosIn = json_decode(stripcslashes($datos));

// Agrupar los articulos por si hay mas de una linea de alguno
foreach ( $articulosIn as $unArticulo )
{
   if ( $articulos["$unArticulo->idarticulo"] )
      $articulos["$unArticulo->idarticulo"]->cantidad += $unArticulo->cantidad;
   else
      $articulos["$unArticulo->idarticulo"] = $unArticulo;
}

// Obtener los datos del Usuario
$datosUsuario = datosUsuario($idSesion);
$idUsuario   = $datosUsuario['idUsuario'];
$nivelAcceso = $datosUsuario['idNivel'];

// El tipo de Transaccion
$tipo = TRS_SOLICITUD;

// El estado queda en borrador
$estado = ETR_BORRADOR;


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::         GRABADO DE LAS TABLAS          ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Iniciar la Transaccion
$db = dbConnect("resint");
$db->beginTransaction();

// Borramos los datos actuales
$qs = "DELETE FROM transaccionarticulo WHERE idtransaccion=$idSolicitud";
$db->exec($qs);

$qs = "DELETE FROM seguimiento WHERE idtransaccion=$idSolicitud";
$db->exec($qs);

//$qs = "DELETE FROM transaccion WHERE idtransaccion=$idSolicitud";
//$db->exec($qs);

// Grabar el Seguimiento
$qs = "INSERT INTO seguimiento
       VALUES ('$idSolicitud',$estado,sysdate(),'$idUsuario')";
$db->exec($qs);

// Grabar datos del cabezal
$qs = "UPDATE transaccion
       SET idestado=$estado, fechaactual=sysdate(), observaciones='$observaciones'
       WHERE idtransaccion='$idSolicitud'";
$db->exec($qs);

// Grabar la lista de articulos
foreach ( $articulos as $renglon )
{
   $qs = "INSERT INTO transaccionarticulo
          VALUES (sysdate(),'$idSolicitud',$estado,$renglon->idarticulo,$renglon->cantidad)";

   $db->exec($qs);
}

// Finalizar Transaccion
$db->commit();


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::               DIAGNOSTICO              ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

$mensaje = sprintf("%s %s",MSG_MODIFICADA,nroSolicitud($idSolicitud));

// Devolver el resultado
$dataSet['resultadoOperacion'] = TAREA_OK;
$dataSet['mensaje'] = $mensaje;

echo json_encode($dataSet);

?>
