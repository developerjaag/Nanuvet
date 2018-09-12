/*
 * Funciones para el modulo de personalizados
 */




/*
 * Motivo de consulta
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoMC(){
	

	$("#hidden_NuevoPersonalizadoMC").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor motivo consulta
function obtenerTxtMotivoConsulta(){
	
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


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarMotivoConsulta(){
	
		var contenido = $("#iframe_editarMotivoConsulta").contents().find("#editor").html();

		$("#editarContenidoEditorMotivoConsulta").html($("#editarTituloMotivoConsulta").html());
		
		$("#editarContenidoEditorMotivoConsulta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_motivoConsulta").html($("#motivoConsulta").val())
		$("#editarMotivoConsulta").val(contenido);
		
		$("#editarMotivoConsulta").hide("slower");
		$("#label_editarMotivoConsulta").hide("slower");
		$("#editarContenidoEditorMotivoConsulta").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaMotivoConsulta(){
	
	$("#motivoConsulta").val($("#contenidoTextoTexarea_motivoConsulta").html());
	
	$("#contenidoEditorMotivoConsulta").hide("slower");
	
	$("#motivoConsulta").show("slower");
	$("#label_motivoConsulta").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoMC(){
	
	$("#hidden_NuevoPersonalizadoMC").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoMC").val("");
	
	//Se limpia el textarea
	$("#motivoConsulta").val("");
	$("#motivoConsulta").show("slower");
	$("#label_motivoConsulta").show("slower");	
	
	$("#contenidoTextoTexarea_motivoConsulta").html("");
	$("#contenidoEditorMotivoConsulta").html("");
	
	
	$("#label_tituloPersonalizadoMC").removeClass("active");
	
	
	$("#tituloPersonalizadoMC").removeClass("valid");
	
	$("#tituloPersonalizadoMC").removeClass("invalid");
	
	$("#errorTexto").hide();
	
	
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoMC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoMC").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoMC").addClass( "active" );
		$("#tituloPersonalizadoMC").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#motivoConsulta").val().trim().length == 0) || ($("#motivoConsulta").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoMC").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoMC
function editarPersonalizadoMC(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoMC();
	

	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/consultarDatosEditarMC.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoMC").val(idPersonalizado);
        	$("#editarTituloPersonalizadoMC").val(data[0].titulo);
        	$("#editarMotivoConsulta").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_motivoConsulta").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorMotivoConsulta").append($("#editarTituloMotivoConsulta").html());
        	$("#editarContenidoEditorMotivoConsulta").append(data[0].texto);
        	
			$("#iframe_editarMotivoConsulta").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorMotivoConsulta").show("slower");
        	$("#editarMotivoConsulta").hide("slower");
			$("#label_editarMotivoConsulta").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoMC").addClass( "active" ); 			
 			$("#label_editarMotivoConsulta").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoMC").show("slower",function() {
	    		mostrarHints();
	  		});	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarMotivoConsulta(){

	$("#editarMotivoConsulta").val("");
	
	$("#editarContenidoEditorMotivoConsulta").hide("slower");
	
	$("#editarMotivoConsulta").show("slower");
	$("#label_editarMotivoConsulta").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoMotivoConsulta(){

	$("#motivoConsulta").val("");
	
	$("#contenidoEditorMotivoConsulta").hide("slower");
	
	$("#motivoConsulta").show("slower");
	$("#label_motivoConsulta").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaMotivoConsulta (){
	
	$("#editarMotivoConsulta").val($("#editarContenidoTextoTexarea_motivoConsulta").html());
	
	$("#editarContenidoEditorMotivoConsulta").hide("slower");
	
	$("#editarMotivoConsulta").show("slower");
	$("#label_editarMotivoConsulta").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoMC(){

	$("#hidden_EditarPersonalizadoMC").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoMC").val("");
	
	//Se limpia el textarea
	$("#editarMotivoConsulta").val("");
	$("#editarMotivoConsulta").show("slower");
	$("#label_editarMotivoConsulta").show("slower");	
	
	$("#editarContenidoTextoTexarea_motivoConsulta").html("");
	$("#editarContenidoEditorMotivoConsulta").html("");
	
	
	$("#label_editarTituloPersonalizadoMC").removeClass("active");
	
	
	$("#editarTituloPersonalizadoMC").removeClass("valid");
	
	$("#editarTituloPersonalizadoMC").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoMC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoMC").val() == "" ){
		sw = 1;
	}

	if( ($("#editarTituloPersonalizadoMC").val().trim().length == 0) || ($("#editarTituloPersonalizadoMC").val() == "<br>") ){
		
		$("#label_editarTituloPersonalizadoMC").addClass( "active" );
		$("#editarTituloPersonalizadoMC").addClass( "invalid" );
		sw = 1;
	}


	if( $("#editarMotivoConsulta").val().trim().length == 0 ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoMC").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoMC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/desactivarPersonalizadoMC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoMC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoMC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/activarPersonalizadoMC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoMC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoConsulta/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


//funcion para ocultar la busqueda de un personalizado
function cerrarBusquedaPersonalizado(){
	
	$("#resultadoPersonalizadosAjax").hide('slower');
	$("#buscarPersonalizado").val("");	
	$("#buscarPersonalizado").blur();	
	$("#btnCancelarBusqueda").hide('slower');	
	
	$("#resultadoPersonalizados").show('slower');
	
}
//---

/*
 * Fin Motivo de consulta
 */






/*
 * Observaciones de consulta
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOC(){
	
	$("#hidden_NuevoPersonalizadoOC").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesConsulta(){
	
	var contenido = $("#iframe_observacionesConsulta").contents().find("#editor").html();


		$("#contenidoEditorObservacionesConsulta").html($("#tituloObservacionesConsulta").html());
		
		$("#contenidoEditorObservacionesConsulta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesConsulta").html($("#observacionesConsulta").val());
		$("#observacionesConsulta").val(contenido);
		
		$("#observacionesConsulta").hide("slower");
		$("#label_observacionesConsulta").hide("slower");
		$("#contenidoEditorObservacionesConsulta").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesConsulta(){
	
		var contenido = $("#iframe_editarObservacionesConsulta").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesConsulta").html($("#editarTituloObservacionesConsulta").html());
		
		$("#editarContenidoEditorObservacionesConsulta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesConsulta").html($("#observacionesConsulta").val())
		$("#editarObservacionesConsulta").val(contenido);
		
		$("#editarObservacionesConsulta").hide("slower");
		$("#label_editarObservacionesConsulta").hide("slower");
		$("#editarContenidoEditorObservacionesConsulta").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesConsulta(){
	
	$("#observacionesConsulta").val($("#contenidoTextoTexarea_observacionesConsulta").html());
	
	$("#contenidoEditorObservacionesConsulta").hide("slower");
	
	$("#observacionesConsulta").show("slower");
	$("#label_observacionesConsulta").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoOC(){
	
	$("#hidden_NuevoPersonalizadoOC").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoOC").val("");
	
	//Se limpia el textarea
	$("#observacionesConsulta").val("");
	$("#observacionesConsulta").show("slower");
	$("#label_observacionesConsulta").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesConsulta").html("");
	$("#contenidoEditorObservacionesConsulta").html("");
	
	
	$("#label_tituloPersonalizadoOC").removeClass("active");
	
	
	$("#tituloPersonalizadoOC").removeClass("valid");
	
	$("#tituloPersonalizadoOC").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOC").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOC").addClass( "active" );
		$("#tituloPersonalizadoOC").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesConsulta").val().trim().length == 0) || ($("#observacionesConsulta").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOC").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOC
function editarPersonalizadoOC(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOC();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/consultarDatosEditarOC.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOC").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOC").val(data[0].titulo);
        	$("#editarObservacionesConsulta").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesConsulta").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesConsulta").append($("#editarTituloObservacionesConsulta").html());
        	$("#editarContenidoEditorObservacionesConsulta").append(data[0].texto);
        	
			$("#iframe_editarObservacionesConsulta").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesConsulta").show("slower");
        	$("#editarObservacionesConsulta").hide("slower");
			$("#label_editarObservacionesConsulta").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOC").addClass( "active" ); 			
 			$("#label_editarObservacionesConsulta").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOC").show("slower",function() {
    		mostrarHints();
  		});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesConsulta(){

	$("#editarObservacionesConsulta").val("");
	
	$("#editarContenidoEditorObservacionesConsulta").hide("slower");
	
	$("#editarObservacionesConsulta").show("slower");
	$("#label_editarObservacionesConsulta").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesConsulta(){

	$("#observacionesConsulta").val("");
	
	$("#contenidoEditorObservacionesConsulta").hide("slower");
	
	$("#observacionesConsulta").show("slower");
	$("#label_observacionesConsulta").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesConsulta (){
	
	$("#editarObservacionesConsulta").val($("#editarContenidoTextoTexarea_observacionesConsulta").html());
	
	$("#editarContenidoEditorObservacionesConsulta").hide("slower");
	
	$("#editarObservacionesConsulta").show("slower");
	$("#label_editarObservacionesConsulta").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOC(){

	$("#hidden_EditarPersonalizadoOC").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOC").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesConsulta").val("");
	$("#editarObservacionesConsulta").show("slower");
	$("#label_editarObservacionesConsulta").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesConsulta").html("");
	$("#editarContenidoEditorObservacionesConsulta").html("");
	
	
	$("#label_editarTituloPersonalizadoOC").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOC").removeClass("valid");
	
	$("#editarTituloPersonalizadoOC").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOC").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOC").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOC").addClass( "active" );
		$("#editarTituloPersonalizadoOC").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesConsulta").val().trim().length == 0) || ($("#editarObservacionesConsulta").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOC").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/desactivarPersonalizadoOC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/activarPersonalizadoOC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesConsulta/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Observaciones de consulta
 */




