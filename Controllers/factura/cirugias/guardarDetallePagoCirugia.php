<?php


/*
 * Archivo para guardar los detalles del pago de una cirugia
 */
 
  	if(!isset($_SESSION)){
		    session_start();
		} 
 
	//se reciben las variables
   $idFactura						=  $_POST['idFactura'];
   $factura_idCirugia				=  $_POST['factura_idCirugia'];
   $idPanelCirugiaDiagnostico		=  $_POST['idPanelCirugiaDiagnostico'];
   $valorBruto						=  $_POST['valorBruto'];
   $descuento						=  $_POST['descuento']; 

 require_once("../../../Config/config.php");
 require_once("../../../Models/factura_model.php");
 
 $objetoFactura = new factura(); 
 
 $idSucursal = $_SESSION['sucursalActual_idSucursal'];
 
 $objetoFactura->guardarDetallePagoCirugia($idFactura, $factura_idCirugia, $idPanelCirugiaDiagnostico, $valorBruto, $descuento, $idSucursal);

	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
					
						$_SESSION['mensaje'] = "Factura generada correctamente!";	
					        		
	        		break;
	        		
	        	case 'En':
					
						$_SESSION['mensaje'] = "Bill Generated Correctly!";
	        		
	        		break;
	            
	        }//fin swtich

?>