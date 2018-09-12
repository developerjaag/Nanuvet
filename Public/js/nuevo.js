/*
 * Funciones para validar la creación de un propietario y un paciente
 */

$(document).ready(function () {

			$('.datetimepicker').datetimepicker({
				dayOfWeekStart : 1,
				lang:'es',
				timepicker: false,
				mask:true,
				formatDate:'Y/m/d',
				format: 'Y/m/d',
				 maxDate:'+1970/01/01',//tomorrow is maximum date calendar
				onSelectDate: function (date) {
		            calcularTiempoDeVida(date,'resultadoFechas')
		        }
								
			 });
			 
			 var theLanguage = $('html').attr('lang');
			 
			 switch(theLanguage) {
				    case 'Es':
				        $.datetimepicker.setLocale('es');
				        break;
				    case 'En':
				        $.datetimepicker.setLocale('en');
				        break;
				    default:
				        $.datetimepicker.setLocale('es');
				}
			 
			 


});

function calcularTiempoDeVida(date, idElementoMostrarResultado){
	
	//se arma la fecha elegida
	var d = new Date(date);	
	//var mes = d.getMonth()+1;
	var ano	= d.getFullYear();
	var mes = d.getMonth()+1;
	var dia = d.getDate();
	
	
	var fecha = ano+'-'+mes+'-'+dia;
	
	
	//se arma la fecha actual
	var dd = new Date();	
	var aano	= dd.getFullYear();
	var ames    = dd.getMonth()+1;
	var adia    = dd.getDate();
	
	
	  var theLanguage = $('html').attr('lang');
		 
	 switch(theLanguage) {
		    case 'Es':
		        	var errofechaMayor	= "Error!.La fecha es mayor";
		        break;
		    case 'En':
		        	var errofechaMayor	= "Error! .The Date is greater";
		        break;
		    default:
		        	var errofechaMayor	= "Error!.La fecha es mayor";
		}
	
	//validar si la fecha ingresada es mayor a la actual
	var fechaFinal = adia+'/'+ames+'/'+aano;
	var fechaInicial = dia+'/'+mes+'/'+ano;
	
	
	if(validate_fechaMayorQue(fechaInicial,fechaFinal) == 0){
            document.getElementById(idElementoMostrarResultado).innerHTML=errofechaMayor;
            $("#hidden_errorFecha").val('1');
            return false;
        }else{
        	$("#hidden_errorFecha").val('0');
        }


	  var result = calcularEdad(fecha);  
	  var json = JSON.stringify(result);
	  json = JSON.parse(json);	  
			 
		 switch(theLanguage) {
			    case 'Es':
			        document.getElementById(idElementoMostrarResultado).innerHTML = json.years+' años, '+ json.months+' meses y '+json.days+' días.';
			        break;
			    case 'En':
			        document.getElementById(idElementoMostrarResultado).innerHTML = json.years+' years, '+ json.months+' months and '+json.days+' days.';
			        break;
			    default:
			        document.getElementById(idElementoMostrarResultado).innerHTML = json.years+' años, '+ json.months+' meses y '+json.days+' días.';
			}
	  
	
}
//---


function ValidarDatosNuevoPropietario(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	
	if( $("#propietario_identificacion").val().trim().length == 0 ){
		
		$("#label_propietario_identificacion").addClass( "active" );
		$("#propietario_identificacion").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#propietario_nombre").val().trim().length == 0 ){
		
		$("#label_propietario_nombre").addClass( "active" );
		$("#propietario_nombre").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_apellido").val().trim().length == 0 ){
		
		$("#label_propietario_apellido").addClass( "active" );
		$("#propietario_apellido").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_telefono").val().trim().length == 0 ){
		
		$("#label_propietario_telefono").addClass( "active" );
		$("#propietario_telefono").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_celular").val().trim().length == 0 ){
		
		$("#label_propietario_celular").addClass( "active" );
		$("#propietario_celular").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_direccion").val().trim().length == 0 ){
		
		$("#label_propietario_direccion").addClass( "active" );
		$("#propietario_direccion").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_email").val().trim().length == 0 ){
		
		$("#label_propietario_email").addClass( "active" );
		$("#propietario_email").addClass( "invalid" );
		sw = 1;
	}else if($("#propietario_email").val().indexOf('@', 0) == -1 || $("#propietario_email").val().indexOf('.', 0) == -1) {
            $("#label_propietario_email").addClass( "active" );
			$("#propietario_email").addClass( "invalid" );
			sw = 1;
        }	
	
	if( $("#idPais").val() == '0' ){
		
		$("#label_propietario_pais").addClass( "active" );
		$("#pais").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#idCiudad").val() == '0' ){
		
		$("#label_propietario_ciudad").addClass( "active" );
		$("#ciudad").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#idBarrio").val() == '0'){
		
		$("#label_propietario_barrio").addClass( "active" );
		$("#barrio").addClass( "invalid" );
		sw = 1;
	}		
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoPropietario").submit();
	}

	
}
//---