/*
 * Plan de consulta
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoPC(){
	
	$("#hidden_NuevoPersonalizadoPC").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtPlanConsulta(){
	
	var contenido = $("#iframe_planConsulta").contents().find("#editor").html();


		$("#contenidoEditorPlanConsulta").html($("#tituloPlanConsulta").html());
		
		$("#contenidoEditorPlanConsulta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_planConsulta").html($("#planConsulta").val());
		$("#planConsulta").val(contenido);
		
		$("#planConsulta").hide("slower");
		$("#label_planConsulta").hide("slower");
		$("#contenidoEditorPlanConsulta").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarPlanConsulta(){
	
		var contenido = $("#iframe_editarPlanConsulta").contents().find("#editor").html();

		$("#editarContenidoEditorPlanConsulta").html($("#editarTituloPlanConsulta").html());
		
		$("#editarContenidoEditorPlanConsulta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_planConsulta").html($("#planConsulta").val())
		$("#editarPlanConsulta").val(contenido);
		
		$("#editarPlanConsulta").hide("slower");
		$("#label_editarPlanConsulta").hide("slower");
		$("#editarContenidoEditorPlanConsulta").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaPlanConsulta(){
	
	$("#planConsulta").val($("#contenidoTextoTexarea_planConsulta").html());
	
	$("#contenidoEditorPlanConsulta").hide("slower");
	
	$("#planConsulta").show("slower");
	$("#label_planConsulta").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoPC(){
	
	$("#hidden_NuevoPersonalizadoPC").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoPC").val("");
	
	//Se limpia el textarea
	$("#planConsulta").val("");
	$("#planConsulta").show("slower");
	$("#label_planConsulta").show("slower");	
	
	$("#contenidoTextoTexarea_planConsulta").html("");
	$("#contenidoEditorPlanConsulta").html("");
	
	
	$("#label_tituloPersonalizadoPC").removeClass("active");
	
	
	$("#tituloPersonalizadoPC").removeClass("valid");
	
	$("#tituloPersonalizadoPC").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoPC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoPC").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoPC").addClass( "active" );
		$("#tituloPersonalizadoPC").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#planConsulta").val().trim().length == 0) || ($("#planConsulta").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoPC").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoPC
function editarPersonalizadoPC(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoPC();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/consultarDatosEditarPC.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoPC").val(idPersonalizado);
        	$("#editarTituloPersonalizadoPC").val(data[0].titulo);
        	$("#editarPlanConsulta").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_planConsulta").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorPlanConsulta").append($("#editarTituloPlanConsulta").html());
        	$("#editarContenidoEditorPlanConsulta").append(data[0].texto);
        	
			$("#iframe_editarPlanConsulta").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorPlanConsulta").show("slower");
        	$("#editarPlanConsulta").hide("slower");
			$("#label_editarPlanConsulta").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoPC").addClass( "active" ); 			
 			$("#label_editarPlanConsulta").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoPC").show("slower",function() {
    		mostrarHints();
  		}); 	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarPlanConsulta(){

	$("#editarPlanConsulta").val("");
	
	$("#editarContenidoEditorPlanConsulta").hide("slower");
	
	$("#editarPlanConsulta").show("slower");
	$("#label_editarPlanConsulta").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoPlanConsulta(){

	$("#planConsulta").val("");
	
	$("#contenidoEditorPlanConsulta").hide("slower");
	
	$("#planConsulta").show("slower");
	$("#label_planConsulta").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaPlanConsulta (){
	
	$("#editarPlanConsulta").val($("#editarContenidoTextoTexarea_planConsulta").html());
	
	$("#editarContenidoEditorPlanConsulta").hide("slower");
	
	$("#editarPlanConsulta").show("slower");
	$("#label_editarPlanConsulta").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoPC(){

	$("#hidden_EditarPersonalizadoPC").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoPC").val("");
	
	//Se limpia el textarea
	$("#editarPlanConsulta").val("");
	$("#editarPlanConsulta").show("slower");
	$("#label_editarPlanConsulta").show("slower");	
	
	$("#editarContenidoTextoTexarea_planConsulta").html("");
	$("#editarContenidoEditorPlanConsulta").html("");
	
	
	$("#label_editarTituloPersonalizadoPC").removeClass("active");
	
	
	$("#editarTituloPersonalizadoPC").removeClass("valid");
	
	$("#editarTituloPersonalizadoPC").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoPC(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoPC").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoPC").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoPC").addClass( "active" );
		$("#editarTituloPersonalizadoPC").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarPlanConsulta").val().trim().length == 0) || ($("#editarPlanConsulta").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoPC").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoPC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/desactivarPersonalizadoPC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanPC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoPC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoPC(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/activarPersonalizadoPC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanPC_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoPC(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoPlanListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/planConsulta/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin plan de consulta
 */



