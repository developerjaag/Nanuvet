<?php

/*
 * Controlador para el modulo cuenta
 */

 
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 		
		//se importa el modelo
		require_once ("Models/cuenta_model.php");
		
		//se instancia el objeto
		$objetoCuenta	= new cuenta();
		
		
		//en caso tal de que se envie el formulario
		if(isset($_POST['hidden_envioForm']) and $_POST['hidden_envioForm'] == "enviar" ){
			
			//se reciebn la variables
			$identificacion	= $_POST['identificacion'];
			$nombre			= $_POST['nombre'];
			$telefono1		= $_POST['telefono1'];
			$telefono2		= $_POST['telefono2'];
			$celular		= $_POST['celular'];
			$direccion		= $_POST['direccion'];
			$email			= $_POST['email'];
			
			
			$sw        = 0;//para controlar si entra en un error_get_last
			
			function comprobar_email($email){ 
				   	$mail_correcto = 0; 
				   	//compruebo unas cosas primeras 
				   	if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
				      		if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
				         		//miro si tiene caracter . 
				         		if (substr_count($email,".")>= 1){ 
				            	//obtengo la terminacion del dominio 
				            	$term_dom = substr(strrchr ($email, '.'),1); 
					            	//compruebo que la terminación del dominio sea correcta 
					            	if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
					               	//compruebo que lo de antes del dominio sea correcto 
					               	$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
					               	$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
						               	if ($caracter_ult != "@" && $caracter_ult != "."){ 
						                  	$mail_correcto = 1; 
						               		} 
					            	} 
					         	} 
					      	} 
					   	} 
					   	if ($mail_correcto) 
					      	return 1; 
					   	else 
					      	return 0; 
				}

			
			$resultadoEmail	= comprobar_email($email);
	
			if($resultadoEmail == 0){
				$sw = 2;
			}
			
        
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
	        if(($identificacion == "") or ($nombre == "") or ($telefono1 == "") or ($celular == "") or ($direccion == "") or ($email == "")){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
	        
	        
	        if($sw == 0){
				
				$urlFoto	= "";
				
				
				//se pregunta si se subio una imagen
	             if($_FILES['fotoCuenta']['tmp_name'] != ""){
                 
	                 //validar el tipo de archivo subido
	                 if( ( $_FILES['fotoCuenta']['type'] == "image/jpg" ) or ( $_FILES['fotoCuenta']['type'] == "image/JPG" ) 
		                 		or ( $_FILES['fotoCuenta']['type'] == "image/png" ) or ( $_FILES['fotoCuenta']['type'] == "image/PNG" ) 
		                 		or ( $_FILES['fotoCuenta']['type'] == "image/jpeg" ) or ( $_FILES['fotoCuenta']['type'] == "image/JPEG" )  ){
	                     
	                     //se copia el archivo en el servidor
	                     
	                     //se construye el nombre para el archivo
	                     $nombreArchivo = '1';
					     
					     $tmpNombreFotoServidor = $_FILES["fotoCuenta"]["tmp_name"];  //nombre que el  servidor le da al archivo
					    
					     $ext = explode(".", $_FILES["fotoCuenta"]["name"]); // se toma la extension del archivo
					     
					     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
					     
					     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/logoClinica/";
					     //si no existe la ruta se crea
					     if(!is_file($ruta)){
	                        	@mkdir($ruta,0774, true);
	                        }
					     
					     copy($tmpNombreFotoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/logoClinica/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
					     
					     $urlFoto   = $nombreArchivo;				     
					     
	                     
	                 }//fin if validar tipo de archivo
	                 
                 }//fin if para saber si se ingreso foto
				
				//se llama al metodo par actualizar la informacion
				$objetoCuenta->actualizarInformacionCuenta($identificacion, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlFoto);
				
				$_SESSION['mensaje'] = $ok;
				
				 //se redirecciona nuevamente a cuenta
	       		 header('Location: '.Config::ruta().'cuenta/' );	
				 		
				exit();
				
			}else if($sw == 2){
				
				$_SESSION['mensaje'] = 'Error E-mail';
				
				//se redirecciona nuevamente a cuenta
	       		 header('Location: '.Config::ruta().'cuenta/' );	
				 		
				exit();
				
			}//fin if sw 
	         
			
			
		}//fin if si se envia el formulario
		
		
		//si se envia el formulario de vincular una licencia con un usuario
		if(isset($_POST['idLicenciaVincular']) and $_POST['idLicenciaVincular'] != "" ){
			
			switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
	        		$ok="Licencia vinculada correctamente!";
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
	        		$ok="License linked correctly!";
	        		break;
	            
	        }//fin swtich
			
			$idLicenciaVincular = $_POST['idLicenciaVincular'];
			$idUsuarioVincular  = $_POST['idUsuarioVincular'];
			
			$objetoCuenta->vincularLicenciaUsuario($idUsuarioVincular, $idLicenciaVincular);
			
			//marcar licencia como ocupada
			$objetoCuenta->ocuparLicencia($idLicenciaVincular);
			
			$_SESSION['mensaje'] = $ok;
			
			//se redirecciona nuevamente a cuenta
       		 header('Location: '.Config::ruta().'cuenta/' );	
			 		
			 exit();
			
		}//fin if si se vincula un usuairo con una licencia
	
		//se llam al metodo que consulta la informacion
		$informacionCuenta = $objetoCuenta->consultarInformacionCuenta();
 
 		$idCliente = $_SESSION['BDC_id'];
 
 		//consultar la informacion de las licencias
 		$ListadoLicencias = $objetoCuenta->consultarLicencias($idCliente);
		
		$totalLicencias = sizeof($ListadoLicencias);
		
		//consultar los usuarios sin licencia
		$usuariosSinLicencia = $objetoCuenta->usuariosSinLicencia();
		
		//se consulta ti es una cuenta demo o no
		$esDemo =  $objetoCuenta->consultarCuentaDemo($_SESSION['BDC_id']);
 
 
 		 //se llama al json que tiene los precios
		 $data = file_get_contents("Views/index/resources/precios.json");
		 $precios = json_decode($data, true);
		 
		 $tamano = sizeof($precios["precios"]);
 
 		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
		
		
		//saber si tiene permisos de acceder a cuenta
		
		if(!in_array("2", $_SESSION['permisos_usuario'] )){
			
			require_once("Views/Layout/sinPermiso.phtml");	
			
		}else{
			//se importa la vista de cuenta
			require_once("Views/cuenta/cuenta.phtml");	
		}
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
 
 
     }else{
        header('Location: '.Config::ruta());
		exit();
    } 
 
 
?>