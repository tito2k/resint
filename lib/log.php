<?php

/*=============================================================================*
*                                                                              *
*    Sistema  		:  serv222                                                   *
*                                                                              *
* 	  Módulo			:  Log                                                       *
*                                                                              *
*    Descripción  :  Genera archivo de log.                                    *
*                                                                              *
*           Graba en log.txt el resultado de las funciones wlor y plog.        *
*                                                                              *
*                                                                              *
*    Fecha  		: Octubre de 2010.                                           *
*                                                                              *
*=============================================================================*/


function wlog($text)
{

	$fileContainer = "../../log/log.txt";
	$filePointer = fopen($fileContainer, "a+");
	$logMsg = $text . "\n";
	fputs($filePointer, $logMsg);
	fclose($filePointer);
	return;
	
}

function plog()
{

    $fileContainer = "../../log/log.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_POST, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
}


function alog($arr)
{

    $fileContainer = "../../log/log.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($arr, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
}


?>
