<?php

/*
 * Archivo para desactiva run vinculo entre un facturador y una resolucion
 */
 
 	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$idVinculo = $_POST['idVinculo'];
	
	$objetoConfiguracion->desactivarVinculoFacturadorResolucion($idVinculo); 


?>