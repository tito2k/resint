<?php



	$fileContainer = "resource.txt";

	$filePointer = fopen($fileContainer, "a+");

   $logMsg = print_r($_POST, true) . "\n";

   fputs($filePointer, $logMsg);

   fclose($filePointer);


?>