/*
 * Archivo que contiene las funciones de la historia clinica
 */


//funcion para decidir el tipo impresion de historia clinica
function tipoImpresionHistoriaClinica(){
	
	$('#modal_impresionHC').openModal();	
	
}
//---



$(document).ready(function () {
	//para modificar la posicion del indicator y que se vea bien
	if($(".modificarIndicatorVacuna").length > 0){
		
			$(".indicator").css('right','0px', 'important');
			$(".indicator").css('left','1101px', 'important'); 
	}  

	if($(".modificarIndicatorHospitalizacion").length > 0){
		
			$(".indicator").css('right','166px', 'important');
	}  	

});


//funcines para redireccionar, segun los items de la historia clinica
function redireccionEnHC(url){
	
        	window.location=url;

}
//--



/*
 * Consultas
 */


//limpiar los datos del modal de nuevo diagnostico
function limpiarModalDiagnosticoConsulta(){
	
	
	
	$("#nombreDiagnostico").val("");
	$("#codigoDiagnostico").val("");
	$("#observacionDiagnostico").val("");
	
	//se remueve las clases activas
	$("#label_nombreDiagnostico").removeClass("active");
	$("#label_codigoDiagnostico").removeClass("active");
	$("#label_observacionDiagnostico").removeClass("active");
	
	
	$("#nombreDiagnostico").removeClass("valid");
	$("#codigoDiagnostico").removeClass("valid");
	$("#observacionDiagnostico").removeClass("valid");
	

	$("#nombreDiagnostico").removeClass("invalid");
	$("#codigoDiagnostico").removeClass("invalid");
	$("#observacionDiagnostico").removeClass("invalid");	
	
}
//---

//funcion para validar el guardado de un nuevo diagnostico
function guardarNuevoDiagnosticoConsulta(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreDiagnostico").addClass( "active" );
		$("#nombreDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#codigoDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoDiagnostico").addClass( "active" );
		$("#codigoDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	
	
	
	if(sw == 1){
		return false;
	}else{
		
			  $.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/consultas/guardarDiagnosticoConsulta.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    nombre : $("#nombreDiagnostico").val(), codigo: $("#codigoDiagnostico").val(), observacion: $("#observacionDiagnostico").val(),
		            	},
		            success: function(data) {
		            		$('#modal_nuevoDiagnostico').closeModal();
							Materialize.toast(data, 4000);	                 
		            }
		      	});	
	}	
		
}
//---

//generar un codigo aleatorio
function generarCodigodiagnosticoConsulta(idCampo){
	
	var numeros = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
	var letras  = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "W", "X", "Y", "Z" ];
	var ln = 0;
	var n  = 0;
	var l  = 0;
	var string = "";
	
	for(var i = 0; i < 10; i++){
		
		ln = (Math.floor(Math.random() * 2) + 1);
		
		if(ln == 1){
			
			n = (Math.floor(Math.random() * 9) + 1);
			string = string+numeros[n];
			
		}else{
			l = (Math.floor(Math.random() * 24) + 1);
			string = string+letras[l];
		}
		

		
	}//fin for
	
		$("#"+idCampo).val(string);
		$("#label_"+idCampo).addClass( "active" );	
}
//---


//abrir el formulario nueva consulta
function abrirFormNuevaConsulta(){
	
	
	$("#hidden_nuevaConsulta").show();
	$("#form_nuevaConsulta").addClass('unsavedForm');
	$("#tituloLi").hide();
	$("#tab_principalConsulta").click();

	
}

//funcion para consultar las notas aclaratorias de una consulta
function consultarNotasAclaratoriasConsulta(idConsulta){
	
				$("#idConsultaNotaAclaratoria").val(idConsulta);
				
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/consultas/notasAclaratoriasController.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idConsulta : idConsulta
		            	},
		            beforeSend: function() {
					     $('#resultadoBusquedaNotasAclaratorias').addClass('center-align');
					     $('#resultadoBusquedaNotasAclaratorias').html('<div class="preloader-wrapper big active"><div class="spinner-layer  spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
					  },
					complete: function(){
					     $('#resultadoBusquedaNotasAclaratorias').removeClass('center-align');
					  },
		            success: function(data) {
		               $("#textoNotaAclaratoria").val("");
		               $("#label_textoNotaAclaratoria").removeClass( "active" );
					   $("#textoNotaAclaratoria").removeClass( "invalid" )
					   $("#textoNotaAclaratoria").removeClass( "valid" )
		               $("#resultadoBusquedaNotasAclaratorias").html(data);
								                 
		            }
		      	});
	
}
//---

//funcion para guardar una nota aclaratoria
function guardarNotaAclaratoria(){
	
	if( $("#textoNotaAclaratoria").val().trim().length == 0 ){
		
		$("#label_textoNotaAclaratoria").addClass( "active" );
		$("#textoNotaAclaratoria").addClass( "invalid" );
		return false;
	}else{
		
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/consultas/guardarNotaAclaratoriaController.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idConsulta : $("#idConsultaNotaAclaratoria").val(), textoNota: $("#textoNotaAclaratoria").val()
		            	},
		            success: function(data) {
		            	
		               var idConsulta = $("#idConsultaNotaAclaratoria").val();
		               consultarNotasAclaratoriasConsulta(idConsulta);
								                 
		            }
		      	});		
		
	}
	
	
	
	
}
//---


//cancelar una nueva consulta
function cancelarGuardadoNuevoConsulta(){
	
	//pedir confirmacion
		swal({
		  title: $("#estaSeguro").html(),
		  text: $("#Seperderan").html(),
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: $("#SiCancelarla").html(),
		  cancelButtonText: 'No!',
		},function(){
			
			$("#hidden_nuevaConsulta").hide("slower");
			$("#form_nuevaConsulta").removeClass('unsavedForm');
			$("#tituloLi").show("slower");		

			//se limpia todo
			consulta_limpiarTextareaMotivoConsulta();
			consulta_limpiarTextareaObservacionesConsulta();
			consulta_limpiarTextareaPlanConsulta();
			consulta_limpiarTextareaObservacionesExamenF();
			
			$("#ul_Diagnosticos").empty();
			
			$("#pesoExamenF").val("");
			$("#alturaExamenF").val("");
			$("#temperaturaExamenF").val("");

			$("#label_pesoExamenF").removeClass("active");
			$("#label_alturaExamenF").removeClass("active");
			$("#label_temperaturaExamenF").removeClass("active");
			
			$("#pesoExamenF").removeClass("valid");
			$("#alturaExamenF").removeClass("valid");
			$("#temperaturaExamenF").removeClass("valid");
	

			$("#pesoExamenF").removeClass("invalid");
			$("#alturaExamenF").removeClass("invalid");
			$("#temperaturaExamenF").removeClass("invalid");
			
			cancelarGuardadoNuevoItemExamenF();
			
			//se quitan todos los input creados segun el contador
			for(var j = 0; j <= parseInt($("#contadorLIIEF").val()); j++ ){				
				
				$("#iEFNombre_"+j).remove();
				$("#iEFObservacion_"+j).remove();
				$("#iEFEstado_"+j).remove();
				
			}//fin for
			
			
			$("#contadorLIIEF").val("0");
			$('#ulItemsExamenFisico li:not(:first)').remove();
			
			$('#ul_Diagnosticos li').remove();
			

			$('#select_diagnosticos').find('option').remove();
			
			$('select').material_select();



			
		});
	
}
//---


//para validar el guardado de una consulta
function validarGuardadoNuevaConsulta(){
	
	if( ($("#select_diagnosticos").val() == undefined) || ($("#select_diagnosticos").val() == null) || ($("#select_diagnosticos").val() == 'null')  ){
		
		$("#spanErrorGuardar").show("slower");
			
	}else{	
		
		$("#spanErrorGuardar").hide("slower");
		$("#form_nuevaConsulta").removeClass('unsavedForm');
		$("#form_nuevaConsulta").submit();
	}
	
}
//---





/*Motivo consulta*/

