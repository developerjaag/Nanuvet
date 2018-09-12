<?php


/**
 * clase para los datos de los servicios
 */
class servicios extends Config {
	

        //metodo para buscar un servicio según un string ingresado en un campo input text
        public function buscarServicioConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idServicio, nombre, codigo, precio, descripcion FROM tb_servicios ".
					    " where  ((nombre like '%$sting%') or (codigo like '%$sting%')) ";
			}else{
				
				$query  = "SELECT idServicio, nombre, codigo, precio, descripcion FROM tb_servicios ".
					    " where  ((nombre like '%$sting%') or (codigo like '%$sting%')) AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['codigo']." ".$filas['nombre'],
	                    						'id' => $filas['idServicio'],
	                    						'nombre' => $filas['nombre'],
	                    						'codigo' => $filas['codigo'],
	                    						'value' => $filas['nombre'],
	                    						'precio' => $filas['precio'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarServicioConString

	
        //metodo para saber si un servicio existe
        public function comprobarExistenciaServicio($nombreServicio){
            
            $nombreServicio  = parent::escaparQueryBDCliente($nombreServicio); 
            
            
            $resultado = array();
            
            $query  = "SELECT idServicio, nombre from tb_servicios ".
					    " where   nombre = '$nombreServicio' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaServicio




        //metodo para guardar una nuevo servicio 
        public function guardarServicio($nombreServicio, $codigoServicio, $descripcionServicio, $precioServicio ){
            
           $nombreServicio  		= parent::escaparQueryBDCliente($nombreServicio); 
		   $codigoServicio  		= parent::escaparQueryBDCliente($codigoServicio); 
		   $descripcionServicio  = parent::escaparQueryBDCliente($descripcionServicio); 
		   $precioServicio  		= parent::escaparQueryBDCliente($precioServicio); 
            
           $query = "INSERT INTO tb_servicios (nombre, codigo, descripcion, precio, estado) ".
                        " VALUES ('$nombreServicio', '$codigoServicio', '$descripcionServicio', '$precioServicio', 'A') ";
           
           
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarServicio


        //metodo para editar un servicio
        public function editarServicio($idServicio, $nombreServicio, $codigoServicio, $descripcionServicio, $precioServicio){
 
 			$resultado = "";
 
 		   $nombreServicio  		= parent::escaparQueryBDCliente($nombreServicio); 
		   $codigoServicio  		= parent::escaparQueryBDCliente($codigoServicio); 
		   $descripcionServicio  	= parent::escaparQueryBDCliente($descripcionServicio); 
		   $precioServicio  		= parent::escaparQueryBDCliente($precioServicio); 
 
           $query = "UPDATE tb_servicios SET nombre = '$nombreServicio', codigo = '$codigoServicio',
           							descripcion = '$descripcionServicio', precio = '$precioServicio' 
           
           			WHERE idServicio = '$idServicio' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarServicio 


        //metodo para contar la cantidad de servicos
        public function tatalServicios(){        	

			$resultado = array();
			
			$query = "Select count(idServicio) as cantidadServicios from tb_servicios ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadServicios'];			
			
			
        }//fin metodo tatalServicios 



        //metodo para listar los servicios
        public function listarServicios($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idServicio, nombre, codigo, descripcion, precio, estado
						FROM tb_servicios
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
			
			
        }//fin metodo listarServicios



        //metodo para activar un servicio
        public function activarServicio($idServicio){

            
           $query = "UPDATE tb_servicios SET estado = 'A' WHERE idServicio = '$idServicio' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarServicio        
                 

                 
        //metodo para desactivar un servicio
        public function desactivarServicio($idServicio){

            
           $query = "UPDATE tb_servicios SET estado = 'I' WHERE idServicio = '$idServicio' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarServicio

        
        //metodo para listar un servicio
        public function listarUnServicio($idServicio){
        	
			$resultado = array();
		
			$query = " SELECT idServicio, nombre, codigo, descripcion, precio, estado
						FROM tb_servicios
						WHERE idServicio = '$idServicio'";
						
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
			
			
        }//fin metodo listarUnServicio    




}//fin clase


?>