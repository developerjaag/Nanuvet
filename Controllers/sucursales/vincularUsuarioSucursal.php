<?php


/*
 * Archivo para vincular un usuario con una sucursal, desde el modal
 */
 
 $idSucursal = $_POST['idSucursal'];
 $idUsuario	 = $_POST['idUsuario'];

	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	
	$objetoSucursales->vincularUsuarioSucursal($idUsuario,$idSucursal);
	
	
?>