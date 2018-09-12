<?php


/*
 * Controlador para activar un diagnostico
 */
 
 
  $idDiagnostico = $_POST['idDiagnostico'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las categorias
	require_once("../../../Models/diagnosticosCirugias_model.php");
	
	$objetodiagnosticosCirugias = new diagnosticosCirugias();
	
	$objetodiagnosticosCirugias->activarDiagnostico($idDiagnostico); 
 
 
 
 ?>
