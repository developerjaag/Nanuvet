<?php

/**
 * Clase para las categorías de los productos
 */
class categoriasProductos extends Config {


        //metodo para buscar una categoría según un string ingresado en un campo input text
        public function buscarCategoriaConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idCategoria, nombre FROM tb_categoriasProductos ".
					    " where  (nombre like '%$sting%') ";
			}else{
				
				$query  = "SELECT idCategoria, nombre FROM tb_categoriasProductos ".
					    " where  (nombre like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idCategoria'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarCategoriaConString

	
        //metodo para saber si una categoría existe
        public function comprobarExistenciaCategoria($nombreCategoria){
            
            $nombreCategoria  = parent::escaparQueryBDCliente($nombreCategoria); 
            
            
            $resultado = array();
            
            $query  = "SELECT idCategoria, nombre from tb_categoriasProductos ".
					    " where   nombre = '$nombreCategoria' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaCategoria




        //metodo para guardar una nueva categoria
        public function guardarCategoria($nombreCategoria){
            
           $nombreCategoria  = parent::escaparQueryBDCliente($nombreCategoria); 
            
           $query = "INSERT INTO tb_categoriasProductos (nombre, estado) ".
                        " VALUES ('$nombreCategoria', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarCategoria


        //metodo para editar una categoria
        public function editarCategoria($idCategoria, $nombreCategoria){
 
           $query = "UPDATE tb_categoriasProductos SET nombre = '$nombreCategoria' WHERE idCategoria = '$idCategoria' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarCategoria 


        //metodo para contar la cantidad de categorias
        public function tatalCategorias(){        	

			$resultado = array();
			
			$query = "Select count(idCategoria) as cantidadCategoria from tb_categoriasProductos ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadCategoria'];			
			
			
        }//fin metodo tatalCategorias 



        //metodo para listar las categorías
        public function listarCategorias($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idCategoria, nombre, estado
						FROM tb_categoriasProductos
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
			
			
        }//fin metodo listarCategorias



        //metodo para listar las categorías activas para el select
        public function listarCategoriasSelect(){
        	
			$resultado = array();
		
			$query = " SELECT idCategoria, nombre, estado
						FROM tb_categoriasProductos
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
			
			
        }//fin metodo listarCategoriasSelect


        //metodo para activar una CATEGORIA
        public function activarCategoria($idCategoria){

            
           $query = "UPDATE tb_categoriasProductos SET estado = 'A' WHERE idCategoria = '$idCategoria' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarCategoria        
                 

                 
        //metodo para desactivar una categoria
        public function desactivarCategoria($idCategoria){

            
           $query = "UPDATE tb_categoriasProductos SET estado = 'I' WHERE idCategoria = '$idCategoria' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarCategoria

        
        //metodo para listar una categoria
        public function listarUnaCategoria($idCategoria){
        	
			$resultado = array();
		
			$query = " SELECT idCategoria, nombre, estado
						FROM tb_categoriasProductos
						WHERE idCategoria = '$idCategoria'";
						
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
			
			
        }//fin metodo listarUnaCategoria    



}//fin clase



?>