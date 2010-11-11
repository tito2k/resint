<?php

/*

  :::::
::::
::    *     Iniciar Sesion
::   ***
::  *****   Recibe usuario y clave e inicia una sesion.
::::        iniciarSesion( S, S )
  :::::

*/
function iniciarSesion($usuario,$clave)
{
   $db = dbConnect("talos");
   $rs = $db->query( "CALL talos.iniciarSesion('$usuario','$clave')" );
   $row = $rs->fetchObject();

   return ( $row->idsesion );
}


/*

  :::::
::::
::    *     Terminar Sesion
::   ***
::  *****   Recibe el idSesion y llama al SP correspondiente.
::::        terminarSesion( S )
  :::::

*/
function terminarSesion($idSesion)
{
   $db = dbConnect("talos");
   $rs = $db->query( "CALL talos.terminarSesion('$idSesion')" );
}

/*

  :::::
::::
::    *     Sesion Valida
::   ***
::  *****   Recibe una idSesion y verifica que sea valida
::::        sesionValida( S )
  :::::

*/
function sesionValida($idSesion)
{
   $db = dbConnect("talos");
   $rs = $db->query( "CALL talos.sesionValida('$idSesion')" );
   $row = $rs->fetchObject();

   return ( $row->esValida );
}


/*

  :::::
::::
::    *     Datos del Usuario
::   ***
::  *****   Recibe una idSesion y devuelve los datos del usuario
::::        datosUsuario( S )
  :::::

*/
function datosUsuario($idSesion)
{
   $db = dbConnect("talos");
   $rs = $db->query( "CALL talos.datosUsuario('$idSesion','APLICACION')" );
   $row = $rs->fetchObject();

   $datosUsuario['idUsuario']   = $row->idUsuario;
   $datosUsuario['Nombre']      = $row->Nombre;
   $datosUsuario['idNivel']     = $row->idNivel;
   $datosUsuario['nivelAcceso'] = $row->nivelAcceso;
   $datosUsuario['horaInicio']  = $row->horaInicio;
   $datosUsuario['idSeccion']   = $row->idSeccion;
   $datosUsuario['descSeccion'] = $row->descSeccion;

   return ( $datosUsuario );
}


/*

  :::::
::::
::    *     Cambiar Clave
::   ***
::  *****   Cambia la clave del usuario en la base de datos.
::::        cambiarClave( S, S, S )
  :::::

*/
function cambiarClave($idSesion, $claveActual, $claveNueva)
{
   $db = dbConnect("talos");
   $rs = $db->query( "CALL talos.cambiarClave('$idSesion','$claveActual','$claveNueva')" );
   $row = $rs->fetchObject();

   return ( $row->cambioClave );
}


/*

  :::::
::::
::  ***     <li> Menu
::  *****
::  ***     Clase que encapsula la construccion del menu HTML basado en <li>s
::          Recibe como unico parametro el idSesion del usuario, toma las
::          tareas del mismo de la base de datos y construye el menu HTML.
::
::          Ademas de los metodos internos provee el metodo display() para
::          enviar el menu a la salida estandar.
::
::          $menu = new liMenu( S );                  // Constructor
::          $menu->display();                         // Despliega
::::
  :::::

*/
class liMenu
{

// El menu y las opciones
var $menu = "";
var $opciones = array();

   /*

     :::::
   ::::
   ::    *     Constructor
   ::   ***
   ::  *****   Carga las tareas a partir del idNivel y genera el menu.
   ::::        new liMenu( N )
     :::::

   */
   function liMenu($idNivel)
   {
      // Obtener menu de la base de datos
      $db = dbConnect("resint");
      $rs = $db->query( "CALL resint.menuNivel('$idNivel')" );
      foreach ( $rs as $row )
      {
         array_push($this->opciones,$row);
      }

      // Generah <li></li>s HTML para el menu
      $this->menu .= '<ul class="jd_menu jd_menu_slate">' . "\n";
      $this->procesarHijos(1);
      $this->menu .= '</ul>' . "\n";
   }


   /*

     :::::
   ::::
   ::    *     Filtrar Hijos
   ::   ***
   ::  *****   Filtra las opciones de un "nivel padre" dado y las retorna.
   ::::        filtrarHijos( S )
     :::::

   */
   function filtrarHijos($nivel)
   {
      foreach ( $this->opciones as $opc )
      {
         if ( $opc["padre"] == $nivel )
         {
            $hijos[] = $opc;
         }
      }

      return ( $hijos );
   }


   /*

     :::::
   ::::
   ::    *     Encontrar Hijos
   ::   ***
   ::  *****   Determina si existen hijos de un nivel dado con True o False.
   ::::        encontrarHijos( S )
     :::::

   */
   function encontrarHijos($padre)
   {
      $hayHijos = False;

      foreach ( $this->opciones as $opc )
      {
         if ( $opc["padre"] == $padre )
         {
            $hayHijos = True;
         }
      }

      return ( $hayHijos );
   }


   /*

     :::::
   ::::
   ::   ***    Procesar Hijos
   ::  *****
   ::   ***    Procesa las opciones de un nivel dado.
   ::::        procesarHijos( S )
     :::::

   */
   function procesarHijos($nivel)
   {
      // Tomar todos los hijos de $nivel
      $hijos = $this->filtrarHijos($nivel);

      // Procesar cada hijo
      foreach ( $hijos as $opc )
      {
         $tarea = $opc["idtarea"];

         // Si hay hijos de esta opcion, se procesan
         if ( $this->encontrarHijos($tarea) )
         {
	        $this->menu .= '<li><a class="accessible" href="#" tarea="' . $opc["idtarea"] .  '">' . utf8_encode($opc["descripcion"]) . '</a>' . "\n";
            $this->menu .= '<ul>' . "\n";
            $this->procesarHijos($tarea);
            $this->menu .= '</ul>' . "\n";
         }
         else
         {
	        $this->menu .= '<li><a class="menu" href="javascript:' . $opc["url"] . ';" tarea="' . $opc["idtarea"] .  '">' . utf8_encode($opc["descripcion"]) . '</a>' . "\n";
		 }

         $this->menu .= '</li>' . "\n";
      }
   }


   /*

     :::::
   ::::
   ::   ***    Desplegar menu
   ::  *****
   ::   ***    Despliega en la salida estandar el menu generado.
   ::::        display()
     :::::

   */
   function display()
   {
      echo $this->menu;
   }

}

?>
