<?php

/*
 * Archivo para inactivar el horario de un dia de semana para un usuario 
 */
 
 $idUsuario 	= $_POST['idUsuario'];
 $dia			= $_POST['dia'];
 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoHorarioDiaUsuario	= $objetoAgenda->consultarHorarioDiaUsuario($dia,$idUsuario);
	
	if(sizeof($resultadoHorarioDiaUsuario) > 0){
		$objetoAgenda->inactivarHorarioDiaUsuario($idUsuario, $dia);
	}

?>