function proveedores()
{
  $('#center').load('http://localhost/resint/bin/adm/pntproveedor.php');
}

function secciones()
{
  $('#center').load('http://localhost/resint/bin/adm/pntseccion.php');
}

function sectores()
{
  $('#center').load('http://localhost/resint/bin/adm/pntsector.php');
}

function articulos()
{
  $('#center').load('http://localhost/resint/bin/adm/pntarticulo.php');
}

function familias()
{
  $('#center').load('http://localhost/resint/bin/adm/pntfamilia.php');
}

function tareanivel()
{
  $('#center').load('http://localhost/resint/bin/adm/pnttareanivel.php');
}
function tareas()
{
  $('#center').load('http://localhost/resint/bin/adm/pnttarea.php');
}

function usuarios()
{
  $('#center').load('http://localhost/resint/bin/adm/pntusuario.php');
}

function usuarioaplicacion()
{
  $('#center').load('http://localhost/resint/bin/adm/usuarioaplicacion.php');
}

function usuarioseccion()
{
  $('#center').load('http://localhost/resint/bin/adm/usuarioseccion.php');
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
  $('#center').load('http://localhost/resint/bin/solicitud/editsolicitud.html');
}

function bandejaSalida()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('http://localhost/resint/bin/solicitud/pntBandejaSalida.php',{idSesion:idSesion});
	}
}

function bandejaEntrada()
{
	if (sesionValida())
	{	
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('http://localhost/resint/bin/solicitud/pntBandejaEntrada.php',{idSesion:idSesion});
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
