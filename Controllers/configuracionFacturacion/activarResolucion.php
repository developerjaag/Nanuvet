<?php


/*
 * archivo para activar una resolucion
 */


	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$idResolucion = $_POST['idResolucion'];
	
	$objetoConfiguracion->activarResolucion($idResolucion);

?>