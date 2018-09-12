<?php

/*
 * Archivo para guardar 
 */
 
 $idUsuario 	= $_POST['idUsuario'];
 $dia			= $_POST['dia'];
 $horaInicio	= $_POST['horaInicio'];
 $horaFin		= $_POST['horaFin'];
 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoHorarioDiaUsuario	= $objetoAgenda->consultarHorarioDiaUsuario($dia,$idUsuario);
	
	if(sizeof($resultadoHorarioDiaUsuario) > 0){
		$objetoAgenda->acturalizarHorarioDiaUsuario($idUsuario, $dia, $horaInicio, $horaFin);
	}else{
		$objetoAgenda->guardarHorarioDiaUsuario($idUsuario, $dia, $horaInicio, $horaFin);
	}

?>