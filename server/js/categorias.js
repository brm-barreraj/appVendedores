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
					minlength: 2,
					maxlength: 150
				},
				idPadre:{
					required:true,
				},
			},
			messages: {
				nombre:{
					required:'Campo necesario',
					minlength: 'Nombre de categoria corto en longitud',
					maxlength:'Nombre de categoria muy largo',	
				},
				idPadre:{
					required: 'Seleccione una categoria padre',
				},

				
			}
		});



	// Eliminar

	$('.eliminar').click(function(){
		var id = $(this).attr('data-field');
		result = sendAjax("serviceAdmin.php", "deleteCategoria", {idCategoria:id});
		if (result.error == 1){
			data = result.data;
			showmessage('Registro Elemininado correctamente');
			location.reload();
		}else{
			showmessage('Ocurrio un error en la consulta');
		}
	});


	// Agregar y editar
	$('#create-title-option').click(function(){

		if($('#create').valid()){
			var accion = ($("#idCategoria").val() != "") ? "updateCategoria" : "setCategoria";
			var serial = $('#create').serialize();
			result = sendAjax("serviceAdmin.php", accion,serial);
			if (result.error == 1){
				data = result.data;
				showmessage('Registro Agregado correctamente');
				window.location="categorias.php";
			}else{
				showmessage('Ocurrio un error en el registro del usuario');
			}
		}
	});

	$(document).on( "click", '.data-list-field-menu',function() {
		var field=$(this).attr("data-field");
		$(".data-list-field-option[data-field='"+field+"']").show();

	});

	$(document).on( "click",".close", function() {
		var field=$(this).attr("data-field");
		$(".data-list-field-option[data-field='"+field+"']").hide();
	});

	$('#data').jplist({				
	    itemsBox: '#data-list-fields', 
	    itemPath: '.data-list-field', 
	    panelPath: '.data-panel'	
	 });


});


