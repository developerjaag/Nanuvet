<?php

	if(!isset($_SESSION)){
		    session_start();
		}

/*
 * Archivo para adicionar un item a una factura que se encuentre iniciada
 */
 
 //se reciben las variables
 
 $tipoElemento  = $_POST['tipoElemento'];
 $precio		= $_POST['precio'];
 $idElemento	= $_POST['idElemento'];
 $cantidad		= $_POST['cantidad'];
 
 
 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura();
 
 $idUsuario = $_SESSION['usuario_idUsuario'];

 	$idSucursal = $_SESSION['sucursalActual_idSucursal'];
	
	$retorno =	$objetoFactura->adicionarItemFactura($tipoElemento, $precio, $idElemento, $idUsuario, $cantidad, $idSucursal);
	
	echo $retorno;

 

?>