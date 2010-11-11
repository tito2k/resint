<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    
	require_once ("../../lib/generica.class.php");
	
    $sql_count = "SELECT COUNT(*) AS count FROM proveedor";
    $sql_data = "SELECT idproveedor, nombre, direccion, telefono, 
					mail, contacto, concat('idproveedor=',idproveedor) AS id 
                FROM proveedor ";

    $generica = new Generica('resint');
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
