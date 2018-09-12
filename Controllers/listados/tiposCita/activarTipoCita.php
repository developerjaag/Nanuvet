<?php


/*
 * Controlador para activar un tipo de cita
 */
 
 
  $idTipoCita = $_POST['idTipoCita'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los tipos de cita
	require_once("../../../Models/tiposCita_model.php");
	
	$objetoTiposCita = new tiposCita();
	
	$objetoTiposCita->activarTipoCita($idTipoCita); 
 
 
 
 ?>
