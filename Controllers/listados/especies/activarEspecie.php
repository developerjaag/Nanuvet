<?php


/*
 * Controlador para activar una especie
 */
 
 
  $idEspecie = $_POST['idEspecie'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las especies
	require_once("../../../Models/especies_model.php");
	
	$objetoEspecies = new especies();
	
	$objetoEspecies->activarEspecie($idEspecie); 
 
 
 
 ?>
