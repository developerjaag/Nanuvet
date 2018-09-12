/*
 * Archivo que contiene las funciones de las sucursales
 */

//funcion para mostrar el formulario de nueva sucursal
function mostrarFormNuevaSucursal(){


	$("#tituloLi").hide('slower');
	
	//se muestra el div
	$("#hideen_nuevaSucursal").show('slower');
	
	
}
//---

//funcion para cancelar la creacion de una nueva sucursal
function cancelarGuardadoSucursal(){

//se limpian los campos
	$("#idPais").val("0");
	$("#idCiudad").val("0");
	$("#idBarrio").val("0");
	$("#sucursal_nit").val("");
	$("#sucursal_nombre").val("");
	$("#sucursal_leyendaEncabezado").val("");
	$("#sucursal_telefono1").val("");
	$("#sucursal_telefono2").val("");
	$("#sucursal_celular").val("");
	$("#sucursal_direccion").val("");
	$("#sucursal_email").val("");
	$("#path_sucursal_logo").val("");
	$("#pais").val("");
	$("#ciudad").val("");
	$("#barrio").val("");
	
	//se remueve las clases activas
	$("#label_sucursal_nit").removeClass("active");
	$("#label_sucursal_nombre").removeClass("active");
	$("#label_sucursal_leyendaEncabezado").removeClass("active");
	$("#label_sucursal_telefono1").removeClass("active");
	$("#label_sucursal_telefono2").removeClass("active");
	$("#label_sucursal_celular").removeClass("active");
	$("#label_sucursal_latitud").removeClass("active");
	$("#label_sucursal_longitud").removeClass("active");
	$("#label_sucursal_direccion").removeClass("active");
	$("#label_sucursal_email").removeClass("active");
	$("#label_sucursal_pais").removeClass("active");
	$("#label_sucursal_ciudad").removeClass("active");
	$("#label_sucursal_barrio").removeClass("active");
	
	//se formatea el input file
	var foto = $("#sucursal_logo");
	foto.replaceWith( foto = foto.clone( true ) );
	
	$("#sucursal_nit").removeClass("valid");
	$("#sucursal_nombre").removeClass("valid");
	$("#sucursal_leyendaEncabezado").removeClass("valid");
	$("#sucursal_telefono1").removeClass("valid");
	$("#sucursal_telefono2").removeClass("valid");
	$("#sucursal_celular").removeClass("valid");
	$("#sucursal_direccion").removeClass("valid");
	$("#sucursal_email").removeClass("valid");
	$("#pais").removeClass("valid");
	$("#ciudad").removeClass("valid");
	$("#barrio").removeClass("valid");
	
	$("#sucursal_nit").removeClass("invalid");
	$("#sucursal_nombre").removeClass("invalid");
	$("#sucursal_leyendaEncabezado").removeClass("invalid");
	$("#sucursal_telefono1").removeClass("invalid");
	$("#sucursal_telefono2").removeClass("invalid");
	$("#sucursal_celular").removeClass("invalid");
	$("#sucursal_direccion").removeClass("invalid");
	$("#sucursal_email").removeClass("invalid");
	$("#pais").removeClass("invalid");
	$("#ciudad").removeClass("invalid");
	$("#barrio").removeClass("invalid");
	
	//se oculta
	$("#hideen_nuevaSucursal").hide('slower');
	
	//se muestra el titulo del li
	$("#tituloLi").show('slower');
	
}
//---


//funcion para validar el guardado de una sucursal
function validarGuardadoSucursal(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar

	
	if( $("#sucursal_nombre").val().trim().length == 0 ){
		
		$("#label_sucursal_nombre").addClass( "active" );
		$("#sucursal_nombre").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#sucursal_telefono1").val().trim().length == 0 ){
		
		$("#label_sucursal_telefono1").addClass( "active" );
		$("#sucursal_telefono1").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#sucursal_celular").val().trim().length == 0 ){
		
		$("#label_sucursal_celular").addClass( "active" );
		$("#sucursal_celular").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#sucursal_direccion").val().trim().length == 0 ){
		
		$("#label_sucursal_direccion").addClass( "active" );
		$("#sucursal_direccion").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#idPais").val() == '0' ){
		
		$("#label_sucursal_pais").addClass( "active" );
		$("#pais").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#idCiudad").val() == '0' ){
		
		$("#label_sucursal_ciudad").addClass( "active" );
		$("#ciudad").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#idBarrio").val() == '0'){
		
		$("#label_sucursal_barrio").addClass( "active" );
		$("#barrio").addClass( "invalid" );
		sw = 1;
	}	
	

	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaSucursal").submit();
	}

	
}
//---

