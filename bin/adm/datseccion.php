<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    

	require_once ("../../lib/generica.class.php");
	
    $sql_count = "SELECT COUNT(*) AS count FROM seccion";
    $sql_data = "SELECT idseccion, descripcion, concat('idseccion=',idseccion) AS id 
                FROM seccion ";

    $generica = new Generica();
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
