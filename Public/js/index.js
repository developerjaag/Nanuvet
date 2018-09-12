	$(document).ready(function () {
			

			$('#fullpage').fullpage({
				//sectionsColor: ['#fafafa', '#fafafa', '#fafafa', '#fafafa', '#fafafa', '#fafafa', '#fafafa', '#fafafa'],
				anchors: ['inicio', 'nosotros', 'tumascota', 'modulos', 'precios', 'contacto', 'login'],
				menu: '#menu',
				afterLoad: function(anchorLink, index){
					
					$("li").removeClass("active");
					
					if(anchorLink == "nosotros"){
						$("#menu_nosotros").addClass("active");
					}//fin if
					
					if(anchorLink == "tumascota"){
						$("#menu_tumascota").addClass("active");
					}//fin if
					
					if(anchorLink == "modulos"){
						$("#menu_modulos").addClass("active");
					}//fin if
					
					if(anchorLink == "precios"){
						$("#menu_precios").addClass("active");
						

						
					}//fin if
					
					if(anchorLink == "contacto"){
						$("#menu_contacto").addClass("active");
					}//fin if
					
					if(anchorLink == "login"){
						$("#menu_login").addClass("active");
					}//fin if
					

					
				},//fin afterload
				
				/*scrollOverflow: true,
				autoScrolling: false,
				fitToSection: true,
				scrollBar: true,
				animateAnchor: true,
				controlArrows: true*/
				
			});
			
			$('video').get(0).play();
			
			
			//animacion para el titulo
			$('#titulo').textillate({
			
				selector: '.texts',
				loop: true,
				autoStart: true,
				type: 'char'
			
				
			});
			

			
		});
		
		
		
/*
     * Funciones javascript para el login
*/

//funcion para validar el formulario login
function validarLogin(){
    
    var sw = 0; // variable para determinar si existen campos sin diligenciar
    
    if( $("#login_identificacionTitular").val().trim().length == 0 ){
		
		$("#label_login_identificacionTitular").addClass( "active" );
		$("#login_identificacionTitular").addClass( "invalid" );
		sw = 1;
	}
	
    if( $("#login_identificacion").val().trim().length == 0 ){
		
		$("#label_login_identificacion").addClass( "active" );
		$("#login_identificacion").addClass( "invalid" );
		sw = 1;
	}
	
    if( $("#login_pass").val().trim().length == 0 ){
		
		$("#label_login_pass").addClass( "active" );
		$("#login_pass").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_login").submit();
	}

	
}
//---


//funcion para validar la recuperacion de los datos
function validarRecuperarDatos(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#recuperar_identificacionTitular").val().trim().length == 0 ){
		
		$("#label_recuperar_identificacionTitular").addClass( "active" );
		$("#recuperar_identificacionTitular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#recuperar_identificacion").val().trim().length == 0 ){
		
		$("#lebel_recuperar_identificacion").addClass( "active" );
		$("#recuperar_identificacion").addClass( "invalid" );
		sw = 1;
	}


	if( $("#recuperar_email").val().trim().length == 0 ){
		
		$("#lebel_recuperar_email").addClass( "active" );
		$("#recuperar_email").addClass( "invalid" );
		sw = 1;
		
	}else if($("#recuperar_email").val().indexOf('@', 0) == -1 || $("#recuperar_email").val().indexOf('.', 0) == -1) {
            $("#lebel_recuperar_email").addClass( "active" );
			$("#recuperar_email").addClass( "invalid" );
			sw = 1;
        }

	

	if(sw == 1){
		return false;
	}else{

		$("#preloaderRestablecer").show("slower");

		$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/index/recuperarDatos.php",
	        dataType: "html",
	        cache: false,
	        type : 'POST',
	        data: {
	        	
	        	titular : $("#recuperar_identificacionTitular").val(),
	        	identificacion	: $("#recuperar_identificacion").val(),
	        	email	: $("#recuperar_email").val(),
	        	idioma	: $('html').attr('lang')
	        	
	        },
	        success: function(data) {
	        	
	        	if (data == "ok"){
	        		
	        		$("#preloaderRestablecer").hide("slower");
	        		$("#errorEnviandoRecuperacion").hide("slower");
	        		$("#errorEmailNoCoincide").hide("slower");
	        		$("#okEnviandoRecuperacion").show("slower");
	        		
	        	}else if(data == "email no coincide"){
	        		
	        		$("#preloaderRestablecer").hide("slower");
	        		$("#okEnviandoRecuperacion").hide("slower");
	        		$("#errorEnviandoRecuperacion").hide("slower");
	        		$("#errorEmailNoCoincide").show("slower");
	        		
	        	}else{
	        		$("#preloaderRestablecer").hide("slower");
	        		$("#okEnviandoRecuperacion").hide("slower");
	        		$("#errorEmailNoCoincide").hide("slower");
	        		$("#errorEnviandoRecuperacion").show("slower");
	        	}
	        	
	        }
	  	});
		
	}//fin else	
	
}
//---

