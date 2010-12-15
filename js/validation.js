var validationErrorMessage = new Object();
validationErrorMessage['required'] = 'Debe completar este dato';
validationErrorMessage['numeric'] = 'Debe ingresar un n\xfamero';
validationErrorMessage['float'] = 'Debe ingresar un n\xfamero';
validationErrorMessage['pattern'] = 'Patr\xf3n incorrecto';
validationErrorMessage['email'] = 'Correo electr\xf3nico incorrecto';
validationErrorMessage['sgp'] = 'Ya existe un hecho con ese SGP';
validationErrorMessage['prontuario'] = 'Ya existe un liberado con este Prontuario';
validationErrorMessage['denuncia'] = 'Fecha incorrecta';
validationErrorMessage['user'] = 'Ya existe este usuario';
validationErrorMessage['fecha'] = 'La fecha es posterior a la actual';
validationErrorMessage['mayor_cero'] = 'Tiene que ser un valor mayor a cero';

var validationFunctions = new Object();
validationFunctions["required"] = isRequired;
validationFunctions["pattern"] = isPattern;
validationFunctions["numeric"] = isNumeric;
validationFunctions["float"] = isFloat;
validationFunctions["email"] = isEmail;
validationFunctions["sgp"] = existeSGP;
validationFunctions["prontuario"] = existeProntuario;
validationFunctions["denuncia"] = validaDenuncia;
validationFunctions["user"] = existeUsuario;
validationFunctions["fecha"] = fechaValida;
validationFunctions["mayor_cero"] = isMayorCero;


function existeSGP(formField)
{
  oldsgp = document.getElementById('old_sgp');
  ok = true;

  if (oldsgp)
  {
    if (formField.value != oldsgp.value)
    {
      ajax = objetoAjax();
      ajax.open("POST", "comunes/existeSGP.php",true);
     	ajax.onreadystatechange=function() {
                  	if (ajax.readyState==4) {
                      if (ajax.responseText == '0')  // 0 = No existe el SGP, 1 en caso contrario
                      {
                        habilitaCampos();
                        document.getElementById('primer_campo').focus();
                      }  
                      else
                      {
                        ok = false;
                        deshabilitaCampos();
                        formField.focus();
                        writeError(formField,validationErrorMessage['sgp']);
                      }
                  	}
    	           }
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    	ajax.send("sgp="+formField.value);
    }
    else
    {
      habilitaCampos();   
    }
  }  
  return ok;
}

function existeProntuario(formField)
{
  oldProntuario = document.getElementById('old_prontuario');
  ok = true;

  if (oldProntuario)
  {
    if (formField.value != oldProntuario.value)
    {
      ajax = objetoAjax();
      ajax.open("POST", "comunes/existeProntuario.php",true);
     	ajax.onreadystatechange=function() {
                  	if (ajax.readyState==4) {
                      if (ajax.responseText == '0')  // 0 = No existe el Prontuario, 1 en caso contrario
                      {
                        habilitaCampos();
                        document.getElementById('primer_campo').focus();
                      }  
                      else
                      {
                        ok = false;
                        deshabilitaCampos();
                        formField.focus();
                        writeError(formField,validationErrorMessage['prontuario']);
                      }
                  	}
    	           }
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    	ajax.send("prontuario="+formField.value);
    }
    else
    {
      habilitaCampos();   
    }
  }  
  return ok;
}

function existeUsuario(formField)
{
  olduser = document.getElementById('old_user');
  ok = true;

  if (olduser)
  {
    if (formField.value != olduser.value)
    {
      ajax = objetoAjax();
      ajax.open("POST", "comunes/existeUsuario.php",true);
     	ajax.onreadystatechange=function() {
                  	if (ajax.readyState==4) {
                      if (ajax.responseText == '0')  // 0 = No existe el Usuario, 1 en caso contrario
                      {     
                        habilitaCampos();
                        document.getElementById('nombre').focus();
                      }  
                      else
                      {
                        ok = false;
                        deshabilitaCamposUsuario();
                        formField.focus();
                        writeError(formField,validationErrorMessage['user']);
                      }
                  	}
    	           }
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    	ajax.send("usuario="+formField.value);
    }
    else
    {
      habilitaCampos();   
    }
  }  
  return ok;
}

function validaDenuncia(formField)
{
  fecha_hecho = document.getElementById('fecha_hecho');
  fecha_den = parseInt(formField.value.substr(6,4)+formField.value.substr(3,2)+formField.value.substr(0,2));
  fecha_hec = parseInt(fecha_hecho.value.substr(6,4)+fecha_hecho.value.substr(3,2)+fecha_hecho.value.substr(0,2));
  
  return fecha_den >= fecha_hec;  
}

function fechaValida(formField)
{
  var fechaServ = new Date();
  var fechaActual = ((fechaServ.getYear()+1900)*10000)+((fechaServ.getMonth()+1)*100)+fechaServ.getDate();
  var fechaPasada = parseInt(formField.value.substr(6,4)+formField.value.substr(3,2)+formField.value.substr(0,2)); 

  return fechaPasada <= fechaActual;
}

