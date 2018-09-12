<?php

/*
 * Inactivar un horario de una fecha
 */
 
 	$idAgendaHorarioFechaUsuario 	= $_POST['idAgendaHorarioFechaUsuario']; 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$objetoAgenda->inactivarHorarioFecha($idAgendaHorarioFechaUsuario); 
 
 
?>
