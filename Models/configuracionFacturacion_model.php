<?php

/**
 * Clase para manipular los datos de las configuraciones de facturacion y caja
 */
class configuracionFacturacion extends Config {
	
	
	//metodo para guardar una nueva resolucion
	public function guardarNuevaResolucion($numeroResolucion, $resolucion_autocorrectorIva, $resolucion_porcentajeIva, $resolucion_consecutivoInicial,
																	$resolucion_consecutivoFinal, $resolucion_iniciarEn, $resolucion_fecha, $resolucion_fechaVencimiento, $proximaFactura){
																		
			
			$numeroResolucion  				= parent::escaparQueryBDCliente($numeroResolucion); 
			$resolucion_autocorrectorIva  	= parent::escaparQueryBDCliente($resolucion_autocorrectorIva); 
			$resolucion_porcentajeIva  		= parent::escaparQueryBDCliente($resolucion_porcentajeIva); 
			$resolucion_consecutivoInicial  = parent::escaparQueryBDCliente($resolucion_consecutivoInicial); 
			$resolucion_consecutivoFinal  	= parent::escaparQueryBDCliente($resolucion_consecutivoFinal); 
			$resolucion_iniciarEn  			= parent::escaparQueryBDCliente($resolucion_iniciarEn); 
			$resolucion_fecha  				= parent::escaparQueryBDCliente($resolucion_fecha); 
			$resolucion_fechaVencimiento  	= parent::escaparQueryBDCliente($resolucion_fechaVencimiento); 
			$proximaFactura  				= parent::escaparQueryBDCliente($proximaFactura); 
			
			if($proximaFactura == '0'){
				$proximaFactura = '1';
			};
			
			
			
			$query = "INSERT INTO tb_resolucionDian (numeroResolucion, consecutivoInicial, consecutivoFinal,
													 iniciarFacturaEn, fechaResolucion, fechaVencimiento, 
													 autoCorrectorIva, porcentajeIva, proximaFactura ,estado) 
                         VALUES ('$numeroResolucion', '$resolucion_consecutivoInicial', '$resolucion_consecutivoFinal', 
                         		'$resolucion_iniciarEn', '$resolucion_fecha', '$resolucion_fechaVencimiento', 
                         		'$resolucion_autocorrectorIva', '$resolucion_porcentajeIva', '$proximaFactura', 'A') ";
           
	
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
			
																		
																		
																		
	}//fin metodo guardarNuevaResolucion
	
	
	//metodo para listar las resoluciones existentes
	public function listarResoluciones(){
		
			$resultado = array();
		
			$query = " SELECT idResolucionDian, numeroResolucion, consecutivoInicial, consecutivoFinal, iniciarFacturaEn, 
								fechaResolucion, fechaResolucion, fechaVencimiento, autoCorrectorIva, porcentajeIva, proximaFactura, estado
						FROM tb_resolucionDian ORDER BY estado ASC";
						
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
			
		
		
	}//fin metodo listarResoluciones
	
	
	//metodo para desactivar una resolucion
	public function desactivarResolucion($idResolucion){
		
		
		$query = "UPDATE tb_resolucionDian SET estado = 'I'
					WHERE idResolucionDian = '$idResolucion'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);
		
	}//fin metodo desactivarResolucion
	
	
	//metodo para activar una resolucion
	public function activarResolucion($idResolucion){
					
		$query = "UPDATE tb_resolucionDian SET estado = 'A'
					WHERE idResolucionDian = '$idResolucion'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);		
			
		
	}//fin metodo activarResolucion
	

