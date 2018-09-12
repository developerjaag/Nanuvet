<?php


/**
 * Clase para controlar los datos referentes a facturación
 */
class factura extends Config {
	
	//metodo para consultar si existe una factura iniciada
	public function comprobarFacturaIniciada($idUsuario){

		$resultado = array();
		
		$query = "SELECT count(idFactura) as cantidadFacturasIniciadas
		
						FROM tb_facturas    
						
    				WHERE estado = 'Iniciada' and idUsuario = '$idUsuario'";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadFacturasIniciadas'];	

		
	}//fin metodo comprobarFacturaIniciada
	
	
	
	//se consultan las consultas pendientes por facturar
	public function consultasPendientes(){

		$resultado = array();
		
		$query = "SELECT count(C.idConsulta) as cantidadConsultas
		
						FROM tb_consultas AS C    
						
    				WHERE Not C.idConsulta IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Consulta' AND estado = 'Activo' )";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadConsultas'];	


		
	}//fin metodo consultasPendientes
	
	
	//se consultan las cirugias pendientes por facturar
	public function cirugiasPendientes(){

		$resultado = array();
		
		$query = "SELECT count(C.idCirugia) as cantidadCirugias
						FROM tb_cirugias AS C    
    				WHERE Not C.idCirugia IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Cirugia' AND estado = 'Activo' )";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadCirugias'];		


		
	}//fin metodo cirugiasPendientes	
	


	
	//se consultan los examenes pendientes por facturar
	public function examenesPendientes(){

		$resultado = array();
		
		$query = "SELECT count(E.idExamen) as cantidadExamenes
						FROM tb_examenes AS E    
    				WHERE Not E.idExamen IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Examen' AND estado = 'Activo' )";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadExamenes'];		


		
	}//fin metodo examenesPendientes		

	
	//se consultan los examenes pendientes por facturar
	public function hospitalizacionesPendientes(){

		$resultado = array();
		
		$query = "SELECT count(H.idHospitalizacion) as cantidadHospitalizaciones
						FROM tb_hospitalizacion AS H    
						INNER JOIN tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
    				WHERE Not H.idHospitalizacion IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Hospitalizacion'  AND estado = 'Activo' )";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadHospitalizaciones'];		


		
	}//fin metodo hospitalizacionesPendientes	
	
	
	//metodo para listar las consultas que no se encuentren facturadas
	public function listadoConsultasSinPagar(){
		$resultado = array();
		
		$query = "SELECT C.idConsulta, C.fecha, DATE_FORMAT(C.hora, '%H:%i') as hora,
		
						P.nombre AS nombrePaciente,
						
						PP.idPropietario, PP.identificacion, PP.nombre AS nombre,  PP.apellido,
						
						U.nombre AS nombreMedico, U.apellido AS apellidoMedico
		
						FROM tb_consultas AS C    
						
						INNER JOIN tb_mascotas AS P ON P.idMascota = C.idMascota
						INNER JOIN tb_propietarios AS PP ON PP.idPropietario = P.idPropietario
						INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario
						
    				WHERE Not C.idConsulta IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Consulta'  AND estado = 'Activo' )
    				order by C.fecha desc, C.hora ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;		
	}//fin metodo listadoConsultasSinPagar
	

	
	
//metodo para listar las cirugias que no se encuentren facturadas
	public function listadoCirugiasSinPagar(){
		$resultado = array();
		
		$query = "SELECT C.idCirugia, C.fecha, DATE_FORMAT(C.hora, '%H:%i') as hora,
		
						P.nombre AS nombrePaciente,
						
						PP.idPropietario, PP.identificacion, PP.nombre AS nombre,  PP.apellido,
						
						U.nombre AS nombreMedico, U.apellido AS apellidoMedico
		
						FROM tb_cirugias AS C    
						
						INNER JOIN tb_mascotas AS P ON P.idMascota = C.idMascota
						INNER JOIN tb_propietarios AS PP ON PP.idPropietario = P.idPropietario
						INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario
						
    				WHERE Not C.idCirugia IN (SELECT idTipoDetalle FROM tb_pago_factura_caja_detalle WHERE tipoDetalle = 'Cirugia'  AND estado = 'Activo' )
    				order by C.fecha desc, C.hora ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;		
	}//fin metodo listadoCirugiasSinPagar	
	
	