var map;


//funcion para mostrar el mapa de una sucursal (con una marca)
function mostrarMapa(latitud,longitud){


	map = new GMaps({
        el: '#map',
        lat: latitud,
        lng: longitud,
        width: '700px',
        height: '300px'
      });
      map.addMarker({
        lat: latitud,
        lng: longitud
      });
      
      $('#modal_mapa').openModal();
	
}
//---

//funcion para editar una sucursal
function editarSucursal(idSucursal,identificativoNit,nombre,telefono1,telefono2,celular,direccion,longitud,latitud,email,urlLogo,
						leyendaencabezado,estado,idPais,idCiudad,idBarrio,NombreCiudad,NombrePais,NombreBarrio){
	
	
	cancelarGuardadoSucursal();
	
	//se asignan los valores
	$("#editar_idSucursal").val(idSucursal);
	
	$("#editar_idPais").val(idPais);
	$("#editar_idCiudad").val(idCiudad);
	$("#editar_idBarrio").val(idBarrio);
	$("#editar_sucursal_nit").val(identificativoNit);
	$("#editar_sucursal_nombre").val(nombre);
	$("#editar_sucursal_leyendaEncabezado").val(leyendaencabezado);
	$("#editar_sucursal_telefono1").val(telefono1);
	$("#editar_sucursal_telefono2").val(telefono2);
	$("#editar_sucursal_celular").val(celular);
	$("#editar_sucursal_direccion").val(direccion);
	$("#editar_sucursal_latitud").val(latitud);
	$("#editar_sucursal_longitud").val(longitud);
	$("#editar_sucursal_email").val(email);
	$("#editar_pais").val(NombrePais);
	$("#editar_ciudad").val(NombreCiudad);
	$("#editar_barrio").val(NombreBarrio);
	
	//se cambia la imagen
	$("#editar_sucursal_logo").attr("src",urlLogo);
	
	if(estado == 'A'){
		$('#editar_sucursal_estado').prop('checked', true);	
	}else{
		$('#editar_sucursal_estado').prop('checked', false);
	}
	
	$("#label_editar_sucursal_nit").addClass( "active" );
	$("#label_editar_sucursal_nombre").addClass( "active" );
	$("#label_editar_sucursal_leyendaEncabezado").addClass( "active" );
	$("#label_editar_sucursal_telefono1").addClass( "active" );
	$("#label_editar_sucursal_telefono2").addClass( "active" );
	$("#label_editar_sucursal_celular").addClass( "active" );
	$("#label_editar_sucursal_latitud").addClass( "active" );
	$("#label_editar_sucursal_longitud").addClass( "active" );
	$("#label_editar_sucursal_direccion").addClass( "active" );
	$("#label_editar_sucursal_email").addClass( "active" );
	$("#label_editar_sucursal_pais").addClass( "active" );
	$("#label_editar_sucursal_ciudad").addClass( "active" );
	$("#label_editar_sucursal_barrio").addClass( "active" );
	
	
	$("#tituloLi").hide('slower');
	
	//se muestra el formulario
	$("#hidden_editar_Sucursal").show('slower');
	
}
//---