//funcion para mostrar el div de editar propietario
function mostrarFormEditarPropietario(){
	$("#hideFormEditarpropietario").show('slower');
}
//---

//funcion para ocultar el div de editar propietario
function ocultarFormEditarPropietario(){
	$("#hideFormEditarpropietario").hide('slower');
}
//---


//funcion para mostrar el formulario del nuevo paciente
function mostrarFormNuevoPaciente(){
	
	$("#hideFormPaciente").show('slower');
	
}
//---

//funcion para cancelar la creación d eun nuevo paciente
function cancelarCreacionPaciente(){
	
	//se limpian los campos
	$("#idEspecie").val("");
	$("#idRaza").val("");
	$("#idReplica").val("0");
	$("#paciente_nombre").val("");
	$("#paciente_chip").val("");
	$("#paciente_especie").val("");
	$("#paciente_raza").val("");
	
	//se limpian los checkbox del div
	$('#hideFormPaciente :checked').removeAttr('checked');
	
	$("#fechaNacimiento").val("");
	$("#resultadoFechas").html("&nbsp;");
	$("#paciente_color").val("");
	$("#paciente_alimento").val("");
	$("#frecuenciaAlimento").val("0");
	$("#paciente_bano").val("");
	$("#filePath").val("");
	
	//se remueve las clases activas
	$("#label_paciente_nombre").removeClass("active");
	$("#label_paciente_chip").removeClass("active");
	$("#label_paciente_especie").removeClass("active");
	$("#label_paciente_raza").removeClass("active");
	$("#label_paciente_alimento").removeClass("active");
	$("#label_paciente_bano").removeClass("active");
	
	var foto = $("#fotoPaciente");
	foto.replaceWith( foto = foto.clone( true ) );

	$("#paciente_nombre").removeClass("valid");
	$("#paciente_chip").removeClass("valid");
	$("#paciente_especie").removeClass("valid");
	$("#label_paciente_raza").removeClass("valid");
	$("#paciente_raza").removeClass("valid");
	$("#paciente_color").removeClass("valid");	
	$("#paciente_alimento").removeClass("valid");
	$("#paciente_bano").removeClass("valid");
	$("#filePath").removeClass("valid");
	$("#fechaNacimiento").removeClass("valid");


	$("#paciente_nombre").removeClass("invalid");
	$("#paciente_chip").removeClass("invalid");
	$("#paciente_especie").removeClass("invalid");
	$("#label_paciente_raza").removeClass("invalid");
	$("#paciente_raza").removeClass("invalid");
	$("#paciente_color").removeClass("invalid");	
	$("#paciente_alimento").removeClass("invalid");
	$("#paciente_bano").removeClass("invalid");
	$("#fechaNacimiento").removeClass("invalid");

	$("#mensajeErrorCheckMostrar").html("&nbsp;");

	$("#hideFormPaciente").hide('slower');
	
}
//---



//funcion para buscar una especie
function buscarEspecie(){
	
	 $('#paciente_especie').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarEspecie.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarEspecie : request.term//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idEspecie").val(ui.item.id); 	
				//cuando se elige una especie, se habilita el campo para buscar una raza
				$( "#iconoNuevaRaza" ).show("show");
				//se habilita el campo para que se pueda digitar
				$("#paciente_raza").prop('disabled', false);
				//se lleva el nombre de la especie al texto del modal
				$("#nombreEspecieSeleccionada").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
	
	
}
//---



