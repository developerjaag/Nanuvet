<?php

    /*
        * Contolador para gestionar los proveedores
    */
    
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    	
				
		//se importa el modelo
		require_once("Models/proveedores_model.php"); 
		
		//se intancia el objeto
		$objetoProvedores 	= new proveedores();
		
		if( isset($_POST['envioNuevoProveedor']) and $_POST['envioNuevoProveedor'] == "envio" ){
			
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
			         $_SESSION['mensaje']   = $error;
			     }//fin if validar los campos
			     
			     if($sw == 0){
			     	
					$guardarProveedor = $objetoProvedores->guardarProveedor($identificacion, $nombre, $telefono1, $telefono2, $celular, $email, $direccion);
					
					$_SESSION['mensaje']   = $ok;
				 }			
			
				//se redirecciona nuevamente a barrios listado
				 header('Location: '.Config::ruta().'proveedores/' );	
				 		
				exit();	    
		}//fin si llega un  nuevo proveedor
		
		// si ellega un proveedor para editar	
		if( isset($_POST['editar_idProveedor']) and $_POST['editar_idProveedor'] != "" ){
			
				//se reciben las variables
				$idProveedor	= $_POST['editar_idProveedor'];
				$identificacion	= $_POST['editar_identificativo'];
				$nombre			= $_POST['editar_nombre'];
				$telefono1		= $_POST['editar_telefono1'];
				$telefono2		= $_POST['editar_telefono2'];
				$celular		= $_POST['editar_celular'];
				$email			= $_POST['editar_email'];
				$direccion		= $_POST['editar_direccion'];


				$sw        = 0;//para controlar si entra en un 
			        
			    switch($_SESSION['usuario_idioma']){
			        
			        case 'Es':
			    		$error="Algo salió mal";
			    		$ok="Proveedor editado correctamente!";
			    		break;
			    		
			    	case 'En':
			    		$error="Something went wrong";
			    		$ok="Provider successfully edit!";
			    		break;
			        
			    }//fin swtich
			    
			    //validar si algun campo obligatorio llega vacio
			    if(($identificacion == "") or ($nombre == "")){
			         $sw = 1;			
			         $_SESSION['mensaje']   = $error;
			     }//fin if validar los campos
			     
			     if($sw == 0){
			     	
					$editarProveedor = $objetoProvedores->editarProveedor($idProveedor,$identificacion, $nombre, $telefono1, $telefono2, $celular, $email, $direccion);
					
					$_SESSION['mensaje']   = $ok;
				 }					
			
			
			
				//se redirecciona nuevamente a barrios listado
				 header('Location: '.Config::ruta().'proveedores/' );	
				 		
				exit();	
							
		}//fin si ellega un proveedor para editar			
				
		
 //se consulta el total de los directorios existentes
		$TotalProveedores = $objetoProvedores->tatalProveedores();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id1');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoproveedores = $objetoProvedores->listarProveedores($paginaActual,$records_per_page);//se llama al metodo para listar los proveedores segun los limites de la consulta
		
		$pagination->records($TotalProveedores);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
		
		
		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
			
		//se importa la vista de los proveedores
		require_once("Views/proveedores/proveedores.phtml");	
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	
			
    }else{
        header('Location: '.Config::ruta());
		exit();
    }    	