//funcion para detectar la tecla enter en los campos
function searchKeyPress(e){
        // look for window.event in case event isn't passed in
        if (typeof e == 'undefined' && window.event) { e = window.event; }
        if (e.keyCode == 13){
            document.getElementById('btn_validarLogin').click();
        }
}
//---		

/*Demo*/

//funcion para continuar iniciar creacion demo
function crearDemo(){
	


	
	$.ajax({
  		url: "../Controllers/index/nuevoDemo.php",
        dataType: "html",
        cache: false,
        type : 'POST',
        data: {},
        success: function(data) {
             $("#section5").html(data);
             $('.modal-trigger').leanModal();
        }
  	});
	
	
}//fin funcion continuarCompra

//funcion para validar los datos ingresados en el formulario del titular
function validarDatosCuentaDemo(){
	

	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#identificacion_titular").val().trim().length < 4 ){
		
		$("#label_identificacion_titular").addClass( "active" );
		$("#identificacion_titular").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#nombre_titular").val().trim().length < 2 ){
		
		$("#label_nombre_titular").addClass( "active" );
		$("#nombre_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#personaContacto_titular").val().trim().length == 0 ){
		
		$("#label_personaContacto_titular").addClass( "active" );
		$("#personaContacto_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#direccion_titular").val().trim().length == 0 ){
		
		$("#label_direccion_titular").addClass( "active" );
		$("#direccion_titular").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#telefono1_titular").val().trim().length == 0 ){
		
		$("#label_telefono1_titular").addClass( "active" );
		$("#telefono1_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#celular_titular").val().trim().length == 0 ){
		
		$("#label_celular_titular").addClass( "active" );
		$("#celular_titular").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#email_titular").val().trim().length == 0 ){
		
		$("#label_email_titular").addClass( "active" );
		$("#email_titular").addClass( "invalid" );
		sw = 1;
		
	}else if($("#email_titular").val().indexOf('@', 0) == -1 || $("#email_titular").val().indexOf('.', 0) == -1) {
            $("#label_email_titular").addClass( "active" );
			$("#email_titular").addClass( "invalid" );
			sw = 1;
        }


	if( $("#pais_titular").val().trim().length == 0 ){
		
		$("#label_pais_titular").addClass( "active" );
		$("#pais_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#ciudad_titular").val().trim().length == 0 ){
		
		$("#label_ciudad_titular").addClass( "active" );
		$("#ciudad_titular").addClass( "invalid" );
		sw = 1;
	}
	
	if( $('#terminosCondiciones').prop('checked') ){
		$("#errorTerminosCondiciones").hide("slower");
		
	}else{
		$("#errorTerminosCondiciones").show("slower");
		sw = 1;
	}

	if(sw == 1){
		return false;
	}else{
		
		//pedir confirmacion de email
		swal({
		  title: 'Verifica tu E-mail',
		  text: "Es muy importante!. a este E-mail se enviarán tus datos de acceso al sistema: "+$("#email_titular").val()+" ",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: 'Si, el E-mail está bien escrito',
		  cancelButtonText: 'Cancelar',
		},function(){
			

			$.ajax({
		  		url: "../Controllers/index/registrarTitularCuentaDemo.php",
		  		async:false, 
                cache:false,
		        dataType: "json",
		        type : 'POST',
		        data: {
        	    	identificacion_titular 	: $("#identificacion_titular").val(),
        	    	nombre_titular 			: $("#nombre_titular").val(),
        	    	personaContacto_titular : $("#personaContacto_titular").val(),
        	    	direccion_titular 		: $("#direccion_titular").val(),
        	    	telefono1_titular 		: $("#telefono1_titular").val(),
        	    	telefono2_titular 		: $("#telefono2_titular").val(),
        	    	celular_titular 		: $("#celular_titular").val(),
        	    	email_titular 			: $("#email_titular").val(),
        	    	pais_titular 			: $("#pais_titular").val(),
        	    	ciudad_titular 			: $("#ciudad_titular").val(),
        	    	idioma					: $('html').attr('lang')
        	    	
        		},
		        success: function(data) {
		        	if (data.mensaje == 'Error') {
		        		
		        		sweetAlert("Ups...", "Algo salio mal!", "error");
						return false;
		        		
		        	}else if (data.mensaje == 'Ok'){
		        		
		        		registrarClienteNVDemo();
		        		
		        	}//fin else
		        			             
		        }
		  	});				
			
			
			
			
		});
		

  	
			
	}//fin else		
	
}//fin funcion validarDatosCompraDemo


