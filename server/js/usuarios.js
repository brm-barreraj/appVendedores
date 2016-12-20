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
				nombre:{
					required: true,
					string:true,
					minlength: 2,
					maxlength: 150
				},
				apellido:{
					required: true,
					minlength: 2,
					maxlength: 150
				},

				idCargo: {
					required: true,
					number: true,
					minlength: 1,
					maxlength: 10
				},
				email:{
					required: true,
					email: true,
				},
				usuario:{
					required: true,
				},
				

				contrasena:{
					required: true,
				},

				puntos:{
					required:true,
					number: true,
					minlength: 1,
					maxlength: 10
				},
			},
			messages: {
				nombre:{
					required:'Campo necesario',
					string:'Ingrese unicamente letras',
					minlength: 'Titulo corto en longitud',
					maxlength:'Titulo muy largo',
					
				},
				apellido:{
					required: 'Campo necesario',
					string:'Ingrese unicamente letras',
					minlength: 'Subtitulo corto en longitud',
					maxlength: 'Subtitulo muy largo',
					
				},

				idCargo:{
					required:'Campo necesario',
					number: 'Únicamente admite digitos (0-9)',
					minlength:'Número muy corto',
					maxlength: 'Número muy largo',
				},

				email:{
					required: 'Campo necesario',
					email: 'Formato de correo electrónico no válido',
				},


				usuario:{
					required: 'Campo necesario',
				},

				contrasena:{
					required: 'Campo necesario',
				},
				puntos:{
					required:'Campo necesario',
					number: 'Únicamente admite digitos (0-9)',
					minlength:'Número muy corto',
					maxlength: 'Número muy largo',
				},
			}
		});
});

//eliminar

$('.eliminar').click(function(){
	var id = $(this).attr('data-field');
	result = sendAjax("serviceAdmin.php", "deleteUsuario", {idUsuario:id});
	if (result.error == 1){
		data = result.data;
		alert('Registro Elemininado correctamente');
		location.reload();
	}else{
		alert('Ocurrio un error en la consulta');
	}
});

//Editar

$('.editar').click(function(){

});


//agregar
$('#btnForm').click(function(){

	if($('#create').valid()){
		var accion = ($("#idUsuario").val() != "") ? "updateUsuario" : "setUsuario";
		var serial = $('#create').serialize();
		result = sendAjax("serviceAdmin.php", accion,serial);
		if (result.error == 1){
			data = result.data;
			alert('Registro Agregado correctamente');
			window.location="usuarios.php";
		}else{
			alert('Ocurrio un error en el registro del usuario');
		}
	}
});


$( ".data-list-field-menu").on( "click", function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").show();

});

$( ".close").on( "click", function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").hide();
});