//funcion para buscar una especie en editar
function editarBuscarEspecie(){
	
	 $('#editarPacinete_paciente_especie').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarEspecie.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarEspecie : request.term//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#editarPacinete_idEspecie").val(ui.item.id); 	
				$("#idEspecie").val(ui.item.id); 	
				//cuando se elige una especie, se habilita el campo para buscar una raza
				$( "#editarIconoNuevaRaza" ).show("show");
				//se habilita el campo para que se pueda digitar
				$("#editarPacinete_paciente_raza").prop('disabled', false);
				//se lleva el nombre de la especie al texto del modal
				$("#nombreEspecieSeleccionada").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
	
	
}
//---







//funcion para validar el guardado en una especie
function guardarNuevaEspecie(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#nuevaEspecie").val().trim().length == 0 ){
				
		$("#label_nuevaEspecie").addClass( "active" );
		$("#nuevaEspecie").addClass( "invalid" );
		sw = 1;
	}
	
	
	if(sw == 1){
		return false;
	}else{
		
		//se valida si la especie existe o de lo contrario se guarda
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/nuevo/guardarEspecie.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    nombreEspecie : $("#nuevaEspecie").val()
            	},
            success: function(data) {
                 
                 if(data == "Existe!"){
                 	
                 	$('#label_nuevaEspecie').attr('data-error', especies[0]); 
		
					$("#label_nuevaEspecie").addClass( "active" );
					$("#nuevaEspecie").addClass( "invalid" );
                 	
                 }else{
                 	
                 	
                 	$("#label_nuevaEspecie").removeClass( "active" );
					$("#nuevaEspecie").removeClass( "invalid" );
					$("#nuevaEspecie").val("");
                 	$('#modal_nuevaEspecie').closeModal();
                 	Materialize.toast(especies[1], 4000);
                 	
                 }
                 
                 
            }
      	});
		
	}
	
	
}
//---

//funcion para buscar una raza
function editarBuscarRaza(){

	 $('#editarPacinete_paciente_raza').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarRaza.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarRaza : request.term,//se envia el string a buscar
	            	    idEspecie		 : $("#editarPacinete_idEspecie").val()
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#editarPacinete_idRaza").val(ui.item.id); 	
				//cuando se elige una especie, se habilita el campo para buscar una raza
				//se lleva el nombre de la raza al texto del modal
				$("#nombreRazaSeleccionado").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
	
}
//---



//funcion para buscar una raza
function buscarRaza(){

	 $('#paciente_raza').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarRaza.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarRaza : request.term,//se envia el string a buscar
	            	    idEspecie		 : $("#idEspecie").val()
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idRaza").val(ui.item.id); 	
				//cuando se elige una especie, se habilita el campo para buscar una raza
				//se lleva el nombre de la raza al texto del modal
				$("#nombreRazaSeleccionado").html(ui.item.nombre );
        			   			
        }
    	
  	}); 
	
}
//---




//funcion para validar el guardado en una raza
function guardarNuevaRaza(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#nuevaRaza").val().trim().length == 0 ){
				
		$("#label_nuevaRaza").addClass( "active" );
		$("#nuevaRaza").addClass( "invalid" );
		sw = 1;
	}
	
	
	if(sw == 1){
		return false;
	}else{
		
		//se valida si la ciudad existe o de lo contrario se guarda
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/nuevo/guardarRaza.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    nombreRaza : $("#nuevaRaza").val(),
            	    idEspecie  : $("#idEspecie").val()
            	},
            success: function(data) {
                 
                 if(data == "Existe!"){
                 	
                 	$('#label_nuevaRaza').attr('data-error', razas[0]); 
		
					$("#label_nuevaRaza").addClass( "active" );
					$("#nuevaRaza").addClass( "invalid" );
                 	
                 }else{
                 	
                 	
                 	$("#label_nuevaRaza").removeClass( "active" );
					$("#nuevaRaza").removeClass( "invalid" );
					$("#nuevaRaza").val("");
                 	$('#modal_nuevaRaza').closeModal();
                 	Materialize.toast(razas[1], 4000);
                 	
                 }
                 
                 
            }
      	});
		
	}
	
	
}
//---


