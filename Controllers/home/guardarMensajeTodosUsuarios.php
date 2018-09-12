<?php


/*
 * Archivo para guardar un mensaje para todos los usuarios
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		}
 
 $fechaVenciemiento = $_POST['fechaVencimiento'];
 $texto				= $_POST['mensaje'];
 
 
 require_once("../../Config/config.php");
 require_once("../../Models/home_model.php");
 
 $objetoHome = new home();
 
 $idUsuario = $_SESSION['usuario_idUsuario'];
 
 $objetoHome->guardarNuevoMensajeTexto($fechaVenciemiento, $texto, $idUsuario);
 

?>