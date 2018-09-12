<?php

/*
 * Archivo para vincular un facturador con una resolucion
 */
 
 $idResolucion = $_POST['idResolucion'];
 $idFacturador = $_POST['idFacturador'];
 
 	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$resultado = $objetoConfiguracion->guardarVinculoFacturadorResolucion($idResolucion, $idFacturador);
 
 	echo $resultado;

?>