/*----------------------------- Facturadores -------------------*/
	
	//metodo para guardar un nuevo facturador
	public function guardarNuevoFacturador($facturador_identifiacion, $facturador_nombre, $facturador_apellido, $facturador_telefono,
																$facturador_celular, $facturador_direccion, $facturador_email, $facturador_tipoRegimen,
																$facturador_razonSocial, $facturador_identifiacionEmisor, $facturador_nombreEmisor){
			
																		
		$facturador_identifiacion  			= parent::escaparQueryBDCliente($facturador_identifiacion);
		$facturador_nombre  				= parent::escaparQueryBDCliente($facturador_nombre);
		$facturador_apellido  				= parent::escaparQueryBDCliente($facturador_apellido);
		$facturador_telefono  				= parent::escaparQueryBDCliente($facturador_telefono);
		$facturador_celular  				= parent::escaparQueryBDCliente($facturador_celular);
		$facturador_direccion  				= parent::escaparQueryBDCliente($facturador_direccion);
		$facturador_email  					= parent::escaparQueryBDCliente($facturador_email);
		$facturador_tipoRegimen  			= parent::escaparQueryBDCliente($facturador_tipoRegimen);
		$facturador_razonSocial  			= parent::escaparQueryBDCliente($facturador_razonSocial);
		$facturador_identifiacionEmisor  	= parent::escaparQueryBDCliente($facturador_identifiacionEmisor);
		$facturador_nombreEmisor  			= parent::escaparQueryBDCliente($facturador_nombreEmisor); 
		
		
		$query = "INSERT INTO tb_facturadores(identificacion,nombre,apellido,telefono,celular,direccion,email,tipoRegimen,
							razonSocial,identificacionEmisor,nombreEmisor,estado) 
				 VALUES 
				 
				 ('$facturador_identifiacion', '$facturador_nombre', '$facturador_apellido', '$facturador_telefono', '$facturador_celular',
				 	'$facturador_direccion', '$facturador_email', '$facturador_tipoRegimen', '$facturador_razonSocial', '$facturador_identifiacionEmisor',
				 	'$facturador_nombreEmisor', 'A'
				 )";
           
	
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
																	
																	
	}//fin metodo guardarNuevoFacturador 	
	

	
	
	//metodo para guardar una edicion de un facturador
	public function guardarEdicionFacturador($idFacturador, $facturador_identifiacion, $facturador_nombre, $facturador_apellido, $facturador_telefono,
																$facturador_celular, $facturador_direccion, $facturador_email, $facturador_tipoRegimen,
																$facturador_razonSocial, $facturador_identifiacionEmisor, $facturador_nombreEmisor){
			
			
		$idFacturador  						= parent::escaparQueryBDCliente($idFacturador);																
		$facturador_identifiacion  			= parent::escaparQueryBDCliente($facturador_identifiacion);
		$facturador_nombre  				= parent::escaparQueryBDCliente($facturador_nombre);
		$facturador_apellido  				= parent::escaparQueryBDCliente($facturador_apellido);
		$facturador_telefono  				= parent::escaparQueryBDCliente($facturador_telefono);
		$facturador_celular  				= parent::escaparQueryBDCliente($facturador_celular);
		$facturador_direccion  				= parent::escaparQueryBDCliente($facturador_direccion);
		$facturador_email  					= parent::escaparQueryBDCliente($facturador_email);
		$facturador_tipoRegimen  			= parent::escaparQueryBDCliente($facturador_tipoRegimen);
		$facturador_razonSocial  			= parent::escaparQueryBDCliente($facturador_razonSocial);
		$facturador_identifiacionEmisor  	= parent::escaparQueryBDCliente($facturador_identifiacionEmisor);
		$facturador_nombreEmisor  			= parent::escaparQueryBDCliente($facturador_nombreEmisor); 
		
		
		$query = "UPDATE tb_facturadores  SET identificacion = '$facturador_identifiacion', nombre = '$facturador_nombre', apellido = '$facturador_apellido', 
											telefono = '$facturador_telefono' , celular = '$facturador_celular', direccion = '$facturador_direccion',
											email = '$facturador_email', tipoRegimen = '$facturador_tipoRegimen', razonSocial = '$facturador_razonSocial',
											identificacionEmisor = '$facturador_identifiacionEmisor', nombreEmisor = '$facturador_nombreEmisor' 
				 WHERE idFacturador = '$idFacturador' ";
           
		   
	
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
																	
																	
	}//fin metodo guardarNuevoFacturador 	
	
	
		
	//metodo para consultar los datos de todos los facturadores
	public function listarFacturadores(){
		
		$resultado = array();
		
			$query = " SELECT idFacturador, identificacion, nombre, apellido, telefono, celular, direccion, email, 
								tipoRegimen, razonSocial, identificacionEmisor, nombreEmisor, estado
						FROM tb_facturadores ORDER BY estado ASC";
						
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
		
		
	}//fin metodo listarFacturadores
	

	//metodo para desactivar un facturador
	public function desactivarFacturador($idFacturador){
		
		
		$query = "UPDATE tb_facturadores SET estado = 'I'
					WHERE idFacturador = '$idFacturador'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);
		
	}//fin metodo desactivarResolucion
	
	
	//metodo para activar un facturador
	public function activarFacturador($idFacturador){
					
		$query = "UPDATE tb_facturadores SET estado = 'A'
					WHERE idFacturador = '$idFacturador'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);		
			
		
	}//fin metodo activarResolucion
	
	
	
		
	//metodo para consultar los facturadores para el select
	public function consultarFacturadoresSelect(){
		
			$resultado = array();
		
			$query = " SELECT F.idFacturador, F.identificacion, F.nombre, F.apellido
			
						FROM tb_facturadores as F
												
						WHERE F.estado = 'A'  ORDER BY nombre ASC";
						
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
		
	}//fin metodo consultarFacturadoresSelect
	
	
	//metodo para guardar la vinculacion de un facturador con una resolucion
	public function guardarVinculoFacturadorResolucion($idResolucion, $idFacturador){
		
		$resultado = "";
		
		$idResolucion  	= parent::escaparQueryBDCliente($idResolucion); 
		$idFacturador  	= parent::escaparQueryBDCliente($idFacturador); 
			


		$query = " SELECT idFacturadoresResolucionDian
			
						FROM tb_facturadoresResolucionDian
												
						WHERE idFacturador = '$idFacturador' AND  idResolucionDian = '$idResolucion'";
				
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                   
					  $resultado = "existe";
					   
					   
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
		
			
		if($resultado != "existe"){

					$query2 = "INSERT INTO tb_facturadoresResolucionDian (estado, idFacturador, idResolucionDian)
						VALUES
						('A', '$idFacturador', '$idResolucion') ";      

		
			        if($res2 = $conexion->query($query2)){
			            
			                $resultado = "Ok";
			        }
			
		}

			


        return $resultado;
		
		
	}//fin metodo guardarVinculoFacturadorResolucion
	
	
	//metodo para consultar los facturadores de una resolucion
	public function consultarFacturadoresResolucion($idResolucion){
		
		$resultado = array();
		
			$query = " SELECT  R.idFacturadoresResolucionDian, F.identificacion, F.nombre, F.apellido, F.tipoRegimen, F.razonSocial, F.identificacionEmisor, F.nombreEmisor,
								R.estado
			
						FROM tb_facturadores as F
						
						INNER JOIN tb_facturadoresResolucionDian as R on R.idFacturador = F.idFacturador
																		
						WHERE R.idResolucionDian = '$idResolucion'";
						
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
	
	
	//metodo para desactivar un vinculo entre un facturador y una resolucion
	public function desactivarVinculoFacturadorResolucion($idVinculo){
		
		$query = "UPDATE tb_facturadoresResolucionDian SET estado = 'I'
					WHERE idFacturadoresResolucionDian = '$idVinculo'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);		
		
	}//fin metodo desactivarVinculoFacturadorResolucion
		

	//metodo para desactivar un vinculo entre un facturador y una resolucion
	public function activarVinculoFacturadorResolucion($idVinculo){
		
		$query = "UPDATE tb_facturadoresResolucionDian SET estado = 'A'
					WHERE idFacturadoresResolucionDian = '$idVinculo'";
		
		$conexion = parent::conexionCliente();
		
		$conexion->query($query);		
		
	}//fin metodo desactivarVinculoFacturadorResolucion		
	
	
	//metodo para guardar un facturador por defecto
	public function facturadorPorDefecto($idFacturador){
		
		$query = " SELECT  idconfiguracion from tb_configuraciones";
			
		$sw = 0; 
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    		
	                    $sw = 1;	
	                    
	                }
	            
				
				
					if($sw == 0){
						
						$query2 = "Insert into tb_configuraciones (idFacturadorPorDefecto) values ('$idFacturador')";
						
					}else{
						
						$query2 = "UPDATE tb_configuraciones SET idFacturadorPorDefecto = '$idFacturador'";
						
												
					}
					
					
					$conexion->query($query2);
				
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
		
		
	}//fin metodo facturadorPorDefecto
	
	
	
	//metodo pra consultar el facturador por defecto
	public function consultarConfiguracionesPorDefecto(){
		
		$resultado = array();
		
			$query = " SELECT  idFacturadorPorDefecto, precioConsulta, precioHoraHospitalizacion FROM tb_configuraciones";
						
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
		
	}//fin metodo consultarFacturadorPorDefecto
	

	
	//metodo para guardar los precios de consulta y hospitalizacion en facturacion
	public function guardarPrecios($precioConsulta, $precioHospitalizacion){
		
		$query = " SELECT  idconfiguracion from tb_configuraciones";
			
		$sw = 0; 
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    		
	                    $sw = 1;	
	                    
	                }
	            
				
				
					if($sw == 0){
						
						$query2 = "Insert into tb_configuraciones (precioConsulta, precioHoraHospitalizacion) values ('$precioConsulta', '$precioHospitalizacion')";
						
					}else{
						
						$query2 = "UPDATE tb_configuraciones SET precioConsulta = '$precioConsulta', precioHoraHospitalizacion = '$precioHospitalizacion'";
						
												
					}
					
					
					$conexion->query($query2);
				
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
		
		
	}//fin metodo guardarPrecios
			
			
}//fin clase


?>