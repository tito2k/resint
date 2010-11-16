// Tabla de colores para cada estado de una transacción
var estadoTransaccion = new Array();
estadoTransaccion['1'] = "c7d6eb";		// Borrador
estadoTransaccion['2'] = "f7ed80";		// Ratificada
estadoTransaccion['3'] = "e7c58f";		// Autorizada
estadoTransaccion['4'] = "ededed";		// Denegada
estadoTransaccion['5'] = "9ddacb";		// Parcialmente Entregada
estadoTransaccion['6'] = "d9d9d9";		// Totalmente Entregada


function mensajeError(texto)
{
  var dialog = $('<div><p>'+texto+'</p></div>');
	var execute = function(){dialog.dialog("close");};

	var opciones = {	buttons: {"Aceptar": execute},
										title: "Error",
										bgiframe: true,
										modal: true
								};
  dialog.dialog(opciones);
}

function mensajeInfo(texto)
{
  var dialog = $('<div><p>'+texto+'</p></div>');
	var execute = function(){dialog.dialog("close");};

	var opciones = {	buttons: {"Aceptar": execute},
										title: "Información",
										bgiframe: true,
										modal: true
								};
  dialog.dialog(opciones);
}

function loadSincronico(pagina,datos)
{
	var resultado;
	$.ajax({
               type: "POST",
               async: false,
               dataType: "json",
               url: pagina,
               data: datos,
               success: function(available_json){
										resultado = available_json;
               }
             });

	return(resultado);
}

function sesionValida()
{
/*
	var resultado;
	$.ajax({
               type: "POST",
               async: false,
               dataType: "json",
               url: "../frontend/valSesion.php",
               data: {"idSesion":idSesion},
               success: function(available_json){
										resultado = available_json.estadoSesion;
               }
             });
*/
	var resultado = loadSincronico("../frontend/valSesion.php",{"idSesion":idSesion});
	return (resultado.estadoSesion == "SESION_OK");
}
