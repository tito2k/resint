<?php


    /*//LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);*/


    require_once ("../../lib/generica.class.php");


    $sql_count = "SELECT COUNT(*) AS count FROM usuario;";

    $sql_data = "SELECT idusuario,nombres,apellidos,documento,clave,
    			s.descripcion AS idseccion
                ,concat('idusuario=',char(39),u.idusuario,char(39)) AS id 
                FROM usuario u
                INNER JOIN seccion s ON s.idseccion = u.idseccion ";


    //LOG
    /*$fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = $sql_data . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);*/



    $generica = new Generica('talos');
    echo $generica->select($sql_count,$sql_data);
    $generica = null;


?>
