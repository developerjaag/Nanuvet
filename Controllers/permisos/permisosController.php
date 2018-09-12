<?php

/*
 * Controlador para gestionar los permisos d eun usuario
 */

     if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
     	
		 //se importa el modelo de permisos
		 require_once("Models/permisos_model.php"); 
		 
		 //se importa el modelo de usuarios
		 require_once("Models/usuarios_model.php"); 
		 
		 //se instancia el objeto
		 $objetoPermisos 	= new permisos();
		 $objetoUsuarios	= new usuarios();
		 
		 //cargar la informacion de los usuarios para mostrar en el select
		 $informacionUsuarios	= $objetoUsuarios->listarUsuariosSelect();
		 
	 
		//se importa el layout del menu
		require_once("Views/Layout/menu.phtml");
		
		
		//saber si tiene permisos de acceder a los permisos
		if(!in_array("6", $_SESSION['permisos_usuario'] )){
			
			require_once("Views/Layout/sinPermiso.phtml");	
			
		}else{
			//se importa la vista de los permisos
			require_once("Views/permisos/permisos.phtml");				
		}
			

		
		//se importa el footer
		require_once("Views/Layout/footer.phtml");	

    }else{
        header('Location: '.Config::ruta());
		exit();
    }   
 
?>