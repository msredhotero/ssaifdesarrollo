/**
 * Nombre: commons.js
 * Fecha: ENE 05, 2017.
 *
 * Descripci�n: Manejo de funciones y mensajes comunes para autenticacion de Usuarios
 *
 */

/**
 * MENSAJES DEVUELTOS
 */

const MSG_ERROR_GENERAL = "Ha ocurrido alg�n error, int�ntelo nuevamente"

const MSG_ERROR_TIMEOUT = "Hay demoras en este momento, int�ntelo en unos instantes";
const MSG_CREDENCIALES_VACIAS = "Ingrese su usuario y contrase�a";
const MSG_CREDENCIALES_VALIDAS = "Accediendo al Sistema...";
const MSG_CREDENCIALES_INVALIDAS = "Usuario y/o contrase�a incorrecta";
const MSG_CREDENCIALES_USUARIO_VACIA = "Ingrese su usuario";
const MSG_CAMPO_LONGITUD_CONTRASENA = 'La contrase�a debe tener entre 8 y 12 caracteres';
const MSG_USUARIO_NO_ACTIVO = "Usuario no activo";
const MSG_USUARIO_CON_ERRORES = "El sistema no puede validar su usuario, consulte con mesa de ayuda";
const MSG_USUARIO_DESCONOCIDO = "Usuario desconocido";
const MSG_SOLICITUD_EN_PROCESO = 'Procesando su solicitud, aguarde...';
const MSG_SESION_CADUCADA = 'Su sesi�n ha caducado. Vuelva a acceder al sitio para continuar operando.';

const MSG_IMAGEN_CAPTCHA_VACIA = "Ingrese el c�digo de la imagen";
const MSG_CAPTCHA_FAIL = "El c�digo de la im�gen no coincide";
const MSG_ENVIO_CLAVE_EXITO = "Enviamos un mail a su cuenta de correo registrada, para completar el cambio de clave solicitado." +
    "<br> Recuerde revisar su bandeja de correo no deseado. ";
const MSG_DOCUMENTO_INCORRECTO = "El documento no es correcto";
const MSG_DOCUMENTO_NO_REGISTRADO = "El documento no est� registrado";
const MSG_MAIL_INCORRECTO = "El mail que usted us� para registrarse no es correcto. " +
    "Por favor solicite el cambio de email a la mesa de ayuda.";

const MSG_CAMPO_TIPO_DNI_VACIO = "Seleccione su Tipo de Documento";
const MSG_CAMPO_NRO_DOCUMENTO = "Ingrese su Nro de Documento";
const MSG_CAMPO_LONGITUD_DOCUMENTO = 'El documento debe tener entre 7 y 8 d�gitos';
const MSG_CAMPO_TIPO_SEXO = "Indique el sexo";
const MSG_CAPTCHA_VACIO = 'Ingrese el c�digo de la imagen ( captcha )';
const MSG_DOCUMENTO_YA_REGISTRADO = "Ya existe un usuario registrado para este documento";
const MSG_ES_USUARIO_SIAPE = "Ud. es usuario de SIAPE, no debe registrarse, ingrese con su usuario y contrase�a habitual";

const MSG_REGISTRO_EXITOSO = "Ud. se ha registrado exitosamente en Portal Siape";
const MSG_DATOS_OBLIGATORIOS = "Complete todos los datos";
const MSG_DOCUMENTO_DISTINTO_CONTRASENA = "La contrase�a no puede ser igual a su documento";
const MSG_CAMPO_EMAIL_NO_VACIO = 'Ingrese su correo electr�nico email';
const MSG_CAMPO_EMAIL_FORMATO_VALIDO = 'Ingrese un email con formato v�lido';
const MSG_CAMPO_CUIL_FORMATO_NUMEROS = 'El cuip/cuit/cuil solo puede contener n�meros';
const MSG_CAMPO_CUIL_CANTIDAD_DIGITOS = 'El cuip/cuit/cuil debe tener 11 d�gitos';
const MSG_CAMPO_CUIL_DISTINTO_DOCUMENTO = 'Su cuip/cuit/cuil no tiene relaci�n con el documento';
const MSG_CAMPO_CUIL_INVALIDO = 'Su Cuip/Cuit/Cuil no pas� la validaci�n';
const MSG_CAMPO_CONTRASENA_NO_VACIA = 'Ingrese una contrase�a';
const MSG_CAMPO_CONTRASENA_NO_VALIDO = 'Contrase�as no pueden contener espacios en blanco';
const MSG_CAMPO_REPETIR_CONTRASENA = 'Complete el campo Repetir su contrase�a';
const MSG_CLAVE_VACIA = "Ingrese y repita su nueva clave";
const MSG_CLAVE_MODIFICADA_CORRECTAMENTE = "Su contrase�a ha sido modificada con �xito.";
const MSG_LINK_INVALIDO = "El link que quieres acceder no existe o est� vencido.";
const MSG_CAMPO_CONTRASENA_NO_COINCIDEN = 'Contrase�as no coinciden, ingrese la misma contrase�a en ambos campos';
const MSG_COMPLETAR_EMAIL = 'Debe completar el email en su perfil';



