<?php
	if(!isset($_SESSION)){
		    session_start();
		}

/**
 * clase par alos datos de los examenes
 */
class examenes extends Config {


/*
 * Funciones para los encabezados de los examenes como tal
 * */

        //metodo para contar la cantidad de examenes de encabezado
        public function tatalExamenesEncabezado($idPaciente){        	

			$resultado = array();
			
			$query = "Select count(idExamen) as cantidadExamenes from tb_examenes WHERE idMascota = '$idPaciente' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadExamenes'];			
			
			
        }//fin metodo tatalExamenesEncabezado 
 
 	
        //metodo para listar los examenes encabezado
        public function listarExamenesEncabezado($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			
			$resultado = array();
		
			$query = " SELECT E.idExamen, E.fecha, DATE_FORMAT(E.hora, '%H:%i') as hora, E.observaciones, E.idUsuario,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
							
						FROM tb_examenes AS E
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = E.idSucursal
						INNER JOIN tb_usuarios AS U ON U.idUsuario = E.idUsuario
						
						WHERE E.idMascota = '$idPaciente' ORDER BY E.idExamen DESC
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
			
			
        }//fin metodo listarExamenesEncabezado 
        

        
      //metodo para listar un solo examen encabezado
        public function listarUnExamenEncabezado($idExamen){
        	
			$idExamen	= parent::escaparQueryBDCliente($idExamen);
			
			
			$resultado = array();
		
			$query = " SELECT E.idExamen, E.fecha, E.hora, E.observaciones, E.idUsuario, E.idMascota,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
							
						FROM tb_examenes AS E
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = E.idSucursal
						INNER JOIN tb_usuarios AS U ON U.idUsuario = E.idUsuario
						
						WHERE E.idExamen = '$idExamen'";
					
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
			
			
        }//fin metodo listarUnExamenEncabezado         
                
        
        //metodo para guardar el encabezado de un examen
        public function guardarExamenEncabezado($idUsuario, $idPaciente, $observaciones, $idSucursal, $idPacienteReplica){
        			
           $resultado = array();	
        				
           $idPaciente  = parent::escaparQueryBDCliente($idPaciente);
		   $observaciones  = parent::escaparQueryBDCliente($observaciones);
		   $idPacienteReplica  = parent::escaparQueryBDCliente($idPacienteReplica);
            
           $query = "INSERT INTO tb_examenes (fecha, hora, observaciones, idMascota, idUsuario, idSucursal) ".
                        " VALUES (NOW(),NOW(),'$observaciones', '$idPaciente', '$idUsuario', '$idSucursal') ";
           
           $conexion = parent::conexionCliente();
    		
			if($res = $conexion->query($query)){
				
				$query2	= "SELECT MAX(idExamen) as ultimoIdExamen FROM tb_examenes";
				
				if($res2 = $conexion->query($query2)){
		           
		               /* obtener un array asociativo */
		                while ($filas = $res2->fetch_assoc()) {
		                    $resultado[] = $filas['ultimoIdExamen'];
		                }
		            
		                /* liberar el conjunto de resultados */
		                $res2->free();
		           
		        }	
						
			}
			
			/*------ Replica ----*/
			
			$nombreSucursal = $_SESSION['sucursalActual_nombreSucursal'];
			
			$nombreUsuario = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];					
			
			$queryReplica = "INSERT INTO tb_examenes (fecha, hora, observaciones, idMascota, usuario, nombreSucursal) ".
                        " VALUES (NOW(),NOW(),'$observaciones', '$idPacienteReplica', '$nombreUsuario', '$nombreSucursal') ";
           
            $conexionReplica = parent::conexionReplica();


			if($resReplica = $conexionReplica->query($queryReplica)){
				
				$query2	= "SELECT MAX(idExamen) as ultimoIdExamen FROM tb_examenes";
				
				if($resReplica2 = $conexionReplica->query($query2)){
		           
		               /* obtener un array asociativo */
		                while ($filas = $resReplica2->fetch_assoc()) {
		                    $resultado[] = $filas['ultimoIdExamen'];
		                }
		            
		                /* liberar el conjunto de resultados */
		                $resReplica2->free();
		           
		        }	
						
			}

			
			/*------ Replica ----*/
	
