<?php

/*
 * Archivo utilizado para generar la busuqeda de una raza
 */
 
 
 	$stringParaBuscar   = $_POST['stringBuscarRaza'];
    $idEspecie   		= $_POST['idEspecie'];

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de la replica
    require_once("../../Models/replica_model.php");
    
    //se define el objeto replica
    $objetoReplica   = new replica();


    //se busca con el string
    $retorno    = $objetoReplica->buscarRazaConString($stringParaBuscar, $idEspecie);
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    


?>