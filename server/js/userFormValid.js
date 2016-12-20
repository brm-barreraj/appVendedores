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
				/*idSubCategoria:{
					required: true,
					email: true,
				},*/
				/*celular:{
					required: true,
					number: true,
					minlength: 10,
					maxlength: 15,
				},
				idPais:{
					required: true,
				},
				ciudad:{
					required: true,
				},
				sexo:{
					required:true,
				},
				terminos:{
					required: true,
				},
				politica:{
					required: true,
				},*/
				/*otroDepto:{
					required:true,
					minlength: 3,
					maxlength: 50
				},
				otroCiudad:{
					required:true,
					minlength: 3,
					maxlength: 50
				}*/


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
				/*fecha:{
					required: 'Campo necesario',
					date: 'Formato de fecha no válido',
				},
				email:{
					required: 'Campo necesario',
					email: 'Formato de correo electrónico no válido',
				},
				celular:{
					required: 'Campo necesario',
					number: 'Únicamente admite digitos (0-9)',
					minlength:'Debe ser mayor a 10 dígitos',
					maxlength: 'Debe ser menor a 15 dígitos',
				},
				idPais:{
					required: 'Campo necesario',
				},
				sexo:{
					required:'Campo necesario',
				},
				ciudad:{
					required: 'Campo necesario',
				},
				terminos:{
					required: 'Campo necesario',
				},
				politica:{
					required: 'Campo necesario',
				},*/
				/*otroDepto:{
					required:'Campo necesario',
					minlength:'El nombre del departamento es muy corto',
					maxlength:'El nombre del departamento largo',

				},
				otroCiudad:{
					required:'Campo necesario',
					minlength:'El nombre de la ciudad es muy corto',
					maxlength:'El nombre de la ciudad largo',

				}*/

			}
		});
});