//obtener el contenido de lo que se escribió en el editor motivo consulta
function consulta_ObtenerTxtMotivoConsulta(){
	
	var contenido = $("#iframe_motivoConsulta").contents().find("#editor").html();
	
	$("#contenidoEditorMotivoConsulta").html($("#tituloMotivoConsulta").html());
	
	$("#contenidoEditorMotivoConsulta").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_motivoConsulta").html($("#motivoConsulta").val())
	$("#motivoConsulta").val(contenido);
	
	$("#motivoConsulta").hide("slower");
	$("#label_motivoConsulta").hide("slower");
	$("#contenidoEditorMotivoConsulta").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function consulta_recuperarTextareaMotivoConsulta(){
	
	$("#motivoConsulta").val($("#contenidoTextoTexarea_motivoConsulta").html().trim());
	$("#label_motivoConsulta").addClass("active");
	$("#contenidoEditorMotivoConsulta").hide("slower");
	
	$("#motivoConsulta").show("slower");
	$("#label_motivoConsulta").show("slower");	
	
}
//---

//limpiar textarea motivo consulta
function consulta_limpiarTextareaMotivoConsulta(){

	$("#motivoConsulta").val("");
	
	$("#contenidoEditorMotivoConsulta").hide("slower");
	$("#label_motivoConsulta").removeClass("active");
	$("#motivoConsulta").show("slower");
	$("#label_motivoConsulta").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en motivo de consulta
function consulta_buscarPersonalizadoMotivoConsulta(){

	
   $('#buscarPersonalizadoMC').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoMotivoConsultaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoMotivoConsultaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoMotivoConsulta").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoMotivoConsulta(){
	
	$("#motivoConsulta").val($("#textoUtilizarPersonalizadoMotivoConsulta").html());
	
	$("#contenidoEditorMotivoConsulta").html($("#tituloMotivoConsulta").html());
	$("#contenidoEditorMotivoConsulta").append($("#textoUtilizarPersonalizadoMotivoConsulta").html());
	
	$("#motivoConsulta").hide("slower");
	$("#label_motivoConsulta").hide("slower");	
	
	$("#contenidoEditorMotivoConsulta").show("slower");
	
	$("#iframe_motivoConsulta").contents().find("#editor").html($("#textoUtilizarPersonalizadoMotivoConsulta").html());
	
	
}
//---

/*Fin Motivo consulta*/


/*Observaciones consulta*/

//obtener el contenido de lo que se escribió en el editor observaciones consulta
function consulta_ObtenerTxtObservacionesConsulta(){
	
	var contenido = $("#iframe_observacionesConsulta").contents().find("#editor").html();
	
	$("#contenidoEditorObservacionesConsulta").html($("#tituloObservacionesConsulta").html());
	
	$("#contenidoEditorObservacionesConsulta").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observacionesConsulta").html($("#observacionesConsulta").val())
	$("#observacionesConsulta").val(contenido);
	
	$("#observacionesConsulta").hide("slower");
	$("#label_observacionesConsulta").hide("slower");
	$("#contenidoEditorObservacionesConsulta").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function consulta_recuperarTextareaObservacionesConsulta(){
	
	$("#observacionesConsulta").val($("#contenidoTextoTexarea_observacionesConsulta").html().trim());
	$("#label_observacionesConsulta").addClass("active");
	$("#contenidoEditorObservacionesConsulta").hide("slower");
	
	$("#observacionesConsulta").show("slower");
	$("#label_observacionesConsulta").show("slower");	
	
}
//---

//limpiar textarea observaciones consulta
function consulta_limpiarTextareaObservacionesConsulta(){

	$("#observacionesConsulta").val("");
	
	$("#contenidoEditorObservacionesConsulta").hide("slower");
	$("#label_observacionesConsulta").removeClass("active");
	$("#observacionesConsulta").show("slower");
	$("#label_observacionesConsulta").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de consulta
function consulta_buscarPersonalizadoObservacionesConsulta(){

	
   $('#buscarPersonalizadoOC').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesConsultaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesConsultaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesConsulta").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesConsulta(){
	
	$("#observacionesConsulta").val($("#textoUtilizarPersonalizadoObservacionesConsulta").html());
	
	$("#contenidoEditorObservacionesConsulta").html($("#tituloObservacionesConsulta").html());
	$("#contenidoEditorObservacionesConsulta").append($("#textoUtilizarPersonalizadoObservacionesConsulta").html());
	
	$("#observacionesConsulta").hide("slower");
	$("#label_observacionesConsulta").hide("slower");	
	
	$("#contenidoEditorObservacionesConsulta").show("slower");
	
	$("#iframe_observacionesConsulta").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesConsulta").html());
	
	
}
//---
/*Fin Observaciones consulta*/


/*Plan consulta*/

//obtener el contenido de lo que se escribió en el editor plan consulta
function consulta_ObtenerTxtPlanConsulta(){
	
	var contenido = $("#iframe_planConsulta").contents().find("#editor").html();
	
	$("#contenidoEditorPlanConsulta").html($("#tituloPlanConsulta").html());
	
	$("#contenidoEditorPlanConsulta").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_planConsulta").html($("#planConsulta").val())
	$("#planConsulta").val(contenido);
	
	$("#planConsulta").hide("slower");
	$("#label_planConsulta").hide("slower");
	$("#contenidoEditorPlanConsulta").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function consulta_recuperarTextareaPlanConsulta(){
	
	$("#planConsulta").val($("#contenidoTextoTexarea_planConsulta").html().trim());
	$("#label_planConsulta").addClass("active");
	$("#contenidoEditorPlanConsulta").hide("slower");
	
	$("#planConsulta").show("slower");
	$("#label_planConsulta").show("slower");	
	
}
//---

//limpiar textarea plan consulta
function consulta_limpiarTextareaPlanConsulta(){

	$("#planConsulta").val("");
	
	$("#contenidoEditorPlanConsulta").hide("slower");
	$("#label_planConsulta").removeClass("active");
	$("#planConsulta").show("slower");
	$("#label_planConsulta").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en plan de consulta
function consulta_buscarPersonalizadoPlanConsulta(){

	
   $('#buscarPersonalizadoPC').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoPlanConsultaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoPlanConsultaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoPlanConsulta").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoPlanConsulta(){
	
	$("#planConsulta").val($("#textoUtilizarPersonalizadoPlanConsulta").html());
	
	$("#contenidoEditorPlanConsulta").html($("#tituloPlanConsulta").html());
	$("#contenidoEditorPlanConsulta").append($("#textoUtilizarPersonalizadoPlanConsulta").html());
	
	$("#planConsulta").hide("slower");
	$("#label_planConsulta").hide("slower");	
	
	$("#contenidoEditorPlanConsulta").show("slower");
	
	$("#iframe_planConsulta").contents().find("#editor").html($("#textoUtilizarPersonalizadoPlanConsulta").html());
	
	
}
//---
/*Fin plan consulta*/



//buscar un diagnostico
function consulta_buscarDiagnostico(){
	
	$("#buscarDiagnostico").removeClass("valid");	

	$("#buscarDiagnostico").removeClass("invalid");


   $('#buscarDiagnostico').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term, utilizar: "Si"
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
				 
				 var txtRemover = $("#removerDX").html(); 
				 
				 if ( !$("#liDx_"+id).length ) {
				 	
						$('#select_diagnosticos').append('<option value="'+id+'" selected="selected"></option>');						
						$('#ul_Diagnosticos').append('<li id="liDx_'+id+'" class="collection-item"><div>('+codigoDX+') '+nombreDX+'<a id="'+id+'" onclick="quitarDiagnostico(this.id)" href="javascript:void(0)" class="secondary-content tooltipped" data-position="left" data-delay="50" data-tooltip="'+txtRemover+'" ><i class="material-icons">delete</i></a></div></li>');
		    					    			
		    					    			
		    			$('.tooltipped').tooltip();
		    			
		    			this.value = "";
    					return false;
		    			
				} else{
					
							$("#label_buscarDiagnostico").addClass( "active" );
							$("#buscarDiagnostico").addClass( "invalid" );
							
					
				}//fin else		
		   			
        }
    	
  	}); 
  	


	
}
//---


//para remover el diagnostico de una consulta
function quitarDiagnostico (idDx) {
  
  $("#select_diagnosticos option[value='"+idDx+"']").remove();
  
  $('#liDx_'+idDx).remove();
  
  
  $('.material-tooltip').hide();
  $('.tooltipped').tooltip();
  
  
}
//---


/*
 * Fin Consultas
 */



/*
 * Examen fisico
 */

//abrir el formulario para adicionar un nuevo item
function abrirFormNuevoItemEF(){
	
	$("#dviNuevoItem").show('slower');
	
}
//---

//cancelar la creacion de un item
function cancelarGuardadoNuevoItemExamenF(){
	
	$("#dviNuevoItem").hide('slower');
	
	$("#nombreItemExamenF").val("");
	$("#observacionesItemExamenF").val("");
	
	$('#estadoItemExamenF').material_select('destroy');
	
	$("#estadoItemExamenF").val("NA");
	
	$('#estadoItemExamenF').material_select();
	
	$("#label_nombreItemExamenF").removeClass("active");
	$("#label_observacionesItemExamenF").removeClass("active");
	
	$("#nombreItemExamenF").removeClass("valid");
	$("#observacionesItemExamenF").removeClass("valid");	

	$("#nombreItemExamenF").removeClass("invalid");
	$("#observacionesItemExamenF").removeClass("invalid");
	
}
//----

//validar la adicion de un nuevo item examen fisico
function validarGuardadoNuevoItemExamenF(){
	
	var nombre 			= $("#nombreItemExamenF").val();
	var observacion 	= $("#observacionesItemExamenF").val();
	var estado			= $("#estadoItemExamenF option:selected").text();
	



	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#nombreItemExamenF").val().trim().length == 0 ){
		
		$("#label_nombreItemExamenF").addClass( "active" );
		$("#nombreItemExamenF").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		var numeroContador 	= $("#contadorLIIEF").val();
		numeroContador = parseInt(numeroContador);	
		
		numeroContador = numeroContador+1;
		
		$("#ulItemsExamenFisico").append('<li id="liItemEF_'+numeroContador+'" class="collection-item"><div class="row"><div class="col s4 m2 l2">'+nombre+'</div><div class="col s7 m8 l8">'+observacion+'</div><div class="col s1 m2 l2">'+estado+'</div><a href="javascript:void(0)" id="'+numeroContador+'" onclick="removerItemExamenFisico(this.id)" class="secondary-content"  ><i class="material-icons">delete</i></a></div></li>');
	

		$('#form_nuevaConsulta').append('<input type="hidden" id="iEFNombre_'+numeroContador+'" name="iEFNombre_'+numeroContador+'" value="'+nombre+'" />');
		$('#form_nuevaConsulta').append('<input type="hidden" id="iEFObservacion_'+numeroContador+'" name="iEFObservacion_'+numeroContador+'" value="'+observacion+'" />');
		$('#form_nuevaConsulta').append('<input type="hidden" id="iEFEstado_'+numeroContador+'" name="iEFEstado_'+numeroContador+'" value="'+$("#estadoItemExamenF").val()+'" />');


		$("#contadorLIIEF").val(numeroContador);
		
		cancelarGuardadoNuevoItemExamenF();
	}



	
	
	
}
//-----

//remover un item de examen fisico
function removerItemExamenFisico(idLi){
	
	var numeroContador 	= $("#contadorLIIEF").val();
	numeroContador = parseInt(numeroContador);	
	
	$("#iEFNombre_"+idLi).remove();
	$("#iEFObservacion_"+idLi).remove();
	$("#iEFEstado_"+idLi).remove();
	
	
	numeroContador = numeroContador-1;
	
	$('#liItemEF_'+idLi).remove();

	$("#contadorLIIEF").val(numeroContador);
	
}
//---



//obtener el contenido de lo que se escribió en el editor observaciones examen fisico
function consulta_ObtenerTxtObservacionesExamenFisico(){
	
	var contenido = $("#iframe_observacionesExamenFisico").contents().find("#editor").html();
	
	$("#contenidoEditorObservacionesExamenF").html($("#tituloObservacionesExamenF").html());
	
	$("#contenidoEditorObservacionesExamenF").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observacionesExamenF").html($("#observacionesExamenF").val())
	$("#observacionesExamenF").val(contenido);
	
	$("#observacionesExamenF").hide("slower");
	$("#label_observacionesExamenF").hide("slower");
	$("#contenidoEditorObservacionesExamenF").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function consulta_recuperarTextareaObservacionesExamenF(){
	
	$("#observacionesExamenF").val($("#contenidoTextoTexarea_observacionesExamenF").html().trim());
	$("#label_observacionesExamenF").addClass("active");
	$("#contenidoEditorObservacionesExamenF").hide("slower");
	
	$("#observacionesExamenF").show("slower");
	$("#label_observacionesExamenF").show("slower");	
	
}
//---

//limpiar textarea observaciones examen fisico
function consulta_limpiarTextareaObservacionesExamenF(){

	$("#observacionesExamenF").val("");
	
	$("#contenidoEditorObservacionesExamenF").hide("slower");
	$("#label_observacionesExamenF").removeClass("active");	
	$("#observacionesExamenF").show("slower");
	$("#label_observacionesExamenF").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de examen fisico
function consulta_buscarPersonalizadoObservacionesExamenFisico(){

	
   $('#buscarPersonalizadoOEF').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesExamenFisicoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesExamenFisicoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesExamenFisico").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesExamenFisico(){
	
	$("#observacionesExamenF").val($("#textoUtilizarPersonalizadoObservacionesExamenFisico").html());
	
	$("#contenidoEditorObservacionesExamenF").html($("#tituloObservacionesExamenF").html());
	$("#contenidoEditorObservacionesExamenF").append($("#textoUtilizarPersonalizadoObservacionesExamenFisico").html());
	
	$("#observacionesExamenF").hide("slower");
	$("#label_observacionesExamenF").hide("slower");	
	
	$("#contenidoEditorObservacionesExamenF").show("slower");
	
	$("#iframe_observacionesExamenFisico").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesExamenFisico").html());
	
	
}
//---


//validar que el input file de adjuntar archivos no se encuentre vacio
function validarAdjuntosConsulta(idConsulta){
	
	//verificar el tamaño del archivo
	if( $('#archivosAdjuntosConsulta_'+idConsulta)[0].files[0].size > '5242880' ){
		swal(
		  'Error!',
		  'El archivo supera el lmite permitido de 5 MB',
		  'error'
		)
		
		return false;
	}
	
	if ($('#archivosAdjuntosConsulta_'+idConsulta).get(0).files.length === 0) {
	    return false;
	}else{
		$("#divPreloader_"+idConsulta).show('slower');
		$("#form_uploadFiles_"+idConsulta).submit();
	}
	
}
//---









/*
 * Cirugias
 */


//limpiar los datos del modal de nuevo diagnostico
function limpiarModalDiagnosticoCirugia(){
	
	
	
	$("#nombreDiagnostico").val("");
	$("#codigoDiagnostico").val("");
	$("#observacionDiagnostico").val("");
	
	//se remueve las clases activas
	$("#label_nombreDiagnostico").removeClass("active");
	$("#label_codigoDiagnostico").removeClass("active");
	$("#label_observacionDiagnostico").removeClass("active");
	
	
	$("#nombreDiagnostico").removeClass("valid");
	$("#codigoDiagnostico").removeClass("valid");
	$("#observacionDiagnostico").removeClass("valid");
	

	$("#nombreDiagnostico").removeClass("invalid");
	$("#codigoDiagnostico").removeClass("invalid");
	$("#observacionDiagnostico").removeClass("invalid");	
	
}
//---

//funcion para validar el guardado de un nuevo diagnostico
function guardarNuevoDiagnosticoCirugia(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreDiagnostico").addClass( "active" );
		$("#nombreDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#codigoDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoDiagnostico").addClass( "active" );
		$("#codigoDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#precioDiagnostico").val().trim().length == 0 ){
		
		$("#label_precioDiagnostico").addClass( "active" );
		$("#precioDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	
	
	if(sw == 1){
		return false;
	}else{
		
			  $.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/cirugias/guardarDiagnosticoCirugia.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    nombre : $("#nombreDiagnostico").val(), codigo: $("#codigoDiagnostico").val(), 
		            	    observacion: $("#observacionDiagnostico").val(), precio: $("#precioDiagnostico").val()
		            	},
		            success: function(data) {
		            		$('#modal_nuevoDiagnostico').closeModal();
							Materialize.toast(data, 4000);	                 
		            }
		      	});	
	}	
		
}
//---


//abrir el formulario motivo cirugia
function abrirFormNuevaCirugia(){
	
	
	$("#hidden_nuevaCirugia").show('slower');
	$("#form_nuevaCirugia").addClass('unsavedForm');
	$("#tituloLi").hide('slower');
	
}



//cancelar una nueva cirugia
function cancelarGuardadoNuevaCirugia(){
	
	//pedir confirmacion
		swal({
		  title: $("#estaSeguro").html(),
		  text: $("#Seperderan").html(),
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: $("#SiCancelarla").html(),
		  cancelButtonText: 'No!',
		},function(){
			
			$("#hidden_nuevaCirugia").hide("slower");
			$("#form_nuevaCirugia").removeClass('unsavedForm');
			$("#tituloLi").show("slower");		

			//se limpia todo
			cirugia_limpiarTextareaMotivoCirugia();
			cirugia_limpiarTextareaObservacionesCirugia();
			cirugia_limpiarTextareaPlanCirugia();
			cirugia_limpiarTextareaComplicaciones();
			
			$("#ul_Cirugias").empty();
			
			$('#ul_Cirugias li').remove();
			

			$('#select_cirugias').find('option').remove();
			$("#tipoAnestesia").val("");
			
			$('select').material_select();



			
		});
	
}
//---





/*Motivo cirugia*/

//obtener el contenido de lo que se escribió en el editor motivo cirugia
function cirugia_ObtenerTxtMotivoCirugia(){
	
	var contenido = $("#iframe_motivoCirugia").contents().find("#editor").html();
	
	$("#contenidoEditorMotivoCirugia").html($("#tituloMotivoCirugia").html());
	
	$("#contenidoEditorMotivoCirugia").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_motivoCirugia").html($("#motivoCirugia").val())
	$("#motivoCirugia").val(contenido);
	
	$("#motivoCirugia").hide("slower");
	$("#label_motivoCirugia").hide("slower");
	$("#contenidoEditorMotivoCirugia").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function cirugia_recuperarTextareaMotivoCirugia(){
	
	$("#motivoCirugia").val($("#contenidoTextoTexarea_motivoCirugia").html().trim());
	$("#label_motivoCirugia").addClass("active");
	$("#contenidoEditorMotivoCirugia").hide("slower");
	
	$("#motivoCirugia").show("slower");
	$("#label_motivoCirugia").show("slower");	
	
}
//---

//limpiar textarea motivo cirugia
function cirugia_limpiarTextareaMotivoCirugia(){

	$("#motivoCirugia").val("");
	
	$("#contenidoEditorMotivoCirugia").hide("slower");
	
	$("#label_motivoCirugia").removeClass("active");
	$("#motivoCirugia").show("slower");
	$("#label_motivoCirugia").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en motivo de cirugia
function cirugia_buscarPersonalizadoMotivoCirugia(){

	
   $('#buscarPersonalizadoMCI').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoMotivoCirugiaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoMotivoCirugiaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoMotivoCirugia").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoMotivoCirugia(){
	
	$("#motivoCirugia").val($("#textoUtilizarPersonalizadoMotivoCirugia").html());
	
	$("#contenidoEditorMotivoCirugia").html($("#tituloMotivoCirugia").html());
	$("#contenidoEditorMotivoCirugia").append($("#textoUtilizarPersonalizadoMotivoCirugia").html());
	
	$("#motivoCirugia").hide("slower");
	$("#label_motivoCirugia").hide("slower");	
	
	$("#contenidoEditorMotivoCirugia").show("slower");
	
	$("#iframe_motivoCirugia").contents().find("#editor").html($("#textoUtilizarPersonalizadoMotivoCirugia").html());
	
	
}
//---

/*Fin Motivo cirugia*/





/*observaciones cirugia*/

//obtener el contenido de lo que se escribió en el editor observaciones cirugia
function cirugia_ObtenerTxtObservacionesCirugia(){
	
	var contenido = $("#iframe_observacionesCirugia").contents().find("#editor").html();
	
	$("#contenidoEditorObservacionesCirugia").html($("#tituloObservacionesCirugia").html());
	
	$("#contenidoEditorObservacionesCirugia").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observacionesCirugia").html($("#observacionesCirugia").val())
	$("#observacionesCirugia").val(contenido);
	
	$("#observacionesCirugia").hide("slower");
	$("#label_observacionesCirugia").hide("slower");
	$("#contenidoEditorObservacionesCirugia").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function cirugia_recuperarTextareaObservacionesCirugia(){
	
	$("#observacionesCirugia").val($("#contenidoTextoTexarea_observacionesCirugia").html().trim());
	$("#label_observacionesCirugia").addClass("active")
	$("#contenidoEditorObservacionesCirugia").hide("slower");
	
	$("#observacionesCirugia").show("slower");
	$("#label_observacionesCirugia").show("slower");	
	
}
//---

//limpiar textarea observaciones cirugia
function cirugia_limpiarTextareaObservacionesCirugia(){

	$("#observacionesCirugia").val("");
	
	$("#contenidoEditorObservacionesCirugia").hide("slower");
	$("#label_observacionesCirugia").removeClass("active");
	$("#observacionesCirugia").show("slower");
	$("#label_observacionesCirugia").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de consulta
function cirugia_buscarPersonalizadoObservacionesCirugia(){

	
   $('#buscarPersonalizadoOCI').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesCirugiaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesCirugiaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesCirugia").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesCirugia(){
	
	$("#observacionesCirugia").val($("#textoUtilizarPersonalizadoObservacionesCirugia").html());
	
	$("#contenidoEditorObservacionesCirugia").html($("#tituloObservacionesConsulta").html());
	$("#contenidoEditorObservacionesCirugia").append($("#textoUtilizarPersonalizadoObservacionesCirugia").html());
	
	$("#observacionesCirugia").hide("slower");
	$("#label_observacionesCirugia").hide("slower");	
	
	$("#contenidoEditorObservacionesCirugia").show("slower");
	
	$("#iframe_observacionesCirugia").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesCirugia").html());
	
	
}
//---
/*Fin Observaciones cirugia*/



/*Plan cirugia*/

//obtener el contenido de lo que se escribió en el editor plan cirugia
function cirugia_ObtenerTxtPlanCirugia(){
	
	var contenido = $("#iframe_planCirugia").contents().find("#editor").html();
	
	$("#contenidoEditorPlanCirugia").html($("#tituloPlanCirugia").html());
	
	$("#contenidoEditorPlanCirugia").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_planCirugia").html($("#planCirugia").val())
	$("#planCirugia").val(contenido);
	
	$("#planCirugia").hide("slower");
	$("#label_planCirugia").hide("slower");
	$("#contenidoEditorPlanCirugia").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function cirugia_recuperarTextareaPlanCirugia(){
	
	$("#planCirugia").val($("#contenidoTextoTexarea_planCirugia").html().trim());
	$("#label_planCirugia").addClass("active");
	$("#contenidoEditorPlanCirugia").hide("slower");
	
	$("#planCirugia").show("slower");
	$("#label_planCirugia").show("slower");	
	
}
//---

//limpiar textarea plan cirugia
function cirugia_limpiarTextareaPlanCirugia(){

	$("#planCirugia").val("");
	
	$("#contenidoEditorPlanCirugia").hide("slower");
	$("#label_planCirugia").removeClass("active");
	$("#planCirugia").show("slower");
	$("#label_planCirugia").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en plan de cirugia
function cirugia_buscarPersonalizadoPlanCirugia(){

	
   $('#buscarPersonalizadoPCI').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoPlanCirugiaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoPlanCirugiaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoPlanCirugia").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoPlanCirugia(){
	
	$("#planCirugia").val($("#textoUtilizarPersonalizadoPlanCirugia").html());
	
	$("#contenidoEditorPlanCirugia").html($("#tituloPlanCirugia").html());
	$("#contenidoEditorPlanCirugia").append($("#textoUtilizarPersonalizadoPlanCirugia").html());
	
	$("#planCirugia").hide("slower");
	$("#label_planCirugia").hide("slower");	
	
	$("#contenidoEditorPlanCirugia").show("slower");
	
	$("#iframe_planCirugia").contents().find("#editor").html($("#textoUtilizarPersonalizadoPlanCirugia").html());
	
	
}
//---
/*Fin plan cirugia*/




/*complicaciones cirugia*/

//obtener el contenido de lo que se escribió en el editor plan cirugia
function cirugia_ObtenerTxtComplicacionesCirugia(){
	
	var contenido = $("#iframe_complicaiconesCirugia").contents().find("#editor").html();
	
	$("#contenidoEditorComplicacionesCirugia").html($("#tituloComplicacionesCirugia").html());
	
	$("#contenidoEditorComplicacionesCirugia").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_complicacionesCirugia").html($("#complicacionesCirugia").val())
	$("#complicacionesCirugia").val(contenido);
	
	$("#complicacionesCirugia").hide("slower");
	$("#label_complicacionesCirugia").hide("slower");
	$("#contenidoEditorComplicacionesCirugia").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function cirugia_recuperarTextareaComplicaciones(){
	
	$("#complicacionesCirugia").val($("#contenidoTextoTexarea_complicacionesCirugia").html().trim());
	$("#label_complicacionesCirugia").addClass("active");
	$("#contenidoEditorComplicacionesCirugia").hide("slower");
	
	$("#complicacionesCirugia").show("slower");
	$("#label_complicacionesCirugia").show("slower");	
	
}
//---

//limpiar textarea complicaciones cirugia
function cirugia_limpiarTextareaComplicaciones(){

	$("#complicacionesCirugia").val("");
	
	$("#contenidoEditorComplicacionesCirugia").hide("slower");
	$("#label_complicacionesCirugia").removeClass("active");
	$("#complicacionesCirugia").show("slower");
	$("#label_complicacionesCirugia").show("slower");	
	
}
//---

/*Fin complicaciones cirugia*/



//buscar un diagnostico
function cirugia_buscarCirugia(){
	
	$("#buscarCirugia").removeClass("valid");	

	$("#buscarCirugia").removeClass("invalid");


   $('#buscarCirugia').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term, utilizar: "Si"
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
				 
				 var txtRemover = $("#removerCirugia").html(); 
				 
				 if ( !$("#liDx_"+id).length ) {
				 	
						$('#select_cirugias').append('<option value="'+id+'" selected="selected"></option>');						
						$('#ul_Cirugias').append('<li id="liDx_'+id+'" class="collection-item"><div>('+codigoDX+') '+nombreDX+'<a id="'+id+'" onclick="quitarCirugia(this.id)" href="javascript:void(0)" class="secondary-content tooltipped" data-position="left" data-delay="50" data-tooltip="'+txtRemover+'" ><i class="material-icons">delete</i></a></div></li>');
		    					    			
		    					    			
		    			$('.tooltipped').tooltip();
		    			
		    			this.value = "";
    					return false;
		    			
				} else{
					
							$("#label_buscarCirugia").addClass( "active" );
							$("#buscarCirugia").addClass( "invalid" );
							
					
				}//fin else		
		   			
        }
    	
  	}); 
  	


	
}
//---


//para remover el diagnostico de una cirugia
function quitarCirugia (idDx) {
  
  $("#select_diagnosticos option[value='"+idDx+"']").remove();
  
  $('#liDx_'+idDx).remove();
  
  
  $('.material-tooltip').hide();
  $('.tooltipped').tooltip();
  
  
}
//---


//para validar el guardado de una cirugia
function validarGuardadoNuevaCirugia(){
	
	if( ($("#tipoAnestesia").val() == undefined) || ($("#tipoAnestesia").val() == null) || ($("#tipoAnestesia").val() == 'null')  ){
		
		$("#spanErrorGuardar1").show("slower");
		return false;
			
	}else{
		$("#spanErrorGuardar1").hide("slower");
	}
	
	
	
	if(($("#select_cirugias").val() == undefined) || ($("#select_cirugias").val() == null) || ($("#select_cirugias").val() == 'null') ){
		
		$("#spanErrorGuardar").show("slower");
		return false;
		
	}else{
		$("#spanErrorGuardar").hide("slower");
	}

		$("#spanErrorGuardar").hide("slower");
		$("#form_nuevaCirugia").removeClass('unsavedForm');
		$("#form_nuevaCirugia").submit();

	
}
//---


//validar que el input file de adjuntar archivos no se encuentre vacio
function validarAdjuntosCirugia(idCirugia){
	
	//verificar el tamaño del archivo
	if( $('#archivosAdjuntosCirugia_'+idCirugia)[0].files[0].size > '5242880' ){
		swal(
		  'Error!',
		  'El archivo supera el lmite permitido de 5 MB',
		  'error'
		)
		
		return false;
	}
	
	if ($('#archivosAdjuntosCirugia_'+idCirugia).get(0).files.length === 0) {
	    return false;
	}else{
		$("#divPreloader_"+idCirugia).show('slower');
		$("#form_uploadFiles_"+idCirugia).submit();
	}
	
}
//---


//funcion para consultar las notas aclaratorias de una cirugia
function consultarNotasAclaratoriasCirugia(idCirugia){
	
				$("#idCirugiaNotaAclaratoria").val(idCirugia);
				
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/cirugias/notasAclaratoriasController.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idCirugia : idCirugia
		            	},
		            beforeSend: function() {
					     $('#resultadoBusquedaNotasAclaratorias').addClass('center-align');
					     $('#resultadoBusquedaNotasAclaratorias').html('<div class="preloader-wrapper big active"><div class="spinner-layer  spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
					  },
					complete: function(){
					     $('#resultadoBusquedaNotasAclaratorias').removeClass('center-align');
					  },
		            success: function(data) {
		               $("#textoNotaAclaratoria").val("");
		               $("#label_textoNotaAclaratoria").removeClass( "active" );
					   $("#textoNotaAclaratoria").removeClass( "invalid" )
					   $("#textoNotaAclaratoria").removeClass( "valid" )
		               $("#resultadoBusquedaNotasAclaratorias").html(data);
								                 
		            }
		      	});
	
}
//---

//funcion para guardar una nota aclaratoria
function guardarNotaAclaratoriaCirugia(){
	
	if( $("#textoNotaAclaratoria").val().trim().length == 0 ){
		
		$("#label_textoNotaAclaratoria").addClass( "active" );
		$("#textoNotaAclaratoria").addClass( "invalid" );
		return false;
	}else{
		
				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/cirugias/guardarNotaAclaratoriaController.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idCirugia : $("#idCirugiaNotaAclaratoria").val(), textoNota: $("#textoNotaAclaratoria").val()
		            	},
		            success: function(data) {
		            	
		               var idCirugia = $("#idCirugiaNotaAclaratoria").val();
		               consultarNotasAclaratoriasCirugia(idCirugia);
								                 
		            }
		      	});		
		
	}
	
	
	
	
}
//---


/*
 * Fin Cirugias
 */





/*
 * Examenes
 */


//abrir el formulario nuevo examen
function abrirFormNuevoExamen(){
	
	
	$("#hidden_nuevoExamen").show('slower');
	$("#form_nuevoExamen").addClass('unsavedForm');
	$("#tituloLi").hide('slower');

	
}


//adicionar examenes
function examen_buscarExamen(){
	
	$("#buscarExamen").removeClass("valid");	

	$("#buscarExamen").removeClass("invalid");
	
	 $('#buscarExamen').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/examenes/buscarExamen.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringExamen : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 $("#idExamenBuscadoItems").val(ui.item.id);     
				 $("#nombreExamenBuscadoItems").val(ui.item.nombre);      
		   			
        }
    	
  	}); 
	
	
	
}
//---


