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

	// Eliminar

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


	// Agregar y editar
	$('#create-title-option').click(function(){

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

	$(document).on( "click",".data-list-field-menu", function() {
		var field=$(this).attr("data-field");
		$(".data-list-field-option[data-field='"+field+"']").show();

	});

	$(document).on( "click",".close", function() {
		var field=$(this).attr("data-field");
		$(".data-list-field-option[data-field='"+field+"']").hide();
	});



	$("#create-excel").on('change','#excel' , function(){ 

		var excel = $("#create-excel input[name=excel]").val();
		excel= excel.split('.');
		var img= '';
		var ext =false;
		//console.log(excel[(excel.length -1)]);
	    ext=excel[(excel.length -1)];
		if ( ext === 'xls') {
			img=true;
		}else { 
			$("#message").addClass('error');
			$("#message").html('<span style="color:#f04124;">Por favor selecciona una excel.</span>');
		}
		if (img) {
			var formData = new FormData(document.getElementById("create-excel"));
			$.ajax({
				url:'serviceAdmin.php',
				method: 'POST',
				data: formData,
				cache: false,
				dataType: 'json',
				contentType: false,
				processData: false,
				enctype: 'multipart/form-data'
			}).success(function (data){
				if (data.error==1){
					location.reload();
					alert("Guardo el excel correctamente");
				}else{
					alert("Ocurrio un error al guardar la noticia");
				}
			});
		}

	});

	 $('#data').jplist({				
	    itemsBox: '#data-list-fields', 
	    itemPath: '.data-list-field', 
	    panelPath: '.data-panel'	
	 });

});



