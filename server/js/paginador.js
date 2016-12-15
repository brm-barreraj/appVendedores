$('.num').click(function(){
	var num = $(this).attr('id');
	var pagI = (num==1)? 1 : (num*10)-9;
	var pagF = pagI+9;
	$('#pagI').html(pagI);
	$('#pagF').html(pagF);
	$.ajax({
		dataType:'json',
		type:'POST',
		url:'goUsuarios.php',
		data:{
			control:'paginar',
			pagina:num,
		},
		success:function(data){
			var tabla='';
			for (var i =0; i< data.length ; i++) {
				tabla+='<div class="data-list-field"><div><p>'+data[i].nombre+'</p><small>'+data[i].apellido+'</small></div><div><p>'+data[i].cargo+'</p></div><div><p>'+data[i].email+'</p></div><div><p>'+data[i].puntos+'</p></div><div class="data-list-field-option"><em class="lnr lnr-pencil"></em></div></div>';
			}
			$('.tabla').html(tabla);
		}
	});
});