//funcion para cancelar la edicion de una sucursal
function cancelarEditarSucursal(){

	
	//se muestra el formulario
	$("#hidden_editar_Sucursal").hide('slower');

	$("#tituloLi").show('slower');
	

	
	$("#editar_idSucursal").val("");
	
	$("#idPais").val("0");
	$("#idCiudad").val("0");
	$("#idBarrio").val("0");
	$("#editar_sucursal_nit").val("");
	$("#editar_sucursal_nombre").val("");
	$("#editar_sucursal_leyendaEncabezado").val("");
	$("#editar_sucursal_telefono1").val("");
	$("#editar_sucursal_telefono2").val("");
	$("#editar_sucursal_celular").val("");
	$("#editar_sucursal_direccion").val("");
	$("#editar_sucursal_latitud").val("");
	$("#editar_sucursal_longitud").val("");
	$("#editar_sucursal_email").val("");
	$("#editar_pais").val("");
	$("#editar_ciudad").val("");
	$("#editar_barrio").val("");
	$("#editar_path_sucursal_logo").val("");
	
		//se formatea el input file
	var foto = $("#editar_sucursal_logo");
	foto.replaceWith( foto = foto.clone( true ) );
	
	
		//se remueve las clases activas
	$("#label_editar_sucursal_nit").removeClass("active");
	$("#label_editar_sucursal_nombre").removeClass("active");
	$("#label_editar_sucursal_leyendaEncabezado").removeClass("active");
	$("#label_editar_sucursal_telefono1").removeClass("active");
	$("#label_editar_sucursal_telefono2").removeClass("active");
	$("#label_editar_sucursal_celular").removeClass("active");
	$("#label_editar_sucursal_latitud").removeClass("active");
	$("#label_editar_sucursal_longitud").removeClass("active");
	$("#label_editar_sucursal_direccion").removeClass("active");
	$("#label_editar_sucursal_email").removeClass("active");
	$("#label_editar_sucursal_pais").removeClass("active");
	$("#label_editar_sucursal_ciudad").removeClass("active");
	$("#label_editar_sucursal_barrio").removeClass("active");
	
	
	$("#editar_sucursal_nit").removeClass("valid");
	$("#editar_sucursal_nombre").removeClass("valid");
	$("#editar_sucursal_leyendaEncabezado").removeClass("valid");
	$("#editar_sucursal_telefono1").removeClass("valid");
	$("#editar_sucursal_telefono2").removeClass("valid");
	$("#editar_sucursal_celular").removeClass("valid");
	$("#editar_sucursal_latitud").removeClass("valid");
	$("#editar_sucursal_longitud").removeClass("valid");
	$("#editar_sucursal_direccion").removeClass("valid");
	$("#editar_sucursal_email").removeClass("valid");
	$("#editar_sucursal_pais").removeClass("valid");
	$("#editar_sucursal_ciudad").removeClass("valid");
	$("#editar_sucursal_barrio").removeClass("valid");
	$("#editar_path_sucursal_logo").removeClass("valid");
	
	$("#editar_path_sucursal_logo").removeClass("invalid");
	$("#editar_sucursal_nit").removeClass("invalid");
	$("#editar_sucursal_nombre").removeClass("invalid");
	$("#editar_sucursal_leyendaEncabezado").removeClass("invalid");
	$("#editar_sucursal_telefono1").removeClass("invalid");
	$("#editar_sucursal_telefono2").removeClass("invalid");
	$("#editar_sucursal_celular").removeClass("invalid");
	$("#editar_sucursal_latitud").removeClass("invalid");
	$("#editar_sucursal_longitud").removeClass("invalid");
	$("#editar_sucursal_direccion").removeClass("invalid");
	$("#editar_sucursal_email").removeClass("invalid");
	$("#editar_sucursal_pais").removeClass("invalid");
	$("#editar_sucursal_ciudad").removeClass("invalid");
	$("#editar_sucursal_barrio").removeClass("invalid");
	
	
}
//---



