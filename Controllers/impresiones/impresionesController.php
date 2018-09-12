<?php


/*
 * Archivo para mostrar el contenido de la historia clinica d eun paciente
 */
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){

			
			//se llama al metodo que consulta datos del propietario y del paciente
	
			//se importa el controlador segun el item de la HC
			if(isset($_GET['id1'])){
				
				if(is_file("Controllers/impresiones/".$_GET['id1']."/".$_GET['id1']."Controller.php")){
					//se importa el controlador de apoyo
					require_once("Controllers/impresiones/".$_GET['id1']."/".$_GET['id1']."Controller.php");
				}else{
					//se importa el controlador de error
					require_once("Controllers/error/errorController.php");
					exit();
				}
				
			}
	
	
			if(isset($_GET['id1'])){
				
				if( is_file("Views/impresiones/".$_GET['id1']."/".$_GET['id1'].".phtml") ){
					//se importa la vista que corresponda al item de impresiones
					require_once("Views/impresiones/".$_GET['id1']."/".$_GET['id1'].".phtml");
				}				
				
			}
			
	
     }else{
        header('Location: '.Config::ruta());
		exit();
    }	


?>