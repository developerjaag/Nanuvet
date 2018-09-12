<?php

/*
 * Controlador para desactivar un servicio
 */
 
 $idServicio = $_POST['idServicio'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de los servicios
	require_once("../../../Models/servicios_model.php");
	
	$objetoServicios = new servicios();
	
	$objetoServicios->desactivarServicio($idServicio); 
 
 

?>