//adicionar un examen al listado
function adicionarExamenBuscadoItems(){

	
	if( ($("#idExamenBuscadoItems").val() == '0') || ($("#nombreExamenBuscadoItems").val() == '0') ){
	
		$("#errorAdicionarExamenItem").html($("#textoErrorAdicionarExamenItem").html());
		
		return false;
		
	}else{
		$("#errorAdicionarExamenItem").html("&nbsp;");
	}
	
	var id 	  	 		= 	$("#idExamenBuscadoItems").val();    
	var nombre 			= 	$("#nombreExamenBuscadoItems").val();  
	var observaciones	= 	$("#observacionesExamen").val();
	
	 var txtRemover = $("#removerExamen").html(); 
				 
	 if ( !$("#liEx_"+id).length ) {
	 	
	 	
	 		//-------
	 		
	 	var numeroContador 	= $("#contadorIE").val();
		numeroContador = parseInt(numeroContador);	
		
		numeroContador = numeroContador+1;
		
		$('#ul_Examenes').append('<li id="liEx_'+id+'" class="collection-item"><div><b>'+nombre+'</b>  '+observaciones+'<a id="'+id+'" onclick="quitarExamen(this.id)" href="javascript:void(0)" class="secondary-content tooltipped" data-position="left" data-delay="50" data-tooltip="'+txtRemover+'" ><i class="material-icons">delete</i></a></div></li>');
	

		$('#form_nuevoExamen').append('<input type="hidden" id="iENombre_'+numeroContador+'" name="iENombre_'+numeroContador+'" value="'+nombre+'" />');
		$('#form_nuevoExamen').append('<input type="hidden" id="iEObservacion_'+numeroContador+'" name="iEObservacion_'+numeroContador+'" value="'+observaciones+'" />');
		$('#form_nuevoExamen').append('<input type="hidden" id="iEId_'+numeroContador+'" name="iEId_'+numeroContador+'" value="'+id+'" />');
		


		$("#contadorIE").val(numeroContador);
	 		

	 						    			
			$('.tooltipped').tooltip();
			
			
		 	$("#idExamenBuscadoItems").val("0");     
		 	$("#nombreExamenBuscadoItems").val("0");  
		 
		 	$("#buscarExamen").removeClass("valid");
			$("#buscarExamen").removeClass("invalid");
			$("#observacionesExamen").removeClass("valid");
			$("#observacionesExamen").removeClass("invalid");
			
			$("#label_observacionesExamen").removeClass("active");
			$("#label_buscarExamen").removeClass("active");
			
			$("#buscarExamen").val("");
			$("#observacionesExamen").val("");
			
			
	} else{
		
				$("#errorAdicionarExamenItem").html($("#textoErrorAdicionarExamenItem2").html());
				
		
	}//fin else		
	
	
	
}
//---


