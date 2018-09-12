<?php


/**
 * clase par alos datos de los medicamentos
 */
class medicamentos extends Config {
	

        //metodo para buscar un Medicamento según un string ingresado en un campo input text
        public function buscarMedicamentoConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idMedicamento, nombre FROM tb_listadoMedicamentos ".
					    " where  (nombre like '%$sting%') or (codigo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idMedicamento, nombre FROM tb_listadoMedicamentos ".
					    " where  ((nombre like '%$sting%') OR (codigo like '%$sting%')) AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idMedicamento'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarMedicamentoConString

	
        //metodo para saber si un medicamento existe
        public function comprobarExistenciaMedicamento($nombreMedicamento){
            
            $nombreMedicamento  = parent::escaparQueryBDCliente($nombreMedicamento); 
            
            
            $resultado = array();
            
            $query  = "SELECT idMedicamento, nombre from tb_listadoMedicamentos ".
					    " where   nombre = '$nombreMedicamento' ";

            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaMedicamento




        //metodo para guardar una nuevo medicamento 
        public function guardarMedicamento($nombreMedicamento, $codigoMedicamento, $observacionMedicamento){
            
           $nombreMedicamento  = parent::escaparQueryBDCliente($nombreMedicamento);
		   $codigoMedicamento  = parent::escaparQueryBDCliente($codigoMedicamento);
		   $observacionMedicamento  = parent::escaparQueryBDCliente($observacionMedicamento);
            
           $query = "INSERT INTO tb_listadoMedicamentos (nombre, codigo,  observacion, estado) ".
                        " VALUES ('$nombreMedicamento', '$codigoMedicamento',  '$observacionMedicamento', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarMedicamento


        //metodo para editar un medicamento
        public function editarMedicamento($idMedicamento, $nombreMedicamento, $codigoMedicamento, $observacionMedicamento ){
 
 			$resultado = "";
 
 		   $nombreMedicamento  = parent::escaparQueryBDCliente($nombreMedicamento); 
		   $codigoMedicamento  = parent::escaparQueryBDCliente($codigoMedicamento); 
		   $observacionMedicamento  = parent::escaparQueryBDCliente($observacionMedicamento); 
 
           $query = "UPDATE tb_listadoMedicamentos SET nombre = '$nombreMedicamento', codigo = '$codigoMedicamento', observacion = '$observacionMedicamento' 
           WHERE idMedicamento = '$idMedicamento' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarMedicamento 


        //metodo para contar la cantidad de medicamentos
        public function tatalMedicamentos(){        	

			$resultado = array();
			
			$query = "Select count(idMedicamento) as cantidadMedicamentos from tb_listadoMedicamentos ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadMedicamentos'];			
			
			
        }//fin metodo tatalMedicamentos 



        //metodo para listar los medicamentos
        public function listarMedicamentos($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idMedicamento, nombre, codigo, observacion, estado
						FROM tb_listadoMedicamentos
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
			
			
        }//fin metodo listarMedicamentos



        //metodo para activar un medicamentos
        public function activarMedicamento($idMedicamento){

            
           $query = "UPDATE tb_listadoMedicamentos SET estado = 'A' WHERE idMedicamento = '$idMedicamento' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarMedicamento        
                 

                 
        //metodo para desactivar un medicamento
        public function desactivarMedicamento($idMedicamento){

            
           $query = "UPDATE tb_listadoMedicamentos SET estado = 'I' WHERE idMedicamento = '$idMedicamento' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarMedicamento

        
        //metodo para listar un medicamento
        public function listarUnMedicamento($idMedicamento){
        	
			$resultado = array();
		
			$query = " SELECT idMedicamento, nombre, codigo, observacion, estado
						FROM tb_listadoMedicamentos
						WHERE idMedicamento = '$idMedicamento'";
						
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
			
			
        }//fin metodo listarUnMedicamento    



	//metodo para consultar los que no se encuentre vinculadas con productos
	public function medicamentosNoVinculadosProductos(){
		
			$resultado = array();
		
			$query = " SELECT 
						    M.idMedicamento, M.codigo, M.nombre, M.observacion
						FROM
						    tb_listadoMedicamentos AS M
						WHERE
						    M.estado = 'A' AND M.idMedicamento NOT IN (SELECT 
						            idExterno
						        FROM
						            tb_productos
						        WHERE
						            tipoExterno = 'Medicamento'
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
		
	}//fin metodo medicamentosNoVinculadosProductos





}//fin clase


?>