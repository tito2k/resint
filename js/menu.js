function proveedores()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntproveedor.php');
		$('#bottomright').empty();		
	}
}

function secciones()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntseccion.php');
		$('#bottomright').empty();		
	}
	
}

function sectores()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntsector.php');
		$('#bottomright').empty();		
	}
}

function articulos()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntarticulo.php',{idSesion:idSesion});
		$('#bottomright').empty();		
	}
}

function familias()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntfamilia.php');
		$('#bottomright').empty();		
	}
}

function tareanivel()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pnttareanivel.php');
		$('#bottomright').empty();		
	}
}
function tareas()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pnttarea.php');
		$('#bottomright').empty();		
	}
}

function usuarios()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntusuario.php');
		$('#bottomright').empty();		
	}
}

function usuarioaplicacion()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/usuarioaplicacion.php');
		$('#bottomright').empty();		
	}
}

function usuarioseccion()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntusuarioseccion.php');
		$('#bottomright').empty();		
	}
}

function usuarioalmacen()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/adm/pntusuarioalmacen.php');
		$('#bottomright').empty();		
	}
}


function nuevaSolicitud(idTarea)
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntNueva.php',{idSesion:idSesion});
		$('#bottomright').load('../../bin/solicitud/pntBotonesFormulario.html');		
	}
}

function ratificaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntRatifica.php',{idSesion:idSesion,idSolicitud:idSol});
		$('#bottomright').load('../../bin/solicitud/pntBotonesFormulario.html');		
	}
}

function autorizaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntAutoriza.php',{idSesion:idSesion,idSolicitud:idSol});
		$('#bottomright').load('../../bin/solicitud/pntBotonesFormulario.html');		
	}
}

function entregaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntEntrega.php',{idSesion:idSesion,idSolicitud:idSol});
		$('#bottomright').load('../../bin/solicitud/pntBotonesFormulario.html');		
	}
}

function consultaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntConsulta.php',{idSesion:idSesion,idSolicitud:idSol});
		$('#bottomright').load('../../bin/solicitud/pntBotonesConsulta.html');		
	}
}

function modificaSolicitud(idSol,idTarea)
{
	if (sesionValida())
	{	
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntModifica.php',{idSesion:idSesion,idSolicitud:idSol});
		$('#bottomright').load('../../bin/solicitud/pntBotonesFormulario.html');		
	}
}

function bandejaSalida()
{
	if (sesionValida())
	{	
		bandejaActiva = 'SALIDA';
		$('#diagramaEstado').empty();		
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntBandejaSalida.php',{idSesion:idSesion});
		$('#bottomright').load('../../bin/solicitud/pntBotonesBandeja.html');		
	}
}

function bandejaEntrada()
{
	if (sesionValida())
	{	
		bandejaActiva = 'ENTRADA';
		$('#diagramaEstado').empty();		
		$('#notificacion').load('../../bin/frontend/getAvisoNotificacion.php',{idSesion:idSesion});
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/solicitud/pntBandejaEntrada.php',{idSesion:idSesion});
		$('#bottomright').load('../../bin/solicitud/pntBotonesBandeja.html');		
	}
	
}

function cargarBandejaActiva()
{
	$('#topleft').empty();
	$('#diagramaEstado').empty();
	$('#notificacion').empty();		
	$('#center').empty();
	$('#bottomright').empty();
	
	if (bandejaActiva == 'ENTRADA')
	{
		idTarea = IDT_BANDEJA_ENTRADA;
		bandejaEntrada();
	}
	else
	{
		idTarea = IDT_BANDEJA_SALIDA;
		bandejaSalida();
	}
}

function cambiarClave()
{
	if (sesionValida())
	{	
		$('#diagramaEstado').empty();
		$('#notificacion').empty();		
		$('#topleft').load('../../bin/frontend/getTitulo.php',{idSesion:idSesion,idTarea:idTarea});
		$('#center').load('../../bin/usuario/pntCambiarClave.html');
		$('#bottomright').empty();
	}

}
