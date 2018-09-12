<?php

/*
 * Controlador para desactivar una ciudad
 */
 
 $idCiudad = $_POST['idCiudad'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../../Models/ciudades_model.php");
	
	$objetoCiudades = new ciudades();
	
	$objetoCiudades->desactivarCiudad($idCiudad); 
 
 

?>