<?php

/*

  :::::
::::
::    *     dbConnect
::   ***
::  *****   Establece la conexion PDO con mySQL y devuelve el objeto.
::::        dbConnect( S )
  :::::

*/
function dbConnect($db_base)
{
   $db = new PDO("mysql:dbname=$db_base;host=127.0.0.1", "root", "");
   return ( $db );
}

?>
