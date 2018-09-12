/*
    * Funciones generales para el aplicativo
*/

//variable global para determinar si se estan mostrando los hints d elos tutos o no
var tutorialesActivos = 0;


/*
 * Funcion mostrar video tutorial y darle play
 */
function playVideoTutorial(){
	
	$("#div_videoTutorial").show("slower",function() {
    		mostrarHints();
  		});
	$('#videoTutorial_personalizados').get(0).play();
	
}
//---

/*
 * Funcion para cerrar el video tutorial
 */
function cerrarVideoTutorial(){
	$('#videoTutorial_personalizados').get(0).pause();
	$("#div_videoTutorial").hide("slower",function() {
    		mostrarHints();
  		});
}


/*hins tutorials*/
function mostrarAyudas(){
	
	if(tutorialesActivos == 0){
		tutorialesActivos = 1;
		var intro = introJs();
		intro.refresh();
		intro.addHints();
		intro.showHints();
	}else{
		var intro = introJs();
		intro.refresh();
		intro.hideHints();
		tutorialesActivos = 0;
		$(".introjs-hints").remove();
	}
		
	

}
//---

//funcion para comprobar si se muestran los hinst ocultos
function mostrarHints(){
	
	if(tutorialesActivos == 1){
		
		$(".introjs-hints").remove();
		var intro = introJs();
		intro.refresh();
		intro.showHints();
	}
	
}
//---


//funcion para refrescar sesion y no se pierda el login
function refresSession(){
	
	$.ajax({
      		url: "http://www.nanuvet.com/Config/sessionViva.php",
            dataType: "html",
            type : 'POST',
            data: {},
            success: function(data) {
                 
            }
      	});
	
}
//---

//funcion para mostrar la barra de busqueda
function motrarBarraBusqueda(){
    
    $("#barraBusqueda").show("slow");
    $("#input_busqueda").val("");
    $("#input_busqueda").focus();
    $('.button-collapse').sideNav('hide');
    
}
//---

//funcion para ocultar la barra de busqueda
function ocultarBarraBusqueda(){
    
    $("#input_busqueda").val("");
    $("#barraBusqueda").hide("slow");
}
//---


//buscar pais al escribir
function buscarPais(){
   

    $('#pais').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/paises/buscarPais.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarPais : request.term//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPais").val(ui.item.id); 	
				//cuando se elige un pais, se habilita el campo para buscar una ciodad
				$( "#iconoNuevaCiudad" ).show("show");
				//se habilita el campo para que s epueda digitar
				$("#ciudad").prop('disabled', false);
				//se lleva el nombre del país al texto del modal
				$("#nombrePaisSeleccionado").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
   
   
    
}
//---

//buscar ciudad al escribir
function buscarCiudad(){
   

    $('#ciudad').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/ciudades/buscarCiudad.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringCiudad : request.term,//se envia el string a buscar
	            	    idPais : $("#idPais").val()//se envia el id del pais seleccionado
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idCiudad").val(ui.item.id); 	
				//cuando se elige una ciudad, se habilita el campo para buscar un barrio
				$( "#iconoNuevoBarrio" ).show("show");
				//se habilita el campo para que se pueda digitar
				$("#barrio").prop('disabled', false);
				//se lleva el nombre del país al texto del modal
				$("#nombreCiudadSeleccionada").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
   
   
    
}
//---



//funcion para validar el guardado en una ciudad
function guardarNuevaCiudad(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#nuevaCiudad").val().trim().length  == 0 ){
		
	//	$('#label_nuevaCiudad').attr('data-error', ciudades[0]); 
		
		$("#label_nuevaCiudad").addClass( "active" );
		$("#nuevaCiudad").addClass( "invalid" );
		sw = 1;
	}


	if( $("#idPais").val() == '0' ){
		
		$('#label_nuevaCiudad').attr('data-error', ciudades[1]); 
		
		$("#label_nuevaCiudad").addClass( "active" );
		$("#nuevaCiudad").addClass( "invalid" );
		sw = 1;
	}
	
	
	if(sw == 1){
		return false;
	}else{
		
		//se valida si la ciudad existe o de lo contrario se guarda
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/ciudades/guardarCiudad.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    idPais : $("#idPais").val(), nombreCiudad : $("#nuevaCiudad").val()
            	},
            success: function(data) {
                 
                 if(data == "Existe!"){
                 	
                 	$('#label_nuevaCiudad').attr('data-error', ciudades[0]); 
		
					$("#label_nuevaCiudad").addClass( "active" );
					$("#nuevaCiudad").addClass( "invalid" );
                 	
                 }else{
                 	
                 	
                 	$("#label_nuevaCiudad").removeClass( "active" );
					$("#nuevaCiudad").removeClass( "invalid" );
					$("#nuevaCiudad").val("");
                 	$('#modal_nuevaCiudad').closeModal();
                 	Materialize.toast(ciudades[2], 4000);
                 	
                 }
                 
                 
            }
      	});
		
	}
	
	
}
//---


