$(document).ready(function(){
	$('#btnInsertCat').click(function(){
		result = sendAjax("serviceAdmin.php", "setCategoria", {nombre: $("#nombreSubcategoria").val(),idCategoria: $("#idCategoria").val()});
		if (result.error == 1){
			alert("inserto categoría correctamente");
		}else{
			alert('Ocurrio un error en la consulta');
		}
	});
});

//eleminiar

$('.eliminar').click(function(){
	var id = $(this).attr('data-id');
	result = sendAjax("serviceAdmin.php", "deleteCategoria", {idCategoria:id});
	if (result.error == 1){
		data = result.data;
		alert('Registro Elemininado correctamente');
	}else{
		alert('Ocurrio un error en la consulta');
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
			tabla+='<div> <p>'+data[i].subcategoria+'</p> </div> <div> <p>'+data[i].categoria+'</p> </div> <div class="data-list-field-option" data-field="'+data[i].idUsuario+'"> <a href="categoriasForm.php?idCategoria='+data[i].idUsuario+'"> <div class="edit" data-field="'+data[i].idUsuario+'"> <p>EDITAR</p> <em class="lnr lnr-pencil"></em> </div> </a> <div class="show-hide eliminar" data-field="'+data[i].idUsuario+'"> <p>OCULTAR</p> <em class="lnr lnr-eye-hidden"></em> </div> <i class="close lnr lnr-cross" data-field="'+data[i].idUsuario+'"></i> </div> <div class="data-list-field-menu" data-field="'+data[i].idUsuario+'"> <em class="lnr lnr-menu"></em> </div>';
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
				tabla+='<div> <p>'+data[i].subcategoria+'</p> </div> <div> <p>'+data[i].categoria+'</p> </div> <div class="data-list-field-option" data-field="'+data[i].idUsuario+'"> <a href="categoriasForm.php?idCategoria='+data[i].idUsuario+'"> <div class="edit" data-field="'+data[i].idUsuario+'"> <p>EDITAR</p> <em class="lnr lnr-pencil"></em> </div> </a> <div class="show-hide eliminar" data-field="'+data[i].idUsuario+'"> <p>OCULTAR</p> <em class="lnr lnr-eye-hidden"></em> </div> <i class="close lnr lnr-cross" data-field="'+data[i].idUsuario+'"></i> </div> <div class="data-list-field-menu" data-field="'+data[i].idUsuario+'"> <em class="lnr lnr-menu"></em> </div>';
			}
			$('.tabla').html(tabla);
		}else{
			alert('Ocurrio un error en la consulta');
		}
	}
});

