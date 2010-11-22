<?php

/*

  :::::
::::
::    *     autocompletar
::   ***
::  *****   Busca en la base de datos en la codiguera indicada las tuplas que
::          contengan la secuencia de caracteres indicados y devuelve un grupo
::          de lineas (cuyo numero esta dado por $tuplas), para ser presentadas
::          en la persiana del autocomplete.
::          autocompletar( S, S, S, S, S, S )
::
::          $tabla            Tabla en la cual buscar
::          $buscarPor        Campo por el cual buscar ['clave'|'descripcion']
::          $campoClave       Nombre del campo clave
::          $campoDesc        Nombre del campo descripcion
::          $valor            Valor ingresado por el usuario
::          $filtro           Filtro adicional sobre la tabla
::::
  :::::

*/
function autocompletar($colClave,$colDesc,$colBuscar,$tabla,$valor,$filtro)
{
// Cuantas tupla devolver
$tuplas = 10;

   $db = dbConnect("resint");
   $rs = $db->query("SELECT $colClave, $colDesc FROM $tabla WHERE $colBuscar REGEXP '$valor' $filtro ORDER BY $colBuscar LIMIT $tuplas");
   $row = $rs->fetchAll(PDO::FETCH_ASSOC);

   return ( $row );
}

?>
