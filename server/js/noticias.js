
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
		var valid = $('#create').valid();
	if (img && valid ) {
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

//cargar subcategorias con base a la categoria seleccionado
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

//eleminiar

$('.eliminar').click(function(){
	var id = $(this).attr('data-id');
	result = sendAjax("serviceAdmin.php", "deleteNoticia", {idNoticia:id});
	if (result.error == 1){
		data = result.data;
		alert('Registro Elemininado correctamente');
	}else{
		alert('Ocurrio un error en la consulta');
	}
});


;( function( $, window, document, undefined )
{
	$( '.inputfile' ).each( function()
	{
		var $input	 = $( this ),
			$label	 = $input.next( 'label' ),
			labelVal = $label.html();

		$input.on( 'change', function( e )
		{
			var fileName = '';

			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else if( e.target.value )
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				$label.find( 'span' ).html( fileName );
			else
				$label.html( labelVal );
		});

		// Firefox bug fix
		$input
		.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
		.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
	});
})( jQuery, window, document );


var contador = 0;
$('.lnr-plus').click(function(){
	if(contador > 0){
		$('.lnr-chevron-left').attr('data-pos','contador');
		$('.'+ contador +'').hide();
	}
	contador++;
	$('#main-new').hide();
	pintarSeccion();
});

function pintarSeccion(){
	
	var seccion = '<div class="section-new '+contador+'"><div class="create-field"><div style="padding: 2% 3%;font-family: col-thin; font-size: 12px; color: #fff;">Imagen Contenido</div> <input type="file" name="image'+contador+'" id="image'+contador+'" placeholder="Imagen"> </div> <div class="create-field"> <textarea style="background-color:white;" name="contenido'+contador+'" id="contenido'+contador+'" placeholder="Contenido noticia"></textarea></div></div>';
	var actual = $('.dinamico').html();
	if(actual !=''){
		actual = actual + seccion;
	}else{
		actual = seccion;
	}
		$('.dinamico').html(actual);
		$('.section-new').show();
		for (var i = 0; i < ($('.section-new').length -1); i++) {
			var ocultar=$('.section-new').get(i);
			$(ocultar).hide();
		};

}

function retroceder(){

}