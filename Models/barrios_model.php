<?php
/*
    * Archivo que manipula la información de los barrios
    
*/

    class barrios extends Config{
        
        
        //metodo para buscar un barrio según un string ingresado en un campo input text
        public function buscarBarrioConString($string, $idCiudad = ""){
            
            $string  = parent::escaparQueryBDCliente($string); 
            
            $resultado = array();
            
			if($idCiudad == ""){
				
	            $query  = "SELECT idBarrio, nombre from tb_barrios ".
						    " WHERE  (nombre LIKE '%$string%')";				
							
			}else{
				
	            $query  = "SELECT idBarrio, nombre from tb_barrios ".
						    " WHERE  (nombre LIKE '%$string%') AND estado = 'A' AND idCiudad = '$idCiudad' ";			
								
			}
			
			

            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idBarrio'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarBarrioConString
        
        
        //metodo para saber si un barrio existe con una ciudad determinada
        public function comprobarExistenciaBarrio($idCiudad, $nombreBarrio){
            
            $nombreBarrio  = parent::escaparQueryBDCliente($nombreBarrio); 
            
            
            $resultado = array();
            
            $query  = "SELECT idBarrio, nombre from tb_barrios ".
					    " where  idCiudad = '$idCiudad' and nombre = '$nombreBarrio' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaBarrio
        
        
        
        //metodo para guardar un nuevo barrio
        public function guardarBarrio($idCiudad, $nombreBarrio){
            
           $nombreBarrio  = parent::escaparQueryBDCliente($nombreBarrio); 
            
           $query = "INSERT INTO tb_barrios (nombre, idCiudad, estado) ".
                        " VALUES ('$nombreBarrio', '$idCiudad', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarBarrio
        
        
        //metodo para contar la cantidad de barrios
        public function tatalBarrios(){        	

			$resultado = array();
			
			$query = "Select count(idBarrio) as cantidadBarrio from tb_barrios ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadBarrio'];			
			
			
        }//fin metodo tatalBarrios
        
        
        //metodo para listar los barrios
        public function listarBarrios($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT B.idBarrio, B.nombre AS nombreB, B.idCiudad, B.estado, C.nombre AS nombreC, P.idPais, P.nombre AS nombreP
						FROM tb_barrios AS B
						INNER JOIN tb_ciudades AS C ON C.idCiudad = B.idCiudad
						INNER JOIN tb_paises AS P ON P.idPais = C.idPais
						ORDER BY (B.nombre)
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
			
			
        }//fin metodo listarBarrios
 
 
        
        //metodo para desactivar un barrio
        public function desactivarBarrio($idBarrio){

            
           $query = "UPDATE tb_barrios SET estado = 'I' WHERE idBarrio = '$idBarrio' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarBarrio
 
 
 
         //metodo para activar un barrio
        public function activarBarrio($idBarrio){

            
           $query = "UPDATE tb_barrios SET estado = 'A' WHERE idBarrio = '$idBarrio' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarBarrio

        
        
        
        //metodo para listar un barrio
        public function listarUnBarrio($idBarrio){
        	
			$resultado = array();
		
			$query = " SELECT B.idBarrio, B.nombre AS nombreB, B.idCiudad, B.estado, C.nombre AS nombreC, P.idPais, P.nombre AS nombreP
						FROM tb_barrios AS B
						INNER JOIN tb_ciudades AS C ON C.idCiudad = B.idCiudad
						INNER JOIN tb_paises AS P ON P.idPais = C.idPais
						WHERE B.idBarrio = '$idBarrio'";
						
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
			
			
        }//fin metodo listarBarrios        
        
        
        //metodo para editar un barrio
        public function editarBarrio($idBarrio, $nombreBarrio){
 
           $query = "UPDATE tb_barrios SET nombre = '$nombreBarrio' WHERE idBarrio = '$idBarrio' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarBarrio
        
                
    }//fin clase