//fuincion para guardar el cliente NV Demo
function registrarClienteNVDemo(){
	

			$.ajax({
		  		url: "../Controllers/index/registrarClienteNVDemo.php",
		  		async:false, 
                cache:false,
		        dataType: "html",
		        type : 'POST',
		        data: {
        	    	identificacion_titular 	: $("#identificacion_titular").val(),
        	    	nombre_titular 			: $("#nombre_titular").val(),
        	    	personaContacto_titular : $("#personaContacto_titular").val(),
        	    	direccion_titular 		: $("#direccion_titular").val(),
        	    	telefono1_titular 		: $("#telefono1_titular").val(),
        	    	telefono2_titular 		: $("#telefono2_titular").val(),
        	    	celular_titular 		: $("#celular_titular").val(),
        	    	email_titular 			: $("#email_titular").val(),
        	    	pais_titular 			: $("#pais_titular").val(),
        	    	ciudad_titular 			: $("#ciudad_titular").val(),
        	    	idioma					: $('html').attr('lang')
        	    	
        		},
		        success: function(data) {
		        		Materialize.toast('Cuenta demo creada correctamente!', 4000);
						avisarCreacionDemo();
						 
				 	}
		  		});	
}
//---


//funcion para mostrar de que se creo la cuenta demo
function avisarCreacionDemo(){

	$.ajax({
  		url: "../Controllers/index/avisarCreacionDemo.php",
        dataType: "html",
        cache: false,
        type : 'POST',
        success: function(data) {
             $("#section5").html(data);
        }
  	});	
	
	
}//fin funcion avisarCreacionDemo

/*Fin demo*/










/*Comprar*/

//funcion para continuar con la compra
function continuarCompra(){
	
	if( $("#select_precio").val() == 0 ){
		
		sweetAlert("Ups...", "Elección incorrecta!", "error");
		return false;
		
	}//fin if	
	
	
	$.ajax({
  		url: "../Controllers/index/nuevaCuenta.php",
        dataType: "html",
        cache: false,
        type : 'POST',
        data: {
        	    idPrecio : $("#select_precio").val()
        	},
        success: function(data) {
             $("#section5").html(data);
             $('.modal-trigger').leanModal();
             $('select').material_select();
        }
  	});
	
	
}//fin funcion continuarCompra


//funcion para cancelar una compra
function cancelarCompra(){

	$.ajax({
  		url: "../Controllers/index/cancelarCompra.php",
        dataType: "html",
        cache: false,
        type : 'POST',
        success: function(data) {
             $("#section5").html(data);
        }
  	});	
	
	
}//fin funcion cancelarCompra


