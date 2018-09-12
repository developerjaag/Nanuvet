$(document).ready(function() {

    contruirCalendario();
    
    //fin configuracion fullcalendar

			
	/*---------------- Horario -------------------*/
	//para los campos de horas
	$('.hora').datetimepicker({
	  defaultTime:'06:00',
	  step: 20,
	  datepicker:false,
	  formatTime:'H:i',
	  format: 'H:i'
	  
	});		

	//para los campos de fecha
	$('.calendarioFecha').datetimepicker({
	  timepicker:false,
	  formatDate:'Y/m/d',
	  format: 'Y/m/d'
	  
	});	

	 $('.duracionHoras').datetimepicker({

		datepicker:false,
		format:'H',
		formatTime:'H',
		allowTimes:[
			'00:00','01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00',
			'21:00','22:00','23:00'
		]
	 });	

	 $('.duracionMinutos').datetimepicker({

		datepicker:false,
		format:'i',
		formatTime:'i',
		allowTimes:[
		 '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15',
		  '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30',
		  '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45',
		  '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'
		]
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


	//campos fecha y hora de la cita
	
	


});



/*
 * Funcion para construir el calendario
 */
function contruirCalendario(){

	var theLanguage = $('html').attr('lang');

	theLanguage = 	theLanguage.toLowerCase();
    
    
    var idUsuarioEventos = $("#selectUsuario").val();
    

    $('#calendar').fullCalendar({
    	
    	locale : theLanguage,
    	
    	eventLimit: true,
        
        buttonText: {
					    listMonth:   'L. M',
					    listWeek:    'L. S',
					    listDay:     'L. D'
					},
        
        
        customButtons: {
	        irafecha: {
	            text: ''
	        }
	    },
	            
        
        header: {
        	left:   'today, prevYear, prev,next, nextYear',
		    center: 'title',
		    right:  'month, agendaWeek, agendaDay, listMonth, listWeek, listDay, irafecha'

        },
        
        //al hacer click en un dia
      /*  dayClick: function(date) {
        	 
        	 
        	 //$('#calendar').fullCalendar( 'changeView', agendaDay );
	    },*/
        
        
        slotDuration: "00:20:00",
        slotLabelFormat : 'HH:mm',
		timeFormat: 'HH:mm)', 
        //hora de inicio
       // minTime: "06:00:00",
        
        weekNumbers: true,
        
        //para que no se monten encima los eventos
        slotEventOverlap: false,
        
        eventLimit: true,//limite de las citas que se muestran en la vista mes
        
        navLinks: true,//para que el numero de dias y de semanas sea clickable
        
        //al dar click en un evento
		 eventClick: function(calEvent) {
			
			editarCitaUsuario(calEvent.id);
			
	
	   },
        
        
        //al dar click en un dia
		dayClick: function(date) {
						
			var fechaCitaClick	= String(date.format("YYYY/MM/DD"));
			var horaCitaClick	= String(date.format("HH:mm"));

			$("#fecha_cita").val(fechaCitaClick);
			$("#hora_cita").val(horaCitaClick);
			
			//editar cita
			/*$("#EditarfechaCIta").val(fechaCitaClick);
			$("#EditarhoraCIta").val(horaCitaClick);
			$("#EditarminutoCIta").val(minutoCitaClick);*/
			//fin editar cita
			

			$("#duracion_citaHoras").val("0");
			$("#duracion_citaMinutos").val("20");
			
			//editar cita
			/*$("#EditarduracionCitaHoras").val(duracionHoraClick);
			$("#EditarduracionCitaMinutos").val(duracionMinutoClick);*/
			//fin editar cita
			
			if( (horaCitaClick == "00:00")){
				
				cambiarVistaDia(date);
				
				/*if(!$('#EditarformAgendar').is(':visible')){
					mostrarDivAgendar('funcion');
				}*/
				
			}
			
			
		},
        
        /*	eventRender: function(event, element, view) {
			
			//	var view = $('#calendar').fullCalendar('getView');
				if (view.name == 'agendaWeek' || view.name == 'agendaDay'){
					
					$(".horarioFecha").parent().children(".horarioDiaSemana").remove();
				} 			            
								           								            
			}, */

        	
			eventAfterRender: function(event, element, view) {
			
			//	var view = $('#calendar').fullCalendar('getView');
				if (view.name == 'agendaWeek' || view.name == 'agendaDay'){
					
					$(".horarioFecha").parent().children(".horarioDiaSemana").remove();
					$(".recesoFecha").parent().children(".recesoDiaSemana").remove();
				} 			            
								           								            
			}, 

		
	 eventSources: [  								 
		  								 
						 {
						        url: 'http://www.nanuvet.com/Controllers/agenda/consultarEventosUsuarioCalendario.php',
						        async: false,
						        type: 'POST',
						        data: {
						            idUsuario: idUsuarioEventos
						        },
						        textColor: 'black' // a non-ajax option
						},
				 	
				 ]
				 


        
        
    });


	   //para dar el icono al boton de ir a fecha
		    $(".fc-irafecha-button").append('<i class="fa fa-calendar" aria-hidden="true"></i>');
		    //para construir el calendario pequeño
		    $('.fc-irafecha-button').datetimepicker({
		    	timepicker:false,
		    	onSelectDate:function(dp,$input){
				   
				   var fecha = $input.val();
				   
				   var fecha1 = fecha.split(" ");
				   
				   var fecha2 = fecha1[0].split("/");
		
					var mes	= fecha2[1];
					var dia = fecha2[0];
					var ano = fecha2[2];		   
				   
				   	 var fecha3 = "'"+mes+"-"+dia+"-"+ano+"'";
				   
				   //alert(fecha3);
				   $('#calendar').fullCalendar( 'gotoDate', fecha);
				}
		    });
		    //al hacer click en el boton
		    $('.fc-irafecha-button').on('click', function () {
		    	$('.fc-irafecha-button').datetimepicker('show');
			});


	
}
/*
 * FIN Funcion para construir el calendario
 */



/*
 * Funcion para rehacer el calendario para cuando se cambia a la vista de dia
 */
function cambiarVistaDia(fecha){
	$('#calendar').fullCalendar( 'gotoDate', fecha);
	$('#calendar').fullCalendar( 'changeView', 'agendaDay' );
}
//-----

/*
 * Consultar las citas de un usuario
 */
function consultarCitasUsuario(){
	
	var idUsuario = $("#selectUsuario").val();
	
	
	var selectList = $("#otrosUsuarios");
	selectList.find("option:gt(0)").remove();
	
	//para mostrar nombre en spán de select usuarios
	$("#nombreUsuarioSeleccionado").html( $("#selectUsuario option:selected").text() );
	
	$("#selectUsuario option").each(function(){
    // Add $(this).val() to your list
    	if( ($("#selectUsuario").val() != $(this).val()) && ($("#selectUsuario").val() != "") && ($("#selectUsuario").val() != null) && ($(this).val() != "") && ($(this).val() != null) ){
    		
    		$('#otrosUsuarios').append($('<option>', {
		    	value: $(this).val(),
		    	text: $(this).text()
			}));
    		
    	}
		
	});	
	
 	 $('#otrosUsuarios').material_select('destroy');
 	 $('#otrosUsuarios').material_select();	
 	 
 	 //se recorre el select que se acabo de contruir para dar los ids a los checkbox de materialize
 	 $("#otrosUsuarios option").each(function(){
		
    	$("#nuevaCitaOtrosUsuariosMultiple").find('span:contains("'+$(this).text()+'")').parent('li').attr('id', 'multipleCreando'+$(this).val());
    	$('#multipleCreando'+$(this).val()).attr("onClick", 'comprobarSeleccionMultipleNuevaCita(this.id)');
		
	});	
 	 

	$("#calendar").fullCalendar( 'destroy' );
	contruirCalendario();	
	
	
}
//-----


/*------------------------------------------ Horarios -------------------------*/

//funcion para consultar el horario y recesos de un usuario
function consultarHorarioUsuario(){
	
	if( $("#selectUsuario_horario").val() == null ){
		return false;
	}
        
	
 	 $('#selectUsuario_horario').material_select('destroy');
 	 $('#selectUsuario_horario').material_select();
            
	
	//preloader
	$("#div_contenidoHorarioFechas").html($("#div_preloader").html());
	
	
	$("#div_recesos0").html($("#div_preloader").html());
	$("#div_recesos1").html($("#div_preloader").html());
	$("#div_recesos2").html($("#div_preloader").html());
	$("#div_recesos3").html($("#div_preloader").html());
	$("#div_recesos4").html($("#div_preloader").html());
	$("#div_recesos5").html($("#div_preloader").html());
	$("#div_recesos6").html($("#div_preloader").html());
	
	$("#div_contenidoRecesosFechas").html($("#div_preloader").html());
	
	
	//horario dias de la semana
	
	$("#Lunes").prop('disabled', false);
	$("#Martes").prop('disabled', false);
	$("#Miercoles").prop('disabled', false);
	$("#Jueves").prop('disabled', false);
	$("#Viernes").prop('disabled', false);
	$("#Sabado").prop('disabled', false);
	$("#Domingo").prop('disabled', false);
	
	
	var idUsuario = $("#selectUsuario_horario").val();
	
	var dias = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];	
	var horasInicio = ['inicioJornadaLunes','inicioJornadaMartes','inicioJornadaMiercoles','inicioJornadaJueves','inicioJornadaViernes','inicioJornadaSabado','inicioJornadaDomingo'];	
	var horasFin = ['finJornadaLunes','finJornadaMartes','finJornadaMiercoles','finJornadaJueves','finJornadaViernes','finJornadaSabado','finJornadaDomingo'];
		
			for(var j = 0; j < 7; j++){
				
					//primero se limpia todo
					$('#'+dias[j]).prop('checked', false);
					$("#"+dias[j]).prop('disabled', false);
            		$("#"+horasInicio[j]).prop('disabled', true);
            		$("#"+horasFin[j]).prop('disabled', true);
            		
            		$("#"+horasInicio[j]).val("");
            	    $("#"+horasFin[j]).val(""); 
            	       
            	    $("#label_"+horasInicio[j]).removeClass( "active" );
            	    $("#label_"+horasFin[j]).removeClass( "active" ); 
					
					
					$.ajax({
			      		url: "http://www.nanuvet.com/Controllers/agenda/consultarHorarioDiaSemana.php",
			      		async:false,    
                      	cache:false,
			            dataType: "json",
			            type : 'POST',
			            data: {
			            	    idUsuario : idUsuario,
			            	    dia: j,
			            	    
			            	},
			            success: function(data) {
			            	
			            	if (data != 'Sin horario') {
			            		
			            		$('#'+dias[j]).prop('checked', true);
			            		$("#"+dias[j]).prop('disabled', false);
			            		$("#"+horasInicio[j]).prop('disabled', false);
			            		$("#"+horasFin[j]).prop('disabled', false);
			            		
			            		$("#"+horasInicio[j]).val(data[0].horaInicio);
			            	    $("#"+horasFin[j]).val(data[0].horaFin); 
			            	       
			            	    $("#label_"+horasInicio[j]).addClass( "active" );
			            	    $("#label_"+horasFin[j]).addClass( "active" ); 
			            		
			            	}
			            		            
			            }
			      	});					
							
				
			}//fin for		
	


/*-------------Consultar horario fechas------------------------*/	
		consultarHorarioFechas(idUsuario);

/*-------------Consultar recesos días------------------------*/	

	consultarRecesoDia('0', idUsuario);
	consultarRecesoDia('1', idUsuario);
	consultarRecesoDia('2', idUsuario);
	consultarRecesoDia('3', idUsuario);
	consultarRecesoDia('4', idUsuario);
	consultarRecesoDia('5', idUsuario);
	consultarRecesoDia('6', idUsuario);

/*-------------Consultar recesos fechas------------------------*/	
	consultarRecesoFechas(idUsuario);
	
	
}
//---

//funcion para activar o inactivar los campos de un dia
function ActivarDesactivarDia(dia){

	//saber si el checkbox esta seleccionado
	if( $('#'+dia).prop('checked') ) {
		
    	$("#inicioJornada"+dia).prop('disabled', false);
    	$("#finJornada"+dia).prop('disabled', false);
    	
	}else{
		
    	$("#inicioJornada"+dia).prop('disabled', true);
    	$("#finJornada"+dia).prop('disabled', true);	
    	
    	$("#inicioJornada"+dia).removeClass("valid")
    	$("#inicioJornada"+dia).removeClass("invalid");
 
    	$("#finJornada"+dia).removeClass("valid");
    	$("#finJornada"+dia).removeClass("invalid");
    	    	    	
    	$("#inicioJornada"+dia).val("");
    	$("#finJornada"+dia).val("");
    		
	}
	
	
}
//---


//funcion para copiar el horario de un dia en otros
function copiarHorarioOtrosDias(idCopiar){

	var dia = idCopiar.slice(6);

	if( $('#'+dia).prop('checked') ) {
		
		var inicioJornada	= $("#inicioJornada"+dia).val();
		var finJornada		= $("#finJornada"+dia).val();

		
		$('#Lunes').prop('checked', true);
		$('#Martes').prop('checked', true);
		$('#Miercoles').prop('checked', true);
		$('#Jueves').prop('checked', true);
		$('#Viernes').prop('checked', true);
		$('#Sabado').prop('checked', true);
		$('#Domingo').prop('checked', true);
		
		ActivarDesactivarDia("Lunes");
		ActivarDesactivarDia("Martes");
		ActivarDesactivarDia("Miercoles");
		ActivarDesactivarDia("Jueves");
		ActivarDesactivarDia("Viernes");
		ActivarDesactivarDia("Sabado");
		ActivarDesactivarDia("Domingo");
		
		$("#inicioJornadaLunes").val(inicioJornada);	
		$("#finJornadaLunes").val(finJornada);

		$("#inicioJornadaMartes").val(inicioJornada);	
		$("#finJornadaMartes").val(finJornada);
		
		$("#inicioJornadaMiercoles").val(inicioJornada);	
		$("#finJornadaMiercoles").val(finJornada);	
		
		$("#inicioJornadaJueves").val(inicioJornada);	
		$("#finJornadaJueves").val(finJornada);
		
		$("#inicioJornadaViernes").val(inicioJornada);	
		$("#finJornadaViernes").val(finJornada);	
		
		$("#inicioJornadaSabado").val(inicioJornada);	
		$("#finJornadaSabado").val(finJornada);
		
		$("#inicioJornadaDomingo").val(inicioJornada);	
		$("#finJornadaDomingo").val(finJornada);		
		
		$("#label_inicioJornadaLunes").addClass( "active" );	
		$("#label_inicioJornadaMartes").addClass( "active" );	
		$("#label_inicioJornadaMiercoles").addClass( "active" );	
		$("#label_inicioJornadaJueves").addClass( "active" );	
		$("#label_inicioJornadaViernes").addClass( "active" );	
		$("#label_inicioJornadaSabado").addClass( "active" );	
		$("#label_inicioJornadaDomingo").addClass( "active" );	
		
		$("#label_finJornadaLunes").addClass( "active" );
		$("#label_finJornadaMartes").addClass( "active" );
		$("#label_finJornadaMiercoles").addClass( "active" );
		$("#label_finJornadaJueves").addClass( "active" );
		$("#label_finJornadaViernes").addClass( "active" );
		$("#label_finJornadaSabado").addClass( "active" );
		$("#label_finJornadaDomingo").addClass( "active" );									

		
	}
	
}
//---

//funcion para limpiar los campos de horario de semana 
function limpiarHorarioSemana(){
	
		$('#Lunes').attr('checked', false);
		$('#Martes').attr('checked', false);
		$('#Miercoles').attr('checked', false);
		$('#Jueves').attr('checked', false);
		$('#Viernes').attr('checked', false);
		$('#Sabado').attr('checked', false);
		$('#Domingo').attr('checked', false);
		
		ActivarDesactivarDia("Lunes");
		ActivarDesactivarDia("Martes");
		ActivarDesactivarDia("Miercoles");
		ActivarDesactivarDia("Jueves");
		ActivarDesactivarDia("Viernes");
		ActivarDesactivarDia("Sabado");
		ActivarDesactivarDia("Domingo");

	
		$("#inicioJornadaLunes").val("");	
		$("#finJornadaLunes").val("");	

		$("#inicioJornadaMartes").val("");	
		$("#finJornadaMartes").val("");	
		
		$("#inicioJornadaMiercoles").val("");	
		$("#finJornadaMiercoles").val("");	
		
		$("#inicioJornadaJueves").val("");	
		$("#finJornadaJueves").val("");
		
		$("#inicioJornadaViernes").val("");	
		$("#finJornadaViernes").val("");
		
		$("#inicioJornadaSabado").val("");	
		$("#finJornadaSabado").val("");	
		
		$("#inicioJornadaDomingo").val("");	
		$("#finJornadaDomingo").val("");		

		$("#label_inicioJornadaLunes").removeClass( "active" );	
		$("#label_inicioJornadaMartes").removeClass( "active" );	
		$("#label_inicioJornadaMiercoles").removeClass( "active" );	
		$("#label_inicioJornadaJueves").removeClass( "active" );	
		$("#label_inicioJornadaViernes").removeClass( "active" );	
		$("#label_inicioJornadaSabado").removeClass( "active" );	
		$("#label_inicioJornadaDomingo").removeClass( "active" );	
		
		$("#label_finJornadaLunes").removeClass( "active" );
		$("#label_finJornadaMartes").removeClass( "active" );
		$("#label_finJornadaMiercoles").removeClass( "active" );
		$("#label_finJornadaJueves").removeClass( "active" );
		$("#label_finJornadaViernes").removeClass( "active" );
		$("#label_finJornadaSabado").removeClass( "active" );
		$("#label_finJornadaDomingo").removeClass( "active" );	
		
		$("#inicioJornadaLunes").removeClass( "invalid" );	
		$("#inicioJornadaMartes").removeClass( "invalid" );	
		$("#inicioJornadaMiercoles").removeClass( "invalid" );	
		$("#inicioJornadaJueves").removeClass( "invalid" );	
		$("#inicioJornadaViernes").removeClass( "invalid" );	
		$("#inicioJornadaSabado").removeClass( "invalid" );	
		$("#inicioJornadaDomingo").removeClass( "invalid" );	
		
		$("#finJornadaLunes").removeClass( "invalid" );
		$("#finJornadaMartes").removeClass( "invalid" );
		$("#finJornadaMiercoles").removeClass( "invalid" );
		$("#finJornadaJueves").removeClass( "invalid" );
		$("#finJornadaViernes").removeClass( "invalid" );
		$("#finJornadaSabado").removeClass( "invalid" );
		$("#finJornadaDomingo").removeClass( "invalid" );			
		
		$("#inicioJornadaLunes").removeClass( "valid" );	
		$("#inicioJornadaMartes").removeClass( "valid" );	
		$("#inicioJornadaMiercoles").removeClass( "valid" );	
		$("#inicioJornadaJueves").removeClass( "valid" );	
		$("#inicioJornadaViernes").removeClass( "valid" );	
		$("#inicioJornadaSabado").removeClass( "valid" );	
		$("#inicioJornadaDomingo").removeClass( "valid" );	
		
		$("#finJornadaLunes").removeClass( "valid" );
		$("#finJornadaMartes").removeClass( "valid" );
		$("#finJornadaMiercoles").removeClass( "valid" );
		$("#finJornadaJueves").removeClass( "valid" );
		$("#finJornadaViernes").removeClass( "valid" );
		$("#finJornadaSabado").removeClass( "valid" );
		$("#finJornadaDomingo").removeClass( "valid" );			

	
}
//---


//funcion para guardar el horario de la semana de un usuario
function guardarHorarioSemana(){
	
	if( $("#selectUsuario_horario").val() == null ){
		return false;
	}
	
	var idUsuario = $("#selectUsuario_horario").val();
	
	var dias = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
	
	var horasInicio = ['inicioJornadaLunes','inicioJornadaMartes','inicioJornadaMiercoles','inicioJornadaJueves','inicioJornadaViernes','inicioJornadaSabado','inicioJornadaDomingo'];
	
	var horasFin = ['finJornadaLunes','finJornadaMartes','finJornadaMiercoles','finJornadaJueves','finJornadaViernes','finJornadaSabado','finJornadaDomingo'];
	
	var sw = 0; 
				
	for(var i = 0; i < 7; i++){
		
		if( $('#'+dias[i]).prop('checked') ) {
						
			//hora inicio
			if(  $("#"+horasInicio[i]).val().trim().length == 0  ){
				
				$("#label_"+horasInicio[i]).addClass( "active" );
				$("#"+horasInicio[i]).addClass( "invalid" );
				
				sw = 1;
			}
			
			//hora fin
			if(  $("#"+horasFin[i]).val().trim().length == 0 ){
				
				$("#label_"+horasFin[i]).addClass( "active" );
				$("#"+horasFin[i]).addClass( "invalid" );
			  
			    sw = 1;
			}
			
		}//fin if
		
		
	}//fin for
	
	if(sw == 1){
		return false;
	}else{
		
			for(var i = 0; i < 7; i++){
				
				if( $('#'+dias[i]).prop('checked') ) {
					
						$.ajax({
				      		url: "http://www.nanuvet.com/Controllers/agenda/guardarHorarioDiaSemana.php",
				            dataType: "html",
				            type : 'POST',
				            data: {
				            	    idUsuario : idUsuario,
				            	    dia: i,
				            	    horaInicio  : $("#"+horasInicio[i]).val(),
				            	    horaFin		: $("#"+horasFin[i]).val()
				            	}
				      	});					
					
										
					
				}else{
					
					$.ajax({
				      		url: "http://www.nanuvet.com/Controllers/agenda/inactivarHorarioDiaSemana.php",
				            dataType: "html",
				            type : 'POST',
				            data: {
				            	    idUsuario : idUsuario,
				            	    dia: i
				            	}
				      	});	
					
				}//fin else
				
				
			}//fin for	
			
			Materialize.toast($("#mensajeGuardado").html(), 4000);	
		
	}//fin else
	
	
	
}
//---


/*-------------- Horairo fecha ----------------*/

/*-------------Consultar horario fechas------------------------*/
function consultarHorarioFechas(idUsuario){
	

		$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/consultarHorarioFechas.php",
	      		
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario	            	    
	            	},
	            success: function(data) {
	            	
	            	$("#div_contenidoHorarioFechas").html(data);
	            		            
	            }
	      	});		
}
//---


