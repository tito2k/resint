<?php

/*

  :::::
::::
::   000    Entrega Solicitud
::  00000
::   000    Registra la entrga de articulos  a partir de los datos del
::          formulario. grabando el seguimiento y las cantidades.
::          Una vez grabados los datos verifica si la suma de las cantidades
::          entregadas es menor a las cantidades autorizadas, en ese caso sigue
::          en estado ENTREGA_PARCIAL; de lo contrario pasa a ENTREGA_TOTAL.
::
::          $idSesion         Identificador de sesion
;;          $idSolicitud      Numero de la Transaccion
::          $datos            Articulos autorizados {id:valor,cant:valor}, ...
::          $observaciones    Observaciones ;-)
::
::          $articulos        Arreglo de articulos como objetos.
::          $idSolicitud      Numero de Solicitud
::          $nivelAcceso      Privilegios del usuario
::          $idUsuario        Identificador del usuaro.
::          $estado           Estado de la transaccion (Ratificada)
::          $paraEntregar     Arreglo cuyo indice es el idArticulo de los
::                            autorizados para entrega y su valor es la
::                            cantidad que falta por entregar
::          $faltaEntregar    Cantidad por entregar
::          $solTerminada     Bandera en True si todo fue entregado
::          $dataSet          El paquete de datos json a devolver
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos
$idSesion      = $_POST['idSesion'];
$idSolicitud   = $_POST['idSolicitud'];
$datos         = $_POST['datos'];
$observaciones = $_POST['observaciones'];


// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Si el nivelAcceso es inadecuado, sorry ...
$datosUsuario = datosUsuario($idSesion);
if ( $datosUsuario['idNivel'] < NA_OPERADOR_ALMACEN ) return;


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::          RESOLUCION DE DATOS           ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */


// Convertir los datos a un arreglo de objetos
$articulos = json_decode(stripcslashes($datos));

// Obtener los datos del Usuario
$idUsuario   = $datosUsuario['idUsuario'];
$nivelAcceso = $datosUsuario['idNivel'];

// El tipo de Transaccion
$tipo = TRS_SOLICITUD;

// El estado
$estado = ETR_ENTREGA_PARCIAL;


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
   if ( $renglon->entrega )
   {
      $qs = "INSERT INTO transaccionarticulo
             VALUES (sysdate(),'$idSolicitud',$estado,$renglon->idarticulo,$renglon->entrega)";
      $db->exec($qs);

      // Debita el Stock
      $qs = "UPDATE articulo SET stock = stock - $renglon->entrega
             WHERE idarticulo = $renglon->idarticulo";
      $db->exec($qs);
   }
}

// Finalizar Transaccion
$db->commit();


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::   VERIFICA SI SE COMPLETO LA ENTREGA   ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */

// Cantidades autorizadas para Entregar
$qs = "SELECT idarticulo, cantidad FROM transaccionarticulo
       WHERE idtransaccion=$idSolicitud AND idestado=" . ETR_AUTORIZADA;
foreach ( $db->query($qs) as $row)
{
   $paraEntregar[$row["idarticulo"]] = $row["cantidad"];
}

// Se restan las cantidades entregadas
$qs = "SELECT idarticulo, cantidad FROM transaccionarticulo
       WHERE idtransaccion=$idSolicitud AND idestado=" . ETR_ENTREGA_PARCIAL;
foreach ( $db->query($qs) as $row)
{
   $paraEntregar[$row["idarticulo"]] -= $row["cantidad"];
}

// Queda algo por entregar ?
$solTerminada = True;
foreach ( $paraEntregar as $faltaEntregar )
{
   if ( $faltaEntregar ) $solTerminada = False;
}

// Si se completo ...
if ( $solTerminada )
{
   // Iniciar la Transaccion
   $db->beginTransaction();

   // El estado depende del nivel del operador
   $estado = ETR_ENTREGA_TOTAL;

   // Grabar datos del cabezal
   $qs = "UPDATE transaccion
          SET idestado=$estado, fechaactual=sysdate()
          WHERE idtransaccion='$idSolicitud'";
   $db->exec($qs);
   
   // Finalizar Transaccion
   $db->commit();
}


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::               DIAGNOSTICO              ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */


$msg = sprintf("%s %s",MSG_ENTREGA,nroSolicitud($idSolicitud));

// Devolver el resultado
$dataSet['resultadoOperacion'] = TAREA_OK;
$dataSet['mensaje'] = $msg;

echo json_encode($dataSet);

?>
