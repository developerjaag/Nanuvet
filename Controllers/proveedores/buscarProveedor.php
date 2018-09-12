<?php
/*
    * Este archivo se utiliza para realizar la busqueda de un proveedor desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringProveedor'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de los proveedores
    require_once("../../Models/proveedores_model.php");
    
    //se define el objeto Proveedores
    $objetoProveedores   = new proveedores();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetoProveedores->buscarProveedorConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetoProveedores->buscarProveedorConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>