//funcin para guardar un horairi por fecha
function guardarHorarioFecha(){
	
	if( $("#selectUsuario_horario").val() == null ){
		return false;
	}
	
	var idUsuario = $("#selectUsuario_horario").val();
	var sw = 0;


		//fecha
		if(  $("#fecha_horarioFecha").val().trim().length == 0  ){
			
			$("#label_fecha_horarioFecha").addClass( "active" );
			$("#fecha_horarioFecha").addClass( "invalid" );
			
			sw = 1;
		}
	
		//hora inicio
		if(  $("#fecha_horarioInicioFecha").val().trim().length == 0  ){
			
			$("#label_fecha_horarioInicioFecha").addClass( "active" );
			$("#fecha_horarioInicioFecha").addClass( "invalid" );
			
			sw = 1;
		}
		
		//hora fin
		if(  $("#fecha_horarioFinFecha").val().trim().length == 0 ){
			
			$("#label_fecha_horarioFinFecha").addClass( "active" );
			$("#fecha_horarioFinFecha").addClass( "invalid" );
		  
		    sw = 1;
		}	
		
		if (sw == 0) {
			
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/guardarHorarioFecha.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario,
	            	    fecha		: $("#fecha_horarioFecha").val(),
	            	    horaInicio  : $("#fecha_horarioInicioFecha").val(),
	            	    horaFin		: $("#fecha_horarioFinFecha").val()
	            	},success: function(data) {
			            	
			            	if (data == 'Guardado') {
			            		
			            		Materialize.toast($("#mensajeGuardadoFecha").html(), 4000);	
			            		
			            	}else{
			            		
			            		Materialize.toast($("#mensajeActualizadoFecha").html(), 4000);	
			            		
			            	}//fin else
			            	
			            	consultarHorarioFechas(idUsuario);
			            	
			            	//se limpian los campos
			            	$("#fecha_horarioFecha").val("");
			            	$("#fecha_horarioInicioFecha").val("");
			            	$("#fecha_horarioFinFecha").val("");
			            	
			            	$("#fecha_horarioFecha").removeClass( "invalid" );
			            	$("#fecha_horarioInicioFecha").removeClass( "invalid" );
			            	$("#fecha_horarioFinFecha").removeClass( "invalid" );
			            	
			            	$("#fecha_horarioFecha").removeClass( "valid" );
			            	$("#fecha_horarioInicioFecha").removeClass( "valid" );
			            	$("#fecha_horarioFinFecha").removeClass( "valid" );
			            	
			            	$("#label_fecha_horarioFecha").removeClass( "active" );
			            	$("#label_fecha_horarioInicioFecha").removeClass( "active" );
			            	$("#label_fecha_horarioFinFecha").removeClass( "active" );			            	
			            		            
			            }//fin succes
	      	});		
			
		}else{
			return false;
			
		}
	
}
//---

