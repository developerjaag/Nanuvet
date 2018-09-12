/*
 * Funciones par alos permisos
 */

/*
 * Funcion mostrar video tutorial y darle play
 */
function playVideoTutorial(){
	
	$("#div_videoTutorial").show("slower");
	$('#videoTutorial_permisos').get(0).play();
	
}
//---

/*
 * Funcion para cerrar el video tutorial
 */
function cerrarVideoTutorial(){
	$('#videoTutorial_permisos').get(0).pause();
	$("#div_videoTutorial").hide("slower");
}


//funcion para consultar los permisos de un usuarios seleccionado
function consultarPermisosUsuario(idSelect, permiso){
	
	if(permiso == 1){
		//se activan todos los checbox
		$("input[type='checkbox']").removeAttr("disabled");
		
	}
	
	//consultar que permisos tiene activos el usuario
	
	$.ajax({
  		url: "../Controllers/permisos/consultarPermisosUsuario.php",
        dataType: "json",
        type : 'POST',
        data: { idUsuario : $("#SelectUsuarios").val() },
        success: function(data) {			
	
			$('input[type=checkbox]').each(function(index,e){
				var $this = $(this);
				
				var id = $this.attr("id");
								
				id = id.substr(3,3);//para tomar solo los numeros de los ids
				
				for(var i = 0; i < data.length; i++){
					
				  if(data[i].idPermiso == id){
				    
				    $("#cx_"+id).prop('checked', true);
				    
				    i = data.length+i;
				    
				  }else{
				  	$("#cx_"+id).prop('checked', false);
				  }
				  
				}
				
				
			});

        }//fin success
  	});
	
}
//---


//funcion para cambiar el estado de un permiso
function cambiarPermiso(idCheckbox){
	
	var estado = "";
	
	if( $('#'+idCheckbox).is(':checked') ) {
	   
	   estado = 'A';
	   
	}else{
		
		estado = 'I';
		
	}//fin else
	
	
	//se corta el id del checkbox para enviar el numero del permiso
	var idPermiso	= idCheckbox.substr(3,3);
	
	$.ajax({
  		url: "../Controllers/permisos/cambiarEstadoPermiso.php",
        dataType: "json",
        type : 'POST',
        data: { idPermiso : idPermiso, estado : estado, idUsuario : $("#SelectUsuarios").val() },
        success: function(data) {			

			if(data != 'OK'){
				$("#"+idCheckbox).attr('checked', false);
			}//fin if

        }//fin success
  	});
	
	
	
}
//---
