<?php

/*
 * SubControlador para facturar hospitalizaciones
 */

    $datosHospitalizacionesFacturar = $objetoFactura->listadoHospitalizacionesSinPagar();

	//consultar el precio de una hora de hospitalizacion
	$precioHoraHospitalizacion = $objetoFactura->precioHospitalizacion();
	
	
	if($precioHoraHospitalizacion == ""){
		$precioHoraHospitalizacion = 0;
	}

	
	
	$facturaNuevaPestaña = "";
	
	
		//funcion para calcular el tiempo de hospitalizacion
		function tiempoTranscurridoFechas($fechaInicio, $fechaFin){
			    $fecha1 = new DateTime($fechaInicio);
			    $fecha2 = new DateTime($fechaFin);
			    $fecha = $fecha1->diff($fecha2);
			    $tiempo = 0;
				$sw = 0;
			         
			    //años
			    if($fecha->y > 0)
			    {
			        $tiempo = 0;
					$sw = 1;
					
			    }
			         
			    //meses
			    if($fecha->m > 0)
			    {
			        $tiempo = 0;
					$sw = 1;
			    }
			         
			    //dias
			    if($fecha->d > 0)
			    {
			       
				   if($sw == 0){
				   	
					$cantidadDias = $fecha->d;
					   $tiempo = $cantidadDias * 24;
					
				   }
				    
			    }
			         
			     //horas
			     if($fecha->h > 0)
			     {
			     	
					if($sw == 0){
						
						$cantidadHoras = $fecha->h;
							$tiempo = $tiempo+$cantidadHoras;
						
					}
					
			     }
			         
			     //minutos
			     if($fecha->i > 0)
			     {
			         	//si es mayor a 20 minutos se toma como una hora
						if($sw == 0 AND $fecha->i >= 20){
							$tiempo = $fecha->i;
						}
						
			     }
			     //else if($fecha->i == 0) //segundos
			       //  $tiempo .= $fecha->s." segundos";
			         
			    return $tiempo;
			}//fin funcion tiempo de hospitalizacion php
		
	
	
	
	//si se envia una nueva factura de una sola hospitalizacion
	if(isset($_POST['envioNuevaFacturaHospitalizacion']) and $_POST['envioNuevaFacturaHospitalizacion'] == "enviar"){
		
		//se reciben las variables
		$resolucionfacturador 		= $_POST['factura_resolucionfacturador'];
		$idFacturador 				= $_POST['factura_idFacturador'];
		$idResolucion 				= $_POST['factura_idResolucion'];
		$iva 						= $_POST['factura_iva'];
		$metodoPago 				= $_POST['factura_metodoPago'];
		$idPropietario 				= $_POST['factura_idPropietario'];
		$idHospitalizacion		    = $_POST['factura_idHospitalizacion'];
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
				$resultadoIdFactura =  $objetoFactura->guardarFacturaUnElemento($descuento, $iva, $valorIva, $valorBruto, $totalFactura, '0', $metodoPago, $observaciones, $estado, $idPropietario, $idFacturador, $idResolucion, $idUsuario, $idSucursal, $idHospitalizacion, '1', 'Hospitalizacion' );

				$_SESSION['mensaje']   = $ok;
				
			 }//fin if si todo va bien
	         	

		header('Location: '.Config::ruta().'factura/hospitalizaciones/' );
		
	}//fin if si se envia una nueva factura de una sola hospitalizacion

	
	

?>