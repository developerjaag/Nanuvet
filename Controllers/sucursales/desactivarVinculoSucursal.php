<?php

/*
 * Archivo para desactivar el vinculo entre un usuario y una sucursal
 */
 
 	$idVinculo = $_POST['idVinculo'];
 
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	$objetoSucursales->desactivarVinculoSucursalUsuario($idVinculo);
	
 
 
 
?>
