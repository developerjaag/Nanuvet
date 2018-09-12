<?php


/**
 * Clase para manipular los datos de los productos
 */
class productos extends Config {

    //metodo para buscar un producto según un string ingresado en un campo input text
        public function buscarProductoConString($sting, $utilizar = 'No', $vender = 'No', $idSucursal = ''){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($vender == 'Si'){
				
				$query  = "SELECT P.idProducto, P.nombre, P.codigo, P.precio 
								FROM tb_productos AS P
								INNER JOIN tb_productos_sucursal AS PS ON PS.idProducto = P.idProducto
					    	 where  (P.nombre like '%$sting%') OR (P.codigo like '%$sting%') AND P.estado = 'A' AND PS.idSucursal = '$idSucursal'";
				
			}else{
				
				if($utilizar == 'No'){
	
					$query  = "SELECT idProducto, nombre, codigo, precio FROM tb_productos 
						    	 where  (nombre like '%$sting%') OR (codigo like '%$sting%') ";
				}else{
					
					$query  = "SELECT idProducto, nombre, codigo, precio FROM tb_productos 
						    	 where  (nombre like '%$sting%') OR (codigo like '%$sting%') AND estado = 'A' ";
				}
				
			}



	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['codigo']." ".$filas['nombre']." (".$filas['precio'].")",
	                    						'id' => $filas['idProducto'],
	                    						'value' => $filas['codigo']." ".$filas['nombre']." (".$filas['precio'].")",
	                    						'nombre' => $filas['nombre'],
	                    						'precio' => $filas['precio'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarProductoConString


	
	//metodo para totalizar los productos
	public function tatalProductos(){
		
			$resultado = array();
			
			$query = "Select count(idProducto) as cantidadProductos from tb_productos ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadProductos'];			
		
		
		
	}//fin metodo tatalProductos
	
	
	//metodo para listar los productos
	public function listarProductos($paginaActual,$records_per_page){
		
			$resultado = array();
		
			$query = " SELECT P.idProducto, P.nombre, P.descripcion, P.codigo, P.precio, P.estado, P.idCategoria,
								CP.nombre as nombreCategoria, CP.descripcion as descripcionCategoriaProducto
			
						FROM tb_productos AS P
						
						INNER JOIN tb_categoriasProductos AS CP ON P.idCategoria = CP.idCategoria						
						
						ORDER BY (P.nombre)
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

	}//fin metodo 	listarProductos
	

	//metodo para listar un soilo producto
	public function listarUnProducto($idProducto){

		
			$resultado = array();
		
			$query = " SELECT P.idProducto, P.nombre, P.descripcion, P.codigo, P.precio, P.estado, P.idCategoria,
								CP.nombre as nombreCategoria, CP.descripcion as descripcionCategoriaProducto
			
						FROM tb_productos AS P
						
						INNER JOIN tb_categoriasProductos AS CP ON P.idCategoria = CP.idCategoria						
						 WHERE P.idProducto = '$idProducto' ";
						
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
		
	}//fin metodo listarUnProducto
	
	
	
	
	//metodo para guardar un productos
	public function guardarProducto($nombre, $descripcion, $codigo, $precio, $idCategoria, $tipoExterno = '0', $idExterno = '0'){		
           
		   $resultado = "";
		   
		   $nombre  			= parent::escaparQueryBDCliente($nombre); 
		   $descripcion  		= parent::escaparQueryBDCliente($descripcion); 
		   $codigo  			= parent::escaparQueryBDCliente($codigo); 
		   $precio  			= parent::escaparQueryBDCliente($precio); 
		   $idCategoria  		= parent::escaparQueryBDCliente($idCategoria); 
            
           $query = "INSERT INTO tb_productos (nombre, descripcion, codigo, precio, estado, idCategoria, tipoExterno, idExterno) ".
                        " VALUES ('$nombre', '$descripcion', '$codigo', '$precio', 'A', '$idCategoria', '$tipoExterno', '$idExterno') ";
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                   
				  $query2	= "SELECT MAX(idProducto) as ultimoIdProducto FROM tb_productos";
			
					if($res2 = $conexion->query($query2)){
			           
			               /* obtener un array asociativo */
			                while ($filas = $res2->fetch_assoc()) {
			                    $resultado = $filas['ultimoIdProducto'];
			                }
			            
			                /* liberar el conjunto de resultados */
			                $res2->free();
			           
			        }	
				   
				   
            }
    
            return $resultado;
		
		
	}///fin metodo guardarProducto	
	
	
	//metodo para editar un producto
	public function editarProducto($idProducto, $nombre, $codigo, $precio, $idCategoria,$descripcion){
					
		   $resultado = "";
		   
		   $idProducto  			= parent::escaparQueryBDCliente($idProducto); 
		   $nombre  				= parent::escaparQueryBDCliente($nombre); 
		   $codigo  				= parent::escaparQueryBDCliente($codigo); 
		   $precio  				= parent::escaparQueryBDCliente($precio); 
		   $idCategoria  			= parent::escaparQueryBDCliente($idCategoria); 
		   $descripcion  			= parent::escaparQueryBDCliente($descripcion); 
		   
            
           $query = "UPDATE  tb_productos SET nombre = '$nombre',  descripcion = '$descripcion', codigo = '$codigo', precio = '$precio',
           										idCategoria = '$idCategoria'
           						WHERE idProducto = '$idProducto'  ";
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;				
			
		
	}//fin editarProducto
	
	
	
	//metodo para vincular un producto con un proveedor
	public function vincularProductoProveedor($idProducto, $proveedor, $costo){
					
		   $resultado = "";
		   
		   $proveedor  			= parent::escaparQueryBDCliente($proveedor); 
		   $costo  				= parent::escaparQueryBDCliente($costo); 
            
		   $conexion = parent::conexionCliente();
			
			$query0 = "SELECT idProductosProveedores FROM tb_productos_proveedores WHERE idProducto = '$idProducto' AND idProveedor = '$proveedor'";	
			
			if($res0 = $conexion->query($query0)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res0->fetch_assoc()) {
	                    $resultado = "Existe";
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res0->free();
	           
	        }

			if($resultado == ""){
				
				$query = "INSERT INTO tb_productos_proveedores (costo, estado, idProducto, idProveedor) ".
                        " VALUES ('$costo', 'A', '$idProducto', '$proveedor') ";

	            if($res = $conexion->query($query)){				
				
				         $resultado = "Ok"  ;
				}
				
			}//fin if


            return $resultado;
			
					
	}//fin metodo vincularProductoProveedor
	
	
	//metodo para consultar los proveedores de un producto
	public function consultarVinculoProductoProveedores($idProducto, $uso = ""){
		
			$resultado = array();
		
			if($uso == "Select"){
					$query = " SELECT PP.idProductosProveedores, PP.costo, PP.estado,
										PV.idProveedor, PV.nombre as nombreProveedor, PV.identificativoNit
					
								FROM tb_productos_proveedores AS PP
								
								INNER JOIN tb_proveedores AS PV ON PV.idProveedor = PP.idProveedor
								
								WHERE PP.idProducto = '$idProducto'	AND PP.estado = 'A'	order by PP.idProductosProveedores desc";
													
			}else{
				
					$query = " SELECT PP.idProductosProveedores, PP.costo, PP.estado,
										PR.nombre as nombreProducto, PR.codigo,
										PV.nombre as nombreProveedor, PV.identificativoNit
					
								FROM tb_productos_proveedores AS PP
								
								INNER JOIN tb_productos AS PR ON PR.idProducto = PP.idProducto
								INNER JOIN tb_proveedores AS PV ON PV.idProveedor = PP.idProveedor
								
								WHERE PP.idProducto = '$idProducto'		order by PP.idProductosProveedores desc";	
											
			}
		

						
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
		
		
	}//fin metodo consultarVinculoProductoProveedores
	
	
	//metodo para editar el vinculo entre un producto y un proveedor
	public function editarVinculoProductoProveedor($idProductosProveedores, $costo){
			
		   $resultado = "";
		   
		   $costo  						= parent::escaparQueryBDCliente($costo); 
		   $idProductosProveedores  	= parent::escaparQueryBDCliente($idProductosProveedores); 
		   
           $query = "UPDATE tb_productos_proveedores SET costo = '$costo' WHERE idProductosProveedores = '$idProductosProveedores' ";
      
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;		   		
		
	}//fin metodo editarVinculoProductoProveedor
	
	
	//metodo para desactivar un producto
	public function desactivarProducto($idProducto){
		
		   $resultado = "";
			
		   $idProducto  = parent::escaparQueryBDCliente($idProducto); 
		
           $query = "UPDATE tb_productos SET estado = 'I' WHERE idProducto = '$idProducto' ";
      
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;				
		
		
	}//fin metodo desactivarProducto
	

	//metodo para activar un producto
	public function activarProducto($idProducto){
		
		   $resultado = "";
			
		   $idProducto  = parent::escaparQueryBDCliente($idProducto); 
		
           $query = "UPDATE tb_productos SET estado = 'A' WHERE idProducto = '$idProducto' ";
      
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;				
		
		
	}//fin metodo activarProducto	
	
	
	//metodo para consultar el stock de un producto en las sucursales
	public function consultarStockProductoSucursales($idProducto){
		
			$resultado = array();
		
			$query = " SELECT PS.idProductoSucursal, PS.cantidad, PS.stockMinimo, PS.idSucursal,
								S.identificativoNit, S.nombre 
								FROM tb_productos_sucursal AS PS
								INNER JOIN tb_sucursales AS S ON S.idSucursal = PS.idSucursal
								
								WHERE PS.idProducto = '$idProducto'";
					
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
		
		
	}//fin metodo consultarStockProductoSucursales
	
	//metodo para guardar el stock de un producto en una sucursal
	public function guardarStockProductoSucursal($idProducto, $idSucursal, $cantidad, $cantidadMinima){

		   $resultado = "";
			
		   $idProducto  	= parent::escaparQueryBDCliente($idProducto);
		   $idSucursal  	= parent::escaparQueryBDCliente($idSucursal);
		   $cantidad  		= parent::escaparQueryBDCliente($cantidad);
		   $cantidadMinima  = parent::escaparQueryBDCliente($cantidadMinima); 
		
		   $conexion = parent::conexionCliente();
		 
		   $query0 = "SELECT idProductoSucursal FROM tb_productos_sucursal WHERE idProducto = '$idProducto' AND  idSucursal = '$idSucursal'" ;

			if($res0 = $conexion->query($query0)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res0->fetch_assoc()) {
	                    $resultado = "Existe";
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res0->free();
	           
	        }

			if($resultado == ""){

	           $query = "INSERT INTO  tb_productos_sucursal 
	           				(cantidad, stockMinimo, idProducto, idSucursal)
	           			VALUES
	           				('$cantidad', '$cantidadMinima', '$idProducto', '$idSucursal')";
	      
	      
	          
	    		
	            if($res = $conexion->query($query)){				
				
				         $resultado = "Ok"  ;
				}	

				
			}		


            return $resultado;	

		
	}//fin metodo guardarStockProductoSucursal
	
	
	//metodo para editar un stock
	public function editarStockProductoSucursal($idProductoSucursal, $idProducto, $cantidad, $cantidadMinima){

		   $resultado = "";
			
		   $idProductoSucursal  	= parent::escaparQueryBDCliente($idProductoSucursal);
		   $cantidad  				= parent::escaparQueryBDCliente($cantidad);
		   $cantidadMinima  		= parent::escaparQueryBDCliente($cantidadMinima); 
		
           $query = "UPDATE  tb_productos_sucursal 
           				SET cantidad = '$cantidad', stockMinimo = '$cantidadMinima'
           				WHERE idProductoSucursal = '$idProductoSucursal'";
      
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;	

		
	}//fin metodo editarStockProductoSucursal
	
	
	//metodo para descontar unidades de un producto
	public function descontarUnidadesVentaProducto($idProducto, $idSucursal, $cantidadDescontar){
		
		   $resultado = "";
			
		   $idProducto  			= parent::escaparQueryBDCliente($idProducto);
		   $cantidadDescontar  		= parent::escaparQueryBDCliente($cantidadDescontar); 
		
           $query = "UPDATE  tb_productos_sucursal 
           				SET cantidad = cantidad-'$cantidadDescontar'
           				WHERE idProducto = '$idProducto' AND idSucursal = '$idSucursal'";
      
      
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){				
			
			         $resultado = "Ok"  ;
			}	

            return $resultado;			
		
		
	}//fin metodo descontarUnidadesVentaProducto
	
	
	//metodo para guardar una nueva entrada de un producto
	public function registrarNuevaEntrada($idProducto, $idSucursal, $idProveedor, $costo, $cantidad, $idUsuario){

 		   		   
		   $idProducto  	= parent::escaparQueryBDCliente($idProducto); 
		   $idSucursal  	= parent::escaparQueryBDCliente($idSucursal); 
		   $idProveedor  	= parent::escaparQueryBDCliente($idProveedor); 
		   $costo  			= parent::escaparQueryBDCliente($costo); 
		   $cantidad  		= parent::escaparQueryBDCliente($cantidad); 
            
           $query = "INSERT INTO tb_productos_sucursal_entradas (cantidad, costo, fecha, idProducto, idSucursal, idProveedor, idUsuario ) ".
                        " VALUES ('$cantidad', '$costo', NOW(), '$idProducto', '$idSucursal', '$idProveedor', '$idUsuario') ";
      
           $conexion = parent::conexionCliente();
    		
           $res = $conexion->query($query);
		
	}//fin metodo registrarNuevaEntrada
	
	
	//metodo para aumentar la cantidad de un producto luego de una entrada
	public function aumentarCantidadProducto($idProducto, $idSucursal, $cantidad){
		
		   $idProducto  	= parent::escaparQueryBDCliente($idProducto); 
		   $idSucursal  	= parent::escaparQueryBDCliente($idSucursal); 
		   $cantidad  		= parent::escaparQueryBDCliente($cantidad); 		
		
		
			$query = "UPDATE tb_productos_sucursal SET cantidad = cantidad + '$cantidad'
						WHERE idSucursal = '$idSucursal' AND idProducto = '$idProducto' ";

           $conexion = parent::conexionCliente();
    		
           $res = $conexion->query($query);

		
	}//fin metodo aumentarCantidadProducto
	
			
}//fin class



?>