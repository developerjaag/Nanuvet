/*
 * Archivo que contiene todas las funciones para los listados y sus subCategorias
 */




/*
 * Barrios
 */

//funcion para mostrar el formulario de crear un nuevo barrios
function mostrarFormNuevoBarrio(){
	
	$("#hidden_NuevoBarrio").show('slower');
	
}
//---

//funcion para cancelar la creación d eun nuevo barrio
function cancelarGuardadoNuevoBarrio(){
	
	
	$("#hidden_NuevoBarrio").hide('slower');
	
	
	$("#idPais").val("0");
	$("#idCiudad").val("0");
	
	$("#pais").val("");
	$("#ciudad").val("");
	$("#nombreBarrio").val("");
	
	//se remueve las clases activas
	$("#label_pais").removeClass("active");
	$("#label_ciudad").removeClass("active");
	$("#label_nombreBarrio").removeClass("active");
	
	
	$("#pais").removeClass("valid");
	$("#ciudad").removeClass("valid");
	$("#nombreBarrio").removeClass("valid");
	

	$("#pais").removeClass("invalid");
	$("#ciudad").removeClass("invalid");
	$("#nombreBarrio").removeClass("invalid");
	
	$("#ciudad").prop('disabled', true);

	
}
//---

//funcion para validar el guardado de n nuevo barrio
function validarGuardadoNuevoBarrio(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#idPais").val() == '0' ){
		
		$("#label_pais").addClass( "active" );
		$("#pais").addClass( "invalid" );
		sw = 1;
	}

	
	if( $("#idCiudad").val() == '0' ){
		
		$("#label_ciudad").addClass( "active" );
		$("#ciudad").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#nombreBarrio").val().trim().length == 0 ){
		
		$("#label_nombreBarrio").addClass( "active" );
		$("#nombreBarrio").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoBarrio").submit();
	}	
		
}
//---


