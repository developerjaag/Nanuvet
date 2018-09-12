<?php

/*
 * Archivo para modificar la contraseña de un usuario
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 $nuevaPass		= $_POST['nuevaPass'];
 $idUsuario		= $_SESSION['usuario_idUsuario'];
 
  //se importa el config
 require_once ("../../Config/config.php");
 
 //se importa el modelo de perfil
 require ("../../Models/perfil_model.php");
 
 //Se intancia el objeto
 $objetoPerfil	= new perfiles();
 
 $nuevaPass = password_hash($nuevaPass, PASSWORD_DEFAULT);
 
 //se llama al metodo que modifica la contraseña
 $resultado	= $objetoPerfil->cambiarPass($nuevaPass, $idUsuario);

 echo $resultado;

?>