//metodo para listar los examenes que no se encuentren facturados
	public function listadoExamenesSinPagar(){
		$resultado = array();
		
		$query = "SELECT 
				    E.idExamen,
				    E.fecha,
				    DATE_FORMAT(E.hora, '%H:%i') AS hora,
				    P.nombre AS nombrePaciente,
				    PP.idPropietario,
				    PP.identificacion,
				    PP.nombre AS nombre,
				    PP.apellido,
				    U.nombre AS nombreMedico,
				    U.apellido AS apellidoMedico
				FROM
				    tb_examenes AS E
				        INNER JOIN
				    tb_mascotas AS P ON P.idMascota = E.idMascota
				        INNER JOIN
				    tb_propietarios AS PP ON PP.idPropietario = P.idPropietario
				        INNER JOIN
				    tb_usuarios AS U ON U.idUsuario = E.idUsuario
				WHERE
				    NOT E.idExamen IN (SELECT 
				            idTipoDetalle
				        FROM
				            tb_pago_factura_caja_detalle
				        WHERE
				            tipoDetalle = 'Examen'
				                AND estado = 'Activo')
				ORDER BY E.fecha DESC , E.hora";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;		
	}//fin metodo listadoExamenesSinPagar		
	
		

	//metodo para listar las hospitalizaciones que no se encuentren facturadas
	public function listadoHospitalizacionesSinPagar(){
		$resultado = array();
		
		$query = "SELECT 
				    H.idHospitalizacion,
				    H.fechaIngreso,
				    DATE_FORMAT(H.horaIngreso, '%H:%i') AS hora,
				    DATE_FORMAT(concat(H.fechaIngreso,' ',H.horaIngreso), '%Y-%m-%d %H:%i') As inicioHospitalizacion,
				    DATE_FORMAT(concat(HA.fecha,' ',HA.hora), '%Y-%m-%d %H:%i') As alta,    
				    P.nombre AS nombrePaciente,
				    PP.idPropietario,
				    PP.identificacion,
				    PP.nombre AS nombre,
				    PP.apellido,
				    U.nombre AS nombreMedico,
				    U.apellido AS apellidoMedico
				FROM
				    tb_hospitalizacion AS H
				        INNER JOIN
				    tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
				        INNER JOIN
				    tb_mascotas AS P ON P.idMascota = H.idMascota
				        INNER JOIN
				    tb_propietarios AS PP ON PP.idPropietario = P.idPropietario
				        INNER JOIN
				    tb_usuarios AS U ON U.idUsuario = H.idUsuario
				WHERE
				    NOT H.idHospitalizacion IN (SELECT 
				            idTipoDetalle
				        FROM
				            tb_pago_factura_caja_detalle
				        WHERE
				            tipoDetalle = 'Hospitalizacion'
				                AND estado = 'Activo')
				ORDER BY HA.fecha DESC , HA.hora ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;		
	}//fin metodo listadoHospitalizacionesSinPagar		
		
			
		
	//metodo para consultar los facturadores y sus resoluciones
	public function consultarFacturadoresResolucion(){
			
		$resultado = array();
		
		$query = "SELECT  FR.idFacturadoresResolucionDian,  FR.idFacturador, FR.idResolucionDian, F.identificacion, F.nombre, F.apellido,
					R.numeroResolucion, R.porcentajeIva
					
					From tb_facturadoresResolucionDian AS FR
					INNER JOIN tb_resolucionDian AS R ON R.idResolucionDian = FR.idResolucionDian
					INNER JOIN tb_facturadores AS F ON F.idFacturador = FR.idFacturador
					
					WHERE F.estado = 'A' AND FR.estado = 'A' AND R.estado = 'A'
		
		  ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;			
				
			
		
	}//fin metodo consultarFacturadoresResolucion
			
			
	//metodo para consultar el valor de una consulta guardado en las configuraciones
	function precioConsulta(){
				
		$resultado = array();
		
		$query = "SELECT precioConsulta
					FROM tb_configuraciones";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['precioConsulta'];				
		
	}//fin metodo precioConsulta	
	

	//metodo para consultar el valor de una hospitalizacion guardado en las configuraciones
	function precioHospitalizacion(){
				
		$resultado = array();
		
		$query = "SELECT precioHoraHospitalizacion
					FROM tb_configuraciones";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['precioHoraHospitalizacion'];				
		
	}//fin metodo precioHospitalizacion		
	
		
	//metodo para guardar una factura
	public function guardarFacturaUnElemento($descuento, $iva, $valorIva, $valorBruto, $totalFactura, $numeroImpresiones, $metodoPago, $observaciones, $estadoFactura, $idPropietario, $idFacturador, $idResolucion, $idUsuario, $idSucursal, $idElemento = '0', $cantidad, $tipoDetalle ){
		
		$numeroFactura = "";
		
		$descuento 			= parent::escaparQueryBDCliente($descuento);
		$iva 				= parent::escaparQueryBDCliente($iva);
		$valorIva 			= parent::escaparQueryBDCliente($valorIva);
		$valorBruto 		= parent::escaparQueryBDCliente($valorBruto);
		$totalFactura 		= parent::escaparQueryBDCliente($totalFactura);
		$numeroImpresiones 	= parent::escaparQueryBDCliente($numeroImpresiones);
		$metodoPago 		= parent::escaparQueryBDCliente($metodoPago);
		$observaciones 		= parent::escaparQueryBDCliente($observaciones);
		$estadoFactura 		= parent::escaparQueryBDCliente($estadoFactura);
		$idPropietario 		= parent::escaparQueryBDCliente($idPropietario);
		$idFacturador 		= parent::escaparQueryBDCliente($idFacturador);
		$idResolucion 		= parent::escaparQueryBDCliente($idResolucion);
		$idUsuario 			= parent::escaparQueryBDCliente($idUsuario);
		$idSucursal 		= parent::escaparQueryBDCliente($idSucursal);
		$idElemento 		= parent::escaparQueryBDCliente($idElemento);
		$cantidad 		    = parent::escaparQueryBDCliente($cantidad);
		$tipoDetalle 		= parent::escaparQueryBDCliente($tipoDetalle);
		
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT proximaFactura FROM tb_resolucionDian WHERE idResolucionDian = '$idResolucion'";
		
		
		if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                	
	                    $numeroFactura = $filas['proximaFactura'];
						
						
						$query2 = "INSERT INTO tb_facturas (numeroFactura, fecha, hora, fechaFin, horaFin, iva, valorIva, descuento, subtotal, total, numeroImpresiones, metodopago, 
															observaciones, estado, idPropietario, idFacturador, idResolucionDian, idUsuario, idSucursal)
															
											VALUES
											('$numeroFactura', NOW(), NOW(), NOW(), NOW(), '$iva', '$valorIva', '$descuento', '$valorBruto', '$totalFactura', '$numeroImpresiones', '$metodoPago',
											'$observaciones', '$estadoFactura', '$idPropietario', '$idFacturador', '$idResolucion', '$idUsuario', '$idSucursal' )
									";					
						
						
						$res2 = $conexion->query($query2);
						
						$query3 = "UPDATE tb_resolucionDian SET proximaFactura = proximaFactura+1 WHERE idResolucionDian = '$idResolucion' ";
						
						$res3 = $conexion->query($query3);
						
						$query4 = "SELECT MAX(idFactura) as idFactura FROM tb_facturas";
						
						if($res4 = $conexion->query($query4)){
							while ($filas4 = $res4->fetch_assoc()) {
									
								$resultadoIdFactura = $filas4['idFactura'];
								
								$query5 = "INSERT INTO tb_pago_factura_caja (fecha, hora, tipoElemento, idTipoElemento, idUsuario)
										VALUES (NOW(), NOW(), 'Factura', '$resultadoIdFactura', '$idUsuario')";
									
								$res5 = $conexion->query($query5);	
								
								$query6 = "SELECT MAX(idPagoFacturaCaja) as idPagoFacturaCaja FROM tb_pago_factura_caja";
								
								if($res6 = $conexion->query($query6)){
									
									if($tipoDetalle != 'Cirugia' AND  $tipoDetalle != 'Examen' AND $tipoDetalle != 'Producto' AND $tipoDetalle != 'Servicio'){									
									
									
											while ($filas6 = $res6->fetch_assoc()) {
															
												$resultadoIdPagoFacturaCaja = $filas6['idPagoFacturaCaja'];		
													
												$query7 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, idSucursal)
															VALUES ('$tipoDetalle', '$idElemento', '$valorBruto', '$descuento', '$cantidad', 'Activo', '$resultadoIdPagoFacturaCaja', '$idSucursal') ";	
													
												$res7 = $conexion->query($query7);	
												
													
											}//fin while
											
											/* liberar el conjunto de resultados */
					          				$res6->free();
			          				
			          				}//fin if si el tipo detalle no es una cirugia (Los detalles de cirugia son aparte)
									
								}//fin if	
								
							}//fin while
						
							
				            /* liberar el conjunto de resultados */
			          		$res4->free();
						
						}//fin if
						
						
						
						
	                }
	            
	            /* liberar el conjunto de resultados */
          		$res->free();
	           
	        }//fin if ejecucion primer query
	        
	        
	        
            return $resultadoIdFactura;
    	
		
	}//fin metodo guardarFactura
	
	
	
	//metodo para adicionar un item a una factura
	public function adicionarItemFactura($tipoElemento, $precio, $idElemento, $idUsuario, $cantidad, $idSucursal){
						
		$resultado = "";
		$retorno   = "";		
					
		$tipoElemento 		= parent::escaparQueryBDCliente($tipoElemento);
		$precio 			= parent::escaparQueryBDCliente($precio);
		$idElemento 		= parent::escaparQueryBDCliente($idElemento);
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT 
					    PF.idPagoFacturaCaja
					FROM
					    tb_pago_factura_caja AS PF
					        INNER JOIN
					    tb_facturas AS F ON F.idFactura = PF.idTipoElemento
					WHERE
					    PF.tipoElemento = 'Factura'
					        AND F.estado = 'Iniciada'
					        AND F.idUsuario = '$idUsuario';";
				
			
		if($res = $conexion->query($query)){
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];		
					
				if($tipoElemento == 'Cirugia'){
					
					$query7 = "SELECT 
								    PDC.precio, PDC.idPanelCirugiaDiagnostico
								FROM
								    tb_panelesCirugiaDiagnosticos AS PDC
								        INNER JOIN
								    tb_diagnosticosCirugias AS DC ON DC.idPanelCirugiaDiagnostico = PDC.idPanelCirugiaDiagnostico
								WHERE
								    DC.idCirugia = '$idElemento'";
									
					if($res7 = $conexion->query($query7)){
						
						while ($filas7 = $res7->fetch_assoc()) {

							$precio 			= $filas7['precio'];
							$idTipoSubDetalle	= $filas7['idPanelCirugiaDiagnostico'];

							$query8 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, 'idSucursal')
										VALUES ('$tipoElemento', '$idElemento', 'DetalleExamen', '$idTipoSubDetalle', '$precio', '0', '$cantidad', 'Activo', '$resultado', '$idSucursal') ";	
										
							$res8 = $conexion->query($query8);								
							
							
						}
						
					}//fin if q7 cirugia
					
					
				}else if ($tipoElemento == 'Examen'){
						
					$query7 = "SELECT 
								    LE.precio, LE.idListadoExamen
								FROM
								    tb_listadoExamenes AS LE
								        INNER JOIN
								    tb_examenDetalle AS ED ON ED.idListadoExamen = LE.idListadoExamen
								WHERE
								    ED.idExamen = '$idElemento'";
									
					if($res7 = $conexion->query($query7)){
						
						while ($filas7 = $res7->fetch_assoc()) {

							$precio 			= $filas7['precio'];
							$idTipoSubDetalle	= $filas7['idListadoExamen'];

							$query8 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, idSucursal)
										VALUES ('$tipoElemento', '$idElemento', 'DiagnosticoCirugia', '$idTipoSubDetalle', '$precio', '0', '$cantidad', 'Activo', '$resultado', '$idSucursal') ";	
										
							$res8 = $conexion->query($query8);								
							
							
						}
						
					}//fin if q7 cirugia
					
					
				}else if($tipoElemento == 'Servicio' OR $tipoElemento == 'Producto'){
								
					
								
					$query7 = "SELECT 
								    idPagoFacturaCajaDetalle
								FROM
								    tb_pago_factura_caja_detalle
								WHERE
								    tipoDetalle = '$tipoElemento' AND idTipoDetalle = '$idElemento' AND idPagoFacturaCaja = '$resultado' AND estado = 'Activo' ";
									
					if($res7 = $conexion->query($query7)){
						
						$swTipo = 1;
						
						while ($filas7 = $res7->fetch_assoc()) {
							$swTipo = 0;	
							
							$retorno = "Ya existe!";
						}
						
						if($swTipo == 1){
							$query8 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, idSucursal)
								VALUES ('$tipoElemento', '$idElemento', '$precio', '0', '$cantidad', 'Activo', '$resultado', '$idSucursal') ";	
								
							$res8 = $conexion->query($query8);
							
							//saber si es un producto para decontar cantidad
							if($tipoElemento == "Producto"){
								
								$query9 = "UPDATE tb_productos_sucursal SET cantidad = cantidad - '$cantidad' 
												WHERE idSucursal = '$idSucursal' AND idProducto = '$idElemento'";
								
								$conexion->query($query9);
								
							}//fin si es un producto para descontar cantidad de la sucursal
		
							
						}
						
					}//fin if q7 servicio o producto		
						
					
				}else{								
					
					$query7 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, idSucursal)
								VALUES ('$tipoElemento', '$idElemento', '$precio', '0', '$cantidad', 'Activo', '$resultado', '$idSucursal') ";	
								
					$res7 = $conexion->query($query7);								
						
					
				}//fin else
					

				
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if	
		
		return $retorno;
		
	}//fin metodo adicionarItemFactura
			
			
	//metodo para consultar una factura que se encuentr en curso
	public function consultarFacturaIniciada($idUsuario){
				
		$resultado = array();
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT 
				    F.idFactura,
				    F.numeroFactura,
				    F.fecha,
				    F.hora,
				    F.iva,
				    F.valorIva,
				    F.descuento,
				    F.metodopago,
				    F.observaciones,
				    F.idPropietario,
				    F.idFacturador,
				    F.idResolucionDian,
				    P.identificacion as identificacionPropietario,
    				P.nombre as nombrePropietario,
				    P.apellido,
				    FACT.nombre AS nombreFacturador,
				    RE.numeroResolucion,
				    PFCD.idPagoFacturaCajaDetalle,
				    PFCD.tipoDetalle,
				    PFCD.idTipoDetalle,
				    PFCD.valorUnitario,
				    PFCD.cantidad,
    				PFCD.descuento
				FROM
				    tb_facturas AS F
				        INNER JOIN
				    tb_propietarios AS P ON P.idPropietario = F.idPropietario
				        INNER JOIN
				    tb_facturadores AS FACT ON FACT.idFacturador = F.idFacturador
				        INNER JOIN
				    tb_resolucionDian AS RE ON RE.idResolucionDian = F.idResolucionDian
				        INNER JOIN
				    tb_pago_factura_caja AS PFC ON PFC.idTipoElemento = F.idFactura
				        AND PFC.tipoElemento = 'Factura'
				        INNER JOIN
				    tb_pago_factura_caja_detalle AS PFCD ON PFCD.idPagoFacturaCaja = PFC.idPagoFacturaCaja
				        AND PFCD.estado = 'Activo'
				WHERE
				    F.idUsuario = '$idUsuario'
				        AND F.estado = 'Iniciada'";
		
		if($res = $conexion->query($query)){
			while ($filas = $res->fetch_assoc()) {
							
				$resultado[] = $filas;
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;
					
		
	}//fin metodo 	consultarFacturaIniciada	
	
	
	//metodo para anular un item del detalle de una factura
	public function anularItemDetalle($idDetalleParaAnular){
				
		$idDetalleParaAnular 		= parent::escaparQueryBDCliente($idDetalleParaAnular);	
		
		$query = "UPDATE tb_pago_factura_caja_detalle SET estado = 'Borrado' WHERE idPagoFacturaCajaDetalle = '$idDetalleParaAnular'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
		//saber si es un producto para retornar la cantidad
		$query2 = "SELECT tipoDetalle, idSucursal, idTipoDetalle, cantidad
					 FROM tb_pago_factura_caja_detalle 
				   WHERE idPagoFacturaCajaDetalle = '$idDetalleParaAnular' ";
		
			
		if($res2 = $conexion->query($query2)){
			while ($filas = $res2->fetch_assoc()) {
							
				if($filas['tipoDetalle'] == "Producto"){
					
					$cantidadAumentar   = 	$filas['cantidad'];	
					$id 				=	$filas['idTipoDetalle'];
					$sucursal			= 	$filas['idSucursal'];
					
					$query3 = "UPDATE tb_productos_sucursal SET cantidad = cantidad + '$cantidadAumentar' 
								WHERE  idSucursal = '$sucursal' AND idProducto = '$id'";		
								
					$conexion->query($query3);
					
					
				}
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res2->free();
			
		}//fin if		
			
		
		
	}//fin metodo anularItemDetalle
	
	
	//metodo para anular una factura
	public function anularFactura($idFactura){
			
		$resultado = "";
				
		$idFactura 		= parent::escaparQueryBDCliente($idFactura);	
		
		$query = "UPDATE tb_facturas SET estado = 'Anulada' WHERE idFactura = '$idFactura'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);	
		
		
		$query2 = "SELECT idPagoFacturaCaja FROM tb_pago_factura_caja WHERE idTipoElemento = '$idFactura' AND tipoElemento = 'Factura'";
		
			
		if($res2 = $conexion->query($query2)){
			while ($filas = $res2->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res2->free();
			
		}//fin if
		
		return $resultado;
		
	}//fin metodo anularFactura
	
	
	//metodo para anular todos los detalles de una factura
	public function anularTodosDetallesFactura($idPagoFacturaCaja){
		
				
		$query = "UPDATE tb_pago_factura_caja_detalle SET estado = 'Anulado' WHERE idPagoFacturaCaja = '$idPagoFacturaCaja'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);	
		
		//retornar los productos al inventario 
		$query2 = "SELECT idTipoDetalle, cantidad, idSucursal 
					FROM tb_pago_factura_caja_detalle 
				  WHERE tipoDetalle = 'Producto' AND idPagoFacturaCaja = '$idPagoFacturaCaja' ";
		
		if($res2 = $conexion->query($query2)){
			
			while ($filas = $res2->fetch_assoc()) {
								
				$cantidadAumentar   = 	$filas['cantidad'];	
				$id 				=	$filas['idTipoDetalle'];
				$sucursal			= 	$filas['idSucursal'];
				
				$query3 = "UPDATE tb_productos_sucursal SET cantidad = cantidad + '$cantidadAumentar' 
							WHERE  idSucursal = '$sucursal' AND idProducto = '$id'";		
							
				$conexion->query($query3);
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res2->free();
			
		}//fin if
		
	}//fin metodo anularTodosDetallesFactura
	
	
	//metodo para finalizar una factura iniciada
	public function finalizarFacturaIniciada($idFactura, $metodoPago, $observaciones, $subTotal, $valorIva, $descuento, $total){
		
		$idFactura 		= parent::escaparQueryBDCliente($idFactura);
		$metodoPago 	= parent::escaparQueryBDCliente($metodoPago);
		$observaciones 	= parent::escaparQueryBDCliente($observaciones);
		$subTotal 		= parent::escaparQueryBDCliente($subTotal);
		$valorIva 		= parent::escaparQueryBDCliente($valorIva);
		$descuento 		= parent::escaparQueryBDCliente($descuento);
		$total 			= parent::escaparQueryBDCliente($total);
		
		
		$query = "UPDATE tb_facturas SET fechaFin = NOW(), horaFin = NOW(), valorIva = '$valorIva',  descuento = '$descuento', subtotal = '$subTotal', 
							total = '$total', observaciones = '$observaciones', metodopago = '$metodoPago', estado = 'Activa'
					WHERE idFactura = '$idFactura'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);			
		
		
	}//fin metodo finalizarFacturaIniciada
	
	
	//-------------------cirugias
	public function consultarDetalleCirugia($idCirugia){
		
		
		$resultado = array();
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT 
					    PDC.idPanelCirugiaDiagnostico, PDC.nombre, PDC.precio
					FROM
					    tb_panelesCirugiaDiagnosticos AS PDC
					        INNER JOIN
					    tb_diagnosticosCirugias AS DC ON DC.idPanelCirugiaDiagnostico = PDC.idPanelCirugiaDiagnostico
					WHERE
					    DC.idCirugia = '$idCirugia'";
		
			
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado[] = $filas;
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;		
		
	}//fin consultarDetalleCirugia
	

	//funcion para guardar el detalle del pago de una cirugia
	public function guardarDetallePagoCirugia($idFactura, $factura_idCirugia, $idPanelCirugiaDiagnostico, $valorBruto, $descuento, $idSucursal){
		
		$idFactura 						= parent::escaparQueryBDCliente($idFactura);
		$factura_idCirugia 				= parent::escaparQueryBDCliente($factura_idCirugia);
		$idPanelCirugiaDiagnostico 		= parent::escaparQueryBDCliente($idPanelCirugiaDiagnostico);
		$valorBruto 					= parent::escaparQueryBDCliente($valorBruto);
		$descuento 						= parent::escaparQueryBDCliente($descuento);
		
		$resultado = "";
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT idPagoFacturaCaja 
					FROM tb_pago_factura_caja
					
					WHERE tipoElemento = 'Factura' AND idTipoElemento = '$idFactura'";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		
		$query2 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle, valorUnitario, descuento, cantidad, idPagoFacturaCaja, estado, idSucursal)
								VALUES ('Cirugia', '$factura_idCirugia', 'DiagnosticoCirugia', '$idPanelCirugiaDiagnostico', '$valorBruto', '$descuento', '1', '$resultado', 'Activo', '$idSucursal')";
		
		$res2 = $conexion->query($query2);
		
		
	}//fin metodo guardarDetallePagoCirugia
	

	
	
	
	//-------------------Examen
	public function consultarDetalleExamen($idExamen){
		
		
		$resultado = array();
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT 
					    LE.idListadoExamen, LE.nombre, LE.precio
					FROM
					    tb_listadoExamenes AS LE
					        INNER JOIN
					    tb_examenDetalle AS DE ON DE.idListadoExamen = LE.idListadoExamen
					WHERE
					    DE.idExamen = '$idExamen'";
		
			
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado[] = $filas;
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;		
		
	}//fin consultarDetalleExamen
		
	

	//funcion para guardar el detalle del pago de un examen
	public function guardarDetallePagoExamen($idFactura, $factura_idExamen, $idListadoExamen, $valorBruto, $descuento, $idSucursal){
		
		$idFactura 						= parent::escaparQueryBDCliente($idFactura);
		$factura_idExamen 				= parent::escaparQueryBDCliente($factura_idExamen);
		$idListadoExamen 				= parent::escaparQueryBDCliente($idListadoExamen);
		$valorBruto 					= parent::escaparQueryBDCliente($valorBruto);
		$descuento 						= parent::escaparQueryBDCliente($descuento);
		
		$resultado = "";
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT idPagoFacturaCaja 
					FROM tb_pago_factura_caja
					
					WHERE tipoElemento = 'Factura' AND idTipoElemento = '$idFactura'";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		
		$query2 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle, valorUnitario, descuento, cantidad, idPagoFacturaCaja, estado, idSucursal)
								VALUES ('Examen', '$factura_idExamen', 'DetalleExamen', '$idListadoExamen', '$valorBruto', '$descuento', '1', '$resultado', 'Activo', '$idSucursal')";
		
		$res2 = $conexion->query($query2);
		
		
	}//fin metodo guardarDetallePagoExamen
		
		
	//metodo para registrar un elemento como no facturado
	public function noFacturarElemento($tipoDetalle, $idDetalle, $motivo, $usuario, $idSucursal){
		
		$tipoDetalle 					= parent::escaparQueryBDCliente($tipoDetalle);
		$idDetalle 						= parent::escaparQueryBDCliente($idDetalle);
		$motivo 						= parent::escaparQueryBDCliente($motivo);
		
		$resultado = "";
		
		$conexion = parent::conexionCliente();
		
		$query = "INSERT INTO tb_pago_factura_caja (fecha, hora, tipoElemento, motivoninguno, idUsuario) 
											VALUES 
											(NOW(), NOW(), 'Ninguno', '$motivo', '$usuario')";
		
		$res = $conexion->query($query);
		
		$query2 = "SELECT MAX(idPagoFacturaCaja) as idPagoFacturaCaja FROM tb_pago_factura_caja";
		
		if($res2 = $conexion->query($query2)){
			
			while ($filas = $res2->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res2->free();
			
		}//fin if
		
		
		$query3 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle, valorUnitario, descuento, cantidad, estado, idPagoFacturaCaja, 'idSucursal') 
								VALUES ('$tipoDetalle', '$idDetalle', '0','0','0','Activo','$resultado', '$idSucursal')";
								
		
		$res3 = $conexion->query($query3);
		
	}//fin metodo noFacturarElemento
	
	
	//metodo para validar la cantidad a descontar d eun producto
	public function validarCantidadProducto($idSucursal, $idProducto){
				
		$resultado = 0;	
					
		$idSucursal 					= parent::escaparQueryBDCliente($idSucursal);		
		$idProducto 					= parent::escaparQueryBDCliente($idProducto);	
			
		$conexion = parent::conexionCliente();	
		
		$query = "SELECT cantidad FROM tb_productos_sucursal where idSucursal = '$idSucursal' AND idProducto = '$idProducto' ";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['cantidad'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;
		
	}//fin metodo validarCantidadProducto
			

	//funcion para guardar los items (detalle) de una facura (Productos o servicios)
	public function guardarDetalleFacturaFactura($idFactura, $id, $tipoDetalle, $valorBruto, $descuento, $cantidad, $idSucursal){
		
		
		$idFactura 						= parent::escaparQueryBDCliente($idFactura);
		$id 							= parent::escaparQueryBDCliente($id);
		$tipoDetalle 					= parent::escaparQueryBDCliente($tipoDetalle);
		$valorBruto 					= parent::escaparQueryBDCliente($valorBruto);
		$descuento 						= parent::escaparQueryBDCliente($descuento);
		$cantidad 						= parent::escaparQueryBDCliente($cantidad);
		
		$resultado = "";
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT idPagoFacturaCaja 
					FROM tb_pago_factura_caja
					
					WHERE tipoElemento = 'Factura' AND idTipoElemento = '$idFactura'";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['idPagoFacturaCaja'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		
		$query2 = "INSERT INTO tb_pago_factura_caja_detalle (tipoDetalle, idTipoDetalle,  valorUnitario, descuento, cantidad, idPagoFacturaCaja, estado, idSucursal)
								VALUES ('$tipoDetalle', '$id',  '$valorBruto', '$descuento', '$cantidad', '$resultado', 'Activo', '$idSucursal')";
		
		$res2 = $conexion->query($query2);
		
		//saber si es un producto para decontar cantidad
		if($tipoDetalle == "Producto"){
			
			$query3 = "UPDATE tb_productos_sucursal SET cantidad = cantidad - '$cantidad' WHERE idSucursal = '$idSucursal' AND idProducto = '$id'";
			
			$res3 = $conexion->query($query3);
			
		}//fin si es un producto para descontar cantidad de la sucursal
		
		
	}//fin metodo guardarDetalleFacturaFactura	
	
	
	//metodo para consultar el nombre d eun producto
	public function consultarNombreProducto($idProducto){

		
		$resultado = "";
			
		$conexion = parent::conexionCliente();	
		
		$query = "SELECT nombre FROM tb_productos where idProducto = '$idProducto' ";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['nombre'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;
		
	}//fin metodo consultarNombreProducto
			

	//metodo para consultar el nombre de un servicio
	public function consultarNombreServicio($idServicio){

		
		$resultado = "";
			
		$conexion = parent::conexionCliente();	
		
		$query = "SELECT nombre FROM tb_servicios where idServicio = '$idServicio' ";
		
		if($res = $conexion->query($query)){
			
			while ($filas = $res->fetch_assoc()) {
							
				$resultado = $filas['nombre'];
					
			}//fin while
			
			/* liberar el conjunto de resultados */
			$res->free();
			
		}//fin if
		
		return $resultado;
		
	}//fin metodo consultarNombreServicio	
	
	
	
	//metodo para contar las facturas
	public function tatalFacturas(){
				
		$resultado = array();
		
		$query = "Select count(idFactura) as cantidadFacturas from tb_facturas WHERE estado <> 'Iniciada'";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadFacturas'];			
		
	}//fin metodo tatalFacturas		
			


        //metodo para listar las facturas
        public function listarFacturas($paginaActual,$records_per_page){
        	
			
			$resultado = array();
		
			$query = " SELECT F.idFactura, F.numeroFactura, F.fecha, DATE_FORMAT(F.hora, '%H:%i') as hora, F.fechaFin, DATE_FORMAT(F.hora, '%H:%i') as horaFin, F.iva, F.valorIva, F.descuento, F.subtotal,
								F.total, F.metodopago, F.observaciones, F.estado, 
								RD.numeroResolucion, 
								FT.identificacion, FT.nombre, FT.apellido,
								P.identificacion as identifiacacionPropietario, P.nombre as nombrePropietario, P.apellido as apellidoPropietario
			
						FROM tb_facturas AS F
						
						 INNER JOIN tb_resolucionDian AS RD ON RD.idResolucionDian = F.idResolucionDian
						 INNER JOIN tb_facturadores AS FT ON FT.idFacturador = F.idFacturador
						 INNER JOIN tb_propietarios AS P ON P.idPropietario = F.idPropietario
						 				 
						
						WHERE F.estado <> 'Iniciada' ORDER BY F.idFactura DESC
						 LIMIT ". (($paginaActual) * $records_per_page). " , ". $records_per_page;
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo listarConsultas	
        
        
        //metodo para aumentar el número de impresion de una factura
        public function aumentarNumeroImpresion($idFactura){
        			
        		
			$idFactura 						= parent::escaparQueryBDCliente($idFactura);
			
			$conexion = parent::conexionCliente();
			
			$query = "UPDATE tb_facturas SET numeroImpresiones = numeroImpresiones +1 WHERE idFactura = '$idFactura'";
			
			$res = $conexion->query($query);
			
        	
        }//fin metodo aumentarNumeroImpresion
        			
        			
		//metodo para listar una factura	
		public function listarUnaFactura($idFactura){
			
			$idFactura 						= parent::escaparQueryBDCliente($idFactura);
			
			$resultado = array();
		
			$query = " SELECT 
						    F.idFactura,
						    F.numeroFactura,
						    F.fecha,
						    F.hora,
						    F.fechaFin,
						    DATE_FORMAT(F.horaFin, '%H:%i') as horaFin,
						    F.iva,
						    F.valorIva,
						    F.descuento,
						    F.subtotal,
						    F.total,
						    F.metodopago,
						    F.observaciones,
						    F.estado,
						    RD.numeroResolucion,
						    RD.fechaResolucion,
						    FT.identificacion,
						    FT.nombre,
						    FT.apellido,
						    P.identificacion AS identifiacacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono, 
						    P.celular,
						    P.email,
						    P.direccion,
						    PFC.idPagoFacturaCaja
						FROM
						    tb_facturas AS F
						        INNER JOIN
						    tb_resolucionDian AS RD ON RD.idResolucionDian = F.idResolucionDian
						        INNER JOIN
						    tb_facturadores AS FT ON FT.idFacturador = F.idFacturador
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = F.idPropietario
						        INNER JOIN
						    tb_pago_factura_caja AS PFC ON PFC.idTipoElemento = F.idFactura
						WHERE
						    F.idFactura = '$idFactura'
						        AND PFC.tipoElemento = 'Factura'";
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
			
		}//fin metodo listarUnaFactura
		
		
		//metodo para listar el detalle de una factura al momento de imprimir
		public function consultarDetalleFacturaImprimir($idPagoFacturaCaja, $estadoFactura){
					
			$resultado = array();	
						
			if($estadoFactura == "Anulada"){
				
				$query = "SELECT idPagoFacturaCajaDetalle, tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle,
								valorUnitario, descuento, cantidad
					  FROM tb_pago_factura_caja_detalle 
					  WHERE estado <> 'Borrado' AND idPagoFacturaCaja = '$idPagoFacturaCaja'";
					  
			}else{
				
				$query = "SELECT idPagoFacturaCajaDetalle, tipoDetalle, idTipoDetalle, tipoSubDetalle, idTipoSubDetalle,
									valorUnitario, descuento, cantidad
						  FROM tb_pago_factura_caja_detalle 
						  WHERE estado <> 'Anulado' AND estado <> 'Borrado' AND idPagoFacturaCaja = '$idPagoFacturaCaja'";	
						  			
			}
				

			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
		}//fin metodo consultarDetalleFacturaImprimir
		
		
		//metodo para consltar el nombre de una cirugia
		public function consultarNombreCirugia($idCirugia){
				
			$resultado = "";	
				
				$query = "SELECT nombre. codigo
					  FROM tb_panelesCirugiaDiagnosticos 
					  WHERE  idPanelCirugiaDiagnostico = '$idCirugia'";
			

			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
		}//fin metodo consultarNombreCirugia

		
		
		//metodo para consltar el nombre de un examen
		public function consultarNombreExamen($idExamen){
				
			$resultado = "";	
				
				$query = "SELECT nombre, codigo
					  FROM tb_listadoExamenes 
					  WHERE  idListadoExamen = '$idExamen'";
			

			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
		}//fin metodo consultarNombreExamen		

		
		//metodo para consltar el nombre de un producto
		public function consultarNombreProductoImpresion($idProducto){
				
			$resultado = "";	
				
				$query = "SELECT nombre, codigo
					  FROM tb_productos 
					  WHERE  idProducto = '$idProducto'";
			

			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
		}//fin metodo consultarNombreProducto				

		
		//metodo para consltar el nombre de un servicio
		public function consultarNombreServicioImpresion($idServicio){
				
			$resultado = "";	
				
				$query = "SELECT nombre, codigo
					  FROM tb_servicios 
					  WHERE  idServicio = '$idServicio'";
			

			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
		}//fin metodo consultarNombreServicio			
																				
}//fin clase


?>