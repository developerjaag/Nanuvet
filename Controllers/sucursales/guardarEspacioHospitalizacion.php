<?php

/*
 * Archivo para guardar un nuevo espacio de hospitalizacion en una sucursal
 */
 
 $idSucursal		= $_POST['idSucursal'];
 $nombre			= $_POST['nombre'];
 $capacidad			= $_POST['capacidad'];
 $observacion		= $_POST['observacion'];


 	//se importa el archivo de config
	require_once("../../Config/config.php");
	
	//se importa el modelo de las ciudades
	require_once("../../Models/sucursales_model.php");
	
	$objetoSucursales = new sucursales();
	
	
	$objetoSucursales->guardarEspacioHospitalizacionSucursal($idSucursal, $nombre, $capacidad, $observacion);	


?>