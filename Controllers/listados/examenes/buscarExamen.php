<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un desparasitante desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringExamen'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de los examenes
    require_once("../../../Models/examenes_model.php");
    
    //se define el objeto Desparasitante
    $objetoExamenes   = new examenes();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoExamenes->buscarExamenConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoExamenes->buscarExamenConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>