//funcion para desactivar un barrio
function desactivarBarrio(idBarrio){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/barrios/desactivarBarrio.php",
        dataType: "html",
        type : 'POST',
        data: { idBarrio : idBarrio },
        success: function(data) {			

			$('#spanB_'+idBarrio).html('<a id="'+idBarrio+'" class="waves-effect red darken-1 btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="activarBarrio(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un barrio
function activarBarrio(idBarrio){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/barrios/activarBarrio.php",
        dataType: "html",
        type : 'POST',
        data: { idBarrio : idBarrio },
        success: function(data) {			

			$('#spanB_'+idBarrio).html('<a id="'+idBarrio+'" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarBarrio(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar barrio al escribir
function buscarBarrioListados(){
   

    $('#buscarBarrio').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/barrios/buscarBarrio.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringBarrio : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idBarrioBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/barrios/mostrarBusquedaBarrio.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idBarrio : $("#idBarrioBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoBarriosAjax").html(data);
						
						$("#resultadoBarrios").hide('slower');	   
						$("#resultadoBarriosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	
						$('.tooltipped').tooltip({delay: 50});                   
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de un barrio
function editarBarrio(idBarrio,nombreBarrios, idCiudad){

	cancelarGuardadoNuevoBarrio();
	
	$("#idEditarBarrio").val(idBarrio);
	$("#idEditarCiudad").val(idCiudad);
	$("#editarNombreBarrio").val(nombreBarrios);
	$("#replicaNombre").val(nombreBarrios);
	
	$("#label_editarNombreBarrio").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarBarrio").show('slower');
		
}
//---


//funcion para cancelar la edicioin de un barrio
function cancelarEdicionBarrio(){

	$("#hidden_editarBarrio").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarBarrio").val("");
	$("#idEditarCiudad").val("");
	$("#editarNombreBarrio").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreBarrio").removeClass("active");	
	
	$("#editarNombreBarrio").removeClass("valid");	

	$("#editarNombreBarrio").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un barrio
function comprobarEdicionBarrio(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarBarrio").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreBarrio").val().trim().length == 0 ){
		
		$("#label_editarNombreBarrio").addClass( "active" );
		$("#editarNombreBarrio").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarBarrio").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un barrio
function cerrarBusquedaBarrio(){
	
	$("#resultadoBarriosAjax").hide('slower');
	$("#buscarBarrio").val("");	
	$("#buscarBarrio").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoBarrios").show('slower');
	
}
//---


/*
 * Fin Barrios
 */






/*
 * Ciudades
 */

//funcion para mostrar el formulario de crear una nueva ciudad
function mostrarFormNuevaCiudad(){
	
	$("#hidden_NuevaCiudad").show('slower');
	
}
//---

//funcion para cancelar la creación de una nueva ciudad
function cancelarGuardadoNuevaCiudad(){
	
	
	$("#hidden_NuevaCiudad").hide('slower');
	
	
	$("#idPais").val("0");
	
	$("#pais").val("");
	$("#nombreCiudad").val("");
	
	//se remueve las clases activas
	$("#label_pais").removeClass("active");
	$("#label_nombreCiudad").removeClass("active");
	
	
	$("#pais").removeClass("valid");
	$("#nombreCiudad").removeClass("valid");
	

	$("#pais").removeClass("invalid");
	$("#nombreCiudad").removeClass("invalid");
	
	$("#pais").prop('disabled', true);

	
}
//---

//funcion para validar el guardado de n nuevo barrio
function validarGuardadoNuevaCiudad(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#idPais").val() == '0' ){
		
		$("#label_pais").addClass( "active" );
		$("#pais").addClass( "invalid" );
		sw = 1;
	}

	

	if( $("#nombreCiudad").val().trim().length == 0 ){
		
		$("#label_nombreCiudad").addClass( "active" );
		$("#nombreCiudad").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaCiudad").submit();
	}	
		
}
//---


//funcion para desactivar una ciudad
function desactivarCiudad(idCiudad){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/ciudades/desactivarCiudad.php",
        dataType: "html",
        type : 'POST',
        data: { idCiudad : idCiudad },
        success: function(data) {			

			$('#spanB_'+idCiudad).html('<a id="'+idCiudad+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarCiudad(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar una ciudad
function activarCiudad(idCiudad){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/ciudades/activarCiudad.php",
        dataType: "html",
        type : 'POST',
        data: { idCiudad : idCiudad },
        success: function(data) {			

			$('#spanB_'+idCiudad).html('<a id="'+idCiudad+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarCiudad(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar ciudad al escribir
function buscarCiudadListados(){
   

    $('#buscarCiudad').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/ciudades/buscarCiudad.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringCiudad : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idCiudadBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/ciudades/mostrarBusquedaCiudad.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idCiudad : $("#idCiudadBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoCiudadesAjax").html(data);
						
						$("#resultadoCiudades").hide('slower');	   
						$("#resultadoCiudadesAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de una ciudad
function editarCiudad(idCiudad,nombreCiudad, idPais){

	cancelarGuardadoNuevaCiudad();
	
	$("#idEditarCiudad").val(idCiudad);
	$("#idEditarPais").val(idPais);
	$("#editarNombreCiudad").val(nombreCiudad);
	$("#replicaNombre").val(nombreCiudad);
	
	$("#label_editarNombreCiudad").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarCiudad").show('slower');
		
}
//---


//funcion para cancelar la edicioin de una ciudad
function cancelarEdicionCiudad(){

	$("#hidden_editarCiudad").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarCiudad").val("");
	$("#idEditarPais").val("");
	$("#editarNombreCiudad").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreCiudad").removeClass("active");	
	
	$("#editarNombreCiudad").removeClass("valid");	

	$("#editarNombreCiudad").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de una ciudad
function comprobarEdicionCiudad(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarCiudad").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreCiudad").val().trim().length == 0 ){
		
		$("#label_editarNombreCiudad").addClass( "active" );
		$("#editarNombreCiudad").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarCiudad").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de una ciudad
function cerrarBusquedaCiudad(){
	
	$("#resultadoCiudadesAjax").hide('slower');
	$("#buscarCiudad").val("");	
	$("#buscarCiudad").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoCiudades").show('slower');
	
}
//---


/*
 * Fin ciudades
 */










/*
 * Categorias productos
 */

//funcion para mostrar el formulario de crear una nueva categoría
function mostrarFormNuevaCategoria(){
	
	$("#hidden_NuevaCategoria").show('slower');
	
}
//---

//funcion para cancelar la creación de una nueva categoría
function cancelarGuardadoNuevaCategoria(){
	
	
	$("#hidden_NuevaCategoria").hide('slower');
	
	
	$("#nombreCategoria").val("");
	
	//se remueve las clases activas
	$("#label_nombreCategoria").removeClass("active");
	
	
	$("#nombreCategoria").removeClass("valid");
	

	$("#nombreCategoria").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de una nueva categoría
function validarGuardadoNuevaCategoria(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreCategoria").val().trim().length == 0 ){
		
		$("#label_nombreCategoria").addClass( "active" );
		$("#nombreCategoria").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaCategoria").submit();
	}	
		
}
//---


//funcion para desactivar una categoria
function desactivarCategoria(idCategoria){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/categoriasProductos/desactivarCategoria.php",
        dataType: "html",
        type : 'POST',
        data: { idCategoria : idCategoria },
        success: function(data) {			

			$('#spanB_'+idCategoria).html('<a id="'+idCategoria+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarCategoria(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar una categoria
function activarCategoria(idCategoria){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/categoriasProductos/activarCategoria.php",
        dataType: "html",
        type : 'POST',
        data: { idCategoria : idCategoria },
        success: function(data) {			

			$('#spanB_'+idCategoria).html('<a id="'+idCategoria+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarCategoria(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar categoria al escribir
function buscarCategoriaListados(){
   

    $('#buscarCategoria').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/categoriasProductos/buscarCategoria.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringCategoria : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idCategoriaBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/categoriasProductos/mostrarBusquedaCategoria.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idCategoria : $("#idCategoriaBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoCategoriasAjax").html(data);
						
						$("#resultadoCategorias").hide('slower');	   
						$("#resultadoCategoriasAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de una categoria
function editarCategoria(idCategoria,nombreCategoria){

	cancelarGuardadoNuevaCategoria();
	
	$("#idEditarCategoria").val(idCategoria);
	$("#editarNombreCategoria").val(nombreCategoria);
	$("#replicaNombre").val(nombreCategoria);
	
	$("#label_editarNombreCategoria").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarCategoria").show('slower');
		
}
//---


//funcion para cancelar la edicioin de una categoria
function cancelarEdicionCategoria(){

	$("#hidden_editarCategoria").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarCategoria").val("");
	$("#editarNombreCategoria").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreCategoria").removeClass("active");	
	
	$("#editarNombreCategoria").removeClass("valid");	

	$("#editarNombreCategoria").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de una categoria
function comprobarEdicionCategoria(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarCategoria").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreCategoria").val().trim().length == 0 ){
		
		$("#label_editarNombreCategoria").addClass( "active" );
		$("#editarNombreCategoria").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarCategoria").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de una categoria
function cerrarBusquedaCategoria(){
	
	$("#resultadoCategoriasAjax").hide('slower');
	$("#buscarCategoria").val("");	
	$("#buscarCategoria").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoCategorias").show('slower');
	
}
//---


/*
 * Fin categorias productos
 */







/*
 * Desparasitantes
 */

//funcion para mostrar el formulario de crear una nuevo desparasitante
function mostrarFormNuevoDesparasitante(){
	
	$("#hidden_NuevoDesparasitante").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo desparasitante
function cancelarGuardadoNuevoDesparasitante(){
	
	
	$("#hidden_NuevoDesparasitante").hide('slower');
	
	
	$("#nombreDesparasitante").val("");
	$("#descripcionDesparasitante").val("");
	
	//se remueve las clases activas
	$("#label_nombreDesparasitante").removeClass("active");
	$("#label_descripcionDesparasitante").removeClass("active");
	
	
	$("#nombreDesparasitante").removeClass("valid");
	$("#descripcionDesparasitante").removeClass("valid");
	

	$("#nombreDesparasitante").removeClass("invalid");
	$("#descripcionDesparasitante").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo desparasitante
function validarGuardadoNuevoDesparasitante(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreDesparasitante").val().trim().length == 0 ){
		
		$("#label_nombreDesparasitante").addClass( "active" );
		$("#nombreDesparasitante").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoDesparasitante").submit();
	}	
		
}
//---


//funcion para desactivar un desparasitante
function desactivarDesparasitante(idDesparasitante){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/desactivarDesparasitante.php",
        dataType: "html",
        type : 'POST',
        data: { idDesparasitante : idDesparasitante },
        success: function(data) {			

			$('#spanB_'+idDesparasitante).html('<a id="'+idDesparasitante+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarDesparasitante(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un desparasitante
function activarDesparasitante(idDesparasitante){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/activarDesparasitante.php",
        dataType: "html",
        type : 'POST',
        data: { idDesparasitante : idDesparasitante },
        success: function(data) {			

			$('#spanB_'+idDesparasitante).html('<a id="'+idDesparasitante+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarDesparasitante(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar desparasitante al escribir
function buscarDesparasitanteListados(){
   

    $('#buscarDesparasitante').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/buscarDesparasitante.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDesparasitante : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idDesparasitanteBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/desparasitantes/mostrarBusquedaDesparasitante.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idDesparasitante : $("#idDesparasitanteBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoDesparasitantesAjax").html(data);
						
						$("#resultadoDesparasitantes").hide('slower');	   
						$("#resultadoDesparasitantesAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de un Desparasitante
function editarDesparasitante(idDesparasitante,nombreDesparasitante, descripcion){

	cancelarGuardadoNuevoDesparasitante();
	
	$("#idEditarDesparasitante").val(idDesparasitante);
	$("#editarNombreDesparasitante").val(nombreDesparasitante);
	$("#editarDescripcionDesparasitante").val(descripcion);
	$("#replicaNombre").val(nombreDesparasitante);
	
	$("#label_editarNombreDesparasitante").addClass( "active" );
	$("#label_editarDescripcionDesparasitante").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarDesparasitante").show('slower');
		
}
//---


//funcion para cancelar la edicion de un desparasitante
function cancelarEdicionDesparasitante(){

	$("#hidden_editarDesparasitante").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarDesparasitante").val("");
	$("#editarNombreDesparasitante").val("");	
	$("#editarDescripcionDesparasitante").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreDesparasitante").removeClass("active");	
	$("#label_editarDescripcionDesparasitante").removeClass("active");	
	
	$("#editarNombreDesparasitante").removeClass("valid");	
	$("#editarDescripcionDesparasitante").removeClass("valid");	

	$("#editarNombreDesparasitante").removeClass("invalid");	
	$("#editarDescripcionDesparasitante").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un desparasitante
function comprobarEdicionDesparasitante(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarDesparasitante").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreDesparasitante").val().trim().length == 0 ){
		
		$("#label_editarNombreDesparasitante").addClass( "active" );
		$("#editarNombreDesparasitante").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarDesparasitante").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un desparasitante
function cerrarBusquedaDesparasitante(){
	
	$("#resultadoDesparasitantesAjax").hide('slower');
	$("#buscarDesparasitante").val("");	
	$("#buscarDesparasitante").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoDesparasitantes").show('slower');
	
}
//---


/*
 * Desparasitantes
 */







/*
 * Diagnósticos cirugias
 */

//funcion para mostrar el formulario de crear una nuevo diagnostico
function mostrarFormNuevoDiagnosticoCirugia(){
	
	$("#hidden_NuevoDiagnostico").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo diagnostico
function cancelarGuardadoNuevoDiagnosticoCirugia(){
	
	
	$("#hidden_NuevoDiagnostico").hide('slower');
	
	
	$("#nombreDiagnostico").val("");
	$("#codigoDiagnostico").val("");
	$("#observacionDiagnostico").val("");
	$("#precioDiagnostico").val("");
	
	//se remueve las clases activas
	$("#label_nombreDiagnostico").removeClass("active");
	$("#label_codigoDiagnostico").removeClass("active");
	$("#label_observacionDiagnostico").removeClass("active");
	$("#label_precioDiagnostico").removeClass("active");
	
	
	$("#nombreDiagnostico").removeClass("valid");
	$("#codigoDiagnostico").removeClass("valid");
	$("#observacionDiagnostico").removeClass("valid");
	$("#precioDiagnostico").removeClass("valid");
	

	$("#nombreDiagnostico").removeClass("invalid");
	$("#codigoDiagnostico").removeClass("invalid");
	$("#observacionDiagnostico").removeClass("invalid");
	$("#precioDiagnostico").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo diagnostico
function validarGuardadoNuevoDiagnosticoCirugia(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreDiagnostico").addClass( "active" );
		$("#nombreDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#codigoDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoDiagnostico").addClass( "active" );
		$("#codigoDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	
	
	if( $("#precioDiagnostico").val().trim().length == 0 ){
		
		$("#label_precioDiagnostico").addClass( "active" );
		$("#precioDiagnostico").addClass( "invalid" );
		sw = 1;
	}	
	
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoDiagnostico").submit();
	}	
		
}
//---


//funcion para desactivar un diagnostico
function desactivarDiagnosticoCirugia(idDiagnostico){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/desactivarDiagnostico.php",
        dataType: "html",
        type : 'POST',
        data: { idDiagnostico : idDiagnostico },
        success: function(data) {			

			$('#spanB_'+idDiagnostico).html('<a id="'+idDiagnostico+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarDiagnosticoCirugia(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un diagnostico
function activarDiagnosticoCirugia(idDiagnostico){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/activarDiagnostico.php",
        dataType: "html",
        type : 'POST',
        data: { idDiagnostico : idDiagnostico },
        success: function(data) {			

			$('#spanB_'+idDiagnostico).html('<a id="'+idDiagnostico+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarDiagnosticoCirugia(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar diagnostico al escribir
function buscarDiagnosticoCirugiaListados(){
   

    $('#buscarDiagnostico').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idDiagnosticoBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosCirugias/mostrarBusquedaDiagnostico.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idDiagnostico : $("#idDiagnosticoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoDiagnosticosAjax").html(data);
						
						$("#resultadoDiagnosticos").hide('slower');	   
						$("#resultadoDiagnosticosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el un diagnóstico
function editarDiagnosticoCirugia(idDiagnostico, nombre, codigo, observacion, precio){

	cancelarGuardadoNuevoDiagnosticoCirugia();
	
	$("#idEditarDiagnostico").val(idDiagnostico);
	$("#nombreEditarDiagnostico").val(nombre);
	$("#codigoEditarDiagnostico").val(codigo);
	$("#observacionEditarDiagnostico").val(observacion);
	$("#precioEditarDiagnostico").val(precio);
	$("#replicaNombre").val(nombre);
	
	$("#label_nombreEditarDiagnostico").addClass( "active" );
	$("#label_codigoEditarDiagnostico").addClass( "active" );
	$("#label_observacionEditarDiagnostico").addClass( "active" );
	$("#label_precioEditarDiagnostico").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarDiagnostico").show('slower');
		
}
//---


//funcion para cancelar la edicion de un diagnostico
function cancelarEdicionDiagnosticoCirugia(){

	$("#hidden_editarDiagnostico").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarDiagnostico").val("");
	$("#nombreEditarDiagnostico").val("");
	$("#codigoEditarDiagnostico").val("");
	$("#observacionEditarDiagnostico").val("");
	$("#precioEditarDiagnostico").val("");
	$("#replicaNombre").val("");
	
	$("#label_editarNombreDiagnostico").removeClass("active");	
	$("#label_codigoEditarDiagnostico").removeClass("active");	
	$("#label_observacionEditarDiagnostico").removeClass("active");	
	$("#label_precioEditarDiagnostico").removeClass("active");	
	
	$("#nombreEditarDiagnostico").removeClass("valid");
	$("#codigoEditarDiagnostico").removeClass("valid");
	$("#observacionEditarDiagnostico").removeClass("valid");
	$("#precioEditarDiagnostico").removeClass("valid");	

	$("#nombreEditarDiagnostico").removeClass("invalid");
	$("#codigoEditarDiagnostico").removeClass("invalid");
	$("#observacionEditarDiagnostico").removeClass("invalid");
	$("#precioEditarDiagnostico").removeClass("invalid");		
	
}
//---

//funcion para validar la edicion de un diagnostico
function comprobarEdicionDiagnosticoCirugia(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarDiagnostico").val() == "" ){		
		sw = 1;
	}

	if( $("#nombreEditarDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreEditarDiagnostico").addClass( "active" );
		$("#nombreEditarDiagnostico").addClass( "invalid" );
		sw = 1;
	}


	if( $("#codigoEditarDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoEditarDiagnostico").addClass( "active" );
		$("#codigoEditarDiagnostico").addClass( "invalid" );
		sw = 1;
	}


	if( $("#precioEditarDiagnostico").val().trim().length == 0 ){
		
		$("#label_precioEditarDiagnostico").addClass( "active" );
		$("#precioEditarDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarDiagnostico").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un diagnostico
function cerrarBusquedaDiagnosticoCirugia(){
	
	$("#resultadoDiagnosticosAjax").hide('slower');
	$("#buscarDiagnostico").val("");	
	$("#buscarDiagnostico").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoDiagnosticos").show('slower');
	
}
//---

//generar un codigo aleatorio
function generarCodigodiagnosticoCirugia(idCampo){
	
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


/*
 * Diagnosticos cirugias
 */














/*
 * Diagnósticos consultas
 */

//funcion para mostrar el formulario de crear una nuevo diagnostico
function mostrarFormNuevoDiagnosticoConsulta(){
	
	$("#hidden_NuevoDiagnostico").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo diagnostico
function cancelarGuardadoNuevoDiagnosticoConsulta(){
	
	
	$("#hidden_NuevoDiagnostico").hide('slower');
	
	
	$("#nombreDiagnostico").val("");
	$("#codigoDiagnostico").val("");
	$("#observacionDiagnostico").val("");
	
	//se remueve las clases activas
	$("#label_nombreDiagnostico").removeClass("active");
	$("#label_codigoDiagnostico").removeClass("active");
	$("#label_observacionDiagnostico").removeClass("active");
	
	
	$("#nombreDiagnostico").removeClass("valid");
	$("#codigoDiagnostico").removeClass("valid");
	$("#observacionDiagnostico").removeClass("valid");
	

	$("#nombreDiagnostico").removeClass("invalid");
	$("#codigoDiagnostico").removeClass("invalid");
	$("#observacionDiagnostico").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo diagnostico
function validarGuardadoNuevoDiagnosticoConsulta(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreDiagnostico").addClass( "active" );
		$("#nombreDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#codigoDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoDiagnostico").addClass( "active" );
		$("#codigoDiagnostico").addClass( "invalid" );
		sw = 1;
	}
	
	
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoDiagnostico").submit();
	}	
		
}
//---


//funcion para desactivar un diagnostico
function desactivarDiagnosticoConsulta(idDiagnostico){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/desactivarDiagnostico.php",
        dataType: "html",
        type : 'POST',
        data: { idDiagnostico : idDiagnostico },
        success: function(data) {			

			$('#spanB_'+idDiagnostico).html('<a id="'+idDiagnostico+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarDiagnosticoConsulta(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un diagnostico
function activarDiagnosticoConsulta(idDiagnostico){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/activarDiagnostico.php",
        dataType: "html",
        type : 'POST',
        data: { idDiagnostico : idDiagnostico },
        success: function(data) {			

			$('#spanB_'+idDiagnostico).html('<a id="'+idDiagnostico+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarDiagnosticoConsulta(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar diagnostico al escribir
function buscarDiagnosticoConsultaListados(){
   

    $('#buscarDiagnostico').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/buscarDiagnostico.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringDiagnostico : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idDiagnosticoBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/diagnosticosConsultas/mostrarBusquedaDiagnostico.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idDiagnostico : $("#idDiagnosticoBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoDiagnosticosAjax").html(data);
						
						$("#resultadoDiagnosticos").hide('slower');	   
						$("#resultadoDiagnosticosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el un diagnóstico
function editarDiagnosticoConsulta(idDiagnostico, nombre, codigo, observacion){

	cancelarGuardadoNuevoDiagnosticoConsulta();
	
	$("#idEditarDiagnostico").val(idDiagnostico);
	$("#nombreEditarDiagnostico").val(nombre);
	$("#codigoEditarDiagnostico").val(codigo);
	$("#observacionEditarDiagnostico").val(observacion);
	$("#replicaNombre").val(nombre);
	
	$("#label_nombreEditarDiagnostico").addClass( "active" );
	$("#label_codigoEditarDiagnostico").addClass( "active" );
	$("#label_observacionEditarDiagnostico").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarDiagnostico").show('slower');
		
}
//---


//funcion para cancelar la edicion de un diagnostico
function cancelarEdicionDiagnosticoConsulta(){

	$("#hidden_editarDiagnostico").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarDiagnostico").val("");
	$("#nombreEditarDiagnostico").val("");
	$("#codigoEditarDiagnostico").val("");
	$("#observacionEditarDiagnostico").val("");
	$("#replicaNombre").val("");
	
	$("#label_editarNombreDesparasitante").removeClass("active");	
	$("#label_codigoEditarDiagnostico").removeClass("active");	
	$("#label_observacionEditarDiagnostico").removeClass("active");	
	
	$("#nombreEditarDiagnostico").removeClass("valid");
	$("#codigoEditarDiagnostico").removeClass("valid");
	$("#observacionEditarDiagnostico").removeClass("valid");

	$("#nombreEditarDiagnostico").removeClass("invalid");
	$("#codigoEditarDiagnostico").removeClass("invalid");
	$("#observacionEditarDiagnostico").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un diagnostico
function comprobarEdicionDiagnosticoConsulta(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarDiagnostico").val() == "" ){		
		sw = 1;
	}

	if( $("#nombreEditarDiagnostico").val().trim().length == 0 ){
		
		$("#label_nombreEditarDiagnostico").addClass( "active" );
		$("#nombreEditarDiagnostico").addClass( "invalid" );
		sw = 1;
	}


	if( $("#codigoEditarDiagnostico").val().trim().length == 0 ){
		
		$("#label_codigoEditarDiagnostico").addClass( "active" );
		$("#codigoEditarDiagnostico").addClass( "invalid" );
		sw = 1;
	}


	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarDiagnostico").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un diagnostico
function cerrarBusquedaDiagnosticoConsulta(){
	
	$("#resultadoDiagnosticosAjax").hide('slower');
	$("#buscarDiagnostico").val("");	
	$("#buscarDiagnostico").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoDiagnosticos").show('slower');
	
}
//---

//generar un codigo aleatorio
function generarCodigodiagnosticoConsulta(idCampo){
	
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


/*
 * Diagnosticos consultas
 */






/*
 * Especies
 */

//funcion para mostrar el formulario de crear una nueva especie
function mostrarFormNuevaEspecie(){
	
	$("#hidden_NuevaEspecie").show('slower');
	
}
//---

//funcion para cancelar la creación de una nueva especie
function cancelarGuardadoNuevaEspecie(){
	
	
	$("#hidden_NuevaEspecie").hide('slower');
	
	

	$("#nombreEspecie").val("");
	
	//se remueve las clases activas
	$("#label_nombreEspecie").removeClass("active");
	
	
	$("#nombreEspecie").removeClass("valid");
	

	$("#nombreEspecie").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de una nueva especie
function validarGuardadoNuevaEspecie(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	

	if( $("#nombreEspecie").val().trim().length == 0 ){
		
		$("#label_nombreEspecie").addClass( "active" );
		$("#nombreEspecie").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaEspecie").submit();
	}	
		
}
//---


//funcion para desactivar una especie
function desactivarEspecie(idEspecie){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/especies/desactivarEspecie.php",
        dataType: "html",
        type : 'POST',
        data: { idEspecie : idEspecie },
        success: function(data) {			

			$('#spanB_'+idEspecie).html('<a id="'+idEspecie+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarEspecie(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar una especie
function activarEspecie(idEspecie){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/especies/activarEspecie.php",
        dataType: "html",
        type : 'POST',
        data: { idEspecie : idEspecie },
        success: function(data) {			

			$('#spanB_'+idEspecie).html('<a id="'+idEspecie+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarEspecie(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar especie al escribir
function buscarEspecieListados(){
   

    $('#buscarEspecie').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/especies/buscarEspecie.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringEspecie: request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idEspecieBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/especies/mostrarBusquedaEspecie.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idEspecie : $("#idEspecieBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoEspeciesAjax").html(data);
						
						$("#resultadoEspecies").hide('slower');	   
						$("#resultadoEspeciesAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de una especie
function editarEspecie(idEspecie,nombreEspecie){

	cancelarGuardadoNuevaEspecie();
	
	$("#idEditarEspecie").val(idEspecie);
	$("#editarNombreEspecie").val(nombreEspecie);
	$("#replicaNombre").val(nombreEspecie);
	
	$("#label_editarNombreEspecie").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarEspecie").show('slower');
		
}
//---


//funcion para cancelar la edicioin de una especie
function cancelarEdicionEspecie(){

	$("#hidden_editarEspecie").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarEspecie").val("");
	$("#editarNombreEspecie").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreEspecie").removeClass("active");	
	
	$("#editarNombreEspecie").removeClass("valid");	

	$("#editarNombreEspecie").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de una especie
function comprobarEdicionEspecie(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarEspecie").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreEspecie").val().trim().length == 0 ){
		
		$("#label_editarNombreEspecie").addClass( "active" );
		$("#editarNombreEspecie").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarEspecie").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de una especie
function cerrarBusquedaEspecie(){
	
	$("#resultadoEspeciesAjax").hide('slower');
	$("#buscarEspecie").val("");	
	$("#buscarEspecie").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoEspecies").show('slower');
	
}
//---


/*
 * Fin especies
 */










/*
 * Examenes
 */

//funcion para mostrar el formulario de crear una nuevo examen
function mostrarFormNuevoExamen(){
	
	$("#hidden_NuevoExamen").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo examen
function cancelarGuardadoNuevoExamen(){
	
	
	$("#hidden_NuevoExamen").hide('slower');
	
	
	$("#nombreExamen").val("");
	$("#codigoExamen").val("");
	$("#precioExamen").val("");
	$("#descripcionExamen").val("");
	
	//se remueve las clases activas
	$("#label_nombreExamen").removeClass("active");
	$("#label_codigoExamen").removeClass("active");
	$("#label_precioExamen").removeClass("active");
	$("#label_descripcionExamen").removeClass("active");
	
	$("#nombreExamen").removeClass("valid");
	$("#codigoExamen").removeClass("valid");
	$("#precioExamen").removeClass("valid");
	$("#descripcionExamen").removeClass("valid");
	

	$("#nombreExamen").removeClass("invalid");
	$("#codigoExamen").removeClass("invalid");
	$("#precioExamen").removeClass("invalid");
	$("#descripcionExamen").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo examen
function validarGuardadoNuevoExamen(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreExamen").val().trim().length == 0 ){
		
		$("#label_nombreExamen").addClass( "active" );
		$("#nombreExamen").addClass( "invalid" );
		sw = 1;
	}


	if( $("#precioExamen").val().trim().length == 0 ){
		
		$("#label_precioExamen").addClass( "active" );
		$("#precioExamen").addClass( "invalid" );
		sw = 1;
	}


	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoExamen").submit();
	}	
		
}
//---


//funcion para desactivar un examen
function desactivarExamen(idExamen){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/examenes/desactivarExamen.php",
        dataType: "html",
        type : 'POST',
        data: { idExamen : idExamen },
        success: function(data) {			

			$('#spanB_'+idExamen).html('<a id="'+idExamen+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarExamen(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un examen
function activarExamen(idExamen){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/examenes/activarExamen.php",
        dataType: "html",
        type : 'POST',
        data: { idExamen : idExamen },
        success: function(data) {			

			$('#spanB_'+idExamen).html('<a id="'+idExamen+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarExamen(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar examen al escribir
function buscarExamenListados(){
   

    $('#buscarExamen').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/examenes/buscarExamen.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringExamen : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idExamenBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/examenes/mostrarBusquedaExamen.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idExamen : $("#idExamenBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoExamenesAjax").html(data);
						
						$("#resultadoExamenes").hide('slower');	   
						$("#resultadoExamenesAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar un examen
function editarExamen(idExamen, nombreExamen, codigoExamen, precio, descripcion){

	cancelarGuardadoNuevoExamen();
	
	$("#idEditarExamen").val(idExamen);
	$("#editarNombreExamen").val(nombreExamen);
	$("#editarCodigoExamen").val(codigoExamen);
	$("#editarPrecioExamen").val(precio);
	$("#editarDescripcionExamen").val(descripcion);
	$("#replicaNombre").val(nombreExamen);
	
	$("#label_editarNombreExamen").addClass( "active" );
	$("#label_editarCodigoExamen").addClass( "active" );
	$("#label_editarPrecioExamen").addClass( "active" );
	$("#label_editarDescripcionExamen").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarExamen").show('slower');
		
}
//---


//funcion para cancelar la edicion de un examen
function cancelarEdicionExamen(){

	$("#hidden_editarExamen").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarExamen").val("");
	$("#editarNombreExamen").val("");
	$("#editarCodigoExamen").val("");
	$("#editarPrecioExamen").val("");
	$("#editarDescripcionExamen").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreExamen").removeClass("active");	
	$("#label_editarCodigoExamen").removeClass("active");	
	$("#label_editarPrecioExamen").removeClass("active");	
	$("#label_editarDescripcionExamen").removeClass("active");		
	
	$("#editarNombreExamen").removeClass("valid");	
	$("#editarCodigoExamen").removeClass("valid");	
	$("#editarPrecioExamen").removeClass("valid");	
	$("#editarDescripcionExamen").removeClass("valid");	

	$("#editarNombreExamen").removeClass("invalid");
	$("#editarCodigoExamen").removeClass("invalid");
	$("#editarPrecioExamen").removeClass("invalid");
	$("#editarDescripcionExamen").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un examen
function comprobarEdicionExamen(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarExamen").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreExamen").val().trim().length == 0 ){
		
		$("#label_editarNombreExamen").addClass( "active" );
		$("#editarNombreExamen").addClass( "invalid" );
		sw = 1;
	}


	if( $("#editarPrecioExamen").val().trim().length == 0 ){
		
		$("#label_editarPrecioExamen").addClass( "active" );
		$("#editarPrecioExamen").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarExamen").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un examen
function cerrarBusquedaExamen(){
	
	$("#resultadoExamenesAjax").hide('slower');
	$("#buscarExamen").val("");	
	$("#buscarExamen").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoExamenes").show('slower');
	
}
//---


/*
 * examenes
 */






/*
 * Medicamentos
 */

//funcion para mostrar el formulario de crear una nuevo medicamento
function mostrarFormNuevoMedicamento(){
	
	$("#hidden_NuevoMedicamento").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo Medicamento
function cancelarGuardadoNuevoMedicamento(){
	
	
	$("#hidden_NuevoMedicamento").hide('slower');
	
	
	$("#nombreMedicamento").val("");
	$("#codigoMedicamento").val("");
	$("#observacionMedicamento").val("");
	
	//se remueve las clases activas
	$("#label_nombreMedicamento").removeClass("active");
	$("#label_codigoMedicamento").removeClass("active");
	$("#label_observacionMedicamento").removeClass("active");
	
	$("#nombreMedicamento").removeClass("valid");
	$("#codigoMedicamento").removeClass("valid");
	$("#observacionMedicamento").removeClass("valid");
	

	$("#nombreMedicamento").removeClass("invalid");
	$("#codigoMedicamento").removeClass("invalid");
	$("#observacionMedicamento").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo medicamento
function validarGuardadoNuevoMedicamento(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreMedicamento").val().trim().length == 0 ){
		
		$("#label_nombreMedicamento").addClass( "active" );
		$("#nombreMedicamento").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoMedicamento").submit();
	}	
		
}
//---


//funcion para desactivar un medicamento
function desactivarMedicamento(idMedicamento){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/desactivarMedicamento.php",
        dataType: "html",
        type : 'POST',
        data: { idMedicamento : idMedicamento },
        success: function(data) {			

			$('#spanB_'+idMedicamento).html('<a id="'+idMedicamento+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarMedicamento(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un medicamento
function activarMedicamento(idMedicamento){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/activarMedicamento.php",
        dataType: "html",
        type : 'POST',
        data: { idMedicamento : idMedicamento },
        success: function(data) {			

			$('#spanB_'+idMedicamento).html('<a id="'+idMedicamento+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarMedicamento(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar medicamento al escribir
function buscarMedicamentoListados(){
   

    $('#buscarMedicamento').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/buscarMedicamento.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringMedicamento : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idMedicamentoBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/medicamentos/mostrarBusquedaMedicamento.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idMedicamento : $("#idMedicamentoBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoMedicamentosAjax").html(data);
						
						$("#resultadoMedicamentos").hide('slower');	   
						$("#resultadoMedicamentosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar un mediacamento
function editarMedicamento(idMedicamento, nombreMedicamento, codigoMedicamento, observacion){

	cancelarGuardadoNuevoExamen();
	
	$("#idEditarMedicamento").val(idMedicamento);
	$("#editarNombreMedicamento").val(nombreMedicamento);
	$("#editarCodigoMedicamento").val(codigoMedicamento);
	$("#editarObservacionMedicamento").val(observacion);
	$("#replicaNombre").val(nombreMedicamento);
	
	$("#label_editarNombreMedicamento").addClass( "active" );
	$("#label_editarCodigoMedicamento").addClass( "active" );
	$("#label_editarObservacionMedicamento").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarMedicamento").show('slower');
		
}
//---


//funcion para cancelar la edicion de un Medicamento
function cancelarEdicionMedicamento(){

	$("#hidden_editarMedicamento").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarMedicamento").val("");
	$("#editarNombreMedicamento").val("");
	$("#editarCodigoMedicamento").val("");
	$("#editarObservacionMedicamento").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreMedicamento").removeClass("active");	
	$("#label_editarCodigoMedicamento").removeClass("active");	
	$("#label_editarObservacionMedicamento").removeClass("active");		
	
	$("#editarNombreMedicamento").removeClass("valid");	
	$("#editarCodigoMedicamento").removeClass("valid");	
	$("#editarObservacionMedicamento").removeClass("valid");	

	$("#editarNombreMedicamento").removeClass("invalid");
	$("#editarCodigoMedicamento").removeClass("invalid");
	$("#editarObservacionMedicamento").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un Medicamento
function comprobarEdicionMedicamento(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarMedicamento").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreMedicamento").val().trim().length == 0 ){
		
		$("#label_editarNombreMedicamento").addClass( "active" );
		$("#editarNombreMedicamento").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarMedicamento").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un Medicamento
function cerrarBusquedaMedicamento(){
	
	$("#resultadoMedicamentosAjax").hide('slower');
	$("#buscarMedicamento").val("");	
	$("#buscarMedicamento").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoMedicamentos").show('slower');
	
}
//---


/*
 * Medicamentos
 */








/*
 * Razas
 */

//funcion para mostrar el formulario de crear una nueva raza
function mostrarFormNuevaRaza(){
	
	$("#hidden_NuevaRaza").show('slower');
	
}
//---

//funcion para cancelar la creación de una nueva raza
function cancelarGuardadoNuevaRaza(){
	
	
	$("#hidden_NuevaRaza").hide('slower');
	
	
	$("#idEspecie").val("0");
	
	$("#especie").val("");
	$("#nombreRaza").val("");
	
	//se remueve las clases activas
	$("#label_especie").removeClass("active");
	$("#label_nombreRaza").removeClass("active");
	
	
	$("#especie").removeClass("valid");
	$("#nombreRaza").removeClass("valid");
	

	$("#especie").removeClass("invalid");
	$("#nombreRaza").removeClass("invalid");
	
	$("#especie").prop('disabled', true);

	
}
//---

//funcion para validar el guardado de una nueva raza
function validarGuardadoNuevaRaza(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar

	if( $("#idEspecie").val() == '0' ){
		
		$("#label_especie").addClass( "active" );
		$("#especie").addClass( "invalid" );
		sw = 1;
	}

	

	if( $("#nombreRaza").val().trim().length == 0 ){
		
		$("#label_nombreRaza").addClass( "active" );
		$("#nombreRaza").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaRaza").submit();
	}	
		
}
//---


//funcion para desactivar una raza
function desactivarRaza(idRaza){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/razas/desactivarRaza.php",
        dataType: "html",
        type : 'POST',
        data: { idRaza : idRaza },
        success: function(data) {			

			$('#spanB_'+idRaza).html('<a id="'+idRaza+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarRaza(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar una raza
function activarRaza(idRaza){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/razas/activarRaza.php",
        dataType: "html",
        type : 'POST',
        data: { idRaza : idRaza },
        success: function(data) {			

			$('#spanB_'+idRaza).html('<a id="'+idRaza+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarRaza(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar raza al escribir
function buscarRazaListados(){
   

    $('#buscarRaza').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/razas/buscarRaza.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringRaza : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idRazaBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/razas/mostrarBusquedaRaza.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idRaza : $("#idRazaBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoRazasAjax").html(data);
						
						$("#resultadoRazas").hide('slower');	   
						$("#resultadoRazasAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de una raza
function editarRaza(idRaza,nombreRaza, idEspecie, nombreEspecie){

	cancelarGuardadoNuevaRaza();
	
	$("#idEditarRaza").val(idRaza);
	$("#idEditarEspecie").val(idEspecie);
	$("#editarNombreRaza").val(nombreRaza);
	$("#editarNombreEspecie").val(nombreEspecie);
	$("#replicaNombre").val(nombreRaza);
	
	$("#label_editarNombreRaza").addClass( "active" );
	$("#label_editarNombreEspecie").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarRaza").show('slower');
		
}
//---


//funcion para cancelar la edicioin de una raza
function cancelarEdicionRaza(){

	$("#hidden_editarRaza").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarRaza").val("");
	$("#idEditarEspecie").val("");
	$("#editarNombreRaza").val("");	
	$("#editarNombreEspecie").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreRaza").removeClass("active");
	$("#label_editarNombreEspecie").removeClass("active");	
	
	$("#editarNombreRaza").removeClass("valid");	
	$("#editarNombreEspecie").removeClass("valid");	

	$("#editarNombreRaza").removeClass("invalid");	
	$("#editarNombreEspecie").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de una raza
function comprobarEdicionRaza(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarRaza").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreRaza").val().trim().length == 0 ){
		
		$("#label_editarNombreRaza").addClass( "active" );
		$("#editarNombreRaza").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarRaza").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de una raza
function cerrarBusquedaRaza(){
	
	$("#resultadoRazasAjax").hide('slower');
	$("#buscarRaza").val("");	
	$("#buscarRaza").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoRazas").show('slower');
	
}
//---



//funcion para buscar una especie
function buscarEspecieListados(){
	
	 $('#especie').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/especies/buscarEspecie.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringEspecie : request.term//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idEspecie").val(ui.item.id); 	
				//se habilita el campo para que se pueda digitar
				$("#nombreRaza").prop('disabled', false);
        			   			
        }
    	
  	}); 
	
	
}
//---



/*
 * Fin razas
 */








/*
 * Servicios
 */

//funcion para mostrar el formulario de crear una nuevo servicio
function mostrarFormNuevoServicio(){
	
	$("#hidden_NuevoServicio").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo servicio
function cancelarGuardadoNuevoServicio(){
	
	
	$("#hidden_NuevoServicio").hide('slower');
	
	
	$("#nombreServicio").val("");
	$("#codigoServicio").val("");
	$("#descripcionServicio").val("");
	$("#precioServicio").val("");
	
	//se remueve las clases activas
	$("#label_nombreServicio").removeClass("active");
	$("#label_codigoServicio").removeClass("active");
	$("#label_descripcionServicio").removeClass("active");
	$("#label_precioServicio").removeClass("active");
	
	
	$("#nombreServicio").removeClass("valid");
	$("#codigoServicio").removeClass("valid");
	$("#descripcionServicio").removeClass("valid");
	$("#precioServicio").removeClass("valid");
	

	$("#nombreServicio").removeClass("invalid");
	$("#codigoServicio").removeClass("invalid");
	$("#descripcionServicio").removeClass("invalid");
	$("#precioServicio").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de un nuevo servicio
function validarGuardadoNuevoServicio(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreServicio").val().trim().length == 0 ){
		
		$("#label_nombreServicio").addClass( "active" );
		$("#nombreServicio").addClass( "invalid" );
		sw = 1;
	}
	

	if( $("#codigoServicio").val().trim().length == 0 ){
		
		$("#label_codigoServicio").addClass( "active" );
		$("#codigoServicio").addClass( "invalid" );
		sw = 1;
	}
	
	if( $("#descripcionServicio").val().trim().length == 0 ){
		
		$("#label_descripcionServicio").addClass( "active" );
		$("#descripcionServicio").addClass( "invalid" );
		sw = 1;
	}	

	
	if( $("#precioServicio").val().trim().length == 0 ){
		
		$("#label_precioServicio").addClass( "active" );
		$("#precioServicio").addClass( "invalid" );
		sw = 1;
	}	
	
	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoServicio").submit();
	}	
		
}
//---


//funcion para desactivar un servicio
function desactivarServicio(idServicio){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/servicios/desactivarServicio.php",
        dataType: "html",
        type : 'POST',
        data: { idServicio : idServicio },
        success: function(data) {			

			$('#spanB_'+idServicio).html('<a id="'+idServicio+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarServicio(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un servicio
function activarServicio(idServicio){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/servicios/activarServicio.php",
        dataType: "html",
        type : 'POST',
        data: { idServicio : idServicio },
        success: function(data) {			

			$('#spanB_'+idServicio).html('<a id="'+idServicio+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarServicio(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar servicio al escribir
function buscarServicioListados(){
   

    $('#buscarServicio').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/servicios/buscarServicio.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringServicio : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idServicioBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/servicios/mostrarBusquedaServicio.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idServicio : $("#idServicioBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoServiciosAjax").html(data);
						
						$("#resultadoServicios").hide('slower');	   
						$("#resultadoServiciosAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el un servicios
function editarServicio(idServicio, nombre, codigo, descripcion, precio){

	cancelarGuardadoNuevoServicio();
	
	$("#idEditarServicio").val(idServicio);
	$("#nombreEditarServicio").val(nombre);
	$("#codigoEditarServicio").val(codigo);
	$("#descripcionEditarServicio").val(descripcion);
	$("#precioEditarServicio").val(precio);
	$("#replicaNombre").val(nombre);
	
	$("#label_nombreEditarServicio").addClass( "active" );
	$("#label_codigoEditarServicio").addClass( "active" );
	$("#label_descripcionEditarServicio").addClass( "active" );
	$("#label_precioEditarServicio").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarServicio").show('slower');
		
}
//---


//funcion para cancelar la edicion de un servicio
function cancelarEdicionServicio(){

	$("#hidden_editarServicio").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarServicio").val("");
	$("#nombreEditarServicio").val("");
	$("#codigoEditarServicio").val("");
	$("#descripcionEditarServicio").val("");
	$("#precioEditarServicio").val("");
	$("#replicaNombre").val("");
	
	$("#label_nombreEditarServicio").removeClass("active");	
	$("#label_codigoEditarServicio").removeClass("active");	
	$("#label_descripcionEditarServicio").removeClass("active");	
	$("#label_precioEditarServicio").removeClass("active");	
	
	$("#nombreEditarServicio").removeClass("valid");
	$("#codigoEditarServicio").removeClass("valid");
	$("#descripcionEditarServicio").removeClass("valid");
	$("#precioEditarServicio").removeClass("valid");	

	$("#nombreEditarServicio").removeClass("invalid");
	$("#codigoEditarServicio").removeClass("invalid");
	$("#descripcionEditarServicio").removeClass("invalid");
	$("#precioEditarServicio").removeClass("invalid");		
	
}
//---

//funcion para validar la edicion de un servicio
function comprobarEdicionServicio(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarServicio").val() == "" ){		
		sw = 1;
	}

	if( $("#nombreEditarServicio").val().trim().length == 0 ){
		
		$("#label_nombreEditarServicio").addClass( "active" );
		$("#nombreEditarServicio").addClass( "invalid" );
		sw = 1;
	}


	if( $("#codigoEditarServicio").val().trim().length == 0 ){
		
		$("#label_codigoEditarServicio").addClass( "active" );
		$("#codigoEditarServicio").addClass( "invalid" );
		sw = 1;
	}


	if( $("#precioEditarServicio").val().trim().length == 0 ){
		
		$("#label_precioEditarServicio").addClass( "active" );
		$("#precioEditarServicio").addClass( "invalid" );
		sw = 1;
	}
	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarServicio").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un servicio
function cerrarBusquedaServicio(){
	
	$("#resultadoServiciosAjax").hide('slower');
	$("#buscarServicio").val("");	
	$("#buscarServicio").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoServicios").show('slower');
	
}
//---

//generar un codigo aleatorio
function generarCodigoServicio(idCampo){
	
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


/*
 *Servicios
 */








/*
 * Tipos de cita
 */

//funcion para mostrar el formulario de crear un nuevo tipo de cita
function mostrarFormNuevoTipoCita(){
	
	$("#hidden_NuevoTipoCita").show('slower');
	
}
//---

//funcion para cancelar la creación de un nuevo tipo de cita
function cancelarGuardadoNuevoTipoCita(){
	
	
	$("#hidden_NuevoTipoCita").hide('slower');
	
	
	$("#nombreTipoCita").val("");
	
	
	//se remueve las clases activas
	$("#label_nombreTipoCita").removeClass("active");
	
	
	
	$("#nombreTipoCita").removeClass("valid");
	
	

	$("#nombreTipoCita").removeClass("invalid");
	
	

	
}
//---

//funcion para validar el guardado de un nuevo TipoCita
function validarGuardadoNuevoTipoCita(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreTipoCita").val().trim().length == 0 ){
		
		$("#label_nombreTipoCita").addClass( "active" );
		$("#nombreTipoCita").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevoTipoCita").submit();
	}	
		
}
//---


//funcion para desactivar un TipoCita
function desactivarTipoCita(idTipoCita){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/tiposCita/desactivarTipoCita.php",
        dataType: "html",
        type : 'POST',
        data: { idTipoCita : idTipoCita },
        success: function(data) {			

			$('#spanTC_'+idTipoCita).html('<a id="'+idTipoCita+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarTipoCita(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar un TipoCita
function activarTipoCita(idTipoCita){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/tiposCita/activarTipoCita.php",
        dataType: "html",
        type : 'POST',
        data: { idTipoCita : idTipoCita },
        success: function(data) {			

			$('#spanTC_'+idTipoCita).html('<a id="'+idTipoCita+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarTipoCita(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar vacuna al escribir
function buscarTipoCitaListados(){
   

    $('#buscarTipoCita').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/tiposCita/buscarTipoCita.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringTipoCita : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idTipoCitaBuscado").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/tiposCita/mostrarBusquedaTipoCita.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idTipoCita : $("#idTipoCitaBuscado").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoTipoCitasAjax").html(data);
						
						$("#resultadoTipoCitas").hide('slower');	   
						$("#resultadoTipoCitasAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de un TipoCita
function editarTipoCita(idTipoCita, nombreTipoCita){

	cancelarGuardadoNuevoTipoCita();
	
	$("#idEditarTipoCita").val(idTipoCita);
	$("#editarNombreTipoCita").val(nombreTipoCita);
	
	$("#replicaNombre").val(nombreTipoCita);
	
	$("#label_editarNombreTipoCita").addClass( "active" );
	
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarTipoCita").show('slower');
		
}
//---


//funcion para cancelar la edicion de un TipoCita
function cancelarEdicionTipoCita(){

	$("#hidden_editarTipoCita").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarTipoCita").val("");
	$("#editarNombreTipoCita").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreTipoCita").removeClass("active");	
	
	$("#editarNombreTipoCita").removeClass("valid");	

	$("#editarNombreTipoCita").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de un TipoCita
function comprobarEdicionTipoCita(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarTipoCita").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreTipoCita").val().trim().length == 0 ){
		
		$("#label_editarNombreTipoCita").addClass( "active" );
		$("#editarNombreTipoCita").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarTipoCita").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de un TipoCita
function cerrarBusquedaTipoCita(){
	
	$("#resultadoTipoCitasAjax").hide('slower');
	$("#buscarTipoCita").val("");	
	$("#buscarTipoCita").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoTipoCitas").show('slower');
	
}
//---


/*
 * Fin TipoCita
 */




/*
 * Vacunas
 */

//funcion para mostrar el formulario de crear una nueva vacuna
function mostrarFormNuevaVacuna(){
	
	$("#hidden_NuevaVacuna").show('slower');
	
}
//---

//funcion para cancelar la creación de una nueva vacuna
function cancelarGuardadoNuevaVacuna(){
	
	
	$("#hidden_NuevaVacuna").hide('slower');
	
	
	$("#nombreVacuna").val("");
	$("#descripcionVacuna").val("");
	
	//se remueve las clases activas
	$("#label_nombreVacuna").removeClass("active");
	$("#label_descripcionVacuna").removeClass("active");
	
	
	$("#nombreVacuna").removeClass("valid");
	$("#descripcionVacuna").removeClass("valid");
	

	$("#nombreVacuna").removeClass("invalid");
	$("#descripcionVacuna").removeClass("invalid");
	

	
}
//---

//funcion para validar el guardado de una nueva vacuna
function validarGuardadoNuevaVacuna(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar


	if( $("#nombreVacuna").val().trim().length == 0 ){
		
		$("#label_nombreVacuna").addClass( "active" );
		$("#nombreVacuna").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_nuevaVacuna").submit();
	}	
		
}
//---


//funcion para desactivar una vacuna
function desactivarVacuna(idVacuna){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanActivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/vacunas/desactivarVacuna.php",
        dataType: "html",
        type : 'POST',
        data: { idVacuna : idVacuna },
        success: function(data) {			

			$('#spanB_'+idVacuna).html('<a id="'+idVacuna+'" class="waves-effect red darken-1 btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="activarVacuna(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---


//funcion para activar una vacuna
function activarVacuna(idVacuna){
	
	$('.tooltipped').tooltip('remove');
	var txt = $("#spanDesactivar").html();
	$.ajax({
  		url: "http://www.nanuvet.com/Controllers/listados/vacunas/activarVacuna.php",
        dataType: "html",
        type : 'POST',
        data: { idVacuna : idVacuna },
        success: function(data) {			

			$('#spanB_'+idVacuna).html('<a id="'+idVacuna+'" class="waves-effect waves-light btn tooltipped" data-position="right" data-delay="50" data-tooltip="'+txt+'" onclick="desactivarVacuna(this.id)" ><i class="fa fa-power-off fa-2x" aria-hidden="true"></i></a>');
			$('.tooltipped').tooltip({delay: 50});
        }//fin success
  	});		
	
}
//---



//buscar vacuna al escribir
function buscarVacunaListados(){
   

    $('#buscarVacuna').autocomplete({
    	source: function(request, response) {
	        $.ajax({
	      		url: "http://www.nanuvet.com/Controllers/listados/vacunas/buscarVacuna.php",
	            dataType: "json",
	            type : 'POST',
	            data: {
	            	    stringVacuna : request.term,//se envia el string a buscar
	            	},
	            success: function(data) {
	                 response(data);
	            }
	      	});
     	},
        minLength: 3,
        select: function(event, ui){
        		
				$("#idVacunaBuscada").val(ui.item.id); 	
        		

				$.ajax({
		      		url: "http://www.nanuvet.com/Controllers/listados/vacunas/mostrarBusquedaVacuna.php",
		            dataType: "html",
		            type : 'POST',
		            data: {
		            	    idVacuna : $("#idVacunaBuscada").val()
		            	},
		            success: function(data) {
		                 
						$("#resultadoVacunasAjax").html(data);
						
						$("#resultadoVacunas").hide('slower');	   
						$("#resultadoVacunasAjax").show('slower');	                 
						$("#btnCancelarBusqueda").show('slower');	   
						$('.tooltipped').tooltip({delay: 50});              
		                 
		            }
		      	});

        		
        			   			
        }
    	
  	}); 
   
   
    
}
//---


//funcion para editar el nombre de una vacuna
function editarVacuna(idVacuna, nombreVacuna, descripcion){

	cancelarGuardadoNuevaVacuna();
	
	$("#idEditarVacuna").val(idVacuna);
	$("#editarNombreVacuna").val(nombreVacuna);
	$("#editarDescripcionVacuna").val(descripcion);
	$("#replicaNombre").val(nombreVacuna);
	
	$("#label_editarNombreVacuna").addClass( "active" );
	$("#label_editarDescripcionVacuna").addClass( "active" );
	
	$("#tituloLi").hide('slower');
	$("#hidden_editarVacuna").show('slower');
		
}
//---


//funcion para cancelar la edicion de una vacuna
function cancelarEdicionVacuna(){

	$("#hidden_editarVacuna").hide('slower');
	
	$("#tituloLi").show('slower');

	$("#idEditarVacuna").val("");
	$("#editarNombreVacuna").val("");	
	$("#editarDescripcionVacuna").val("");	
	$("#replicaNombre").val("");
	
	$("#label_editarNombreVacuna").removeClass("active");	
	$("#label_editarDescripcionVacuna").removeClass("active");	
	
	$("#editarNombreVacuna").removeClass("valid");	
	$("#editarDescripcionVacuna").removeClass("valid");	

	$("#editarNombreVacuna").removeClass("invalid");	
	$("#editarDescripcionVacuna").removeClass("invalid");	
	
}
//---

//funcion para validar la edicion de una vacuna
function comprobarEdicionVacuna(){
	
	var sw = 0; // variable para determinar si existen campos sin diligenciar	

	if( $("#idEditarVacuna").val() == "" ){		
		sw = 1;
	}

	if( $("#editarNombreVacuna").val().trim().length == 0 ){
		
		$("#label_editarNombreVacuna").addClass( "active" );
		$("#editarNombreVacuna").addClass( "invalid" );
		sw = 1;
	}

	
	if(sw == 1){
		return false;
	}else{
		$("#form_editarVacuna").submit();
	}
	
}
//---

//funcion para ocultar la busqueda de una vacuna
function cerrarBusquedaVacuna(){
	
	$("#resultadoVacunasAjax").hide('slower');
	$("#buscarVacuna").val("");	
	$("#buscarVacuna").blur();	
	$("#btnCancelarBusqueda").hide('slower');
	
	
	$("#resultadoVacunas").show('slower');
	
}
//---


/*
 * Vacunas
 */







