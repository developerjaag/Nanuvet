<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un diagnostico desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringDiagnostico'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de laos diagnosticos
    require_once("../../../Models/diagnosticosCirugias_model.php");
    
    //se define el objeto Diagnostico
    $objetoDiagnosticos  = new diagnosticosCirugias();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoDiagnosticos->buscarDiagnosticoConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoDiagnosticos->buscarDiagnosticoConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>