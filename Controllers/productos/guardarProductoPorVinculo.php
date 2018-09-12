<?php

 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de los productos
	require_once("../../Models/productos_model.php");
	
	$objetoProducto = new productos();


	//se reciben las variables
	
	$nombre			= $_POST['nombre'];
	$descripcion	= $_POST['descripcion'];
	$codigo			= $_POST['codigo'];
	$precio			= $_POST['precio'];
	$idCategoria	= $_POST['categoria'];
	$tipoExterno	= $_POST['tipoExterno'];
	$idExterno		= $_POST['idExterno'];


     	
	$objetoProducto->guardarProducto($nombre, $descripcion, $codigo, $precio, $idCategoria, $tipoExterno, $idExterno);
					



?>