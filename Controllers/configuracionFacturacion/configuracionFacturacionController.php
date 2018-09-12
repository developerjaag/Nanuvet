<?php


/*
 * Controlador para las configuraciones de facturacion
 */


     if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
     	
		require_once("Models/configuracionFacturacion_model.php");
		 
		 $objetoConfiguracion = new configuracionFacturacion();
		
		
		//si se envia el formulario de una nueva resolucion
		if( isset($_POST['hidden_enviarFormNuevaResolucion']) and $_POST['hidden_enviarFormNuevaResolucion'] == "enviar" ){
			
			//se reciben las variables
			$numeroResolucion 				= $_POST['resolucion_numero'];
			$resolucion_autocorrectorIva 	= $_POST['resolucion_autocorrectorIva'];
			$resolucion_porcentajeIva 		= $_POST['resolucion_porcentajeIva'];
			$resolucion_consecutivoInicial 	= $_POST['resolucion_consecutivoInicial'];
			$resolucion_consecutivoFinal 	= $_POST['resolucion_consecutivoFinal'];
			$resolucion_iniciarEn 			= $_POST['resolucion_iniciarEn'];
			$resolucion_fecha 				= $_POST['resolucion_fecha'];
			$resolucion_fechaVencimiento 	= $_POST['resolucion_fechaVencimiento'];
			
			
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		        switch($_SESSION['usuario_idioma']){
		            
		            case 'Es':
		        		$error="Algo salió mal";
		        		$ok="Resolución guardada correctamente!";
		        		break;
		        		
		        	case 'En':
		        		$error="Something went wrong";
		        		$ok="Resolution saved successfully!";
		        		break;
		            
		        }//fin swtich
		        
		     
		     //validar si algun campo obligatorio llega vacio
		        if( ($numeroResolucion == "") or ($resolucion_autocorrectorIva == "") or ($resolucion_porcentajeIva == "") or ($resolucion_consecutivoInicial == "") or ($resolucion_consecutivoFinal == "") or ($resolucion_fecha == "")  ){
		        			
					
		             $sw = 1;			
		             $_SESSION['mensaje']   = $error;
					 
		         }//fin if validar los campos
		         
		         if($sw == 0){
		         	
					if($resolucion_iniciarEn != ""){
						
						$proximaFactura = $resolucion_iniciarEn;
					}else{
						$proximaFactura = $resolucion_consecutivoInicial;
					}
			
					$objetoConfiguracion->guardarNuevaResolucion($numeroResolucion, $resolucion_autocorrectorIva, $resolucion_porcentajeIva, $resolucion_consecutivoInicial,
																	$resolucion_consecutivoFinal, $resolucion_iniciarEn, $resolucion_fecha, $resolucion_fechaVencimiento, $proximaFactura);
					
					$_SESSION['mensaje']   =   $ok;
					
				 }//fin if para guardar la nueva resolucion
			
				//se redirecciona nuevamente a configuracionFacturacion
	       		 header('Location: '.Config::ruta().'configuracionFacturacion/' );	
				 		
				exit();
			
			
		}//fin if si se envia el formulario de una nueva resolucion
		
		
		
		//si se envia el formulario de un nuevo facturador
		if( isset($_POST['hidden_enviarFormNuevoFacturador']) and $_POST['hidden_enviarFormNuevoFacturador'] == "enviarFacturador" ){
			
			//se reciben las variables
			$facturador_identifiacion				= $_POST['facturador_identifiacion'];
			$facturador_nombre						= $_POST['facturador_nombre'];
			$facturador_apellido					= $_POST['facturador_apellido'];
			$facturador_telefono					= $_POST['facturador_telefono'];
			$facturador_celular						= $_POST['facturador_celular'];
			$facturador_direccion					= $_POST['facturador_direccion'];
			$facturador_email						= $_POST['facturador_email'];
			$facturador_tipoRegimen					= $_POST['facturador_tipoRegimen'];
			$facturador_razonSocial					= $_POST['facturador_razonSocial'];
			$facturador_identifiacionEmisor			= $_POST['facturador_identifiacionEmisor'];
			$facturador_nombreEmisor				= $_POST['facturador_nombreEmisor'];
			
			
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		        switch($_SESSION['usuario_idioma']){
		            
		            case 'Es':
		        		$error="Algo salió mal";
		        		$ok="Facturador guardado correctamente!";
		        		break;
		        		
		        	case 'En':
		        		$error="Something went wrong";
		        		$ok="Biller saved successfully!";
		        		break;
		            
		        }//fin swtich
		        
		        
		         //validar si algun campo obligatorio llega vacio
		        if( ($facturador_nombreEmisor == "") or ($facturador_identifiacionEmisor == "") or ($facturador_razonSocial == "") 
		        	or ($facturador_email == "") or ($facturador_direccion == "")
		        	or ($facturador_telefono == "") or ($facturador_apellido == "") or ($facturador_nombre == "") or ($facturador_identifiacion == "")  ){
		        			
					
		             $sw = 1;			
		             $_SESSION['mensaje']   = $error;
					 
		         }//fin if validar los campos
		         
		         if($sw == 0){
		         	
			
					$objetoConfiguracion->guardarNuevoFacturador($facturador_identifiacion, $facturador_nombre, $facturador_apellido, $facturador_telefono,
																$facturador_celular, $facturador_direccion, $facturador_email, $facturador_tipoRegimen,
																$facturador_razonSocial, $facturador_identifiacionEmisor, $facturador_nombreEmisor);
					
					$_SESSION['mensaje']   =   $ok;
					
				 }//fin if para guardar la nueva resolucion
		        
			
			//se redirecciona nuevamente a configuracionFacturacion
       		 header('Location: '.Config::ruta().'configuracionFacturacion/' );	
			 		
			exit();
			
		}//fin if si se envia un nuevo facturador

		
		
		//si se envia el formulario de un nuevo facturador
		if( isset($_POST['editar_facturador_id']) and $_POST['editar_facturador_id'] != "0" ){
			
			//se reciben las variables
			$idFacturador							= $_POST['editar_facturador_id'];
			$facturador_identifiacion				= $_POST['editar_facturador_identifiacion'];
			$facturador_nombre						= $_POST['editar_facturador_nombre'];
			$facturador_apellido					= $_POST['editar_facturador_apellido'];
			$facturador_telefono					= $_POST['editar_facturador_telefono'];
			$facturador_celular						= $_POST['editar_facturador_celular'];
			$facturador_direccion					= $_POST['editar_facturador_direccion'];
			$facturador_email						= $_POST['editar_facturador_email'];
			$facturador_tipoRegimen					= $_POST['editar_facturador_tipoRegimen'];
			$facturador_razonSocial					= $_POST['editar_facturador_razonSocial'];
			$facturador_identifiacionEmisor			= $_POST['editar_facturador_identifiacionEmisor'];
			$facturador_nombreEmisor				= $_POST['editar_facturador_nombreEmisor'];
			
			
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		        switch($_SESSION['usuario_idioma']){
		            
		            case 'Es':
		        		$error="Algo salió mal";
		        		$ok="Facturador editado correctamente!";
		        		break;
		        		
		        	case 'En':
		        		$error="Something went wrong";
		        		$ok="Biller edit successfully!";
		        		break;
		            
		        }//fin swtich
		        
		        
		         //validar si algun campo obligatorio llega vacio
		        if( ($facturador_nombreEmisor == "") or ($facturador_identifiacionEmisor == "") or ($facturador_razonSocial == "") 
		        	or ($facturador_email == "") or ($facturador_direccion == "")
		        	or ($facturador_telefono == "") or ($facturador_apellido == "") or ($facturador_nombre == "") or ($facturador_identifiacion == "")  ){
		        			
					
		             $sw = 1;			
		             $_SESSION['mensaje']   = $error;
					 
		         }//fin if validar los campos
		         
		         if($sw == 0){
		         	
			
					$objetoConfiguracion->guardarEdicionFacturador($idFacturador, $facturador_identifiacion, $facturador_nombre, $facturador_apellido, $facturador_telefono,
																$facturador_celular, $facturador_direccion, $facturador_email, $facturador_tipoRegimen,
																$facturador_razonSocial, $facturador_identifiacionEmisor, $facturador_nombreEmisor);
					
					$_SESSION['mensaje']   =   $ok;
					
				 }//fin if para guardar la nueva resolucion
		        
			
			//se redirecciona nuevamente a configuracionFacturacion
       		 header('Location: '.Config::ruta().'configuracionFacturacion/' );	
			 		
			exit();
			
		}//fin if si se envia un nuevo facturador		
		
		
				
		//consultar las resoluciones existentes
		$listadoResoluciones = $objetoConfiguracion->listarResoluciones();
		
		//consultar los facturadores existentes
		$listadoFacturadores = $objetoConfiguracion->listarFacturadores();
		
		//consultar el facturador por defecto
		$configuraciones = $objetoConfiguracion->consultarConfiguracionesPorDefecto();
		
		$idFacturadorPorDefecto = $configuraciones[0]['idFacturadorPorDefecto'];
		
		
 		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
			
		//se importa la vista de los usuarios
		require_once("Views/configuracionFacturacion/configuracionFacturacion.phtml");	
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
 
     	
		
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    				

?>