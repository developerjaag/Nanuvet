<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un barrio desde el texto ingresado en un campo
*/

    $stringParaBuscar     = $_POST['stringBarrio'];
	
	
	if(isset($_POST['idCiudad'])){
		$idCiudad             = $_POST['idCiudad'];
	}
	
    
    

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de los barrios
    require_once("../../Models/barrios_model.php");
    
    //se define el objeto barrios
    $objetoBarrios   = new barrios();
	
	if(!isset($_POST['idCiudad'])){

	    //se busca con el string
	    $retorno    = $objetoBarrios->buscarBarrioConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoBarrios->buscarBarrioConString($stringParaBuscar, $idCiudad);		
	}


    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>