<?php
/*
    * Este archivo se utiliza para realizar la busqueda de una categoria desde el texto ingresado en un campo
*/

    $stringParaBuscar   = $_POST['stringCategoria'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}

    
    //se importa el archivo de config
    require_once("../../../Config/config.php");
    
    //se importa el modelo de las categorias
    require_once("../../../Models/categoriasProductos_model.php");
    
    //se define el objeto categoriasProductos
    $objetocategoriasProductos   = new categoriasProductos();

	if(!isset($_POST['utilizar'])){

	    //se busca con el string
	    $retorno    = $objetocategoriasProductos->buscarCategoriaConString($stringParaBuscar);
		
	}else{
	    //se busca con el string
	    $retorno    = $objetocategoriasProductos->buscarCategoriaConString($stringParaBuscar, $utilizar);		
	}



    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>