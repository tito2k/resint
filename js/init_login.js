$(document).ready(function() {
  $('#usuarioLogin').blur(validaCampos);
  $('#claveLogin').blur(validaCampos);
  $('#aceptarLogin').attr('disabled','-1');
  $('#usuarioLogin').focus();
});

function validaCampos()
{
  var usuario = $('#usuarioLogin');
  var clave = $('#claveLogin');

  if (usuario.val() != '' && clave.val() != '') 
    $('#aceptarLogin').removeAttr('disabled');
  else
    $('#aceptarLogin').attr('disabled','-1');
};