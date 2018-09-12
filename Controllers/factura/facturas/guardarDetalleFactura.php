<?php

/*
 * Archivo para guardar el detalle de una factura factura
 */
 
 	if(!isset($_SESSION)){
		    session_start();
		} 

	//se reciben las variables
   $idFactura						=  $_POST['idFactura'];
   $id								=  $_POST['id'];
   $tipoDetalle						=  $_POST['tipoDetalle'];
   $valorBruto						=  $_POST['valorBruto'];
   $descuento						=  $_POST['descuento'];
   $cantidad						=  $_POST['cantidad']; 

 require_once("../../../Config/config.php");
 require_once("../../../Models/factura_model.php");
 
 $objetoFactura = new factura(); 
 
 
 $idSucursal = $_SESSION['sucursalActual_idSucursal'];
 
 $objetoFactura->guardarDetalleFacturaFactura($idFactura, $id, $tipoDetalle, $valorBruto, $descuento, $cantidad, $idSucursal);

	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
					
						$_SESSION['mensaje'] = "Factura generada correctamente!";	
					        		
	        		break;
	        		
	        	case 'En':
					
						$_SESSION['mensaje'] = "Bill Generated Correctly!";
	        		
	        		break;
	            
	        }//fin swtich

?>


?>