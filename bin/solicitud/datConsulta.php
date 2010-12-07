<?php


    /*// LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);*/
    

// Bibliotecas y Globales
require_once("../../etc/globales.php");
require_once ("../../lib/generica.class.php");

// Recuperar los datos
$idSesion = $_GET['idSesion'];
$idSolicitud = $_GET['idSolicitud'];

// De no haber sesion, adios ...
if ( !sesionValida($idSesion) ) return;

// Obtener datos del Usuario
$datosUsuario = datosUsuario($idSesion);

// Obtener las Secciones que puede representar este usuario
$sql_count  = "SELECT COUNT(*) AS count FROM transaccionarticulo ";
$sql_count .= "WHERE idtransaccion = " . $idSolicitud;

$qs = "SELECT au.idarticulo,a.nombre,";
$qs .= " au.cantidad, au.idestado, e.descripcion,date_format(au.fecha,'%d/%m/%Y') as fecha,";
$qs .= " uuid() AS id";
$qs .= " FROM transaccionarticulo au ";
$qs .= " INNER JOIN articulo a ON a.idarticulo = au.idarticulo";
$qs .= " INNER JOIN estadotransaccion e ON e.idestado = au.idestado"; 
$qs .= " WHERE au.idtransaccion = " . $idSolicitud;
//$qs .= " ORDER BY au.idestado,au.idarticulo";

wlog($qs);
$generica = new Generica();
echo $generica->select($sql_count,$qs,'json');
$generica = null;

//echo '{"page":1,"total":1,"records":"3","rows":[{"id":"idtransaccion=1 AND idarticulo=3","cell":["3","Artefactos de Tubo de 1x20","30","30","S","idtransaccion=1 AND idarticulo=3"]},{"id":"idtransaccion=1 AND idarticulo=2","cell":["2","Artefactos de Tubo de 1x40","20","20","S","idtransaccion=1 AND idarticulo=2"]},{"id":"idtransaccion=1 AND idarticulo=1","cell":["1","Artefactos de tubo de 2x40","10","10","S","idtransaccion=1 AND idarticulo=1"]}]}';


?>
