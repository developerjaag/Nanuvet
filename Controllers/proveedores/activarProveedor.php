<?php


/*
 * Controlador para activar un proveedor
 */
 
 
 $idProveedor = $_POST['idProveedor'];
 
 
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los proveedores
	require_once("../../Models/proveedores_model.php");
	
	$objetoProveedores = new proveedores();
	
	$objetoProveedores->activarProveedor($idProveedor); 
 
 
 ?>
