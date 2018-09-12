<?php

/*
 * Archivo que se encarga de guardar el vinculo entre un producto y un proveedor
 */
 
 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProducto = new productos();
	
	 
 
	 $idProductosProveedores 	= $_POST['idProductosProveedores'];
	 $costo						= $_POST['costo'];
	 
	 $objetoProducto->editarVinculoProductoProveedor($idProductosProveedores, $costo);



?>