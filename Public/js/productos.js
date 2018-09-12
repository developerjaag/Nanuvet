/*
 * Funciones para el modulo de productos
 */

//mostrar formulario para un nuevo producto
function mostrarFormNuevoProductos(){
	

	$("#hidden_NuevoProducto").show('slower');
	
}
//---


//funcion para buscar un proveedor cuando se está el modal un nuevo producto
function modalPP_buscarProveedor(){
	
	if( $("#modalPP_proveedor").val().trim().length > 0 ){
		$("#modalPP_costo").prop('disabled', false);
	}else{
		
		$("#modalPP_costo").prop('disabled', true);
		$("#modalPP_costo").val("");
		$("#ppIdProveedor").val("0");
		
		$("#label_modalPP_costo").removeClass("active");
		$("#modalPP_costo").removeClass("valid");	
		$("#modalPP_costo").removeClass("invalid");
		
	}
	
	
	  $('#modalPP_proveedor').autocomplete({
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
        		
				$("#ppIdProveedor").val(ui.item.id); 	
				$("#modalPP_proveedor").val(ui.item.value); 	
        			   			
        }
    	
  	}); 
	
	
}
//---


//funcion para buscar un proveedor cuando se está creando un nuevo producto
function creando_buscarProveedor(){
	
	if( $("#proveedor").val().trim().length > 0 ){
		$("#costo").prop('disabled', false);
	}else{
		
		$("#costo").prop('disabled', true);
		$("#costo").val("");
		$("#idProveedor").val("0");
		
		$("#label_costo").removeClass("active");
		$("#costo").removeClass("valid");	
		$("#costo").removeClass("invalid");
		
	}
	
	
	  $('#proveedor').autocomplete({
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
        		
				$("#idProveedor").val(ui.item.id); 	
				$("#proveedor").val(ui.item.value); 	
        			   			
        }
    	
  	}); 
	
	
}
//---

//funcion para liompiar el modal de nuevo proveedor
function limpiarModalNuevoProveedor(){

	
	$("#proveedor_identificativo").val("");
	$("#proveedor_nombre").val("");
	$("#proveedor_telefono1").val("");
	$("#proveedor_telefono2").val("");
	$("#proveedor_celular").val("");
	$("#proveedor_direccion").val("");
	$("#proveedor_email").val("");
	
	$("#label_proveedor_identificativo").removeClass("active");
	$("#label_proveedor_nombre").removeClass("active");
	$("#label_proveedor_telefono1").removeClass("active");
	$("#label_proveedor_telefono2").removeClass("active");
	$("#label_proveedor_celular").removeClass("active");
	$("#label_proveedor_direccion").removeClass("active");
	$("#label_proveedor_email").removeClass("active");
	
	$("#proveedor_identificativo").removeClass("valid");
	$("#proveedor_nombre").removeClass("valid");
	$("#proveedor_telefono1").removeClass("valid");
	$("#proveedor_telefono2").removeClass("valid");
	$("#proveedor_celular").removeClass("valid");
	$("#proveedor_direccion").removeClass("valid");
	$("#proveedor_email").removeClass("valid");
	
	$("#proveedor_identificativo").removeClass("invalid");
	$("#proveedor_nombre").removeClass("invalid");
	$("#proveedor_telefono1").removeClass("invalid");
	$("#proveedor_telefono2").removeClass("invalid");
	$("#proveedor_celular").removeClass("invalid");
	$("#proveedor_direccion").removeClass("invalid");
	$("#proveedor_email").removeClass("invalid");	

	
}
//---

//funcion para guardar un proveedor desde el modal
function guardarNuevoProveedor(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#proveedor_identificativo").val().trim().length == 0 ){
		
		$("#label_proveedor_identificativo").addClass( "active" );
		$("#proveedor_identificativo").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#proveedor_nombre").val().trim().length == 0 ){
		
		$("#label_proveedor_nombre").addClass( "active" );
		$("#proveedor_nombre").addClass( "invalid" );
		sw = 1;
	}	
	
	if( $("#proveedor_email").val().trim().length != 0 ){
		
		if($("#proveedor_email").val().indexOf('@', 0) == -1 || $("#proveedor_email").val().indexOf('.', 0) == -1) {
            $("#label_proveedor_email").addClass( "active" );
			$("#proveedor_email").addClass( "invalid" );
			sw = 1;
        }	
		
	}
	
	if(sw == 1){
		return false;
	}else{
		
		
			$.ajax({
		  		url: "http://www.nanuvet.com/Controllers/proveedores/guardarProveedorModal.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	identificativo:	$("#proveedor_identificativo").val(),
					nombre:			$("#proveedor_nombre").val(),
					telefono1:		$("#proveedor_telefono1").val(),
					telefono2:		$("#proveedor_telefono2").val(),
					celular:		$("#proveedor_celular").val(),
					direccion:		$("#proveedor_direccion").val(),
					email:			$("#proveedor_email").val()
		        	
		        	},
		        success: function(data) {	
		        	$('#modal_nuevoProveedor').closeModal();		
		        	Materialize.toast(data, 5000);
		        }//fin success
		  	});	
		
		
	}	
	
}
//---


//validar el guardado de un nuevo producto
function validarGuardadoNuevoProducto(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#nombre").val().trim().length == 0 ){
		
		$("#label_nombre").addClass( "active" );
		$("#nombre").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#codigo").val().trim().length == 0 ){
		
		$("#label_codigo").addClass( "active" );
		$("#codigo").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#precio").val().trim().length == 0 ){
		
		$("#label_precio").addClass( "active" );
		$("#precio").addClass( "invalid" );
		sw = 1;
	}	
	
	if( ($("#categoria").val() == "") || ($("#categoria").val() == null) ){
		
		$("#errorGuardarProducto").html($("#textoErrorGuardarProducto").html());
		sw = 1;
	}else{
		$("#errorGuardarProducto").html("&nbsp;");
	}	
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoProducto").submit();
	}	
		
}
//---