//funcion para validar la edicion de una sucursal
function validarEditarSucursal(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#editar_idSucursal").val() == "" ){
		sw = 1;
	}
	
	if( $("#editar_sucursal_nombre").val().trim().length == 0 ){
		
		$("#label_editar_sucursal_nombre").addClass( "active" );
		$("#editar_sucursal_nombre").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#editar_sucursal_telefono1").val().trim().length == 0 ){
		
		$("#label_editar_sucursal_telefono1").addClass( "active" );
		$("#editar_sucursal_telefono1").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#editar_sucursal_celular").val().trim().length == 0 ){
		
		$("#label_editar_sucursal_celular").addClass( "active" );
		$("#editar_sucursal_celular").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#editar_sucursal_direccion").val().trim().length == 0 ){
		
		$("#label_editar_sucursal_direccion").addClass( "active" );
		$("#editar_sucursal_direccion").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#editar_idPais").val() == '0' ){
		
		$("#label_editar_sucursal_pais").addClass( "active" );
		$("#editar_idPais").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#editar_idCiudad").val() == '0' ){
		
		$("#label_editar_sucursal_ciudad").addClass( "active" );
		$("#editar_idCiudad").addClass( "invalid" );
		sw = 1;
	}	
	

	if( $("#editar_idBarrio").val() == '0'){
		
		$("#label_editar_sucursal_barrio").addClass( "active" );
		$("#editar_idBarrio").addClass( "invalid" );
		sw = 1;
	}	
	

	if(sw == 1){
		return false;
	}else{
		$("#form_editarSucursal").submit();
	}

	
}
//---


//funcion para mostrar los vinculos de la sucursal con los usuarios
function vincularUsuariosSucursal(){
	
	
	$.ajax({
  		url: "../Controllers/sucursales/consultarUsuariosSucursal.php",
        dataType: "html",
        type : 'POST',
        data: { idSucursal : $("#editar_idSucursal").val(), nombre : $("#editar_sucursal_nombre").val() },
        success: function(data) {			

			$('#contenerdorModalVincular').html(data);
			
			
        }//fin success
  	});

	
}
//---


