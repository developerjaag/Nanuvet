<?php

/*
 * Controlador para desactivar un desparasitante
 */
 
 $idDesparasitante = $_POST['idDesparasitante'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los desparasitantes
	require_once("../../../Models/desparasitantes_model.php");
	
	$objetoDesparasitantes = new desparasitantes();
	
	$objetoDesparasitantes->desactivarDesparasitante($idDesparasitante); 
 
 

?>