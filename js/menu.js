function proveedores()
{
  $('#center').load('../../bin/adm/pntproveedor.php');
}

function secciones()
{
  $('#center').load('../../bin/adm/pntseccion.php');
}

function sectores()
{
  $('#center').load('../../bin/adm/pntsector.php');
}

function articulos()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntarticulo.php',{idSesion:idSesion});
	}
}

function familias()
{
  $('#center').load('../../bin/adm/pntfamilia.php');
}

function tareanivel()
{
  $('#center').load('../../bin/adm/pnttareanivel.php');
}
function tareas()
{
  $('#center').load('../../bin/adm/pnttarea.php');
}

function usuarios()
{
  $('#center').load('../../bin/adm/pntusuario.php');
}

function usuarioaplicacion()
{
  $('#center').load('../../bin/adm/usuarioaplicacion.php');
}

function usuarioseccion()
{
  $('#center').load('../../bin/adm/pntusuarioseccion.php');
}

function usuarioalmacen()
{
  $('#center').load('../../bin/adm/pntusuarioalmacen.php');
}


function nuevaSolicitud()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntNueva.php',{idSesion:idSesion});
	}
}

function ratificaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntRatifica.php',{idSesion:idSesion,idSolicitud:idSol});
	}
}

function autorizaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntAutoriza.php',{idSesion:idSesion,idSolicitud:idSol});
	}
}

function entregaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntEntrega.php',{idSesion:idSesion,idSolicitud:idSol});
	}
}

function editaSolicitud()
{
  $('#center').load('../../bin/solicitud/editsolicitud.html');
}

function bandejaSalida()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntBandejaSalida.php',{idSesion:idSesion});
	}
}

function bandejaEntrada()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntBandejaEntrada.php',{idSesion:idSesion});
	}
	
}


function cambiarClave()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
  	$('#center').load('../../bin/usuario/pntCambiarClave.html');
	}

}