//funcion para validar que el guardado de un nuevo paciente
function validarGuardarPaciente(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idEspecie").val().trim().length == 0 ){
				
		$("#label_paciente_especie").addClass( "active" );
		$("#paciente_especie").addClass( "invalid" );
		sw = 1;
	}

	if( $("#idRaza").val().trim().length == 0 ){
				
		$("#label_paciente_raza").addClass( "active" );
		$("#paciente_raza").addClass( "invalid" );
		sw = 1;
	}

	if( $("#paciente_nombre").val().trim().length == 0 ){
				
		$("#label_paciente_nombre").addClass( "active" );
		$("#paciente_nombre").addClass( "invalid" );
		sw = 1;
	}

	if( ( (!$('#radio1').is(':checked')) && (!$('#radio2').is(':checked')) ) || ( (!$('#radio3').is(':checked')) && (!$('#radio4').is(':checked')) ) ){
				
		$("#mensajeErrorCheckMostrar").html( $("#mensajeErrorCheck").html() );
		sw = 1;
	}else{
		$("#mensajeErrorCheckMostrar").html("&nbsp;");
	}

	if( ($("#fechaNacimiento").val().trim().length == 0) || ($("#fechaNacimiento").val() == "____/__/__") ){
				
		$("#label_fechaNacimiento").addClass( "active" );
		$("#fechaNacimiento").addClass( "invalid" );
		sw = 1;
	}

	if( $("#paciente_color").val().trim().length == 0 ){
				
		$("#label_paciente_color").addClass( "active" );
		$("#paciente_color").addClass( "invalid" );
		sw = 1;
	}

	if( $("#paciente_alimento").val().trim().length == 0 ){
				
		$("#label_paciente_alimento").addClass( "active" );
		$("#paciente_alimento").addClass( "invalid" );
		sw = 1;
	}

	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoPaciente").submit();
	}

	
}
//---


//funcion para cargar el formulario de editar un paciente
function editarpaciente(idPropietario, idEspecie, idRaza, rutaFoto, estado, idPaciente, nombre, chip, especie, raza, sexo, fechaNacimiento, esterilizado, color, alimento ,frecuenciaAlimento, bano ){
	
	cancelarCreacionPaciente();
	
	$("#titulo_editarPaciente").show('slower');
	
	//se cambia la imagen
	$("#editarPacinete_fotoActual").attr("src",rutaFoto);
	
	//se completan los value
	$("#editarPacinete_idPropietarioPaciente").val(idPropietario);
	$("#editarPacinete_idEspecie").val(idEspecie);
	$("#editarPacinete_idRaza").val(idRaza);
	$("#editarPacinete_idPaciente").val(idPaciente);
	$("#editarPacinete_paciente_nombre").val(nombre);
	$("#editarPacinete_paciente_chip").val(chip);
	$("#editarPacinete_paciente_especie").val(especie);
	$("#editarPacinete_paciente_raza").val(raza);
	$("#editarPacinete_fechaNacimiento").val(fechaNacimiento);
	$("#editarPacinete_paciente_color").val(color);
	$("#editarPacinete_paciente_alimento").val(alimento);
	$("#editarPacinete_frecuenciaAlimento").val(frecuenciaAlimento);
	//se reinicializa el select para que se vea el cambio
	$("#editarPacinete_frecuenciaAlimento").material_select();
	$("#editarPacinete_paciente_bano").val(bano);
	
	//se adicionan las clases de activas
	$("#editarPacinete_label_paciente_nombre").addClass( "active" );
	$("#editarPacinete_label_paciente_chip").addClass( "active" );
	$("#editarPacinete_label_paciente_especie").addClass( "active" );
	$("#editarPacinete_label_paciente_raza").addClass( "active" );
	$("#editarPacinete_label_fechaNacimiento").addClass( "active" );
	$("#editarPacinete_label_paciente_color").addClass( "active" );
	$("#editarPacinete_label_paciente_alimento").addClass( "active" );
	$("#editarPacinete_label_paciente_bano").addClass( "active" );	
	
	if(estado == 'vivo'){
		$('#radio5').attr('checked', true);	
	}else{
		$('#radio6').attr('checked', true);
	}
	
	if(sexo == 'M'){
		$('#radio7').attr('checked', true);	
	}else{
		$('#radio8').attr('checked', true);
	}

	if(esterilizado == 'Si'){
		$('#radio9').attr('checked', true);	
	}else{
		$('#radio10').attr('checked', true);
	}
		
	calcularTiempoDeVida(fechaNacimiento, 'editarPacinete_resultadoFechas');
	
	//se oculta el titulo
	$("#tituloLi").hide('slower');
	//se muestra el formulario
	$("#divHidden_editarPaciente").show('slower');
	
	
}
//---

