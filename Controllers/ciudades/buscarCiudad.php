<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un pas desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringCiudad'];
    
    
	if(isset($_POST['idPais'])){
		$idPais             = $_POST['idPais'];
	}

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las ciudades
    require_once("../../Models/ciudades_model.php");
    
    //se define el objeto ciudades
    $objetoCiudades   = new ciudades();

	if(!isset($_POST['idPais'])){

	    //se busca con el string
	    $retorno    = $objetoCiudades->buscarCiudadConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoCiudades->buscarCiudadConString($stringParaBuscar, $idPais);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>