<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un desparasitante desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringMedicamento'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de los medicamentos
    require_once("../../../Models/medicamentos_model.php");
    
    //se define el objeto medicamentos
    $objetoMedicamentos   = new medicamentos();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoMedicamentos->buscarMedicamentoConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoMedicamentos->buscarMedicamentoConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>