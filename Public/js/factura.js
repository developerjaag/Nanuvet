/*
 * Archivo para las funciones de factura
 */

$(document).ready(function () {

	$('#factura_valorBruto').on('input', function() {
	    calcularTotalFactura();
	});
	
	$('#factura_descuento').on('input', function() {
	    calcularTotalFactura();
	});
	
	$('.modal-trigger2').leanModal({
				 complete: function() { 
				 	$("#listadoItemsPorFacturar").html($("#preloader").html());
				 	location.reload(true);
				 }
			});

	
	if($("#estadoFactura").html() == "Iniciada"){
	
		swal({
			
		  title: $("#FacturaIniciadaGuia_titulo").html(),
		  text: $("#FacturaIniciadaGuia_texto").html(),
		  imageUrl: 'http://www.nanuvet.com/Public/img/facturaIniciada.png',
		  imageWidth: 200,
		  imageHeight: 100,
		  animation: false
		})

		
	}

	
});


//funcines para redireccionar, segun los items de la factura
function redireccionEnFac(url){
	
        	window.location=url;

}
//---


//funcion para cargar el formulariode nueva factura
function cargarDatosFactura(idConsulta, idPropietario, fechaHora, identificacion, nombre, apellido){
	
	cancelarNoFacturar();
	
	$("#factura_iva").val("0");
	
	$("#factura_idFacturador").val("0");
	$("#factura_idResolucion").val("0");
	
	$("#factura_resolucionfacturador").val("");
	$("#factura_metodoPago").val("");
	
	$("#factura_observaciones").val("");
	
	$('#factura_resolucionfacturador').material_select('destroy');
	$('#factura_metodoPago').material_select('destroy');
	
	$('#factura_resolucionfacturador').material_select();
	$('#factura_metodoPago').material_select();
	
	$("#factura_valorBruto").prop('disabled', true);
	$("#factura_descuento").prop('disabled', true);
	
	$("#factura_valorBruto").val($("#td_valorUnitario").html());
	
	$("#factura_descuento").val("0");
	$("#factura_valorIva").val("0");
	
	$("#factura_totalFactura").val("");	
	$("#label_factura_totalFactura").removeClass("active");
	
	$("#factura_valorBruto").removeClass("valid");
	$("#factura_descuento").removeClass("valid");
	
	
	$("#td_fechaHora").html(fechaHora);
	
	$("#label_factura_identificacionPropietario").addClass("active");
	$("#label_factura_nombrePropietario").addClass("active");
	$("#label_factura_apellidoPropietario").addClass("active");
	
	$("#factura_idConsulta").val(idConsulta);
	$("#factura_idPropietario").val(idPropietario);
	$("#factura_identificacionPropietario").val(identificacion);
	$("#factura_nombrePropietario").val(nombre);
	$("#factura_apellidoPropietario").val(apellido);
	
}
//---


//funcion para cambiar el valor del iva
function cambiarCampoIva(){
	
	$("#factura_valorBruto").prop('disabled', false);
	$("#factura_descuento").prop('disabled', false);
	
	
	data = $('#factura_resolucionfacturador').find(':selected').attr('data-option-value');
	
	$("#factura_iva").val($.parseJSON(data)[0]);
	
	$("#factura_idFacturador").val($.parseJSON(data)[1]);
	$("#factura_idResolucion").val($.parseJSON(data)[2]);
	

	
}
//---

//funcion para calcular el total de una factura
function calcularTotalFactura(){



	if( $("#factura_valorBruto").val().trim().length == 0 ){
		valorBruto = "0";
	}else{
		var valorBruto		= $("#factura_valorBruto").val();
	}	


	if( $("#factura_descuento").val().trim().length == 0 ){
		descuento = "0";
	}else{
		var descuento		= $("#factura_descuento").val();
	}
	
	valorBruto 	= valorBruto.replace('.','');
	descuento 	= descuento.replace('.','');
	
	valorBruto 	= parseInt(valorBruto);
	descuento 	= parseInt(descuento);
	
	var cantidad = parseInt($("#td_cantidad").html());
	
	
	valorBruto = valorBruto*cantidad;
	
	
	
	var iva 			= parseInt($("#factura_iva").val());
		
	//se calcula el procentaje de iva
	var calculoIVA 	= valorBruto*iva;
	
	calculoIVA		= calculoIVA/100;
	
	$("#factura_valorIva").val(calculoIVA);	
	
	
	
	var valorIVA = parseInt($("#factura_valorIva").val());

	var totalFactura 	=  (valorIVA+valorBruto)-descuento;
	
	$("#label_factura_totalFactura").addClass("active");
	
	$("#factura_totalFactura").val(totalFactura);
		
	
}
//---

//funcion para guardar una nueva factura (Solo una consulta u hospitalizacion)
function guardarFacturaConsulta(estadoFactura){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	$("#factura_estado").val(estadoFactura);
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else
	
	
	
	if( $("#factura_metodoPago").val() == "" || $("#factura_metodoPago").val() == null ){
		
		$("#div_factura_metodoPago").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_metodoPago").removeClass( "red lighten-3" );
		
	}//fin else	
	
	
	if( $("#factura_valorBruto").val().trim().length == 0 ){
		
		$("#label_factura_valorBruto").addClass( "active" );
		$("#factura_valorBruto").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#factura_descuento").val().trim().length == 0 ){
		
		$("#label_factura_descuento").addClass( "active" );
		$("#factura_descuento").addClass( "invalid" );
		sw = 1;
	}	
	
	if(sw == 1){
		return false;
	}else{
		
		$("#factura_iva").prop('disabled', false);
		$("#factura_valorBruto").prop('disabled', false);
		$("#factura_descuento").prop('disabled', false);
		$("#factura_valorIva").prop('disabled', false);
		$("#factura_totalFactura").prop('disabled', false);
		
		$("#form_nuevaFacturaConsulta").submit();
		
	}


	
}
//---


//metodo para consultar una factura que se encuentre iniciada
function consultarFacturaIniciada(){

			$.ajax({
		  		url: "http://www.nanuvet.com/Controllers/factura/consultarFacturaIniciada.php",
		        dataType: "html",
		        type : 'POST',
		        success: function(data) {	
		        	
		        	$("#resultadoFacturaIniciada").html(data);
		        	$('#rFI_facturadorResolucion').material_select();
		        	$('#rFI_factura_metodoPago').material_select();
		        	
		        	$("#rFI_label_factura_iva").addClass("active");
		        	
		        	$("#rFI_label_factura_identificacionPropietario").addClass("active");
		        	$("#rFI_label_factura_nombrePropietario").addClass("active");
		        	$("#rFI_label_factura_apellidoPropietario").addClass("active");
		        	
		        	$(".labelActivar").addClass("active");
		        	
	        		/*para los campos de la factura iniciada se calculan los valores cuando se modifican los input*/
					$('.calculoTotalesFacturaIniciada').on('input', function() {
					    calcularValoresFacturaIniciada();
					});	
		        	
	
		        	
		        	calcularValoresFacturaIniciada();
		        	
		        	
		        }//fin success
		  	});	
	
}
//---


