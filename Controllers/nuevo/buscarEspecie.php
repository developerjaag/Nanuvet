<?php

/*
 * Archivo utilizado para generar la busuqeda de una especie
 */
 
 
 	$stringParaBuscar   = $_POST['stringBuscarEspecie'];
    

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las especies
    require_once("../../Models/especies_model.php");
    
    //se define el objeto especies
    $objetoEspecies   = new especies();

    //se busca con el string
    $retorno    = $objetoEspecies->buscarEspecieConString($stringParaBuscar, 'Si');
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    


?>