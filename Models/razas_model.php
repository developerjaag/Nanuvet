<?php
/*
    * Archivo que manipula la información de las razas
    
*/

    class razas extends Config{
        
        
        //metodo para buscar una especie según un string ingresado en un campo input text
        public function buscarRazaConString($string, $idEspecie = ""){
            
            $string  	= parent::escaparQueryBDCliente($string);
			$idEspecie  = parent::escaparQueryBDCliente($idEspecie); 
            
            $resultado = array();

			if($idEspecie == ""){
				
				$query  = "SELECT idRaza, nombre from tb_razas ".
					    " where  (nombre like '%$string%') ";
				
			}else{
			
				$query  = "SELECT idRaza, nombre from tb_razas ".
					    " where  (nombre like '%$string%') and estado = 'A' and idEspecie = '$idEspecie' ";
				
			}

            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idRaza'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarRazaConString
    
    
          
        //metodo para saber si una raza existe
        public function comprobarExistenciaRaza($nombreRaza, $idEspecie){
            
            $nombreRaza  = parent::escaparQueryBDCliente($nombreRaza); 
            $idEspecie  = parent::escaparQueryBDCliente($idEspecie); 
            
            
            $resultado = array();
            
            $query  = "SELECT idRaza, nombre from tb_razas ".
					    " WHERE  nombre = '$nombreRaza' and idEspecie = '$idEspecie' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaRaza
        
        
        
        //metodo para guardar una nueva raza
        public function guardarRaza($nombreRaza, $idEspecie){
            
           $nombreRaza  = parent::escaparQueryBDCliente($nombreRaza); 
		   $idEspecie   = parent::escaparQueryBDCliente($idEspecie); 
            
           $query = "INSERT INTO tb_razas (nombre, idEspecie, estado) ".
                        " VALUES ('$nombreRaza', '$idEspecie' ,'A') ";
           
		   
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarRaza     

        
        
        
       //metodo para editar una raza
        public function editarRaza($idRaza, $nombreRaza){
 
           $query = "UPDATE tb_razas SET nombre = '$nombreRaza' WHERE idRaza = '$idRaza' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarRaza         
 
 
        //metodo para contar la cantidad de razas
        public function tatalRazas(){        	

			$resultado = array();
			
			$query = "Select count(idRaza) as cantidadRazas from tb_razas ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadRazas'];			
			
			
        }//fin metodo tatalRazas 
 

        //metodo para listar las razas
        public function listarRazas($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT R.idRaza, R.nombre as nombreR, R.estado, R.idEspecie, E.nombre as nombreE
						FROM tb_razas AS R						INNER JOIN tb_especies AS E ON R.idEspecie = E.idEspecie
						ORDER BY (R.nombre)
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
			
			
        }//fin metodo listarRazas

        
        
        //metodo para activar una razas
        public function activarRaza($idRaza){

            
           $query = "UPDATE tb_razas SET estado = 'A' WHERE idRaza = '$idRaza' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarRaza        
                 

                 
        //metodo para desactivar una raza
        public function desactivarRaza($idRaza){

            
           $query = "UPDATE tb_razas SET estado = 'I' WHERE idRaza = '$idRaza' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarRaza

        
        //metodo para listar una raza
        public function listarUnaRaza($idRaza){
        	
			$resultado = array();
		
			$query = " SELECT R.idRaza, R.nombre as nombreR, R.estado, R.idEspecie, E.nombre as nombreE
						FROM tb_razas AS R
						INNER JOIN tb_especies AS E ON R.idEspecie = E.idEspecie
						WHERE R.idRaza = '$idRaza'";
						
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
			
			
        }//fin metodo listarUnaRaza                    
                                 
                    
        
    }//fin clase