<?php

/*
 * Controlador principal para los reportes
 */

      if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
      	
		require_once("Models/reportes_model.php");
		   
		  $objetoReportes = new reportes();
	
		//para evitar errores de cabecera se llama al controlador
		if(isset($_GET['id1'])){
			
			if(is_file("Controllers/reportes/".$_GET['id1']."/".$_GET['id1']."Controller.php")){
				//se importa el controlador de apoyo para los reportes
				require_once ("Controllers/reportes/".$_GET['id1']."/".$_GET['id1']."Controller.php");
			}
			
						
			
		}

		

		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
		
		//se importa el menu lateral
		require_once ("Views/Layout/menuReportes.phtml");

		//si se elige una opción del menu lateral
		if(isset($_GET['id1'])){
			
			//saber si tiene permisos de acceder a los reportes
			if(!in_array("35", $_SESSION['permisos_usuario'] )){
						
				require_once("Views/Layout/sinPermiso.phtml");	
				
			}else{
			
				if(is_file("Views/reportes/".$_GET['id1']."/".$_GET['id1'].".phtml")){
					//se importa la vista
					require_once("Views/reportes/".$_GET['id1']."/".$_GET['id1'].".phtml");
				}else{
					//si no existe el archivo se muestra el inicio de los reportes
					require_once("Views/reportes/reportes.phtml");	
				}
			
			}
			
			
			
		}else{
			
					//saber si tiene permisos de acceder a los reportes
					if(!in_array("35", $_SESSION['permisos_usuario'] )){
						
						require_once("Views/Layout/sinPermiso.phtml");	
						
					}else{
						//se importa la vista de los reportes
						require_once("Views/reportes/reportes.phtml");	
					}
			
		} 
			
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	


    }else{
        header('Location: '.Config::ruta());
		exit();
    }
 
 
?>