/*
 * Observaciones de examen fisico
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOEF(){
	
	$("#hidden_NuevoPersonalizadoOEF").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesExamenFisico(){
	
	var contenido = $("#iframe_observacionesExamenFisico").contents().find("#editor").html();


		$("#contenidoEditorObservacionesExamenFisico").html($("#tituloObservacionesExamenFisico").html());
		
		$("#contenidoEditorObservacionesExamenFisico").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesExamenFisico").html($("#observacionesExamenFisico").val());
		$("#observacionesExamenFisico").val(contenido);
		
		$("#observacionesExamenFisico").hide("slower");
		$("#label_observacionesExamenFisico").hide("slower");
		$("#contenidoEditorObservacionesExamenFisico").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesExamenFisico(){
	
		var contenido = $("#iframe_editarObservacionesExamenFisico").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesExamenFisico").html($("#editarTituloObservacionesExamenFisico").html());
		
		$("#editarContenidoEditorObservacionesExamenFisico").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesExamenFisico").html($("#observacionesExamenFisico").val())
		$("#editarObservacionesExamenFisico").val(contenido);
		
		$("#editarObservacionesExamenFisico").hide("slower");
		$("#label_editarObservacionesExamenFisico").hide("slower");
		$("#editarContenidoEditorObservacionesExamenFisico").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesExamenFisico(){
	
	$("#observacionesExamenFisico").val($("#contenidoTextoTexarea_observacionesExamenFisico").html());
	
	$("#contenidoEditorObservacionesExamenFisico").hide("slower");
	
	$("#observacionesExamenFisico").show("slower");
	$("#label_observacionesExamenFisico").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoOEF(){
	
	$("#hidden_NuevoPersonalizadoOEF").hide("slower",function() {
    		mostrarHints();
  		});
	
	
	//se limpia el titulo
	$("#tituloPersonalizadoOEF").val("");
	
	//Se limpia el textarea
	$("#observacionesExamenFisico").val("");
	$("#observacionesExamenFisico").show("slower");
	$("#label_observacionesExamenFisico").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesExamenFisico").html("");
	$("#contenidoEditorObservacionesExamenFisico").html("");
	
	
	$("#label_tituloPersonalizadoOEF").removeClass("active");
	
	
	$("#tituloPersonalizadoOEF").removeClass("valid");
	
	$("#tituloPersonalizadoOEF").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOEF(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOEF").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOEF").addClass( "active" );
		$("#tituloPersonalizadoOEF").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesExamenFisico").val().trim().length == 0) || ($("#observacionesExamenFisico").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOEF").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOEF
function editarPersonalizadoOEF(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOEF();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/consultarDatosEditarOEF.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOEF").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOEF").val(data[0].titulo);
        	$("#editarObservacionesExamenFisico").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesExamenFisico").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesExamenFisico").append($("#editarTituloObservacionesExamenFisico").html());
        	$("#editarContenidoEditorObservacionesExamenFisico").append(data[0].texto);
        	
			$("#iframe_editarObservacionesExamenFisico").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesExamenFisico").show("slower");
        	$("#editarObservacionesExamenFisico").hide("slower");
			$("#label_editarObservacionesExamenFisico").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOEF").addClass( "active" ); 			
 			$("#label_editarObservacionesExamenFisico").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOEF").show("slower",function() {
    			mostrarHints();
  			}); 	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesExamenFisico(){

	$("#editarObservacionesExamenFisico").val("");
	
	$("#editarContenidoEditorObservacionesExamenFisico").hide("slower");
	
	$("#editarObservacionesExamenFisico").show("slower");
	$("#label_editarObservacionesExamenFisico").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesExamenFisico(){

	$("#observacionesExamenFisico").val("");
	
	$("#contenidoEditorObservacionesExamenFisico").hide("slower");
	
	$("#observacionesExamenFisico").show("slower");
	$("#label_observacionesExamenFisico").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesExamenFisico(){
	
	$("#editarObservacionesExamenFisico").val($("#editarContenidoTextoTexarea_observacionesExamenFisico").html());
	
	$("#editarContenidoEditorObservacionesExamenFisico").hide("slower");
	
	$("#editarObservacionesExamenFisico").show("slower");
	$("#label_editarObservacionesExamenFisico").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOEF(){

	$("#hidden_EditarPersonalizadoOEF").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOEF").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesExamenFisico").val("");
	$("#editarObservacionesExamenFisico").show("slower");
	$("#label_editarObservacionesExamenFisico").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesExamenFisico").html("");
	$("#editarContenidoEditorObservacionesExamenFisico").html("");
	
	
	$("#label_editarTituloPersonalizadoOEF").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOEF").removeClass("valid");
	
	$("#editarTituloPersonalizadoOEF").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOEF(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOEF").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOEF").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOEF").addClass( "active" );
		$("#editarTituloPersonalizadoOEF").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesExamenFisico").val().trim().length == 0) || ($("#editarObservacionesExamenFisico").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOEF").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOEF(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/desactivarPersonalizadoOEF.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOEF_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOEF(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOEF(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/activarPersonalizadoOEF.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOEF_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOEF(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesEFListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamenFisico/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Observaciones de ExamenFisico
 */








/*
 * Motivo de cirugia
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoMCI(){
	
	$("#hidden_NuevoPersonalizadoMCI").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor motivo cirugia
function obtenerTxtMotivoCirugia(){
	
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


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarMotivoCirugia(){
	
		var contenido = $("#iframe_editarMotivoCirugia").contents().find("#editor").html();

		$("#editarContenidoEditorMotivoCirugia").html($("#editarTituloMotivoCirugia").html());
		
		$("#editarContenidoEditorMotivoCirugia").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_motivoCirugia").html($("#motivoCirugia").val())
		$("#editarMotivoCirugia").val(contenido);
		
		$("#editarMotivoCirugia").hide("slower");
		$("#label_editarMotivoCirugia").hide("slower");
		$("#editarContenidoEditorMotivoCirugia").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaMotivoCirugia(){
	
	$("#motivoCirugia").val($("#contenidoTextoTexarea_motivoCirugia").html());
	
	$("#contenidoEditorMotivoCirugia").hide("slower");
	
	$("#motivoCirugia").show("slower");
	$("#label_motivoCirugia").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoMCI(){
	
	$("#hidden_NuevoPersonalizadoMCI").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoMCI").val("");
	
	//Se limpia el textarea
	$("#motivoCirugia").val("");
	$("#motivoCirugia").show("slower");
	$("#label_motivoCirugia").show("slower");	
	
	$("#contenidoTextoTexarea_motivoCirugia").html("");
	$("#contenidoEditorMotivoCirugia").html("");
	
	
	$("#label_tituloPersonalizadoMCI").removeClass("active");
	
	
	$("#tituloPersonalizadoMCI").removeClass("valid");
	
	$("#tituloPersonalizadoMCI").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoMCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoMCI").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoMCI").addClass( "active" );
		$("#tituloPersonalizadoMCI").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#motivoCirugia").val().trim().length == 0) || ($("#motivoCirugia").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoMCI").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoMCI
function editarPersonalizadoMCI(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoMC();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/consultarDatosEditarMCI.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoMCI").val(idPersonalizado);
        	$("#editarTituloPersonalizadoMCI").val(data[0].titulo);
        	$("#editarMotivoCirugia").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_motivoCirugia").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorMotivoCirugia").append($("#editarTituloMotivoCirugia").html());
        	$("#editarContenidoEditorMotivoCirugia").append(data[0].texto);
        	
			$("#iframe_editarMotivoCirugia").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorMotivoCirugia").show("slower");
        	$("#editarMotivoCirugia").hide("slower");
			$("#label_editarMotivoCirugia").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoMCI").addClass( "active" ); 			
 			$("#label_editarMotivoCirugia").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoMCI").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarMotivoCirugia(){

	$("#editarMotivoCirugia").val("");
	
	$("#editarContenidoEditorMotivoCirugia").hide("slower");
	
	$("#editarMotivoCirugia").show("slower");
	$("#label_editarMotivoCirugia").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoMotivoCirugia(){

	$("#motivoCirugia").val("");
	
	$("#contenidoEditorMotivoCirugia").hide("slower");
	
	$("#motivoCirugia").show("slower");
	$("#label_motivoCirugia").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaMotivoCirugia (){
	
	$("#editarMotivoCirugia").val($("#editarContenidoTextoTexarea_motivoCirugia").html());
	
	$("#editarContenidoEditorMotivoCirugia").hide("slower");
	
	$("#editarMotivoCirugia").show("slower");
	$("#label_editarMotivoCirugia").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoMCI(){

	$("#hidden_EditarPersonalizadoMCI").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoMCI").val("");
	
	//Se limpia el textarea
	$("#editarMotivoCirugia").val("");
	$("#editarMotivoCirugia").show("slower");
	$("#label_editarMotivoCirugia").show("slower");	
	
	$("#editarContenidoTextoTexarea_motivoCirugia").html("");
	$("#editarContenidoEditorMotivoCirugia").html("");
	
	
	$("#label_editarTituloPersonalizadoMCI").removeClass("active");
	
	
	$("#editarTituloPersonalizadoMCI").removeClass("valid");
	
	$("#editarTituloPersonalizadoMCI").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoMCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoMCI").val() == "" ){
		sw = 1;
	}

	if( ($("#editarTituloPersonalizadoMCI").val().trim().length == 0) || ($("#editarTituloPersonalizadoMCI").val() == "<br>") ){
		
		$("#label_editarTituloPersonalizadoMCI").addClass( "active" );
		$("#editarTituloPersonalizadoMCI").addClass( "invalid" );
		sw = 1;
	}


	if( $("#editarMotivoCirugia").val().trim().length == 0 ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoMCI").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoMCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/desactivarPersonalizadoMCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoMCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoMCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/activarPersonalizadoMCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoMCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoMCIListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoCirugia/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Motivo de cirugia
 */













