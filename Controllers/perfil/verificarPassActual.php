<?php

/*
 * Archivo para verificar si la contraseña de un usuario coincide con la que ingresa en perfil
 */
 
 
	if(!isset($_SESSION)){
		    session_start();
		}
 
 $retorno = "Mal";
 
 $idUsuario 	= $_SESSION['usuario_idUsuario'];
 //se importa el config
 require_once ("../../Config/config.php");
 
 //se importa el modelo de perfil
 require ("../../Models/perfil_model.php");
 
 //Se intancia el objeto
 $objetoPerfil	= new perfiles();
 
 //se llama al metodo que confirma la contraseña
 $passEnBD	= $objetoPerfil->confirmarPass($idUsuario);
 
 if (password_verify($_POST['passIngresada'], $passEnBD)) {//se utiliza la funcion nativa para verificar la contraseña

	$retorno = "OK";
 }
 
 echo $retorno;

?>