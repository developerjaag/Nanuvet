<?php

/*
 * Archivo para consultar la disponibilifdad en cantidad de un producto en una sucursal
 * para descontarlo mediante una factura
 */
 

	if(!isset($_SESSION)){
		    session_start();
		}
	

	 require_once("../../../Config/config.php");
	 require_once("../../../Models/factura_model.php");
	 
	 $objetoFactura = new factura(); 
		
		
		
	$idSucursal = $_SESSION['sucursalActual_idSucursal'];
	$idProducto = $_POST['id'];
	$cantidadDescontar = $_POST['cantidadDescontar'];
	
	
	$cantidadExistente = $objetoFactura->validarCantidadProducto($idSucursal, $idProducto);
	
	$resultado = $cantidadExistente - $cantidadDescontar;
	
	if($resultado < 0 ){
		echo "Mal";
	}else{
		echo "Sin problemas";
	}
	
	 
 

?>