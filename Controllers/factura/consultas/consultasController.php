<?php

/*
 * SubControlador para facturar consultas
 */
 
    $datosConsultasFacturar = $objetoFactura->listadoConsultasSinPagar();

	//consultar el precio de una consulta
	$precioConsulta = $objetoFactura->precioConsulta();
	
	$facturaNuevaPestaña = "";
	
	//si se envia una nueva factura de una sola consulta
	if(isset($_POST['envioNuevaFacturaConsulta']) and $_POST['envioNuevaFacturaConsulta'] == "enviar"){
		
		//se reciben las variables
		$resolucionfacturador 		= $_POST['factura_resolucionfacturador'];
		$idFacturador 				= $_POST['factura_idFacturador'];
		$idResolucion 				= $_POST['factura_idResolucion'];
		$iva 						= $_POST['factura_iva'];
		$metodoPago 				= $_POST['factura_metodoPago'];
		$idPropietario 				= $_POST['factura_idPropietario'];
		$idConsulta				    = $_POST['factura_idConsulta'];
		$observaciones 				= $_POST['factura_observaciones'];
		$valorBruto 				= $_POST['factura_valorBruto'];
		$descuento 					= $_POST['factura_descuento'];
		$valorIva 					= $_POST['factura_valorIva'];
		$totalFactura 				= $_POST['factura_totalFactura'];
		
		$estado   				    = $_POST['factura_estado'];
		
		

		$sw        = 0;//para controlar si entra en un error
        
	        switch($_SESSION['usuario_idioma']){
	            
	            case 'Es':
	        		$error="Algo salió mal";
					
					if($estado == 'Iniciada'){
						$ok="Factura iniciada, continua adicionando items antes de guardarla.";
					}else{
						$ok="Factura generada correctamente!";
					}			
					
	        		
	        		break;
	        		
	        	case 'En':
	        		$error="Something went wrong";
					
					if($estado == 'Iniciada'){
						$ok="Invoice started, continue adding items before saving.";
					}else{
						$ok="Bill Generated Correctly!";
					}			
					
	        		
	        		break;
	            
	        }//fin swtich
	        
	        
	        //validar si algun campo obligatorio llega vacio
	        if(($resolucionfacturador == "") or ($iva == "") or ($metodoPago == "") or ($idPropietario == "") or ($valorBruto == "") or ($descuento == "") or ($valorIva == "") or ($totalFactura == "") or ($idFacturador == "0") or ($idResolucion == "0")){
	             $sw = 1;			
	             $_SESSION['mensaje']   = $error;
	         }//fin if validar los campos
	         
	         //si no exite error
	         if($sw == 0){
	         	
				$idUsuario	= $_SESSION['usuario_idUsuario'];
				$idSucursal = $_SESSION['sucursalActual_idSucursal'];
				
				//registrar el detalle del pago en la consulta
				$resultadoIdFactura =  $objetoFactura->guardarFacturaUnElemento($descuento, $iva, $valorIva, $valorBruto, $totalFactura, '0', $metodoPago, $observaciones, $estado, $idPropietario, $idFacturador, $idResolucion, $idUsuario, $idSucursal, $idConsulta, '1', 'Consulta' );
				
				$_SESSION['mensaje']   = $ok;
				
			 }//fin if si todo va bien
	         	

		header('Location: '.Config::ruta().'factura/consultas/' );
		
	}//fin if si se envia una nueva factura de una sola consulta
	
	

?>