//para remover un examen
function quitarExamen(idEx) {
    
  $('#liEx_'+idEx).remove();
  
  var numeroContador = $("#contadorIE").val();
  
  numeroContador = parseInt(numeroContador) -1;
  
  $("#contadorIE").val(numeroContador);
  
  $('.material-tooltip').hide();
  $('.tooltipped').tooltip();
  
  
}
//---


//limpiar los campos del buscador de examenes
function limpiarExamenBuscadoItems(){

	 	$("#idExamenBuscadoItems").val("0");     
	 	$("#nombreExamenBuscadoItems").val("0");  
	 
	 	$("#buscarExamen").removeClass("valid");
		$("#buscarExamen").removeClass("invalid");
		$("#observacionesExamen").removeClass("valid");
		$("#observacionesExamen").removeClass("invalid");
		
		$("#label_observacionesExamen").removeClass("active");
		$("#label_buscarExamen").removeClass("active");
		
		$("#buscarExamen").val("");
		$("#observacionesExamen").val("");
		$("#errorAdicionarExamenItem").html("&nbsp;");
	
}
//---




/*Observaciones examen*/

//obtener el contenido de lo que se escribió en el editor observaciones examen
function examen_ObtenerTxtObservacionesExamen(){
	
	var contenido = $("#iframe_observaciones").contents().find("#editor").html();
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	
	$("#contenidoEditorObservaciones").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observaciones").html($("#observaciones").val())
	$("#observaciones").val(contenido);
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");
	$("#contenidoEditorObservaciones").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function examen_recuperarTextareaObservaciones(){
	
	$("#observaciones").val($("#contenidoTextoTexarea_observaciones").html().trim());
	$("#label_observaciones").addClass("active");
	$("#contenidoEditorObservaciones").hide("slower");
	
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---

//limpiar textarea observaciones examen
function examen_limpiarTextareaObservacionesExamen(){

	$("#observaciones").val("");
	
	$("#contenidoEditorObservaciones").hide("slower");
	$("#label_observaciones").removeClass("active");
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de Examen
function examen_buscarPersonalizadoObservacionesExamen(){

	
   $('#buscarPersonalizadoOE').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesExamenBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesExamenBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesExamen").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesExamen(){
	
	$("#observaciones").val($("#textoUtilizarPersonalizadoObservaciones").html());
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	$("#contenidoEditorObservaciones").append($("#textoUtilizarPersonalizadoObservacionesExamen").html());
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");	
	
	$("#contenidoEditorObservaciones").show("slower");
	
	$("#iframe_observaciones").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesExamen").html());
	
	
}
//---
/*Fin Observaciones examen*/


//funcion para cancelar un nuevo examen
function cancelarGuardadoNuevoExamen(){

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

			$("#hidden_nuevoExamen").hide('slower');
			$("#tituloLi").show('slower');
			
			$("#form_nuevoExamen").removeClass('unsavedForm');
		
			examen_limpiarTextareaObservacionesExamen();
			limpiarExamenBuscadoItems();
			
			//se quitan todos los input creados segun el contador
			for(var j = 0; j <= parseInt($("#contadorIE").val()); j++ ){				
				
				$("#iENombre_"+j).remove();
				$("#iEObservacion_"+j).remove();
				$("#iEId_"+j).remove();
				
			}//fin for
			
			$("#errorGuardadoExamen").html('&nbsp;');
			
			$("#contadorIE").val("0");
			
			$('#ul_Examenes li:not(:first)').remove();
	
	});
	
}
//---



//funcion para validar el guardado de un nuevo examen
function validarGuardadoNuevoExamen(){
	
	if( (parseInt($("#contadorIE").val()) > 0) || ($("#iEId_1").val() != undefined) ){
		
		$("#form_nuevoExamen").removeClass('unsavedForm');
		
		$("#form_nuevoExamen").submit();
		
	}else{
		
		$("#errorGuardadoExamen").html($("#textoErrorGuardandoExamen").html());
	}
	
}
//---


//funcion para consultar la respuesta que tenga un examen
function consultarResultadoExamen(idExamenDetalle){
	
			$("#idExamenDetalleResultado").val(idExamenDetalle);
	
			$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/examenes/consultarResultadoExamen.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idExamenDetalle : idExamenDetalle
		            	},
		            success: function(data) {
		                 
		                 if(data == 'SinData'){		
		                 	
		                 	$("#observacionesResultadoExamen").val("");
		                 	$("#observacionesResultadoExamen").removeClass( "invalid" );
		                 	$("#observacionesResultadoExamen").removeClass( "valid" );
		                 	$("#label_observacionesResultadoExamen").removeClass( "active" );
		                 	$("#errorGuardadoResultadoExamen").html("&nbsp;");
		                 	
	                 		$('#resultadoGeneral').material_select('destroy');								
							$('#resultadoGeneral').material_select();		                 	
		                 	
		                 	$("#formResultadoExamen").show("slower"); 
		                 	$("#cuerpoResultadoExamen").hide("slower"); 
		                 }else{
		                 	$("#formResultadoExamen").hide("slower");
		                 	$("#cuerpoResultadoExamen").html(data);
		                 	$("#cuerpoResultadoExamen").show("slower");
		                 	
		                 }
								                 
		            }
		      	});	
	
}
//---


