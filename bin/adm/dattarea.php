<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    

	require_once ("../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM tarea";
    $sql_data = "SELECT t.idtarea, t.descripcion, t.url, p.descripcion AS padre, t.secuencia, 
                t.titulo, t.subtitulo, t.icono ,concat('idtarea=',t.idtarea) AS id 
                FROM tarea t
                INNER JOIN tarea p ON p.idtarea = t.padre ";

    $generica = new Generica();
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
