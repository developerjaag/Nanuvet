<?php
/*
    * Este archivo se utiliza para realizar la busqueda de una raza desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringRaza'];
    
    
    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de las razas
    require_once("../../../Models/razas_model.php");
    
    //se define el objeto razas
    $objetoRazas   = new razas();

	
	    //se busca con el string
	    $retorno    = $objetoRazas->buscarRazaConString($stringParaBuscar);		


    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>