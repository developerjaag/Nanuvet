<?php

/*
 * Archivo para cancelar una cita
 */
 
	if(!isset($_SESSION)){
		    session_start();
		} 
 
   $idCita = $_POST['idCita'];
   $motivo	= $_POST['motivoCancelacion'];
 
   require_once("../../Config/config.php");
   
   require_once("../../Models/agenda_model.php");
   
   $objetoAgenda	= new agenda();
   
   $idUsuario = $_SESSION['usuario_idUsuario'];
   
   $objetoAgenda->cancelarCita($idCita, $idUsuario, $motivo);
   

?>