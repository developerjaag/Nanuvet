<?php

/*
 * Archivo para guardar un facturador por defecto
 */


	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$idFacturador = $_POST['idFacturador'];
	
	$objetoConfiguracion->facturadorPorDefecto($idFacturador);
  
 
 
?>