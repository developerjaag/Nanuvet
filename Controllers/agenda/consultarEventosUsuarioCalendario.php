<?php

	header('Content-type: application/json; charset=UTF-8');

	/*
	 * Archivo para consulta rlos eventos de un usrio en el calendario
	 */
	 
   $fechaInicio			= $_POST['start'];
   $fechaFin			= $_POST['end'];
   $idUsuario			= $_POST['idUsuario'];
   
   require_once("../../Config/config.php");
   
   require_once("../../Models/agenda_model.php");
   
   $objetoAgenda	= new agenda();
   
   $eventos = $objetoAgenda->consultarEventosCalendarioUsuario($idUsuario, $fechaInicio, $fechaFin);
   
   
   echo json_encode($eventos);	 

?>