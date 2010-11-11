$(document).ready(function() {
	$('#idSesion').clone().appendTo('#frmCambiarClave');

  var options = {
      target:       '#mensaje',
      beforeSubmit: validaForm,
      success:      formSuccess
  };      
  $('#frmCambiarClave').ajaxForm(options);

  $('#claveVieja').focus();

});

function validaForm()
{
	return true;
};

function formSuccess(responseText, statusText, xhr, $form)
{
	var retorno = $.parseJSON(responseText);
	mensajeInfo(retorno.mensaje);
	$('#center').empty();
};
