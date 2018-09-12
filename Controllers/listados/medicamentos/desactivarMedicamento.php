<?php

/*
 * Controlador para desactivar un medicamento
 */
 
 $idMedicamento = $_POST['idMedicamento'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los medicamentos
	require_once("../../../Models/medicamentos_model.php");
	
	$objetoMedicamentos = new medicamentos();
	
	$objetoMedicamentos->desactivarMedicamento($idMedicamento); 
 
 

?>