//funcoin para calcular los valores de una factura iniciada
function calcularValoresFacturaIniciada(){
	
	var sumaPrecioBruto = 0;
	var sumaDescuento 	= 0;
	var valorBruto;
	var descuento;
	var cantidad;
	
	$('.tr_facturaIniciada').each(function() {
		
		
		if( $(this).find(".rFI_valorUnitario").val().trim().length == 0 ){
			valorBruto = "0";
		}else{
			valorBruto = $(this).find(".rFI_valorUnitario").val();	
		}
		
			
		valorBruto = valorBruto.replace('.','');		
		valorBruto 	= parseInt(valorBruto);		
		
		if( $(this).find(".rFI_cantidad").val().trim().length == 0 ){
			cantidad = "0";
		}else{
			cantidad = $(this).find(".rFI_cantidad").val();
		}
		
		
		
		cantidad = parseInt(cantidad);
		
		valorBruto = valorBruto*cantidad;
		
		sumaPrecioBruto = sumaPrecioBruto+valorBruto;

		if( $(this).find(".rFI_descuento").val().trim().length == 0 ){
			descuento = "0";
		}else{
			descuento 	= $(this).find(".rFI_descuento").val();	
		}
		
			
		
		descuento 	= descuento.replace('.','');		
		descuento 	= parseInt(descuento);		
		sumaDescuento = sumaDescuento+descuento;

	});
	
	
			var iva 			= parseInt($("#rFI_factura_iva").val());
		
			//se calcula el procentaje de iva
			var calculoIVA 	= sumaPrecioBruto*iva;
			
			calculoIVA		= calculoIVA/100;
						
			var valorIVA = parseInt(calculoIVA);
		
			var totalFactura 	=  (valorIVA+sumaPrecioBruto)-sumaDescuento;	
	
	
	$("#subTotalFacturaIniciada").html(formatNumber.new(sumaPrecioBruto));
	$("#descuentoFacturaIniciada").html(formatNumber.new(sumaDescuento));
	$("#valorIVAFacturaIniciada").html(formatNumber.new(calculoIVA));
	$("#totalFacturaIniciada").html(formatNumber.new(totalFactura));
	
}
//---

//metodo para adicionar un item a la factura
function adicionarItemFactura(idQuitarListado, tipoElemento, precio, idElemento, cantidad){
	
			
			$.ajax({
		  		url: "http://www.nanuvet.com/Controllers/factura/adicionarItemFactura.php",
		  		Async: false,
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	tipoElemento 	: tipoElemento,
		        	precio 			: precio, 
		        	idElemento 		: idElemento,
		        	cantidad 		: cantidad
		        	
		        	},
		        success: function(data) {	
		        	
		        	
		        	
		        		
		        		if( (tipoElemento == "Servicio") ){
		        			
		        			if( (data == "Ya existe!") ){
		        				
		        				$("#errorAdicionandoServicio").show("slower"); 
		        			}else{
		        				
		        				limpiarAdicionarServicio();
								$('#modal_adicionarServicio').closeModal();	
								Materialize.toast('Se adicionó el servicio a la factura!', 4000);
		        				
		        			}
		        			
		        			return false;
		        			
		        		}else if( (tipoElemento == "Producto") ){
		        			
		        			if( (data == "Ya existe!") ){
		        				
		        				$("#errorAdicionandoProducto").show("slower"); 
		        			}else{
		        				
		        				limpiarAdicionarProducto();
								$('#modal_adicionarProducto').closeModal();	
								Materialize.toast('Se adicionó el producto a la factura!', 4000);
		        				
		        			}
		        			
		        			return false;
		        			
		        		}else{
		        		
			        		$("#"+idQuitarListado).remove();
			        	
				        	var txt = $("#textoMensajeAdicionarItem").html();
				        	
				        	Materialize.toast(txt, 4000);
		        		
		        		}
		        	
		        	
		        	
		        }//fin success
		  	});	
	
	
	
}
//----







//funcion para anular un item de la factura iniciada
function anularItem(idDetalleParaAnular){
	
	$.ajax({
		  		url: "http://www.nanuvet.com/Controllers/factura/anularItemDetalle.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idDetalleParaAnular 	: idDetalleParaAnular
		        	
		        	},
		        success: function() {	
		        	
		        	$("#tr_facturaIniciada_"+idDetalleParaAnular).remove();
		        	calcularValoresFacturaIniciada();
		        	
		        }//fin success
		  	});	
	
}
//---


//funcion para anular una factura
function anularFacturaIniciada(){
	
	swal({
	  title: 'Anular la factura?',
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#2BBBAD',
	  cancelButtonColor: '#E53935',
	  confirmButtonText: 'Si, anularla!',
	  cancelButtonText: 'No!',
	},function(){
	  
			$.ajax({
				  		url: "http://www.nanuvet.com/Controllers/factura/anularFactura.php",
				        dataType: "html",
				        type : 'POST',
				        data: { 
				        	
				        	idFactura 	: $("#idFacturaIniciada").val()
				        	
				        	},
				        success: function() {	
				        	
				        	location.reload(true);
				        	
				        }//fin success
				  	});		  
	  
	});
	
}
//---


//funcion para guardar una factura iniciada
function guardarFacturaIniciada(){
	
	$.ajax({
		  		url: "http://www.nanuvet.com/Controllers/factura/guardarFacturaIniciada.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idFactura 		: $("#idFacturaIniciada").val(),
		        	metodoPago		: $("#rFI_factura_metodoPago").val(),
		        	observaciones 	: $("#rFI_factura_observaciones").val(),
		        	subTotal		: $("#subTotalFacturaIniciada").html(),
		        	valorIva		: $("#valorIVAFacturaIniciada").html(),
		        	descuento		: $("#descuentoFacturaIniciada").html(),
		        	total			: $("#totalFacturaIniciada").html(),
		        	
		        	
		        	
		        	},
		        success: function() {	
		        	
		        	location.reload(true);
		        	
		        }//fin success
		  	});		
	
	
}
//---


///****************************cirugia ////

