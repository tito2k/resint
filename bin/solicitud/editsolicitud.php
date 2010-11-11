<?php


    // LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "w+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    


    require_once ("../../lib/generica.class.php");
    
    
    $idsolicitud = $_GET["idsolicitud"];
	$idestado = $_GET["idestado"];
	
    $sql_count = "SELECT COUNT(*) AS count FROM transaccionarticulo WHERE idtransaccion=$idsolicitud;";
    $sql_data = "SELECT ta.idarticulo, a.nombre, ta.cantidad ,ta.idarticulo AS id 
                FROM transaccionarticulo ta
                INNER JOIN articulo a ON a.idarticulo = ta.idarticulo
                WHERE ta.idtransaccion=$idsolicitud
                AND ta.idestado=$idestado";

    $generica = new Generica();
    $retorno = $generica->select($sql_count,$sql_data,'json');
    die($retorno);
    echo $generica->select($sql_count,$sql_data,'json');
    $generica = null;

	$fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "w+");
    fputs($filePointer, $sql_data);
    fclose($filePointer);
    
    
//echo '{"page":1,"total":3,"records":"3","rows":[{"id":"3","cell":["3","Artefactos de Tubo de 1x20","30","3"]},{"id":"2","cell":["2","Artefactos de Tubo de 1x40","20","2"]},{"id":"1","cell":["1","Artefactos de tubo de 2x40","10","1"]}]}'    
    
?>
