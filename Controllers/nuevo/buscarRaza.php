<?php

/*
 * Archivo utilizado para generar la busuqeda de una raza
 */
 
 
 	$stringParaBuscar   = $_POST['stringBuscarRaza'];
    $idEspecie   		= $_POST['idEspecie'];

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las razas
    require_once("../../Models/razas_model.php");
    
    //se define el objeto razas
    $objetoRazas  = new razas();

    //se busca con el string
    $retorno    = $objetoRazas->buscarRazaConString($stringParaBuscar, $idEspecie);
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    


?>