///funcion para guardar el resultado de un examen
function guardarResultadoExamen(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( ($("#resultadoGeneral").val() == "0") || ($("#resultadoGeneral").val() == null) ){
		
		$("#errorGuardadoResultadoExamen").html($("#textoErrorGuardandoResultadoExamen").html());
		sw = 1;
	}else{
		$("#errorGuardadoResultadoExamen").html("&nbsp;");
	}	
	

    if( $("#observacionesResultadoExamen").val().trim().length == 0 ){
		
		$("#label_observacionesResultadoExamen").addClass( "active" );
		$("#observacionesResultadoExamen").addClass( "invalid" );
		sw = 1;
	}	


	if(sw == 1){
		return false;
	}else{
	
			$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/historiaClinica/examenes/guardarResultadoExamen.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idDetalleExamen : $("#idExamenDetalleResultado").val(), general : $("#resultadoGeneral").val() ,observaciones : $("#observacionesResultadoExamen").val()
		            	},
		            success: function(data) {
		                 
		                 var idExamenDetalle	= $("#idExamenDetalleResultado").val();
		                 consultarResultadoExamen(idExamenDetalle);
								                 
		            }
		      	});
	
	}
	
}
//---




/*
 * Fin examenes
 */


/*
 * Desparasitantes
 */

//abrir el formulario de nuevo
function abrirFormNuevoDesparasitante(){
	
	$("#hidden_nuevoDesparasitante").show('slower');
	$("#form_nuevoDesparasitante").addClass('unsavedForm');
	$("#tituloLi").hide('slower');
	
	
}
//---


//funcion para obtener el texto del iframe
function desparasitante_ObtenerTxtObservacionesDesparasitante(){
	
	var contenido = $("#iframe_observaciones").contents().find("#editor").html();
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	
	$("#contenidoEditorObservaciones").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observaciones").html($("#observaciones").val())
	$("#observaciones").val(contenido);
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");
	$("#contenidoEditorObservaciones").show("slower");
	
	
}
//---

//funcion para buscar un desparasitante para la nueva aplicación
function desparasitante_buscarDesparasitante(){
	
	
	$("#buscarDesparasitante").removeClass("valid");	

	$("#buscarDesparasitante").removeClass("invalid");
	
	 $('#buscarDesparasitante').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/buscarDesparasitante.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDesparasitante : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
        		if( ((ui.item.resultadoIdProducto != null) || (ui.item.resultadoIdProducto != "")) && (parseInt(ui.item.cantidadDisponible) > 0) ){
        			
	  				 $("#idDesparasitanteBuscado").val(ui.item.id);     
					 $("#buscarDesparasitante").val(ui.item.nombre);  
					 $("#resultadoIdProducto").val(ui.item.resultadoIdProducto);     
					 $("#cantidadDisponible").val(ui.item.cantidadDisponible);       
					 
					 $("#buscarDesparasitante").removeClass( "invalid" );  
					 $("#buscarDesparasitante").removeClass( "SinCantidad" );			
        			
        		}
        		
         		if( ((ui.item.resultadoIdProducto != null) || (ui.item.resultadoIdProducto != "")) && (parseInt(ui.item.cantidadDisponible) <= 0) ){
        			   
					 $("#buscarDesparasitante").val(ui.item.nombre);         			
        			 $('#label_buscarDesparasitante').attr('data-error', $("#errorSinCantidad").html());
					 $("#buscarDesparasitante").addClass( "invalid" );
					 $("#buscarDesparasitante").addClass( "SinCantidad" );
        		}  
        		
        		if(  ((ui.item.resultadoIdProducto == null) || (ui.item.resultadoIdProducto == "")) && ((ui.item.cantidadDisponible == null) || (ui.item.cantidadDisponible == ""))  ){
        			
        			$("#idDesparasitanteBuscado").val(ui.item.id);     
					$("#buscarDesparasitante").val(ui.item.nombre);
					$("#buscarDesparasitante").addClass( "invalid" );
					 $("#buscarDesparasitante").addClass( "SinCantidad" );
					$('#label_buscarDesparasitante').attr('data-error', $("#errorNoVinculado").html());
        			
        		}     		
        		
   
		   			
        }
    	
  	}); 
	

	
	
}
//---


//validar si el label del input de busqueda esta con error, para dejarlo con el error
function validarClaseDelabel(){
	
	if($("#buscarDesparasitante").hasClass('SinCantidad')){
		$("#buscarDesparasitante").addClass( "invalid" );
	}
	
}
//---

