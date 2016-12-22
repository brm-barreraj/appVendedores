
	 $('#data').jplist({				
	    itemsBox: '#data-list-fields', 
	    itemPath: '.data-list-field', 
	    panelPath: '.data-panel'	
	 });


	$( ".create-template .lnr-chevron-left").on( "click", function() {

		var template=parseInt( $(this).attr("data-template") );
		$(".create-templates div").hide();
		$(".create-templates #template-"+template).show();
		$(".create-template i").attr("data-now",template);
		$("#tipoTemplate").val(template);
		template=(template == 1) ? 3 : template-1;
		$(this).attr("data-template",template);

	});

	$( ".create-template .lnr-chevron-right").on( "click", function() {

		var template=parseInt( $(this).attr("data-template") );
		$(".create-templates div").hide();
		$(".create-templates #template-"+template).show();
		$(".create-template i").attr("data-now",template);
		$("#tipoTemplate").val(template);
		template=(template == 3) ? 1 : template+1;
		$(this).attr("data-template",template);

	});

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

$('#contenido').trumbowyg({
	 autogrow: true,
	  resetCss: true,
    btns: [
        ['viewHTML'],
        ['formatting'],
        ['removeformat'],
        ['fullscreen'],
        'btnGrp-semantic',
        ['link'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['horizontalRule'],

    ]
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
	var id = $(this).attr('data-field');
	result = sendAjax("serviceAdmin.php", "deleteNoticia", {idNoticia:id});
	if (result.error == 1){
		data = result.data;
		alert('Registro Elemininado correctamente');
		location.reload();
	}else{
		alert('Ocurrio un error en la consulta');
	}
});


( function( $, window, document, undefined )
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
$('#adenlanteSec').click(function(){
	contador++;
	$("#atrasSec").removeClass("hide");
	var nSecciones = $(".dinamico").find('.section-new').length;
	if(contador > nSecciones){
		letreroAtras = (contador == 1) ? "Contenido principal" : "Sección "+(contador-1);
		$("#atrasSec p").text(letreroAtras);
		$("#tituloCentro p").text("Seccion "+contador);
		$("#adenlanteSec p").text("Agregar sección a la noticia");

		pintarSeccion();
		$(this).find("i").removeClass("lnr-chevron-right");
		$(this).find("i").addClass("lnr-plus");
	}else if(contador == nSecciones){
		letreroAtras = (contador == 1) ? "Contenido principal" : "Sección "+(contador-1);
		$("#atrasSec p").text(letreroAtras);
		$("#tituloCentro p").text("Seccion "+contador);
		$("#adenlanteSec p").text("Agregar sección a la noticia");
		$('.section-new').hide();
		$('.dinamico').hide();
		$('.sec'+contador).show();
		$('.dinamico').show();
		$(this).find("i").removeClass("lnr-chevron-right");
		$(this).find("i").addClass("lnr-plus");
	}else{
		letreroAtras = (contador == 1) ? "Contenido principal" : "Sección "+(contador-1);
		$("#atrasSec p").text(letreroAtras);
		$("#tituloCentro p").text("Seccion "+contador);
		$("#adenlanteSec p").text("Seccion "+(contador+1));
		$('.section-new').hide();
		$('.dinamico').hide();
		$('.sec'+contador).show();
		$('.dinamico').show();
		$(this).find("i").removeClass("lnr-plus");
		$(this).find("i").addClass("lnr-chevron-right");
	}
	
	console.log(contador);
	$('#main-new').hide();
});

$('#atrasSec').click(function(){
	if (contador > 0) {
		$("#atrasSec").removeClass("hide");
		contador--;
		var nSecciones = $(".dinamico").find('.section-new').length;
		$("#adenlanteSec").find("i").removeClass("lnr-plus");
		$("#adenlanteSec").find("i").addClass("lnr-chevron-right");
		if (contador == 0) {
			$("#atrasSec").addClass("hide");
			$("#atrasSec p").text("");
			$("#tituloCentro p").text("Contenido principal");
			$("#adenlanteSec p").text("Agregar sección a la noticia");

			$('.section-new').hide();
			$('.dinamico').hide();
			$('#main-new').show();
		}else{
			letreroAtras = (contador == 1) ? "Contenido principal" : "Sección "+(contador-1);
			$("#atrasSec p").text(letreroAtras);
			$("#tituloCentro p").text("Seccion "+contador);
			$("#adenlanteSec p").text("Seccion "+(contador+1));

			$('.section-new').hide();
			$('.dinamico').hide();
			$('.sec'+contador).show();
		$('.dinamico').show();
		}	
		console.log(contador);
	}
});

function pintarSeccion(){
	
	var seccion = '';
	seccion+='<div class="section-new '+contador+' sec'+contador+'">';
	seccion+='<div class="create-fileds">';
	seccion+='<div class="create-image-area">';
	seccion+='<div class="icon-upload-new">';
	seccion+='<i class="lnr lnr-upload"></i>';
	seccion+='<i class="lnr lnr-picture"></i>';
	seccion+='</div>';
	seccion+='<input type="file" name="image'+contador+'" id="image'+contador+'" class="inputfile inputfile-3"/>';
	seccion+='<label for="image"><span>Selecciona la imagen principal de la noticia</span></label>';
	seccion+='</div>';
	seccion+='</div>';
	seccion+='<div class="create-fileds">';
	seccion+='<div class="create-field">';
	seccion+='<textarea style="background-color:white;" name="contenido'+contador+'" id="contenido'+contador+'" placeholder="Contenido sección '+contador+'"></textarea>';
	seccion+='</div>';
	seccion+='</div>';
	seccion+='</div>';


	var actual = $('.dinamico').html();
	if(actual !=''){
		$('.dinamico').append(seccion);
		//actual = actual + seccion;
	}else{
		actual = seccion;
		$('.dinamico').html(actual);
	}
		$('.section-new').show();
		$('.dinamico').show();

		for (var i = 0; i < ($('.section-new').length -1); i++) {
			var ocultar=$('.section-new').get(i);
			$(ocultar).hide();
		};

		$('#contenido'+contador).trumbowyg({
			 	autogrow: true,
			  resetCss: true,
		    btns: [
		        ['viewHTML'],
		        ['formatting'],
		        ['removeformat'],
		        ['fullscreen'],
		        'btnGrp-semantic',
		        ['link'],
		        'btnGrp-justify',
		        'btnGrp-lists',
		        ['horizontalRule'],
		    ]
		});


}

//editar 

$('#create-title-option').click(function(){
	$(".dinamic").find(".msg-dinamico").text("");
	var validDinamic=true;
	$(".dinamic").each(function(){
		if($(this).find("img").length == 0 && $(this).find("textarea").val().trim().length == 0){
			$(this).find(".msg-dinamico").text("Verifique que tenga contenido o imagen");
			if (validDinamic) {
				validDinamic = false;
			}
		}
	})
	if ($("#create").valid() && validDinamic) {
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
				alert("Guardo la noticia correctamente");
				location.reload();
			}else{
				alert("Ocurrio un error al guardar la noticia");
			}
		});
	};
});

//ocultar seccion
var manten=0;
$('.oculta').click(function(){

	var id = $(this).attr('data-ids');
	manten=id;
	result = sendAjax("serviceAdmin.php", "ocultaSeccionNoticia", {idSeccionNoticia : id});
		if (result.error == 1){
			data = result.data;
			alert('Registro Elemininado correctamente');
			//console.log(data);
			remover();
			
			//location.reload();
		}else{
			alert('Ocurrio un error en la consulta');
		}
});

function remover(){
	$('.dinamic').each(function(){
		var id = $(this).attr('data-id');
		if (id == manten) {
			$(this).remove();
		};
			
	});
}

$(document).on( "click",".data-list-field-menu", function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").show();
});

$(document).on( "click",".close", function() {
	var field=$(this).attr("data-field");
	$(".data-list-field-option[data-field='"+field+"']").hide();
});
