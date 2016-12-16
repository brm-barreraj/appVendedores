$(document).ready(function(){
	$('#btnInsertCat').click(function(){
		alert(2);
		result = sendAjax("serviceAdmin.php", "setCategoria", {nombre: $("#nombreSubcategoria").val(),idCategoria: $("#idCategoria").val()});
		if (result.error == 1){
			alert("inserto categoria correctamente");
		}else{
			alert('Ocurrio un error en la consulta');
		}
	});
});