//funcion para cargar el formulariode nueva factura
function cargarDatosFacturaCirugia(idCirugia, idPropietario, fechaHora, identificacion, nombre, apellido){
	
	cancelarNoFacturar();
	
	$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/factura/cirugias/consultarDetalleCirugia.php",
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	        	
	        	idCirugia : idCirugia
	        	
	        	},
	        success: function(data) {	
	        	
	        	$('#div_detalleCirugia').html(data);
	        	
	        	$(".labelActivar").addClass("active");
	        	
	        		$('.descuentoCirugia').on('input', function() {
					    tatalizarItemsCirugia();
					});
					
					$('.valorUnitarioCirugia').on('input', function() {
					    tatalizarItemsCirugia();
					});
	        	
	        }//fin success
	  	});		
	
	

	//se limpian los valores de la factura
	$("#unItemSubTotalFacturaCirugia").html("");
	$("#unItemValorIVAFacturaCirugia").html("");
	$("#unItemDescuentoFacturaCirugia").html("");
	$("#unItemTotalFacturaCirugia").html("");

	
	$("#factura_iva").val("0");
	
	$("#factura_idFacturador").val("0");
	$("#factura_idResolucion").val("0");
	
	$("#factura_resolucionfacturador").val("");
	$("#factura_metodoPago").val("");
	
	$("#factura_observaciones").val("");
	
	$('#factura_resolucionfacturador').material_select('destroy');
	$('#factura_metodoPago').material_select('destroy');
	
	$('#factura_resolucionfacturador').material_select();
	$('#factura_metodoPago').material_select();

	
	
	$("#td_fechaHora").html(fechaHora);
	
	$("#label_factura_identificacionPropietario").addClass("active");
	$("#label_factura_nombrePropietario").addClass("active");
	$("#label_factura_apellidoPropietario").addClass("active");
	
	$("#factura_idCirugia").val(idCirugia);
	$("#factura_idPropietario").val(idPropietario);
	$("#factura_identificacionPropietario").val(identificacion);
	$("#factura_nombrePropietario").val(nombre);
	$("#factura_apellidoPropietario").val(apellido);
	
}
//---


//funcion para totalizar los items de una cirugia
function tatalizarItemsCirugia(){
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		return false;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else
		
	
	var sumaPrecioBruto = 0;
	var sumaDescuento 	= 0;
	var valorBruto;
	var descuento;
	var cantidad;
	
	$('.tr_detalleCirugia').each(function() {
		
		
		if( $(this).find(".valorUnitarioCirugia").val().trim().length == 0 ){
			valorBruto = "0";
		}else{
			valorBruto = $(this).find(".valorUnitarioCirugia").val();	
		}
		
			
		valorBruto = valorBruto.replace('.','');		
		valorBruto 	= parseInt(valorBruto);	
		
		sumaPrecioBruto = sumaPrecioBruto+valorBruto;

		if( $(this).find(".descuentoCirugia").val().trim().length == 0 ){
			descuento = "0";
		}else{
			descuento 	= $(this).find(".descuentoCirugia").val();	
		}
		
			
		
		descuento 	= descuento.replace('.','');		
		descuento 	= parseInt(descuento);		
		sumaDescuento = sumaDescuento+descuento;

	});
	
	
			var iva 			= parseInt($("#factura_iva").val());
		
			//se calcula el procentaje de iva
			var calculoIVA 	= sumaPrecioBruto*iva;
			
			calculoIVA		= calculoIVA/100;
						
			var valorIVA = parseInt(calculoIVA);
		
			var totalFactura 	=  (valorIVA+sumaPrecioBruto)-sumaDescuento;	
	
	
	$("#unItemSubTotalFacturaCirugia").html(formatNumber.new(sumaPrecioBruto));
	$("#unItemDescuentoFacturaCirugia").html(formatNumber.new(sumaDescuento));
	$("#unItemValorIVAFacturaCirugia").html(formatNumber.new(calculoIVA));
	$("#unItemTotalFacturaCirugia").html(formatNumber.new(totalFactura));
	
	
}
//---


//funcion para guardar una cirugia
function guardarFacturaCirugia(estadoFactura){
	
		
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	$("#factura_estado").val(estadoFactura);
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else
	
	
	
	if( $("#factura_metodoPago").val() == "" || $("#factura_metodoPago").val() == null ){
		
		$("#div_factura_metodoPago").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_metodoPago").removeClass( "red lighten-3" );
		
	}//fin else	
	

	
	if(sw == 1){
		return false;
	}else{
		
		$("#factura_iva").prop('disabled', false);
		$("#factura_valorIva").prop('disabled', false);
		
			$("#factura_subtotal").val($("#unItemSubTotalFacturaCirugia").html());
			$("#factura_descuento").val($("#unItemDescuentoFacturaCirugia").html());
			$("#factura_valorIva").val($("#unItemValorIVAFacturaCirugia").html());
			$("#factura_totalFactura").val($("#unItemTotalFacturaCirugia").html());
		
		$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/factura/cirugias/guardarFacturaCirugia.php",
	  		Async: false,
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	        	
	        	   factura_resolucionfacturador 	: $("#factura_resolucionfacturador").val(),
	        	   factura_idFacturador 			: $("#factura_idFacturador").val(),
	        	   factura_idResolucion				: $("#factura_idResolucion").val(),
	        	   factura_iva						: $("#factura_iva").val(),
	        	   factura_metodoPago				: $("#factura_metodoPago").val(),
	        	   factura_idPropietario			: $("#factura_idPropietario").val(),
	        	   factura_idCirugia				: $("#factura_idCirugia").val(),
	        	   factura_observaciones			: $("#factura_observaciones").val(),
	        	   factura_valorBruto				: $("#unItemSubTotalFacturaCirugia").html(),
	        	   factura_descuento				: $("#unItemDescuentoFacturaCirugia").html(),
	        	   factura_valorIva					: $("#unItemValorIVAFacturaCirugia").html(),
	        	   factura_totalFactura				: $("#unItemTotalFacturaCirugia").html(),
	        	   factura_estado					: $("#factura_estado").val(),
	        	   
	        	},
	        success: function(data) {
	        	
	        				idFactura = data;
	        				
	        				var len = $('.tr_detalleCirugia').length;
	        				
					        $('.tr_detalleCirugia').each(function(index, element) {
						
						
									idPanelCirugiaDiagnostico = $(this).find(".idPanelCirugiaDiagnostico").val();		
								
									valorBruto = $(this).find(".valorUnitarioCirugia").val();							
									
									descuento 	= $(this).find(".descuentoCirugia").val();	
								
									
									$.ajax({
									  		url: "http://www.nanuvet.com/Controllers/factura/cirugias/guardarDetallePagoCirugia.php",
									  		Async: false,
									        dataType: "html",
									        type : 'POST',
									        data: { 
									        	        	
									        	   idFactura						: idFactura,
									        	   factura_idCirugia				: $("#factura_idCirugia").val(),
									        	   idPanelCirugiaDiagnostico		: idPanelCirugiaDiagnostico,
									        	   valorBruto						: valorBruto,
									        	   descuento						: descuento
									        	   
									        	},
									        	success: function() {
									        		if (index == len - 1) {
											           	$("#listadoItemsPorFacturar").html($("#preloader").html());
											           	location.reload(true);
											          }
									        	}							
									});
									
									

	        			});//fin each tr
	        }//fin success
	        
	  	});	
		
		//$("#form_nuevaFacturaCirugia").submit();
		
	}//fin else


	
	
}
//---