//cancelar el guardado de un nuevo producto
function cancelarGuardadoNuevoProducto(){
	
	$("#hidden_NuevoProducto").hide('slower');
	
	$("#idProveedor").val("0")
	$("#nombre").val("");
	$("#codigo").val("");
	$("#precio").val("");
	$("#proveedor").val("");
	$("#categoria").val("");
	$("#descripcion").val("");
	$("#errorGuardarProducto").html("&nbsp;");
	
			
	$("#costo").prop('disabled', true);
	$("#costo").val("");
	

	$("#label_nombre").removeClass("active");
	$("#label_codigo").removeClass("active");
	$("#label_precio").removeClass("active");
	$("#label_proveedor").removeClass("active");
	$("#label_categoria").removeClass("active");
	$("#label_descripcion").removeClass("active");
	$("#label_costo").removeClass("active");
	
	
	$("#nombre").removeClass("valid");
	$("#codigo").removeClass("valid");
	$("#precio").removeClass("valid");
	$("#proveedor").removeClass("valid");
	$("#categoria").removeClass("valid");
	$("#descripcion").removeClass("valid");
	$("#costo").removeClass("valid");	
	
	
	$("#nombre").removeClass("invalid");
	$("#codigo").removeClass("invalid");
	$("#precio").removeClass("invalid");
	$("#proveedor").removeClass("invalid");
	$("#categoria").removeClass("invalid");
	$("#email").removeClass("invalid");	
	$("#costo").removeClass("invalid");
}
//---

//generar un codigo aleatorio
function generarCodigodigo(idCampo){
	
	var numeros = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
	var letras  = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "W", "X", "Y", "Z" ];
	var ln = 0;
	var n  = 0;
	var l  = 0;
	var string = "";
	
	for(var i = 0; i < 10; i++){
		
		ln = (Math.floor(Math.random() * 2) + 1);
		
		if(ln == 1){
			
			n = (Math.floor(Math.random() * 9) + 1);
			string = string+numeros[n];
			
		}else{
			l = (Math.floor(Math.random() * 24) + 1);
			string = string+letras[l];
		}
		

		
	}//fin for
	
		$("#"+idCampo).val(string);
		$("#label_"+idCampo).addClass( "active" );	
}
//---


