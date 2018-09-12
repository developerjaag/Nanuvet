<?php

/*
 * Archivo guardar una factura iniciada
 */

 
 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura();
 
 //se reciben las veriables 
	$idFactura 		= $_POST['idFactura'];
	$metodoPago		= $_POST['metodoPago'];
	$observaciones 	= $_POST['observaciones'];
	$subTotal		= $_POST['subTotal'];
	$valorIva		= $_POST['valorIva'];
	$descuento		= $_POST['descuento'];
	$total			= $_POST['total'];
	
	$objetoFactura->finalizarFacturaIniciada($idFactura, $metodoPago, $observaciones, $subTotal, $valorIva, $descuento, $total);
	
?>