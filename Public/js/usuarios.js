/*
 * Funciones para el modulo de usuarios
 */

//funcion para mostrar el formulario de nuevo usuario
function mostrarFormNuevoUsuario(){
	
	$("#tituloLi").hide('slower');
	$("#hidden_formNuevoUsuario").show('slower');
	
}
//---

//funcion para cancelar la crecion de un nuevo usuario
function cancelarGuardadoUsuario(){
	
	$("#hidden_formNuevoUsuario").hide('slower');	
	$("#tituloLi").show('slower');
	
	//se limpian los campos
	$("#identificacion").val("");
	$("#nombre").val("");
	$("#apellido").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#direccion").val("");
	$("#email").val("");
	$("#idLicenciaParaUsuario").val("0");
	$("#sucursalesUsuario").val("0");
	$("#usarAgenda").prop( "checked", false );
	$("#estado").prop( "checked", true );
	

	//se remueve las clases activas
	$("#label_identificacion").removeClass("active");
	$("#label_nombre").removeClass("active");
	$("#label_apellido").removeClass("active");
	$("#label_telefono").removeClass("active");
	$("#label_celular").removeClass("active");
	$("#label_direccion").removeClass("active");
	$("#label_email").removeClass("active");

	$("#identificacion").removeClass("valid");
	$("#nombre").removeClass("valid");
	$("#apellido").removeClass("valid");
	$("#telefono").removeClass("valid");
	$("#celular").removeClass("valid");
	$("#direccion").removeClass("valid");
	$("#email").removeClass("valid");

	$("#identificacion").removeClass("invalid");
	$("#nombre").removeClass("invalid");
	$("#apellido").removeClass("invalid");
	$("#telefono").removeClass("invalid");
	$("#celular").removeClass("invalid");
	$("#direccion").removeClass("invalid");
	$("#email").removeClass("invalid");

}
//---


//funcion para validar el guardado de un usuario
function validarGuardadoUsuario(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	var swSucursal = 0; //variable para validar si se eligiron sucursales para el usuario

	
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


	if( $("#apellido").val().trim().length == 0 ){
		
		$("#label_apellido").addClass( "active" );
		$("#apellido").addClass( "invalid" );
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
        
    //saber si eligio sucursal
    $.each($("#sucursalesUsuario").val(), function( index, value ) {
	  swSucursal = 1;
	  return false;
	});			
	
	if(swSucursal == 0){
		$("#spanErrorSucursal").show();
		sw = 1;
	}else{
		$("#spanErrorSucursal").hide();
	}
		
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoUsuario").submit();
	}		
	
}
//---


//funcion para mostrar el formulario de edicion
function editarUsuario(idUsuario, identificacion, nombre, apellido, telefono, celular, direccion, email, agenda, estado){
	
		cancelarGuardadoUsuario();
		
		$("#tituloLi").hide('slower');
	
	
		$("#idUsuario").val(idUsuario);
		$("#editer_identificacion").val(identificacion);
		$("#editer_nombre").val(nombre);
		$("#editer_apellido").val(apellido);
		$("#editer_telefono").val(telefono);
		$("#editer_celular").val(celular);
		$("#editer_direccion").val(direccion);
		$("#editer_email").val(email);
		
		
		
		if(agenda == 'Si'){
			$("#editer_usarAgenda").prop( "checked", true );
		}else{
			$("#editer_usarAgenda").prop( "checked", false );
		}
		
		if(estado == 'A'){
			$("#editer_estado").prop( "checked", true );
		}else{
			$("#editer_estado").prop( "checked", true );
		}
		
		
		$("#label_editer_identificacion").addClass( "active" );
		$("#label_editer_nombre").addClass( "active" );
		$("#label_editer_apellido").addClass( "active" );
		$("#label_editer_telefono").addClass( "active" );
		$("#label_editer_celular").addClass( "active" );
		$("#label_editer_direccion").addClass( "active" );
		$("#label_editer_email").addClass( "active" );
		
		//mostrar div
		$("#form_hidden_editarUsuario").show('slower');

}
//---


//funcion para cancelar la edicion de un usuario
function cancelarEdicionUsuario(){
	
		$("#form_hidden_editarUsuario").hide('slower');
		$("#tituloLi").show('slower');
	
		$("#idUsuario").val("");
		$("#editer_identificacion").val("");
		$("#editer_nombre").val("");
		$("#editer_apellido").val("");
		$("#editer_telefono").val("");
		$("#editer_celular").val("");
		$("#editer_direccion").val("");
		$("#editer_email").val("");	

		$("#editer_usarAgenda").prop( "checked", false );
		$("#editer_estado").prop( "checked", true );
		
	
		//se remueve las clases activas
		$("#label_editer_telefono").removeClass("active");
		$("#label_editer_celular").removeClass("active");
		$("#label_editer_direccion").removeClass("active");
	
		$("#editer_telefono").removeClass("valid");
		$("#editer_celular").removeClass("valid");
		$("#editer_direccion").removeClass("valid");
	
		$("#editer_telefono").removeClass("invalid");
		$("#editer_celular").removeClass("invalid");
		$("#editer_direccion").removeClass("invalid");
		
}
//---


//funcion para validar la edicion de un usuario
function validarEdicionUsuario(){
	
	$("#form_editarUsuario").submit();
}
//---

