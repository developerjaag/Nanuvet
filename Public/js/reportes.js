/*
 * Funciones para el modulo de reportes
 */

$(document).ready(function() {
	
	//para los campos de fecha
	$('.fechaInicio').datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
	    maxDate:$('.fechaFin').val()?$('.fechaFin').val():false
	   })
	  },
	  timepicker:false
	 });
	 
	 $('.fechaFin').datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
	    minDate:$('.fechaInicio').val()?$('.fechaInicio').val():false
	   })
	  },
	  timepicker:false
	 });


	$('.fechaInicio2').datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
	    maxDate:$('.fechaFin2').val()?$('.fechaFin2').val():false
	   })
	  },
	  timepicker:false
	 });
	 
	 $('.fechaFin2').datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
	    minDate:$('.fechaInicio2').val()?$('.fechaInicio2').val():false
	   })
	  },
	  timepicker:false
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


/*----------------Gerenciales -----------------*/

//funcion para buscar el reporte gerencial por fechas
function gerencial_filtrarFechas(){
	
	var sw = 0;
	
	if(  $(".fechaInicio").val().trim().length == 0  ){
				
			$(".label_fechaInicial").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			
			sw = 1;
		}


	if(  $(".fechaFin").val().trim().length == 0  ){
				
			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			
			sw = 1;
		}
		
		
	if(sw == 0){
	
		$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/reportes/gerencial/consultarReportesFecha.php",
	      		
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    fechaInicio : $(".fechaInicio").val(),
	            	    fechaFin	: $(".fechaFin").val()	            	    
	            	},
	            success: function(data) {
	            	
	            	$("#resultadoReporte").html(data);
	            		            
	            }
	      	});	
	
		
	}

	
}
//---


//funcion para exportar los datos a excel
function exportarHCalculo(){
	
	$("#envioForm").val($("#exportarHCalculo").html());
	
	$("#form_excel").submit();
	
}

//funcion para exportar los datos a excel
function exportarPdf(){
	
	$("#envioFormPdf").val($("#reportePdf").html());
	
	$("#form_pedf").submit();
	
}


/*---------------- Fin Gerenciales -----------------*/


/*---------------- Citas -----------------*/

//funcion para validar que se tengan filtros en las citas
function citas_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}
	
	var options = $('#usuarios > option:selected');
   	
	if(options.length > 1){//mayor a 1 por que por defecto esta un selected (El vacio)
		sw = 1;
	}
	
	if(($("#tipoCita").val() != null) && ($("#tipoCita").val() != "") ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroCitas").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---

//funcion para realizar la busqueda de un propietario y llenar el select con los pacientes
function buscarPropietarioCita(){
	
	 $('#propietario').autocomplete({
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
        	
        	      		
        		
        	$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/listarPacientesPorPropietario.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idPropietario : ui.item.id 
	            	},success: function(data) {
	            		   
	            		  $("#idPropietario").val(ui.item.id); 
	            		  
	            		  if($("#selectPacienterDelPropietario").length > 0){ 
							
								$("#selectPacienterDelPropietario").html(data);
				              	$('#cita_pacientes').material_select('destroy');
				              	$('#cita_pacientes').material_select();
							
							}  
	            		    			            				            	
			              
			                    
			        }//fin succes
	      	});		
        			   			
        }
    	
  	}); 
   
	
}
//---

/*---------------- Fin Citas -----------------*/


/*---------------- Cirugias -----------------*/

//funcion para buscar un diagnostico de cirugia para el filtro
function buscarDxCirugia(){
	
	$("#buscarCirugia").removeClass("valid");	
	

	$("#buscarCirugia").removeClass("invalid");


   $('#buscarCirugia').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 var id 	  = 	ui.item.id; 
				 var codigoDX = 	ui.item.codigo      
				 var nombreDX = 	ui.item.nombre      
				 
				 $("#idCirugia").val(ui.item.id);	
		   			
        }
    	
  	}); 
  		
}
//---


//funcion para validar que se tengan filtros en las cirugias
function cirugias_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}
	
   	
	if(($("#usuarios").val() != "") && $("#usuarios").val() != null){
		sw = 1;
	}
	
	if($("#idCirugia").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroCirugias").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---


/*---------------- Fin Cirugias -----------------*/



/*---------------- consultas -----------------*/

//funcion para buscar un diagnostico de consulta para el filtro
function buscarDxConsulta(){
	
	$("#buscarDiagnostico").removeClass("valid");	
	

	$("#buscarDiagnostico").removeClass("invalid");


   $('#buscarDiagnostico').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 var id 	  = 	ui.item.id; 
				 var codigoDX = 	ui.item.codigo      
				 var nombreDX = 	ui.item.nombre      
				 
				 $("#idDxConsulta").val(ui.item.id);
		   			
        }
    	
  	}); 
  		
}
//---


//funcion para validar que se tengan filtros en las consultas
function consultas_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}
	
   	
	if(($("#usuarios").val() != "") && $("#usuarios").val() != null){
		sw = 1;
	}
	
	if($("#idDxConsulta").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroConsultas").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---


/*---------------- Fin Consultas -----------------*/

/*---------------- Desparasitantes -----------------*/

//funcion para buscar un desparasitante para el filtro
function buscarDesparasitante(){
	
	$("#buscarDesparasitante").removeClass("valid");	

	$("#buscarDesparasitante").removeClass("invalid");
	
	 $('#buscarDesparasitante').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/buscarDesparasitante.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDesparasitante : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        	
        	$("#idDesparasitante").val(ui.item.id);
		   			
        }
    	
  	}); 
  		
}
//---


