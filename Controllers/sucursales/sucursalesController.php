<?php

/*
 * COntrolador para las sucursales
 */
 
	if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 
 
 		//se importa el modelo
		require_once("Models/sucursales_model.php"); 
		
		//se declara el objeto
		$objetoSucursales = new sucursales();
		
		
		//validar si se envia el formulario de una nueva sucursal
		if(isset($_POST['hidden_envioFormNueva']) and $_POST['hidden_envioFormNueva'] == "enviar" ){
			
			
			 	$identificativoNit          =   $_POST['sucursal_nit'];
		        $nombre                     =   $_POST['sucursal_nombre'];
		        $telefono1                  =   $_POST['sucursal_telefono1'];
		        $telefono2                  =   $_POST['sucursal_telefono2'];
		        $celular                    =   $_POST['sucursal_celular'];
		        $direccion                  =   $_POST['sucursal_direccion'];
		        $email                      =   $_POST['sucursal_email'];
		        $leyendaencabezado          =   $_POST['sucursal_leyendaEncabezado'];
				$latitud		            =   $_POST['sucursal_latitud'];
				$longitud			        =   $_POST['sucursal_longitud'];
		        $idPais                     =   $_POST['idPais'];
		        $idCiudad                   =   $_POST['idCiudad'];
		        $idBarrio                   =   $_POST['idBarrio'];
		        
		        $sw        = 0;//para controlar si entra en un error_get_last
		        
		        switch($_SESSION['usuario_idioma']){
		            
		            case 'Es':
		        		$error="Algo salió mal";
		        		$ok="Guardada correctamente!";
		        		break;
		        		
		        	case 'En':
		        		$error="Something went wrong";
		        		$ok="Saved successfully!";
		        		break;
		            
		        }//fin swtich
		        
		        
		        //validar si algun campo obligatorio llega vacio
		        if(($nombre == "") or ($telefono1 == "") or ($celular == "") or ($direccion == "") or ($idPais == "0") or ($idCiudad == "0") or ($idBarrio == "0")  ){
		             $sw = 1;			
		             $_SESSION['mensaje']   = $error;
		         }//fin if validar los campos
		         
		         //guardar el archivo si existe y generar la url
		         if($sw == 0){
		         	
					$urlLogo = "";
		             
		             //validar si se subio imagen
		             if($_FILES['sucursal_logo']['tmp_name']!=""){
		                 
		                 //validar el tipo de archivo subido
		                 if( ( $_FILES['sucursal_logo']['type'] == "image/jpg" ) or ( $_FILES['sucursal_logo']['type'] == "image/png" ) ){
		                     
		                     //se copia el archivo en el servidor
		                     
		                     //se construye el nombre para el archivo
		                     $nombreArchivo = $nombre;
						     $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre de la sucursal
						     
						     $tmpNombreLogoServidor = $_FILES["sucursal_logo"]["tmp_name"];  //nombre que el  servidor le da al archivo
						     
						     $ext = explode(".", $_FILES["sucursal_logo"]["name"]); // se toma la extension del archivo
						     
						     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/";
						     //si no existe la ruta se crea
						     if(!is_file($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreLogoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						     $urlLogo   = $nombreArchivo;
						     
						     
		                     
		                 }//fin if validar tipo de archivo
		                 
		             }//fin if para saber si se subio logo
		             
		             
		             $guardarSucursal    = $objetoSucursales->guardarSucursal($identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlLogo, $leyendaencabezado, $idPais, $idCiudad, $idBarrio, $latitud, $longitud  );
		                     
		             $_SESSION['mensaje']   =   $ok;
		             
		             
		         }//fin if para guardar el archivo y generar url
			
			
				//se redirecciona nuevamente a sucursales
	       		 header('Location: '.Config::ruta().'sucursales/' );	
				 		
				exit();
			
		}//fin if si llega formulario nueva sucursal
		
		
		//si se envia el formulario para editar una sucursal
		if(isset($_POST['editar_idSucursal']) and $_POST['editar_idSucursal'] != "" ){
			
				$idSucursal			        =   $_POST['editar_idSucursal'];
			
				$identificativoNit          =   $_POST['editar_sucursal_nit'];
		        $nombre                     =   $_POST['editar_sucursal_nombre'];
		        $telefono1                  =   $_POST['editar_sucursal_telefono1'];
		        $telefono2                  =   $_POST['editar_sucursal_telefono2'];
		        $celular                    =   $_POST['editar_sucursal_celular'];
		        $direccion                  =   $_POST['editar_sucursal_direccion'];
		        $email                      =   $_POST['editar_sucursal_email'];
		        $leyendaencabezado          =   $_POST['editar_sucursal_leyendaEncabezado'];
				$latitud		            =   $_POST['editar_sucursal_latitud'];
				$longitud			        =   $_POST['editar_sucursal_longitud'];
		        $idPais                     =   $_POST['editar_idPais'];
		        $idCiudad                   =   $_POST['editar_idCiudad'];
		        $idBarrio                   =   $_POST['editar_idBarrio'];
				
				if(isset($_POST['editar_sucursal_estado'])){
					$estado = "A";
				}else{
					$estado = "I";
				}
				
		        
		        $sw        = 0;//para controlar si entra en un error_get_last
		        
		        switch($_SESSION['usuario_idioma']){
		            
		            case 'Es':
		        		$error="Algo salió mal";
		        		$ok="Sucursal editada correctamente!";
		        		break;
		        		
		        	case 'En':
		        		$error="Something went wrong";
		        		$ok="Branch edited successfully!";
		        		break;
		            
		        }//fin swtich
		        
		        
		        //validar si algun campo obligatorio llega vacio
		        if(($nombre == "") or ($telefono1 == "") or ($celular == "") or ($direccion == "") or ($idPais == "0") or ($idCiudad == "0") or ($idBarrio == "0")  ){
		             $sw = 1;			
		             $_SESSION['mensaje']   = $error;
		         }//fin if validar los campos
			
				
				 //guardar el archivo si existe y generar la url
		         if($sw == 0){
		         	
					$urlLogo = "";
		             
		             //validar si se subio imagen
		             if($_FILES['editar_sucursal_logo']['tmp_name']!=""){
		                 
		                 //validar el tipo de archivo subido
		                 if( ( $_FILES['editar_sucursal_logo']['type'] == "image/jpg" ) or ( $_FILES['editar_sucursal_logo']['type'] == "image/png" ) ){
		                     
		                     //se copia el archivo en el servidor
		                     
		                     //se construye el nombre para el archivo
		                     $nombreArchivo = $nombre;
						     $nombreArchivo = str_replace(" ","_",$nombreArchivo);//se eliminan los espacios del nombre de la sucursal
						     
						     $tmpNombreLogoServidor = $_FILES["editar_sucursal_logo"]["tmp_name"];  //nombre que el  servidor le da al archivo
						     
						     $ext = explode(".", $_FILES["sucursal_logo"]["name"]); // se toma la extension del archivo
						     
						     $nombreArchivo = $nombreArchivo.".".$ext[1]; //se arma el nombre final del archivo
						     
						     $ruta  = "Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/";
						     //si no existe la ruta se crea
						     if(!is_file($ruta)){
		                        	mkdir($ruta,0774, true);
		                        }
						     
						     copy($tmpNombreLogoServidor,"Public/uploads/".$_SESSION['BDC_carpeta']."/img_sucursales/$nombreArchivo");//se copia el archivo al servidor no se puede la ruta absoluta por que contine http
						     
						     $urlLogo   = $nombreArchivo;
						     
						     
		                     
		                 }//fin if validar tipo de archivo
		                 
		             }//fin if para saber si se subio logo
			
					 $guardarSucursal    = $objetoSucursales->editarSucursal($idSucursal,$identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlLogo, $leyendaencabezado, $idPais, $idCiudad, $idBarrio, $latitud, $longitud, $estado  );
		                     
		             $_SESSION['mensaje']   =   $ok;
					 
				}//fin si todo va bien sw == 0
			
			
				//se redirecciona nuevamente a sucursales
	       		 header('Location: '.Config::ruta().'sucursales/' );	
				 		
				exit();
			
		}//fin if si se envia el formulario para editar una sucursal
		
		
		
		//se consultan las sucursales
		$listadoSucursales = $objetoSucursales->consultarInfomacionSucursales();
 
 
 		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
		
		
					//saber si tiene permisos de acceder a las sucursales
					if(!in_array("8", $_SESSION['permisos_usuario'] )){
						
						require_once("Views/Layout/sinPermiso.phtml");	
						
					}else{
						
						//se importan los layout modales de crear , ciudad y barrio
				         require_once("Views/Layout/modals/modal_nuevaCiudad.phtml");
				         require_once("Views/Layout/modals/modal_nuevoBarrio.phtml");
						
						
								//se importa la vista de las sucursales
						require_once("Views/sucursales/sucursales.phtml");							
					}
		

		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
 
 
 
 
    }else{
        header('Location: '.Config::ruta());
		exit();
    } 
 
 ?>
