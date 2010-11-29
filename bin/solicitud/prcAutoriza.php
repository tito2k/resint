<?php

/*

  :::::
::::
::   000    Autoriza Solicitud
::  00000
::   000    Autoriza la solicitud a partir de los datos del formulario.
::          grabando el seguimiento y los articulos recibidos.
::
::          $idSesion         Identificador de sesion
::          $idSolicitud      Numero de la Transaccion
::          $datos            Articulos autorizados {id:valor,cant:valor}, ...
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
$idSolicitud   = $_POST['idSolicitud'];
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
$articulos = json_decode(stripcslashes($datos));

// Obtener los datos del Usuario
$datosUsuario = datosUsuario($idSesion);
$idUsuario   = $datosUsuario['idUsuario'];
$nivelAcceso = $datosUsuario['idNivel'];

// El tipo de Transaccion
$tipo = TRS_SOLICITUD;

// El estado depende de que haya al menos un articulo autorizado
$estado = ETR_DENEGADA;
foreach ( $articulos as $renglon )
   if ($renglon->autoriza == 'SI')
      $estado = ETR_AUTORIZADA;


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
   if ($renglon->autoriza == 'SI')
   {
      $qs = "INSERT INTO transaccionarticulo
           VALUES (sysdate(),'$idSolicitud',$estado,$renglon->idarticulo,$renglon->aprueba)";
      $db->exec($qs);
   }
}

// Finalizar Transaccion
$db->commit();


          /*     ::::::::::::::::::::::::::::::::::::::::
               ::::                                    ::::
             ::::               DIAGNOSTICO              ::::
               ::::                                    ::::
                 ::::::::::::::::::::::::::::::::::::::::     */


// Devolver el resultado
$dataSet['resultadoOperacion'] = TAREA_OK;
echo json_encode($dataSet);

?>