//******************** Exmanes-----------------------------------------
//funcion para cargar el formulario de nuevo examen
function cargarDatosFacturaExamen(idExamen, idPropietario, fechaHora, identificacion, nombre, apellido){
	
	cancelarNoFacturar();
	
	$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/factura/examenes/consultarDetalleExamen.php",
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	        	
	        	idExamen : idExamen
	        	
	        	},
	        success: function(data) {	
	        	
	        	$('#div_detalleExamen').html(data);
	        	
	        	$(".labelActivar").addClass("active");
	        	
	        		$('.descuentoExamen').on('input', function() {
					    tatalizarItemsExamen();
					});
					
					$('.valorUnitarioExamen').on('input', function() {
					    tatalizarItemsExamen();
					});
	        	
	        }//fin success
	  	});		
	
	//se limpian los valores de la factura
	$("#unItemSubTotalFacturaExamen").html("");
	$("#unItemValorIVAFacturaExamen").html("");
	$("#unItemDescuentoFacturaExamen").html("");
	$("#unItemTotalFacturaExamen").html("");
	
	$("#factura_iva").val("0");
	
	$("#factura_idFacturador").val("0");
	$("#factura_idResolucion").val("0");
	
	$("#factura_resolucionfacturador").val("");
	$("#factura_metodoPago").val("");
	
	$("#factura_observaciones").val("");
	
	$('#factura_resolucionfacturador').material_select('destroy');
	$('#factura_metodoPago').material_select('destroy');
	
	$('#factura_resolucionfacturador').material_select();
	$('#factura_metodoPago').material_select();

	
	
	$("#td_fechaHora").html(fechaHora);
	
	$("#label_factura_identificacionPropietario").addClass("active");
	$("#label_factura_nombrePropietario").addClass("active");
	$("#label_factura_apellidoPropietario").addClass("active");
	
	$("#factura_idExamen").val(idExamen);
	$("#factura_idPropietario").val(idPropietario);
	$("#factura_identificacionPropietario").val(identificacion);
	$("#factura_nombrePropietario").val(nombre);
	$("#factura_apellidoPropietario").val(apellido);
	
}
//---


//funcion para totalizar los items de un Examen
function tatalizarItemsExamen(){
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		return false;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else
		
	
	var sumaPrecioBruto = 0;
	var sumaDescuento 	= 0;
	var valorBruto;
	var descuento;
	var cantidad;
	
	$('.tr_detalleExamen').each(function() {
		
		
		if( $(this).find(".valorUnitarioExamen").val().trim().length == 0 ){
			valorBruto = "0";
		}else{
			valorBruto = $(this).find(".valorUnitarioExamen").val();	
		}
		
			
		valorBruto = valorBruto.replace('.','');		
		valorBruto 	= parseInt(valorBruto);	
		
		sumaPrecioBruto = sumaPrecioBruto+valorBruto;

		if( $(this).find(".descuentoExamen").val().trim().length == 0 ){
			descuento = "0";
		}else{
			descuento 	= $(this).find(".descuentoExamen").val();	
		}
		
			
		
		descuento 	= descuento.replace('.','');		
		descuento 	= parseInt(descuento);		
		sumaDescuento = sumaDescuento+descuento;

	});
	
	
			var iva 			= parseInt($("#factura_iva").val());
		
			//se calcula el procentaje de iva
			var calculoIVA 	= sumaPrecioBruto*iva;
			
			calculoIVA		= calculoIVA/100;
						
			var valorIVA = parseInt(calculoIVA);
		
			var totalFactura 	=  (valorIVA+sumaPrecioBruto)-sumaDescuento;	
	
	
	$("#unItemSubTotalFacturaExamen").html(formatNumber.new(sumaPrecioBruto));
	$("#unItemDescuentoFacturaExamen").html(formatNumber.new(sumaDescuento));
	$("#unItemValorIVAFacturaExamen").html(formatNumber.new(calculoIVA));
	$("#unItemTotalFacturaExamen").html(formatNumber.new(totalFactura));
	
	
}
//---





//funcion para guardar la factura de un examen
function guardarFacturaExamen(estadoFactura){
	
		
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	$("#factura_estado").val(estadoFactura);
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else
	
	
	
	if( $("#factura_metodoPago").val() == "" || $("#factura_metodoPago").val() == null ){
		
		$("#div_factura_metodoPago").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_metodoPago").removeClass( "red lighten-3" );
		
	}//fin else	
	

	
	if(sw == 1){
		return false;
	}else{
		
		$("#factura_iva").prop('disabled', false);
		$("#factura_valorIva").prop('disabled', false);
		
			$("#factura_subtotal").val($("#unItemSubTotalFacturaExamen").html());
			$("#factura_descuento").val($("#unItemDescuentoFacturaExamen").html());
			$("#factura_valorIva").val($("#unItemValorIVAFacturaExamen").html());
			$("#factura_totalFactura").val($("#unItemTotalFacturaExamen").html());
		
		$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/factura/examenes/guardarFacturaExamen.php",
	  		Async: false,
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	        	
	        	   factura_resolucionfacturador 	: $("#factura_resolucionfacturador").val(),
	        	   factura_idFacturador 			: $("#factura_idFacturador").val(),
	        	   factura_idResolucion				: $("#factura_idResolucion").val(),
	        	   factura_iva						: $("#factura_iva").val(),
	        	   factura_metodoPago				: $("#factura_metodoPago").val(),
	        	   factura_idPropietario			: $("#factura_idPropietario").val(),
	        	   factura_idExamen					: $("#factura_idExamen").val(),
	        	   factura_observaciones			: $("#factura_observaciones").val(),
	        	   factura_valorBruto				: $("#unItemSubTotalFacturaExamen").html(),
	        	   factura_descuento				: $("#unItemDescuentoFacturaExamen").html(),
	        	   factura_valorIva					: $("#unItemValorIVAFacturaExamen").html(),
	        	   factura_totalFactura				: $("#unItemTotalFacturaExamen").html(),
	        	   factura_estado					: $("#factura_estado").val(),
	        	   
	        	},
	        success: function(data) {
	        	
	        				idFactura = data;
	        				
	        				var len = $('.tr_detalleExamen').length;
	        				
					        $('.tr_detalleExamen').each(function(index, element) {
						
						
									idListadoExamen = $(this).find(".idListadoExamen").val();		
								
									valorBruto = $(this).find(".valorUnitarioExamen").val();							
									
									descuento 	= $(this).find(".descuentoExamen").val();	
								
									
									$.ajax({
									  		url: "http://www.nanuvet.com/Controllers/factura/examenes/guardarDetallePagoExamen.php",
									  		Async: false,
									        dataType: "html",
									        type : 'POST',
									        data: { 
									        	        	
									        	   idFactura						: idFactura,
									        	   factura_idExamen					: $("#factura_idExamen").val(),
									        	   idListadoExamen					: idListadoExamen,
									        	   valorBruto						: valorBruto,
									        	   descuento						: descuento
									        	   
									        	},
									        	success: function() {
									        		if (index == len - 1) {
											           	$("#listadoItemsPorFacturar").html($("#preloader").html());
											           	location.reload(true);
											          }
									        	}							
									});
									
									

	        			});//fin each tr
	        }//fin success
	        
	  	});	
		
		
	}//fin else


	
	
}
//---


