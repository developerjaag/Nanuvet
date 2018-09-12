<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un servicio desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringServicio'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de los servicios
    require_once("../../../Models/servicios_model.php");
    
    //se define el objeto servicios
    $objetoServicios  = new servicios();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoServicios->buscarServicioConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoServicios->buscarServicioConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>