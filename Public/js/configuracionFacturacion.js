/*
 * Funciones para la configuracion de la facturacion y de las cajas
 */

$(document).ready(function() {


	$('#resolucion_fecha').datetimepicker({
		  
		  onSelectDate:function(ct,$i){
			  calcularFechaVencimientoResolucion();
			},
		  timepicker:false,
		  formatDate:'Y/m/d',
		  format: 'Y/m/d'
		  
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

//funcion para abrir el formulario de una nueva resolucion
function mostrarFormNuevaResolucion(){
	
	$("#columnaNuevoFacturador").hide("slower");
	$("#columnaNuevaResolucion").removeClass("m6").removeClass("l6").addClass("m12").addClass("l12");
	
	$("#tituloLiResolucion").hide("slower");
	
	$("#div_hiddenNuevaResolucion").show("slower");
	
	
	
	
	
}
//---


//funcion para cancelar la creacion de una nueva resolucion
function cancelarGuardadoNuevaResolucion(){
	
	$("#columnaNuevaResolucion").removeClass("m12").removeClass("l12").addClass("m6").addClass("l6");
	
	$("#div_hiddenNuevaResolucion").hide("slower");
	
	$("#tituloLiResolucion").show("slower");
	$("#columnaNuevoFacturador").show("slower");
	
	//se limpian los campos
	$("#resolucion_numero").val("");
	$("#resolucion_autocorrectorIva").val("");
	$("#resolucion_porcentajeIva").val("");
	$("#resolucion_consecutivoInicial").val("");
	$("#resolucion_consecutivoFinal").val("");
	$("#resolucion_iniciarEn").val("");
	$("#resolucion_fecha").val("");
	$("#resolucion_fechaVencimiento").val("");
	
	$("#label_resolucion_numero").removeClass("active");
	$("#label_resolucion_consecutivoInicial").removeClass("active");
	$("#label_resolucion_consecutivoFinal").removeClass("active");
	$("#label_resolucion_iniciarEn").removeClass("active");
	$("#label_resolucion_fecha").removeClass("active");
	$("#label_resolucion_fechaVencimiento").removeClass("active");
	
	$("#resolucion_numero").removeClass("valid");
	$("#resolucion_porcentajeIva").removeClass("valid");
	$("#resolucion_consecutivoInicial").removeClass("valid");
	$("#resolucion_consecutivoFinal").removeClass("valid");
	$("#resolucion_iniciarEn").removeClass("valid");
	$("#resolucion_fecha").removeClass("valid");
	$("#resolucion_fechaVencimiento").removeClass("valid");
	
	$("#resolucion_numero").removeClass("invalid");
	$("#resolucion_porcentajeIva").removeClass("invalid");
	$("#resolucion_consecutivoInicial").removeClass("invalid");
	$("#resolucion_consecutivoFinal").removeClass("invalid");
	$("#resolucion_iniciarEn").removeClass("invalid");
	$("#resolucion_fecha").removeClass("invalid");
	$("#resolucion_fechaVencimiento").removeClass("invalid");
	
	$("#resolucion_select_autocorrectorIva").removeClass( "red lighten-3" );
	
  	$('#resolucion_autocorrectorIva').material_select('destroy');
  	$('#resolucion_autocorrectorIva').material_select();
            
	
	
}
//---


//funcion para calcular la fecha de vencimiento de la resolucion dian
function calcularFechaVencimientoResolucion(){
	
	var fecha = $("#resolucion_fecha").val();
	
	var fechaCortada = fecha.split("/");
	
	var fecha = new Date(fechaCortada[0] + "," + fechaCortada[1] + "," + fechaCortada[2]);
	var restar = parseInt(parseInt(fecha.getTime())) + parseInt(729 * 24 * 60 * 60 * 1000);
	fecha.setTime(restar);
	day = fecha.getDate();
	month = fecha.getMonth() + 1;
	year = fecha.getFullYear();
	
	var fechaFinal = year+"/"+month+"/"+day;
	
	$("#label_resolucion_fechaVencimiento").addClass("active");
	$("#resolucion_fechaVencimiento").val(fechaFinal);
	

	
}
//---


//funcion para cambiar el valor del porcentaje de IVA
function cambiarValorPorcentajeIVA(){
	
	if( $("#resolucion_autocorrectorIva").val() == "No" ){
		
		$("#resolucion_porcentajeIva").prop('disabled', true);
		
		$("#resolucion_porcentajeIva").val("0");
		
	}else{
		$("#resolucion_porcentajeIva").val("");
		$("#resolucion_porcentajeIva").prop('disabled', false);
	}
	
	
	
	
}
//---



//funcion para guaradar una nueva resolucion
function validarGuardadoNuevaResolucion(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	
	if( $("#resolucion_numero").val().trim().length == 0 ){
		
		$("#label_resolucion_numero").addClass( "active" );
		$("#resolucion_numero").addClass( "invalid" );
		sw = 1;
	}		

	if( $("#resolucion_autocorrectorIva").val() == "" || $("#resolucion_autocorrectorIva").val() == null ){
		
		$("#resolucion_select_autocorrectorIva").addClass( "red lighten-3" );
		sw = 1;
		
	}else{
		
		$("#resolucion_select_autocorrectorIva").removeClass( "red lighten-3" );
		
		if( $("#resolucion_autocorrectorIva").val() == "Si" ){
			
			if( $("#resolucion_porcentajeIva").val().trim().length == 0 ){
				
				$("#label_resolucion_porcentajeIva").addClass( "active" );
				$("#resolucion_porcentajeIva").addClass( "invalid" );
				sw = 1;
			}	
			
		}
				
	}//fin else
	

	if( $("#resolucion_consecutivoInicial").val().trim().length == 0 ){
		
		$("#label_resolucion_consecutivoInicial").addClass( "active" );
		$("#resolucion_consecutivoInicial").addClass( "invalid" );
		sw = 1;
	}		

	if( $("#resolucion_consecutivoFinal").val().trim().length == 0 ){
		
		$("#label_resolucion_consecutivoFinal").addClass( "active" );
		$("#resolucion_consecutivoFinal").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#resolucion_iniciarEn").val().trim().length > 0 ){
		
		var inicial = parseInt($("#resolucion_consecutivoInicial").val());
		var iniciar = parseInt($("#resolucion_iniciarEn").val());
		
		if(iniciar < inicial){
			$("#resolucion_iniciarEn").val("");
			$("#label_resolucion_iniciarEn").addClass( "active" );
			$("#resolucion_iniciarEn").addClass( "invalid" );
			sw = 1;
		}
		
		
	}

	
	if( $("#resolucion_fecha").val().trim().length == 0 ){
		
		$("#label_resolucion_fecha").addClass( "active" );
		$("#resolucion_fecha").addClass( "invalid" );
		sw = 1;
	}	
	
	
		

	if(sw == 1){
		return false;
	}else{
		calcularFechaVencimientoResolucion();
		$("#resolucion_fechaVencimiento").prop('disabled', false);
		$("#resolucion_porcentajeIva").prop('disabled', false);
		$("#form_nuevaResolucion").submit();
	}

	
}
//---


//para incativar una resolucion
function desactivarResolucion(idResolucion){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/desactivarResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idResolucion : idResolucion },
        success: function(data) {			

			$('#spanR_'+idResolucion).html('<a id="'+idResolucion+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarResolucion(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('#btnFacturadores_'+idResolucion).html('<a class="disabled waves-effect waves-light btn black tooltipped" data-position="top" data-delay="50" data-tooltip="Facturadores" ><i class="fa fa-users" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
			
			$('.modal-trigger').leanModal();
			
        }//fin success
  	});		
	
}
//----

//funcion para activar una resolucion
function activarResolucion(idResolucion){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/activarResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idResolucion : idResolucion },
        success: function(data) {			

			$('#spanR_'+idResolucion).html('<a id="'+idResolucion+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarResolucion(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			
			$('#btnFacturadores_'+idResolucion).html('<a id="btnFacturadores_'+idResolucion+'" class="waves-effect waves-light btn black tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Facturadores" data-target="modal_facturadoresResolucion" href="#modal_facturadoresResolucion" onclick="consultarRelacionFacturadores('+idResolucion+')" ><i class="fa fa-users" aria-hidden="true"></i></a>');
			
			$('.tooltipped').tooltip({delay: 50});
			
			$('.modal-trigger').leanModal();
			
        }//fin success
  	});		
	
}
//---


//**************************Facturadores****************************
function mostrarFormNuevoFacturador(){

	$("#columnaNuevaResolucion").hide("slower");
	$("#columnaNuevoFacturador").removeClass("m6").removeClass("l6").addClass("m12").addClass("l12");
	
	$("#tituloLiFacturadores").hide("slower");
	
	$("#div_hiddenNuevoFacturador").show("slower");	
	
	
}
//---



//funcion para validar el guardado de un nuevo facturador
function validarGuardadoNuevoFacturador(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#facturador_identifiacion").val().trim().length == 0 ){
		
		$("#label_facturador_identifiacion").addClass( "active" );
		$("#facturador_identifiacion").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#facturador_nombre").val().trim().length == 0 ){
		
		$("#label_facturador_nombre").addClass( "active" );
		$("#facturador_nombre").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#facturador_apellido").val().trim().length == 0 ){
		
		$("#label_facturador_apellido").addClass( "active" );
		$("#facturador_apellido").addClass( "invalid" );
		sw = 1;
	}		
	
	if( $("#facturador_telefono").val().trim().length == 0 ){
		
		$("#label_facturador_telefono").addClass( "active" );
		$("#facturador_telefono").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#facturador_direccion").val().trim().length == 0 ){
		
		$("#label_facturador_direccion").addClass( "active" );
		$("#facturador_direccion").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#facturador_email").val().trim().length == 0 ){
		
		$("#label_facturador_email").addClass( "active" );
		$("#facturador_email").addClass( "invalid" );
		sw = 1;
	}else if($("#facturador_email").val().indexOf('@', 0) == -1 || $("#facturador_email").val().indexOf('.', 0) == -1) {
            $("#label_facturador_email").addClass( "active" );
			$("#facturador_email").addClass( "invalid" );
			sw = 1;
        }	
	
	if( $("#facturador_razonSocial").val().trim().length == 0 ){
		
		$("#label_facturador_razonSocial").addClass( "active" );
		$("#facturador_razonSocial").addClass( "invalid" );
		sw = 1;
	}	


	if( $("#facturador_identifiacionEmisor").val().trim().length == 0 ){
		
		$("#label_facturador_identifiacionEmisor").addClass( "active" );
		$("#facturador_identifiacionEmisor").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#facturador_nombreEmisor").val().trim().length == 0 ){
		
		$("#label_facturador_nombreEmisor").addClass( "active" );
		$("#facturador_nombreEmisor").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		
		$("#form_nuevoFacturador").submit();
	}
	
}
//---


//metodo para cancelar la creacion de un nuevo facturador
function cancelarGuardadoNuevoFacturador(){
	
	$("#columnaNuevoFacturador").removeClass("m12").removeClass("l12").addClass("m6").addClass("l6");
	
	$("#div_hiddenNuevoFacturador").hide("slower");
	
	$("#tituloLiFacturadores").show("slower");
	$("#columnaNuevaResolucion").show("slower");	
	
	//se limpian los campos
	$("#facturador_identifiacion").val("");
	$("#facturador_nombre").val("");
	$("#facturador_apellido").val("");
	$("#facturador_telefono").val("");
	$("#facturador_celular").val("");
	$("#facturador_direccion").val("");
	$("#facturador_email").val("");
	$("#facturador_tipoRegimen").val("");
	$("#facturador_razonSocial").val("");
	$("#facturador_identifiacionEmisor").val("");
	$("#facturador_nombreEmisor").val("");
	
	$("#label_facturador_identifiacion").removeClass("active");
	$("#label_facturador_nombre").removeClass("active");
	$("#label_facturador_apellido").removeClass("active");
	$("#label_facturador_telefono").removeClass("active");
	$("#label_facturador_celular").removeClass("active");
	$("#label_facturador_direccion").removeClass("active");
	$("#label_facturador_email").removeClass("active");
	$("#label_facturador_razonSocial").removeClass("active");
	$("#label_facturador_identifiacionEmisor").removeClass("active");
	$("#label_facturador_nombreEmisor").removeClass("active");
	
	$("#facturador_identifiacion").removeClass("valid");
	$("#facturador_nombre").removeClass("valid");
	$("#facturador_apellido").removeClass("valid");
	$("#facturador_telefono").removeClass("valid");
	$("#facturador_celular").removeClass("valid");
	$("#facturador_direccion").removeClass("valid");
	$("#facturador_email").removeClass("valid");
	$("#facturador_razonSocial").removeClass("valid");
	$("#facturador_identifiacionEmisor").removeClass("valid");
	$("#facturador_nombreEmisor").removeClass("valid");
	
	$("#facturador_identifiacion").removeClass("invalid");
	$("#facturador_nombre").removeClass("invalid");
	$("#facturador_apellido").removeClass("invalid");
	$("#facturador_telefono").removeClass("invalid");
	$("#facturador_celular").removeClass("invalid");
	$("#facturador_direccion").removeClass("invalid");
	$("#facturador_email").removeClass("invalid");
	$("#facturador_razonSocial").removeClass("invalid");
	$("#facturador_identifiacionEmisor").removeClass("invalid");
	$("#facturador_nombreEmisor").removeClass("invalid");
	
	
  	$('#facturador_tipoRegimen').material_select('destroy');
  	$('#facturador_tipoRegimen').material_select();	
	
	
}
//---



//para incativar una resolucion
function desactivarFacturador(idFacturador){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivarFacturador").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/desactivarFacturador.php",
        dataType: "html",
        type : 'POST',
        data: { idFacturador : idFacturador },
        success: function(data) {			

			$('#spanF_'+idFacturador).html('<a id="'+idFacturador+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarFacturador(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');		
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//----

//funcion para activar una resolucion
function activarFacturador(idFacturador){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivarFacturador").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/activarFacturador.php",
        dataType: "html",
        type : 'POST',
        data: { idFacturador : idFacturador },
        success: function(data) {			

			$('#spanF_'+idFacturador).html('<a id="'+idFacturador+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarFacturador(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');		
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para mostrar la edicion de un facturador
function editarFacturador(idFacturador, identificacion, nombre, apellido, telefono, celular, direccion, email, tipoRegimen, razonSocial, identificacionEmisor, nombreEmisor){
	
	cancelarGuardadoNuevoFacturador();
	cancelarGuardadoNuevaResolucion();
	

	
	$("#label_editar_facturador_identifiacion").addClass("active");
	$("#label_editar_facturador_nombre").addClass("active");
	$("#label_editar_facturador_apellido").addClass("active");
	$("#label_editar_facturador_telefono").addClass("active");
	$("#label_editar_facturador_celular").addClass("active");
	$("#label_editar_facturador_direccion").addClass("active");
	$("#label_editar_facturador_email").addClass("active");
	$("#label_editar_facturador_razonSocial").addClass("active");
	$("#label_editar_facturador_identifiacionEmisor").addClass("active");
	$("#label_editar_facturador_nombreEmisor").addClass("active");	

	$("#editar_facturador_id").val(idFacturador);
	$("#editar_facturador_identifiacion").val(identificacion);
	$("#editar_facturador_nombre").val(nombre);
	$("#editar_facturador_apellido").val(apellido);
	$("#editar_facturador_telefono").val(telefono);
	$("#editar_facturador_celular").val(celular);
	$("#editar_facturador_direccion").val(direccion);
	$("#editar_facturador_email").val(email);
	$("#editar_facturador_razonSocial").val(razonSocial);
	
	$("#editar_facturador_identifiacionEmisor").val(identificacionEmisor);
	$("#editar_facturador_nombreEmisor").val(nombreEmisor);


	switch(tipoRegimen) {
	    case '1':
	         $("#editar_facturador_tipoRegimen").val("1");	         
	        break;
	    case '2':
	        $("#editar_facturador_tipoRegimen").val("2");
	        break;
	    default:
	        $("#editar_facturador_tipoRegimen").val("");
	}

  	$('#editar_facturador_tipoRegimen').material_select('destroy');
  	$('#editar_facturador_tipoRegimen').material_select();		
	

	$("#columnaNuevaResolucion").hide("slower");
	$("#columnaNuevoFacturador").removeClass("m6").removeClass("l6").addClass("m12").addClass("l12");
	
	$("#tituloLiFacturadores").hide("slower");
	
	$("#div_hiddenEditarFacturador").show("slower");	

	
}
//---



//funcion para validar el guardado de un nuevo facturador
function validarGuardadoEditarFacturador(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#editar_facturador_identifiacion").val().trim().length == 0 ){
		
		$("#label_editar_facturador_identifiacion").addClass( "active" );
		$("#editar_facturador_identifiacion").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#editar_facturador_nombre").val().trim().length == 0 ){
		
		$("#label_editar_facturador_nombre").addClass( "active" );
		$("#editar_facturador_nombre").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#editar_facturador_apellido").val().trim().length == 0 ){
		
		$("#label_editar_facturador_apellido").addClass( "active" );
		$("#editar_facturador_apellido").addClass( "invalid" );
		sw = 1;
	}		
	
	if( $("#editar_facturador_telefono").val().trim().length == 0 ){
		
		$("#label_editar_facturador_telefono").addClass( "active" );
		$("#editar_facturador_telefono").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#editar_facturador_direccion").val().trim().length == 0 ){
		
		$("#label_editar_facturador_direccion").addClass( "active" );
		$("#editar_facturador_direccion").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#editar_facturador_email").val().trim().length == 0 ){
		
		$("#label_editar_facturador_email").addClass( "active" );
		$("#editar_facturador_email").addClass( "invalid" );
		sw = 1;
	}else if($("#editar_facturador_email").val().indexOf('@', 0) == -1 || $("#editar_facturador_email").val().indexOf('.', 0) == -1) {
            $("#label_editar_facturador_email").addClass( "active" );
			$("#editar_facturador_email").addClass( "invalid" );
			sw = 1;
        }	
	
	if( $("#editar_facturador_razonSocial").val().trim().length == 0 ){
		
		$("#label_editar_facturador_razonSocial").addClass( "active" );
		$("#editar_facturador_razonSocial").addClass( "invalid" );
		sw = 1;
	}	


	if( $("#editar_facturador_identifiacionEmisor").val().trim().length == 0 ){
		
		$("#label_editar_facturador_identifiacionEmisor").addClass( "active" );
		$("#editar_facturador_identifiacionEmisor").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#editar_facturador_nombreEmisor").val().trim().length == 0 ){
		
		$("#label_editar_facturador_nombreEmisor").addClass( "active" );
		$("#editar_facturador_nombreEmisor").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		
		$("#form_editarFacturador").submit();
	}
	
}
//---





//metodo para cancelar la edicion de un nuevo facturador
function cancelarGuardadoEditarFacturador(){
	
	$("#columnaNuevoFacturador").removeClass("m12").removeClass("l12").addClass("m6").addClass("l6");
	
	$("#div_hiddenEditarFacturador").hide("slower");
	
	$("#tituloLiFacturadores").show("slower");
	$("#columnaNuevaResolucion").show("slower");	
	
	//se limpian los campos
	$("#editar_facturador_id").val("0");
	$("#editar_facturador_identifiacion").val("");
	$("#editar_facturador_nombre").val("");
	$("#editar_facturador_apellido").val("");
	$("#editar_facturador_telefono").val("");
	$("#editar_facturador_celular").val("");
	$("#editar_facturador_direccion").val("");
	$("#editar_facturador_email").val("");
	$("#editar_facturador_tipoRegimen").val("");
	$("#editar_facturador_razonSocial").val("");
	$("#editar_facturador_identifiacionEmisor").val("");
	$("#editar_facturador_nombreEmisor").val("");
	
	$("#label_editar_facturador_identifiacion").removeClass("active");
	$("#label_editar_facturador_nombre").removeClass("active");
	$("#label_editar_facturador_apellido").removeClass("active");
	$("#label_editar_facturador_telefono").removeClass("active");
	$("#label_editar_facturador_celular").removeClass("active");
	$("#label_editar_facturador_direccion").removeClass("active");
	$("#label_editar_facturador_email").removeClass("active");
	$("#label_editar_facturador_razonSocial").removeClass("active");
	$("#label_editar_facturador_identifiacionEmisor").removeClass("active");
	$("#label_editar_facturador_nombreEmisor").removeClass("active");
	
	$("#editar_facturador_identifiacion").removeClass("valid");
	$("#editar_facturador_nombre").removeClass("valid");
	$("#editar_facturador_apellido").removeClass("valid");
	$("#editar_facturador_telefono").removeClass("valid");
	$("#editar_facturador_celular").removeClass("valid");
	$("#editar_facturador_direccion").removeClass("valid");
	$("#editar_facturador_email").removeClass("valid");
	$("#editar_facturador_razonSocial").removeClass("valid");
	$("#editar_facturador_identifiacionEmisor").removeClass("valid");
	$("#editar_facturador_nombreEmisor").removeClass("valid");
	
	$("#editar_facturador_identifiacion").removeClass("invalid");
	$("#editar_facturador_nombre").removeClass("invalid");
	$("#editar_facturador_apellido").removeClass("invalid");
	$("#editar_facturador_telefono").removeClass("invalid");
	$("#editar_facturador_celular").removeClass("invalid");
	$("#editar_facturador_direccion").removeClass("invalid");
	$("#editar_facturador_email").removeClass("invalid");
	$("#editar_facturador_razonSocial").removeClass("invalid");
	$("#editar_facturador_identifiacionEmisor").removeClass("invalid");
	$("#editar_facturador_nombreEmisor").removeClass("invalid");
	
	
  	$('#editar_facturador_tipoRegimen').material_select('destroy');
  	$('#editar_facturador_tipoRegimen').material_select();	
	
	
}
//---







//funcion para consultar los facturadores de una resolucion
function consultarRelacionFacturadores(idResolucion){
	
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/consultarFacturadoresResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idResolucion : idResolucion },
        success: function(data) {			

			
			$("#resultadoVinculosResolucionFacturadores").html(data);
			
			$('.tooltipped').tooltip({delay: 50});
			
		  	$('#selectFacturadoresActivos').material_select('destroy');
		  	$('#selectFacturadoresActivos').material_select();				
			
			
        }//fin success
  	});	
	
}
//---


//funcion para vincular un facturador con una resolucion
function vincularFacturadorResolucion(){

	if( $("#selectFacturadoresActivos").val() == "" ){
		
		
		$("#div_selectFacturadoresActivos").addClass("red lighten-3");
		
		return false;
	}else{
		
		$("#div_selectFacturadoresActivos").removeClass("red lighten-3");
		
	}

	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/vincularFacturadorResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idResolucion : $("#modal_idResolucion").val(), idFacturador : $("#selectFacturadoresActivos").val() },
        success: function(data) {			

			if(data == "existe"){
				$("#errorVinculo").show("slower");
			}else{
				consultarRelacionFacturadores($("#modal_idResolucion").val());
			}
			
        }//fin success
  	});		
	
	
}
//---





//para incativar un vinculo de una resolucion con un facturador
function desactivarVinculoFacuradorResolucion(idVinculo){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivarVinculo").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/desactivarVinculoFacturadorResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanVFR_'+idVinculo).html('<a id="'+idVinculo+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarVinculoFacuradorResolucion(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
					
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//----

//funcion para activar vinculo de una resolucion con un facturador
function activarVinculoFacuradorResolucion(idVinculo){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivarVinculo").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/activarVinculoFacturadorResolucion.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanVFR_'+idVinculo).html('<a id="'+idVinculo+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarVinculoFacuradorResolucion(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');		
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para marcar un facturador por defecto
function marcarFacturadorDefecto(idFacturador){
	
	$('input:checkbox').addClass("otrosCheck");
	$('#facturadorDefecto_'+idFacturador).removeClass("otrosCheck");
	

	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/facturadorPorDefecto.php",
        dataType: "html",
        type : 'POST',
        data: { idFacturador : idFacturador },
        success: function() {			

			 $('.otrosCheck').attr('checked', false);
			 $('.otrosCheck').attr('disabled', false);
			 $('#facturadorDefecto_'+idFacturador).attr('disabled', true);

			
        }//fin success
  	});			
	
	
	
}
//---


//funcion para guardar los precios de consulta y hospitalizacion
function guardarPreciosConfiguracion(){

	var txt = $("#confirmacionGuardadoPrecio").html();

	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/configuracionFacturacion/guardarPrecios.php",
        dataType: "html",
        type : 'POST',
        data: { precioConsulta : $("#precioConsulta").val(), precioHospitalizacion : $("#precioHospitalizacion").val() },
        success: function() {			

			 Materialize.toast(txt, 4000);
			
        }//fin success
  	});		
	
}
//---