//funcion para inactivar una fecha
function inactivarHorarioFecha(idAgendaHorarioFechaUsuario){
	
			var idUsuario = $("#selectUsuario_horario").val();
	
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/inactivarHorarioFecha.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idAgendaHorarioFechaUsuario : idAgendaHorarioFechaUsuario
	            	},success: function() {
	            		      			            				            	
			            consultarHorarioFechas(idUsuario);
			                    
			        }//fin succes
	      	});			
	
}
//---



/*************************** Recesos por dias ************************************/

//funcion para abrir el formulario de un nuevo receso
function nuevoRecesoDia(dia){
	
	if( $("#selectUsuario_horario").val() == null ){
		return false;
	}
	
	$('#div_nuevoReceso'+dia).show('slower');
	
}
//----

//funcion para cancelar un nuevo receso dia
function cancelarGuardadoRecesoDia(dia){
	
	$('#div_nuevoReceso'+dia).hide('slower');
	
	$("#recesoDias_horaInicio"+dia).val("");
	$("#recesoDias_horaFin"+dia).val("");
	
	$("#recesoDias_horaInicio"+dia).removeClass( "valid" );
	$("#recesoDias_horaFin"+dia).removeClass( "valid" );

	$("#recesoDias_horaInicio"+dia).removeClass( "invalid" );
	$("#recesoDias_horaFin"+dia).removeClass( "invalid" );
			            	
	$("#label_recesoDias_horaInicio"+dia).removeClass( "active" );
	$("#label_recesoDias_horaFin"+dia).removeClass( "active" );
	
	
}
//----


