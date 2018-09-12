<?php

/*
 * Archivo que se ocupa de la presentación inicial de los listados
 */

     if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){ 
	
		//para evitar errores de cabecera se llama al controlador
		if(isset($_GET['id1'])){
			
			if(is_file("Controllers/listados/".$_GET['id1']."/".$_GET['id1']."Controller.php")){
				//se importa el controlador de apoyo para los listados
				require_once ("Controllers/listados/".$_GET['id1']."/".$_GET['id1']."Controller.php");
			}
			
						
			
		}

		

		//se importa el layout del menu
        require_once("Views/Layout/menu.phtml");
		
		//se importa el menu lateral
		require_once ("Views/Layout/menuListados.phtml");

		//si se elige una opción del menu lateral
		if(isset($_GET['id1'])){
			
			if(is_file("Views/listados/".$_GET['id1']."/".$_GET['id1'].".phtml")){
				//se importa la vista
				require_once("Views/listados/".$_GET['id1']."/".$_GET['id1'].".phtml");
			}else{
				//si no existe el archivo se muestra el inicio de los listados
				require_once("Views/listados/listados.phtml");	
			}
			
			
			
		}else{
			
			//se importa la vista de los listados
			require_once("Views/listados/listados.phtml");	
		} 
			
		
		//se importa el footer
        require_once("Views/Layout/footer.phtml");	


    }else{
        header('Location: '.Config::ruta());
		exit();
    }  
 
 ?>
