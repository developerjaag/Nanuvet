<?php

    /*
        * Contolador para la ventana inicial despús de iniciar sesión
    */
    
    if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
    
        //se importa el modelo
        require_once("Models/home_model.php");
        
        //se instancia el objeto 
        $objetoHome = new home();
		
		
		//saber si llega un cambio de sucursal
		if( isset($_POST['cambiarSucursal']) and $_POST['cambiarSucursal'] == "enviaCambioSucursal" ){
		
			//se reciben los datos
			$idUsuario 	= $_SESSION['usuario_idUsuario'];
			$idSucursal	= $_POST['sucursalActual'];
			
			if(isset($_POST['checkDefecto'])){
				$objetoHome->cambiarSucursalUsuario($idUsuario, $idSucursal, 'Si');
			}else{
				$objetoHome->cambiarSucursalUsuario($idUsuario, $idSucursal, 'No');
			}

			$_SESSION['sucursalActual_idSucursal'] 	   = $idSucursal;
			
			$_SESSION['sucursalActual_cambioSucursal'] = 'Si';
			
			
				//se redirecciona nuevamente a home
				header('Location: '.Config::ruta().'home/' );					 		
				exit();	
			
		}//Fin if para saber si llega el cambio de sucursal			
		
        

        //preguntar si existe almenos una sucursal creada, d elo contrario se muestra un modal para crear una
        $cantidadSucursales = $objetoHome->comprobarExistenciaSucursal();
        
        //si no se tienen sucursales creadas
        if($cantidadSucursales <= 0){
 
             //se importa el layout del menu
            require_once("Views/Layout/disableMenu.phtml");
            
             //se importan los layout modales de crear , ciudad y barrio
             require_once("Views/Layout/modals/modal_nuevaCiudad.phtml");
             require_once("Views/Layout/modals/modal_nuevoBarrio.phtml");
            
            require_once("Views/home/crearPrimeraSucursal.phtml");
            
        }else{//fin si no se tienen sucursales creadas
        
        	//se consulta la cantidad de sucursales que tiene asociado un usuario (para seber si se muestra el select o no)
        	$idUsuario	= $_SESSION['usuario_idUsuario'];
        	$sucursalesDelUsuario	= $objetoHome->sucursalesPorUsuario($idUsuario);
        	
 			//se importa el modelo Shop
 			require_once("Shop/ShopModels/shop_model.php");
			//se instancia el objeto
			$objetoShopModel		= new shop_model();
			//se llama al metodo que retorna la conexion de la base de datos del cliente
			$conexion			= $objetoShopModel->conexionBDCliente();
			//se llama al metodo para cargar un array de sesion con los tutoriales activos
			$idUsuario = $_SESSION['usuario_idUsuario'];
			$_SESSION['tutoriales_usuario']	= $objetoShopModel->consultarTutorialesUsuario($idUsuario);
			
			//se consulta las citas que el usuario tiene para el día de hoy
			$citasHoy = $objetoHome->citasUsuarioDiaActual($idUsuario);
			
			//se consultan los mensajes para todos los usuarios 
			$mensajesUsuarios = $objetoHome->consultarMensajesTodosUsuarios();
			
			
			//se consultan los permisos de un usuario y se llevan a un array de session
         	$_SESSION['permisos_usuario'] = $objetoShopModel->permisos_consultarPermisosUsuario($idUsuario);
			
			        
            //se importa el layout del menu
            require_once("Views/Layout/menu.phtml");
            
            require_once("Views/home/home.phtml");    
    
        }
        
            //se importa el footer
            require_once("Views/Layout/footer.phtml");

    
    }else{
        header('Location: '.Config::ruta());
		exit();
    }