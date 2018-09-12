<?php
	if(!isset($_SESSION)){
		    session_start();
		}

/**
 * clase par alos datos de las vacunas
 */
class vacunas extends Config {
	

        //metodo para contar la cantidad de vacunas de una mascota
        public function tatalVacunasPaciente($idPaciente){        	

			$resultado = array();
			
			$query = "Select count(idMascotaVacunas) as cantidadVacunas from tb_mascotas_vacunas; WHERE idMascota = '$idPaciente' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadVacunas'];			
			
			
        }//fin metodo tatalVacunasPaciente


        //metodo para listar las vacunas aplicadas a un paciente
        public function listarVacunasPaciente($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			
			$resultado = array();
		
			$query = " SELECT PV.idMascotaVacunas, PV.fecha, PV.fechaProximaVacuna, PV.observaciones, PV.estado, PV.idVacuna, PV.idSucursal,
							 V.nombre, V.descripcion,
							 S.nombre as nombreSucursal, S.identificativoNit							
							
						FROM tb_mascotas_vacunas AS PV						
						
						INNER JOIN tb_vacunas AS V ON V.idVacuna = PV.idVacuna
						INNER JOIN tb_sucursales AS S ON S.idSucursal = PV.idSucursal
						
						WHERE PV.idMascota = '$idPaciente' ORDER BY PV.idMascotaVacunas DESC
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
			
			
        }//fin metodo listarVacunasPaciente 




        //metodo para listar una aplicadas a un paciente
        public function listarUnaVacunaPaciente($idVacuna){
        	
			$idVacuna	= parent::escaparQueryBDCliente($idVacuna);
			
			
			$resultado = array();
		
			$query = " SELECT PV.idMascotaVacunas, PV.fecha, PV.fechaProximaVacuna, PV.observaciones, PV.estado, PV.idVacuna, PV.idSucursal, PV.idMascota,
							 V.nombre, V.descripcion,
							 S.nombre as nombreSucursal, S.identificativoNit							
							
						FROM tb_mascotas_vacunas AS PV						
						
						INNER JOIN tb_vacunas AS V ON V.idVacuna = PV.idVacuna
						INNER JOIN tb_sucursales AS S ON S.idSucursal = PV.idSucursal
						
						WHERE PV.idMascotaVacunas = '$idVacuna' ";;
			
	
					
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
			
			
        }//fin metodo listarUnaVacunaPaciente 



        //metodo para guardar la aplicación de una vacuna
        public function guardarAplicacionVacuna($idPaciente, $idVacuna, $fechaProximaVacuna, $observaciones, $idSucursal, $idPacienteReplica  ){
        			
        	$resultado = "";	
        				
        	$idPaciente					= parent::escaparQueryBDCliente($idPaciente);
        	$idVacuna					= parent::escaparQueryBDCliente($idVacuna);
			$fechaProximaVacuna			= parent::escaparQueryBDCliente($fechaProximaVacuna);
			$observaciones				= parent::escaparQueryBDCliente($observaciones);	
			$idPacienteReplica				= parent::escaparQueryBDCliente($idPacienteReplica);	
			
           $query = "INSERT INTO tb_mascotas_vacunas (fecha, hora, fechaProximaVacuna, observaciones, idMascota, idVacuna, estado, idSucursal) ".
            " VALUES ( NOW(), NOW(), '$fechaProximaVacuna', '$observaciones', '$idPaciente', '$idVacuna', 'A', '$idSucursal') ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
	
			/*------ Replica ---*/
			$nombreVacuna = '';
			$descripcionVacuna = '';
			$queryConsulta = "SELECT nombre, descripcion FROM tb_vacunas WHERE idVacuna = '$idVacuna'";
			if($res2 = $conexion->query($queryConsulta)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $nombreVacuna = $filas['nombre'];
						$descripcionVacuna = $filas['descripcion'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
	           
	        }
			
			
			$nombreSucursal = $_SESSION['sucursalActual_nombreSucursal'];
		
			$nombreUsuario = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];	
			
           $queryReplica = "INSERT INTO tb_mascotas_vacunas (fecha, hora, fechaProximaVacuna, observaciones, idMascota,  estado, usuario, nombreSucursal, nombreVacuna, descripcionVacuna) ".
            " VALUES ( NOW(), NOW(), '$fechaProximaVacuna', '$observaciones', '$idPacienteReplica',  'A', '$nombreUsuario' ,'$nombreSucursal', '$nombreVacuna', '$descripcionVacuna') ";
           

		   
           $conexionReplica = parent::conexionReplica();
    		
            if($resReplica = $conexionReplica->query($queryReplica)){
                
                    $resultado = "Ok";
            }			
			
			/*------ Replica ---*/
	
	
            return $resultado;	
        		
        	
        }//fin metodo guardarAplicacionVacuna







