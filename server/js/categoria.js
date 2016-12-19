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