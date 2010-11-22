<?php

/*

  :::::
::::
::    *     Numero de Solicitud
::   ***
::  *****   Da formato de presentacion ###/AAAA al numero de solicitud.
::::        nroSolicitud( N )
  :::::

*/
function nroSolicitud($idSolicitud)
{
   $anio = floor($idSolicitud / 10000);
   $numero = $idSolicitud - ($anio * 10000);
   $nroSolicitud = sprintf("%d/%d",$numero,$anio);

   return ( $nroSolicitud );
}

?>
