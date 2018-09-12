/*
 * Archivo javascript que contiene las funciones del perfil
 */

/*
 * Funcion mostrar video tutorial y darle play
 */
function playVideoTutorial(){
	
	$("#div_videoTutorial").show("slower");
	$('#videoTutorial_perfil').get(0).play();
	
}
//---

/*
 * Funcion para cerrar el video tutorial
 */
function cerrarVideoTutorial(){
	$('#videoTutorial_perfil').get(0).pause();
	$("#div_videoTutorial").hide("slower");
}


//funcion para validar el cambio de contraseña
function validarCambioPass(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#passActual").val().trim().length == 0 ){
		
		$("#label_passActual").addClass( "active" );
		$("#passActual").addClass( "invalid" );
		sw = 1;
	}	

    if( $("#passNueva").val().trim().length == 0 ){
		
		$("#label_passNueva").addClass( "active" );
		$("#passNueva").addClass( "invalid" );
		sw = 1;
	}	

    if( $("#passNuevaRepetida").val().trim().length == 0 ){
		
		$("#label_passNuevaRepetida").addClass( "active" );
		$("#passNuevaRepetida").addClass( "invalid" );
		sw = 1;
	}	
	
	//verificar que la confirmación de la nueva contraseña coincida
	if($("#passNueva").val() != $("#passNuevaRepetida").val()){
		
		$("#paraMostrarMensaje").html($("#mensajeErrorPassNuevaConfirmar").val());

		sw = 1;
	}else{
		
		$("#paraMostrarMensaje").html("&nbsp;");
		
	}

	if(sw == 1){
		return false;
	}else{
		//validar si la contraseña actual si coincide
		$.ajax({
      		url: "../Controllers/perfil/verificarPassActual.php",
            dataType: "html",
            type : 'POST',
            data: { passIngresada : $("#passActual").val() },
            success: function(data) {
  				
  				if(data == 'OK'){
  					
  					$("#paraMostrarMensaje").html("&nbsp;");
  					
  					//si todo va bien se procede a cambiar la contraseña
  					$.ajax({
			      		url: "../Controllers/perfil/cambiarPass.php",
			            dataType: "html",
			            type : 'POST',
			            data: { nuevaPass : $("#passNueva").val() },
			            success: function(data) {
			  				
			  				if(data == 'OK'){
			  					
			  					$('#modalCambiarPass').closeModal();
			  					
			  					swal(
								  $("#mensajeOkCambioPass").val() ,
								  '',
								  'success'
								)
			  					
			  				}else{
			  					
			  					$('#modalCambiarPass').closeModal();
			  					
			  					swal(
								  $("#mensajeErrorActualizarPass").val() ,
								  '',
								  'error'
								)
			  					
			  				}//fin else
			  				
			  				
			            }
			      	});
  					
  					
  				}else{
  					
  					//si la contraseña no coincide con la actual, se muestra un mensaje de error
  					$("#paraMostrarMensaje").html($("#mensajeErrorPassActual").val());
  					
  				}//fin else
  				
  				
            }
      	});
	}

	
}
//---

//funcion para validar el cambio de la información
function validarCambioInformacion(){
	

	var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#identificacion").val().trim().length == 0 ){
		
		$("#label_identificacion").addClass( "active" );
		$("#identificacion").addClass( "invalid" );
		sw = 1;
	}

    if( $("#nombres").val().trim().length == 0 ){
		
		$("#label_nombres").addClass( "active" );
		$("#nombres").addClass( "invalid" );
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
  					
  					$("#form_perfil").submit();
  					 					
  				}else{
  					
  					//si la contraseña no coincide con la actual, se muestra un mensaje de error
  					$("#paraMostrarMensajeModalInformacion").html($("#mensajeErrorPassActual").val());
  					
  				}//fin else
  				
  				
            }
      	});
	
	
	
	
}
//---
