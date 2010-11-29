<?php

    /*
    $fileContainer = "resource.txt";
    $filePointer = fopen($fileContainer, "a+");
    $logMsg = print_r($_POST, true) . "\n";
    fputs($filePointer, $logMsg);
    fclose($filePointer);
    */

    require_once (SITE_ROOT . "/lib/generica.class.php");

    $generica = new Generica();
    echo $generica->execute(); // ATENCI�N: No sabemos como capturar el resultado en la interfase
    $generica = null;


?>
