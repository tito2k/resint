function getIdSesion()
{
	return $('#idSesion').val();
}

function agregarIdSesionAForm(form)
{
	$('#idSesion').clone().appendTo(form);
}