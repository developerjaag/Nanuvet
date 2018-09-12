<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un tipo de cita desde el texto ingresado en un campo
*/

	if(!isset($_SESSION)){
		    session_start();
		}

    $stringParaBuscar   = $_POST['stringTipoCita'];
    
    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de los tipos de cita
    require_once("../../../Models/tiposCita_model.php");
    
    //se define el objeto tipos de cita
    $objetoTiposCita   = new tiposCita();


	    //se busca con el string
	    $retorno    = $objetoTiposCita->buscarTipoCitaConString($stringParaBuscar);
		
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>