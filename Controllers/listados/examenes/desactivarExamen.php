<?php

/*
 * Controlador para desactivar un examen
 */
 
 $idExamen = $_POST['idExamen'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los examenes
	require_once("../../../Models/examenes_model.php");
	
	$objetoExamenes = new examenes();
	
	$objetoExamenes->desactivarExamen($idExamen); 
 
 

?>