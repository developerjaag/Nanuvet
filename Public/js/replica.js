/*Funciones para la replica*/
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


//funcines para redireccionar, segun los items de la historia clinica
function redireccionEnHCReplica(url){
	
        	window.location=url;

}
//--

//funcion para mostrar el div de editar propietario
function mostrarFormEditarPropietario(){
	cerrarDatosPaciente();
	$("#hideFormEditarpropietario").show('slower');
}
//---


//funcion para mostrar el div de editar paciente
function mostrarFormEditarPaciente(){
	cerrarDatosPropietario();
	$("#hideFormEditarPaciente").show('slower');
}
//---

//funcion para cerrar los datos del propietario
function cerrarDatosPropietario(){
	$("#hideFormEditarpropietario").hide('slower');
}
//---

//funcion para cerrar los datos del paciente
function cerrarDatosPaciente(){
	$("#hideFormEditarPaciente").hide('slower');
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
	
	
  	$('select').material_select('destroy');
  	$('select').material_select();
            

	$("#hideFormPaciente").hide('slower');
	
}
//---


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

//funcion para habilitar los campos de la raza
function habilitarRaza(){
	
	$( "#iconoNuevaRaza" ).show("show");
	//se habilita el campo para que se pueda digitar
	$("#paciente_raza").prop('disabled', false);
	
}
//---

//funcion para buscar una raza
function buscarRaza(){

	 $('#paciente_raza').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/replica/buscarRaza.php",
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
        			   			
        }
    	
  	}); 
	
}
//---


//funcion para validar que el guardado de un nuevo paciente
function validarGuardarPaciente(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	

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


//abrir el formulario de nuevo
function abrirFormNuevoDesparasitante(){
	
	$("#hidden_nuevoDesparasitante").show('slower');
	$("#form_nuevoDesparasitante").addClass('unsavedForm');
	$("#tituloLi").hide('slower');
	
	
}
//---

//funcion para cancelar el guardado de una nueva aplicacion
function cancelarGuardadoNuevaAplicacionDesparasitante(){



	 swal({
		  title: $("#estaSeguro").html(),
		  text: $("#Seperderan").html(),
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: $("#SiCancelarla").html(),
		  cancelButtonText: 'No!'
		},function(){

			$("#hidden_nuevoDesparasitante").hide('slower');
			$("#tituloLi").show('slower');
			
			$("#form_nuevoDesparasitante").removeClass('unsavedForm');
		
			
			$("#buscarDesparasitante").val("");
			$("#dosificacion").val("");
			$("#fechaProximoDesparasitante").val("");
			
			$("#label_buscarDesparasitante").removeClass("active");
			$("#label_dosificacion").removeClass("active");
			$("#label_fechaProximoDesparasitante").removeClass("active");
			
			$("#buscarDesparasitante").removeClass("valid");
			$("#dosificacion").removeClass("valid");
			$("#fechaProximoDesparasitante").removeClass("valid");		
	
			$("#buscarDesparasitante").removeClass("invalid");
			$("#dosificacion").removeClass("invalid");
			$("#fechaProximoDesparasitante").removeClass("invalid");
			

	});

	
	
}
//---



//validar el guardado de una aplicacion para un desparasitante
function validarGuardadoNuevaAplicacionDesparasitante(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#buscarDesparasitante").val().trim().length == 0  ){
		
		$("#label_buscarDesparasitante").addClass( "active" );
		$("#buscarDesparasitante").addClass( "invalid" );
		sw = 1;
	}	
	

    if( $("#dosificacion").val().trim().length == 0 ){
		
		$("#label_dosificacion").addClass( "active" );
		$("#dosificacion").addClass( "invalid" );
		sw = 1;
	}	


	if(sw == 1){
		return false;
	}else{	
		$("#form_nuevoDesparasitante").removeClass('unsavedForm');
		$("#form_nuevoDesparasitante").submit();
	}
}
//---


//abrir el formulario de nuevo antipulgas
function abrirFormNuevoAntipulgas(){
	
	$("#hidden_nuevoAntipulgas").show('slower');
	$("#form_nuevoAntipulgas").addClass('unsavedForm');
	$("#tituloLi").hide('slower');
	
	
}
//---



//funcion para cancelar el guardado de una nueva aplicacion
function cancelarGuardadoNuevaAplicacionAntipulgas(){



	 swal({
		  title: $("#estaSeguro").html(),
		  text: $("#Seperderan").html(),
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: $("#SiCancelarla").html(),
		  cancelButtonText: 'No!'
		},function(){

			$("#hidden_nuevoAntipulgas").hide('slower');
			$("#tituloLi").show('slower');
			
			$("#form_nuevoAntipulgas").removeClass('unsavedForm');
		
			
			$("#nombreProducto").val("");
			$("#dosificacion").val("");
			$("#fechaProximoDesparasitante").val("");
			
			$("#label_nombreProducto").removeClass("active");
			$("#label_dosificacion").removeClass("active");
			$("#label_fechaProximoDesparasitante").removeClass("active");
			
			$("#nombreProducto").removeClass("valid");
			$("#dosificacion").removeClass("valid");
			$("#fechaProximoDesparasitante").removeClass("valid");		
	
			$("#nombreProducto").removeClass("invalid");
			$("#dosificacion").removeClass("invalid");
			$("#fechaProximoDesparasitante").removeClass("invalid");
			

	});

	
	
}
//---



//validar el guardado de una aplicacion para un antipulgas
function validarGuardadoNuevaAplicacionAntipulgas(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#nombreProducto").val().trim().length == 0  ){
		
		$("#label_nombreProducto").addClass( "active" );
		$("#nombreProducto").addClass( "invalid" );
		sw = 1;
	}	



	if(sw == 1){
		return false;
	}else{	
		$("#form_nuevoAntipulgas").removeClass('unsavedForm');
		$("#form_nuevoAntipulgas").submit();
	}
}
//---
