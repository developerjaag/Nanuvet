<?php


/*
 * Controlador para activar una raza
 */
 
 
  $idRaza = $_POST['idRaza'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las raza
	require_once("../../../Models/razas_model.php");
	
	$objetoRazas = new razas();
	
	$objetoRazas->activarRaza($idRaza); 
 
 
 
 ?>
