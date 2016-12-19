/*
*función que valida el formulario de preventas octubre
*(campos: nombre, email, cedula, y numero de contacto.)
*/


/*comienza verificando que la pagina haya cargado totalmente*/
jQuery(document).ready(function () {
	/*se agrega un metodo de validacion llamdo string; se encarga de
	* validar que las cadenas de caracteres ingresadas no contengan
	* caracteres especiales.
	*/
	jQuery.validator.addMethod("string", function(value, element)
    {
        return this.optional(element) || /^[a-z" "ñÑáéíóúÁÉÍÓÚ,.;]+$/i.test(value);
    });

	/*aquí comienza la validacion campo por campo, esta validacion
	*se efectua a traves de la libreria jquery.validate*/

		jQuery("#create").validate({
			rules: {
				titulo:{
					required: true,
					minlength: 2,
					maxlength: 150
				},
				subtitulo:{
					required: true,
					minlength: 2,
					maxlength: 150
				},

				idCategoria: {
					required: true,
					number: true,
					minlength: 1,
					maxlength: 10
				},
				/*idSubCategoria:{
					required: true,
					email: true,
				},*/
				/*celular:{
					required: true,
					number: true,
					minlength: 10,
					maxlength: 15,
				},
				idPais:{
					required: true,
				},
				ciudad:{
					required: true,
				},
				sexo:{
					required:true,
				},
				terminos:{
					required: true,
				},
				politica:{
					required: true,
				},*/
				/*otroDepto:{
					required:true,
					minlength: 3,
					maxlength: 50
				},
				otroCiudad:{
					required:true,
					minlength: 3,
					maxlength: 50
				}*/


			},
			messages: {
				titulo:{
					required:'Campo necesario',
					minlength: 'Titulo corto en longitud',
					maxlength:'Titulo muy largo',
					
				},
				subtitulo:{
					required: 'Campo necesario',
					minlength: 'Subtitulo corto en longitud',
					maxlength: 'Subtitulo muy largo',
					
				},

				idCategoria:{
					required:'Campo necesario',
					number: 'Únicamente admite digitos (0-9)',
					minlength:'Número muy corto',
					maxlength: 'Número muy largo',
				},
				/*fecha:{
					required: 'Campo necesario',
					date: 'Formato de fecha no válido',
				},
				email:{
					required: 'Campo necesario',
					email: 'Formato de correo electrónico no válido',
				},
				celular:{
					required: 'Campo necesario',
					number: 'Únicamente admite digitos (0-9)',
					minlength:'Debe ser mayor a 10 dígitos',
					maxlength: 'Debe ser menor a 15 dígitos',
				},
				idPais:{
					required: 'Campo necesario',
				},
				sexo:{
					required:'Campo necesario',
				},
				ciudad:{
					required: 'Campo necesario',
				},
				terminos:{
					required: 'Campo necesario',
				},
				politica:{
					required: 'Campo necesario',
				},*/
				/*otroDepto:{
					required:'Campo necesario',
					minlength:'El nombre del departamento es muy corto',
					maxlength:'El nombre del departamento largo',

				},
				otroCiudad:{
					required:'Campo necesario',
					minlength:'El nombre de la ciudad es muy corto',
					maxlength:'El nombre de la ciudad largo',

				}*/

			}
		});

			/*inicia validacion cedula*/
		jQuery('#cedula').change(function(){
			var cc=jQuery("#cedula").val();

			var url='GuardarRegistro.php';
			jQuery.ajax({
				dataType:'json',
				type:'POST',
				url:url,
				data:{
					cc:cc,
					ac:'verificarcc',
					varCtrl:'1'
				},
				beforeSend:function(){
					jQuery(".cargando:first").show();
				},
				success:function(data){
					jQuery(".cargando").hide();
					jQuery('#ccerror').hide();
					if(data){
						jQuery('#ccerror').show();
					}
				}
			});
		});

		/*finaliza validacion cedula*/

		/*inicia validacion email*/
		jQuery('#email').change(function(){
			var em=jQuery("#email").val();

			var url='GuardarRegistro.php';
			jQuery.ajax({
				dataType:'json',
				type:'POST',
				url:url,
				data:{
					em:em,
					ae:'verificarem',
					varCtrl:'2'
				},
				beforeSend:function(){
					jQuery(".cargando:last").show();
				},
				success:function(data){
					jQuery(".cargando").hide();
					jQuery('#emerror').hide();
					if(data){
						jQuery('#emerror').show();
					}
				}
			});
		});
		/*finaliza validacion email*/

		/*inicia importacion de las ciudades que pertenece al pais seleccionado*/
		/*valida si el pais seleccionado es colombia si no cambia el select por un input text*/
		jQuery('#pais').change(function(){
			var p= jQuery('#pais').val();
			if(p !='46'){
				jQuery(".deptos").hide()
				jQuery("#ciudad").replaceWith('<input type="text" name="ciudad" id="ciudad" placeholder="Ingresa tu departamento">');
			}else{
				jQuery('.deptos').show();
				jQuery("#ciudad").replaceWith('<select name="idCiudad" id="ciudad"> </select>');
			}

		});
		/*finaliza importacion de las ciudades que pertenece al pais seleccionado*/

		/*inicia metodo para traer las ciudades*/
		jQuery("#depto").change(function(){
			var depto=jQuery('#depto').val();
			var url='GuardarRegistro.php';

			/*Despliega campo otro en departamento y ciudad/
			if(depto=='otro'){
				jQuery('.deptos').append('<input type="text" name="otroDepto" id="otroDepto" required="Campo requerido" placeholder="Ingresa tu departamento">');
				jQuery("#ciudad").replaceWith('<input type="text" name="ciudad" id="ciudad" required="Campo requerido" placeholder="Ingresa tu ciudad">');
			}else{
				jQuery('#otroDepto').remove();
				jQuery("#ciudad").replaceWith('<select name="idCiudad" id="ciudad"> </select>');
			}

			/*Despliega campo otro en departamento y ciudad*/

			jQuery.ajax({
				dataType:'json',
				type:'POST',
				url:url,
				data:{
					depto:depto,
					ad:'depto',
					varCtrl:'3'
				},

				success:function(data){
					var totalCiudades=data.length;
					var ciudades="";
					ciudades+="<option value='default'>Seleccione la ciudad</option>";
					for(f=0; f<totalCiudades; f++)
						{
							ciudades+="<option value="+data[f].idCiudad+">"+data[f].nombre+"</option>";
						}
						//ciudades+="<option value='otroC'>OTRO</option>";

						jQuery('#ciudad').html(ciudades);
						jQuery("#ciudad").removeAttr("disabled");
					}

			});

			/*Ciudad/
			jQuery("#ciudad").change(function(){
				var city=jQuery('#ciudad').val();
				console.log(city);
				if(city=='otroC'){
				jQuery('.city').append('<input type="text" name="otroCiudad" id="otroCiudad" required="Campo requerido" placeholder="Ingresa tu ciudad">');
			}else{
				jQuery('#otroCiudad').remove();
			}
			});
			/*Ciudad*/

		});
		/*finaliza metodo para traer las ciudades*/
		/*Despliega campo otro en departamento*/

		/*Fin campo otro departamento*/
		/*Despliega campo otro en Ciudades*/
		/*Fin campo otro Ciudades*/



		/*envia formulario validado*/
		jQuery("#enviar").click(function(){

			if( jQuery("#msform").valid() ){
		        var edad = new Date($("#anio").val(),$("#mes").val(),$("#dia").val());
		        var fecha = new Date ();
		        if(edad>fecha){
			        $("#errorEdad").show();
	                Animar('fechaNacimiento', 'wobble');
		        }else{

		        var url="GuardarRegistro.php";
		        var datos = $( "#msform" ).serialize();
				jQuery.ajax({
					type:"POST",
					url:url,
					data:datos,
					beforeSend:function (argument) {
						jQuery(".loading").show();
					},
					success:function(data){
						jQuery(".loading").hide();
						if (data=="1") {
							window.location="Historia.php";
						} else{
							console.log(data);
						};
					}
				});
		        }
				return false;
			} else {
				return false;
			}
			return false;

		});

});
function justAnio(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum >= 48) && (keynum <= 57)) {
        var number = [];
        number[48] = "0";
        number[49] = "1";
        number[50] = "2";
        number[51] = "3";
        number[52] = "4";
        number[53] = "5";
        number[54] = "6";
        number[55] = "7";
        number[56] = "8";
        number[57] = "9";
        valor = $('#anio').val() + number[keynum];
        log = valor.toString().length;
        valor = parseInt(valor);
        if (log== 4) {
            if (valor >= 1900 && valor <= 2015) {
                $('#anio').val(valor);
            } else {
                $('#anio').val("").removeAttr('disabled');

            }
        }else{
          if(log<4){
              return true;
            }else{
              Animar('anio','wobble');
              return false;
            }
        }
        return true;

    } else {
      Animar('anios', 'wobble');
        return /\d/.test(String.fromCharCode(keynum));
    }
}

