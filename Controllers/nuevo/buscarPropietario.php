<?php

/*
 * Archivo para realizar la busqueda de un propietario, segun texto escrito en los campos
 */
 
 $stringBuscar	= $_POST['buscarPropietario'];

    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo
    require_once("../../Models/nuevoPacientePropietario_model.php");
    
    //se define el objeto nuevo
    $objetoNuevo  = new nuevo();

    //se busca con el string
    $retorno    = $objetoNuevo->buscarPropietarioString($stringBuscar);
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();

?>