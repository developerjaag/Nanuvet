<?php

/*
 * Archivo para buscar un propietario en la replica
 */

  $stringBuscar	= $_POST['buscarPropietario'];

    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo
    require_once("../../Models/replica_model.php");
    
    //se define el objeto replica
    $objetoReplica  = new replica();

    //se busca con el string
    $retorno    = $objetoReplica->buscarPropietarioString($stringBuscar);
    	    
    $r =  json_encode($retorno);
	
	echo $r;


    exit();
 
 
?>