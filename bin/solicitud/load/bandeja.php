<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    
	require_once ("../../../lib/generica.class.php");

    $sql_count = "SELECT COUNT(*) AS count FROM familia";
    $sql_data = "SELECT idfamilia, nombre, concat('idfamilia=',idfamilia) AS id 
                FROM familia ";

    $generica = new Generica();
    if ($generica->_search == "false"){
        // Es un select sin filtro 
        echo $generica->select($sql_count,$sql_data);
    }
    else{
        // Es un select con filtro 
        echo $generica->search($sql_count,$sql_data);        
    }
    $generica = null;


?>
