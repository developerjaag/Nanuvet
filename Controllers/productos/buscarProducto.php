<?php
/*
    * Este archivo se utiliza para realizar la busqueda de una vacuna desde el texto ingresado en un campo
*/

	if(!isset($_SESSION)){
		    session_start();
		}


    $stringParaBuscar   = $_POST['stringProducto'];
    
    
	if(isset($_POST['utilizar'])){
		$utilizar             = 'Si';
	}else{
		$utilizar             = 'No';
	}

	if(isset($_POST['vender'])){
		$vender             = 'Si';
	}else{
		$vender             = 'No';
	}
    
    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de los productos
    require_once("../../Models/productos_model.php");
    
    //se define el objeto productos
    $objetoProductos   = new productos();

		
	$idSucursal	= $_SESSION['sucursalActual_idSucursal'];
		
	    //se busca con el string
	    $retorno    = $objetoProductos->buscarProductoConString($stringParaBuscar, $utilizar, $vender, $idSucursal);		


    	    
    $r =  json_encode($retorno);
	
	

	echo $r;


    exit();
    
?>