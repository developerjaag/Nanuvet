<?php

/*
 * Archivo para guardar una nueva cita
 */

	if(!isset($_SESSION)){
		    session_start();
		}

 
$idUsuario				= $_POST["idUsuario"];
$idPropietario 			= $_POST["idPropietario"];
$idPaciente				= $_POST["idPaciente"];
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
	
	$idSucursal = $_SESSION['sucursalActual_idSucursal'];
	
	$idCitaGuardada = $objetoAgenda->guardarCita($fecha_cita, $hora_cita, $fechaFinCita, $horaFinCita, $duracion_citaHoras, $duracion_citaMinutos, 'Asignada', $observaciones, $idPaciente, $idSucursal, $tipoCita, $idPropietario);
	
	$objetoAgenda->vincularUsuarioCita($idCitaGuardada, $idUsuario);
	
	//vincular los usuarios con la cita
	for ($i=0; $i <  sizeof($otrosUsuario) ; $i++) { 
		$objetoAgenda->vincularUsuarioCita($idCitaGuardada, $otrosUsuario[$i]);
	}//fin for
	
 

?>