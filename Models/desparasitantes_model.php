<?php


/**
 * clase par alos datos de los desparasitantes
 */
class desparasitantes extends Config {
	

        //metodo para contar la cantidad de desparasitantes de una mascota
        public function tatalDesparasitantesPaciente($idPaciente){        	

			$resultado = array();
			
			$query = "Select count(idDesparasitanteMascota) as cantidadDesparasitantes from tb_desparasitantesMascotas WHERE idMascota = '$idPaciente' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadDesparasitantes'];			
			
			
        }//fin metodo tatalDesparasitantesPaciente 



        //metodo para listar los desparasitantes aplicados a un paciente
        public function listarDesparasitantesPaciente($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			
			$resultado = array();
		
			$query = " SELECT PD.idDesparasitanteMascota, PD.fecha, PD.dosificacion, PD.observacion, PD.idDesparasitante, PD.fechaProximoDesparasitante,
							 D.nombre, D.descripcion							
							
						FROM tb_desparasitantesMascotas AS PD						
						
						INNER JOIN tb_desparasitantes AS D ON D.idDesparasitante = PD.idDesparasitante
						
						WHERE PD.idMascota = '$idPaciente' ORDER BY PD.idDesparasitanteMascota DESC
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
			
			
        }//fin metodo listarDesparasitantesPaciente 
        

        
        //metodo para listar los un desparasitantes aplicados a un paciente
        public function listarUnDesparasitantesPaciente($idDesparasitante){
        	
			$idDesparasitante	= parent::escaparQueryBDCliente($idDesparasitante);
			
			
			$resultado = array();
		
			$query = " SELECT PD.idDesparasitanteMascota, PD.fecha, PD.dosificacion, PD.observacion, PD.idDesparasitante, PD.fechaProximoDesparasitante, PD.idMascota,
							 D.nombre, D.descripcion							
							
						FROM tb_desparasitantesMascotas AS PD						
						
						INNER JOIN tb_desparasitantes AS D ON D.idDesparasitante = PD.idDesparasitante
						
						WHERE PD.idDesparasitanteMascota = '$idDesparasitante' ";
					
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
			
			
        }//fin metodo listarUnDesparasitantesPaciente         
        
        
                
