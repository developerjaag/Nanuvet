<?php

/*
 * Controlador para desactivar una vacuna
 */
 
 $idVacuna = $_POST['idVacuna'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los vacunas
	require_once("../../../Models/vacunas_model.php");
	
	$objetoVacunas = new vacunas();
	
	$objetoVacunas->desactivarVacuna($idVacuna); 
 
 

?>