//funcion para desactivar un producto
function desactivarProducto(idProducto){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/productos/desactivarProducto.php",
        dataType: "html",
        type : 'POST',
        data: { idProducto : idProducto },
        success: function(data) {			

			$('#spanP_'+idProducto).html('<a id="'+idProducto+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarProducto(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	

	
}
//----


//funcion para editar un producto
function editarProducto(idProducto,codigo,descripcion,nombre,nombreCategoria,idCategoria,precio){

	cancelarGuardadoNuevoProducto();
	
	$("#editar_idProducto").val(idProducto);
	$("#editar_nombre").val(nombre);
	$("#editar_codigo").val(codigo);
	$("#editar_precio").val(precio);
	$("#editar_categoria").val(idCategoria);
	$("#editar_descripcion").val(descripcion);
	
	$("#label_editar_nombre").addClass("active");
	$("#label_editar_codigo").addClass("active");
	$("#label_editar_precio").addClass("active");
	$("#label_editar_descripcion").addClass("active");
	
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarProducto").show('slower');

	
}
//---

//funcion para cancelar la edicion de un producto
function cancelarEdicionProducto(){

	
	$("#hidden_editarProducto").hide('slower');
	$("#tituloLi").show('slower');
	
	$("#label_editar_nombre").removeClass("active");
	$("#label_editar_codigo").removeClass("active");
	$("#label_editar_precio").removeClass("active");
	$("#label_editar_descripcion").removeClass("active");


	$("#editar_idProducto").val("0");
	$("#editar_nombre").val("");
	$("#editar_codigo").val("");
	$("#editar_precio").val("");
	$("#editar_categoria").val("");
	$("#editar_descripcion").val("");


	$("#editar_nombre").removeClass("invalid");
	$("#editar_codigo").removeClass("invalid");
	$("#editar_precio").removeClass("invalid");
	$("#editar_descripcion").removeClass("invalid");
	
	$("#editar_nombre").removeClass("valid");
	$("#editar_codigo").removeClass("valid");
	$("#editar_precio").removeClass("valid");
	$("#editar_descripcion").removeClass("valid");


	
}


//funcion para validar la edicion de un producto
function comprobarEdicionProducto(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#editar_nombre").val().trim().length == 0 ){
		
		$("#label_editar_nombre").addClass( "active" );
		$("#editar_nombre").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#editar_codigo").val().trim().length == 0 ){
		
		$("#label_editar_codigo").addClass( "active" );
		$("#editar_codigo").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#editar_precio").val().trim().length == 0 ){
		
		$("#label_editar_precio").addClass( "active" );
		$("#editar_precio").addClass( "invalid" );
		sw = 1;
	}	
	
	if( ($("#editar_categoria").val() == "") || ($("#editar_categoria").val() == null) ){
		
		$("#editar_errorGuardarProducto").html($("#editar_textoErrorGuardarProducto").html());
		sw = 1;
	}else{
		$("#editar_errorGuardarProducto").html("&nbsp;");
	}	
	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarProducto").submit();
	}	
		

	
}
//---


//funcion para activar un producto
function activarProducto(idProducto){

	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/productos/activarProducto.php",
        dataType: "html",
        type : 'POST',
        data: { idProducto : idProducto },
        success: function(data) {			

			$('#spanP_'+idProducto).html('<a id="'+idProducto+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarProducto(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	

	
}
//----




//funcion para buscar un producto en especifico
function buscarProducto(){

 $('#buscarProducto').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/productos/buscarProducto.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringProducto : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idProductoBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/productos/mostrarBusquedaProducto.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idProducto : $("#idProductoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoProductosAjax").html(data);
						
						$("#resultadoProductos").hide('slower');	   
						$("#resultadoProductosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});  
						//para cargar los modales
						$('.modal-trigger').leanModal();            
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   

	
}
//---


//funcion para cerrar la busqueda de un producto
function cerrarBusquedaProducto(){
	
	$("#resultadoProductosAjax").hide('slower');
	$("#buscarProducto").val("");	
	$("#buscarProducto").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoProductos").show('slower');
	
}
//---

//funcion para consultar los vinculos que tenga un producto con un proveedor
function consultarVinculosProdcutoProveedor(idProducto, nombreProducto){
	
		//se limpian los campos
		$("#ppIdProveedor").val("0");
		$("#modalPP_costo").val("");
		$("#modalPP_proveedor").val("");
		
		$("#label_modalPP_costo").removeClass("active");
		$("#label_modalPP_proveedor").removeClass("active");
		
		$("#modalPP_costo").removeClass("invalid");
		$("#modalPP_proveedor").removeClass("invalid");
		
		$("#modalPP_costo").removeClass("valid");	
		$("#modalPP_proveedor").removeClass("valid");	
		
		$("#modalPP_costo").prop('disabled', true);
	
	
	
		$("#pp_nombreProducto").html(nombreProducto);
		$("#ppIdProducto").val(idProducto);
	
		 $.ajax({
		  		url: "http://www.nanuvet.com/Controllers/productos/vinculosProductosProveedor.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idProducto:	idProducto
		        	
		        	},
		        success: function(data) {	
		        	$('#resultadoProductoProveedores').html(data);
		        }//fin success
		  	});	
	
}
//---


//funcion para guardar el vinculo entre un producto y un proveedor
function guardarProductoProveedor(){
	
	var idProducto 		= $("#ppIdProducto").val();
	var nombreProducto 	= $("#pp_nombreProducto").html();
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#ppIdProveedor").val() == "0" ){
		
		$("#label_modalPP_proveedor").addClass( "active" );
		$("#modalPP_proveedor").addClass( "invalid" );
		sw = 1;
	}	

	
	if( $("#modalPP_costo").val().trim().length == 0 ){
		
		$("#label_modalPP_costo").addClass( "active" );
		$("#modalPP_costo").addClass( "invalid" );
		sw = 1;
	}	
	
	if(sw == 1){
		return false;
	}else{
			 $.ajax({
		  		url: "http://www.nanuvet.com/Controllers/productos/guardarVinculoProductoProveedor.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idProducto:	$("#ppIdProducto").val(), idProveedor: $("#ppIdProveedor").val(), costo: $("#modalPP_costo").val()
		        	
		        	},
		        success: function(data) {	
		        	
		        	if(data == 'Existe'){
		        		$("#proveedor_errorGuardarProveedorProducto").html($("#proveedor_textoErrorProveedorProducto").html());
		        	}else{
		        		$("#proveedor_errorGuardarProveedorProducto").html('&nbsp;');
		        		consultarVinculosProdcutoProveedor(idProducto, nombreProducto);
		        	}
		        	
		        }//fin success
		  	});	
	}		
	

	
}
//---



//funcion para editar un vinculo entre un proveedor y unproducto
function editarVinculoProductoProveedor(idProductoProveedor, costo, identificativo, nombreProveedor ){
	
	$("#idEditarProductoProveedor").val(idProductoProveedor);
	$("#modalPP_editarProveedor").val(identificativo+" "+nombreProveedor);
	$("#modalPP_editarCosto").val(costo);
	
	$("#label_modalPP_editarProveedor").addClass("active");
	$("#label_modalPP_editarCosto").addClass("active");	
	
	$("#modalPP_editarProveedor").removeClass("valid");		
	$("#modalPP_editarCosto").removeClass("invalid");
	
	$("#modalPP_editarProveedor").removeClass("valid");		
	$("#modalPP_editarCosto").removeClass("valid");
	
	$("#hidden_crearVinculoProveedorProducto").hide("slower");
	$("#hieden_editarPP").show("slower");

}
//---

//funcion para cancelar la edicion de de un vinculo producto proveedor
function cancelarEditarVinculoProductoProveedor(){
	
	$("#idEditarProductoProveedor").val("0");
	$("#hieden_editarPP").hide("slower");
	$("#hidden_crearVinculoProveedorProducto").show("slower");
	
}
//----

//funcion para guardar la edicion de un vinculo con un proveedor
function guardarEdicionVinculoProductoProveedor(){

	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#modalPP_editarCosto").val().trim().length == 0 ){
		
		$("#label_modalPP_editarCosto").addClass( "active" );
		$("#modalPP_editarCosto").addClass( "invalid" );
		sw = 1;
	}	
	
	if(sw == 1){
		return false;
	}else{
		
			var idProducto 		= $("#ppIdProducto").val();
			var nombreProducto 	= $("#pp_nombreProducto").html();
		
			 $.ajax({
		  		url: "http://www.nanuvet.com/Controllers/productos/editarVinculoProductoProveedor.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idProductosProveedores:	$("#idEditarProductoProveedor").val(), costo: $("#modalPP_editarCosto").val()
		        	
		        	},
		        success: function() {	
		        	consultarVinculosProdcutoProveedor(idProducto, nombreProducto);
		        	cancelarEditarVinculoProductoProveedor();
		        }//fin success
		  	});	
	}	
	
}
//---