//funcion para guardar el horairo del receso de un dia
function guardarRecesoDia(dia){

	var idUsuario = $("#selectUsuario_horario").val();
	var sw = 0;

		if(  $("#recesoDias_horaInicio"+dia).val().trim().length == 0  ){
			
			$("#label_recesoDias_horaInicio"+dia).addClass( "active" );
			$("#recesoDias_horaInicio"+dia).addClass( "invalid" );
			
			sw = 1;
		}

		if(  $("#recesoDias_horaFin"+dia).val().trim().length == 0  ){
			
			$("#label_recesoDias_horaFin"+dia).addClass( "active" );
			$("#recesoDias_horaFin"+dia).addClass( "invalid" );
			
			sw = 1;
		}
		
		if(sw == 0){
			
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/guardarRecesoDia.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario,
	            	    dia			: dia,
	            	    horaInicio  : $("#recesoDias_horaInicio"+dia).val(),
	            	    horaFin		: $("#recesoDias_horaFin"+dia).val()
	            	},success: function(data) {            	
			            		
			            	//se limpian los campos
			            	$("#recesoDias_horaFin"+dia).val("");
			            	$("#recesoDias_horaInicio"+dia).val("");
			            	
			            	
			            	$("#recesoDias_horaFin"+dia).removeClass( "invalid" );
			            	$("#recesoDias_horaInicio"+dia).removeClass( "invalid" );
			            	
			            	
			            	$("#recesoDias_horaFin"+dia).removeClass( "valid" );
			            	$("#recesoDias_horaInicio"+dia).removeClass( "valid" );
			            	
			            	
			            	$("#label_recesoDias_horaFin"+dia).removeClass( "active" );
			            	$("#label_recesoDias_horaInicio"+dia).removeClass( "active" );
			            		
			            	cancelarGuardadoRecesoDia(dia);
			            	consultarRecesoDia(dia, idUsuario);
			            		
							Materialize.toast($("#mensajeRecesoDia").html(), 4000);			            				            	
			            		            
			            }//fin succes
	      	});		
			
			
		}else{
			return false;
		}//fin else
		
	
}
//---


