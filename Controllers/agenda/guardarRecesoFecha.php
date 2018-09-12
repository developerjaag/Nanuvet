<?php

/*
 * Archivo para guardar el receso de un usuario en una fecha en especifico
 */

 $idUsuario		= $_POST['idUsuario'];
 $fecha			= $_POST['fecha'];
 $horaInicio	= $_POST['horaInicio'];
 $horaFin		= $_POST['horaFin'];
 
	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	

	$objetoAgenda->guardarRecesoFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin);
 
?>