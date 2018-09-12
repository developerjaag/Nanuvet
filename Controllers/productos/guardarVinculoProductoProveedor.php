<?php

/*
 * Archivo que se encarga de guardar el vinculo entre un producto y un proveedor
 */
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProducto = new productos();
	
	 
 
	 $idProducto 	= $_POST['idProducto'];
	 $idProveedor	= $_POST['idProveedor'];
	 $costo			= $_POST['costo'];
	 
	$resultado =  $objetoProducto->vincularProductoProveedor($idProducto, $idProveedor, $costo);

	echo $resultado;


?>