//metodo para consultar el stock de un producto en las distintas sucursales
function consultarStockProdcuto(idProducto, nombreProducto, clickFuncion){

	cerrarEdicionStock();
	cancelarNuevaEntrada();

	if(clickFuncion != 'funcion'){
		
		$("#stock_errorGuardarStock").html("&nbsp;");
	}

	$("#stock_sucursal").val("");
	
  	$('#stock_sucursal').material_select('destroy');
  	$('#stock_sucursal').material_select();
  	
  	$("#stock_cantidad").val("");
  	$("#stock_minimo").val("");
  	
  	$("#label_stock_cantidad").removeClass("active");
  	$("#label_stock_minimo").removeClass("active");	
			
	$("#stock_cantidad").removeClass("invalid");
	$("#stock_minimo").removeClass("invalid");
	
	$("#stock_cantidad").removeClass("valid");	
	$("#stock_minimo").removeClass("valid");	
	
	
            

	$("#stock_idProducto").val(idProducto);
	$("#ps_nombreProducto").html(nombreProducto);
	
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/productos/consultarStockProductoSucursal.php",
        dataType: "html",
        type : 'POST',
        data: { 
        	
        	idProducto:	idProducto
        	
        	},
        success: function(data) {	
        	$("#resultadoStock").html(data);
        	$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});	
	
}
//---

//funcion para guardar un nuevo stock
function guardarNuevoStock(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( ($("#stock_sucursal").val() == "") || ($("#stock_sucursal").val() == null) ){
		
		$("#stock_errorGuardarStock").html($("#stock_textoErrorGuardarStock").html());
		
		sw = 1;
	}else{
		$("#stock_errorGuardarStock").html("&nbsp;");
	}

	
	if( $("#stock_cantidad").val().trim().length == 0 ){
		
		$("#label_stock_cantidad").addClass( "active" );
		$("#stock_cantidad").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#stock_minimo").val().trim().length == 0 ){
		
		$("#label_stock_minimo").addClass( "active" );
		$("#stock_minimo").addClass( "invalid" );
		sw = 1;
	}	

	
	if(sw == 1){
		return false;
	}else{
		
			var idProducto 		= $("#stock_idProducto").val();
			var nombreProducto	= $("#ps_nombreProducto").html();
			
			 $.ajax({
		  		url: "http://www.nanuvet.com/Controllers/productos/guardarStockProductoSucursal.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idProducto:	idProducto, idSucursal: $("#stock_sucursal").val(), cantidad: $("#stock_cantidad").val(), cantidadMinima: $("#stock_minimo").val()
		        	
		        	},
		        success: function(data) {
		        	if(data == 'Existe'){
		        		$("#stock_errorGuardarStock").html($("#stock_textoErrorVinculandoStock").html());
		        	}else{
		        		consultarStockProdcuto(idProducto, nombreProducto,'funcion');
		        	}	
		        	
		        }//fin success
		  	});	
	}		
	
}
//---

//funcion para editar el stock de un producto en una sucursal
function editarStockProductoSucursal(idProductoSucursal, cantidad, stockMinimo, idSucursal){
	
	$("#editar_idProductoSucursal").val(idProductoSucursal);
	$("#editar_stock_cantidad").val(cantidad);
	$("#editar_stock_minimo").val(stockMinimo);
	$("#editar_stock_sucursal").val(idSucursal);

  	$('#editar_stock_sucursal').material_select('destroy');
  	$('#editar_stock_sucursal').material_select();	

  	$("#label_editar_stock_cantidad").addClass("active");
  	$("#label_editar_stock_minimo").addClass("active");	
  	

	$("#stock_sucursal").val("");
	
  	$('#stock_sucursal').material_select('destroy');
  	$('#stock_sucursal').material_select();
  	
  	$("#stock_cantidad").val("");
  	$("#stock_minimo").val("");
  	
  	$("#label_stock_cantidad").removeClass("active");
  	$("#label_stock_minimo").removeClass("active");	
			
	$("#stock_cantidad").removeClass("invalid");
	$("#stock_minimo").removeClass("invalid");
	
	$("#stock_cantidad").removeClass("valid");	
	$("#stock_minimo").removeClass("valid");	
	
	$("#stock_errorGuardarStock").html("&nbsp;");  	
  	
  	$("#divCrearNuevoStock").hide("slower");
  	$("#divEditarStock").show("slower");
	
}
//---


//funcion para cancelar la edicion de un stock
function cerrarEdicionStock(){

  	$("#divEditarStock").hide("slower");
  	$("#divCrearNuevoStock").show("slower");
  	
	$("#editar_idProductoSucursal").val("0");
	$("#editar_stock_cantidad").val("");
	$("#editar_stock_minimo").val("");
	$("#editar_stock_sucursal").val("");  	

  	$('#editar_stock_sucursal').material_select('destroy');
  	$('#editar_stock_sucursal').material_select();


  	$("#label_editar_stock_cantidad").removeClass("active");
  	$("#label_editar_stock_minimo").removeClass("active");	
			
	$("#editar_stock_cantidad").removeClass("invalid");
	$("#editar_stock_minimo").removeClass("invalid");
	
	$("#editar_stock_cantidad").removeClass("valid");	
	$("#editar_stock_minimo").removeClass("valid");	
	
	$("#stock_editar_errorGuardarStock").html("&nbsp;");  
	
}
//---

