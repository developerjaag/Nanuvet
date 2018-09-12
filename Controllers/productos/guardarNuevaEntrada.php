<?php

/*
 * Archivo para guardar una nueva entrada
 */

 	if(!isset($_SESSION)){
		    session_start();
		}
	
 
 	$idProducto		= $_POST['idProducto'];
	$idSucursal		= $_POST['idSucursal'];
	$idProveedor	= $_POST['idProveedor'];
	$costo			= $_POST['costo'];
	$cantidad		= $_POST['cantidad'];

	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos(); 
 
 	$idUsuario	= $_SESSION['usuario_idUsuario'];
 
 	$objetoProductos->registrarNuevaEntrada($idProducto, $idSucursal, $idProveedor, $costo, $cantidad, $idUsuario);
	
	$objetoProductos->aumentarCantidadProducto($idProducto, $idSucursal, $cantidad);
	


?>