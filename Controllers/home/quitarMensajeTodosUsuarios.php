<?php

/*
 * Archivo para quitar el mensaje de un usuario para todos los usuarios
 */
 
 $idmensaje = $_POST['id'];
 
  
 require_once("../../Config/config.php");
 require_once("../../Models/home_model.php");
 
 $objetoHome = new home();
 
 $idUsuario = $_SESSION['usuario_idUsuario'];
 
 $objetoHome->quitarNuevoMensajeTexto($idmensaje);
 

?>