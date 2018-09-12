<?php
/*
    * Este archivo se utiliza para realiza rla busqueda de un pas desde el ttexto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringBuscarPais'];
    

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de los paises
    require_once("../../Models/paises_model.php");
    
    //se define el objeto paises
    $objetoPaises   = new paises();

    //se busca con el string
    $retorno    = $objetoPaises->buscarPaisConString($stringParaBuscar);
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>