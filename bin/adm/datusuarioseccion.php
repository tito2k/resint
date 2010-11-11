<?php

    /*//LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_GET, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);*/


	require_once ("../../lib/generica.class.php");
  
    $opc = $_GET["q"]; 
    if ($opc == 1) {


       
      $sql_count = "SELECT COUNT(*) AS count FROM usuario;";
  
      $sql_data = "SELECT idusuario,nombres,apellidos,idusuario AS id 
                  FROM usuario";
 
       $generica = new Generica('talos');
       $data = $generica->select($sql_count,$sql_data,'json');
       $generica = null;
    //LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = $data . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    echo $data;


   }
   else if ($opc == 2) {
      
      	$id = $_GET["id"];
		global $conn;
			 
		$sql_count = "SELECT COUNT(*) AS count FROM usuarioseccion";
		$sql_data = "SELECT '$id' AS idusuario,s.descripcion AS idseccion, (CASE WHEN us.idseccion IS NOT NULL THEN 'Si' ELSE '' END) AS existe,
					concat('idusuario=',char(39),'$id',char(39),' AND idseccion=',s.idseccion) AS id 
					FROM usuarioseccion us
					INNER JOIN seccion s ON us.idseccion = s.idseccion AND us.idusuario='$id'";
					

		$generica = new Generica();
		echo $generica->select($sql_count,$sql_data);
		$generica = null;
       
       /*
        $res = mysql_query($sql_data, $conn);
    
         if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) { 
            header("Content-type: application/xhtml+xml;charset=utf-8"); 
         } else { 
            header("Content-type: text/xml;charset=utf-8"); 
         } 
         $et = ">";
         $data = "<?xml version='1.0' encoding='utf-8'?$et\n"; 
         $data = "<?xml version='1.0'?$et\n";
         $data .= "<rows>"; // be sure to put text data in CDATA 
         
         while ($row = mysql_fetch_assoc($res)){ 
            $data .= "<row>"; 
            $data .="<cell><![CDATA[". $row[idtarea]."]]></cell>"; 
            $data .="<cell><![CDATA[". $row[descripcion]."]]></cell>"; 
            $data .="</row>"; 
         } 
         $data .="</rows>";        

    //LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = $data . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
*/

          //LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = 'Aca:'.$sql_data . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
         echo $data;


   }


    /*//LOG
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = $sql_data . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
*/


?>