/*
 * Observaciones de cirugia
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOCI(){
	
	$("#hidden_NuevoPersonalizadoOCI").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesCirugia(){
	
	var contenido = $("#iframe_observacionesCirugia").contents().find("#editor").html();


		$("#contenidoEditorObservacionesCirugia").html($("#tituloObservacionesCirugia").html());
		
		$("#contenidoEditorObservacionesCirugia").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesCirugia").html($("#observacionesCirugia").val());
		$("#observacionesCirugia").val(contenido);
		
		$("#observacionesCirugia").hide("slower");
		$("#label_observacionesCirugia").hide("slower");
		$("#contenidoEditorObservacionesCirugia").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesCirugia(){
	
		var contenido = $("#iframe_editarObservacionesCirugia").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesCirugia").html($("#editarTituloObservacionesCirugia").html());
		
		$("#editarContenidoEditorObservacionesCirugia").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesCirugia").html($("#observacionesCirugia").val())
		$("#editarObservacionesCirugia").val(contenido);
		
		$("#editarObservacionesCirugia").hide("slower");
		$("#label_editarObservacionesCirugia").hide("slower");
		$("#editarContenidoEditorObservacionesCirugia").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesCirugia(){
	
	$("#observacionesCirugia").val($("#contenidoTextoTexarea_observacionesCirugia").html());
	
	$("#contenidoEditorObservacionesCirugia").hide("slower");
	
	$("#observacionesCirugia").show("slower");
	$("#label_observacionesCirugia").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizado
function cancelarGuardadoNuevoPersonalizadoOCI(){
	
	$("#hidden_NuevoPersonalizadoOCI").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoOCI").val("");
	
	//Se limpia el textarea
	$("#observacionesCirugia").val("");
	$("#observacionesCirugia").show("slower");
	$("#label_observacionesCirugia").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesCirugia").html("");
	$("#contenidoEditorObservacionesCirugia").html("");
	
	
	$("#label_tituloPersonalizadoOCI").removeClass("active");
	
	
	$("#tituloPersonalizadoOCI").removeClass("valid");
	
	$("#tituloPersonalizadoOCI").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOCI").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOCI").addClass( "active" );
		$("#tituloPersonalizadoOCI").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesCirugia").val().trim().length == 0) || ($("#observacionesCirugia").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOCI").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOCI
function editarPersonalizadoOCI(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOCI();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/consultarDatosEditarOCI.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOCI").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOCI").val(data[0].titulo);
        	$("#editarObservacionesCirugia").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesCirugia").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesCirugia").append($("#editarTituloObservacionesCirugia").html());
        	$("#editarContenidoEditorObservacionesCirugia").append(data[0].texto);
        	
			$("#iframe_editarObservacionesCirugia").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesCirugia").show("slower");
        	$("#editarObservacionesCirugia").hide("slower");
			$("#label_editarObservacionesCirugia").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOCI").addClass( "active" ); 			
 			$("#label_editarObservacionesCirugia").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOCI").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesCirugia(){

	$("#editarObservacionesCirugia").val("");
	
	$("#editarContenidoEditorObservacionesCirugia").hide("slower");
	
	$("#editarObservacionesCirugia").show("slower");
	$("#label_editarObservacionesCirugia").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesCirugia(){

	$("#observacionesCirugia").val("");
	
	$("#contenidoEditorObservacionesCirugia").hide("slower");
	
	$("#observacionesCirugia").show("slower");
	$("#label_observacionesCirugia").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesCirugia(){
	
	$("#editarObservacionesCirugia").val($("#editarContenidoTextoTexarea_observacionesCirugia").html());
	
	$("#editarContenidoEditorObservacionesCirugia").hide("slower");
	
	$("#editarObservacionesCirugia").show("slower");
	$("#label_editarObservacionesCirugia").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOCI(){

	$("#hidden_EditarPersonalizadoOCI").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOCI").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesCirugia").val("");
	$("#editarObservacionesCirugia").show("slower");
	$("#label_editarObservacionesCirugia").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesCirugia").html("");
	$("#editarContenidoEditorObservacionesCirugia").html("");
	
	
	$("#label_editarTituloPersonalizadoOCI").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOCI").removeClass("valid");
	
	$("#editarTituloPersonalizadoOCI").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOCI").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOCI").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOCI").addClass( "active" );
		$("#editarTituloPersonalizadoOCI").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesCirugia").val().trim().length == 0) || ($("#editarObservacionesCirugia").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOCI").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/desactivarPersonalizadoOCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/activarPersonalizadoOCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesCirugiaListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesCirugia/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Observaciones de cirugia
 */









/*
 * Plan de cirugia
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoPCI(){
	
	$("#hidden_NuevoPersonalizadoPCI").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtPlanCirugia(){
	
	var contenido = $("#iframe_planCirugia").contents().find("#editor").html();


		$("#contenidoEditorPlanCirugia").html($("#tituloPlanCirugia").html());
		
		$("#contenidoEditorPlanCirugia").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_planCirugia").html($("#planCirugia").val());
		$("#planCirugia").val(contenido);
		
		$("#planCirugia").hide("slower");
		$("#label_planCirugia").hide("slower");
		$("#contenidoEditorPlanCirugia").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarPlanCirugia(){
	
		var contenido = $("#iframe_editarPlanCirugia").contents().find("#editor").html();

		$("#editarContenidoEditorPlanCirugia").html($("#editarTituloPlanCirugia").html());
		
		$("#editarContenidoEditorPlanCirugia").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_planCirugia").html($("#planCirugia").val())
		$("#editarPlanCirugia").val(contenido);
		
		$("#editarPlanCirugia").hide("slower");
		$("#label_editarPlanCirugia").hide("slower");
		$("#editarContenidoEditorPlanCirugia").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaPlanCirugia(){
	
	$("#planCirugia").val($("#contenidoTextoTexarea_planCirugia").html());
	
	$("#contenidoEditorPlanCirugia").hide("slower");
	
	$("#planCirugia").show("slower");
	$("#label_planCirugia").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoPCI(){
	
	$("#hidden_NuevoPersonalizadoPCI").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoPCI").val("");
	
	//Se limpia el textarea
	$("#planCirugia").val("");
	$("#planCirugia").show("slower");
	$("#label_planCirugia").show("slower");	
	
	$("#contenidoTextoTexarea_planCirugia").html("");
	$("#contenidoEditorPlanCirugia").html("");
	
	
	$("#label_tituloPersonalizadoPCI").removeClass("active");
	
	
	$("#tituloPersonalizadoPCI").removeClass("valid");
	
	$("#tituloPersonalizadoPCI").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoPCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoPCI").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoPCI").addClass( "active" );
		$("#tituloPersonalizadoPCI").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#planCirugia").val().trim().length == 0) || ($("#planCirugia").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoPCI").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoPCI
function editarPersonalizadoPCI(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoPCI();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/consultarDatosEditarPCI.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoPCI").val(idPersonalizado);
        	$("#editarTituloPersonalizadoPCI").val(data[0].titulo);
        	$("#editarPlanCirugia").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_planCirugia").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorPlanCirugia").append($("#editarTituloPlanCirugia").html());
        	$("#editarContenidoEditorPlanCirugia").append(data[0].texto);
        	
			$("#iframe_editarPlanCirugia").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorPlanCirugia").show("slower");
        	$("#editarPlanCirugia").hide("slower");
			$("#label_editarPlanCirugia").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoPCI").addClass( "active" ); 			
 			$("#label_editarPlanCirugia").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoPCI").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarPlanCirugia(){

	$("#editarPlanCirugia").val("");
	
	$("#editarContenidoEditorPlanCirugia").hide("slower");
	
	$("#editarPlanCirugia").show("slower");
	$("#label_editarPlanCirugia").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoPlanCirugia(){

	$("#planCirugia").val("");
	
	$("#contenidoEditorPlanCirugia").hide("slower");
	
	$("#planCirugia").show("slower");
	$("#label_planCirugia").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaPlanCirugia (){
	
	$("#editarPlanCirugia").val($("#editarContenidoTextoTexarea_planCirugia").html());
	
	$("#editarContenidoEditorPlanCirugia").hide("slower");
	
	$("#editarPlanCirugia").show("slower");
	$("#label_editarPlanCirugia").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoPCI(){

	$("#hidden_EditarPersonalizadoPCI").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoPCI").val("");
	
	//Se limpia el textarea
	$("#editarPlanCirugia").val("");
	$("#editarPlanCirugia").show("slower");
	$("#label_editarPlanCirugia").show("slower");	
	
	$("#editarContenidoTextoTexarea_planCirugia").html("");
	$("#editarContenidoEditorPlanCirugia").html("");
	
	
	$("#label_editarTituloPersonalizadoPCI").removeClass("active");
	
	
	$("#editarTituloPersonalizadoPCI").removeClass("valid");
	
	$("#editarTituloPersonalizadoPCI").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoPCI(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoPCI").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoPCI").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoPCI").addClass( "active" );
		$("#editarTituloPersonalizadoPCI").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarPlanCirugia").val().trim().length == 0) || ($("#editarPlanCirugia").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoPCI").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoPCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/desactivarPersonalizadoPCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanPCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoPCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoPCI(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/activarPersonalizadoPCI.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanPCI_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoPCI(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoPlanCirugiaListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/planCirugia/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin plan de cirugia
 */




