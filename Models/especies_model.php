<?php
/*
    * Archivo que manipula la información de las especies
    
*/

    class especies extends Config{
        
        
        //metodo para buscar una especie según un string ingresado en un campo input text
        public function buscarEspecieConString($string, $utilizar = 'No'){
            
            $string  = parent::escaparQueryBDCliente($string); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idEspecie, nombre from tb_especies ".
					    " where  (nombre like '%$string%') ";
			}else{
				
				$query  = "SELECT idEspecie, nombre from tb_especies ".
					    " where  (nombre like '%$string%') and estado = 'A' ";
			}
            
            
            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idEspecie'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPaisConString
        
        
        
        //metodo para saber si una especie existe
        public function comprobarExistenciaEspecie($nombreEspecie){
            
            $nombreEspecie  = parent::escaparQueryBDCliente($nombreEspecie); 
            
            
            $resultado = array();
            
            $query  = "SELECT idEspecie, nombre from tb_especies ".
					    " WHERE  nombre = '$nombreEspecie' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaEspecie
        
        
        
        //metodo para guardar una nueva especie
        public function guardarEspecie($nombreEspecie){
            
           $nombreEspecie  = parent::escaparQueryBDCliente($nombreEspecie); 
            
           $query = "INSERT INTO tb_especies (nombre, estado) ".
                        " VALUES ('$nombreEspecie', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarEspecie       
 
 
 
 
 
       //metodo para editar una especie
        public function editarEspecie($idEspecie, $nombreEspecie){
 
           $query = "UPDATE tb_especies SET nombre = '$nombreEspecie' WHERE idEspecie = '$idEspecie' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarEspecie         
 
 
        //metodo para contar la cantidad de especies
        public function tatalEspecies(){        	

			$resultado = array();
			
			$query = "Select count(idEspecie) as cantidadEspecie from tb_especies ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadEspecie'];			
			
			
        }//fin metodo tatalEspecies 
 

        //metodo para listar las especies
        public function listarEspecies($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idEspecie, nombre, descripcion, estado
						FROM tb_especies 
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
			
			
        }//fin metodo listarEspecies

        
        
        //metodo para activar una especie
        public function activarEspecie($idEspecie){

            
           $query = "UPDATE tb_especies SET estado = 'A' WHERE idEspecie = '$idEspecie' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarEspecie        
                 

                 
        //metodo para desactivar una especie
        public function desactivarEspecie($idEspecie){

            
           $query = "UPDATE tb_especies SET estado = 'I' WHERE idEspecie = '$idEspecie' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarEspecie

        
        //metodo para listar una especie
        public function listarUnaEspecie($idEspecie){
        	
			$resultado = array();
		
			$query = " SELECT idEspecie, nombre, descripcion, estado
						FROM tb_especies 
						WHERE idEspecie = '$idEspecie'";
			
			
						
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
			
			
        }//fin metodo listarUnaEspecie      
 

 
        
    }//fin clase