<?php


/*
 * Controlador para activar un diagnostico
 */
 
 
  $idDiagnostico = $_POST['idDiagnostico'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los diagnósticos
	require_once("../../../Models/diagnosticosConsultas_model.php");
	
	$objetodiagnosticosConsultas = new diagnosticosConsultas();
	
	$objetodiagnosticosConsultas->activarDiagnostico($idDiagnostico); 
 
 
 
 ?>
