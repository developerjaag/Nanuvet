<?php

/**
 * clase para manipular los datos d elos tipos de cita
 */
class tiposCita extends Config {
	
		//metodo para listar los tipos de cita que se encuentren activos (Select)
        public function listarTiposCitaSelect(){
        	
			$resultado = array();
		
			$query = " SELECT idTipoCita, nombre
						FROM tb_tiposCita
						WHERE estado = 'A'
						ORDER BY (nombre)";
						 
						
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
			
			
        }//fin metodo listarTiposCitaSelect 
        
        
        //metodo para saber si un tipo de cita existe
        public function comprobarExistenciaTipoCita($nombreTipoCita){
            
            $nombreTipoCita  = parent::escaparQueryBDCliente($nombreTipoCita); 
            
            
            $resultado = array();
            
            $query  = "SELECT idTipoCita, nombre from tb_tiposCita ".
					    " where   nombre = '$nombreTipoCita' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaTipoCita	
	

	
        //metodo para guardar un nuevo tipo de cita 
        public function guardarTipoCita($nombreTipoCita){
            
           $nombreTipoCita  = parent::escaparQueryBDCliente($nombreTipoCita); 
		   
            
           $query = "INSERT INTO tb_tiposCita (nombre, estado) ".
                        " VALUES ('$nombreTipoCita', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarTipoCita	
        
        
        //metodo para editar un tipo de cita
        public function editarTipoCita($idTipoCita, $nombreVacuna){
 
 			$resultado = "";
 
 		   $nombreVacuna  = parent::escaparQueryBDCliente($nombreVacuna); 
		   
 
           $query = "UPDATE tb_tiposCita SET nombre = '$nombreVacuna' WHERE idTipoCita = '$idTipoCita' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarTipoCita     
        

        //metodo para contar la cantidad de tipos de cita
        public function tatalTiposCita(){        	

			$resultado = array();
			
			$query = "Select count(idTipoCita) as cantidadTiposCita from tb_tiposCita ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadTiposCita'];			
			
			
        }//fin metodo tatalTiposCita         
 
 
        //metodo para listar los tipos de cita
        public function listarTiposCita($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idTipoCita, nombre, estado
						FROM tb_tiposCita
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
			
			
        }//fin metodo listarTiposCita 

        
        //metodo para activar un tipo de cita
        public function activarTipoCita($idTipoCita){

            
           $query = "UPDATE tb_tiposCita SET estado = 'A' WHERE idTipoCita = '$idTipoCita' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarTipoCita          
                    

                    
        //metodo para desactivar un tipo de cita
        public function desactivarTipoCita($idTipoCita){

            
           $query = "UPDATE tb_tiposCita SET estado = 'I' WHERE idTipoCita = '$idTipoCita' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarTipoCita                    
 
 
        //metodo para buscar un tipo de cita según un string ingresado en un campo input text
        public function buscarTipoCitaConString($sting){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();

				
				$query  = "SELECT idTipoCita, nombre FROM tb_tiposCita ".
					    " where  (nombre like '%$sting%') ";
		

            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	               
							 $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idTipoCita'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );		

	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarTipoCitaConString

  
        //metodo para listar un tipo de cita
        public function listarUnTipoCita($idTipoCita){
        	
			$resultado = array();
		
			$query = " SELECT idTipoCita, nombre, estado
						FROM tb_tiposCita
						WHERE idTipoCita = '$idTipoCita'";
		
						
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
			
			
        }//fin metodo listarUnTipoCita     
                    		
}//fin clase
