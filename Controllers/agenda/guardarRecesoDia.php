<?php

/*
 * Archivo para guardar un receso de un dia
 */
 
 $dia			= $_POST['dia'];
 $idUsuario		= $_POST['idUsuario'];
 $horaInicio    = $_POST['horaInicio'];
 $horaFin	    = $_POST['horaFin'];
 
	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$objetoAgenda->guardarRecesoDia($idUsuario, $dia, $horaInicio, $horaFin);

?>