//cancelar la edicion de un paciente
function cancelarEdicionPaciente(){
	
	$("#titulo_editarPaciente").hide('slower');
	
	$("#editarPacinete_filePath").val("");
	
	var foto = $("#editarPacinete_fotoPaciente");
	foto.replaceWith( foto = foto.clone( true ) );
	
	$("#divHidden_editarPaciente").hide('slower');
	$("#tituloLi").show('slower');
}
//---

//funcion para validar la edicion de un paciente
function validarEditarPaciente(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#editarPacinete_idEspecie").val().trim().length == 0 ){
				
		$("#editarPacinete_label_paciente_especie").addClass( "active" );
		$("#editarPacinete_paciente_especie").addClass( "invalid" );
		sw = 1;
	}

	if( $("#editarPacinete_idRaza").val().trim().length == 0 ){
				
		$("#editarPacinete_label_paciente_raza").addClass( "active" );
		$("#editarPacinete_paciente_raza").addClass( "invalid" );
		sw = 1;
	}

	if( $("#editarPacinete_paciente_nombre").val().trim().length == 0 ){
				
		$("#editarPacinete_label_paciente_nombre").addClass( "active" );
		$("#editarPacinete_paciente_nombre").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarPacinete_fechaNacimiento").val().trim().length == 0) || ($("#editarPacinete_fechaNacimiento").val() == "____/__/__") ){
				
		$("#editarPacinete_label_fechaNacimiento").addClass( "active" );
		$("#editarPacinete_fechaNacimiento").addClass( "invalid" );
		sw = 1;
	}

	if( $("#editarPacinete_paciente_color").val().trim().length == 0 ){
				
		$("#editarPacinete_label_paciente_color").addClass( "active" );
		$("#editarPacinete_paciente_color").addClass( "invalid" );
		sw = 1;
	}

	if( $("#editarPacinete_paciente_alimento").val().trim().length == 0 ){
				
		$("#editarPacinete_label_paciente_alimento").addClass( "active" );
		$("#editarPacinete_paciente_alimento").addClass( "invalid" );
		sw = 1;
	}

	if(sw == 1){
		return false;
	}else{
		$("#form_editarPaciente").submit();
	}
	
}
//---


//funcion para buscar un propietario en los campos de identificacion nombr y apellido de cuando se esta creando
function buscarPropietario(idCampo){
	
	$('#' + idCampo).autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarPropietario.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	buscarPropietario : request.term
	          	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        	       			
        			//se diligencia el campo        		
				$("#idPropietarioBusqueda").val(ui.item.id); 	
    				//se envia automaticamente el formulario
        		$("#form_resultadoBusqueda").submit();
    	}

  	});
	
	
}
//---


//funcion para importar los datos de un paciente al firmulario de nuevo paciente
function importarPacienteReplica(id, nombre, numeroChip, sexo, esterilizado, color, fechaNacimiento, alimento, frecuenciAimento, frecuenciaBano){

	cancelarCreacionPaciente();
	cancelarEdicionPaciente();
	$("#idReplica").val(id);
	$("#paciente_nombre").val(nombre);
	$("#paciente_chip").val(numeroChip);
	$("#fechaNacimiento").val(fechaNacimiento);
	$("#paciente_color").val(color);
	$("#frecuenciaAlimento").val(frecuenciAimento);
	$("#paciente_alimento").val(alimento);
	$("#paciente_bano").val(frecuenciaBano);

	if(sexo == 'M'){
		$('#radio1').attr('checked', true);	
	}else{
		$('#radio2').attr('checked', true);
	}

	if(esterilizado == 'Si'){
		$('#radio3').attr('checked', true);	
	}else{
		$('#radio4').attr('checked', true);
	}
	
	$("#label_paciente_nombre").addClass( "active" );
	$("#label_paciente_chip").addClass( "active" );
	$("#label_paciente_color").addClass( "active" );
	$("#label_paciente_alimento").addClass( "active" );
	$("#label_paciente_bano").addClass( "active" );
	
	calcularTiempoDeVida(fechaNacimiento, 'resultadoFechas');
	
	$("#hideFormPaciente").show('slower');
}
//---