//funcin para comprobar la edicion de un stock
function validarEdicionStock(){
	
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( ($("#editar_stock_sucursal").val() == "") || ($("#editar_stock_sucursal").val() == null) ){
		
		$("#editar_stock_errorGuardarStock").html($("#editar_stock_textoErrorGuardarStock").html());
		
		sw = 1;
	}else{
		$("#editar_stock_errorGuardarStock").html("&nbsp;");
	}

	
	if( $("#editar_stock_cantidad").val().trim().length == 0 ){
		
		$("#label_editar_stock_cantidad").addClass( "active" );
		$("#editar_stock_cantidad").addClass( "invalid" );
		sw = 1;
	}	

	if( $("#editar_stock_minimo").val().trim().length == 0 ){
		
		$("#label_editar_stock_minimo").addClass( "active" );
		$("#editar_stock_minimo").addClass( "invalid" );
		sw = 1;
	}	

	
	if(sw == 1){
		return false;
	}else{
		
			var idProducto 		= $("#stock_idProducto").val();
			var nombreProducto	= $("#ps_nombreProducto").html();
			var idProductoSucursal = $("#editar_idProductoSucursal").val();
			
			 $.ajax({
		  		url: "http://www.nanuvet.com/Controllers/productos/editarStockProductoSucursal.php",
		        dataType: "html",
		        type : 'POST',
		        data: { 
		        	
		        	idProductoSucursal: idProductoSucursal, idProducto:	idProducto, idSucursal: $("#editar_stock_sucursal").val(), cantidad: $("#editar_stock_cantidad").val(), cantidadMinima: $("#editar_stock_minimo").val()
		        	
		        	},
		        success: function() {	
		        	
			        	consultarStockProdcuto(idProducto, nombreProducto, 'funcion');
		        		cerrarEdicionStock();;
		        	
		        }//fin success
		  	});	
	}			
	
	
}
//---



//metodo para activar o inactivar los campos de la vinculacion de vacunas
function VactivarInactivarCampos(idCheckbox){

	var contador = idCheckbox.split("_");
	contador = contador[1];


    	$("#Vcodigo_"+contador).val("");
    	$("#Vprecio_"+contador).val("");
    	$("#Vcategoria_"+contador).val("");
    	
	
	//verificar si el check esta seleccionado
	if( $('#'+idCheckbox).prop('checked') ) {    
			
    	$("#Vcodigo_"+contador).prop('disabled', false);
    	$("#Vprecio_"+contador).prop('disabled', false);
    	$("#Vcategoria_"+contador).prop('disabled', false);
    	
	}else{

	  	$("#label_Vcodigo_"+contador).removeClass("active");	
	  	$("#label_Vprecio_"+contador).removeClass("active");	
	  	$("#btnGenerarCodigo_"+contador).removeClass("active");	
				
		$("#Vcodigo_"+contador).removeClass("invalid");
		$("#Vprecio_"+contador).removeClass("invalid");
		
		$("#Vcodigo_"+contador).removeClass("valid");	
		$("#Vprecio_"+contador).removeClass("valid");	

    	$("#Vcodigo_"+contador).prop('disabled', true);
    	$("#Vprecio_"+contador).prop('disabled', true);
    	$("#Vcategoria_"+contador).prop('disabled', true);   
    	$("#errorReplicarVacunas_"+contador).html('&nbsp;'); 			
		
	}
	
}
//---

//funcion para aplicar codigos aleatorios a todos los items de vacunas
function replicarCodigosCabeceraVacunas(){
	
	$('.checkVacunas').each(
	    function() {
	        var id = this.id;
	        
	        	var contador = id.split("_");
				contador = contador[1];
				
				generarCodigodigo('Vcodigo_'+contador);
	 
	    	}
	);
	
	
}
//---

//replicar todas las opciones de cabecera en tododos los imtems de vacunas a vincular
function replicarCabeceraVincularVacunas(){
	
		
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#cabeceraV_precio").val().trim().length == 0 ){
		
		$("#label_cabeceraV_precio").addClass( "active" );
		$("#cabeceraV_precio").addClass( "invalid" );
		sw = 1;
	}	


	if( ($("#cabeceraV_categoria").val() == "") || ($("#cabeceraV_categoria").val() == null) ){
		
		$("#errorReplicarVacunas").html($("#textoErrorReplicarVacunas").html());
		
		sw = 1;
	}else{
		$("#errorReplicarVacunas").html("&nbsp;");
	}	

	if(sw == 1){
		return false;
	}else{
		
		$('.checkVacunas').each(
		    function() {
		        var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					$('.checkVacunas').prop('checked', true);
					
					
					$("#Vcodigo_"+contador).prop('disabled', false);
			    	$("#Vprecio_"+contador).prop('disabled', false);
			    	$("#Vcategoria_"+contador).prop('disabled', false);

					$("#label_Vcodigo_"+contador).addClass("active");	
	  				$("#label_Vprecio_"+contador).addClass("active");

			    	$("#Vprecio_"+contador).val($("#cabeceraV_precio").val());
			    	$("#Vcategoria_"+contador).val($("#cabeceraV_categoria").val());
		 
		    	}
		);		
				
	}//fin else
	
}
//---


//funcion para guardar la vinculacion de las vacunas
function guardarVinculacionVacunas(){
	
		$('.checkVacunas').each(
		    function() {
		    	
		        	var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					
					var sw = 0;
					
					//saber si el item esta seleccionado
					if( $('#'+id).is(':checked') ) {
						
						if( $("#Vcodigo_"+contador).val().trim().length == 0 ){
		
							$("#label_Vcodigo_"+contador).addClass( "active" );
							$("#Vcodigo_"+contador).addClass( "invalid" );
							sw = 1;
						}							
					    

						if( $("#Vprecio_"+contador).val().trim().length == 0 ){
		
							$("#label_Vprecio_"+contador).addClass( "active" );
							$("#Vprecio_"+contador).addClass( "invalid" );
							sw = 1;
						}	
						
						if( ($("#Vcategoria_"+contador).val() == "") || ($("#Vcategoria_"+contador).val() == null) ){
	
							$("#errorReplicarVacunas_"+contador).html($("#textoErrorReplicarVacunas_"+contador).html());
							
							sw = 1;
						}else{
							$("#errorReplicarVacunas_"+contador).html("&nbsp;");
						}
						
						if(sw == 0){
							
							
							 $.ajax({
							  		url: "http://www.nanuvet.com/Controllers/productos/guardarProductoPorVinculo.php",
							        dataType: "html",
							        type : 'POST',
							        data: { 
							        	
							        		nombre: 		$("#Vnombre_"+contador).html(),
							        		descripcion: 	$("#Vdescripcion_"+contador).html(),
							        		codigo: 		$("#Vcodigo_"+contador).val(),
							        		precio: 		$("#Vprecio_"+contador).val(),
							        		categoria: 		$("#Vcategoria_"+contador).val(),
							        		tipoExterno:	'Vacuna',
							        		idExterno:		$("#idTablaVacuna_"+contador).val()
							        	
							        	},
							        success: function() {	
							        	$('#tr_'+contador).remove();
							        }//fin success
							  	});	
							
							
							
						}//fin si todo va bien sw = 0	

					    
					}//fin saber si el item esta seleccionado
					

					
		 
		    	}//fin funcion anonima
		);		
	
	
}
//---