//funcion para validar los datos ingresados en el formulario del titular
function validarDatosCompra(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#identificacion_titular").val().trim().length < 4 ){
		
		$("#label_identificacion_titular").addClass( "active" );
		$("#identificacion_titular").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#nombre_titular").val().trim().length < 2 ){
		
		$("#label_nombre_titular").addClass( "active" );
		$("#nombre_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#personaContacto_titular").val().trim().length == 0 ){
		
		$("#label_personaContacto_titular").addClass( "active" );
		$("#personaContacto_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#direccion_titular").val().trim().length == 0 ){
		
		$("#label_direccion_titular").addClass( "active" );
		$("#direccion_titular").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#telefono1_titular").val().trim().length == 0 ){
		
		$("#label_telefono1_titular").addClass( "active" );
		$("#telefono1_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#celular_titular").val().trim().length == 0 ){
		
		$("#label_celular_titular").addClass( "active" );
		$("#celular_titular").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#email_titular").val().trim().length == 0 ){
		
		$("#label_email_titular").addClass( "active" );
		$("#email_titular").addClass( "invalid" );
		sw = 1;
		
	}else if($("#email_titular").val().indexOf('@', 0) == -1 || $("#email_titular").val().indexOf('.', 0) == -1) {
            $("#label_email_titular").addClass( "active" );
			$("#email_titular").addClass( "invalid" );
			sw = 1;
        }


	if( $("#pais_titular").val().trim().length == 0 ){
		
		$("#label_pais_titular").addClass( "active" );
		$("#pais_titular").addClass( "invalid" );
		sw = 1;
	}


	if( $("#ciudad_titular").val().trim().length == 0 ){
		
		$("#label_ciudad_titular").addClass( "active" );
		$("#ciudad_titular").addClass( "invalid" );
		sw = 1;
	}
	
	if( $('#terminosCondiciones').prop('checked') ){
		$("#errorTerminosCondiciones").hide("slower");
		
	}else{
		$("#errorTerminosCondiciones").show("slower");
		
	}


	if( $("#vendedor").val() == "" || $("#vendedor").val() == null){
		
		$("#div_selectVendedor").addClass("red lighten-3");
		sw = 1;
	}else{
		$("#div_selectVendedor").removeClass("red lighten-3");		
	}


	if(sw == 1){
		return false;
	}else{
		
		//pedir confirmacion de email
		swal({
		  title: 'Verifica tu E-mail',
		  text: "Es muy importante!. a este E-mail se enviarán tus datos de acceso al sistema: "+$("#email_titular").val()+" ",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#2BBBAD',
		  cancelButtonColor: '#E53935',
		  confirmButtonText: 'Si, el E-mail está bien escrito',
		  cancelButtonText: 'Cancelar',
		},function(){
			

			$.ajax({
		  		url: "../Controllers/index/registrarTitularCuenta.php",
		        dataType: "json",
		        type : 'POST',
		        data: {
        	    	identificacion_titular 	: $("#identificacion_titular").val(),
        	    	nombre_titular 			: $("#nombre_titular").val(),
        	    	personaContacto_titular : $("#personaContacto_titular").val(),
        	    	direccion_titular 		: $("#direccion_titular").val(),
        	    	telefono1_titular 		: $("#telefono1_titular").val(),
        	    	telefono2_titular 		: $("#telefono2_titular").val(),
        	    	celular_titular 		: $("#celular_titular").val(),
        	    	email_titular 			: $("#email_titular").val(),
        	    	pais_titular 			: $("#pais_titular").val(),
        	    	ciudad_titular 			: $("#ciudad_titular").val(),
        	    	plan					: $("#plan").val(),
        	    	idioma					: $('html').attr('lang'),
        	    	vendedor				: $("#vendedor").val()
        	    	
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
		        		$("#buyerEmail").val($("#email_titular").val());
		        		$("#responseUrl").val("http://www.nanuvet.com/Controllers/index/pagos_respuesta.php");
		        		$("#confirmationUrl").val("http://www.nanuvet.com/Controllers/index/pagos_confirmacion.php");
		        		$("#mobilePhone").val($("#celular_titular").val());
		        		$("#billingAddress").val($("#direccion_titular").val());
		        		$("#telephone").val($("#telefono1_titular").val());
		        		$("#algorithmSignature").val('SHA');
		        		$("#payerEmail").val($("#email_titular").val());
		        		$("#payerPhone").val($("#telefono1_titular").val());
		        		$("#payerMobilePhone").val($("#celular_titular").val());        		
		        		
		        		
		        		$("#form_envioPasarela").submit();
		        		
		        	};
		        			             
		        }
		  	});				
			
			
			
			
		});
		

  	
			
	}//fin else		
	
}//fin funcion validarDatosCompra


