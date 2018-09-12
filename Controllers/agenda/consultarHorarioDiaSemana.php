<?php

/*
 * Archivo para consultar el horario de un dia de un usuario
 */

 $idUsuario 	= $_POST['idUsuario'];
 $dia			= $_POST['dia'];
 

	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	$objetoAgenda	= new agenda();
	
	$resultado = 'Sin horario';
	
	$resultadoHorarioDiaUsuario	= $objetoAgenda->consultarHorarioDiaUsuario($dia,$idUsuario);
 
 	if(sizeof($resultadoHorarioDiaUsuario)){
 		
		$resultado = json_encode($resultadoHorarioDiaUsuario);
		
 	}else{
 		
		$resultado = 'Sin horario';
		
 	}	
	
	echo $resultado;

?>