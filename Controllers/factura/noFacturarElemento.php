<?php

/*
 * Archivo para no facturar un elemento
 */
 

 
  	if(!isset($_SESSION)){
		    session_start();
		}  
 
 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura(); 
  
  $tipoDetalle		= $_POST['tipoDetalle'];
  $idDetalle		= $_POST['idDetalle'];
  $motivo 			= $_POST['motivo'];
  
  $idUsuario = $_SESSION['usuario_idUsuario'];
  
  $idSucursal = $_SESSION['sucursalActual_idSucursal'];
  
  $objetoFactura->noFacturarElemento($tipoDetalle, $idDetalle, $motivo, $idUsuario, $idSucursal);


    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
			
				$_SESSION['mensaje'] = "Guardado correctamente!";	
			        		
    		break;
    		
    	case 'En':
			
				$_SESSION['mensaje'] = "Saved successfully!";
    		
    		break;
        
    }//fin swtich

?>