	        return $resultado;	
        		
        	
        }//fin metodo guardarExamenEncabezado
 

	//metodo para guardar un item de en examen 
	public function guardarItemDetalleExamen($nombre,$observacion,$id,$idExamenGuardado, $idExamenGuardadoReplica){
		
		$nombre 							= parent::escaparQueryBDCliente($nombre);
		$observacion 						= parent::escaparQueryBDCliente($observacion);
		$id 								= parent::escaparQueryBDCliente($id);
		
		
		$query = "INSERT INTO tb_examenDetalle (observacion,idExamen,idListadoExamen, idExamenReplica)
					VALUES
					('$observacion','$idExamenGuardado','$id', '$idExamenGuardadoReplica');";
		
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);

		/*----------Replica ----------*/

		$queryReplica = "INSERT INTO tb_examenDetalle (nombre,observacion,idExamen)
					VALUES
					('$nombre','$observacion','$idExamenGuardadoReplica');";
	
		$conexionReplica = parent::conexionReplica();			
		$resReplica = $conexionReplica->query($queryReplica);	
		
		/*----------Replica ----------*/

		
	}//fin metodo guardarItemDetalleExamen 
	
	
	//metodo para consultar el detalle de un examen
	public function consultarDetalleExamenEncabezado($idExamen){
		
			$resultado = array();
		
			$query = " SELECT D.idExamenDetalle, D.observacion, D.idListadoExamen,
						LE.nombre, LE.codigo, LE.descripcion,
                        R.general
						
						FROM tb_examenDetalle AS D
						
						INNER JOIN tb_listadoExamenes AS LE ON LE.idListadoExamen = D.idListadoExamen
                        
                        LEFT JOIN tb_resultadoExamen AS R ON R.idExamenDetalle = D.idExamenDetalle
						
						WHERE D.idExamen = '$idExamen' ";
						
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
		
		
	}//fin metodo consultarDetalleExamenEncabezado
	
	
	
	//metodo para consultar el resultado de un examen
	public function consultarResultadoExamen($idExamenDetalle){
		
			$resultado = array();
		
			$query = " SELECT RE.idresultadoExamen, RE.fecha, RE.hora, RE.general, RE.observaciones, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
						
						FROM tb_resultadoExamen AS RE
						
						INNER JOIN tb_usuarios AS U ON U.idUsuario = RE.idUsuario
						
						WHERE RE.idExamenDetalle = '$idExamenDetalle' ";
						
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
		
		
	}//consultarResultadoExamen
	
	
	//funcion para guardar el resultado de un examen
	public function guardarResultadoExamen($idDetalleExamen, $general, $observaciones, $idUsuario){

			$resultadoIdExamenReplica = "";
			$resultadoDetalleReplica	= "";
        				
           $idDetalleExamen  	= parent::escaparQueryBDCliente($idDetalleExamen);
		   $observaciones  		= parent::escaparQueryBDCliente($observaciones);
            
           $query = "INSERT INTO tb_resultadoExamen (fecha, hora, general, observaciones, idExamenDetalle, idUsuario) ".
                        " VALUES (NOW(), NOW(), '$general', '$observaciones', '$idDetalleExamen', '$idUsuario') ";

		   
           $conexion = parent::conexionCliente();
		   
		   $res = $conexion->query($query);

		
		/*----------Replica ----------*/
		
		$query2 = "SELECT idExamenReplica FROM tb_examenDetalle WHERE idExamenDetalle = '$idDetalleExamen'";
		
		if($res2 = $conexion->query($query2)){
	           
	               /* obtener un array asociativo */
	                while ($filas2 = $res2->fetch_assoc()) {
	                	
	                    $resultadoIdExamenReplica = $filas2['idExamenReplica'];
						
						$query3 = "SELECT idExamenDetalle FROM tb_examenDetalle WHERE idExamen = '$resultadoIdExamenReplica'";
						
						$conexionReplica = parent::conexionReplica();
						
						if($res3 = $conexionReplica->query($query3)){
	           
			               /* obtener un array asociativo */
			                while ($filas3 = $res3->fetch_assoc()) {
			                	
			                		$resultadoDetalleReplica = $filas3['idExamenDetalle'];
									
									$usuario = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];
									$sucursal = $_SESSION['sucursalActual_nombreSucursal'];
									
									//se ingresa el resultado en la replica
									$query4 =  "INSERT INTO tb_resultadoExamen 
												(fecha, hora, general, observaciones, usuario, nombreClinica, nombreSucursal, estado, idExamenDetalle)
												VALUES
												(NOW(), NOW(), '$general', '$observaciones', '$usuario', '', '$sucursal', 'Pendiente', '$resultadoDetalleReplica' )";
									
									$conexionReplica->query($query4);
							
							}//fin while replica	
							
							/* liberar el conjunto de resultados */
	                		$res3->free();
							
						}//fin if replica
						
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
	           
	        }
		
		/*----------Fin Replica ----------*/
		
		
	}//fin metodo guardarResultadoExamen
 
 
/*
 * Fin Funciones para los encabezados de los examenes como tal
 * */
	

	

