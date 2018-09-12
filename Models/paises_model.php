<?php
/*
    * Archivo que manipula la información de los paises
    
*/

    class paises extends Config{
        
        
        //metodo para buscar un pais según un string ingresado en un campo input text
        public function buscarPaisConString($sting){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();
            
            $query  = "SELECT idPais, nombre from tb_paises ".
					    " where  (nombre like '%$sting%') and estado = 'A' ";
            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idPais'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPaisConString
        
    }//fin clase