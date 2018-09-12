<?php

/*
 * archivo para desactivar un facturador
 */
 

	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$idFacturador = $_POST['idFacturador'];
	
	$objetoConfiguracion->desactivarFacturador($idFacturador);
  



?>