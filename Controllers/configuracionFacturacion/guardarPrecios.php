<?php

/*
 * Archivo para guardar los precios de consulta y hospitalizacion en configuracion
 */
 
	require_once ("../../Config/config.php");
	require_once ("../../Models/configuracionFacturacion_model.php");
	
	$objetoConfiguracion = new configuracionFacturacion();
	
	
	$precioConsulta 		= $_POST['precioConsulta'];
	$precioHospitalizacion 	= $_POST['precioHospitalizacion'];
	
	$objetoConfiguracion->guardarPrecios($precioConsulta, $precioHospitalizacion);


?>