//funcion para consultar los recesos de un dia
function consultarRecesoDia(dia, idUsuario){
	

			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/consultarRecesoDia.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario,
	            	    dia			: dia
	            	},success: function(data) {            	
			            		
			            	$("#div_recesos"+dia).html(data);		            				            	
			            		            
			            }//fin succes
	      	});		

	
	
}
//---


//funcion para inactivar receso en dias
function inactivarRecesoDia(idAgendaHorarioReceso, dia){
	
			var idUsuario = $("#selectUsuario_horario").val();
	
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/inactivarRecesoDia.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idAgendaHorarioReceso : idAgendaHorarioReceso
	            	},success: function() {
	            		      			            	
			               consultarRecesoDia(dia, idUsuario);
			                    
			        }//fin succes
	      	});			
	
}
//---




/*************************** Fin Recesos por dias ************************************/


/*************************** Recesos por fechas ************************************/

/*-------------Consultar recesos fechas------------------------*/
function consultarRecesoFechas(idUsuario){
	

		$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/consultarRecesoFechas.php",
	      		
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario	            	    
	            	},
	            success: function(data) {
	            	
	            	$("#div_contenidoRecesosFechas").html(data);
	            		            
	            }
	      	});		
}
//---


//funcion para guardar un receso por fecha
function guardarRecesoFecha(){
	
	if( $("#selectUsuario_horario").val() == null ){
		return false;
	}
	
	var idUsuario = $("#selectUsuario_horario").val();
	var sw = 0;


		//fecha
		if(  $("#fecha_recesoFecha").val().trim().length == 0  ){
			
			$("#label_fecha_recesoFecha").addClass( "active" );
			$("#fecha_recesoFecha").addClass( "invalid" );
			
			sw = 1;
		}
	
		//hora inicio
		if(  $("#fecha_recesoInicioFecha").val().trim().length == 0  ){
			
			$("#label_fecha_recesoInicioFecha").addClass( "active" );
			$("#fecha_recesoInicioFecha").addClass( "invalid" );
			
			sw = 1;
		}
		
		//hora fin
		if(  $("#fecha_recesoFinFecha").val().trim().length == 0 ){
			
			$("#label_fecha_recesoFinFecha").addClass( "active" );
			$("#fecha_recesoFinFecha").addClass( "invalid" );
		  
		    sw = 1;
		}	
		
		if (sw == 0) {
			
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/guardarRecesoFecha.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idUsuario : idUsuario,
	            	    fecha		: $("#fecha_recesoFecha").val(),
	            	    horaInicio  : $("#fecha_recesoInicioFecha").val(),
	            	    horaFin		: $("#fecha_recesoFinFecha").val()
	            	},success: function() {
			            	
			            	Materialize.toast($("#mensajeGuardadoFechaReceso").html(), 4000);	
			            	
			            	consultarRecesoFechas(idUsuario);
			            	
			            	//se limpian los campos
			            	$("#fecha_recesoFecha").val("");
			            	$("#fecha_recesoInicioFecha").val("");
			            	$("#fecha_recesoFinFecha").val("");
			            	
			            	$("#fecha_recesoFecha").removeClass( "invalid" );
			            	$("#fecha_recesoInicioFecha").removeClass( "invalid" );
			            	$("#fecha_recesoFinFecha").removeClass( "invalid" );
			            	
			            	$("#fecha_recesoFecha").removeClass( "valid" );
			            	$("#fecha_recesoInicioFecha").removeClass( "valid" );
			            	$("#fecha_recesoFinFecha").removeClass( "valid" );
			            	
			            	$("#label_fecha_recesoFecha").removeClass( "active" );
			            	$("#label_fecha_recesoInicioFecha").removeClass( "active" );
			            	$("#label_fecha_recesoFinFecha").removeClass( "active" );			            	
			            		            
			            }//fin succes
	      	});		
			
		}else{
			return false;
			
		}
	
}
//---

//funcion para inactivar un receso de una fecha
function inactivarRecesoFecha(idAgendaHorarioRecesoFecha){

			var idUsuario = $("#selectUsuario_horario").val();
	
			$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/agenda/inactivarRecesoFecha.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    idAgendaHorarioRecesoFecha : idAgendaHorarioRecesoFecha
	            	},success: function() {
	            		      			            				            	
			            consultarRecesoFechas(idUsuario);
			                    
			        }//fin succes
	      	});	
	
}
//---


/*************************** Fin Recesos por fechas ************************************/



/*************************** citas ************************************/

//funcion para abrir el formulario de una nueva cita
function mostrarFormNuevaCita(){
	
	if($("#selectUsuario").val() == null){
		$("#div_selectUsuario").addClass("red lighten-3");
		return false;
	}else{
		$("#div_selectUsuario").removeClass("red lighten-3");		
	}

	cancelarEdicionCita();
	cerrarCancelacionCita();

	$("#calendar").removeClass("m12");
	$("#calendar").removeClass("l12");
	
	$("#calendar").addClass("m6");
	$("#calendar").addClass("l6");
	
	$('#calendar').fullCalendar('option', 'height', 600);
	
	$("#hidden_agendarCita").show("slower");
	

	
}
//---

