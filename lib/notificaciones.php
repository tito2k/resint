<?php

/*

  :::::
::::
::    *     Obtener Notificaciones
::   ***
::  *****   Construye el arreglo con notificaciones de diversa indole.
::::        getNotificaciones()
  :::::

*/
function getNotificaciones()
{
   $arrNotificacion = array();

   // Stocks en minimo
   $db = dbConnect("resint");
   $rs = $db->query( "SELECT Count(*) AS HayMinimos FROM articulo WHERE stock <= stockminimo" );
   $row = $rs->fetchObject();
   if (  $row->HayMinimos )
      array_push($arrNotificacion,sprintf("Existen %d art&iacute;culos con stock m&iacute;nimo",$row->HayMinimos));

   return ( $arrNotificacion );
}

?>
