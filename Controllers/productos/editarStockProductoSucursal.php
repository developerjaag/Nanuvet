<?php

/*
 * Archivo para editar el stock de un producto en una sucursal
 */

 $idProductoSucursal		= $_POST['idProductoSucursal'];
 $idProducto				= $_POST['idProducto'];
 $cantidad					= $_POST['cantidad'];
 $cantidadMinima			= $_POST['cantidadMinima'];
 
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos();
	
	$stockDelProducto	= $objetoProductos->editarStockProductoSucursal($idProductoSucursal, $idProducto, $cantidad, $cantidadMinima);
 
 
?>