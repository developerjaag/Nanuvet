<?php


/*
 * Controlador para desactivar un producto
 */
 
 
  $idProducto = $_POST['idProducto'];
 
 
	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProductos = new productos();
	
	$objetoProductos->desactivarProducto($idProducto); 
 
 
 
 ?>