        //metodo para guardar la aplicación de un desparasitantes
        public function guardarAplicacionDesparasitante($idPaciente, $idDesparasitante, $dosificacion, $fechaProximoDesparasitante, $observaciones, $idPacienteReplica){
        			
        	$resultado = "";	
        				
        	$idPaciente					= parent::escaparQueryBDCliente($idPaciente);
        	$idDesparasitante			= parent::escaparQueryBDCliente($idDesparasitante);
        	$dosificacion				= parent::escaparQueryBDCliente($dosificacion);
			$fechaProximoDesparasitante	= parent::escaparQueryBDCliente($fechaProximoDesparasitante);
			$observaciones				= parent::escaparQueryBDCliente($observaciones);	
			
           $query = "INSERT INTO tb_desparasitantesMascotas (dosificacion, fecha, hora, fechaProximoDesparasitante, observacion, idMascota, idDesparasitante) ".
            " VALUES ('$dosificacion', NOW(), NOW(), '$fechaProximoDesparasitante', '$observaciones', '$idPaciente', '$idDesparasitante') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
	
			/*---------- Replica -------*/
			$nombreDesparasitante = '';
			$queryConsulta = "SELECT nombre FROM tb_desparasitantes WHERE idDesparasitante = '$idDesparasitante'";
			if($res2 = $conexion->query($queryConsulta)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $nombreDesparasitante = $filas['nombre'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
	           
	        }
			
			$queryReplica = "INSERT INTO tb_desparasitantes (dosificacion, fecha, hora, fechaProximoDesparasitante, nombre, observaciones, idMascota, estado) ".
            " VALUES ('$dosificacion', NOW(), NOW(), '$fechaProximoDesparasitante', '$nombreDesparasitante' ,'$observaciones', '$idPacienteReplica', 'A') ";
           
	
           $conexionReplica = parent::conexionReplica();
    		
            if($resReplica = $conexionReplica->query($queryReplica)){
                
                    $resultado = "Ok";
            }
			/*---------- Replica -------*/
	
	
            return $resultado;	
        		
        	
        }//fin metodo guardarAplicacionDesparasitante



        //metodo para buscar un desparasitante según un string ingresado en un campo input text
        public function buscarDesparasitanteConString($sting, $utilizar = 'No', $idSucursal = ''){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idDesparasitante, nombre, descripcion FROM tb_desparasitantes ".
					    " where  (nombre like '%$sting%') ";
			}else{
				
				$query  = "SELECT 
							    D.idDesparasitante,
							    D.nombre,
							    D.descripcion,
							    (SELECT 
							            idProducto
							        FROM
							            tb_productos
							        WHERE
							            tipoExterno = 'Desparasitante'
							                AND idExterno = D.idDesparasitante) AS resultadoIdProducto,
							    (SELECT 
							            cantidad
							        FROM
							            tb_productos_sucursal
							        WHERE
							            idProducto = resultadoIdProducto
							                AND idSucursal = '$idSucursal') AS cantidadDisponible
							FROM
							    tb_desparasitantes AS D
							WHERE
							    (D.nombre LIKE '%$sting%')
							        AND (D.estado = 'A'); ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
							
	                	if($utilizar == 'No'){
	                		
		                    $resultado[] =   array('label' => $filas['nombre'],
		                    						'id' => $filas['idDesparasitante'],
		                    						'nombre' => $filas['nombre'],
		                    						'value' => $filas['nombre'] );	                		
	                	}else{
	                		
		                    $resultado[] =   array('label' => $filas['nombre'],
		                    						'id' => $filas['idDesparasitante'],
		                    						'nombre' => $filas['nombre'],
		                    						'value' => $filas['nombre'],
		                    						'resultadoIdProducto' => $filas['resultadoIdProducto'],
		                    						'cantidadDisponible' => $filas['cantidadDisponible'] );	    	                		
	                	}//fin else
						

	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarDesparasitanteConString

	
        //metodo para saber si un desparasitante existe
        public function comprobarExistenciaDesparasitante($nombreDesparasitante){
            
            $nombreDesparasitante  = parent::escaparQueryBDCliente($nombreDesparasitante); 
            
            
            $resultado = array();
            
            $query  = "SELECT idDesparasitante, nombre from tb_desparasitantes ".
					    " where   nombre = '$nombreDesparasitante' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaDesparasitante




        //metodo para guardar una nuevo desparasitante 
        public function guardarDesparasitante($nombreDesparasitante, $descripcion){
            
		   $resultado = "";
			
           $nombreDesparasitante  = parent::escaparQueryBDCliente($nombreDesparasitante); 
		   $descripcion  = parent::escaparQueryBDCliente($descripcion); 
            
           $query = "INSERT INTO tb_desparasitantes (nombre, descripcion, estado) ".
                        " VALUES ('$nombreDesparasitante', '$descripcion', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarCategoria


        //metodo para editar un desparasitante
        public function editarDesparasitante($idDesparasitante, $nombreDesparasitante, $descripcion){
 
 			$resultado = "";
 
 		   $nombreDesparasitante  = parent::escaparQueryBDCliente($nombreDesparasitante); 
		   $descripcion  = parent::escaparQueryBDCliente($descripcion);
 
           $query = "UPDATE tb_desparasitantes SET nombre = '$nombreDesparasitante', descripcion = '$descripcion' WHERE idDesparasitante = '$idDesparasitante' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarDesparasitante 


        //metodo para contar la cantidad de desparasitantes
        public function tatalDesparasitantes(){        	

			$resultado = array();
			
			$query = "Select count(idDesparasitante) as cantidadDesparasitantes from tb_desparasitantes ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadDesparasitantes'];			
			
			
        }//fin metodo tatalDesparasitantes 



        //metodo para listar los desparasitantes
        public function listarDesparasitantes($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idDesparasitante, nombre, descripcion, estado
						FROM tb_desparasitantes
						ORDER BY (nombre)
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
			
			
        }//fin metodo listarDesparasitantes



        //metodo para activar un desparasitante
        public function activarDesparasitante($idDesparasitante){

            
           $query = "UPDATE tb_desparasitantes SET estado = 'A' WHERE idDesparasitante = '$idDesparasitante' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarDesparasitante        
                 

                 
        //metodo para desactivar un desparasitante
        public function desactivarDesparasitante($idDesparasitante){

            
           $query = "UPDATE tb_desparasitantes SET estado = 'I' WHERE idDesparasitante = '$idDesparasitante' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarDesparasitante

        
        //metodo para listar un desparasitante
        public function listarUnDesparasitante($idDesparasitante){
        	
			$resultado = array();
		
			$query = " SELECT idDesparasitante, nombre, descripcion, estado
						FROM tb_desparasitantes
						WHERE idDesparasitante = '$idDesparasitante'";
						
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
			
			
        }//fin metodo listarUnDesparasitante    



	//metodo para consultar los desparasitantes que no se encuentre vinculadas con productos
	public function desparasitantesNoVinculadosProductos(){
		
			$resultado = array();
		
			$query = "SELECT 
						    D.idDesparasitante, D.nombre, D.descripcion
						FROM
						    tb_desparasitantes AS D
						WHERE
						    D.estado = 'A' AND D.idDesparasitante NOT IN (SELECT 
						            idExterno
						        FROM
						            tb_productos
						        WHERE
						            tipoExterno = 'Desparasitante'
						                AND (idExterno <> '0' OR idExterno <> NULL));";
						
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
		
	}//fin metodo desparasitantesNoVinculadosProductos
	
	
		//consultar los desparasitantes para impresion por fechas
		public function desparasitantesImpresionFechas($idPaciente){
			
			$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
			
			$resultado = array();
			
			$query = "SELECT 
						    fecha, hora, idDesparasitanteMascota
						FROM
						    tb_desparasitantesMascotas
						WHERE
						    idMascota = '$idPaciente' ";
							
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
			
		}//fin metodo desparasitantesImpresionFechas
	


}//fin clase


?>