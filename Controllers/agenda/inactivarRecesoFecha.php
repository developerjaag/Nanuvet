<?php

/*
 * Inactivar un receso de una fecha
 */
 
 	$idAgendaHorarioRecesoFecha 	= $_POST['idAgendaHorarioRecesoFecha']; 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$objetoAgenda->inactivarRecesoFecha($idAgendaHorarioRecesoFecha); 
 
 
?>