//limpiar textarea observaciones desparasitante
function desparasitante_limpiarTextareaObservacionesDesparasitante(){

	$("#observaciones").val("");
	
	$("#contenidoEditorObservaciones").hide("slower");
	$("#label_observaciones").removeClass("active");
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---

//recuperar contenido de textarea
function desparasitante_recuperarTextareaObservaciones(){
	
	$("#observaciones").val($("#contenidoTextoTexarea_observaciones").html().trim());
	$("#label_observaciones").addClass("active");
	$("#contenidoEditorObservaciones").hide("slower");
	
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
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
		
			desparasitante_limpiarTextareaObservacionesDesparasitante();
			
			$("#idDesparasitanteBuscado").val("0");
			$("#resultadoIdProducto").val("0");
			$("#cantidadDisponible").val("0");

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
    
    if( ($("#idDesparasitanteBuscado").val() == "0") || ($("#idDesparasitanteBuscado").val() == null) ){
		
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


/*
 * Fin Desparasitantes
 */



/*
 * Formulaciones
 */



//abrir el formulario nueva formula
function abrirFormNuevaFormula(){
	
	
	$("#hidden_nuevaFormula").show('slower');
	$("#form_nuevaFormula").addClass('unsavedForm');
	$("#tituloLi").hide('slower');

	
}


//adicionar medicamento
function formula_buscarMedicamento(){
	
	$("#buscarMedicamento").removeClass("valid");	

	$("#buscarMedicamento").removeClass("invalid");
	
	 $('#buscarMedicamento').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/buscarMedicamento.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringMedicamento : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				 $("#idMedicamentoBuscadoItems").val(ui.item.id);     
				 $("#nombreMedicamentoBuscadoItems").val(ui.item.nombre);      
		   			
        }
    	
  	}); 
	
	
	
}
//---


//adicionar un medicamento al listado
function adicionarMedicamentoBuscadoItems(){

	
	var sw = 0;
	
	if( ($("#idMedicamentoBuscadoItems").val() == '0') || ($("#nombreMedicamentoBuscadoItems").val() == '0') ){
	
		$("#errorAdicionarMedicamentoItem").html($("#textoErrorAdicionarMedicamentoItem").html());
		
		sw = 1;
		
	}else if ( $("#viaAdministracion").val() == "" ) {
		
		$("#errorAdicionarMedicamentoItem").html($("#textoErrorAdicionarMedicamentoItem3").html());
		sw = 1;
		
	}else{
		
		$("#errorAdicionarMedicamentoItem").html("&nbsp;");
	}
	

	if( $("#cantidad").val().trim().length == 0 ){
		
		$("#label_cantidad").addClass( "active" );
		$("#cantidad").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#frecuencia").val().trim().length == 0 ){
		
		$("#label_frecuencia").addClass( "active" );
		$("#frecuencia").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#dosificacion").val().trim().length == 0 ){
		
		$("#label_dosificacion").addClass( "active" );
		$("#dosificacion").addClass( "invalid" );
		sw = 1;
	}	
	
	if(sw == 1){
		return false;
	}
	
	var id 	  	 			= 	$("#idMedicamentoBuscadoItems").val();    
	var nombre 				= 	$("#nombreMedicamentoBuscadoItems").val();  
	var cantidad			= 	$("#cantidad").val();
	var frecuencia			= 	$("#frecuencia").val();
	var dosificacion		= 	$("#dosificacion").val(); 
	var viaAdministracion 	=	$("#viaAdministracion").val(); 
	var observaciones		=   $("#observacionesMedicamento").val();
	
	 var txtRemover = $("#removerMedicamento").html(); 
				 
	 if ( !$("#liM_"+id).length ) {
	 	
	 	
	 		//-------
	 		
	 	var numeroContador 	= $("#contadorIF").val();
		numeroContador = parseInt(numeroContador);	
		
		numeroContador = numeroContador+1;
		
		$('#ul_Medicamentos').append('<li id="liM_'+id+'" class="collection-item"><div><b><u>'+nombre+'</u></b>  <b>-Cantidad: </b>'+cantidad+' <b>-Frecuencia: </b>'+frecuencia+' <b>-Dosificacion: </b>'+dosificacion+' <b>-Vía Administracion: </b>'+viaAdministracion+' ('+observaciones+') <a id="'+id+'" onclick="quitarMedicamento(this.id)" href="javascript:void(0)" class="secondary-content tooltipped" data-position="left" data-delay="50" data-tooltip="'+txtRemover+'" ><i class="material-icons">delete</i></a></div></li>');
	
		$('#form_nuevaFormula').append('<input type="hidden" id="iMId_'+numeroContador+'" name="iMId_'+numeroContador+'" value="'+id+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMNombre_'+numeroContador+'" name="iMNombre_'+numeroContador+'" value="'+nombre+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMCantidad_'+numeroContador+'" name="iMCantidad_'+numeroContador+'" value="'+cantidad+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMFrecuencia_'+numeroContador+'" name="iMFrecuencia_'+numeroContador+'" value="'+frecuencia+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMDosificacion_'+numeroContador+'" name="iMDosificacion_'+numeroContador+'" value="'+dosificacion+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMObservaciones_'+numeroContador+'" name="iMObservaciones_'+numeroContador+'" value="'+observaciones+'" />');
		$('#form_nuevaFormula').append('<input type="hidden" id="iMViaAdministracion_'+numeroContador+'" name="iMViaAdministracion_'+numeroContador+'" value="'+viaAdministracion+'" />');
		
		


		$("#contadorIF").val(numeroContador);
	 		

	 						    			
			$('.tooltipped').tooltip();
	
			
		 	$("#idMedicamentoBuscadoItems").val("0");     
		 	$("#nombreMedicamentoBuscadoItems").val("0");  
		 
		 	$("#buscarMedicamento").removeClass("valid");
			$("#buscarMedicamento").removeClass("invalid");
			
			$("#cantidad").removeClass("valid");
			$("#cantidad").removeClass("invalid");

			$("#frecuencia").removeClass("valid");
			$("#frecuencia").removeClass("invalid");
			
			$("#dosificacion").removeClass("valid");
			$("#dosificacion").removeClass("invalid");
			
			$("#observacionesMedicamento").removeClass("valid");
			$("#observacionesMedicamento").removeClass("invalid");
			
			$("#label_buscarMedicamento").removeClass("active");
			$("#label_cantidad").removeClass("active");
			$("#label_frecuencia").removeClass("active");
			$("#label_dosificacion").removeClass("active");
			$("#label_observacionesMedicamento").removeClass("active");
			
			$("#buscarMedicamento").val("");
			$("#cantidad").val("");
			$("#frecuencia").val("");
			$("#dosificacion").val("");
			$("#observacionesMedicamento").val("");
			$("#viaAdministracion").val("");
			
			$('#viaAdministracion').material_select('destroy');
			$('#viaAdministracion').material_select();
			
			
	} else{
		
				$("#errorAdicionarMedicamentoItem").html($("#textoErrorAdicionarMedicamentoItem2").html());
				
		
	}//fin else		
	
	
	
}
//---


//para remover un medicamento
function quitarMedicamento(idM) {
    
  $('#liM_'+idM).remove();
  
  var numeroContador = $("#contadorIF").val();
  
  numeroContador = parseInt(numeroContador) -1;
  
  $("#contadorIF").val(numeroContador);
  
  $('.material-tooltip').hide();
  $('.tooltipped').tooltip();
  
  
}
//---


//limpiar los campos del buscador de medicamentos
function limpiarMedicamentoBuscadoItems(){

		
		 	$("#idMedicamentoBuscadoItems").val("0");     
		 	$("#nombreMedicamentoBuscadoItems").val("0");  
		 
		 	$("#buscarMedicamento").removeClass("valid");
			$("#buscarMedicamento").removeClass("invalid");
			
			$("#cantidad").removeClass("valid");
			$("#cantidad").removeClass("invalid");

			$("#frecuencia").removeClass("valid");
			$("#frecuencia").removeClass("invalid");
			
			$("#dosificacion").removeClass("valid");
			$("#dosificacion").removeClass("invalid");
			
			$("#observacionesMedicamento").removeClass("valid");
			$("#observacionesMedicamento").removeClass("invalid");
			
			$("#label_buscarMedicamento").removeClass("active");
			$("#label_cantidad").removeClass("active");
			$("#label_frecuencia").removeClass("active");
			$("#label_dosificacion").removeClass("active");
			$("#label_observacionesMedicamento").removeClass("active");
			
			$("#buscarMedicamento").val("");
			$("#cantidad").val("");
			$("#frecuencia").val("");
			$("#dosificacion").val("");
			$("#observacionesMedicamento").val("");
			$("#viaAdministracion").val("");
			
			$('#viaAdministracion').material_select('destroy');
			$('#viaAdministracion').material_select();
		
		$("#errorAdicionarExamenItem").html("&nbsp;");
	
}
//---




/*Observaciones formula*/

//obtener el contenido de lo que se escribió en el editor observaciones examen
function examen_ObtenerTxtObservacionesExamen(){
	
	var contenido = $("#iframe_observaciones").contents().find("#editor").html();
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	
	$("#contenidoEditorObservaciones").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observaciones").html($("#observaciones").val())
	$("#observaciones").val(contenido);
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");
	$("#contenidoEditorObservaciones").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function formula_recuperarTextareaObservaciones(){
	
	$("#observaciones").val($("#contenidoTextoTexarea_observaciones").html().trim());
	$("#label_observaciones").addClass("active");
	$("#contenidoEditorObservaciones").hide("slower");
	
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---

//limpiar textarea observaciones examen
function formula_limpiarTextareaObservacionesFormula(){

	$("#observaciones").val("");
	
	$("#contenidoEditorObservaciones").hide("slower");
	$("#label_observaciones").removeClass("active");
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de formula
function formula_buscarPersonalizadoObservacionesFormula(){

	
   $('#buscarPersonalizadoOF').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesFormulaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesFormulaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesFormula").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesFormula(){
	
	$("#observaciones").val($("#textoUtilizarPersonalizadoObservaciones").html());
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	$("#contenidoEditorObservaciones").append($("#textoUtilizarPersonalizadoObservacionesFormula").html());
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");	
	
	$("#contenidoEditorObservaciones").show("slower");
	
	$("#iframe_observaciones").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesFormula").html());
	
	
}
//---
/*Fin Observaciones formula*/


//funcion para cancelar un nueva formula
function cancelarGuardadoNuevaFormula(){

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

			$("#hidden_nuevaFormula").hide('slower');
			$("#tituloLi").show('slower');
			
			$("#form_nuevaFormula").removeClass('unsavedForm');
		
			formula_limpiarTextareaObservacionesFormula();
			limpiarMedicamentoBuscadoItems();
			
			//se quitan todos los input creados segun el contador
			for(var j = 0; j <= parseInt($("#contadorIF").val()); j++ ){				

				$("#iMId_"+j).remove();
				$("#iMNombre_"+j).remove();
				$("#iMCantidad_"+j).remove();
				$("#iMFrecuencia_"+j).remove();
				$("#iMDosificacion_"+j).remove();
				$("#iMObservaciones_"+j).remove();
				$("#iMViaAdministracion_"+j).remove();
				
				
			}//fin for
			
			$("#errorGuardadoFormula").html('&nbsp;');
			
			$("#contadorIE").val("0");
			
			$('#ul_Medicamentos li:not(:first)').remove();
	
	});
	
}
//---



//funcion para validar el guardado de una nueva formula
function validarGuardadoNuevaFormula(){
	
	if( (parseInt($("#contadorIF").val()) > 0) || ($("#iMId_1").val() != undefined) ){
		
		$("#form_nuevaFormula").removeClass('unsavedForm');
		
		$("#form_nuevaFormula").submit();
		
	}else{
		
		$("#errorGuardadoFormula").html($("#textoErrorGuardandoFormula").html());
	}
	
}
//---








/*
 * Fin  Formulaciones
 */



/*
 * Vacunas
 */



//abrir el formulario de nuevo
function abrirFormNuevaVacuna(){
	
	$("#hidden_nuevaVacuna").show('slower');
	$("#form_nuevaVacuna").addClass('unsavedForm');
	$("#tituloLi").hide('slower');
	
	
}
//---


//funcion para obtener el texto del iframe
function vacuna_ObtenerTxtObservacionesVacuna(){
	
	var contenido = $("#iframe_observaciones").contents().find("#editor").html();
	
	$("#contenidoEditorObservaciones").html($("#tituloObservaciones").html());
	
	$("#contenidoEditorObservaciones").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observaciones").html($("#observaciones").val())
	$("#observaciones").val(contenido);
	
	$("#observaciones").hide("slower");
	$("#label_observaciones").hide("slower");
	$("#contenidoEditorObservaciones").show("slower");
	
	
}
//---

//funcion para buscar una vacuna para la nueva aplicación
function vacuna_buscarVacuna(){
	
	
	$("#buscarVacuna").removeClass("valid");	

	$("#buscarVacuna").removeClass("invalid");
	
	 $('#buscarVacuna').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/vacunas/buscarVacuna.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringVacuna : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
        		if( ((ui.item.resultadoIdProducto != null) || (ui.item.resultadoIdProducto != "")) && (parseInt(ui.item.cantidadDisponible) > 0) ){
        			
	  				 $("#idVacunaBuscada").val(ui.item.id);     
					 $("#buscarVacuna").val(ui.item.nombre);  
					 $("#resultadoIdProducto").val(ui.item.resultadoIdProducto);     
					 $("#cantidadDisponible").val(ui.item.cantidadDisponible);       
					 
					 $("#buscarVacuna").removeClass( "invalid" );  
					 $("#buscarVacuna").removeClass( "SinCantidad" );			
        			
        		}
        		
         		if( ((ui.item.resultadoIdProducto != null) || (ui.item.resultadoIdProducto != "")) && (parseInt(ui.item.cantidadDisponible) <= 0) ){
        			   
					 $("#buscarVacuna").val(ui.item.nombre);         			
        			 $('#label_buscarVacuna').attr('data-error', $("#errorSinCantidad").html());
					 $("#buscarVacuna").addClass( "invalid" );
					 $("#buscarVacuna").addClass( "SinCantidad" );
        		}  
        		
        		if(  ((ui.item.resultadoIdProducto == null) || (ui.item.resultadoIdProducto == "")) && ((ui.item.cantidadDisponible == null) || (ui.item.cantidadDisponible == ""))  ){
        			
        			$("#idVacunaBuscada").val(ui.item.id);     
					$("#buscarVacuna").val(ui.item.nombre);
					$("#buscarVacuna").addClass( "invalid" );
					 $("#buscarVacuna").addClass( "SinCantidad" );
					$('#label_buscarVacuna').attr('data-error', $("#errorNoVinculado").html());
        			
        		}     		
        		
   
		   			
        }
    	
  	}); 
	

	
	
}
//---


