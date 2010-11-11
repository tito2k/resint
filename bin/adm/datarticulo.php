<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    
    require_once ("../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM articulo";
    $sql_data = "SELECT a.idarticulo, a.nombre, f.nombre AS idfamilia, stock, stockminimo, 
                m.nombre as idmagnitud,concat('idarticulo=',a.idarticulo) AS id 
                FROM articulo a
                LEFT JOIN magnitud m ON m.idmagnitud = a.idmagnitud 
				LEFT JOIN familia f ON f.idfamilia = a.idfamilia ";

    $generica = new Generica();
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
