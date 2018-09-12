<?php

/*
 * Controlador para desactivar un diagnostico
 */
 
 $idDiagnostico = $_POST['idDiagnostico'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los diagnosticos
	require_once("../../../Models/diagnosticosConsultas_model.php");
	
	$objetoDiagnosticosConsultas = new diagnosticosConsultas();
	
	$objetoDiagnosticosConsultas->desactivarDiagnostico($idDiagnostico); 
 
 

?>