<?php

/*
 * Controlador para desactivar una categoria
 */
 
 $idCategoria = $_POST['idCategoria'];
 
 
	//se importa el archivo de config
	require_once("../../../Config/config.php");
	
	//se importa el modelo de las categorias
	require_once("../../../Models/categoriasProductos_model.php");
	
	$objetocategoriasProductos = new categoriasProductos();
	
	$objetocategoriasProductos->desactivarCategoria($idCategoria); 
 
 

?>