//funcin para cancelar la generacion de una nueva cita
function cancelarNuevaCita(){
	
	$("#hidden_agendarCita").hide('slower');

	$("#calendar").addClass("m12");
	$("#calendar").addClass("l12");
	
	$("#calendar").removeClass("m6");
	$("#calendar").removeClass("l6");
	
	$('#calendar').fullCalendar('option', 'height', 900);
	
	
	//se limpian los campos
	$("#cita_idPropietario").val("0");
	$("#cita_propietario").val("");
	$("#fecha_cita").val("");
	$("#hora_cita").val("");
	$("#duracion_citaHoras").val("");
	$("#duracion_citaMinutos").val("");
	$("#cita_observaciones").val("");
	
	$("#label_cita_propietario").removeClass( "active" );
	
	$(".prefix").removeClass( "active" );
	
	$("#cita_propietario").removeClass( "invalid" );
	$("#cita_propietario").removeClass( "valid" );
	
	$("#fecha_cita").removeClass( "invalid" );
	$("#fecha_cita").removeClass( "valid" );	

	$("#label_hora_cita").removeClass( "invalid" );
	$("#label_hora_cita").removeClass( "valid" );	

	$("#duracion_citaHoras").removeClass( "invalid" );
	$("#duracion_citaHoras").removeClass( "valid" );
	
	$("#duracion_citaMinutos").removeClass( "invalid" );
	$("#duracion_citaMinutos").removeClass( "valid" );
	
	$("#cita_observaciones").removeClass( "invalid" );
	$("#cita_observaciones").removeClass( "valid" );
	
	  var selectList = $("#selectPacienterDelPropietario");
	  selectList.find("option:gt(0)").remove();
      $('#cita_pacientes').material_select('destroy');
      $('#cita_pacientes').material_select();
      
      $("#cita_tipoCita").val("");
      $('#cita_tipoCita').material_select('destroy');
      $('#cita_tipoCita').material_select();
			
	
}
//---



//funcion para realizar la busqueda de un propietario y llenar el select con los pacientes
function buscarPropietarioCita(){
	
	 $('#cita_propietario').autocomplete({
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
	            		   
	            		  $("#cita_idPropietario").val(ui.item.id);   			            				            	
			              $("#selectPacienterDelPropietario").html(data);
			              $('#cita_pacientes').material_select('destroy');
			              $('#cita_pacientes').material_select();
			                    
			        }//fin succes
	      	});		
        			   			
        }
    	
  	}); 
   
	
}
//---


//funcion para refrescar iframe de paciente propietario
function recargarIframePacientePropietario(){
	document.getElementById('iframe_nuevoPropietarioPaciente').contentDocument.location.reload(true);
}
//---

//para guardar un nuevo tipo de cita
function guardarNuevoTipoCita(){
	
		//nombre
		if(  $("#nombreTipoCita").val().trim().length == 0 ){
			
			$("#label_nombreTipoCita").addClass( "active" );
			$("#nombreTipoCita").addClass( "invalid" );
			
			return false;		  
		    
		}	

	
		$.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/tiposCita/guardarTipoCitaAgenda.php",
	            dataType: "html",
	            type : 'POST',
	            data: {
	            	    nombreTipoCita : $("#nombreTipoCita").val()
	            	},success: function(data) {
	            		  
	            		  if(data == "Algo salió mal" || data == "Something went wrong"){
	            		  	 Materialize.toast($("#guardadoTipoCita").html(), 4000);
	            		  	 return false;
	            		  }
	            		  
	            		  
	            		  if(data == 2){
	            		  	Materialize.toast($("#existeTipoCita").html(), 4000);
	            		  }else{
	            		  	
	            		  	$("#btnCerrarModalTipoCita").click();
	            		  	            		  	
	            		  	 $("#div_select_cita_tipoCita").html(data);
			              	 $('#cita_tipoCita').material_select('destroy');
			              	 $('#cita_tipoCita').material_select();
			              	 Materialize.toast($("#guardadoTipoCita").html(), 4000);
	            		  }
	            		      			            				            	
			             
			                    
			        }//fin succes
	      	});		
	
	
}
//---

//funcin para limpiar el formulairo de nuevo tipo de cita
function limpiarFormNuevoTipoCita(){
	
	$("#nombreTipoCita").val("");
	
	$("#nombreTipoCita").removeClass("valid");
    $("#nombreTipoCita").removeClass("invalid");
 
    $("#label_nombreTipoCita").removeClass("active");
	
}
//---


//funcion para guardar una nueva cita
function guardarNuevaCita(){
	
		var sw = 0;

		if(  $("#cita_idPropietario").val() == "0" ){
			
			$("#label_cita_propietario").addClass( "active" );
			$("#cita_propietario").addClass( "invalid" );
			
			sw = 1;			    
		}
		
		if(  ($("#cita_pacientes").val() == "") || ($("#cita_pacientes").val() == null)  ){
			
			$("#selectPacienterDelPropietario").addClass( "red lighten-3" );
			
			sw = 1;			    
		}else{
			$("#selectPacienterDelPropietario").removeClass( "red lighten-3" );
		}	
						
	
		if(  $("#fecha_cita").val().trim().length == 0 ){
			
			$("#label_fecha_cita").addClass( "active" );
			$("#fecha_cita").addClass( "invalid" );
			
			sw = 1;			    
		}		

		if(  $("#hora_cita").val().trim().length == 0 ){
			
			$("#label_hora_cita").addClass( "active" );
			$("#hora_cita").addClass( "invalid" );
			
			sw = 1;			    
		}	

		if(  $("#duracion_citaHoras").val().trim().length == 0 ){
			
			$("#label_duracion_citaHoras").addClass( "active" );
			$("#duracion_citaHoras").addClass( "invalid" );
			
			sw = 1;			    
		}	

		if(  $("#duracion_citaMinutos").val().trim().length == 0 ){
			
			$("#label_duracion_citaMinutos").addClass( "active" );
			$("#duracion_citaMinutos").addClass( "invalid" );
			
			sw = 1;			    
		}	
		
		if(sw == 0){
			
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/agenda/guardarCita.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            		idUsuario				: $("#selectUsuario").val(),
		            	    idPropietario 			: $("#cita_idPropietario").val(),
		            	    idPaciente				: $("#cita_pacientes").val(),
		            	    tipoCita				: $("#cita_tipoCita").val(),
		            	    fecha_cita				: $("#fecha_cita").val(),
		            	    hora_cita				: $("#hora_cita").val(),
		            	    duracion_citaHoras		: $("#duracion_citaHoras").val(),
		            	    duracion_citaMinutos	: $("#duracion_citaMinutos").val(),
		            	    observaciones			: $("#cita_observaciones").val(),
		            	    otrosUsuarios			: $("#otrosUsuarios").val()
		            	    
		            	    
		            	},success: function(data) {
		            		  
		            		  
		            		    cancelarNuevaCita();  	
		            		    $("#calendar").fullCalendar( 'refetchEvents' );		            				            	
				             
				                    
				        }//fin succes
		      	});	

			
		}//fin if sw == 0

	
}
//---


