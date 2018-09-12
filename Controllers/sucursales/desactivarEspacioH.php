<?php


/*
 * Controlador para activar un espacio para hospitalizacion
 */
 
 
  $idEspacio = $_POST['idEspacio'];
 
 
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de las sucursales
	require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	$objetoSucursales->desactivarEspacioHospitalizacion($idEspacio); 
 
 
 
 ?>
