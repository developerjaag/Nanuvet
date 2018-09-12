/*
 * Funcion para validar el restablecimiento de la contraseña
 */

function valirCambioPass(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
    

    if( $("#nuevoPass").val().trim().length == 0 ){
		
		$("#label_nuevoPass").addClass( "active" );
		$("#nuevoPass").addClass( "invalid" );
		sw = 1;
	}	

    if( $("#repetirNuevoPass").val().trim().length == 0 ){
		
		$("#label_repetirNuevoPass").addClass( "active" );
		$("#repetirNuevoPass").addClass( "invalid" );
		sw = 1;
	}	
	
	//verificar que la confirmación de la nueva contraseña coincida
	if($("#nuevoPass").val() != $("#repetirNuevoPass").val()){
		
		$("#paraMostrarMensaje").html($("#mensajeErrorPassNuevaConfirmar").html());

		sw = 1;
	}else{
		
		$("#paraMostrarMensaje").html("&nbsp;");
		
	}

	if(sw == 1){
		return false;
	}else{
	
		$("#form_restablecerPass").submit();
		
	}	
	
	
}
//---
