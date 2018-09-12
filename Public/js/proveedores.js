/*
 * Funciones para proveedores
 */


//funcion para abrir el formulario de nuevo
function mostrarFormNuevoProveedor(){
	
	$("#hidden_NuevoProveedor").show('slower');
	
}
//---

//cancelar el guardado d eun nuevo proveedor
function cancelarGuardadoNuevoProveedor(){
	
	$("#hidden_NuevoProveedor").hide('slower');
	
	$("#identificativo").val("");
	$("#nombre").val("");
	$("#telefono1").val("");
	$("#telefono2").val("");
	$("#celular").val("");
	$("#direccion").val("");
	$("#email").val("");
	
	$("#label_identificativo").removeClass("active");
	$("#label_nombre").removeClass("active");
	$("#label_telefono1").removeClass("active");
	$("#label_telefono2").removeClass("active");
	$("#label_celular").removeClass("active");
	$("#label_direccion").removeClass("active");
	$("#label_email").removeClass("active");
	
	$("#identificativo").removeClass("valid");
	$("#nombre").removeClass("valid");
	$("#telefono1").removeClass("valid");
	$("#telefono2").removeClass("valid");
	$("#celular").removeClass("valid");
	$("#direccion").removeClass("valid");
	$("#email").removeClass("valid");
	
	$("#identificativo").removeClass("invalid");
	$("#nombre").removeClass("invalid");
	$("#telefono1").removeClass("invalid");
	$("#telefono2").removeClass("invalid");
	$("#celular").removeClass("invalid");
	$("#direccion").removeClass("invalid");
	$("#email").removeClass("invalid");	
}
//---

//validar el guardado de un nuevo proveedor
function validarGuardadoNuevoProveedor(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#identificativo").val().trim().length == 0 ){
		
		$("#label_identificativo").addClass( "active" );
		$("#identificativo").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#nombre").val().trim().length == 0 ){
		
		$("#label_nombre").addClass( "active" );
		$("#nombre").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#email").val().trim().length != 0 ){
		
		if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
            $("#label_email").addClass( "active" );
			$("#email").addClass( "invalid" );
			sw = 1;
        }	
		
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoProveedor").submit();
	}	
		
}
//---


//funcion para abrir el formulario de edicion de un proveedor
function editarProveedor(idProveedor,nombre,telefono1,telefono2,celular,direccion,email,identificativoNit){
	
	$("#editar_idProveedor").val(idProveedor);
	$("#editar_identificativo").val(identificativoNit);
	$("#editar_nombre").val(nombre);
	$("#editar_telefono1").val(telefono1);
	$("#editar_telefono2").val(telefono2);
	$("#editar_celular").val(celular);
	$("#editar_direccion").val(direccion);
	$("#editar_email").val(email);
	
	$("#label_editar_identificativo").addClass("active");
	$("#label_editar_nombre").addClass("active");
	$("#label_editar_telefono1").addClass("active");
	$("#label_editar_telefono2").addClass("active");
	$("#label_editar_celular").addClass("active");
	$("#label_editar_direccion").addClass("active");
	$("#label_editar_email").addClass("active");	
	
	cancelarGuardadoNuevoProveedor();
	$("#tituloLi").hide("slower");
	$("#hidden_editarProveedor").show("slower");
	
}
//---


//cancelar la edicion d eun proveedor
function cancelarEdicionProveedor(){

	
	$("#hidden_editarProveedor").hide("slower");
	$("#tituloLi").show("slower");


	$("#editar_idProveedor").val("");
	$("#editar_identificativo").val("");
	$("#editar_nombre").val("");
	$("#editar_telefono1").val("");
	$("#editar_telefono2").val("");
	$("#editar_celular").val("");
	$("#editar_direccion").val("");
	$("#editar_email").val("");
	
	$("#label_editar_identificativo").removeClass("active");
	$("#label_editar_nombre").removeClass("active");
	$("#label_editar_telefono1").removeClass("active");
	$("#label_editar_telefono2").removeClass("active");
	$("#label_editar_celular").removeClass("active");
	$("#label_editar_direccion").removeClass("active");
	$("#label_editar_email").removeClass("active");	

	$("#editar_idProveedor").removeClass("valid");
	$("#editar_identificativo").removeClass("valid");
	$("#editar_nombre").removeClass("valid");
	$("#editar_telefono1").removeClass("valid");
	$("#editar_telefono2").removeClass("valid");
	$("#editar_celular").removeClass("valid");
	$("#editar_direccion").removeClass("valid");
	$("#editar_email").removeClass("valid");

	$("#editar_idProveedor").removeClass("invalid");
	$("#editar_identificativo").removeClass("invalid");
	$("#editar_nombre").removeClass("invalid");
	$("#editar_telefono1").removeClass("invalid");
	$("#editar_telefono2").removeClass("invalid");
	$("#editar_celular").removeClass("invalid");
	$("#editar_direccion").removeClass("invalid");
	$("#editar_email").removeClass("invalid");
	

}
//---

//validar la edicion de un proveedor
function comprobarEdicionProveedor(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#editar_identificativo").val().trim().length == 0 ){
		
		$("#label_editar_identificativo").addClass( "active" );
		$("#editar_identificativo").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#editar_nombre").val().trim().length == 0 ){
		
		$("#label_editar_nombre").addClass( "active" );
		$("#editar_nombre").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#editar_email").val().trim().length != 0 ){
		
		if($("#editar_email").val().indexOf('@', 0) == -1 || $("#editar_email").val().indexOf('.', 0) == -1) {
            $("#label_editar_email").addClass( "active" );
			$("#editar_email").addClass( "invalid" );
			sw = 1;
        }	
		
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarProveedor").submit();
	}	

	
}
//---


//funcion para desactiva run proveedor
function desactivarProveedor(idProveedor){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/proveedores/desactivarProveedor.php",
        dataType: "html",
        type : 'POST',
        data: { idProveedor : idProveedor },
        success: function(data) {			

			$('#spanP_'+idProveedor).html('<a id="'+idProveedor+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarProveedor(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un proveedor
function activarProveedor(idProveedor){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/proveedores/activarProveedor.php",
        dataType: "html",
        type : 'POST',
        data: { idProveedor : idProveedor },
        success: function(data) {			

			$('#spanP_'+idProveedor).html('<a id="'+idProveedor+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarProveedor(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});			
	
}


//buscar un proveedor con un string
function buscarProveedor(){

   $('#buscarProveedor').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/proveedores/buscarProveedor.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringProveedor : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idProveedorBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/proveedores/mostrarBusquedaProveedor.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idProveedor : $("#idProveedorBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoProveedoresAjax").html(data);
						
						$("#resultadoProveedores").hide('slower');	   
						$("#resultadoProveedoresAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});                   
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 


	
}
//---

//cancelar la busqueda de un proveedor
function cerrarBusquedaProveedor(){
	
	$("#resultadoProveedoresAjax").hide('slower');
	$("#buscarProveedor").val("");	
	$("#buscarProveedor").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoProveedores").show('slower');
	
}
//---