//////////////////////////////////////////////////////////////////////////////////////////////////////
//function alerta(msg,color), mensaje de alerta, se le puede enviar tanto mensaje como constante, y colores (red, green, yellow)
//////////////////////////////////////////////////////////////////////////////////////////////////////
function alerta(msg, type){
	var color = "white";
	var title = "Alerta";
	var icon = "&#xE88F;";
	switch(type) {
		case "error":
			icon = "&#xE888;";
			color = "red";
			title = "Error";
			break;
		case "warning":
			icon = "&#xE002;";
			color = "amber darken-1";
			title = "Precauci�n";
			break;
		case "info":
			icon = "&#xE88F;";
			color = "light-blue";
			title = "Informaci�n";
			break;
		case "done":
			icon = "&#xE876;";
			color = "green darken-1";
			title = "Correcto";
			break;
	} 
	
	var dialog = "";
	dialog += "			<div class='row'>";
	dialog += "				<div class='col s4 center-align "+color+"'>";
	dialog += "					<i class='medium material-icons'>"+icon+"</i>";
	dialog += "				</div>";
	dialog += "				<div class='col s8 black-text'>";
	dialog +=					"<b>"+title+":</b><br>"+msg;
	dialog += "					<i class='fa fa-window-close' aria-hidden='true'></i>";
	dialog += "				</div>";
	dialog += "			</div>";
	Materialize.toast(dialog, 10000);
}


function setInputInvalid(selector){
	if ($(selector).is("select")) {
		$(selector).closest(".input-field").children(".select-wrapper").children("input").addClass("invalid");
	}else{
		$(selector).addClass("invalid");
	}
	setTimeout(function () { removeInputValidation(selector); }, 10000);
}

function removeInputValidation(selector){
	if ($(selector).is("select")) {
		$(selector).closest(".input-field").children(".select-wrapper").children("input").removeClass("invalid");
		$(selector).closest(".input-field").children(".select-wrapper").children("input").removeClass("valid");
	}else{
		$(selector).removeClass("invalid");
		$(selector).removeClass("valid");
	}
}

var isNumberKey = function (evt) {

    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;

}

var validaCuitConDNI = function (cuip, dni) {
    
    var sCUIT = cuip;
    if (sCUIT !== '') {

        var n = sCUIT.substring(2, 10);
        if (parseInt(n) != parseInt(dni)) {
            return false;
        }
        var aMult = '5432765432';
        var aMult = aMult.split('');

        if (sCUIT && sCUIT.length == 11) {
            aCUIT = sCUIT.split('');
            var iResult = 0;
            for (i = 0; i <= 9; i++) {
                iResult += aCUIT[i] * aMult[i];
            }
            iResult = (iResult % 11);
            iResult = 11 - iResult;

            if (iResult == 11) iResult = 0;
            if (iResult == 10) iResult = 9;

            if (iResult == aCUIT[10]) {				
                return true;
            }
        }
        return false;
    }
    return false;
}

function validarEmail(valor) {
    filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (filtro.test(valor)) {
        return true;
    }
    else {
        return false;
    }
}

function validarNumero(numero) {
    if (/^([0-9])*$/.test(numero)) {
        return true;
    } else {
        var $toastContent = $('<span> El valor " + numero + " no es un n�mero </span>');
        Materialize.toast($toastContent, DELAY_MESSAGE, 'red');
        return request_login = false;
    }
}

function toastCompleteCallback() {
    $('[class*="invalid"]').removeClass('invalid').css('transition', 'inherit');
}