//funcion para validar que se tengan filtros en los desparasitantes
function desparasitantes_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio2").val().trim().length > 0  ){
		
		if($(".fechaFin2").val().trim().length == 0 ){

			$(".label_fechaFinal2").addClass( "active" );
			$(".fechaFin2").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin2").val().trim().length > 0  ){
		
		if($(".fechaInicio2").val().trim().length == 0 ){

			$(".label_fechaInicio2").addClass( "active" );
			$(".fechaInicio2").addClass( "invalid" );
			return false;
		}
		
	}

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}

	if($(".fechaInicio2").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin2").val().trim().length > 0 ){
		sw = 1;
	}	
 
	
	if($("#idDesparasitante").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroDesparasitantes").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---


/*---------------- Fin Desparasitantes -----------------*/


/*---------------- Examenes -----------------*/

//funcion para buscar un diagnostico de cirugia para el filtro
function buscarExamenExamen(){
	
	$("#buscarExamen").removeClass("valid");	

	$("#buscarExamen").removeClass("invalid");
	
	 $('#buscarExamen').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/examenes/buscarExamen.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringExamen : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 $("#idExamen").val(ui.item.id);      
		   			
        }
    	
  	}); 
	
  		
}
//---


//funcion para validar que se tengan filtros en los examenes
function examenes_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}
	
   	
	if(($("#usuarios").val() != "") && $("#usuarios").val() != null){
		sw = 1;
	}
	
	if($("#idExamen").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroExamenes").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---


/*---------------- Fin Examenes -----------------*/

/*---------------- Formulas -----------------*/


//funcion para buscar un medicamen de la formula para el filtro
function buscarMedicamentoFormula(){
	
	$("#buscarMedicamento").removeClass("valid");	

	$("#buscarMedicamento").removeClass("invalid");
	
	 $('#buscarMedicamento').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/buscarMedicamento.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringMedicamento : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 $("#idMedicamento").val(ui.item.id);          
		   			
        }
    	
  	}); 
  		
}
//---


//funcion para validar que se tengan filtros en las formulas
function formulas_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}
	
   	
	if(($("#usuarios").val() != "") && $("#usuarios").val() != null){
		sw = 1;
	}
	
	if($("#idMedicamento").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroFormulas").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---

/*---------------- Fin Formulas -----------------*/

/*---------------- Vacunas -----------------*/


//funcion para buscar una vacuna para el filtro
function buscarVacunaFiltro(){
	
	$("#buscarVacuna").removeClass("valid");	

	$("#buscarVacuna").removeClass("invalid");
	
	 $('#buscarVacuna').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/vacunas/buscarVacuna.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringVacuna : request.term
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
        		$("#idVacuna").val(ui.item.id);
         		
        }
    	
  	}); 
	
  		
}
//---


//funcion para validar que se tengan filtros en las vacunas
function vacunas_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}
	

	if($(".fechaInicio2").val().trim().length > 0  ){
		
		if($(".fechaFin2").val().trim().length == 0 ){

			$(".label_fechaFinal2").addClass( "active" );
			$(".fechaFin2").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin2").val().trim().length > 0  ){
		
		if($(".fechaInicio2").val().trim().length == 0 ){

			$(".label_fechaInicio2").addClass( "active" );
			$(".fechaInicio2").addClass( "invalid" );
			return false;
		}
		
	}

	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}

	if($(".fechaInicio2").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin2").val().trim().length > 0 ){
		sw = 1;
	}	
 
	
	if($("#idVacuna").val() != "0" ){
		sw = 1;
	}	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroVacunas").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---

/*---------------- Fin Vacunas -----------------*/

/*---------------- Hospitalizaciones -----------------*/

//funcion para validar que se tengan filtros en las hospitalizaicones
function hospitalizaciones_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}

	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroHospitalizaciones").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---

/*---------------- Fin Hospitalizaciones -----------------*/


/*---------------- Pacientes -----------------*/

//funcion para buscar una especie para el filtro
function buscarEspecieFiltro(){
	
 $('#buscarEspecie').autocomplete({
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
        			   			
        }
    	
  	}); 
	
  		
}
//---


//funcion para buscar una raza para el filtro
function buscarRazaFiltro(){

	 $('#buscarRaza').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarRaza.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarRaza : request.term,//se envia el string a buscar
	            	    idEspecie		 : ""
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


//funcion para validar que se tengan filtros en los pacientes
function pacientes_filtrar(){
	
	var sw = 0; //para saber si se aplican filtros
	
	if($(".fechaInicio").val().trim().length > 0  ){
		
		if($(".fechaFin").val().trim().length == 0 ){

			$(".label_fechaFinal").addClass( "active" );
			$(".fechaFin").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaFin").val().trim().length > 0  ){
		
		if($(".fechaInicio").val().trim().length == 0 ){

			$(".label_fechaInicio").addClass( "active" );
			$(".fechaInicio").addClass( "invalid" );
			return false;
		}
		
	}


	if($(".fechaInicio").val().trim().length > 0 ){
		sw = 1;
	}
	
	if($(".fechaFin").val().trim().length > 0 ){
		sw = 1;
	}


	
	if($("#idEspecie").val() != "0" ){
		sw = 1;
	}	


	if($("#idRaza").val() != "0" ){
		sw = 1;
	}	
	
	
	if($("#idPropietario").val() != "0"){
		sw = 1;
	}		
	
	if(sw == 1){
		
		$("#form_filtroPacientes").submit();
		
	}else{
		$("#spanErrorFiltro").show("slower");
	}
		
}
//---


/*---------------- Fin Pacientes -----------------*/