//************* Hospitalizacion

//funcion para cargaar los datos de una factura de hospitalizacion
function cargarDatosFacturaHospitalizacion(idHospitalizacion, idPropietario, fechaHora, identificacion, nombre, apellido, cantidadHoras){
	
	cancelarNoFacturar();
	
	$("#factura_iva").val("0");
	
	$("#factura_idFacturador").val("0");
	$("#factura_idResolucion").val("0");
	
	$("#factura_resolucionfacturador").val("");
	$("#factura_metodoPago").val("");
	
	$("#factura_observaciones").val("");
	
	$('#factura_resolucionfacturador').material_select('destroy');
	$('#factura_metodoPago').material_select('destroy');
	
	$('#factura_resolucionfacturador').material_select();
	$('#factura_metodoPago').material_select();
	
	$("#factura_valorBruto").prop('disabled', true);
	$("#factura_descuento").prop('disabled', true);
	
	$("#factura_valorBruto").val($("#td_valorUnitario").html());
	
	$("#factura_descuento").val("0");
	$("#factura_valorIva").val("0");
	
	$("#factura_totalFactura").val("");	
	$("#label_factura_totalFactura").removeClass("active");
	
	$("#factura_valorBruto").removeClass("valid");
	$("#factura_descuento").removeClass("valid");
	
	
	$("#td_fechaHora").html(fechaHora);
	
	$("#label_factura_identificacionPropietario").addClass("active");
	$("#label_factura_nombrePropietario").addClass("active");
	$("#label_factura_apellidoPropietario").addClass("active");
	
	$("#factura_idHospitalizacion").val(idHospitalizacion);
	$("#factura_idPropietario").val(idPropietario);
	$("#factura_identificacionPropietario").val(identificacion);
	$("#factura_nombrePropietario").val(nombre);
	$("#factura_apellidoPropietario").val(apellido);
	
	$("#td_cantidad").html(cantidadHoras);
	
}
//---




//funcion para no facturar un item
function noFacturarItem(){

	$("#form_noFacturarItem").show("slower");
	
	$('#cuerpoModal :input').attr('disabled', true);
	$('.ocultarBotonFooter').hide();
	
}
//---

//funcion para cancelar el motivo para no facturar
function cancelarNoFacturar(){	


	$("#form_noFacturarItem").hide("slower");
	
	$("#motivoNoFacturar").val("");
	
	$("#label_motivoNoFacturar").removeClass("active");
	
	$("#motivoNoFacturar").removeClass("valid");
	$("#motivoNoFacturar").removeClass("invalid");
	
	$('#factura_resolucionfacturador').removeAttr('disabled');
	$('#factura_metodoPago').removeAttr('disabled');
	$('#factura_observaciones').removeAttr('disabled');
	
	$('select').material_select();
	
	$('.ocultarBotonFooter').show();	
	
}
//---

//funcion para guardar la no facturacion de un elemento
function guardarMotivoNoFacturar(tipoDetalle){

	
	if( $("#motivoNoFacturar").val().trim().length == 0 ){
		
		$("#label_motivoNoFacturar").addClass( "active" );
		$("#motivoNoFacturar").addClass( "invalid" );
		
		return false;
		
	}	
	
	if( $("#factura_idConsulta").length > 0 ){
		var idDetalle = $("#factura_idConsulta").val();
	}
	
	if( $("#factura_idCirugia").length > 0 ){
		var idDetalle = $("#factura_idCirugia").val();
	}	

	if( $("#factura_idExamen").length > 0 ){
		var idDetalle = $("#factura_idExamen").val();
	}	

	if( $("#factura_idHospitalizacion").length > 0 ){
		var idDetalle = $("#factura_idHospitalizacion").val();
	}	
	
	$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/factura/noFacturarElemento.php",
	  		Async: false,
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	        	
	        	   tipoDetalle						: tipoDetalle,
	        	    motivo							: $("#motivoNoFacturar").val(),
	        	   idDetalle						: idDetalle
	        	   
	        	},
	        	success: function() {
			           	$("#listadoItemsPorFacturar").html($("#preloader").html());
			           	location.reload(true);
	        	}							
	});	
	
	
}
//---



//********************Facturas en general (primera pestaña)

//funcion para mostrar el formulario de una nueva factura
function mostrarFormNuevaFactura(){
	
	$("#div_nuevaFactura").show("slower");
	$("#form_nuevaFactura").addClass('unsavedForm');
	$("#tituloLi").hide();
}
//----

//funcion para cerrar el formulario de nueva factura
function cerrarFormNuevaFactura(){
	
	$("#tituloLi").show();
	$("#div_nuevaFactura").hide("slower");
	$("#form_nuevaFactura").removeClass('unsavedForm');
	
	$("#factura_idFacturador").val("0");
	$("#factura_idResolucion").val("0");
	
	$("#factura_resolucionfacturador").val("");
	
	$("#factura_iva").val("0");
	$("#factura_metodoPago").val("0");
	$("#idPropietario").val("0");
	
	$("#factura_propietario").val("");
	$("#factura_observaciones").val("");
	
	$("#label_factura_propietario").removeClass("active");
	
	$("#factura_propietario").removeClass("valid");
	$("#factura_propietario").removeClass("invalid");
	
	$("#label_factura_observaciones").removeClass("active");
	
	$("#factura_observaciones").removeClass("valid");
	$("#factura_observaciones").removeClass("invalid");	
	
	$(".modal-trigger").addClass("disabled");
	$(".modal-trigger").prop('disabled', true);
	
	$('select').material_select();
	
	$("#tabla_nuevaFacturaDetalle").empty();
	
	$("#subTotalFactura").html("");
	$("#valorIVAFactura").html("");
	$("#descuentoFactura").html("");
	$("#totalFactura").html("");
	
}
//---


