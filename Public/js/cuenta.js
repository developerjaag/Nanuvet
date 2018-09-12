/*
 * Archivo con las funciones para la cuenta
 */

function validarCambioInformacion(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#identificacion").val().trim().length == 0 ){
		
		$("#label_identificacion").addClass( "active" );
		$("#identificacion").addClass( "invalid" );
		sw = 1;
	}	

    if( $("#nombre").val().trim().length == 0 ){
		
		$("#label_nombre").addClass( "active" );
		$("#nombre").addClass( "invalid" );
		sw = 1;
	}	

    if( $("#telefono1").val().trim().length == 0 ){
		
		$("#label_telefono1").addClass( "active" );
		$("#telefono1").addClass( "invalid" );
		sw = 1;
	}		

    if( $("#celular").val().trim().length == 0 ){
		
		$("#label_celular").addClass( "active" );
		$("#celular").addClass( "invalid" );
		sw = 1;
	}		

    if( $("#direccion").val().trim().length == 0 ){
		
		$("#label_direccion").addClass( "active" );
		$("#direccion").addClass( "invalid" );
		sw = 1;
	}		

    if( $("#email").val().trim().length == 0 ){
		
		$("#label_email").addClass( "active" );
		$("#email").addClass( "invalid" );
		sw = 1;
	}else if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
            $("#label_email").addClass( "active" );
			$("#email").addClass( "invalid" );
			sw = 1;
        }			
	
	

	if(sw == 1){
		return false;
	}else{
		$('#modalConfirmarCambios').openModal();
	}
	
}
//---


//funcion para validar que la contraseña que se ingresa para modificar la informcaion sea la correcta
function validarPassActualCambioInformacion(){
	
	
	$.ajax({
      		url: "../Controllers/perfil/verificarPassActual.php",
            dataType: "html",
            type : 'POST',
            data: { passIngresada : $("#passActualInformacion").val() },
            success: function(data) {
  				
  				if(data == 'OK'){
  					
  					$("#paraMostrarMensajeModalInformacion").html("&nbsp;");
  					
  					$('#modalConfirmarCambios').closeModal();
  					
  					$("#form_informacionCuenta").submit();
  					 					
  				}else{
  					
  					//si la contraseña no coincide con la actual, se muestra un mensaje de error
  					$("#paraMostrarMensajeModalInformacion").html($("#mensajeErrorPassActual").val());
  					
  				}//fin else
  				
  				
            }
      	});
	
	
	
	
}
//---


//funcion para desvincular una licencia de un usuario
function desvincularLicencia(idLicencia){

		swal({
		  title: 'Quitarle la licencia al usuario?',
		  text: "Un usuario que no se encuentre vinculado a una licenica, no puede ingresar al sistema!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: 'Si, desvincularla!',
		  cancelButtonText: 'Cancelar',
		},function(){
			

			$.ajax({
		  		url: "../Controllers/cuenta/desvincularLicencia.php",
		        dataType: "html",
		        async: false, 
		        cache: false,
		        type : 'POST',
		        data: {
        	    	idLicencia 	: idLicencia
        		},
		        success: function() {
		        	
		        		window.location.href = "http://www.nanuvet.com/cuenta/";

		        			             
		        }
		  	});				
	
			
		});
		
	
	

	
} 
//---


//funcion para vincular una licencia a un usuario
function vincularLicencia(idLicencia, fecha){

	$("#InformacionLicencia").html("");
	$("#idLicenciaVincular").val("");
	
	$("#InformacionLicencia").html(fecha);
	$("#idLicenciaVincular").val(idLicencia);
	
	$('#modalAdicionarLicenciaUsuario').openModal();
	
	
}
//---


//funcion para verificar que todo salga bien al vincular un usuario con una licencia
function validarAdicionLicenciaUsuario(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( ($("#idUsuarioVincular").val() == "") || ($("#idUsuarioVincular").val() == null) ){
		
		$("#errorVincularLicencia").html($("#textoErrorVincularLicencia").html());
		sw = 1;
	}	


	if(sw == 1){
		return false;
	}else{
		$("#form_adicionarLicenciaUsuario").submit();
	}
	
}
//---


//funcion para validar la adicion de la nueva licencia
function continuarCompraNuevaLicencia(){
	
	var selected = $("#select_precio").find('option:selected');
    var cantidad = selected.data('cantidad');
    var valor   = selected.data('valor');
	
	//pedir confirmacion
		swal({
		  title: "Ir a la pasarela de pagos.",
		  text: 'Cantidad de licencias: '+cantidad+' por un valor de '+valor,
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: 'Si, ir a pagar',
		  cancelButtonText: 'Cancelar',
		},function(){
			

			$.ajax({
		  		url: "../Controllers/cuenta/prepararDatosNuevaLicencia.php",
		        dataType: "json",
		        type : 'POST',
		        data: {
        	    	plan	: $("#select_precio").val()
        	    	
        		},
		        success: function(data) {
		        	if (data.mensaje == 'Error') {
		        		
		        		sweetAlert("Ups...", "Algo salio mal!", "error");
						return false;
		        		
		        	}else if (data.mensaje == 'Ok'){
		        		//se envia cargan las variables del formulario para la pasarela
		        		
		        		$("#amount").val(data.valorPO);
		        		$("#merchantId").val('563742');//produccion
		        		//$("#merchantId").val('508029');//pruebas
		        		$("#referenceCode").val(data.referenciaVenta);
		        		$("#accountId").val('566300');
		        		$("#description").val(data.descripcionVenta);
		        		$("#signature").val(data.firmaPO);
		        		$("#currency").val('COP');//se define el tipo de moneda a utilizar
		        		$("#buyerEmail").val(data.titular_email);
		        		$("#responseUrl").val("http://www.nanuvet.com/Controllers/index/pagos_respuesta.php");
		        		$("#confirmationUrl").val("http://www.nanuvet.com/Controllers/index/pagos_confirmacion.php");
		        		$("#mobilePhone").val(data.titular_celular);
		        		$("#billingAddress").val(data.titular_direccion);
		        		$("#telephone").val(data.titular_telefono1);
		        		$("#algorithmSignature").val('SHA');
		        		$("#payerEmail").val(data.titular_email);
		        		$("#payerPhone").val(data.titular_telefono1);
		        		$("#payerMobilePhone").val(data.titular_celular);        		
		        		
		        		
		        		$("#form_envioPasarela").submit();
		        		
		        	};
		        			             
		        }
		  	});				
			
			
			
			
		});
	
	
}
//---


//funcion para mostrar el form para adicionar licencia
function mostrarAdicionarLicencia(){

	$("#hiddenFormNuevalicencia").show('slwoer');
	
}
//---

//funcion para cancelar la nueva compra
function cancelarCompraNuevaLicencia(){
	
	$("#hiddenFormNuevalicencia").hide('slwoer');
}
//---