        //metodo para buscar una vacuna según un string ingresado en un campo input text
        public function buscarVacunaConString($sting, $utilizar = 'No', $idSucursal = ''){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idVacuna, nombre, descripcion FROM tb_vacunas ".
					    " where  (nombre like '%$sting%') ";
			}else{
				
				$query  = "SELECT 
							    V.idVacuna,
							    V.nombre,
							    V.descripcion,
							    (SELECT 
							            idProducto
							        FROM
							            tb_productos
							        WHERE
							            tipoExterno = 'Vacuna'
							                AND idExterno = V.idVacuna) AS resultadoIdProducto,
							    (SELECT 
							            cantidad
							        FROM
							            tb_productos_sucursal
							        WHERE
							            idProducto = resultadoIdProducto
							                AND idSucursal = '$idSucursal') AS cantidadDisponible
							FROM
							    tb_vacunas AS V
							WHERE
							    (nombre LIKE '%$sting%')
							        AND estado = 'A' ";
			}

            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                			
	                	if($utilizar == 'No'){
	                				
							 $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idVacuna'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );		
	                			
						}else{
									
							 $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idVacuna'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'],
	                    						'resultadoIdProducto' => $filas['resultadoIdProducto'],
	                    						'cantidadDisponible' => $filas['cantidadDisponible'] );	  	
							
						}//fin else		
	                	
	                   
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarVacunaConString

	
        //metodo para saber si una vacuna existe
        public function comprobarExistenciaVacuna($nombreVacuna){
            
            $nombreVacuna  = parent::escaparQueryBDCliente($nombreVacuna); 
            
            
            $resultado = array();
            
            $query  = "SELECT idVacuna, nombre from tb_vacunas ".
					    " where   nombre = '$nombreVacuna' ";
            
            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaVacuna




        //metodo para guardar una nueva vacuna 
        public function guardarVacuna($nombreVacuna, $descripcion){
            
           $nombreVacuna  = parent::escaparQueryBDCliente($nombreVacuna); 
		   $descripcion   = parent::escaparQueryBDCliente($descripcion); 
            
           $query = "INSERT INTO tb_vacunas (nombre, descripcion, estado) ".
                        " VALUES ('$nombreVacuna', '$descripcion', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarVacuna


        //metodo para editar una vacuna
        public function editarVacuna($idVacuna, $nombreVacuna, $descripcion){
 
 			$resultado = "";
 
 		   $nombreVacuna  = parent::escaparQueryBDCliente($nombreVacuna); 
		   $descripcion   = parent::escaparQueryBDCliente($descripcion);
 
           $query = "UPDATE tb_vacunas SET nombre = '$nombreVacuna', descripcion = '$descripcion' WHERE idVacuna = '$idVacuna' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarVacuna 


        //metodo para contar la cantidad de vacunas
        public function tatalVacunas(){        	

			$resultado = array();
			
			$query = "Select count(idVacuna) as cantidadVacunas from tb_vacunas ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadVacunas'];			
			
			
        }//fin metodo tatalVacunas 



        //metodo para listar los vacunas
        public function listarVacunas($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idVacuna, nombre, descripcion, estado
						FROM tb_vacunas
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
			
			
        }//fin metodo listarVacunas



        //metodo para activar una vacuna
        public function activarVacuna($idVacuna){

            
           $query = "UPDATE tb_vacunas SET estado = 'A' WHERE idVacuna = '$idVacuna' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarVacuna        
                 

                 
        //metodo para desactivar una vacuna
        public function desactivarVacuna($idVacuna){

            
           $query = "UPDATE tb_vacunas SET estado = 'I' WHERE idVacuna = '$idVacuna' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarVacuna

        
        //metodo para listar una vacuna
        public function listarUnaVacuna($idVacuna){
        	
			$resultado = array();
		
			$query = " SELECT idVacuna, nombre, descripcion, estado
						FROM tb_vacunas
						WHERE idVacuna = '$idVacuna'";
						
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
			
			
        }//fin metodo listarUnaVacuna    


	//metodo para consultar las vacunas que no se encuentre vinculadas con productos
	public function vacunasNoVinculadasProductos(){
		
			$resultado = array();
		
			$query = " SELECT 
						    V.idVacuna, V.nombre, V.descripcion
						FROM
						    tb_vacunas AS V
						WHERE
						    V.estado = 'A' AND V.idVacuna NOT IN (SELECT 
						            idExterno
						        FROM
						            tb_productos
						        WHERE
						            tipoExterno = 'Vacuna'
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
		
	}//fin metodo vacunasNoVinculadasProductos

	
	
		//consultar los desparasitantes para impresion por fechas
		public function vacunasImpresionFechas($idPaciente){
			
			$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
			
			$resultado = array();
			
			$query = "SELECT 
						    fecha, hora, idMascotaVacunas
						FROM
						    tb_mascotas_vacunas
						WHERE
						    idMascota = '$idPaciente' ";
							
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
			
		}//fin metodo 	vacunasImpresionFechas
	
	
	
}//fin clase


?>