//funcion para activar el vinculo entre una sucursal y un usuario
function activarVinculo(idVinculo){
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivarVInculo").html();
	$.ajax({
  		url: "../Controllers/sucursales/activarVinculoSucursal.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanV_'+idVinculo).html('<a id="'+idVinculo+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarVinculo(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
	
}
//----


//funcion para desactivar el vinculo entre una sucursal y un usuario
function desactivarVinculo(idVinculo){
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivarVinculo").html();
	$.ajax({
  		url: "../Controllers/sucursales/desactivarVinculoSucursal.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanV_'+idVinculo).html('<span id="spanV_'+idVinculo+'"> <a id="'+idVinculo+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarVinculo(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
	
}
//----

//funcion para vincular un usuario con una sucursal, desde el modal
function vincularUsuarioSucursalModal(){
	
	if($("#UsuariosVincularSucursalModal").val() == ""){
		return false;
	}
	
	$.ajax({
  		url: "../Controllers/sucursales/vincularUsuarioSucursal.php",
  		async:false,
        dataType: "html",
        type : 'POST',
        data: { idSucursal : $("#editar_idSucursal").val(), idUsuario : $("#UsuariosVincularSucursalModal").val() },
        success: function(data) {			

			
			vincularUsuariosSucursal();
			
        }//fin success
  	});		
	
	
}
//---


/**
 * Espacios para hospitalizacion
 * */

//metodo para consultar los espacios de hospitalizaicon que tiene una sucursal
function mostrarEspaciosHospitalizacion(idSucursal, nombre){
	
	$("#nombreSucursalEspaciosH").html(nombre);
	$("#idSucursalEspacioH").val(idSucursal);
	
	$("#div_crearNuevoEspacioHospitalizacion").show();
	$("#div_editarEspacioHospitalizacion").hide();
	
	//se limpia el formulario
	$("#nombre_espacioH").val("");
	$("#capacidad_espacioH").val("");
	$("#observacion_espacioH").val("");
	
	$("#nombre_espacioH").removeClass("valid");
	$("#capacidad_espacioH").removeClass("valid");
	$("#observacion_espacioH").removeClass("valid");
	
	$("#nombre_espacioH").removeClass("invalid");
	$("#capacidad_espacioH").removeClass("invalid");
	$("#observacion_espacioH").removeClass("invalid");
	
	$("#label_nombre_espacioH").removeClass("active");
	$("#label_capacidad_espacioH").removeClass("active");
	$("#label_observacion_espacioH").removeClass("active");
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/sucursales/consultarEspaciosHospitalizacion.php",
  		async:false,
        dataType: "html",
        type : 'POST',
        data: { idSucursal : idSucursal },
        success: function(data) {			

			$("#resultadoEspaciosHospitalizacion").html(data);
			$('.tooltipped').tooltip('remove');
			$('.tooltipped').tooltip({delay: 50});						
        }//fin success
  	});		
	
}
//---


//metodo para limpiar el formulario de un nunevo espacio de hospitalizacion para una sucursal
function limpiarEspacioHospitalizacion(){

	$("#nombre_espacioH").val("");
	$("#capacidad_espacioH").val("");
	$("#observacion_espacioH").val("");
	
	$("#nombre_espacioH").removeClass("valid");
	$("#capacidad_espacioH").removeClass("valid");
	$("#observacion_espacioH").removeClass("valid");
	
	$("#nombre_espacioH").removeClass("invalid");
	$("#capacidad_espacioH").removeClass("invalid");
	$("#observacion_espacioH").removeClass("invalid");
	
	$("#label_nombre_espacioH").removeClass("active");
	$("#label_capacidad_espacioH").removeClass("active");
	$("#label_observacion_espacioH").removeClass("active");

	
}
//---


//funcion para validar el guardado de un nuevo espacio para hospitalizacion
function validarGuardadoNuevoEspacioHospitalizacion(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombre_espacioH").val().trim().length == 0 ){
		
		$("#label_nombre_espacioH").addClass( "active" );
		$("#nombre_espacioH").addClass( "invalid" );
		sw = 1;
	}		

	if( $("#capacidad_espacioH").val().trim().length == 0 ){
		
		$("#label_capacidad_espacioH").addClass( "active" );
		$("#capacidad_espacioH").addClass( "invalid" );
		sw = 1;
	}		
	
	if( $("#observacion_espacioH").val().trim().length == 0 ){
		
		$("#label_observacion_espacioH").addClass( "active" );
		$("#observacion_espacioH").addClass( "invalid" );
		sw = 1;
	}		

	if(sw == 1){
		return false;
	}else{


		$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/sucursales/guardarEspacioHospitalizacion.php",
	  		async:false,
	        dataType: "html",
	        type : 'POST',
	        data: { idSucursal : $("#idSucursalEspacioH").val(), nombre: $("#nombre_espacioH").val(), capacidad:  $("#capacidad_espacioH").val(), observacion:  $("#observacion_espacioH").val()  },
	        success: function() {			
	
				mostrarEspaciosHospitalizacion($("#idSucursalEspacioH").val(), $("#nombreSucursalEspaciosH").html())
							
	        }//fin success
	  	});	
		
		
	}
	
}
//---

//metodo par cargar la edicion de un espacio de hospitalizaicon 
function EditarEspacioH(id, nombre, capacidad, ocupados, observacion){
	
	limpiarEspacioHospitalizacion();
	$("#div_crearNuevoEspacioHospitalizacion").hide('slower');
	$("#div_editarEspacioHospitalizacion").show('slower');
	
	$("#idEspacioHospitalizacion").val(id);
	$("#editar_nombre_espacioH").val(nombre);
	$("#editar_capacidad_espacioH").val(capacidad);
	$("#editar_ocupado_espacioH").val(ocupados);
	$("#editar_observacion_espacioH").val(observacion);
	
	$("#editar_nombre_espacioH").removeClass("valid");
	$("#editar_capacidad_espacioH").removeClass("valid");
	$("#editar_ocupado_espacioH").removeClass("valid");
	$("#editar_observacion_espacioH").removeClass("valid");
	
	$("#editar_nombre_espacioH").removeClass("invalid");
	$("#editar_capacidad_espacioH").removeClass("invalid");
	$("#editar_ocupado_espacioH").removeClass("invalid");
	$("#editar_observacion_espacioH").removeClass("invalid");
	
	$("#label_editar_nombre_espacioH").addClass( "active" );
	$("#label_editar_capacidad_espacioH").addClass( "active" );
	$("#label_editar_ocupado_espacioH").addClass( "active" );
	$("#label_editar_observacion_espacioH").addClass( "active" );
	
}
//---


