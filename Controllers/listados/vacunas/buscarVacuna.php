<?php
/*
    * Este archivo se utiliza para realizar la busqueda de una vacuna desde el texto ingresado en un campo
*/

	if(!isset($_SESSION)){
		    session_start();
		}

    $stringParaBuscar   = $_POST['stringVacuna'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de las vacunas
    require_once("../../../Models/vacunas_model.php");
    
    //se define el objeto Vacunas
    $objetoVacunas   = new vacunas();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoVacunas->buscarVacunaConString($stringParaBuscar);
		
	}else{
		$idSucursal = $_SESSION['sucursalActual_idSucursal'];
	    //se busca con el string
	    $retorno    = $objetoVacunas->buscarVacunaConString($stringParaBuscar, $utilizar, $idSucursal);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>