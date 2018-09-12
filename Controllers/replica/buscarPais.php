<?php
/*
    * Este archivo se utiliza para realiza rla busqueda de un pas desde el ttexto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringBuscarPais'];
    

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de la replica
    require_once("../../Models/replica_model.php");
    
    //se define el objeto replica
    $objetoReplica   = new replica();

    //se busca con el string
    $retorno    = $objetoReplica->buscarPaisConString($stringParaBuscar);
    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>