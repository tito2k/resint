<?php

/*

  :::::
::::
::    *     Titulo de la Tarea
::   ***
::  *****   Lee de la db el titulo, subtitulo e icono de una tarea dado su id.
::::        getTitulo( N )
  :::::

*/
function getTitulo($idTarea)
{
   $db = dbConnect("resint");
   $rs = $db->query( "SELECT * FROM tarea WHERE idtarea=$idTarea" );
   $row = $rs->fetch(PDO::FETCH_ASSOC);

   return ( $row );
}


/*

  :::::
::::
::   ***    Genera y despliega el HTML del titulo
::  *****
::   ***    Parsea el HTML generico de titulo y lo desploiega. Recibe el objeto
::          con los datos pertinentes.
::::        putTitulo( A )
  :::::

*/
function putTitulo($row)
{
   $pntTitulo = new fxl_template("pntTitulo.html");
   $pntTitulo->assign("titulo",utf8_encode($row["titulo"]));
   $pntTitulo->assign("subtitulo",utf8_encode($row["subtitulo"]));
   $pntTitulo->assign("icono",$row["icono"]);
   $pntTitulo->display();
}

?>