//funcion para buscar un propietario
function buscarPropietarioFactura(){


 $('#factura_propietario').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/nuevo/buscarPropietario.php",
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
        	
	            		   
	         $("#idPropietario").val(ui.item.id); 
	         $("#factura_propietario").val(ui.item.value);
	         $("#label_factura_propietario").addClass("active");
	         habilitarBotonesProductosServicios();
        			   			
        }
    	
  	}); 	
	
}
//---


//comprobar si se han diligenciado los campos para habilitar los botones de productos y servicios
function habilitarBotonesProductosServicios(){
	
	if($("#factura_idFacturador").val() == '0' || $("#factura_idResolucion").val() == '0'  ){
		return false;
	}
	
	if($("#factura_metodoPago").val() == '0' ){
		return false;
	}
	
	if($("#idPropietario").val() == '0'){
		return false;
	}
	
	$(".modal-trigger").removeClass("disabled");
	$(".modal-trigger").prop('disabled', false);
	
}
//---

//funcion para buscar un producto para adicionar
function buscarProductoAdicionar(){

 $('#adicionarProducto_buscar').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/productos/buscarProducto.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringProducto : request.term,//se envia el string a buscar
	            	    utilizar : 'Si',
	            	    vender: 'Si'
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idProductoBuscado").val(ui.item.id); 
				
				$("#nombreAdicionarProducto").val(ui.item.nombre);	
				$("#precioAdicionarProducto").val(ui.item.precio);
				
				$("#label_nombreAdicionarProducto").addClass("active");
				$("#label_precioAdicionarProducto").addClass("active");
				
				$("#iconAdiconarProducto").show("slower");	
				
				$('#aAdicionarProducto').attr('onclick', 'adicionarItemProducto()' );
				$("#aAdicionarProducto").removeClass("disabled");
        		       		
        			   			
        }
    	
  	}); 

	
}
//---


//funcion para adicionar un producto a la factura
function adicionarItemProducto(){
	
	//para saber si existe una factura iniciada y adicionar el producto a tal factura
	if( $("#estadoFactura").html() == 'Iniciada' ){
		
		var precio 		= $("#precioAdicionarProducto").val();
		var idElemento 	= $("#idProductoBuscado").val();
		var cantidad	= $("#cantidadAdicionarProducto").val();
		
		adicionarItemFactura('NoQuitarNada', 'Producto', precio, idElemento, cantidad);
		
		
		return false;
	}
	
	
	if( $("#idTrTablaDetalleProducto_"+$("#idProductoBuscado").val()).length > 0 ){
		$("#errorAdicionandoProducto").show("slower");
		return false;
	}
	
	
	$('#tabla_nuevaFacturaDetalle').append('<tr id="idTrTablaDetalleProducto_'+$("#idProductoBuscado").val()+'" class="tr_facturaFactura">'+
											'<td style="display: none;" class="tipo" >Producto</td>'+
											'<td style="display: none;" class="id" >'+$("#idProductoBuscado").val()+'</td>'+
						  					'<td>'+$("#nombreAdicionarProducto").val()+'</td>'+
						  					'<td class="FF_valorUnitario">'+$("#precioAdicionarProducto").val()+'</td>'+
						  					'<td>'+
						  						'<div class="input-field">'+
							      					'<input type="text" class="FF_cantidad" id="cantidadAdicionarProducto_'+$("#idProductoBuscado").val()+'" onkeypress="return soloNumeros(event)" value="'+$("#cantidadAdicionarProducto").val()+'" />'+
							      					'<label class="active" id="label_cantidadAdicionarProducto" for="cantidadAdicionarProducto_'+$("#idProductoBuscado").val()+'" data-error="La cantidad supera la existencia de esta sucursal" data-success="Ok" style="width:100%; text-align: left;" >Cantidad</label>'+
							      				'</div>'+
						  					'</td>'+
						  					'<td>'+
						  						'<div class="input-field">'+
							      					'<input type="text" class="FF_descuento" id="descuentoAdicionarProducto_'+$("#idProductoBuscado").val()+'" onkeypress="return soloNumerosPuntos(event)" value="'+$("#descuentoAdicionarProducto").val()+'" />'+
							      					'<label class="active" id="label_descuentoAdicionarProducto" for="descuentoAdicionarProducto_'+$("#idProductoBuscado").val()+'">Descuento</label>'+
							      				'</div>'+
						  					'</td>'+
						  					'<td>'+
						  						'<i style="cursor: pointer;" class="fa fa-trash fa-3x" aria-hidden="true" onclick="removerItemFacturaFactura(\'idTrTablaDetalleProducto_'+$("#idProductoBuscado").val()+'\')"></i>'+
						  					'</td>'+
						  				'</tr>');
	

	$('.FF_descuento').on('input', function() {
	    calcularValoresFacturaFactura();
	});

	$('.FF_cantidad').on('input', function() {
	    calcularValoresFacturaFactura();
	});

	limpiarAdicionarProducto();
	
	$("#tabla_nuevaFacturaDetalle").addClass("highlight");
						  				
	$('#modal_adicionarProducto').closeModal();		
	
	calcularValoresFacturaFactura();		  				
						  				
}
//---


//funcion para limpiar el formulario de adicionar producto
function limpiarAdicionarProducto(){
	
	$("#errorAdicionandoProducto").hide("slower");
	$("#idProductoBuscado").val("0"); 
				
	$("#nombreAdicionarProducto").val("");	
	$("#precioAdicionarProducto").val("");
	
	$("#cantidadAdicionarProducto").val("1");
	$("#descuentoAdicionarProducto").val("0");
	
	$("#label_nombreAdicionarProducto").removeClass("active");
	$("#label_precioAdicionarProducto").removeClass("active");
	
	
	$("#cantidadAdicionarProducto").removeClass("valid");
	$("#cantidadAdicionarProducto").removeClass("invalid");
	
	$("#descuentoAdicionarProducto").removeClass("valid");
	$("#descuentoAdicionarProducto").removeClass("invalid");
	
	
	$("#adicionarProducto_buscar").val("");
	$("#adicionarProducto_buscar").removeClass("valid");
	$("#adicionarProducto_buscar").removeClass("invalid");	
	$("#label_adicionarProducto_buscar").removeClass("active");
	
	
	$("#iconAdiconarProducto").hide("slower");	
	
	
	$('#aAdicionarProducto').attr('onclick',null);
	
	$("#aAdicionarProducto").prop('disabled', true);
	
	$("#aAdicionarProducto").addClass('disabled');	
	
}
//---