/*
 * Examenes (Encabezado)
 */



//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOE(){
	
	$("#hidden_NuevoPersonalizadoOE").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesExamen(){
	
	var contenido = $("#iframe_observacionesExamen").contents().find("#editor").html();


		$("#contenidoEditorObservacionesExamen").html($("#tituloObservacionesExamen").html());
		
		$("#contenidoEditorObservacionesExamen").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesExamen").html($("#observacionesExamen").val());
		$("#observacionesExamen").val(contenido);
		
		$("#observacionesExamen").hide("slower");
		$("#label_observacionesExamen").hide("slower");
		$("#contenidoEditorObservacionesExamen").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesExamen(){
	
		var contenido = $("#iframe_editarObservacionesExamen").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesExamen").html($("#editarTituloObservacionesExamen").html());
		
		$("#editarContenidoEditorObservacionesExamen").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesExamen").html($("#observacionesExamen").val())
		$("#editarObservacionesExamen").val(contenido);
		
		$("#editarObservacionesExamen").hide("slower");
		$("#label_editarObservacionesExamen").hide("slower");
		$("#editarContenidoEditorObservacionesExamen").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesExamen(){
	
	$("#observacionesExamen").val($("#contenidoTextoTexarea_observacionesExamen").html());
	
	$("#contenidoEditorObservacionesExamen").hide("slower");
	
	$("#observacionesExamen").show("slower");
	$("#label_observacionesExamen").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoOE(){
	
	$("#hidden_NuevoPersonalizadoOE").hide("slower",function() {
    		mostrarHints();
  		});
	
	
	//se limpia el titulo
	$("#tituloPersonalizadoOE").val("");
	
	//Se limpia el textarea
	$("#observacionesExamen").val("");
	$("#observacionesExamen").show("slower");
	$("#label_observacionesExamen").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesExamen").html("");
	$("#contenidoEditorObservacionesExamen").html("");
	
	
	$("#label_tituloPersonalizadoOE").removeClass("active");
	
	
	$("#tituloPersonalizadoOE").removeClass("valid");
	
	$("#tituloPersonalizadoOE").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOE(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOE").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOE").addClass( "active" );
		$("#tituloPersonalizadoOE").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesExamen").val().trim().length == 0) || ($("#observacionesExamen").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOE").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOE
function editarPersonalizadoOE(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOE();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/consultarDatosEditarOE.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOE").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOE").val(data[0].titulo);
        	$("#editarObservacionesExamen").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesExamen").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesExamen").append($("#editarTituloObservacionesExamen").html());
        	$("#editarContenidoEditorObservacionesExamen").append(data[0].texto);
        	
			$("#iframe_editarObservacionesExamen").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesExamen").show("slower");
        	$("#editarObservacionesExamen").hide("slower");
			$("#label_editarObservacionesExamen").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOE").addClass( "active" ); 			
 			$("#label_editarObservacionesExamen").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOE").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesExamen(){

	$("#editarObservacionesExamen").val("");
	
	$("#editarContenidoEditorObservacionesExamen").hide("slower");
	
	$("#editarObservacionesExamen").show("slower");
	$("#label_editarObservacionesExamen").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesExamen(){

	$("#observacionesExamen").val("");
	
	$("#contenidoEditorObservacionesExamen").hide("slower");
	
	$("#observacionesExamen").show("slower");
	$("#label_observacionesExamen").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesExamen(){
	
	$("#editarObservacionesExamen").val($("#editarContenidoTextoTexarea_observacionesExamen").html());
	
	$("#editarContenidoEditorObservacionesExamen").hide("slower");
	
	$("#editarObservacionesExamen").show("slower");
	$("#label_editarObservacionesExamen").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOE(){

	$("#hidden_EditarPersonalizadoOE").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOE").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesExamen").val("");
	$("#editarObservacionesExamen").show("slower");
	$("#label_editarObservacionesExamen").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesExamen").html("");
	$("#editarContenidoEditorObservacionesExamen").html("");
	
	
	$("#label_editarTituloPersonalizadoOE").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOE").removeClass("valid");
	
	$("#editarTituloPersonalizadoOE").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOE(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOE").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOE").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOE").addClass( "active" );
		$("#editarTituloPersonalizadoOE").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesExamen").val().trim().length == 0) || ($("#editarObservacionesExamen").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOE").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOE(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/desactivarPersonalizadoOE.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOE_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOE(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOE(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/activarPersonalizadoOE.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOE_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOE(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesEListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesExamen/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---

/*
 * Fin Examenes (Encabezado)
 */








/*
 * Formula 
 */



//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOF(){
	
	$("#hidden_NuevoPersonalizadoOF").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesFormula(){
	
	var contenido = $("#iframe_observacionesFormula").contents().find("#editor").html();


		$("#contenidoEditorObservacionesFormula").html($("#tituloObservacionesFormula").html());
		
		$("#contenidoEditorObservacionesFormula").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesFormula").html($("#observacionesFormula").val());
		$("#observacionesFormula").val(contenido);
		
		$("#observacionesFormula").hide("slower");
		$("#label_observacionesFormula").hide("slower");
		$("#contenidoEditorObservacionesFormula").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesFormula(){
	
		var contenido = $("#iframe_editarObservacionesFormula").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesFormula").html($("#editarTituloObservacionesFormula").html());
		
		$("#editarContenidoEditorObservacionesFormula").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesFormula").html($("#observacionesFormula").val())
		$("#editarObservacionesFormula").val(contenido);
		
		$("#editarObservacionesFormula").hide("slower");
		$("#label_editarObservacionesFormula").hide("slower");
		$("#editarContenidoEditorObservacionesFormula").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesFormula(){
	
	$("#observacionesFormula").val($("#contenidoTextoTexarea_observacionesFormula").html());
	
	$("#contenidoEditorObservacionesFormula").hide("slower");
	
	$("#observacionesFormula").show("slower");
	$("#label_observacionesFormula").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizado
function cancelarGuardadoNuevoPersonalizadoOF(){
	
	$("#hidden_NuevoPersonalizadoOF").hide("slower",function() {
    		mostrarHints();
  		});
	
	
	//se limpia el titulo
	$("#tituloPersonalizadoOF").val("");
	
	//Se limpia el textarea
	$("#observacionesFormula").val("");
	$("#observacionesFormula").show("slower");
	$("#label_observacionesFormula").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesFormula").html("");
	$("#contenidoEditorObservacionesFormula").html("");
	
	
	$("#label_tituloPersonalizadoOF").removeClass("active");
	
	
	$("#tituloPersonalizadoOF").removeClass("valid");
	
	$("#tituloPersonalizadoOF").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOF(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOF").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOF").addClass( "active" );
		$("#tituloPersonalizadoOF").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesFormula").val().trim().length == 0) || ($("#observacionesFormula").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOF").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOF
function editarPersonalizadoOF(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOF();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/consultarDatosEditarOf.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOF").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOF").val(data[0].titulo);
        	$("#editarObservacionesFormula").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesFormula").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesFormula").append($("#editarTituloObservacionesFormula").html());
        	$("#editarContenidoEditorObservacionesFormula").append(data[0].texto);
        	
			$("#iframe_editarObservacionesFormula").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesFormula").show("slower");
        	$("#editarObservacionesFormula").hide("slower");
			$("#label_editarObservacionesFormula").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOF").addClass( "active" ); 			
 			$("#label_editarObservacionesFormula").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOF").show("slower",function() {
    			mostrarHints();
  			}); 	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesFormula(){

	$("#editarObservacionesFormula").val("");
	
	$("#editarContenidoEditorObservacionesFormula").hide("slower");
	
	$("#editarObservacionesFormula").show("slower");
	$("#label_editarObservacionesFormula").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesFormula(){

	$("#observacionesFormula").val("");
	
	$("#contenidoEditorObservacionesFormula").hide("slower");
	
	$("#observacionesFormula").show("slower");
	$("#label_observacionesFormula").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesFormula(){
	
	$("#editarObservacionesFormula").val($("#editarContenidoTextoTexarea_observacionesFormula").html());
	
	$("#editarContenidoEditorObservacionesFormula").hide("slower");
	
	$("#editarObservacionesFormula").show("slower");
	$("#label_editarObservacionesFormula").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOF(){

	$("#hidden_EditarPersonalizadoOF").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOF").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesFormula").val("");
	$("#editarObservacionesFormula").show("slower");
	$("#label_editarObservacionesFormula").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesFormula").html("");
	$("#editarContenidoEditorObservacionesFormula").html("");
	
	
	$("#label_editarTituloPersonalizadoOF").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOF").removeClass("valid");
	
	$("#editarTituloPersonalizadoOF").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOF(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOF").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOF").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOF").addClass( "active" );
		$("#editarTituloPersonalizadoOF").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesFormula").val().trim().length == 0) || ($("#editarObservacionesFormula").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOF").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOF(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/desactivarPersonalizadoOF.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOF_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOF(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOF(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/activarPersonalizadoOF.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOF_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOF(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesFListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesFormula/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---

/*
 * Fin Formula
 */





/*
 * Motivo de hospitalizacion
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoMH(){
	
	$("#hidden_NuevoPersonalizadoMH").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor motivo hospitalizacion
function obtenerTxtMotivoHospitalizacion(){
	
	var contenido = $("#iframe_motivohospitalizacion").contents().find("#editor").html();


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


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarMotivoHospitalizacion(){
	
		var contenido = $("#iframe_editarMotivoHospitalizacion").contents().find("#editor").html();

		$("#editarContenidoEditorMotivoHospitalizacion").html($("#editarTituloMotivoHospitalizacion").html());
		
		$("#editarContenidoEditorMotivoHospitalizacion").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_motivoHospitalizacion").html($("#motivoHospitalizacion").val())
		$("#editarMotivoHospitalizacion").val(contenido);
		
		$("#editarMotivoHospitalizacion").hide("slower");
		$("#label_editarMotivoHospitalizacion").hide("slower");
		$("#editarContenidoEditorMotivoHospitalizacion").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaMotivoHospitalizacion(){
	
	$("#motivoHospitalizacion").val($("#contenidoTextoTexarea_motivoHospitalizacion").html());
	
	$("#contenidoEditorMotivoHospitalizacion").hide("slower");
	
	$("#motivoHospitalizacion").show("slower");
	$("#label_motivoHospitalizacion").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoMH(){
	
	$("#hidden_NuevoPersonalizadoMH").hide("slower",function() {
    		mostrarHints();
  		});
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#tituloPersonalizadoMH").val("");
	
	//Se limpia el textarea
	$("#motivoHospitalizacion").val("");
	$("#motivoHospitalizacion").show("slower");
	$("#label_motivoHospitalizacion").show("slower");	
	
	$("#contenidoTextoTexarea_motivoHospitalizacion").html("");
	$("#contenidoEditorMotivoHospitalizacion").html("");
	
	
	$("#label_tituloPersonalizadoMH").removeClass("active");
	
	
	$("#tituloPersonalizadoMH").removeClass("valid");
	
	$("#tituloPersonalizadoMH").removeClass("invalid");
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoMH(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoMH").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoMH").addClass( "active" );
		$("#tituloPersonalizadoMH").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#motivoHospitalizacion").val().trim().length == 0) || ($("#motivoHospitalizacion").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoMH").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoMH
function editarPersonalizadoMH(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoMH();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/consultarDatosEditarMH.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoMH").val(idPersonalizado);
        	$("#editarTituloPersonalizadoMH").val(data[0].titulo);
        	$("#editarMotivoHospitalizacion").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_motivoHospitalizacion").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorMotivoHospitalizacion").append($("#editarTituloMotivoHospitalizacion").html());
        	$("#editarContenidoEditorMotivoHospitalizacion").append(data[0].texto);
        	
			$("#iframe_editarMotivoHospitalizacion").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorMotivoHospitalizacion").show("slower");
        	$("#editarMotivoHospitalizacion").hide("slower");
			$("#label_editarMotivoHospitalizacion").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoMH").addClass( "active" ); 			
 			$("#label_editarMotivoHospitalizacion").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoMH").show("slower",function() {
    			mostrarHints();
  			}); 	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarMotivoHospitalizacion(){

	$("#editarMotivoHospitalizacion").val("");
	
	$("#editarContenidoEditorMotivoHospitalizacion").hide("slower");
	
	$("#editarMotivoHospitalizacion").show("slower");
	$("#label_editarMotivoHospitalizacion").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoMotivoHospitalizacion(){

	$("#motivoHospitalizacion").val("");
	
	$("#contenidoEditorMotivoHospitalizacion").hide("slower");
	
	$("#motivoHospitalizacion").show("slower");
	$("#label_motivoHospitalizacion").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaMotivoHospitalizacion (){
	
	$("#editarMotivoHospitalizacion").val($("#editarContenidoTextoTexarea_motivoHospitalizacion").html());
	
	$("#editarContenidoEditorMotivoHospitalizacion").hide("slower");
	
	$("#editarMotivoHospitalizacion").show("slower");
	$("#label_editarMotivoHospitalizacion").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoMH(){

	$("#hidden_EditarPersonalizadoMH").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoMH").val("");
	
	//Se limpia el textarea
	$("#editarMotivoHospitalizacion").val("");
	$("#editarMotivoHospitalizacion").show("slower");
	$("#label_editarMotivoHospitalizacion").show("slower");	
	
	$("#editarContenidoTextoTexarea_motivoHospitalizacion").html("");
	$("#editarContenidoEditorMotivoHospitalizacion").html("");
	
	
	$("#label_editarTituloPersonalizadoMH").removeClass("active");
	
	
	$("#editarTituloPersonalizadoMH").removeClass("valid");
	
	$("#editarTituloPersonalizadoMH").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoMH(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoMH").val() == "" ){
		sw = 1;
	}

	if( ($("#editarTituloPersonalizadoMH").val().trim().length == 0) || ($("#editarTituloPersonalizadoMH").val() == "<br>") ){
		
		$("#label_editarTituloPersonalizadoMH").addClass( "active" );
		$("#editarTituloPersonalizadoMH").addClass( "invalid" );
		sw = 1;
	}


	if( $("#editarMotivoHospitalizacion").val().trim().length == 0 ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoMH").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoMH(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/desactivarPersonalizadoMH.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMH_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoMH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoMH(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/activarPersonalizadoMC.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanMH_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoMH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoListadosMotivoHospitalizacion(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/motivoHospitalizacion/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Motivo de hospitalizacion
 */





/*
 * Observaciones de hospitalizacion
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoOH(){
	
	$("#hidden_NuevoPersonalizadoOH").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtObservacionesHospitalizacion(){
	
	var contenido = $("#iframe_observacionesHospitalizacion").contents().find("#editor").html();


		$("#contenidoEditorObservacionesHospitalizacion").html($("#tituloObservacionesHospitalizacion").html());
		
		$("#contenidoEditorObservacionesHospitalizacion").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_observacionesHospitalizacion").html($("#observacionesHospitalizacion").val());
		$("#observacionesHospitalizacion").val(contenido);
		
		$("#observacionesHospitalizacion").hide("slower");
		$("#label_observacionesHospitalizacion").hide("slower");
		$("#contenidoEditorObservacionesHospitalizacion").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarObservacionesHospitalizacion(){
	
		var contenido = $("#iframe_editarObservacionesHospitalizacion").contents().find("#editor").html();

		$("#editarContenidoEditorObservacionesHospitalizacion").html($("#editarTituloObservacionesHospitalizacion").html());
		
		$("#editarContenidoEditorObservacionesHospitalizacion").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_observacionesHospitalizacion").html($("#observacionesHospitalizacion").val())
		$("#editarObservacionesHospitalizacion").val(contenido);
		
		$("#editarObservacionesHospitalizacion").hide("slower");
		$("#label_editarObservacionesHospitalizacion").hide("slower");
		$("#editarContenidoEditorObservacionesHospitalizacion").show("slower");	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaObservacionesHospitalizacion(){
	
	$("#observacionesHospitalizacion").val($("#contenidoTextoTexarea_observacionesHospitalizacion").html());
	
	$("#contenidoEditorObservacionesHospitalizacion").hide("slower");
	
	$("#observacionesHospitalizacion").show("slower");
	$("#label_observacionesHospitalizacion").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoOH(){
	
	$("#hidden_NuevoPersonalizadoOH").hide("slower",function() {
    		mostrarHints();
  		});
	
	
	//se limpia el titulo
	$("#tituloPersonalizadoOH").val("");
	
	//Se limpia el textarea
	$("#observacionesHospitalizacion").val("");
	$("#observacionesHospitalizacion").show("slower");
	$("#label_observacionesHospitalizacion").show("slower");	
	
	$("#contenidoTextoTexarea_observacionesHospitalizacion").html("");
	$("#contenidoEditorObservacionesHospitalizacion").html("");
	
	
	$("#label_tituloPersonalizadoOH").removeClass("active");
	
	
	$("#tituloPersonalizadoOH").removeClass("valid");
	
	$("#tituloPersonalizadoOH").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoOH(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoOH").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoOH").addClass( "active" );
		$("#tituloPersonalizadoOH").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#observacionesHospitalizacion").val().trim().length == 0) || ($("#observacionesHospitalizacion").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoOH").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOH
function editarPersonalizadoOH(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoOH();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/consultarDatosEditarOH.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoOH").val(idPersonalizado);
        	$("#editarTituloPersonalizadoOH").val(data[0].titulo);
        	$("#editarObservacionesHospitalizacion").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_observacionesHospitalizacion").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorObservacionesHospitalizacion").append($("#editarTituloObservacionesHospitalizacion").html());
        	$("#editarContenidoEditorObservacionesHospitalizacion").append(data[0].texto);
        	
			$("#iframe_editarObservacionesHospitalizacion").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorObservacionesHospitalizacion").show("slower");
        	$("#editarObservacionesHospitalizacion").hide("slower");
			$("#label_editarObservacionesHospitalizacion").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoOH").addClass( "active" ); 			
 			$("#label_editarObservacionesHospitalizacion").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoOH").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarObservacionesHospitalizacion(){

	$("#editarObservacionesHospitalizacion").val("");
	
	$("#editarContenidoEditorObservacionesHospitalizacion").hide("slower");
	
	$("#editarObservacionesHospitalizacion").show("slower");
	$("#label_editarObservacionesHospitalizacion").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoObservacionesHospitalizacion(){

	$("#observacionesHospitalizacion").val("");
	
	$("#contenidoEditorObservacionesHospitalizacion").hide("slower");
	
	$("#observacionesHospitalizacion").show("slower");
	$("#label_observacionesHospitalizacion").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaObservacionesHospitalizacion(){
	
	$("#editarObservacionesHospitalizacion").val($("#editarContenidoTextoTexarea_observacionesHospitalizacion").html());
	
	$("#editarContenidoEditorObservacionesHospitalizacion").hide("slower");
	
	$("#editarObservacionesHospitalizacion").show("slower");
	$("#label_editarObservacionesHospitalizacion").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoOH(){

	$("#hidden_EditarPersonalizadoOH").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoOH").val("");
	
	//Se limpia el textarea
	$("#editarObservacionesHospitalizacion").val("");
	$("#editarObservacionesHospitalizacion").show("slower");
	$("#label_editarObservacionesHospitalizacion").show("slower");	
	
	$("#editarContenidoTextoTexarea_observacionesHospitalizacion").html("");
	$("#editarContenidoEditorObservacionesHospitalizacion").html("");
	
	
	$("#label_editarTituloPersonalizadoOH").removeClass("active");
	
	
	$("#editarTituloPersonalizadoOH").removeClass("valid");
	
	$("#editarTituloPersonalizadoOH").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoOH(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoOH").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoOH").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoOH").addClass( "active" );
		$("#editarTituloPersonalizadoOH").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarObservacionesHospitalizacion").val().trim().length == 0) || ($("#editarObservacionesHospitalizacion").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoOH").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoOH(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/desactivarPersonalizadoOH.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOH_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoOH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoOH(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/activarPersonalizadoOH.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanOH_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoOH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoObservacionesListadosHospitalizacion(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/observacionesHospitalizacion/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin Observaciones de hospitalizacion
 */







/*
 * cuidados alta
 */

//funcion para mostrar el formulario de crear un nuevo personalizado
function mostrarFormNuevoPersonalizadoCA(){
	
	$("#hidden_NuevoPersonalizadoCA").show('slower',function() {
    		mostrarHints();
  		});
	
}
//---


//obtener el contenido de lo que se escribió en el editor
function obtenerTxtCuidadosAlta(){
	
	var contenido = $("#iframe_cuidadosAlta").contents().find("#editor").html();


		$("#contenidoEditorCuidadosAlta").html($("#tituloCuidadosAlta").html());
		
		$("#contenidoEditorCuidadosAlta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#contenidoTextoTexarea_cuidadosAlta").html($("#cuidadosAlta").val());
		$("#cuidadosAlta").val(contenido);
		
		$("#cuidadosAlta").hide("slower");
		$("#label_cuidadosAlta").hide("slower");
		$("#contenidoEditorCuidadosAlta").show("slower");

	
}
//---


//obtener el contenido de lo que se escribio en el editor cuando se esta editando
function obtenerTxtEditarCuidadosAlta(){
	
		var contenido = $("#iframe_editarCuidadosAlta").contents().find("#editor").html();

		$("#editarContenidoEditorCuidadosAlta").html($("#editarTituloCuidadosAlta").html());
		
		$("#editarContenidoEditorCuidadosAlta").append(contenido);
		//se lleva lo que tiene el texarea, para recuperarlo luego por si algo
		$("#editarContenidoTextoTexarea_cuidadosAlta").html($("#editarCuidadosAlta").val())
		$("#editarCuidadosAlta").val(contenido);
		
		$("#editarCuidadosAlta").hide("slower");
		$("#label_editarCuidadosAlta").hide("slower");
		$("#editarContenidoEditorCuidadosAlta").show("slower");	
	

	
	
}
//---


//recuperar contenido de textarea
function recuperarTextareaCuidadosAlta(){
	
	$("#cuidadosAlta").val($("#contenidoTextoTexarea_cuidadosAlta").html());
	
	$("#contenidoEditorCuidadosAlta").hide("slower");
	
	$("#cuidadosAlta").show("slower");
	$("#label_cuidadosAlta").show("slower");	
	
}
//---


//funcion para cancelar el guardado de un nuevo personalizad
function cancelarGuardadoNuevoPersonalizadoCA(){
	
	$("#hidden_NuevoPersonalizadoCA").hide("slower",function() {
    		mostrarHints();
  		});
	
	
	//se limpia el titulo
	$("#tituloPersonalizadoCA").val("");
	
	//Se limpia el textarea
	$("#cuidadosAlta").val("");
	$("#cuidadosAlta").show("slower");
	$("#label_cuidadosAlta").show("slower");	
	
	$("#contenidoTextoTexarea_cuidadosAlta").html("");
	$("#contenidoEditorCuidadosAlta").html("");
	
	$("#errorTexto").hide();
	
	$("#label_tituloPersonalizadoCA").removeClass("active");
	
	
	$("#tituloPersonalizadoCA").removeClass("valid");
	
	$("#tituloPersonalizadoCA").removeClass("invalid");
	
		$("#errorTexto").hide();
}
//---


//validar el guardado del nuevo personalizado
function validarGuardadoNuevoPersonalizadoCA(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#tituloPersonalizadoCA").val().trim().length == 0 ){
		
		$("#label_tituloPersonalizadoCA").addClass( "active" );
		$("#tituloPersonalizadoCA").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#cuidadosAlta").val().trim().length == 0) || ($("#cuidadosAlta").val() == "<br>") ){
		
		$("#errorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#errorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_NuevoPersonalizadoCA").submit();
	}
	
	
}
//---


//funcion para editar un personalizadoOH
function editarPersonalizadoCA(idPersonalizado){
	
	cancelarGuardadoNuevoPersonalizadoCA();
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/consultarDatosEditarCA.php",
        dataType: "json",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {	
        	
        	$("#idPersonalizadoCA").val(idPersonalizado);
        	$("#editarTituloPersonalizadoCA").val(data[0].titulo);
        	$("#editarCuidadosAlta").val(data[0].texto);	
        	
        	$("#editarContenidoTextoTexarea_cuidadosAlta").html(data[0].texto);
        	
        	
        	$("#editarContenidoEditorCuidadosAlta").append($("#editarTituloCuidadosAlta").html());
        	$("#editarContenidoEditorCuidadosAlta").append(data[0].texto);
        	
			$("#iframe_editarCuidadosAlta").contents().find("#editor").html(data[0].texto);
        	
        	$("#editarContenidoEditorCuidadosAlta").show("slower");
        	$("#editarCuidadosAlta").hide("slower");
			$("#label_editarCuidadosAlta").hide("slower");
			
			
        	
 			$("#label_editarTituloPersonalizadoCA").addClass( "active" ); 			
 			$("#label_editarCuidadosAlta").addClass( "active" );     
 			
 			$("#tituloLi").hide("slower");   			
 			$("#hidden_EditarPersonalizadoCA").show("slower",function() {
    			mostrarHints();
  			});  	

        }//fin success
  	});	
	
	
}
//---

//limpiar textarea en edicion
function limpiarTextareaEditarCuidadosAlta(){

	$("#editarCuidadosAlta").val("");
	
	$("#editarContenidoEditorCuidadosAlta").hide("slower");
	
	$("#editarCuidadosAlta").show("slower");
	$("#label_editarCuidadosAlta").show("slower");	
	
}
//---

//limpiar textarea en creacion
function limpiarTextareaNuevoCuidadosAlta(){

	$("#cuidadosAlta").val("");
	
	$("#contenidoEditorCuidadosAlta").hide("slower");
	
	$("#cuidadosAlta").show("slower");
	$("#label_cuidadosAlta").show("slower");	
	
}
//---


//recuperar contenido del textarea en edicion
function editarRecuperarTextareaCuidadosAlta(){
	
	$("#editarCuidadosAlta").val($("#editarContenidoTextoTexarea_cuidadosAlta").html());
	
	$("#editarContenidoEditorCuidadosAlta").hide("slower");
	
	$("#editarCuidadosAlta").show("slower");
	$("#label_editarCuidadosAlta").show("slower");
	
}
//---

//cancelar edicion personalizado
function cancelarEdicionPersonalizadoCA(){

	$("#hidden_EditarPersonalizadoCA").hide("slower",function() {
    		mostrarHints();
  		});
	$("#tituloLi").show("slower");
	
	//se limpia el editor
	//$("#iframe_motivoConsulta").contents().find("#editor").html("");
	
	//se limpia el titulo
	$("#editarTituloPersonalizadoCA").val("");
	
	//Se limpia el textarea
	$("#editarCuidadosAlta").val("");
	$("#editarCuidadosAlta").show("slower");
	$("#label_editarCuidadosAlta").show("slower");	
	
	$("#editarContenidoTextoTexarea_cuidadosAlta").html("");
	$("#editarContenidoEditorCuidadosAlta").html("");
	
	
	$("#label_editarTituloPersonalizadoCA").removeClass("active");
	
	
	$("#editarTituloPersonalizadoCA").removeClass("valid");
	
	$("#editarTituloPersonalizadoCA").removeClass("invalid");
	
}
//---

//validar la edicion de un personalizado
function validarEdicionPersonalizadoCA(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#idPersonalizadoCA").val() == "" ){
		sw = 1;
	}

	if( $("#editarTituloPersonalizadoCA").val().trim().length == 0 ){
		
		$("#label_editarTituloPersonalizadoCA").addClass( "active" );
		$("#editarTituloPersonalizadoCA").addClass( "invalid" );
		sw = 1;
	}


	if( ($("#editarCuidadosAlta").val().trim().length == 0) || ($("#editarCuidadosAlta").val() == "<br>") ){
		
		$("#editarErrorTexto").show("slower");
		
		sw = 1;
	}else{
		$("#editarErrorTexto").hide("slower");
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_EditarPersonalizadoCA").submit();
	}	
	
}
//---

//para inactivar un personalizado 
function desactivarPersonalizadoCA(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/desactivarPersonalizadoCA.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanCA_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect red darken-1 btn secondary-content"  onclick="activarPersonalizadoCA(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//activar un personalizado
function activarPersonalizadoCA(idPersonalizado){

	$('.tooltipped').tooltip('remove');
	//var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/activarPersonalizadoCA.php",
        dataType: "html",
        type : 'POST',
        data: { idPersonalizado : idPersonalizado },
        success: function(data) {			

			$('#spanCA_'+idPersonalizado).html('<a id="'+idPersonalizado+'" class="waves-effect waves-light btn secondary-content"  onclick="desactivarPersonalizadoCA(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//buscar un personalizado
function buscarPersonalizadoCuidadosAltaListados(){
	
   $('#buscarPersonalizado').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/buscarPersonalizado.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringPersonalizado : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPersonalizadoBuscado").val(ui.item.id); 	        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/personalizados/cuidadosAlta/mostrarBusquedaPersonalizado.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idPersonalizado : $("#idPersonalizadoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoPersonalizadosAjax").html(data);
						
						$("#resultadoPersonalizados").hide('slower');	   
						$("#resultadoPersonalizadosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});     
						$('.collapsible').collapsible({});              
		                 
		            }
		      	});
    			   			
        }
    	
  	}); 	
	
}
//---


/*
 * Fin cuidados alta
 */