//funcion para cancelar la edicion de un espacio de hospitalizacion
function cancelarEdicionEspacioHospitalizacion(){
	
	$("#div_editarEspacioHospitalizacion").hide('slower');
	$("#div_crearNuevoEspacioHospitalizacion").show('slower');
	
	$("#editar_nombre_espacioH").val("");
	$("#editar_capacidad_espacioH").val("");
	$("#editar_ocupado_espacioH").val("");
	$("#editar_observacion_espacioH").val("");
	$("#idEspacioHospitalizacion").val("0");
	
	$("#editar_nombre_espacioH").removeClass("valid");
	$("#editar_capacidad_espacioH").removeClass("valid");
	$("#editar_ocupado_espacioH").removeClass("valid");
	$("#editar_observacion_espacioH").removeClass("valid");
	
	$("#editar_nombre_espacioH").removeClass("invalid");
	$("#editar_capacidad_espacioH").removeClass("invalid");
	$("#editar_ocupado_espacioH").removeClass("invalid");
	$("#editar_observacion_espacioH").removeClass("invalid");
	
	$("#label_editar_nombre_espacioH").removeClass( "active" );
	$("#label_editar_capacidad_espacioH").removeClass( "active" );
	$("#label_editar_ocupado_espacioH").removeClass( "active" );
	$("#label_editar_observacion_espacioH").removeClass( "active" );
		
	
}
//---

//metodo para validar la edicion de un espacio de hospitalizacion
function validarEdicionEspacioHospitalizacion(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#editar_nombre_espacioH").val().trim().length == 0 ){
		
		$("#label_editar_nombre_espacioH").addClass( "active" );
		$("#nombre_espacioH").addClass( "invalid" );
		sw = 1;
	}		

	if( $("#editar_capacidad_espacioH").val().trim().length == 0 ){
		
		$("#label_editar_capacidad_espacioH").addClass( "active" );
		$("#editar_capacidad_espacioH").addClass( "invalid" );
		sw = 1;
	}		

	if( $("#editar_ocupado_espacioH").val().trim().length == 0 ){
		
		$("#label_editar_ocupado_espacioH").addClass( "active" );
		$("#editar_ocupado_espacioH").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#editar_observacion_espacioH").val().trim().length == 0 ){
		
		$("#label_editar_observacion_espacioH").addClass( "active" );
		$("#editar_observacion_espacioH").addClass( "invalid" );
		sw = 1;
	}		

	if(sw == 1){
		return false;
	}else{


		$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/sucursales/editarEspacioHospitalizacion.php",
	  		async:false,
	        dataType: "html",
	        type : 'POST',
	        data: { idEspacio : 	$("#idEspacioHospitalizacion").val(), 
	        		nombre: 		$("#editar_nombre_espacioH").val(), 
	        		capacidad:  	$("#editar_capacidad_espacioH").val(),
	        		ocupado:  		$("#editar_ocupado_espacioH").val(), 
	        		observacion:  	$("#editar_observacion_espacioH").val()  },
	        success: function() {			
	
				mostrarEspaciosHospitalizacion($("#idSucursalEspacioH").val(), $("#nombreSucursalEspaciosH").html())
							
	        }//fin success
	  	});	
		
		
	}

	
}
//---


//funcion para desactivar un espacio de hospitalizacion 
function desactivarEspacioH(idEspacio){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/sucursales/desactivarEspacioH.php",
        dataType: "html",
        type : 'POST',
        data: { idEspacio : idEspacio },
        success: function(data) {			

			$('#spanEH_'+idEspacio).html('<a id="'+idEspacio+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarEspacioH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		

	
}
//---


//funcion para activar un espacio de hospitalizacion
function activarEspacioH(idEspacio){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/sucursales/activarEspacioH.php",
        dataType: "html",
        type : 'POST',
        data: { idEspacio : idEspacio },
        success: function(data) {			

			$('#spanEH_'+idEspacio).html('<a id="'+idEspacio+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarEspacioH(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---



/**
 * Fin Espacios para hospitalizacion
 * */



