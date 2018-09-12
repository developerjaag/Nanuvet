<?php

/*
 * Controlador para desactivar un barrio
 */
 
 $idBarrio = $_POST['idBarrio'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../../Models/barrios_model.php");
	
	$objetobarrios = new barrios();
	
	$objetobarrios->desactivarBarrio($idBarrio); 
 
 

?>