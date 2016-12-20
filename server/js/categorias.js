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
		result = sendAjax("serviceAdmin.php", "deleteCategoria", {idCategoria:id});
		if (result.error == 1){
			data = result.data;
			alert('Registro Elemininado correctamente');
			location.reload();
		}else{
			alert('Ocurrio un error en la consulta');
		}
	});


	// Agregar y editar
	$('#btnForm').click(function(){

		if($('#create').valid()){
			var accion = ($("#idCategoria").val() != "") ? "updateCategoria" : "setCategoria";
			var serial = $('#create').serialize();
			result = sendAjax("serviceAdmin.php", accion,serial);
			if (result.error == 1){
				data = result.data;
				alert('Registro Agregado correctamente');
				window.location="categorias.php";
			}else{
				alert('Ocurrio un error en el registro del usuario');
			}
		}
	});


	// Paginador
	$('.num').click(function(){
		var num = $(this).attr('id');
		var pagI = (num==1)? 1 : (num*10)-9;
		var pagF = pagI+9;
		$('#pagI').html(pagI);
		$('#pagF').html(pagF);
		// obtiene los datos de usuario
		result = sendAjax("serviceAdmin.php", "getCategorias", {pagina:num});
		if (result.error == 1){
			data = result.data;
			var tabla='';
			for (var i =0; i< data.length ; i++) {
				tabla+='<div> <p>'+data[i].nombre+'</p> </div> <div> <p>'+data[i].padre+'</p> </div> <div class="data-list-field-option" data-field="'+data[i].idCategoria+'"> <a href="categoriasForm.php?idCategoria='+data[i].idCategoria+'"> <div class="edit" data-field="'+data[i].idCategoria+'"> <p>EDITAR</p> <em class="lnr lnr-pencil"></em> </div> </a> <div class="show-hide eliminar" data-field="'+data[i].idCategoria+'"> <p>OCULTAR</p> <em class="lnr lnr-eye-hidden"></em> </div> <i class="close lnr lnr-cross" data-field="'+data[i].idCategoria+'"></i> </div> <div class="data-list-field-menu" data-field="'+data[i].idCategoria+'"> <em class="lnr lnr-menu"></em> </div>';
			}
			$('.tabla').html(tabla);
		}else{
			alert('Ocurrio un error en la consulta');
		}
	});

	//busqueda automatica
	$('#search').keyup(function(){
		var termino = $('#search').val();
		termino=termino.trim();
		if(termino==''){
			location.reload();
		}else{
			termino = (termino.length > 60)? termino.slice(0,59): termino;
			//console.log(termino);
			result = sendAjax("serviceAdmin.php", "buscadorCategoria", {termino:termino});
			if(result.error == 1){
				$('#data-list-bottom').hide();
				$('#data-list').css('overflow-y','scroll');
				data = result.data;
				var tabla='';
				for (var i =0; i< data.length ; i++) {
					tabla+='<div class="data-list-field"><div> <p>'+data[i].nombre+'</p> </div> <div> <p>'+data[i].padre+'</p> </div> <div class="data-list-field-option" data-field="'+data[i].idCategoria+'"> <a href="categoriasForm.php?idCategoria='+data[i].idCategoria+'"> <div class="edit" data-field="'+data[i].idCategoria+'"> <p>EDITAR</p> <em class="lnr lnr-pencil"></em> </div> </a> <div class="show-hide eliminar" data-field="'+data[i].idCategoria+'"> <p>OCULTAR</p> <em class="lnr lnr-eye-hidden"></em> </div> <i class="close lnr lnr-cross" data-field="'+data[i].idCategoria+'"></i> </div> <div class="data-list-field-menu" data-field="'+data[i].idCategoria+'"> <em class="lnr lnr-menu"></em> </div>';
				}
				$('.tabla').html(tabla);
			}else{
				alert('Ocurrio un error en la consulta');
			}
		}
	});
});


$(document).on( "click", '.data-list-field-menu',function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").show();

});

$(document).on( "click",".close", function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").hide();
});