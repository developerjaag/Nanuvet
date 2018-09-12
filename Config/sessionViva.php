<?php
/*
 * Archivo php ṕara mantener viva las variables de sesion y evitar que el usuario pierda el login
 */
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 		//se importa el archivo config
        require_once("config.php");
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 		
		echo $_SESSION['usuario_idUsuario'];
		
     }else{
        header('Location: '.Config::ruta());
		exit();
    }
 
 ?>
