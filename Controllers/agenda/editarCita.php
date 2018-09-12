<?php

/*
 * Archivo para editar una nueva cita
 */

 
$idCita					= $_POST["idCita"];

$tipoCita				= $_POST["tipoCita"];
$fecha_cita				= $_POST["fecha_cita"];
$hora_cita				= $_POST["hora_cita"];
$duracion_citaHoras		= $_POST["duracion_citaHoras"];
$duracion_citaMinutos	= $_POST["duracion_citaMinutos"];
$observaciones			= $_POST["observaciones"]; 

$otrosUsuario			= $_POST['otrosUsuarios'];


$fechaHoraCita = date($fecha_cita." ".$hora_cita);

$fechaHoraFinCita = date ( '"Y/m/d  H:i"', strtotime ( '+'.$duracion_citaHoras.' hour +'.$duracion_citaMinutos.' minute' , strtotime ( $fechaHoraCita ) ) );

	$fechaHoraFinCita = explode(" ", $fechaHoraFinCita);

	
	$vowels = array('"', ' ');
	$fechaHoraFinCita[0] = str_replace($vowels, "", $fechaHoraFinCita[0]);
	$fechaHoraFinCita[2] = str_replace($vowels, "", $fechaHoraFinCita[2]);
	
	$fechaFinCita 	= $fechaHoraFinCita[0];
	$horaFinCita	= $fechaHoraFinCita[2]; 


	require_once("../../Config/config.php");
	
	require_once("../../Models/agenda_model.php");
	
	
	$objetoAgenda = new agenda();
	
	$idCitaGuardada = $objetoAgenda->editarCita($idCita, $fecha_cita, $hora_cita, $fechaFinCita, $horaFinCita, $duracion_citaHoras, $duracion_citaMinutos, $observaciones, $tipoCita);

	
	//inactivar todos los vinculos d elos usuarios con la cita
	$objetoAgenda->incativarTodosVinculosUsuarioCita($idCita);
	
	//vincular los usuarios con la cita
	for ($i=0; $i <  sizeof($otrosUsuario) ; $i++) {
		
		//se consulta si el usuario ya tiene vinculo con la cita
		$resultado = $objetoAgenda->consultarVinculoCita($idCita, $otrosUsuario[$i]);
		//si tiene vinculo se actualiza el estado a A
		if($resultado > '0'){
			$objetoAgenda->actualizarVinculoUsuarioCita($idCita, $otrosUsuario[$i]);
		}else{//sino se adiciona el vinculo
			$objetoAgenda->vincularUsuarioCita($idCita, $otrosUsuario[$i]);
		}
		 
		
	}//fin for
	
 

?>