//funcion para remover un item de la factura factura
function removerItemFacturaFactura(idRemover){
	
	$("#"+idRemover).remove();
	calcularValoresFacturaFactura();
	
}
//---



//funcio npara calcular los valores en la factura factura
function calcularValoresFacturaFactura(){
	
	
	var sumaPrecioBruto = 0;
	var sumaDescuento 	= 0;
	var valorBruto;
	var descuento;
	var cantidad;
	
	$('.tr_facturaFactura').each(function() {
		
		
		if( $(this).find(".FF_valorUnitario").html().trim().length == 0 ){
			valorBruto = 0;
		}else{
			valorBruto = $(this).find(".FF_valorUnitario").html();	
		}
		
			
		valorBruto = valorBruto.replace('.','');		
		valorBruto 	= parseInt(valorBruto);		
		
		if( $(this).find(".FF_cantidad").val().trim().length == 0 ){
			cantidad = 0;
		}else{
			cantidad = $(this).find(".FF_cantidad").val();
		}
				
		
		cantidad = parseInt(cantidad);
		
		valorBruto = valorBruto*cantidad;
		
		sumaPrecioBruto = sumaPrecioBruto+valorBruto;

		if( $(this).find(".FF_descuento").val().trim().length == 0 ){
			descuento = "0";
		}else{
			descuento 	= $(this).find(".FF_descuento").val();	
		}
		
			
		
		descuento 	= descuento.replace('.','');		
		descuento 	= parseInt(descuento);		
		sumaDescuento = sumaDescuento+descuento;

	});
	
	
			var iva 			= parseInt($("#factura_iva").val());
		
			//se calcula el procentaje de iva
			var calculoIVA 	= sumaPrecioBruto*iva;
			
			calculoIVA		= calculoIVA/100;
						
			var valorIVA = parseInt(calculoIVA);
		
			var totalFactura 	=  (valorIVA+sumaPrecioBruto)-sumaDescuento;	
	
	
	$("#subTotalFactura").html(formatNumber.new(sumaPrecioBruto));
	$("#descuentoFactura").html(formatNumber.new(sumaDescuento));
	$("#valorIVAFactura").html(formatNumber.new(calculoIVA));
	$("#totalFactura").html(formatNumber.new(totalFactura));
		
	
	
}
//---


//funcion para buscar un servicio para adicionar
function buscarServicioAdicionar(){

 $('#adicionarServicio_buscar').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/servicios/buscarServicio.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringServicio : request.term,//se envia el string a buscar
	            	    utilizar : 'Si'
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idServicioBuscado").val(ui.item.id); 
				
				$("#nombreAdicionarServicio").val(ui.item.nombre);	
				$("#precioAdicionarServicio").val(ui.item.precio);
				
				$("#label_nombreAdicionarServicio").addClass("active");
				$("#label_precioAdicionarServicio").addClass("active");
				
				$("#iconAdiconarServicio").show("slower");	
				
				$('#aAdicionarServicio').attr('onclick', 'adicionarItemServicio()' );
				$("#aAdicionarServicio").removeClass("disabled");
        		       		
        			   			
        }
    	
  	}); 

	
}
//---



//funcion para adicionar un servicio a la factura
function adicionarItemServicio(){

	//para saber si existe una factura iniciada y adicionar el producto a tal factura
	if( $("#estadoFactura").html() == 'Iniciada' ){
		
		var precio 		= $("#precioAdicionarServicio").val();
		var idElemento 	= $("#idServicioBuscado").val();
		var cantidad	= $("#cantidadAdicionarServicio").val();
		
		adicionarItemFactura('NoQuitarNada', 'Servicio', precio, idElemento, cantidad)
		

		
		return false;
	}


	
	if( $("#idTrTablaDetalleServicio_"+$("#idServicioBuscado").val()).length > 0 ){
		
		$("#errorAdicionandoServicio").show("slower");
		
		return false;
	}
	
	$('#tabla_nuevaFacturaDetalle').append('<tr id="idTrTablaDetalleServicio_'+$("#idServicioBuscado").val()+'" class="tr_facturaFactura">'+
											'<td style="display: none;" class="tipo" >Servicio</td>'+
											'<td style="display: none;" class="id" >'+$("#idServicioBuscado").val()+'</td>'+
						  					'<td>'+$("#nombreAdicionarServicio").val()+'</td>'+
						  					'<td class="FF_valorUnitario">'+$("#precioAdicionarServicio").val()+'</td>'+
						  					'<td>'+
						  						'<div class="input-field">'+
							      					'<input type="text" class="FF_cantidad" id="cantidadAdicionarServicio_'+$("#idServicioBuscado").val()+'" onkeypress="return soloNumeros(event)" value="'+$("#cantidadAdicionarServicio").val()+'" />'+
							      					'<label class="active" id="label_cantidadAdicionarServicio" for="cantidadAdicionarServicio_'+$("#idServicioBuscado").val()+'">Cantidad</label>'+
							      				'</div>'+
						  					'</td>'+
						  					'<td>'+
						  						'<div class="input-field">'+
							      					'<input type="text" class="FF_descuento" id="descuentoAdicionarServicio_'+$("#idServicioBuscado").val()+'"  onkeypress="return soloNumerosPuntos(event)" value="'+$("#descuentoAdicionarServicio").val()+'" />'+
							      					'<label class="active" id="label_descuentoAdicionarServicio" for="descuentoAdicionarServicio_'+$("#idServicioBuscado").val()+'">Descuento</label>'+
							      				'</div>'+
						  					'</td>'+
						  					'<td>'+
						  						'<i style="cursor: pointer;" class="fa fa-trash fa-3x" aria-hidden="true" onclick="removerItemFacturaFactura(\'idTrTablaDetalleServicio_'+$("#idServicioBuscado").val()+'\')"></i>'+
						  					'</td>'+
						  				'</tr>');
	

	$('.FF_descuento').on('input', function() {
	    calcularValoresFacturaFactura();
	});

	$('.FF_cantidad').on('input', function() {
	    calcularValoresFacturaFactura();
	});

	limpiarAdicionarServicio();
	
	$("#tabla_nuevaFacturaDetalle").addClass("highlight");
						  				
	$('#modal_adicionarServicio').closeModal();		
	
	calcularValoresFacturaFactura();		  				
						  				
}
//---



