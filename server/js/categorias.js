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