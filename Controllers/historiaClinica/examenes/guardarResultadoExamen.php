<?php

	/*
	 * Archivo para guardar el resultado de un examen
	 */

	if(!isset($_SESSION)){
		    session_start();
		}
		 
	 $idDetalleExamen 	= $_POST['idDetalleExamen'];
	 $observaciones		= $_POST['observaciones'];
	 $general			= $_POST['general'];
	 
	//se importa el config y el modelo
	require_once('../../../Config/config.php');
	
	require_once('../../../Models/examenes_model.php');	 
	
	$objetoExamen  = new examenes();
	
	$objetoExamen->guardarResultadoExamen($idDetalleExamen, $general, $observaciones, $_SESSION['usuario_idUsuario']);	 



?>