/*
 * Funciones para los items de los examenes
 * */	
        //metodo para buscar un examen según un string ingresado en un campo input text
        public function buscarExamenConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idListadoExamen, nombre FROM tb_listadoExamenes ".
					    " where  (nombre like '%$sting%') or (codigo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idListadoExamen, nombre FROM tb_listadoExamenes ".
					    " where  ((nombre like '%$sting%') OR (codigo like '%$sting%')) AND estado = 'A' ";
			}

            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idListadoExamen'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarExamenConString

	
        //metodo para saber si un examen existe
        public function comprobarExistenciaExamen($nombreExamen){
            
            $nombreExamen  = parent::escaparQueryBDCliente($nombreExamen); 
            
            
            $resultado = array();
            
            $query  = "SELECT idListadoExamen, nombre from tb_listadoExamenes ".
					    " where   nombre = '$nombreExamen' ";

            $conexion = parent::conexionCliente();
            
            if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado =   $filas;
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	
            
        }//fin metodo comprobarExistenciaExamen




        //metodo para guardar una nuevo examen 
        public function guardarExamen($nombreExamen, $codigoExamen, $precioExamen, $descripcionExamen ){
            
           $nombreExamen  = parent::escaparQueryBDCliente($nombreExamen);
		   $codigoExamen  = parent::escaparQueryBDCliente($codigoExamen);
		   $precioExamen  = parent::escaparQueryBDCliente($precioExamen);
		   $descripcionExamen  = parent::escaparQueryBDCliente($descripcionExamen);
            
           $query = "INSERT INTO tb_listadoExamenes (nombre, codigo, precio, descripcion, estado) ".
                        " VALUES ('$nombreExamen', '$codigoExamen', '$precioExamen', '$descripcionExamen', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;
            
            
        }//fin metodo guardarExamen


        //metodo para editar un examen
        public function editarExamen($idExamen, $nombreExamen, $codigoExamen, $precioExamen, $descripcionExamen ){
 
 			$resultado = "";
 
 		   $nombreExamen  = parent::escaparQueryBDCliente($nombreExamen); 
		   $codigoExamen  = parent::escaparQueryBDCliente($codigoExamen); 
		   $precioExamen  = parent::escaparQueryBDCliente($precioExamen); 
		   $descripcionExamen  = parent::escaparQueryBDCliente($descripcionExamen); 
 
           $query = "UPDATE tb_listadoExamenes SET nombre = '$nombreExamen', codigo = '$codigoExamen', precio = '$precioExamen', descripcion = '$descripcionExamen' 
           WHERE idListadoExamen = '$idExamen' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;      	
			
        }//fin metodo editarExamen 


        //metodo para contar la cantidad de examenes
        public function tatalExamenes(){        	

			$resultado = array();
			
			$query = "Select count(idListadoExamen) as cantidadExamenes from tb_listadoExamenes ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadExamenes'];			
			
			
        }//fin metodo tatalExamenes 



        //metodo para listar los examenes
        public function listarExamenes($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT idListadoExamen, nombre, codigo, precio, descripcion, estado
						FROM tb_listadoExamenes
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
			
			
        }//fin metodo listarExamenes



        //metodo para activar un examen
        public function activarExamen($idExamen){

            
           $query = "UPDATE tb_listadoExamenes SET estado = 'A' WHERE idListadoExamen = '$idExamen' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo activarExamen        
                 

                 
        //metodo para desactivar un examen
        public function desactivarExamen($idExamen){

            
           $query = "UPDATE tb_listadoExamenes SET estado = 'I' WHERE idListadoExamen = '$idExamen' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;        	
			
			
        }//fin metodo desactivarExamen

        
        //metodo para listar un examen
        public function listarUnExamen($idExamen){
        	
			$resultado = array();
		
			$query = " SELECT idListadoExamen, nombre, codigo, precio, descripcion, estado
						FROM tb_listadoExamenes
						WHERE idListadoExamen = '$idExamen'";
						
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
			
			
        }//fin metodo listarUnExamen    


/*
 * Fin Funciones para los items de los examenes
 * */	

 		
	//metodo para relacionar un examen con una hospitalizacion
	public function relacionarExamenHospitalizacion($idExamen, $idHospitalizacion){
						
					
		$query = "INSERT INTO tb_examen_hospitalizacion (idHospitalizacion,idExamen)
					VALUES
					('$idHospitalizacion','$idExamen');";
	
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);					
			
		
	}//fin metodo relacionarExamenHospitalizacion	
		
 
//consultar las examenes que no se encuentren relacionadas con hospitalizacion
	public function examenesNoHospitalizacion($idPaciente){
		
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "SELECT 
					    idExamen, fecha, hora
					FROM
					    tb_examenes
					WHERE
					    idExamen NOT IN (SELECT 
					            idExamen
					        FROM
					            tb_examen_hospitalizacion)
					        AND idMascota = '$idPaciente'";
						
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
		
	}
	 
 
 
}//fin clase


?>