//funcion para replicar los codigos de cabecera a los items de medicamentos
function replicarCodigosCabeceraMedicamentos(){

	
	$('.checkMedicamentos').each(
	    function() {
	        var id = this.id;
	        
	        	var contador = id.split("_");
				contador = contador[1];
				
				generarCodigodigo('Mcodigo_'+contador);
	 
	    	}
	);

	
}
//----


//replicar los datos de cabecera a los items de medicamentos
function replicarCabeceraVincularMedicamentos(){
	
	
		
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#cabeceraM_precio").val().trim().length == 0 ){
		
		$("#label_cabeceraM_precio").addClass( "active" );
		$("#cabeceraM_precio").addClass( "invalid" );
		sw = 1;
	}	


	if( ($("#cabeceraM_categoria").val() == "") || ($("#cabeceraM_categoria").val() == null) ){
		
		$("#errorReplicarMedicamentos").html($("#textoErrorReplicarMedicamentos").html());
		
		sw = 1;
	}else{
		$("#errorReplicarMedicamentos").html("&nbsp;");
	}	

	if(sw == 1){
		return false;
	}else{
		
		$('.checkMedicamentos').each(
		    function() {
		        var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					$('.checkMedicamentos').prop('checked', true);
					
					
					$("#Mcodigo_"+contador).prop('disabled', false);
			    	$("#Mprecio_"+contador).prop('disabled', false);
			    	$("#Mcategoria_"+contador).prop('disabled', false);

					$("#label_Mcodigo_"+contador).addClass("active");	
	  				$("#label_Mprecio_"+contador).addClass("active");

			    	$("#Mprecio_"+contador).val($("#cabeceraM_precio").val());
			    	$("#Mcategoria_"+contador).val($("#cabeceraM_categoria").val());
		 
		    	}
		);		
				
	}//fin else
		
	
}
//---


//metodo para activar o inactivar los campos de la vinculacion de medicamentos
function MactivarInactivarCampos(idCheckbox){

	var contador = idCheckbox.split("_");
	contador = contador[1];


    	$("#Mcodigo_"+contador).val("");
    	$("#Mprecio_"+contador).val("");
    	$("#Mcategoria_"+contador).val("");
    	
	
	//verificar si el check esta seleccionado
	if( $('#'+idCheckbox).prop('checked') ) {    
			
    	$("#Mcodigo_"+contador).prop('disabled', false);
    	$("#Mprecio_"+contador).prop('disabled', false);
    	$("#Mcategoria_"+contador).prop('disabled', false);
    	
	}else{

	  	$("#label_Mcodigo_"+contador).removeClass("active");	
	  	$("#label_Mprecio_"+contador).removeClass("active");	
	  	$("#MbtnGenerarCodigo_"+contador).removeClass("active");	
				
		$("#Mcodigo_"+contador).removeClass("invalid");
		$("#Mprecio_"+contador).removeClass("invalid");
		
		$("#Mcodigo_"+contador).removeClass("valid");	
		$("#Mprecio_"+contador).removeClass("valid");	

    	$("#Mcodigo_"+contador).prop('disabled', true);
    	$("#Mprecio_"+contador).prop('disabled', true);
    	$("#Mcategoria_"+contador).prop('disabled', true);   
    	$("#errorReplicarMedicamentos_"+contador).html('&nbsp;'); 			
		
	}
	
}
//---



//funcion para guardar la vinculacion de las vacunas
function guardarVinculacionMedicamentos(){
	
		$('.checkMedicamentos').each(
		    function() {
		    	
		        	var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					
					var sw = 0;
					
					//saber si el item esta seleccionado
					if( $('#'+id).is(':checked') ) {
						
						if( $("#Mcodigo_"+contador).val().trim().length == 0 ){
		
							$("#label_Mcodigo_"+contador).addClass( "active" );
							$("#Mcodigo_"+contador).addClass( "invalid" );
							sw = 1;
						}							
					    

						if( $("#Mprecio_"+contador).val().trim().length == 0 ){
		
							$("#label_Mprecio_"+contador).addClass( "active" );
							$("#Mprecio_"+contador).addClass( "invalid" );
							sw = 1;
						}	
						
						if( ($("#Mcategoria_"+contador).val() == "") || ($("#Mcategoria_"+contador).val() == null) ){
	
							$("#errorReplicarMedicamentos_"+contador).html($("#textoErrorReplicarmedicamentos_"+contador).html());
							
							sw = 1;
						}else{
							$("#errorReplicarMedicamentos_"+contador).html("&nbsp;");
						}
						
						if(sw == 0){
							
							
							 $.ajax({
							  		url: "http://www.nanuvet.com/Controllers/productos/guardarProductoPorVinculo.php",
							        dataType: "html",
							        type : 'POST',
							        data: { 
							        	
							        		nombre: 		$("#Mnombre_"+contador).html(),
							        		descripcion: 	$("#Mdescripcion_"+contador).html(),
							        		codigo: 		$("#Mcodigo_"+contador).val(),
							        		precio: 		$("#Mprecio_"+contador).val(),
							        		categoria: 		$("#Mcategoria_"+contador).val(),
							        		tipoExterno:	'Medicamento',
							        		idExterno:		$("#idTablaMedicamento_"+contador).val()
							        	
							        	},
							        success: function() {	
							        	$('#Mtr_'+contador).remove();
							        }//fin success
							  	});	
							
							
							
						}//fin si todo va bien sw = 0	

					    
					}//fin saber si el item esta seleccionado
					

					
		 
		    	}//fin funcion anonima
		);		
	
	
}
//---














