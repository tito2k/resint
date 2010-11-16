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
$sql_count .= " AND (idestado = ".ETR_AUTORIZADA." OR idestado = ".ETR_ENTREGA_PARCIAL.") ";

$qs  = "SELECT au.idarticulo,a.nombre, ";
$qs .= "au.cantidad,ifnull(en.cantidad,0) AS entregado,au.cantidad - ifnull(en.cantidad,0) AS entregar, ";
$qs .= "concat('idtransaccion=',au.idtransaccion,' AND idarticulo=',au.idarticulo) AS id ";
$qs .= "FROM transaccionarticulo au ";
$qs .= "LEFT JOIN (SELECT idtransaccion, idarticulo, SUM(cantidad) AS cantidad ";
$qs .= "FROM transaccionarticulo ";
$qs .= "WHERE idestado = " . ETR_ENTREGA_PARCIAL;
$qs .= 	" GROUP BY idarticulo) en ON au.idtransaccion = en.idtransaccion ";
$qs .= " AND au.idarticulo = en.idarticulo ";
$qs .= " INNER JOIN articulo a ON a.idarticulo = au.idarticulo ";
$qs .= "WHERE au.idtransaccion = " . $idSolicitud;
$qs .= " AND au.idestado = " . ETR_AUTORIZADA;

wlog($qs);
$generica = new Generica();
echo $generica->select($sql_count,$qs,'json');
$generica = null;

//echo '{"page":1,"total":1,"records":"3","rows":[{"id":"idtransaccion=1 AND idarticulo=3","cell":["3","Artefactos de Tubo de 1x20","30","30","S","idtransaccion=1 AND idarticulo=3"]},{"id":"idtransaccion=1 AND idarticulo=2","cell":["2","Artefactos de Tubo de 1x40","20","20","S","idtransaccion=1 AND idarticulo=2"]},{"id":"idtransaccion=1 AND idarticulo=1","cell":["1","Artefactos de tubo de 2x40","10","10","S","idtransaccion=1 AND idarticulo=1"]}]}';


?>
