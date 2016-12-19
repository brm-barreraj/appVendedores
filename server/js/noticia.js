
$('#guardar').click(function(){

	var imagen = $("#create input[name=image]").val();
	imagen= imagen.split('.');
	var img= '';
	var ext =false;
	//console.log(imagen[(imagen.length -1)]);
    ext=imagen[(imagen.length -1)];
		if ( ext === 'jpg' || ext ==='png' || ext === 'gif' || ext === 'jpeg' || ext === 'JPG' || ext === 'PNG' || ext ==='GIF' || ext === 'JPEG' ) {
			img=true;
		}else { 
			$("#info").addClass('error');
			$("#info").html('<span style="color:#f04124;">Por favor selecciona una imagen.</span>');
		}

	if (img && $('#create').valid()) {
		var formData = new FormData(document.getElementById("create"));
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
			console.log(data.error);
			if (data.error==1){
				location.reload();
				alert("Guardo la noticia correctamente");
			}else{
				alert("Ocurrio un error al guardar la noticia");
			}
		});
	}
});

$('#idCategoria').change(function(){
	console.log($(this).val());
	result = sendAjax("serviceAdmin.php", "getSubcategorias", {idCategoria:$(this).val()});
	if (result.error == 1){
		data = result.data;
		var tabla='<option>Subcategoría</option>';
		for (var i =0; i< data.length ; i++) {
			tabla+='<option value="'+data[i].idCategoria +'">'+data[i].nombre+'</option>';
		}
		$('#idSubCategoria').html(tabla).show();
		$('#idSubCategoriaDiv').show();
		
	}else{
		alert('Ocurrio un error en la consulta');
	}
});