//funcion para replicar los codigos de cabecera a los items de desparasitantes
function replicarCodigosCabeceraDesparasitantes(){

	
	$('.checkDesparasitantes').each(
	    function() {
	        var id = this.id;
	        
	        	var contador = id.split("_");
				contador = contador[1];
				
				generarCodigodigo('Dcodigo_'+contador);
	 
	    	}
	);

	
}
//----


//replicar los datos de cabecera a los items de desparasitantes
function replicarCabeceraVincularDesparasitantes(){
	
	
		
	var sw = 0; // variable para determinar si existen campos sin diligenciar
	
	if( $("#cabeceraD_precio").val().trim().length == 0 ){
		
		$("#label_cabeceraD_precio").addClass( "active" );
		$("#cabeceraD_precio").addClass( "invalid" );
		sw = 1;
	}	


	if( ($("#cabeceraD_categoria").val() == "") || ($("#cabeceraD_categoria").val() == null) ){
		
		$("#errorReplicarDesparasitantes").html($("#textoErrorReplicarDesparasitantes").html());
		
		sw = 1;
	}else{
		$("#errorReplicarDesparasitantes").html("&nbsp;");
	}	

	if(sw == 1){
		return false;
	}else{
		
		$('.checkDesparasitantes').each(
		    function() {
		        var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					$('.checkDesparasitantes').prop('checked', true);
					
					
					$("#Dcodigo_"+contador).prop('disabled', false);
			    	$("#Dprecio_"+contador).prop('disabled', false);
			    	$("#Dcategoria_"+contador).prop('disabled', false);

					$("#label_Dcodigo_"+contador).addClass("active");	
	  				$("#label_Dprecio_"+contador).addClass("active");

			    	$("#Dprecio_"+contador).val($("#cabeceraD_precio").val());
			    	$("#Dcategoria_"+contador).val($("#cabeceraD_categoria").val());
		 
		    	}
		);		
				
	}//fin else
		
	
}
//---


//metodo para activar o inactivar los campos de la vinculacion de desparasitantes
function DactivarInactivarCampos(idCheckbox){

	var contador = idCheckbox.split("_");
	contador = contador[1];


    	$("#Dcodigo_"+contador).val("");
    	$("#Dprecio_"+contador).val("");
    	$("#Dcategoria_"+contador).val("");
    	
	
	//verificar si el check esta seleccionado
	if( $('#'+idCheckbox).prop('checked') ) {    
			
    	$("#Dcodigo_"+contador).prop('disabled', false);
    	$("#Dprecio_"+contador).prop('disabled', false);
    	$("#Dcategoria_"+contador).prop('disabled', false);
    	
	}else{

	  	$("#label_Dcodigo_"+contador).removeClass("active");	
	  	$("#label_Dprecio_"+contador).removeClass("active");	
	  	$("#DbtnGenerarCodigo_"+contador).removeClass("active");	
				
		$("#Dcodigo_"+contador).removeClass("invalid");
		$("#Dprecio_"+contador).removeClass("invalid");
		
		$("#Dcodigo_"+contador).removeClass("valid");	
		$("#Dprecio_"+contador).removeClass("valid");	

    	$("#Dcodigo_"+contador).prop('disabled', true);
    	$("#Dprecio_"+contador).prop('disabled', true);
    	$("#Dcategoria_"+contador).prop('disabled', true);   
    	$("#errorReplicarDesparasitantes_"+contador).html('&nbsp;'); 			
		
	}
	
}
//---



//funcion para guardar la vinculacion de los desparasitantes
function guardarVinculacionDesparasitantes(){
	
		$('.checkDesparasitantes').each(
		    function() {
		    	
		        	var id = this.id;
		        
		        	var contador = id.split("_");
					contador = contador[1];
					
					var sw = 0;
					
					//saber si el item esta seleccionado
					if( $('#'+id).is(':checked') ) {
						
						if( $("#Dcodigo_"+contador).val().trim().length == 0 ){
		
							$("#label_Dcodigo_"+contador).addClass( "active" );
							$("#Dcodigo_"+contador).addClass( "invalid" );
							sw = 1;
						}							
					    

						if( $("#Dprecio_"+contador).val().trim().length == 0 ){
		
							$("#label_Dprecio_"+contador).addClass( "active" );
							$("#Dprecio_"+contador).addClass( "invalid" );
							sw = 1;
						}	
						
						if( ($("#Dcategoria_"+contador).val() == "") || ($("#Dcategoria_"+contador).val() == null) ){
	
							$("#errorReplicarDesparasitantes_"+contador).html($("#textoErrorReplicarDesparasitantes_"+contador).html());
							
							sw = 1;
						}else{
							$("#errorReplicarDesparasitantes_"+contador).html("&nbsp;");
						}
						
						if(sw == 0){
							
							
							 $.ajax({
							  		url: "http://www.nanuvet.com/Controllers/productos/guardarProductoPorVinculo.php",
							        dataType: "html",
							        type : 'POST',
							        data: { 
							        	
							        		nombre: 		$("#Dnombre_"+contador).html(),
							        		descripcion: 	$("#Ddescripcion_"+contador).html(),
							        		codigo: 		$("#Dcodigo_"+contador).val(),
							        		precio: 		$("#Dprecio_"+contador).val(),
							        		categoria: 		$("#Dcategoria_"+contador).val(),
							        		tipoExterno:	'Desparasitante',
							        		idExterno:		$("#idTablaDesparasitante_"+contador).val()
							        	
							        	},
							        success: function() {	
							        	$('#Dtr_'+contador).remove();
							        }//fin success
							  	});	
							
							
							
						}//fin si todo va bien sw = 0	

					    
					}//fin saber si el item esta seleccionado
					

					
		 
		    	}//fin funcion anonima
		);		
	
	
}
//---


