<?php

/**
 * modelo para gestionar la iunformacion de los proveedores
 */
class proveedores extends Config {



        //metodo para buscar un proveedor según un string ingresado en un campo input text
        public function buscarProveedorConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idProveedor, nombre, identificativoNit FROM tb_proveedores ".
					    " where  (nombre like '%$sting%') OR (identificativoNit like '%$sting%') ";
			}else{
				
				$query  = "SELECT idProveedor, nombre, identificativoNit FROM tb_proveedores ".
					    " where  (nombre like '%$sting%') OR (identificativoNit like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['identificativoNit']." ".$filas['nombre'],
	                    						'id' => $filas['idProveedor'],
	                    						'value' => $filas['identificativoNit']." ".$filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarProveedorConString



	
	//metodo para totalizar los proveedores
	public function tatalProveedores(){
		
			$resultado = array();
			
			$query = "Select count(idProveedor) as cantidadproveedores from tb_proveedores ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadproveedores'];			
		
		
		
	}//fin metodo tatalProveedores
	
	
	//metodo para listar los proveedores
	public function listarProveedores($paginaActual,$records_per_page){
		
			$resultado = array();
		
			$query = " SELECT idProveedor, identificativoNit, nombre, telefono1, telefono2, celular, direccion, email,  estado
						FROM tb_proveedores
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

	}//fin metodo 



	//metodo para listar un solo  proveedores
	public function listarUnProveedor($idProveedor){
		
			$resultado = array();
		
			$query = " SELECT idProveedor, identificativoNit, nombre, telefono1, telefono2, celular, direccion, email,  estado
						FROM tb_proveedores
						WHERE idProveedor = '$idProveedor'";
						
						
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

	}//fin metodo listarUnProveedor



	//metodo para guardar un proveedor
	public function guardarProveedor($identificacion, $nombre, $telefono1, $telefono2, $celular, $email, $direccion){
		
           $identificacion  	= parent::escaparQueryBDCliente($identificacion); 
		   $nombre  			= parent::escaparQueryBDCliente($nombre); 
		   $telefono1  			= parent::escaparQueryBDCliente($telefono1); 
		   $telefono2  			= parent::escaparQueryBDCliente($telefono2); 
		   $celular  			= parent::escaparQueryBDCliente($celular); 
		   $email  				= parent::escaparQueryBDCliente($email); 
		   $direccion  			= parent::escaparQueryBDCliente($direccion); 
            
           $query = "INSERT INTO tb_proveedores (identificativoNit, nombre, telefono1, telefono2, celular, direccion, email, estado) ".
                        " VALUES ('$identificacion', '$nombre', '$telefono1', '$telefono2', '$celular', '$direccion', '$email', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
		
		
	}///fin metodo guardarProveedor
	
	
	//metodo para editar un proveedor
	public function editarProveedor($idProveedor,$identificacion, $nombre, $telefono1, $telefono2, $celular, $email, $direccion){
		
           $identificacion  	= parent::escaparQueryBDCliente($identificacion); 
		   $nombre  			= parent::escaparQueryBDCliente($nombre); 
		   $telefono1  			= parent::escaparQueryBDCliente($telefono1); 
		   $telefono2  			= parent::escaparQueryBDCliente($telefono2); 
		   $celular  			= parent::escaparQueryBDCliente($celular); 
		   $email  				= parent::escaparQueryBDCliente($email); 
		   $direccion  			= parent::escaparQueryBDCliente($direccion); 
            
           $query = "UPDATE  tb_proveedores  SET identificativoNit = '$identificacion', nombre = '$nombre', telefono1 = '$telefono1',
           										telefono2 = '$telefono2', celular = '$celular', direccion = '$direccion', email = '$email'
           				WHERE idProveedor = '$idProveedor' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;		
		
		
	}//fin metodo editarProveedor
	

	//metodo para desactivar un proveedor
	public function desactivarProveedor($idProveedor){
		
           $query = "UPDATE tb_proveedores SET estado = 'I' WHERE idProveedor = '$idProveedor' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;   		
	}//fin desactivarProveedor

	
	//metodo para activar un proveedor
	public function activarProveedor($idProveedor){
		
           $query = "UPDATE tb_proveedores SET estado = 'A' WHERE idProveedor = '$idProveedor' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;   		
	}//fin desactivarProveedor	
	

}//fin class



?>