//funcion para operar el ajax que envia los datos para la compra
function operarCompra(){
	
	$.ajax({
		  		url: "../Controllers/index/registrarTitularCuenta.php",
		        dataType: "json",
		        async: false, 
		        cache: false,
		        type : 'POST',
		        data: {
        	    	identificacion_titular 	: $("#identificacion_titular").val(),
        	    	nombre_titular 			: $("#nombre_titular").val(),
        	    	personaContacto_titular : $("#personaContacto_titular").val(),
        	    	direccion_titular 		: $("#direccion_titular").val(),
        	    	telefono1_titular 		: $("#telefono1_titular").val(),
        	    	telefono2_titular 		: $("#telefono2_titular").val(),
        	    	celular_titular 		: $("#celular_titular").val(),
        	    	email_titular 			: $("#email_titular").val(),
        	    	pais_titular 			: $("#pais_titular").val(),
        	    	ciudad_titular 			: $("#ciudad_titular").val(),
        	    	plan					: $("#plan").val(),
        	    	idioma					: $('html').attr('lang')
        	    	
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
		        		$("#buyerEmail").val($("#email_titular").val());
		        		$("#responseUrl").val("http://www.nanuvet.com/Controllers/index/pagos_respuesta.php");
		        		$("#confirmationUrl").val("http://www.nanuvet.com/Controllers/index/pagos_confirmacion.php");
		        		$("#mobilePhone").val($("#celular_titular").val());
		        		$("#billingAddress").val($("#direccion_titular").val());
		        		$("#telephone").val($("#telefono1_titular").val());
		        		$("#algorithmSignature").val('SHA');
		        		$("#payerEmail").val($("#email_titular").val());
		        		$("#payerPhone").val($("#telefono1_titular").val());
		        		$("#payerMobilePhone").val($("#celular_titular").val());        		
		        		
		        		
		        		$("#form_envioPasarela").submit();
		        		
		        	};
		        			             
		        }
		  	});	
	
	
}//fin funcion operarCompra


///funcion para  buscar un propietario en la replica
function buscarPropietarioDesdeReplica(){

	 $('#buscarPropietarioReplica').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/replica/buscarPropietario.php",
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
        	
        	window.location.href = "http://www.nanuvet.com/replica/"+ui.item.id+"/";
        		
        			   			
        }
    	
  	}); 
	
}
//---

//funcion aplicar busqueda desde el boton buscar
function aplicarBusqueda(){
	
	if( $("#idPropietarioReplica").val() != "0" ){
		
		window.location.href = "http://www.nanuvet.com/replica/"+ui.item.id+"/";		
		
	}else{
		
		$("#buscarPropietarioReplica").addClass("invalid");
		$("#label_buscarPropietarioReplica").addClass("active")
		
	}
	
}
//---




///funcion para  buscar un propietario en la replica cuando se esta creando un propietario, para evitar que se dupliquen
function buscarPropietarioDesdeReplicaCreando(){

	 $('#propietario_identificacion').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/replica/buscarPropietario.php",
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
        minLength: 4,
        select: function(event, ui){
        	
        	window.location.href = "http://www.nanuvet.com/replica/"+ui.item.id+"/";
        		
        			   			
        }
    	
  	}); 
	
}
//---


//buscar pais al escribir
function buscarPaisReplica(){
   

    $('#pais').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/replica/buscarPais.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBuscarPais : request.term//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idPais").val(ui.item.id); 	
        			   			
        }
    	
  	}); 
   
   
    
}
//---




