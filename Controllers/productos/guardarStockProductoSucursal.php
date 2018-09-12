<?php

/*
 * Archivo para guardar el stock de un producto en una sucursal
 */

 $idProducto		= $_POST['idProducto'];
 $idSucursal		= $_POST['idSucursal'];
 $cantidad			= $_POST['cantidad'];
 $cantidadMinima	= $_POST['cantidadMinima'];
 
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos();
	
	$stockDelProducto	= $objetoProductos->guardarStockProductoSucursal($idProducto, $idSucursal, $cantidad, $cantidadMinima);
 
 	echo $stockDelProducto;
 
?>