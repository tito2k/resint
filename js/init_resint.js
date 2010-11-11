$(document).ready(function() {
	// GLOBALES
	var idTarea = "";
	var idSesion = "";

	$.getScript('../../js/funciones.js');
	$.getScript('../../js/menu.js');
	$.ajaxSetup({ cache: false });
	$('.menu').click(ejecutarOpcion);
	$('#logoff').click(terminarSesion);
	$('#logoff').focus(pruebaFoco);
	
//	$('ul.jd_menu').jdMenu();	
});
/*
function cargaScript(data)
{
	var script = document.createElement("script"); 
	script.setAttribute('type','text/javascript'); 
	script.setAttribute('src',$('#js').val()); 
	document.body.appendChild(script);
};
*/

function pruebaFoco()
{

}

function terminarSesion()
{
	$('#logoff').load('prcTerminarSesion.php',{idSesion:$('#idSesion').val()});
	window.location = 'http://localhost/resint/index.html';
};

function ejecutarOpcion()
{
	idTarea = this.getAttribute('tarea');
	idSesion = $('#idSesion').val();
};
