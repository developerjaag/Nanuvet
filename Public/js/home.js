/*
    *   funciones para el home
*/

$(document).ready(function() {

	$('.fecha').datetimepicker({
	  timepicker:false,
	  formatDate:'Y/m/d',
	  format: 'Y/m/d',
	  
	  minDate:0
	  
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

//funcion para validar el guardado de la primera sucursal
function validarGuardadoPrimeraSucursal(){

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
		$("#form_primeraSucursal").submit();
	}
    
}
//---


//para enviar el cambio de sucursal
function enviarCambioSucursal(){
	
	$("#form_cambiarSucursal").submit();
	
}
//---


//funcion para el intro del home
function startIntroHome(btn1,btn2,btn3,btn4,t1,t2,t3,t4,t7,t8,t9,t10,t11,t12,t13,t15,t16){
	
	//se adicionan los data a los elementos del menu
	
	var intro = introJs();
	
	intro.setOptions({
            steps: [
            
              { 
                intro: t1
              },
              {
                intro: t2
              },
              {
              	element: document.querySelector('#chipRecordatorios'),
                intro: t3,
                position: 'right'
              },
              {
              	element: document.querySelector('#chipCitas'),
                intro: t4,
                position: 'right'
              },
              {
              	element: document.querySelector('#menuWebUsuario'),
                intro: t7,
                position: 'left'
              },
              {
              	element: document.querySelector('#menuWebConfiguracion'),
                intro: t8,
                position: 'left'
              },
              {
              	element: document.querySelector('#menuWebListados'),
                intro: t9,
                position: 'bottom'
              },
              {
              	element: document.querySelector('#menuWebReportes'),
                intro: t10,
                position: 'bottom'
              },
              {
              	element: document.querySelector('#menuWebFacturacion'),
                intro: t11,
                position: 'bottom'
              },
              {
              	element: document.querySelector('#menuWebinventario'),
                intro: t12,
                position: 'bottom'
              },
              {
              	element: document.querySelector('#menuWebAgenda'),
                intro: t13,
                position: 'bottom'
              },
              {
              	element: document.querySelector('#menuWebNuevo'),
                intro: t15,
                position: 'right'
              },
              {
              	element: document.querySelector('#menuWebBuscar'),
                intro: t16,
                position: 'right'
              }
              
              
            ],
            
            nextLabel: btn1,
            prevLabel: btn2,
            doneLabel: btn3,
            skipLabel: btn4,
            //para que no se salga si se hace click por fuera
            exitOnOverlayClick: 'false',
            showStepNumbers: 'false',
            showButtons: 'false',
            exitOnEsc: 'false',
            disableInteraction: 'true',
            
            showProgress: 'true'
          });

		intro.start();	
		
		
		
		intro.oncomplete(function() {
		  introCompleto('1');
		});
		
		intro.onexit(function() {
		  introCompleto('1');
		});
}
//---


//funcion para guardar un mensaje a todos los usuarios
function guardarMensajeTodosUsuarios(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	
	if( $("#fechaVencimientoMensaje").val().trim().length == 0 ){
		
		$("#label_fechaVencimientoMensaje").addClass( "active" );
		$("#fechaVencimientoMensaje").addClass( "invalid" );
		sw = 1;
		
	}		


	if( $("#textoMensaje").val().trim().length == 0 ){
		
		$("#label_textoMensaje").addClass( "active" );
		$("#textoMensaje").addClass( "invalid" );
		sw = 1;
		
	}
	
	if(sw == 0){
			$.ajax({
			      		url: "http://www.nanuvet.com/Controllers/home/guardarMensajeTodosUsuarios.php",
			      		async:false,    
                      	cache:false,
			            dataType: "html",
			            type : 'POST',
			            data: {
			            	    fechaVencimiento : $("#fechaVencimientoMensaje").val(),
			            	    mensaje : $("#textoMensaje").val()
			            	    
			            	},
			            success: function() {
			            	
			            	location.reload(true);	            
			            }
			      	});		
	}			
	
}
//---

//funcion para quitar un mensaje
function quitarmensaje(id){

			$.ajax({
			      		url: "http://www.nanuvet.com/Controllers/home/quitarMensajeTodosUsuarios.php",
			      		async:false,    
                      	cache:false,
			            dataType: "html",
			            type : 'POST',
			            data: {
			            	    id : id
			            	    
			            	},
			            success: function() {
			            	
			            	$("#tr_mensaje_"+id).remove();            
			            }
			      	});		
	
}
//---
