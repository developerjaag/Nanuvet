<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un personalizado desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringPersonalizado'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de los personalizados
    require_once("../../../Models/personalizados_model.php");
    
    //se define el objeto Personalizados
    $objetoPersonalizados   = new personalizados();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoPersonalizados->buscarPersonalizadoOFConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoPersonalizados->buscarPersonalizadoOFConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>