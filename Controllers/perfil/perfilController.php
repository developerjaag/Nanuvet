<?php

    /*
        * Contolador para gestionar el perfil de un usuario
    */
    
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    	
				
		//se importa el modelo
		require_once("Models/perfil_model.php"); 
		
		//se intancia el objeto
		$objetoPerfil 	= new perfiles();
		$idUsuario		= $_SESSION['usuario_idUsuario'];
		
		
		//si se envia el formulario para actualizar los datos
		if( isset($_POST['hidden_envioForm']) and $_POST['hidden_envioForm'] == "enviar" ){
			
			//se inicializan las variables con los datos que lleguen
			$idUsuario		= $_SESSION['usuario_idUsuario'];
			$identificacion	= $_POST['identificacion'];
			$nombres		= $_POST['nombres'];
			$apellidos		= $_POST['apellidos'];
			$telefono		= $_POST['telefono'];
			$celular		= $_POST['celular'];
			$direccion		= $_POST['direccion'];
			$email			= $_POST['email'];
			$idioma			= $_POST['idioma'];
			
			$sw        = 0;//para controlar si entra en un error_get_last
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
	        		$ok="Información actualizada correctamente!";
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
	        		$ok="Information successfully updated!";
	        		break;
	            
	        }//fin swtich
			
			
			//validar si algun campo obligatorio llega vacio
	        if(($identificacion == "") or ($nombres == "") or ($email == "")){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
			
			
			if($sw == 0){
				
				$urlFoto	= "";
				
				//se pregunta si se subio una imagen
	             if($_FILES['fotoUsuario']['tmp_name']!=""){
	                 
		                 //validar el tipo de archivo subido
		                 if( ($_FILES['fotoUsuario']['type'] == "image/jpg" ) or ( $_FILES['fotoUsuario']['type'] == "image/JPG" ) 
		                 		or ( $_FILES['fotoUsuario']['type'] == "image/png" ) or ( $_FILES['fotoUsuario']['type'] == "image/PNG" ) 
		                 		or ( $_FILES['fotoUsuario']['type'] == "image/jpeg" ) or ( $_FILES['fotoUsuario']['type'] == "image/JPEG" )   ){
		                     
		                     //se copia el archivo en el servidor
		                     
		                     //se construye el nombre para el archivo
		                     $nombreArchivo = $_SESSION['usuario_idUsuario'];
						     
						     $tmpNombreFotoServidor = $_FILES["fotoUsuario"]["tmp_name"];  //nombre que el  servidor le da al archivo
						     
						     $ext = explode(".", $_FILES["fotoUsuario"]["name"]); // se toma la extension del archivo
						     
						     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/img_usuarios/";
						     //si no existe la ruta se crea
						     if(!is_file($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreFotoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/img_usuarios/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						     $urlFoto   = $nombreArchivo;				     
						     
		                     
		                 }//fin if validar tipo de archivo
		                 
	                 }//fin if para saber si se ingreso foto
	                 
	                 
	                 //se llama al metodo que actualiza la información
	                 $objetoPerfil->actualizarUsuario($idUsuario,$identificacion,$nombres,$apellidos,$telefono,$celular,$direccion,$email,$idioma,$urlFoto);
				
				
					//se actualiza la variable de session del idioma
			
					if($idioma == '1'){
						$_SESSION['usuario_idioma'] = 'Es';
					}else if($idioma == '2'){
						$_SESSION['usuario_idioma'] = 'En';
					}
					
					$_SESSION['mensaje'] = $ok;
					
			}//fin if $sw
			
			 //se redirecciona nuevamente a perfil
       		 header('Location: '.Config::ruta().'perfil/' );	
			 		
			exit();
			
		}//fin if si se envia el formulario
		
		
		
		
		//consultar los datos del usuario para cargarlos en el formulario

		//se llama al metodo que devuelve los datos del usuario
		$datosUsuario	= $objetoPerfil->consultarDatosUsuario($idUsuario);
		
		
		//se actualizan las variables de sesion del nombre y del idioma
		$_SESSION['usuario_idioma'] 		= $datosUsuario['urlArchivo']; 
		$_SESSION['usuario_nombre'] 		= $datosUsuario['nombre'];
		$_SESSION['usuario_identificacion']	= $datosUsuario['identificacion'];
		$_SESSION['usuario_urlFoto']		= $datosUsuario['urlFoto'];
		
		
		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
			
		//se importa la vista del perfil
		require_once("Views/perfil/perfil.phtml");	
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
			
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    	