function isRequired(formField) {
	switch (formField.type) {
		case 'text':
		case 'textarea':
		case 'password':
      if (formField.value)
				return true;
			return false;
		case 'select-one':
			if (formField.value != 0)
				return true;
			return false;
		case 'radio':
			var radios = formField.form[formField.name];
			for (var i=0;i<radios.length;i++) {
				if (radios[i].checked) return true;
			}
			return false;
		case 'checkbox':
			return formField.checked;
	}	
}

function isPattern(formField,pattern) {
	var pattern = pattern || formField.getAttribute('pattern');
	var regExp = new RegExp("^"+pattern+"$","");
	var correct = regExp.test(formField.value);
	if (!correct && formField.getAttribute('patternDesc'))
		correct = formField.getAttribute('patternDesc');
	return correct;
}

function isNumeric(formField) {
	return isPattern(formField,"\\d+");
}

function isFloat(formField) {
	return (isPattern(formField,"\\d+\.\\d+") || isNumeric(formField));
}

function isEmail(formField) {
	return isPattern(formField,"\\w*@\\w*\.\\w{2,4}")
}

function isMayorCero(formField) {
	if (isNumeric(formField)) {
		if (formField.value > 0) {
			return true;
		}
	}
	return false;
}

function emptyFunction() {
	return true;
}

/*********************************/

var W3CDOM = document.createElement && document.getElementsByTagName;

function validateForms() {

	if (!W3CDOM) return;
	var forms = document.forms;
	for (var i=0;i<forms.length;i++) {
		forms[i].onsubmit = validate;
	}
}

function validate(formData, jqForm, options) {
	var els = jqForm[0].elements;
	var validForm = true;
	var firstError = null;

	for (var i=0;i<els.length;i++) {
		if (els[i].removeError)
			els[i].removeError();
		var req = els[i].getAttribute('validation');

		if (!req) continue;
		var reqs = req.split(' ');
		if (els[i].getAttribute('pattern'))
			reqs[reqs.length] = 'pattern';
		for (var j=0;j<reqs.length;j++) {
			if (!validationFunctions[reqs[j]])
				validationFunctions[reqs[j]] = emptyFunction;
			var OK = validationFunctions[reqs[j]](els[i]);
			if (OK != true) {
				var errorMessage = OK || validationErrorMessage[reqs[j]];
				writeError(els[i],errorMessage)
				validForm = false;
				if (!firstError)
					firstError = els[i];
				break;
			}
		}
	}

	if (!validForm) {
		alert("Se encontraron errores");
		location.hash = '#form';
	}
  return validForm;
	
}

function writeError(obj,message) {
  selector = $('#'+obj.name);
  selector.addClass('errorMessage');
//	obj.className += ' errorMessage';
  addEventSimple(obj,'change',removeError);
//	obj.onchange = removeError;
  
	if (obj.errorMessage || obj.parentNode.errorMessage) return;
	var errorMessage = document.createElement('span');
	errorMessage.className = 'errorMessage';
	errorMessage.setAttribute('for',obj.id);
	errorMessage.setAttribute('htmlFor',obj.id);
	errorMessage.setAttribute('id',obj.id+'_error');
	errorMessage.appendChild(document.createTextNode(message));
	obj.parentNode.appendChild(errorMessage);
	obj.errorMessage = errorMessage;
	obj.parentNode.errorMessage = errorMessage;
}

function removeError() {

  $(this).removeClass('errorMessage');
		
	if (this.errorMessage) {
		$('#'+this.id + '_error').remove();		
		this.errorMessage = null;
		this.parentNode.errorMessage = null;
  }
  removeEventSimple(this,'change',removeError);
}

function habilitaCampos()
{
	if (!W3CDOM) return;
	var elements = document.forms[0].elements;
	for (var i=0;i<elements.length;i++) {
		elements[i].removeAttribute('disabled');
  }
    // para el form de usuarios
    var nivel = $('#nivel_usuario').val();
    if (nivel == 2)
    {
      $('#seccional').attr('disabled','disabled');
      $('#nivel_id').attr('disabled','disabled');
    }
}

function deshabilitaCampos()
{
	if (!W3CDOM) return;
	var elements = document.forms[0].elements;
	for (var i=0;i<elements.length;i++) {
	  $('#'+elements[i].name).attr('disabled','disabled');
  }
  $('#sgp').removeAttr('disabled');
  $('#sgp').focus;
}

function deshabilitaCamposUsuario()
{
	if (!W3CDOM) return;
	var elements = document.forms[0].elements;
	for (var i=0;i<elements.length;i++) {
	  $('#'+elements[i].name).attr('disabled','disabled');
  }

  $('#user').removeAttr('disabled');
  $('#user').focus;
}

function fechaServidor()
{
  var dia = <?php echo strftime("%d-%m-%y",time()); ?>;
  var mes = <?php echo date("m"); ?>;
  var anio = <?php echo date("Y"); ?>;
  var fecha = new Date(anio,mes,dia);
  
alert(dia+"-"+mes+"-"+anio);
  return(fecha);
}
