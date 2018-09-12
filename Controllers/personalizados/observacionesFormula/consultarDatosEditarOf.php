<?php

	$idPersonalizadoOF = $_POST['idPersonalizado'];

	//se importa el config
	require_once("../../../Config/config.php");
	
	//se importa el m odelo
	require_once ("../../../Models/personalizados_model.php");
	
	//se declara el objeto
	$objetoPersonalizados	= new personalizados();
	
	
	//se llama al metodo que consulta los datos de un personalizado
	$resultado 	= $objetoPersonalizados->consultarUnPersonalizadoOF($idPersonalizadoOF);
	
	
	$r = json_encode($resultado);

	echo $r;



?>