<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un desparasitante desde el texto ingresado en un campo
*/


	if(!isset($_SESSION)){
		    session_start();
		}

    $stringParaBuscar   = $_POST['stringDesparasitante'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de laos desparasitantes
    require_once("../../../Models/desparasitantes_model.php");
    
    //se define el objeto Desparasitante
    $objetoDesparasitantes   = new desparasitantes();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoDesparasitantes->buscarDesparasitanteConString($stringParaBuscar);
		
	}else{
		
		$idSucursal = $_SESSION['sucursalActual_idSucursal'];
	    //se busca con el string
	    $retorno    = $objetoDesparasitantes->buscarDesparasitanteConString($stringParaBuscar, $utilizar, $idSucursal);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>