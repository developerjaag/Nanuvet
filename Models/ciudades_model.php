<?php
/*
    * Archivo que manipula la información de las ciudades
    
*/

    class ciudades extends Config{
        
        
        //metodo para buscar una ciudad según un string ingresado en un campo input text
        public function buscarCiudadConString($sting, $idPais = ""){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();
            
			if($idPais == ""){
				
				$query  = "SELECT idCiudad, nombre from tb_ciudades ".
					    " where  (nombre like '%$sting%') ";
				
			}else{
			
				$query  = "SELECT idCiudad, nombre from tb_ciudades ".
						    " where  (nombre like '%$sting%') and estado = 'A' and idPais = '$idPais' ";
				
			}
			            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idCiudad'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarCiudadConString
        
        
        //metodo para saber si una ciudad existe con un pais determinado
        public function comprobarExistenciaCiudad($idPais, $nombreCiudad){
            
            $nombreCiudad  = parent::escaparQueryBDCliente($nombreCiudad); 
            
            
            $resultado = array();
            
            $query  = "SELECT idCiudad, nombre from tb_ciudades ".
					    " where  idPais = '$idPais' and nombre = '$nombreCiudad' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaCiudad
        
        
        
        //metodo para guardar una nueva ciudad
        public function guardarCiudad($idPais, $nombreCiudad){
            
           $nombreCiudad  = parent::escaparQueryBDCliente($nombreCiudad); 
            
           $query = "INSERT INTO tb_ciudades (nombre, idPais, estado) ".
                        " VALUES ('$nombreCiudad', '$idPais', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarCiudad
        

        //metodo para editar una ciudad
        public function editarCiudad($idCiudad, $nombreCiudad){
 
           $query = "UPDATE tb_ciudades SET nombre = '$nombreCiudad' WHERE idCiudad = '$idCiudad' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarCiudad         
 
 
        //metodo para contar la cantidad de ciudades
        public function tatalCiudades(){        	

			$resultado = array();
			
			$query = "Select count(idCiudad) as cantidadCiudad from tb_ciudades ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadCiudad'];			
			
			
        }//fin metodo tatalCiudades 
 

        //metodo para listar las ciudades
        public function listarCiudades($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT C.idCiudad, C.estado, C.nombre AS nombreC, P.idPais, P.nombre AS nombreP
						FROM tb_ciudades AS C
						INNER JOIN tb_paises AS P ON P.idPais = C.idPais
						ORDER BY (C.nombre)
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
			
			
        }//fin metodo listarCiudades

        
        
        //metodo para activar una ciudad
        public function activarCiudad($idCiudad){

            
           $query = "UPDATE tb_ciudades SET estado = 'A' WHERE idCiudad = '$idCiudad' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarCiudad        
                 

                 
        //metodo para desactivar una ciudad
        public function desactivarCiudad($idCiudad){

            
           $query = "UPDATE tb_ciudades SET estado = 'I' WHERE idCiudad = '$idCiudad' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarCiudad

        
        //metodo para listar una ciudad
        public function listarUnaCiudad($idCiudad){
        	
			$resultado = array();
		
			$query = " SELECT C.idCiudad, C.estado, C.nombre AS nombreC, P.idPais, P.nombre AS nombreP
						FROM tb_ciudades AS C
						INNER JOIN tb_paises AS P ON P.idPais = C.idPais
						WHERE C.idCiudad = '$idCiudad'";
						
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
			
			
        }//fin metodo listarUnaCiudad                    
                                 
    }//fin clase