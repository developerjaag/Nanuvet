<?php

/*
 * Controlador para desactivar un personalizado MC
 */
 
 $idPersonalizado = $_POST['idPersonalizado'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los personalizados
	require_once("../../../Models/personalizados_model.php");
	
	$objetoPersonalizados = new personalizados();
	
	$objetoPersonalizados->desactivarPersonalizadoPlanConsulta($idPersonalizado); 
 
 

?>