<?php

/*
 * Archivo para guardar el horairo de un usuario en una feche en especifico
 */

 $idUsuario		= $_POST['idUsuario'];
 $fecha			= $_POST['fecha'];
 $horaInicio	= $_POST['horaInicio'];
 $horaFin		= $_POST['horaFin'];
 
	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultadoHorarioFechaUsuario	= $objetoAgenda->consultarHorarioFechaUsuario($fecha,$idUsuario);
	
	if(sizeof($resultadoHorarioFechaUsuario) > 0){
		$objetoAgenda->acturalizarHorarioFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin);
		$retorno = 'Actualizado';
	}else{
		$objetoAgenda->guardarHorarioFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin);	
		$retorno = 'Guardado';
	}	
	
	echo $retorno;
	
	 
 
 
?>