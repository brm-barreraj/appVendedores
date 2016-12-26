/*
*función que valida el formulario de preventas octubre
*(campos: nombre, email, cedula, y numero de contacto.)
*/


/*comienza verificando que la pagina haya cargado totalmente*/
jQuery(document).ready(function () {
	/*se agrega un metodo de validacion llamdo string; se encarga de
	* validar que las cadenas de caracteres ingresadas no contengan
	* caracteres especiales.
	*/
	jQuery.validator.addMethod("string", function(value, element)
    {
        return this.optional(element) || /^[a-z" "ñÑáéíóúÁÉÍÓÚ,.;]+$/i.test(value);
    });

	/*aquí comienza la validacion campo por campo, esta validacion
	*se efectua a traves de la libreria jquery.validate*/

	jQuery("#create").validate({
		rules: {
			titulo:{
				required: true,
				minlength: 2,
				maxlength: 150
			},
			subtitulo:{
				required: true,
				minlength: 2,
				maxlength: 150
			},

			idCategoria: {
				required: true,
				number: true,
				minlength: 1,
				maxlength: 10
			},
		},
		messages: {
			titulo:{
				required:'Campo necesario',
				minlength: 'Titulo corto en longitud',
				maxlength:'Titulo muy largo',
				
			},
			subtitulo:{
				required: 'Campo necesario',
				minlength: 'Subtitulo corto en longitud',
				maxlength: 'Subtitulo muy largo',
				
			},

			idCategoria:{
				required:'Campo necesario',
				number: 'Únicamente admite digitos (0-9)',
				minlength:'Número muy corto',
				maxlength: 'Número muy largo',
			},
		}
	});
};