//validar si el label del input de busqueda esta con error, para dejarlo con el error
function validarClaseDelabelVacuna(){
	
	if($("#buscarVacuna").hasClass('SinCantidad')){
		$("#buscarVacuna").addClass( "invalid" );
	}
	
}
//---

//limpiar textarea observaciones vacuna
function vacuna_limpiarTextareaObservacionesVacuna(){

	$("#observaciones").val("");
	
	$("#contenidoEditorObservaciones").hide("slower");
	$("#label_observaciones").removeClass("active");
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---

//recuperar contenido de textarea
function vacuna_recuperarTextareaObservaciones(){
	
	$("#observaciones").val($("#contenidoTextoTexarea_observaciones").html().trim());
	$("#label_observaciones").addClass("active");
	$("#contenidoEditorObservaciones").hide("slower");
	
	$("#observaciones").show("slower");
	$("#label_observaciones").show("slower");	
	
}
//---


//funcion para cancelar el guardado de una nueva aplicacion
function cancelarGuardadoNuevaAplicacionVacuna(){



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

			$("#hidden_nuevaVacuna").hide('slower');
			$("#tituloLi").show('slower');
			
			$("#form_nuevaVacuna").removeClass('unsavedForm');
		
			vacuna_limpiarTextareaObservacionesVacuna();
			
			$("#idVacunaBuscada").val("0");
			$("#resultadoIdProducto").val("0");
			$("#cantidadDisponible").val("0");

			$("#buscarVacuna").val("");
			$("#fechaProximaVacuna").val("");
			
			$("#label_buscarVacuna").removeClass("active");
			$("#label_fechaProximaVacuna").removeClass("active");
			
			$("#buscarVacuna").removeClass("valid");
			$("#dosificacion").removeClass("valid");
			$("#fechaProximaVacuna").removeClass("valid");		
	
			$("#buscarVacuna").removeClass("invalid");
			$("#dosificacion").removeClass("invalid");
			$("#fechaProximaVacuna").removeClass("invalid");
			

	});

	
	
}
//---


//validar el guardado de una aplicacion para una vacuna
function validarGuardadoNuevaAplicacionVacuna(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( ($("#idVacunaBuscada").val() == "0") || ($("#idVacunaBuscada").val() == null) ){
		
		$("#label_buscarVacuna").addClass( "active" );
		$("#buscarVacuna").addClass( "invalid" );
		sw = 1;
	}	
	


	if(sw == 1){
		return false;
	}else{	
		$("#form_nuevaVacuna").removeClass('unsavedForm');
		$("#form_nuevaVacuna").submit();
	}
}
//---



/*
 * Fin Vacunas
 */



/*
 * Hospitalizacion
 */

//abrir el formulario nueva hospitalizacion
function abrirFormNuevaHospitalizacion(){
	
	
	$("#hidden_nuevaHospitalizacion").show();
	$("#form_nuevaHospitalizacion").addClass('unsavedForm');
	$("#tituloLi").hide();

	
}



/*Motivo hospitalizacion*/

