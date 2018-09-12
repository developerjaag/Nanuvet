<?php

/*
 * Inactivar un receso de un dia
 */
 
 	$idAgendaHorarioReceso 	= $_POST['idAgendaHorarioReceso']; 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$objetoAgenda->inactivarRecesoDia($idAgendaHorarioReceso); 
 
 
?>
