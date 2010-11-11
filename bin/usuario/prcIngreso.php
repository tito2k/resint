<?php

/*

  :::::
::::
::   ***    Proceso Principal.
::  *****
::   ***    Toma los datos mediante POST e invoca el SP iniciarSesion()
::          y de acuerdo a su resultado da inicio a la sesion o reporta ERROR.
::
::
::          $usuario                    El idUsuario ingresado
::          $clave                      La clave del usuario ingresada
::          $idSesion                   Identificador de sesion
::          $idUsuario                  Login del Usuario
::          $horaInicio                 Hora de inicio de sesion
::          $nivelAcceso                Privilegios de acceso
::          $datosUsuario               Datos del usuario
::::
  :::::

*/

// Bibliotecas y Globales
require_once("../../etc/globales.php");

// Recuperar los datos del formulario
$usuario = $_POST["usuarioLogin"];
$clave   = $_POST["claveLogin"];

// Iniciar sesion si los datos del usuario son correctos
$idSesion = iniciarSesion($usuario,$clave);

// Si hay sesion el frontEnd de lo contrario Error
if ( $idSesion )
{
   // Los datos del Usuario
   $datosUsuario = datosUsuario($idSesion);

   // El menu del Usuario segun su nivel
   $usrMenu = new liMenu($datosUsuario["idNivel"]);

   // Desplegar
   $pntRESINT = new fxl_template("resint.html");
   $pntRESINT->assign("menuUsuario",$usrMenu->menu);
   $pntRESINT->assign("idSesion",$idSesion);
   $pntRESINT->assign("usuario",$datosUsuario['idUsuario']);
   $pntRESINT->assign("acceso",$datosUsuario['nivelAcceso']);
   $pntRESINT->assign("inicio",$datosUsuario['horaInicio']);
   $pntRESINT->display();
}
else
{
   // Error en el Ingreso
   readfile("loginerror.html");
}

?>