//****entradas de productos****//


//funcion para abrir el formulario para adiciona runa nueva entrada
function abrirFormAdicionarEntrada(idSucursal,idProducto,nitSucursal,nombreSucursal){
	
	cerrarEdicionStock();
	$("#divCrearNuevoStock").hide("slower");
	
	
	$("#nuevaEntrada_idSucursal").val(idSucursal);
	$("#nuevaEntrada_idProducto").val(idProducto);
	
	$("#nuevaEntrada_nombreSucursal").html("("+nitSucursal+") "+nombreSucursal);
	
	
	//se consultan los proveedores del producto
	$.ajax({
	  		url: "http://www.nanuvet.com/Controllers/productos/consultarProveedoresProducto.php",
	        dataType: "html",
	        type : 'POST',
	        data: { 
	        	
	        		idProducto: idProducto
	        	
	        	},
	        success: function(data) {	
	        	
	        	$("#nuevaEntrada_divSelectProveedores").html(data);
	        	
	        	
  				$('#nuevaEntrada_proveedores').material_select('destroy');
            	$('#nuevaEntrada_proveedores').material_select();
	        	
	        }//fin success
	  	});	
	
	
	
	$("#div_registrarEntradaproducto").show("slower");
	
}
//---


//funcion para cambiar el placheholder de costo al elegir un proveedor en nuesva entrada
function cambiarPlaceholderCosto(){
	
    var costo = $('#nuevaEntrada_proveedores').find(':selected').data('costo');
    
    $("#label_nuevaEntrada_costo").addClass('active');
    	
	$("#nuevaEntrada_costo").attr("placeholder", costo);
	
}
//---

//funcion para cancelar la nueva adicion d euna entrada
function cancelarNuevaEntrada(){

	$("#div_registrarEntradaproducto").hide("slower");
	
	$("#divCrearNuevoStock").show("slower");
	
	$("#nuevaEntrada_idSucursal").val("0");
	$("#nuevaEntrada_idProducto").val("0");
	
	$("#nuevaEntrada_costo").val("");
	$("#nuevaEntrada_costo").attr("placeholder", "");
	
	$("#nuevaEntrada_cantidad").val("");
	
	$("#label_nuevaEntrada_costo").removeClass('active');
	$("#label_nuevaEntrada_cantidad").removeClass('active');
	
	$("#nuevaEntrada_costo").removeClass('valid');
	$("#nuevaEntrada_costo").removeClass('invalid');
	
	$("#nuevaEntrada_cantidad").removeClass('valid');
	$("#nuevaEntrada_cantidad").removeClass('invalid');
	
	

	
}
//---


//funcion para guardar una nueva entrada
function validarNuevaEntrada(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#nuevaEntrada_proveedores").val() == "" || $("#nuevaEntrada_proveedores").val() == null ){
		
		$("#nuevaEntrada_divSelectProveedores").addClass("red lighten-3");

		sw = 1;
	}else{
		$("#nuevaEntrada_divSelectProveedores").removeClass("red lighten-3");
	}		

	
	if( $("#nuevaEntrada_costo").val().trim().length == 0 ){
		
		$("#label_nuevaEntrada_costo").addClass( "active" );
		$("#nuevaEntrada_costo").addClass( "invalid" );
		sw = 1;
	}		


	if( $("#nuevaEntrada_cantidad").val().trim().length == 0 ){
		
		$("#label_nuevaEntrada_cantidad").addClass( "active" );
		$("#nuevaEntrada_cantidad").addClass( "invalid" );
		sw = 1;
	}	
	

	if(sw == 0){
			
			
			 $.ajax({
			  		url: "http://www.nanuvet.com/Controllers/productos/guardarNuevaEntrada.php",
			        dataType: "html",
			        type : 'POST',
			        data: { 
			        	
			        		idProducto: 	$("#nuevaEntrada_idProducto").val(),
			        		idSucursal:  	$("#nuevaEntrada_idSucursal").val(),
			        		idProveedor:	$("#nuevaEntrada_proveedores").val(),
			        		costo:			$("#nuevaEntrada_costo").val(),
			        		cantidad:		$("#nuevaEntrada_cantidad").val()
			        	
			        	},
			        success: function() {	
			        	
			        	cancelarNuevaEntrada();
			        	$('#btn_cerrarModalStock').click();
			        	 var texto = $("#textoNuevaEntradaGuardada").html();
			        	 Materialize.toast(texto, 4000);
			        	
			        }//fin success
			  	});	
			
			
			
		}//fin si todo va bien sw = 0	


	
}
//---







/*

//funcion para desactivar un vinculo
function desactivarVinculo(idVinculo){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivarVinculo").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/productos/desactivarVinculo.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanV_'+idVinculo).html('<a id="'+idVinculo+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarVinculo(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});			
	
}
//---


//funcion para activar un vinculo
function activarVinculo(idVinculo){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivarVinculo").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/productos/activarVinculo.php",
        dataType: "html",
        type : 'POST',
        data: { idVinculo : idVinculo },
        success: function(data) {			

			$('#spanV_'+idVinculo).html('<a id="'+idVinculo+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarVinculo(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}

*/