//buscar barrio al escribir
function buscarBarrio(){
   

    $('#barrio').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/barrios/buscarBarrio.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBarrio : request.term,//se envia el string a buscar
	            	    idCiudad : $("#idCiudad").val()//se envia el id de la ciudad seleccionada
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idBarrio").val(ui.item.id); 	
				//se lleva el nombre de la ciudad al texto del modal del barrio
				$("#nombreCiudadSeleccionada").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para validar el guardado de un barrio
function guardarNuevoBarrio(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#nuevoBarrio").val().trim().length  == 0 ){
		
		$("#label_nuevoBarrio").addClass( "active" );
		$("#nuevoBarrio").addClass( "invalid" );
		sw = 1;
	}


	if( $("#idCiudad").val() == '0' ){
		
		$('#label_nuevoBarrio').attr('data-error', barrios[1]); 
		
		$("#label_nuevoBarrio").addClass( "active" );
		$("#nuevoBarrio").addClass( "invalid" );
		sw = 1;
	}
	
	
	if(sw == 1){
		return false;
	}else{
		
		//se valida si el barrio existe o de lo contrario se guarda
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/barrios/guardarBarrio.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    idCiudad : $("#idCiudad").val(), nombreBarrio : $("#nuevoBarrio").val()
            	},
            success: function(data) {
                 
                 if(data == "Existe!"){
                 	
                 	$('#label_nuevoBarrio').attr('data-error', barrios[0]); 
		
					$("#label_nuevoBarrio").addClass( "active" );
					$("#nuevoBarrio").addClass( "invalid" );
                 	
                 }else{
                 	
                 	
                 	$("#label_nuevoBarrio").removeClass( "active" );
					$("#nuevoBarrio").removeClass( "invalid" );
					$("#nuevoBarrio").val("");
                 	$('#modal_nuevoBarrio').closeModal();
                 	Materialize.toast(barrios[2], 4000);
                 	
                 }
                 
                 
            }
      	});
		
	}
	
	
}
//---


//funcion para marcar un tutorial como completo
function introCompleto(idIntro){
	
	//se actualiza el estado del tutorial mediante un ajax
	$.ajax({
      		url: "http://www.nanuvet.com/Shop/ShopControllers/actualizarIntroTutorial.php",
            dataType: "html",
            type : 'POST',
            data: {idIntro: idIntro, estado: 'I'},
            success: function(data) {
            	if(data == 'OK'){
            		Materialize.toast('<i class="fa fa-thumbs-up" aria-hidden="true"></i>', 4000);    
            	}
				             
            }
      	});
	
}
//---


//funciones para calcular la edad
/**
 * Funcion que devuelve true o false dependiendo de si la fecha es correcta.
 * Tiene que recibir el dia, mes y año
 */
function isValidDate(day,month,year)
{
    var dteDate;
 
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/**
 * Funcion para validar una fecha
 * Tiene que recibir:
 *  La fecha en formato ingles yyyy-mm-dd
 * Devuelve:
 *  true-Fecha correcta
 *  false-Fecha Incorrecta
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}
 
/**
 * Esta función calcula la edad de una persona y los meses
 * La fecha la tiene que tener el formato yyyy-mm-dd que es
 * metodo que por defecto lo devuelve el <input type="date">
 */
function calcularEdad(fecha){
    //var fecha=document.getElementById("user_date").value;
    if(validate_fecha(fecha)==true){
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];
 
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth()+1;
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < mes )
        {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }
 
        // calculamos los meses
        var meses=0;
        if(ahora_mes>mes)
            meses=ahora_mes-mes;
        if(ahora_mes<mes)
            meses=12-(mes-ahora_mes);
        if(ahora_mes==mes && dia>ahora_dia)
            meses=11;
 
        // calculamos los dias
        var dias=0;
        if(ahora_dia>dia)
            dias=ahora_dia-dia;
        if(ahora_dia<dia)
        {
            ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
            dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
        }
 		
 		$("#hidden_errorFecha").val('0');
 		return ({"years":edad,"months":meses,"days":dias});
 		
    }else{
        document.getElementById("resultadoFechas").innerHTML="Error "+fecha;
        $("#hidden_errorFecha").val('1');
    }
}
//--- FIn funciones para calcular la edad


//funcion para validar si una fecha es mayor a otra
function validate_fechaMayorQue(fechaInicial,fechaFinal){
            valuesStart=fechaInicial.split("/");
            valuesEnd=fechaFinal.split("/");
            
 
            // Verificamos que la fecha no sea posterior a la actual
            var dateStart=new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
            var dateEnd=new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
            if(dateStart>dateEnd){
                return 0;
            }
            return 1;
        }

//funcion para realizar la busqueda de un paciente o un propietario en la barra de busqueda
function buscarPacientePropietario(){
	
	 $('#input_busqueda').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarPropietario.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    buscarPropietario : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        	
        	window.location.href = "http://www.nanuvet.com/nuevo/"+ui.item.id+"/";
        		
        			   			
        }
    	
  	}); 
   
	
}
//---

//funcion para permitir escribir numeros puntos y guiones
function soloNumerosPuntosGuiones(e){
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57)||(key==46)||(key==45)||(key==8)||(key==0))
}
//---

//funcion para permitir escribir numeros puntos
function soloNumerosPuntos(e){
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57)||(key==46)||(key==8)||(key==0))
}
//---

//funcion para permitir escribir numeros dos puntos
function soloNumerosDosPuntos(e){
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57)||(key==58)||(key==8)||(key==0))
}
//---

//funcion para permitir escribir numeros
function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57)||(key==8)||(key==0))
}
//---


//para dar formato a los numeros con puntuacion de miles y de decimales
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
 num +='';
 var splitStr = num.split('.');
 var splitLeft = splitStr[0];
 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
 var regx = /(\d+)(\d{3})/;
 while (regx.test(splitLeft)) {
 splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
 }
 return this.simbol + splitLeft +splitRight;
 },
 new:function(num, simbol){
 this.simbol = simbol ||'';
 return this.formatear(num);
 }
}

