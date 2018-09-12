<?php


/*
 * Controlador para activar una vacuna
 */
 
 
  $idVacuna = $_POST['idVacuna'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las vacunas
	require_once("../../../Models/vacunas_model.php");
	
	$objetoVacunas = new vacunas();
	
	$objetoVacunas->activarVacuna($idVacuna); 
 
 
 
 ?>