//funcion para limpiar el formulario de adicionar servicio
function limpiarAdicionarServicio(){
	
	$("#errorAdicionandoServicio").hide("slower");
	
	$("#idServicioBuscado").val("0"); 
				
	$("#nombreAdicionarServicio").val("");	
	$("#precioAdicionarServicio").val("");
	
	$("#cantidadAdicionarServicio").val("1");
	$("#descuentoAdicionarServicio").val("0");
	
	$("#label_nombreAdicionarServicio").removeClass("active");
	$("#label_precioAdicionarServicio").removeClass("active");
	
	
	$("#cantidadAdicionarServicio").removeClass("valid");
	$("#cantidadAdicionarServicio").removeClass("invalid");
	
	$("#descuentoAdicionarServicio").removeClass("valid");
	$("#descuentoAdicionarServicio").removeClass("invalid");
	
	
	$("#adicionarServicio_buscar").val("");
	$("#adicionarServicio_buscar").removeClass("valid");
	$("#adicionarServicio_buscar").removeClass("invalid");	
	$("#label_adicionarServicio_buscar").removeClass("active");
	
	
	$("#iconAdiconarServicio").hide("slower");	
	
	
	$('#aAdicionarServicio').attr('onclick',null);
	
	$("#aAdicionarServicio").prop('disabled', true);
	
	$("#aAdicionarServicio").addClass('disabled');	
	
}
//---


//funcion para guardar una factura factura
function guardarFacturaFactura(estadoFactura){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	$("#factura_estado").val(estadoFactura);
	
	if( $("#factura_resolucionfacturador").val() == "" || $("#factura_resolucionfacturador").val() == null ){
		
		$("#div_factura_resolucionfacturador").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_resolucionfacturador").removeClass( "red lighten-3" );
		
	}//fin else	
	
	
	if( $("#factura_metodoPago").val() == "" || $("#factura_metodoPago").val() == null ){
		
		$("#div_factura_metodoPago").addClass( "red lighten-3" );
		sw = 1;
		
	}else{

		$("#div_factura_metodoPago").removeClass( "red lighten-3" );
		
	}//fin else	
	
	
	if($("#idPropietario").val() == "0"){
		
		$("#label_factura_propietario").addClass("active");
		$("#factura_propietario").addClass("invalid");
		sw = 1;
		
	}
	
	if ($('#tabla_nuevaFacturaDetalle >tr').length == 0){
		sw = 1;
	}
	
	if( parseInt( $("#totalFactura").html() ) < 0 ){
		sw = 1;
	}
	

	
	if(sw == 1){
		return false;
	}else{
		
		var swCantidadDescontar = 0;
		
		var len = $('#tabla_nuevaFacturaDetalle >tr').length;
	        				
        $('#tabla_nuevaFacturaDetalle >tr').each(function(index, element) {
	
	
				if($(this).find(".tipo").html() == "Producto"){
					
					var id 				  =  $(this).find(".id").html();
					var cantidadDescontar =  $("#cantidadAdicionarProducto_"+id).val();
					
					
					
					$.ajax({
				  		url: "http://www.nanuvet.com/Controllers/factura/facturas/consultarDisponibilidadCantidadProducto.php",
				  		Async: false,
				        dataType: "html",
				        type : 'POST',
				        data: { 
				        	        	
				        	   id						: id,
				        	   cantidadDescontar		: cantidadDescontar
				        	   
				        	},
				        	success: function(data) {
				        		
				        		if(data == "Mal"){
				        			
				        			$("#cantidadAdicionarProducto_"+id).addClass("invalid");
				        			
				        			swCantidadDescontar = 1;
				        			
				        		}else{
				        			$("#cantidadAdicionarProducto_"+id).removeClass("invalid");
				        		}
				        		
				        		
				        	}							
					});
					
					
					
				}//fin if si es un producto

		 });//fin each tr
		
		
		if(swCantidadDescontar == 0){//si no se tiene problema con la cantidad de ningun producto
			
					$.ajax({
				  		url: "http://www.nanuvet.com/Controllers/factura/facturas/guardarFactura.php",
				  		Async: false,
				        dataType: "html",
				        type : 'POST',
				        data: { 
				        	        	
				        	  	        	        	
				        	   
				        	   factura_idFacturador 			: $("#factura_idFacturador").val(),
				        	   factura_idResolucion				: $("#factura_idResolucion").val(),
				        	   factura_iva						: $("#factura_iva").val(),
				        	   factura_metodoPago				: $("#factura_metodoPago").val(),
				        	   factura_idPropietario			: $("#idPropietario").val(),
				        	   
				        	   factura_observaciones			: $("#factura_observaciones").val(),
				        	   
				        	   factura_valorBruto				: $("#subTotalFactura").html(),
				        	   factura_descuento				: $("#descuentoFactura").html(),
				        	   factura_valorIva					: $("#valorIVAFactura").html(),
				        	   factura_totalFactura				: $("#totalFactura").html(),
				        	   factura_estado					: estadoFactura
				        	   
				        	},
				        	success: function(data) {
				        		
				        		var idFacturaGuardada = data;
				        		
				        		//se recorre el tr para almacenar los detalles de la factura
				        		$('#tabla_nuevaFacturaDetalle >tr').each(function(index, element) {
				        		
				        		
				        				$.ajax({
									  		url: "http://www.nanuvet.com/Controllers/factura/facturas/guardarDetalleFactura.php",
									  		Async: false,
									        dataType: "html",
									        type : 'POST',
									        data: { 
									        	        	
									        	  	   idFactura 	:  idFacturaGuardada,
													   id			:  $(this).find(".id").html(),
													   tipoDetalle	:  $(this).find(".tipo").html(),
													   valorBruto	:  $(this).find(".FF_valorUnitario").html(),
													   descuento	:  $(this).find(".FF_descuento").val(),
													   cantidad		:  $(this).find(".FF_cantidad").val()    	        	
									        	   									        	   
									        	},
									        	success: function() {
									        		
									        		if (index == len - 1) {
											           	$("#listadoFacturas").html($("#preloader").html());
											           	$("#form_nuevaFactura").removeClass("unsavedForm");
											           	location.reload(true);
											          }
									        		
									        											        		
									        	}//fin succes							
										});
				        		
				        		
				        		
				        		});//fin each tr
				        		
				        	}//fin succes							
					});
			
		}//fin if sin problemas con cantidad de productos
		
		
	}//fin else	para enviar factura
	

	
}
//---
