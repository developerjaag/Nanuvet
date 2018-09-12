<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un desparasitante desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringEspecie'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de las especies
    require_once("../../../Models/especies_model.php");
    
    //se define el objeto Especies
    $objetoEspecies  = new especies();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoEspecies->buscarEspecieConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoEspecies->buscarEspecieConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>