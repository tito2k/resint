<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    
	require_once ("../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM sector";
    $sql_data = "SELECT c.idsector, c.descripcion, s.descripcion AS seccion, 
					concat('idsector=',idsector) AS id 
                FROM sector c
				INNER JOIN seccion s ON s.idseccion = c.idseccion";

    $generica = new Generica();
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