//obtener el contenido de lo que se escribió en el editor motivo hospitalizacion
function hospitalizacion_ObtenerTxtMotivoHospitalizacion(){
	
	var contenido = $("#iframe_motivoHospitalizacion").contents().find("#editor").html();
	
	$("#contenidoEditorMotivoHospitalizacion").html($("#tituloMotivoHospitalizacion").html());
	
	$("#contenidoEditorMotivoHospitalizacion").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_motivoHospitalizacion").html($("#motivoHospitalizacion").val())
	$("#motivoHospitalizacion").val(contenido);
	
	$("#motivoHospitalizacion").hide("slower");
	$("#label_motivoHospitalizacion").hide("slower");
	$("#contenidoEditorMotivoHospitalizacion").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function hospitalizacion_recuperarTextareaMotivoHospitalizacion(){
	
	$("#motivoHospitalizacion").val($("#contenidoTextoTexarea_motivoHospitalizacion").html().trim());
	$("#label_motivoHospitalizacion").addClass("active");
	
	$("#contenidoEditorMotivoHospitalizacion").hide("slower");
	
	$("#motivoHospitalizacion").show("slower");
	$("#label_motivoHospitalizacion").show("slower");	
	
}
//---

//limpiar textarea motivo Hospitalizacion
function hospitalizacion_limpiarTextareaMotivoHospitalizacion(){

	$("#motivoHospitalizacion").val("");
	
	$("#contenidoEditorMotivoHospitalizacion").hide("slower");
	$("#label_motivoHospitalizacion").removeClass("active");
	$("#motivoHospitalizacion").show("slower");
	$("#label_motivoHospitalizacion").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en motivo de Hospitalizacion
function hospitalizacion_buscarPersonalizadoMotivoHospitalizacion(){

	
   $('#buscarPersonalizadoMH').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoMotivoHospitalizacionBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoMotivoHospitalizacionBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoMotivoHospitalizacion").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoMotivoHospitalizacion(){
	
	$("#motivoHospitalizacion").val($("#textoUtilizarPersonalizadoMotivoHospitalizacion").html());
	
	$("#contenidoEditorMotivoHospitalizacion").html($("#tituloMotivoHospitalizacion").html());
	$("#contenidoEditorMotivoHospitalizacion").append($("#textoUtilizarPersonalizadoMotivoHospitalizacion").html());
	
	$("#motivoHospitalizacion").hide("slower");
	$("#label_motivoHospitalizacion").hide("slower");	
	
	$("#contenidoEditorMotivoHospitalizacion").show("slower");
	
	$("#iframe_motivoHospitalizacion").contents().find("#editor").html($("#textoUtilizarPersonalizadoMotivoHospitalizacion").html());
	
	
}
//---

/*Fin Motivo Hospitalizacion*/


/*Observaciones Hospitalizacion*/

//obtener el contenido de lo que se escribió en el editor observaciones Hospitalizacion
function hospitalizacion_ObtenerTxtObservacionesHospitalizacion(){
	
	var contenido = $("#iframe_observacionesHospitalizacion").contents().find("#editor").html();
	
	$("#contenidoEditorObservacionesHospitalizacion").html($("#tituloObservacionesHospitalizacion").html());
	
	$("#contenidoEditorObservacionesHospitalizacion").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observacionesHospitalizacion").html($("#observacionesHospitalizacion").val())
	$("#observacionesHospitalizacion").val(contenido);
	
	$("#observacionesHospitalizacion").hide("slower");
	$("#label_observacionesHospitalizacion").hide("slower");
	$("#contenidoEditorObservacionesHospitalizacion").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function hospitalizacion_recuperarTextareaObservacionesHospitalizacion(){
	
	$("#observacionesHospitalizacion").val($("#contenidoTextoTexarea_observacionesHospitalizacion").html());
	
	$("#contenidoEditorObservacionesHospitalizacion").hide("slower");
	
	$("#observacionesHospitalizacion").show("slower");
	$("#label_observacionesHospitalizacion").show("slower");	
	
}
//---

//limpiar textarea observaciones Hospitalizacion
function hospitalizacion_limpiarTextareaObservacionesHospitalizacion(){

	$("#observacionesHospitalizacion").val("");
	
	$("#contenidoEditorObservacionesHospitalizacion").hide("slower");
	$("#label_observacionesHospitalizacion").removeClass("active");
	$("#observacionesHospitalizacion").show("slower");
	$("#label_observacionesHospitalizacion").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en observaciones de Hospitalizacion
function hospitalizacion_buscarPersonalizadoObservacionesHospitalizacion(){

	
   $('#buscarPersonalizadoOH').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoObservacionesHospitalizacionBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoObservacionesHospitalizacionBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoObservacionesHospitalizacion").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoObservacionesHospitalizacion(){
	
	$("#observacionesHospitalizacion").val($("#textoUtilizarPersonalizadoObservacionesHospitalizacion").html());
	
	$("#contenidoEditorObservacionesHospitalizacion").html($("#tituloObservacionesHospitalizacion").html());
	$("#contenidoEditorObservacionesHospitalizacion").append($("#textoUtilizarPersonalizadoObservacionesHospitalizacion").html());
	
	$("#observacionesHospitalizacion").hide("slower");
	$("#label_observacionesHospitalizacion").hide("slower");	
	
	$("#contenidoEditorObservacionesHospitalizacion").show("slower");
	
	$("#iframe_observacionesHospitalizacion").contents().find("#editor").html($("#textoUtilizarPersonalizadoObservacionesHospitalizacion").html());
	
	
}
//---
/*Fin Observaciones Hospitalizacion*/


//funcion para cancelar una nueva hospitalizacion
function cancelarGuardadoNuevaHospitalizacion(){
	
	$("#hidden_nuevaHospitalizacion").hide("slower");
	$("#tituloLi").show("slower");
	
	hospitalizacion_limpiarTextareaMotivoHospitalizacion();
	hospitalizacion_limpiarTextareaObservacionesHospitalizacion();
	
	$("#fechaIngreso").val("____/__/__");
	$("#horaIngreso").val("__:__");
	
	$("#espacioHospitalizacion").val("0");		
	
  	$('#espacioHospitalizacion').material_select('destroy');
  	$('#espacioHospitalizacion').material_select();
            
	
	$("#fechaIngreso").removeClass("valid");
	$("#horaIngreso").removeClass("valid");
	

	$("#fechaIngreso").removeClass("invalid");
	$("#horaIngreso").removeClass("invalid");
	
	$("#errorGuardandoHospitalizacion").html("&nbsp;");
	
	$("#form_nuevaHospitalizacion").removeClass('unsavedForm');
	
}
//----


//validar el guardado de una nueva hospitalizacion
function validarGuardadoNuevaHospitalizacion(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( ($("#fechaIngreso").val().trim().length == 0) || ($("#fechaIngreso").val() == "____/__/__") ){
		
		$("#label_fechaIngreso").addClass( "active" );
		$("#fechaIngreso").addClass( "invalid" );
		sw = 1;
	}

	if( ($("#horaIngreso").val().trim().length == 0) || ($("#horaIngreso").val() == "__:__") ){
		
		$("#label_horaIngreso").addClass( "active" );
		$("#horaIngreso").addClass( "invalid" );
		sw = 1;
	}

	if( ($("#espacioHospitalizacion").val() == "") || ($("#espacioHospitalizacion").val() == null)){
				
		$("#errorGuardandoHospitalizacion").html($("#textoErrorGuardarHospitalizacion2").html());
		
		sw = 1;
	}else if( ($("#motivoHospitalizacion").val().trim().length == 0)){
			
			$("#label_motivoHospitalizacion").addClass( "active" );
			$("#motivoHospitalizacion").addClass( "invalid" );
			
			$("#errorGuardandoHospitalizacion").html($("#textoErrorGuardarHospitalizacion").html());
			
			sw = 1;
	}else{
			$("#errorGuardandoHospitalizacion").html("&nbsp;");
	}


	if(sw == 1){
		return false;
	}else{	
	
		$("#form_nuevaHospitalizacion").removeClass('unsavedForm');
		$("#form_nuevaHospitalizacion").submit();
	
	}
	
}
//----


//para abrir el formulario para dar de alta a un paciente
function darDeAltaPaciente(id){
	
	$("#alta_idHospitalizacion").val($("#alta_idHospitalizacion_"+id).val());
	$("#idRelacionEspacioHospitalizacion").val($("#idRelacionEspacioHospitalizacion_"+id).val());
	$("#idEspacioHospitalizacionAlta").val($("#idEspacioHospitalizacionAlta_"+id).val());
	
	$("#hidden_dardeAltapaciente").show('slower');
	
	
}


//observaciones alta

//obtener el contenido de lo que se escribió en el editor observaciones Hospitalizacion
function hospitalizacion_ObtenerTxtObservacionesAlta(){
	
	var contenido = $("#iframe_observacionesAlta").contents().find("#editor").html();
	
	$("#contenidoEditorObservacionesAlta").html($("#tituloObservacionesAlta").html());
	
	$("#contenidoEditorObservacionesAlta").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_observacionesAlta").html($("#observacionesAlta").val())
	$("#observacionesAlta").val(contenido);
	
	$("#observacionesAlta").hide("slower");
	$("#label_observacionesAlta").hide("slower");
	$("#contenidoEditorObservacionesAlta").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function hospitalizacion_recuperarTextareaObservacionesAlta(){
	
	$("#observacionesAlta").val($("#contenidoTextoTexarea_observacionesAlta").html());
	
	$("#contenidoEditorObservacionesAlta").hide("slower");
	
	$("#observacionesAlta").show("slower");
	$("#label_observacionesAlta").show("slower");	
	
}
//---

//limpiar textarea observaciones alta
function hospitalizacion_limpiarTextareaObservacionesAlta(){

	$("#observacionesAlta").val("");
	
	$("#contenidoEditorObservacionesAlta").hide("slower");
	$("#label_observacionesAlta").removeClass("active");
	$("#observacionesAlta").show("slower");
	$("#label_observacionesAlta").show("slower");	
	
}
//---


//Fin observaciones alta 


//cuidados Alta
//obtener el contenido de lo que se escribió en el editor cuidados alta
function hospitalizacion_ObtenerTxtCuidadosAlta(){
	
	var contenido = $("#iframe_cuidadosAlta").contents().find("#editor").html();
	
	$("#contenidoEditorCuidadosAlta").html($("#tituloCuidadosAlta").html());
	
	$("#contenidoEditorCuidadosAlta").append(contenido);
	//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
	$("#contenidoTextoTexarea_cuidadosAlta").html($("#cuidadosAlta").val())
	$("#cuidadosAlta").val(contenido);
	
	$("#cuidadosAlta").hide("slower");
	$("#label_cuidadosAlta").hide("slower");
	$("#contenidoEditorCuidadosAlta").show("slower");
	
	
}
//---


//recuperar contenido de textarea
function hospitalizacion_recuperarTextareaCuidadosAlta(){
	
	$("#cuidadosAlta").val($("#contenidoTextoTexarea_cuidadosAlta").html());
	
	$("#contenidoEditorCuidadosAlta").hide("slower");
	
	$("#cuidadosAlta").show("slower");
	$("#label_cuidadosAlta").show("slower");	
	
}
//---

//limpiar textarea cuidados alta
function hospitalizacion_limpiarTextareaCuidadosAlta(){

	$("#cuidadosAlta").val("");
	
	$("#contenidoEditorCuidadosAlta").hide("slower");
	$("#label_cuidadosAlta").removeClass("active");
	$("#cuidadosAlta").show("slower");
	$("#label_cuidadosAlta").show("slower");	
	
}
//---


//buscar personalizado y obtener texto en cuidados alta
function hospitalizacion_buscarPersonalizadoCuidadosAlta(){

	
   $('#buscarPersonalizadoCA').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term, utilizar: "Si"
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoCuidadosAltaBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/mostrarBusquedaPersonalizadoUtilizar.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoCuidadosAltaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBusquedaPersonalizadoCuidadosAlta").html(data);  
						$('.collapsible').collapsible({  }); 
								                 
		            }
		      	});
    			   			
        }
    	
  	}); 
	
}
//---


//para obtener el texto del personalizado
function obtenerTxtPersonalizadoCuidadosAlta(){
	
	$("#cuidadosAlta").val($("#textoUtilizarPersonalizadoCuidadosAlta").html());
	
	$("#contenidoEditorCuidadosAlta").html($("#tituloCuidadosAlta").html());
	$("#contenidoEditorCuidadosAlta").append($("#textoUtilizarPersonalizadoCuidadosAlta").html());
	
	$("#cuidadosAlta").hide("slower");
	$("#label_cuidadosAlta").hide("slower");	
	
	$("#contenidoEditorCuidadosAlta").show("slower");
	
	$("#iframe_cuidadosAlta").contents().find("#editor").html($("#textoUtilizarPersonalizadoCuidadosAlta").html());
	
	
}
//---
//Fin cuidados Alta


//funcion para cancelar un alta
function cancelarGuardadoAlta(){
	
	$("#hidden_dardeAltapaciente").hide("slower");
	
	hospitalizacion_limpiarTextareaCuidadosAlta();
	hospitalizacion_limpiarTextareaObservacionesAlta();
	
	$("#idRelacionEspacioHospitalizacion").val("0");
	$("#idEspacioHospitalizacionAlta").val("0");
	$("#alta_idHospitalizacion").val("0");
	
	$("#fechaAlta").val("____/__/__");
	$("#horaAlta").val("__:__");
	$("#alta_estado").val("");
	
	$('#alta_estado').material_select('destroy');
	$('#alta_estado').material_select();
	
	$("#fechaAlta").removeClass("valid");
	$("#horaAlta").removeClass("valid");
	
	$("#fechaAlta").removeClass("invalid");
	$("#horaAlta").removeClass("invalid");
	
	$("#errorGuardandoAlta").html("&nbsp;");
	
}
//---


//funcion para validar dar de alta a un paciente
function validarGuardadoAlta(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( ($("#fechaAlta").val().trim().length == 0) || ($("#fechaAlta").val() == "____/__/__") ){
		
		$("#label_fechaAlta").addClass( "active" );
		$("#fechaAlta").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#horaAlta").val().trim().length == 0) || ($("#horaAlta").val() == "__:__") ){
		
		$("#label_horaAlta").addClass( "active" );
		$("#horaAlta").addClass( "invalid" );
		sw = 1;
	}

	if( $("#alta_estado").val() == "" ){
		
		$("#errorGuardandoAlta").html($("#textoErrorGuardarAlta").html());
		sw = 1;
	}else{
		$("#errorGuardandoAlta").html("&nbsp;");
	}

	if(sw == 1){
		return false;
	}else{
		$("#form_altaPaciente").submit();
	}		
	
	
}
//---


/*
 * Fin Hospitalizacion
 */