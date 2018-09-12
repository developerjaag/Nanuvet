<?php

/*
 * Archivo para guardar un nuevo propietario en la replica
 */
 
 //se importa el config
 require_once("../../Config/config.php");
 
 require_once("../../Models/replica_model.php");
 
 $objetoReplica = new replica();
 
 
 //se reciben las variables
	$identificacion 	= $_POST['identificacion'];
	$nombre				= $_POST['nombre'];
	$apellido			= $_POST['apellido'];
	$telefono			= $_POST['telefono'];
	$celular			= $_POST['celular'];
	$direccion			= $_POST['direccion'];
	$email				= $_POST['email'];
	$idPais				= $_POST['idPais'];
	
	$idPropietarioGuardado = $objetoReplica->guardarPropietarioReplica($identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais);
 
	echo $idPropietarioGuardado;

?>