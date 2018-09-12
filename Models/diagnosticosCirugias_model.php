<?php


/**
 * clase para los datos de los diagnosticos
 */
class diagnosticosCirugias extends Config {
	

        //metodo para buscar un diagnostico según un string ingresado en un campo input text
        public function buscarDiagnosticoConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPanelCirugiaDiagnostico, nombre, codigo, observacion FROM tb_panelesCirugiaDiagnosticos ".
					    " where  ((nombre like '%$sting%') or (codigo like '%$sting%')) ";
			}else{
				
				$query  = "SELECT idPanelCirugiaDiagnostico, nombre, codigo, observacion FROM tb_panelesCirugiaDiagnosticos ".
					    " where  ((nombre like '%$sting%') or (codigo like '%$sting%')) AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['codigo']." ".$filas['nombre'],
	                    						'id' => $filas['idPanelCirugiaDiagnostico'],
	                    						'nombre' => $filas['nombre'],
	                    						'codigo' => $filas['codigo'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarDiagnosticoConString

	
        //metodo para saber si un diagnostico existe
        public function comprobarExistenciaDiagnostico($nombreDiagnostico){
            
            $nombreDiagnostico  = parent::escaparQueryBDCliente($nombreDiagnostico); 
            
            
            $resultado = array();
            
            $query  = "SELECT idPanelCirugiaDiagnostico, nombre from tb_panelesCirugiaDiagnosticos ".
					    " where   nombre = '$nombreDiagnostico' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaDiagnostico




        //metodo para guardar una nuevo diagnostico 
        public function guardarDiagnostico($nombreDiagnostico, $codigoDiagnostico, $observacionDiagnostico, $precioDiagnostico ){
            
           $nombreDiagnostico  		= parent::escaparQueryBDCliente($nombreDiagnostico); 
		   $codigoDiagnostico  		= parent::escaparQueryBDCliente($codigoDiagnostico); 
		   $observacionDiagnostico  = parent::escaparQueryBDCliente($observacionDiagnostico); 
		   $precioDiagnostico  		= parent::escaparQueryBDCliente($precioDiagnostico); 
            
           $query = "INSERT INTO tb_panelesCirugiaDiagnosticos (nombre, codigo, observacion, precio, estado, idPanelCirugia) ".
                        " VALUES ('$nombreDiagnostico', '$codigoDiagnostico', '$observacionDiagnostico', '$precioDiagnostico', 'A', '1') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarDiagnostico


        //metodo para editar un diagnostico
        public function editarDiagnostico($idDiagnostico, $nombreDiagnostico, $codigoDiagnostico, $observacionDiagnostico, $precioDiagnostico ){
 
 			$resultado = "";
 
 		   $nombreDiagnostico  		= parent::escaparQueryBDCliente($nombreDiagnostico); 
		   $codigoDiagnostico  		= parent::escaparQueryBDCliente($codigoDiagnostico); 
		   $observacionDiagnostico  = parent::escaparQueryBDCliente($observacionDiagnostico); 
		   $precioDiagnostico  		= parent::escaparQueryBDCliente($precioDiagnostico); 
 
           $query = "UPDATE tb_panelesCirugiaDiagnosticos SET nombre = '$nombreDiagnostico', codigo = '$codigoDiagnostico',
           							observacion = '$observacionDiagnostico', precio = '$precioDiagnostico' 
           
           			WHERE idPanelCirugiaDiagnostico = '$idDiagnostico' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarDiagnostico 


        //metodo para contar la cantidad de diagnosticos
        public function tatalDiagnosticos(){        	

			$resultado = array();
			
			$query = "Select count(idPanelCirugiaDiagnostico) as cantidadDiagnosticos from tb_panelesCirugiaDiagnosticos ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadDiagnosticos'];			
			
			
        }//fin metodo tatalDiagnosticos 



        //metodo para listar los diagnosticos
        public function listarDiagnosticos($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idPanelCirugiaDiagnostico, nombre, codigo, observacion, precio, estado
						FROM tb_panelesCirugiaDiagnosticos
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
			
			
        }//fin metodo listarDiagnosticos



        //metodo para activar un diagnostico
        public function activarDiagnostico($idDiagnostico){

            
           $query = "UPDATE tb_panelesCirugiaDiagnosticos SET estado = 'A' WHERE idPanelCirugiaDiagnostico = '$idDiagnostico' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarDiagnostico        
                 

                 
        //metodo para desactivar un diagnostico
        public function desactivarDiagnostico($idDiagnostico){

            
           $query = "UPDATE tb_panelesCirugiaDiagnosticos SET estado = 'I' WHERE idPanelCirugiaDiagnostico = '$idDiagnostico' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarDiagnostico

        
        //metodo para listar un diagnostico
        public function listarUnDiagnostico($idDiagnostico){
        	
			$resultado = array();
		
			$query = " SELECT idPanelCirugiaDiagnostico, nombre, codigo, observacion, precio, estado
						FROM tb_panelesCirugiaDiagnosticos
						WHERE idPanelCirugiaDiagnostico = '$idDiagnostico'";
						
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
			
			
        }//fin metodo listarUnDiagnostico    




}//fin clase


?>