$('.num').click(function(){
	var num = $(this).attr('id');
	var pagI = (num==1)? 1 : (num*10)-9;
	var pagF = pagI+9;
	$('#pagI').html(pagI);
	$('#pagF').html(pagF);
	// obtiene los datos de usuario
	result = sendAjax("serviceAdmin.php", "getUsuarios", {pagina:num});
	if (result.error == 1){
		data = result.data;
		var tabla='';
		for (var i =0; i< data.length ; i++) {
			tabla+='<div class="data-list-field"><div><p>'+data[i].nombre+'</p><small>'+data[i].apellido+'</small></div><div><p>'+data[i].cargo+'</p></div><div><p>'+data[i].email+'</p></div><div><p>'+data[i].puntos+'</p></div><div class="data-list-field-option"><em class="lnr lnr-pencil"></em></div></div>';
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
		result = sendAjax("usuarios.php", "buscadorUsuario", {termino:termino});
		if(result.error == 1){
			$('#data-list-bottom').hide();
			$('#data-list').css('overflow-y','scroll');
			data = result.data;
			var tabla='';
			for (var i =0; i< data.length ; i++) {
				tabla+='<div class="data-list-field"><div><p>'+data[i].nombre+'</p><small>'+data[i].apellido+'</small></div><div><p>'+data[i].cargo+'</p></div><div><p>'+data[i].email+'</p></div><div><p>'+data[i].puntos+'</p></div><div class="data-list-field-option"><em class="lnr lnr-pencil"></em></div></div>';
			}
			$('.tabla').html(tabla);
		}else{
			alert('Ocurrio un error en la consulta');
		}
	}
});
