(function( $ ) {
	$( ".ui-autocomplete-input" ).live( "autocompleteopen", function() {
		var autocomplete = $( this ).data( "autocomplete" ),
		menu = autocomplete.menu;

		if ( !autocomplete.options.selectFirst ) {
			return;
		}

		menu.activate( $.Event({ type: "mouseenter" }), menu.element.children().first() );
	});
}( jQuery ));	


$(document).ready(function() {

	$('#idSesion').clone().appendTo('#frmSolicitud');	
	$('#frmSolicitud').append('<input type="hidden" id="datos" name="datos" value=/>');
	$('#destino').change(mostrarCampo);
	mostrarCampo();

	$('#idfuncionario').focusout(function(){var idFuncionario = $('#idfuncionario').val();$('#ci').load("../solicitud/datFuncionario.php",{idSesion:idSesion,Cedula:idFuncionario});});		
	$('#idvehiculo').focusout(function(){var mat = $('#idvehiculo').val();$('#matricula').load("../solicitud/datVehiculo.php",{idSesion:idSesion,Matricula:mat});});
		
	var options = {
	  target:       '#center',
	  beforeSubmit: validaForm,
	  success:      formSuccess
	};      
	$('#frmSolicitud').ajaxForm(options);

	var opcDate = {
			dateFormat:		"dd/mm/yy"
		};

	$('#fecha').datepicker(opcDate);
//	$('#fecha').focus();

	$('#aceptarSolicitud').click(procesaGrilla);

// TinyMCE ////////////////////////////////////////////////////////////////////////
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../../js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
//			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,|,forecolor,backcolor",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
		});
// //////////////////////////////////////////////////////////////
	


	$('select#seccion').selectmenu({style:'dropdown'});
	$('select#almacen').selectmenu({style:'dropdown'});
	
});

function setHotKeys()
{
	jQuery('#list').editGridRow("new");	
}

function editarFila(elem)
{
	autocompletar(elem);
}
	
function autocompletar(elem){
	$(elem).autocomplete({
		source: "../frontend/prcAutocompletar.php?idSesion="+idSesion+"&tabla=articulo&buscar=descripcion&campoClave=idArticulo&campoDesc=nombre",
		width: 20,
		max: 4,
		highlight: false,
		multiple: false,
		multipleSeparator: " ",
		selectFirst: true,
		scroll: true,
		scrollHeight: 300,
		select: function(event, ui) {
			$('#nombre').attr('value' ,ui.item.value);
			$('#idarticulo').attr('value',ui.item.id);						
		}
	});
}

function callBack(response,postData) {

	var success = true;
	var message = "";

	return [success,message];
}

function validaForm()
{
	if (jQuery("#list").getGridParam("records")==0)
		return false;
	else
		return true;
};

function formSuccess(responseText, statusText, xhr, $form)
{
	var retorno = $.parseJSON(responseText);
	mensajeInfo(retorno.mensaje);
	$('#center').empty();
};

function getAutocomplete(term)
{
	var retorno = "[";
	var tuplas;
	$.ajax({
               type: "GET",
               async: false,
               dataType: "json",
               url: "../frontend/prcAutocompletar.php",
               data: {"idSesion":idSesion,"tabla":"articulo","buscar":"descripcion","campoClave":"idarticulo","campoDesc":"nombre","valor":"tor"},
               success: function(available_json){
										tuplas = available_json;
               }
             });
	return tuplas;
};

function procesaGrilla()
{
	var array = jQuery("#list").jqGrid('getRowData');
	var datos = "[";
	var largo = array.length;

	for (var i=0;i<largo;i++)
	{
		var linea = array[i];
		if (linea.idarticulo) 
		{
			if (i > 0) datos += ",";
			datos += '{';
			var primero = true;
			for (var indice in linea)
			{
				if (!primero) {
					datos += ",";
				}
				else
				{
					primero = false;
				}
				datos += '"'+indice+'":"'+linea[indice]+'"';
			}				
			datos += '}';			
		}
	}

	datos += "]";
	$('#datos').attr("value",datos);	
};

function mostrarCampo()
{
	var destino = $('#destino').val();
	
	switch(destino) {
		case "S":
			$('#seccion').show();
			$('#funcionario').hide();
			$('#vehiculo').hide();
			break;
		case "F":
			$('#seccion').hide();
			$('#funcionario').show();
			$('#vehiculo').hide();
			break;
		case "V":
			$('#seccion').hide();
			$('#funcionario').hide();
			$('#vehiculo').show();
			break;			
	}
}