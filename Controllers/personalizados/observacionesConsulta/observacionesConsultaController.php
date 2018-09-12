<?php

/*
 * Controlador para los personalizados de motivo de consulta
 */

	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){ 
 
 
 		if(is_file("Models/personalizados_model.php")){
 			
	 		//se importa el modelo
			require_once("Models/personalizados_model.php"); 
			
 		}else{
 			
	 		//se importa el modelo
			require_once("../../../Models/personalizados_model.php");  			
 		}
 

		//se declara el objeto
		$objetoPersonalizados = new personalizados();
		
		
		//validar si se envia el formulario de un nuevo personalizado
		if(isset($_POST['envioNuevoOC']) and $_POST['envioNuevoOC'] == "envio" ){
			
			//se reciben las variables
			$titulo		= $_POST['tituloPersonalizadoOC'];
			$texto		= trim($_POST['observacionesConsulta']);
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Personalizado guardado correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Custom saved successfully!";
		    		break;
		        
		    }//fin swtich
		    
		    //validar si algun campo obligatorio llega vacio
		    if(($titulo == "") or ($texto == "")){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos	
		     
		     
		     if($sw == 0){
		     	
				$idUsuario = $_SESSION['usuario_idUsuario'];
		     
			 	$guardarPersonalizado  = $objetoPersonalizados->guardarPersonalizadoObservacionesConsulta($titulo, $texto, $idUsuario);
		        
		        $_SESSION['mensaje']   = $ok;	

				//se redirecciona nuevamente a personalizados 
				 header('Location: '.Config::ruta().'personalizados/observacionesConsulta/' );	
				 		
				exit();	
				
			 }//fin sw == 0     
		     		
			
			
		}//fin if si se envia un nuevo personalizado
		
		
		
		
		//validar si se envia la edicion de un personalizado
		if(isset($_POST['idPersonalizadoOC']) and $_POST['idPersonalizadoOC'] != "" ){
					
						//se reciben las variables
			$idPersonalizado	= $_POST['idPersonalizadoOC'];			
			$titulo				= $_POST['editarTituloPersonalizadoOC'];
			$texto				= trim($_POST['editarObservacionesConsulta']);
			
			$sw        = 0;//para controlar si entra en un error_get_last
		        
		    switch($_SESSION['usuario_idioma']){
		        
		        case 'Es':
		    		$error="Algo salió mal";
		    		$ok="Personalizado editado correctamente!";
		    		break;
		    		
		    	case 'En':
		    		$error="Something went wrong";
		    		$ok="Custom edit successfully!";
		    		break;
		        
		    }//fin swtich
		    
		    //validar si algun campo obligatorio llega vacio
		    if(($titulo == "") or ($texto == "")){
		         $sw = 1;			
		         $_SESSION['mensaje']   = $error;
		     }//fin if validar los campos	
		     
		     
		     if($sw == 0){
		     	
		     
			 	$editarPersonalizado  = $objetoPersonalizados->editarPersonalizadoObservacionesConsulta($idPersonalizado, $titulo, $texto);
		        
		        $_SESSION['mensaje']   = $ok;	

				//se redirecciona nuevamente a personalizados 
				 header('Location: '.Config::ruta().'personalizados/observacionesConsulta/' );	
				 		
				exit();	
				
			 }//fin sw == 0     	
			
		}//fin if si llega la edicion de un personalizado

		
 	//se consulta el total de los personalizados existentes
		$TotalPersonalizados = $objetoPersonalizados->tatalPersonalizadosOC();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$idUsuario = $_SESSION['usuario_idUsuario'];
		
		$listadoPersonalizados = $objetoPersonalizados->listarPersonalizadosOC($idUsuario, $paginaActual,$records_per_page);//se llama al metodo para listar los personalizados segun los limites de la consulta
		
		$pagination->records($TotalPersonalizados);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación		

    }else{
        header('Location: '.Config::ruta());
		exit();
    } 

?>