//funcion para mostrar la edicion de una cita
function editarCitaUsuario(idCita){
	
	$("#editar_fecha_cita").removeClass( "invalid" );
	$("#editar_fecha_cita").removeClass( "valid" );	

	$("#editar_hora_cita").removeClass( "invalid" );
	$("#editar_hora_cita").removeClass( "valid" );	

	$("#editar_duracion_citaHoras").removeClass( "invalid" );
	$("#editar_duracion_citaHoras").removeClass( "valid" );
	
	$("#editar_duracion_citaMinutos").removeClass( "invalid" );
	$("#editar_duracion_citaMinutos").removeClass( "valid" );
	
	cancelarNuevaCita();
	cancelarBusquedaCita();
	cerrarCancelacionCita();
	
	$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/agenda/consultarDatosCita.php",
		            dataType: "json",
		            type : 'POST',
		            data: {
		            		idCita				: idCita,		            	    
		            	    
		            	},success: function(data) {           		  
		            		  	
		            		  //se llenan los campos	
		            		  $("#idCitaEditar").val(idCita);
		            		  	            		  
		            		  $("#label_editar_cita_propietario").addClass("active");
		            		  
		            		  $("#editar_cita_propietario").val(data[0].identificacion+' '+data[0].nombrePropietario+' '+data[0].apellido);
		            		  
		            		  $("#aEnlacePaciente").attr("href", "http://www.nanuvet.com/historiaClinica/"+data[0].idMascota+"/consultas/")
		            		  
		            		  $('#editar_cita_pacientes').append($('<option>', {
								    value: data[0].idMascota,
								    text: data[0].nombrePaciente
								}));
								
								 $('#editar_cita_pacientes').material_select('destroy');
								 $('#editar_cita_pacientes').material_select();
								 
								 //si existe el tipo de cita en el select
								 if($("#editar_cita_tipoCita option[value='"+data[0].idTipoCita+"']").length > 0){
								 	
								 	$("#editar_cita_tipoCita").val(data[0].idTipoCita);
								 	
								 }else{
								 	
								 	$('#editar_cita_tipoCita').append($('<option>', {
								    	value: data[0].idTipoCita,
								    	text: data[0].nombreTipoCita,
								    	class: "TipoCitaAdicionado"
									}));
								 	
								 	$("#editar_cita_tipoCita").val(data[0].idTipoCita);
								 }
		            		  	    
 								 $('#editar_cita_tipoCita').material_select('destroy');
								 $('#editar_cita_tipoCita').material_select();		
								 
								 $("#editar_fecha_cita").val(data[0].fecha);  
								 $("#editar_hora_cita").val(data[0].horaInicio);  
								 $("#editar_duracion_citaHoras").val(data[0].duracionHoras);  
								 $("#editar_duracion_citaMinutos").val(data[0].duracionMinutos);  
								 
								 $("#label_editar_cita_observaciones").addClass("active");
								 $("#editar_cita_observaciones").val(data[0].observaciones);            		  	           		  
		            		 	 
		            		  
		            		 	$.ajax({
						      		url: "http://www.nanuvet.com/Controllers/agenda/consultarUsuariosCita.php",
						            dataType: "json",
						            type : 'POST',
						            data: {
						            		idCita				: idCita,		            	    
						            	    
						            	},success: function(data2) {           		  
						            		  
						            		  $('#editar_otrosUsuarios').material_select('destroy');
						            		  $('#editar_otrosUsuarios').material_select();
						            		  
						            		   	 //se recorre el select de otros usuarios editar
											 	 $("#editar_otrosUsuarios option").each(function(){
													
											    	$("#divOtrosUsuarios").find('span:contains("'+$(this).text()+'")').parent('li').attr('id', 'multipleEditando'+$(this).val());
											    	$('#multipleEditando'+$(this).val()).attr("onClick", 'comprobarSeleccionMultipleEdicionCita(this.id)');
													
												});	
						            		  
						            		  
						            		  for (var i=0; i < data2.length; i++) {
												
												//idUsuarios.push(data2[i].identificacion);	
												$("#divOtrosUsuarios").find('span:contains("'+data2[i].identificacion+'")').parent('li').click();										
												
												
											  };
											  
											  $("#editar_cita_observaciones").click();
						            		  
						            		  
								                    
								        }//fin succes
						      	});    			            				            	
				             
				                    
				        }//fin succes
		      	});	
	
	
	$("#calendar").removeClass("m12");
	$("#calendar").removeClass("l12");
	
	$("#calendar").addClass("m6");
	$("#calendar").addClass("l6");
	
	$('#calendar').fullCalendar('option', 'height', 600);
	
		
	
	$("#hidden_editarCita").show("slower");	
	
	
}
//---


//funcin para cancelar la generacion de una nueva cita
function cancelarEdicionCita(){
	
	$("#hidden_editarCita").hide('slower');

	$("#calendar").addClass("m12");
	$("#calendar").addClass("l12");
	
	$("#calendar").removeClass("m6");
	$("#calendar").removeClass("l6");
	
	$('#calendar').fullCalendar('option', 'height', 900);
	
	
	//se limpian los campos
	$("#idCitaEditar").val("0");
	
	$("#editar_cita_propietario").val("");
	
	//se remueven las opciones de los select
	$('#editar_cita_pacientes')
	    .find('option')
	    .remove()
	    .end()
	;
	
	$('#editar_cita_tipoCita')
	    .find('.TipoCitaAdicionado')
	    .remove()
	    .end()
	;	
	
	
	$("#editar_fecha_cita").val("");
	$("#editar_hora_cita").val("");
	$("#editar_duracion_citaHoras").val("");
	$("#editar_duracion_citaMinutos").val("");
	
	$("#editar_otrosUsuarios").val("");
	
	$("#editar_cita_observaciones").val("");
	
	
	  $('#editar_cita_pacientes').material_select('destroy');
	  $('#editar_cita_pacientes').material_select();
	
	  $('#editar_cita_tipoCita').material_select('destroy');
	  $('#editar_cita_tipoCita').material_select();	

	
	$("#editar_fecha_cita").removeClass( "invalid" );
	$("#editar_fecha_cita").removeClass( "valid" );	

	$("#editar_hora_cita").removeClass( "invalid" );
	$("#editar_hora_cita").removeClass( "valid" );	

	$("#editar_duracion_citaHoras").removeClass( "invalid" );
	$("#editar_duracion_citaHoras").removeClass( "valid" );
	
	$("#editar_duracion_citaMinutos").removeClass( "invalid" );
	$("#editar_duracion_citaMinutos").removeClass( "valid" );
	
			
	
}
//---


