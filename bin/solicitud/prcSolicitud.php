<?php
	$fileContainer = "resource.txt";
	$filePointer = fopen($fileContainer, "w+");
   $logMsg = print_r($_REQUEST, true) . "\n";
   fputs($filePointer, $logMsg);
   fclose($filePointer);
?>