//funcion para validar el guardado de un nuevo propietario
function ValidarDatosNuevoPropietarioReplica(){

var sw = 0; // variable para determinar si existen campos sin diligenciar

	
	if( $("#propietario_identificacion").val().trim().length == 0 ){
		
		$("#label_propietario_identificacion").addClass( "active" );
		$("#propietario_identificacion").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#propietario_nombre").val().trim().length == 0 ){
		
		$("#label_propietario_nombre").addClass( "active" );
		$("#propietario_nombre").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_apellido").val().trim().length == 0 ){
		
		$("#label_propietario_apellido").addClass( "active" );
		$("#propietario_apellido").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_telefono").val().trim().length == 0 ){
		
		$("#label_propietario_telefono").addClass( "active" );
		$("#propietario_telefono").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_celular").val().trim().length == 0 ){
		
		$("#label_propietario_celular").addClass( "active" );
		$("#propietario_celular").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_direccion").val().trim().length == 0 ){
		
		$("#label_propietario_direccion").addClass( "active" );
		$("#propietario_direccion").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#propietario_email").val().trim().length == 0 ){
		
		$("#label_propietario_email").addClass( "active" );
		$("#propietario_email").addClass( "invalid" );
		sw = 1;
	}else if($("#propietario_email").val().indexOf('@', 0) == -1 || $("#propietario_email").val().indexOf('.', 0) == -1) {
            $("#label_propietario_email").addClass( "active" );
			$("#propietario_email").addClass( "invalid" );
			sw = 1;
        }	
	
	if( $("#idPais").val() == '0' ){
		
		$("#label_propietario_pais").addClass( "active" );
		$("#pais").addClass( "invalid" );
		sw = 1;
	}	
	

	
	if(sw == 1){
		return false;
	}else{
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/replica/guardarNuevoPropietario.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    
            	    identificacion 	: $("#propietario_identificacion").val(),
            	    nombre			: $("#propietario_nombre").val(),
            	    apellido		: $("#propietario_apellido").val(),
            	    telefono		: $("#propietario_telefono").val(),
            	    celular			: $("#propietario_celular").val(),
            	    direccion		: $("#propietario_direccion").val(),
            	    email			: $("#propietario_email").val(),
            	    idPais			: $("#idPais").val()
            	    
            	    
            	},
            success: function(data) {
                 
                 window.location.href = "http://www.nanuvet.com/replica/"+data+"/";               
                 
            }
      	});
	}

	
}
//---



//funcion para validar el envio del mensaje de contacto
function enviarMensajeContactanos(){
	
	var sw = 0;
	
	if( $("#contactoNombre").val().trim().length == 0 ){
		
		$("#label_contactoNombre").addClass( "active" );
		$("#contactoNombre").addClass( "invalid" );
		sw = 1;
	}		


	if( $("#contactoEmail").val().trim().length == 0 ){
		
		$("#label_contactoEmail").addClass( "active" );
		$("#contactoEmail").addClass( "invalid" );
		sw = 1;
		
	}else if($("#contactoEmail").val().indexOf('@', 0) == -1 || $("#contactoEmail").val().indexOf('.', 0) == -1) {
            $("#label_contactoEmail").addClass( "active" );
			$("#contactoEmail").addClass( "invalid" );
			sw = 1;
        }	
	

	if( $("#contactoTexto").val().trim().length == 0 ){
		
		$("#label_contactoTexto").addClass( "active" );
		$("#contactoTexto").addClass( "invalid" );
		sw = 1;
	}	
	
	if(sw == 1){
		return false;
	}else{
		
		$.ajax({
      		url: "http://www.nanuvet.com/Controllers/index/guardarNuevoMensajeContactenos.php",
            dataType: "html",
            type : 'POST',
            data: {
            	    
            	    nombre			: $("#contactoNombre").val(),
            	    email			: $("#contactoEmail").val(),
            	    texto 			: $("#contactoTexto").val()
            	    
            	    
            	},
            success: function() {
                 
                 	$("#contactoNombre").val("");
                 	$("#contactoEmail").val("");
                 	$("#contactoTexto").val("");
                 
                 	$("#contactoNombre").removeClass("valid");
                 	$("#contactoEmail").removeClass("valid");
                 	$("#contactoTexto").removeClass("valid");
                 	
                 	$("#contactoNombre").removeClass("invalid");
                 	$("#contactoEmail").removeClass("invalid");
                 	$("#contactoTexto").removeClass("invalid");
                 	
                 	$("#label_contactoNombre").removeClass("active");
                 	$("#label_contactoEmail").removeClass("active");
                 	$("#label_contactoTexto").removeClass("active");
                 	
                 	$("#mensajeEnvioMensaje").show("slower");
                 
                   Materialize.toast('Mensaje enviado!', 4000);             
                 
            }
      	});
		
		
	}
	
}//fin metodo enviarMensajeContactanos