//funcion para guardar la edicion de una cita
function guardarEdicionCita(){

		var sw = 0;
		

		if(  $("#editar_otrosUsuarios").val() == "" || $("#editar_otrosUsuarios").val() == null || $("#editar_otrosUsuarios").val() == "[]" ){
			
			$("#divOtrosUsuarios").addClass("red lighten-3");
			
			sw = 1;		
				    
		}else{
			
			$("#divOtrosUsuarios").removeClass("red lighten-3");
			
		}	
						
	
		if(  $("#editar_fecha_cita").val().trim().length == 0 ){
			
			$("#label_editar_fecha_cita").addClass( "active" );
			$("#editar_fecha_cita").addClass( "invalid" );
			
			sw = 1;			    
		}		

		if(  $("#editar_hora_cita").val().trim().length == 0 ){
			
			$("#label_editar_hora_cita").addClass( "active" );
			$("#editar_hora_cita").addClass( "invalid" );
			
			sw = 1;			    
		}	

		if(  $("#editar_duracion_citaHoras").val().trim().length == 0 ){
			
			$("#label_editar_duracion_citaHoras").addClass( "active" );
			$("#editar_duracion_citaHoras").addClass( "invalid" );
			
			sw = 1;			    
		}	

		if(  $("#editar_duracion_citaMinutos").val().trim().length == 0 ){
			
			$("#label_editar_duracion_citaMinutos").addClass( "active" );
			$("#editar_duracion_citaMinutos").addClass( "invalid" );
			
			sw = 1;			    
		}	
		
		if(sw == 0){
			
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/agenda/editarCita.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            		
		            	    idCita					: $("#idCitaEditar").val(),
		            	    tipoCita				: $("#editar_cita_tipoCita").val(),
		            	    fecha_cita				: $("#editar_fecha_cita").val(),
		            	    hora_cita				: $("#editar_hora_cita").val(),
		            	    duracion_citaHoras		: $("#editar_duracion_citaHoras").val(),
		            	    duracion_citaMinutos	: $("#editar_duracion_citaMinutos").val(),
		            	    observaciones			: $("#editar_cita_observaciones").val(),
		            	    otrosUsuarios			: $("#editar_otrosUsuarios").val()
		            	    
		            	    
		            	},success: function(data) {
		            		  
		            		  
		            		    cancelarEdicionCita();  
		            		    $("#calendar").fullCalendar( 'refetchEvents' );
		            		    			            				            	
				             
				                    
				        }//fin succes
		      	});	

			
		}//fin if sw == 0



	
	
}
//----


//funcion para comprobar realmente la seleccion de los otros usuarios vinculados
function comprobarSeleccionMultipleNuevaCita(id){
	
	//multipleCreando
   		
    		
 	if( !$('#'+id).find('input').prop('checked') ) {	    
				id = id.slice(15);
				var valorSelect = $("#otrosUsuarios").val();
			
				valorSelect = jQuery.grep(valorSelect, function(value) {
				  return value != id;
				});
		
				$("#otrosUsuarios").val(valorSelect);
	
		}   		
    		
	

	
	
}
//---

//fuincion para que realmente se seleccionen los usuarios que son en otros usuarios editando

function comprobarSeleccionMultipleEdicionCita(id){
	
	//multipleEditando
   		
    		
 	if( !$('#'+id).find('input').prop('checked') ) {	    
				id = id.slice(16);
				var valorSelect = $("#editar_otrosUsuarios").val();
			
				valorSelect = jQuery.grep(valorSelect, function(value) {
				  return value != id;
				});
		
				$("#editar_otrosUsuarios").val(valorSelect);
	
		}   		

	
}
//---




/*************************** Fin citas ************************************/


/*************************** buscador ************************************/

//funcion para mostrar el formulario de busqueda
function mostrarFormBuscarCitas(){
	
	$("#div_hiddenBuscarcitas").show("slower");
}
//---

//funcion para realizar la busqueda de un propietario para la busqueda de citas
function buscarPropietarioBuscarCita(){
	
	 $('#buscarCita_propietario').autocomplete({
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
        	
        	   $("#buscarCita_idPropietario").val(ui.item.id); 		
        			   			
        }
    	
  	}); 
   
	
}
//---


//metodo para aplicar los parametros de busqueda de la citas
function aplicarBusquedaCitas(){
	
		if(  $("#buscarCita_propietario").val().trim().length == 0 ){
			
			$("#label_buscarCita_propietario").addClass( "active" );
			$("#buscarCita_propietario").addClass( "invalid" );
			
			return false;			    
		}		

		$("#resultadoBusquedaCitas").html($("#div_preloader").html());
		
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/agenda/buscarCitas.php",
            dataType: "html",
            type : 'POST',
            data: {
            		
            	    idPropietario				: $("#buscarCita_idPropietario").val(),
            	    fechaInicial				: $("#buscarCitaFechaInicial").val(),
            	    fechaFinal					: $("#buscarCitaFechaFinal").val()
            	    
            	    
            	},success: function(data) {
            		            		    			            				            	
		             $("#resultadoBusquedaCitas").html(data);
		                    
		        }//fin succes
      	});	
	
}
//--

//funcion para cerrar la busqueda de citas
function cancelarBusquedaCita(){
	
	$("#div_hiddenBuscarcitas").hide("slower");
	$("#resultadoBusquedaCitas").html("");
	
	$("#buscarCita_idPropietario").val("0");
	
	$("#buscarCitaFechaInicial").val("");
	$("#buscarCitaFechaFinal").val("");
	$("#buscarCita_propietario").val("");
	
	$("#buscarCita_propietario").removeClass("valid");
	$("#buscarCita_propietario").removeClass("invalid");
	
	$("#buscarCitaFechaInicial").removeClass("valid");
	$("#buscarCitaFechaInicial").removeClass("invalid");
	
	$("#buscarCitaFechaFinal").removeClass("valid");
	$("#buscarCitaFechaFinal").removeClass("invalid");		
	
}
//--


/*************************** Fin buscador ************************************/


/*************************** cancelar cita ************************************/

//funcion para abrir el formulario de cancelar cita
function abrirFormCanelarCita(){
	
	$("#motivoCancelacion").val("");
	
	$("#label_motivoCancelacion").removeClass("active");
	$("#motivoCancelacion").removeClass("valid");
	$("#motivoCancelacion").removeClass("invalid");
	
	$("#divHiddenCancelarCita").show("slower");

}
//---

//funcion para cerrar la cancelacion de una cita
function cerrarCancelacionCita(){
	
	$("#divHiddenCancelarCita").hide("slower");
	
}
//---

//funcion para confirmar la cancelacion de la cita
function cancelarCita(){
	
	if(  $("#motivoCancelacion").val().trim().length == 0 ){
		
		$("#label_motivoCancelacion").addClass( "active" );
		$("#motivoCancelacion").addClass( "invalid" );
		
		return false;			    
	}


		swal({
		  title: 'Estas seguro de cancelar la cita?',
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: 'Si, cancelarla',
		  cancelButtonText: 'No!',
		},function(){


				$.ajax({
			  		url: "http://www.nanuvet.com/Controllers/agenda/cancelarCitas.php",
			        dataType: "html",
			        type : 'POST',
			        data: {
			        		
			        	    idCita				: $("#idCitaEditar").val(),
			        	    motivoCancelacion   : $("#motivoCancelacion").val()
			        	    
			        	    
			        	},success: function() {
			        		
			        		cancelarEdicionCita();  
					        $("#calendar").fullCalendar( 'refetchEvents' );            		    			   
			        		            		    			   
				                    
				        }//fin succes
			  	});	

			
		});





	
}
//---


/*************************** Fin cancelar cita ************************************/


