<?php

	if(!isset($_SESSION)){
		    session_start();
		}

	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los proveedores
	require_once("../../Models/proveedores_model.php");
	
	$objetoProveedores = new proveedores();
	

				//se reciben las variables
				$identificacion	= $_POST['identificativo'];
				$nombre			= $_POST['nombre'];
				$telefono1		= $_POST['telefono1'];
				$telefono2		= $_POST['telefono2'];
				$celular		= $_POST['celular'];
				$email			= $_POST['email'];
				$direccion		= $_POST['direccion'];


				$sw        = 0;//para controlar si entra en un 
			        
			    switch($_SESSION['usuario_idioma']){
			        
			        case 'Es':
			    		$error="Algo salió mal";
			    		$ok="Proveedor guardado correctamente!";
			    		break;
			    		
			    	case 'En':
			    		$error="Something went wrong";
			    		$ok="Provider successfully saved!";
			    		break;
			        
			    }//fin swtich
			    
			    //validar si algun campo obligatorio llega vacio
			    if(($identificacion == "") or ($nombre == "")){
			         $sw = 1;			
			         echo $error;
			     }//fin if validar los campos
			     
			     if($sw == 0){
			     	
					$guardarProveedor = $objetoProveedores->guardarProveedor($identificacion, $nombre, $telefono1, $telefono2, $celular, $email, $direccion);
					
					echo $ok;
				 }		

?>