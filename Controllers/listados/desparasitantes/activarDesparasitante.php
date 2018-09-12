<?php


/*
 * Controlador para activar un desparasitante
 */
 
 
  $idDesparasitante = $_POST['idDesparasitante'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las categorias
	require_once("../../../Models/desparasitantes_model.php");
	
	$objetodesparasitantes = new desparasitantes();
	
	$objetodesparasitantes->activarDesparasitante($idDesparasitante); 
 
 
 
 ?>
