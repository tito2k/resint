<?php

/*

  :::::
::::
::  000     Incluciones y definiciones.
::  00000
::  000     Funciones requeridas y variables globales necesarias.
::::
  :::::

*/

// Nivel del reporte de errores
// error_reporting(0);

// Identificacion de la aplicacion
define("APLICACION","RESINT");

// SIGNALS de diagnostico para javaScript
define("TAREA_OK","TAREA_OK");              // Diagnostico generico
define("TAREA_ERROR","TAREA_ERROR");
define("SESION_OK","SESION_OK");            // La sesion del usuario
define("SESION_ERROR","SESION_ERROR");
define("CAMBIO_OK","CAMBIO_OK");            // El cambio de clave del usario
define("CAMBIO_ERROR","CAMBIO_ERROR");

// Mensajes de diagnostico
define("MSG_CLAVE_NO_VERIFICA","Error al verificar.");
define("MSG_CAMBIO_OK","Se realizó el cambio");
define("MSG_CAMBIO_ERROR","La clave actual es incorrecta.");
define("MSG_NRO_SOLICITUD","SE HA CREADO LA SOLICITUD NUMERO: ");
define("MSG_ERROR_SOLICITUD","NO SE PUDO CREAR LA SOLICITUD");
define("MSG_MODIFICADA","SE HA MODIFICADO LA SOLICITUD NUMERO: ");
define("MSG_RATIFICADA","SE HA RATIFICADO LA SOLICITUD NUMERO: ");
define("MSG_AUTORIZADA","SE HA AUTORIZADO LA SOLICITUD NUMERO: ");
define("MSG_ENTREGA","SE HA REALIZADO UNA ENTREGA A LA SOLICITUD NUMERO: ");
define("MSG_NO_DOCUMENTO","Documento Inexistente");
define("MSG_NO_MATRICULA","Matr&iacute;cula Inexistente");
define("MSG_DISTINTAS_ALMACENES","HAY ARTICULOS DE DISTINTAS ALMACENES");

// Tipos de Seccion
define("SEC_ALMACEN",1);
define("SEC_CONSUMIDOR",2);

// Niveles de Acceso
define("NA_INVITADO",10);
define("NA_OPERADOR_UNIDAD",20);
define("NA_OPERADOR_ALMACEN",30);
define("NA_ENCARGADO",40);
define("NA_SUPERVISOR",50);
define("NA_GERENTE",60);
define("NA_ADMIN",100);

// Tipos de Transacciones
define("TRS_SOLICITUD",1);
define("TRS_COMPRA",2);
define("TRS_PRODUCCION",3);
define("TRS_DONACION_RECIBIDA",4);
define("TRS_DONACION_HECHA",5);
define("TRS_PREDIDA",6);
define("TRS_MERMA",7);

// Estado de la Transaccion
define("ETR_BORRADOR",1);
define("ETR_RATIFICADA",2);
define("ETR_AUTORIZADA",3);
define("ETR_DENEGADA",4);
define("ETR_ENTREGA_PARCIAL",5);
define("ETR_ENTREGA_TOTAL",6);

// Las Bibliotecas y Funciones son incluidas solo desde aca
// de modo que ellas no deban incluirse ni incluir globales.php.
// Solo los modulos operativos incluyen globales y con ello todo lo demas.
require_once("../../lib/template.php");
require_once("../../lib/database.php");
require_once("../../lib/sesion.php");
require_once("../../lib/titulo.php");
require_once("../../lib/formato.php");
require_once("../../lib/autocompletar.php");
require_once("../../lib/log.php");

?>