function justMes(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    var valor = "";
    var number = [];
    number[48] = "0";
    number[49] = "1";
    number[50] = "2";
    number[51] = "3";
    number[52] = "4";
    number[53] = "5";
    number[54] = "6";
    number[55] = "7";
    number[56] = "8";
    number[57] = "9";
    if ((keynum >= 48) && (keynum <= 57)) {
        //es numero
        valor = $('#mes').val()+number[keynum];
        log = valor.toString().length;
        valor = parseInt(valor);

       // console.log(valor);
        if (log == 2 && valor > 0 && valor < 13) {
            $('#mes').val($('#mes').val()+number[keynum]);
            return true;
        } else {
            if(log==1){
              return true;
            }else{
              Animar('mes','wobble');
              return false;
            }
        }
    } else {
        $('#mes').val('');
        return /\d/.test(String.fromCharCode(keynum));
    }
}

function justDia(e) {
  //verifica que el mes este completo
    var valor = $('#mes').val();
    var log = valor.toString().length;
    if(log==1){
      $('#mes').val("0"+$('#mes').val());
    }
    var keynum = window.event ? window.event.keyCode : e.which;
    var valor = "";
    var number = [];
    number[48] = "0";
    number[49] = "1";
    number[50] = "2";
    number[51] = "3";
    number[52] = "4";
    number[53] = "5";
    number[54] = "6";
    number[55] = "7";
    number[56] = "8";
    number[57] = "9";
    if ((keynum >= 48) && (keynum <= 57)) {
        //es numero
        valor = $('#dia').val() + number[keynum];
        log = valor.toString().length;
        console.log(log);
        if (log == 2) {
            valor = parseInt(valor);
            var mes = parseInt($('#mes').val());
            console.log("mes"+mes);
            var mayor = 0;
            switch (mes) {
                case 1:
                    mayor = 31;
                    break;
                case 2:
                    if (EsBisiesto(parseInt($('#anio').val()))) {
                        mayor = 29;
                    } else {
                        mayor = 28;
                    }
                break;
                case 3:
                    mayor = 31;
                    break;
                case 4:
                    mayor = 30;
                    break;
                case 5:
                    mayor = 31;
                    break;
                case 6:
                    mayor = 30;
                    break;
                case 7:
                    mayor = 31;
                    break;
                case 8:
                    mayor = 31;
                    break;
                case 9:
                    mayor = 30;
                    break;
                case 10:
                    mayor = 31;
                    break;
                case 11:
                    mayor = 30;
                    break;
                case 12:
                    mayor = 31;
                    break;

            }
            console.log(mayor);
            if (valor > 0 && valor <= mayor) {
                //Dia valido
                $('#dia').val($('#dia').val());
            } else {
                //Fecha Invalida
                Animar('dia', 'wobble');
                return false;

            }
        } else {
            return true;
        }
    } else {
        $('#dia').val('');
        return /\d/.test(String.fromCharCode(keynum));
    }
}

function EsBisiesto(anio) {
    var resultado;
    //Comprobamos la regla general.
    //Si anio es divisible por 4, es decir, si el
    //resto de la división entre 4 es 0...
    if (anio % 4 == 0) {
        //Si es divisible por 4, ahora toca comprobar
        //la excepción
        if (
            (anio % 100 == 0) && //Si es divisible por 100
            (anio % 400 != 0) //y no por 400
        ) {
            resultado = false; //entonces no es bisiesto
        } else {
            resultado = true; //No cumple la excepción.
            //Lo dejamos como bisiesto por ser divisible por 4
        }
    } else //Si no cumple la regla general
    {
        //No es bisiesto.
        resultado = false;
    }
    return resultado;
}

function Animar(id, x) {
    $('#' + id).addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass(x + ' animated');
    });
};