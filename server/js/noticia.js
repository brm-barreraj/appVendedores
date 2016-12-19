
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

	if (img) {
		var formData = new FormData(document.getElementById("create"));
		$.ajax({
				url:'serviceAdmin.php',
				method: 'POST',
				data: formData,
				cache: false,
		        contentType: false,
		        processData: false,
		        enctype: 'multipart/form-data'
		    }).success(function (data){ 
		        	if (data=='1'){
		        		jQuery("#contenedor_2").hide();
						jQuery("#contenedor_1").hide();
						jQuery("#logo_1").hide();
						jQuery("#contenedor_3").show();
						setTimeout(function(){
						location.reload();
					},6000);
		        	}else{
		        		if (data =='bad_guardar_directorio') {
		        			$("#info").addClass('error');
						$("#info").html('<span style="color:#f04124;">La imagen debe pesar menos de 1MB.</span>');
		        		}//alert('a ocurrido una falla');
		        	}
		        		console.log(data);
		        	
		        		
		        	
		        });
	}
});
