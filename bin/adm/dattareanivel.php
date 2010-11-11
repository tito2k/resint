<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    

	require_once ("../../lib/generica.class.php");
	
    $sql_count = "SELECT COUNT(*) AS count FROM tareanivel";
    $sql_data = "SELECT t.descripcion AS idtarea, n.descripcion AS idnivel,
					concat('idtarea=',tn.idtarea,' AND idnivel=',tn.idnivel) AS id 
                FROM tareanivel tn
				INNER JOIN tarea t ON t.idtarea = tn.idtarea
				INNER JOIN talos.nivel n ON n.idnivel = tn.idnivel ";

    $generica = new Generica();
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
