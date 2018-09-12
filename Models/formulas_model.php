<?php
	if(!isset($_SESSION)){
		    session_start();
		}

/**
 * modelo para los datos de las formulas
 */
class formulas extends Config {
	

        //metodo para contar la cantidad de formulas
        public function tatalFormulas($idPaciente){        	

			$resultado = array();
			
			$query = "Select count(idFormula) as cantidadFormulas from tb_formulas WHERE idMascota = '$idPaciente' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadFormulas'];			
			
			
        }//fin metodo tatalFormulas 


        //metodo para listar las formulas
        public function listarFormulas($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			
			$resultado = array();
		
			$query = " SELECT F.idFormula, F.fecha,  DATE_FORMAT(F.hora, '%H:%i') as hora, F.observaciones, F.idUsuario,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
							
						FROM tb_formulas AS F
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = F.idSucursal
						INNER JOIN tb_usuarios AS U ON U.idUsuario = F.idUsuario
						
						WHERE F.idMascota = '$idPaciente' ORDER BY F.idFormula DESC
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
			
			
        }//fin metodo listarFormulas 
        

        
       //metodo para listar una formula
        public function listarUnaFormula($idFormula){
        	
			$idFormula	= parent::escaparQueryBDCliente($idFormula);
			
			
			$resultado = array();
		
			$query = " SELECT F.idFormula, F.fecha, F.hora, F.observaciones, F.idUsuario, F.idMascota,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
							
						FROM tb_formulas AS F
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = F.idSucursal
						INNER JOIN tb_usuarios AS U ON U.idUsuario = F.idUsuario
						
						WHERE F.idFormula = '$idFormula'";
						 
					
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
			
			
        }//fin metodo listarUnaFormula         
        
        
        //metodo para guardar una nueva formula
        public function guardarFormula($idUsuario, $idPaciente, $observaciones, $idSucursal, $idPacienteReplica){
        				
        	 $resultado = array();	
        				
           $idPaciente  	= parent::escaparQueryBDCliente($idPaciente);
		   $observaciones  	= parent::escaparQueryBDCliente($observaciones);
		   $idPacienteReplica  	= parent::escaparQueryBDCliente($idPacienteReplica);
            
           $query = "INSERT INTO tb_formulas (fecha, hora, observaciones, idMascota, idUsuario, idSucursal) ".
                        " VALUES (NOW(),NOW(),'$observaciones', '$idPaciente', '$idUsuario', '$idSucursal') ";
           
           $conexion = parent::conexionCliente();
    		
			if($res = $conexion->query($query)){
				
				$query2	= "SELECT MAX(idFormula) as ultimoIdFormula FROM tb_formulas";
				
				if($res2 = $conexion->query($query2)){
		           
		               /* obtener un array asociativo */
		                while ($filas = $res2->fetch_assoc()) {
		                    $resultado[] = $filas['ultimoIdFormula'];
		                }
		            
		                /* liberar el conjunto de resultados */
		                $res2->free();
		           
		        }	
						
			}
			
			
			/*-------- Replica ----------*/
			
			$nombreSucursal = $_SESSION['sucursalActual_nombreSucursal'];
		
			$nombreUsuario = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];		
			
           $queryReplica = "INSERT INTO tb_formulas (fecha, hora, observaciones, idMascota, usuario, nombreSucursal) ".
                        " VALUES (NOW(),NOW(),'$observaciones', '$idPacienteReplica', '$nombreUsuario', '$nombreSucursal') ";
           
           $conexionReplica = parent::conexionReplica();
    		
			if($resReplica = $conexionReplica->query($queryReplica)){
				
				$queryReplica2	= "SELECT MAX(idFormula) as ultimoIdFormula FROM tb_formulas";
				
				if($resReplica2 = $conexionReplica->query($queryReplica2)){
		           
		               /* obtener un array asociativo */
		                while ($filas = $resReplica2->fetch_assoc()) {
		                    $resultado[] = $filas['ultimoIdFormula'];
		                }
		            
		                /* liberar el conjunto de resultados */
		                $resReplica2->free();
		           
		        }	
						
			}			
			/*-------- Replica ----------*/
			
	
	        return $resultado;			
        		
        	
        }//fin metodo guardarFormula
        
        
        //metodo para guardar un medicamento de una formula
        public function guardarMedicamentoFormula($id, $nombre,$cantidad,$frecuencia,$dosificacion,$observacion,$viaAdministracion,$idFormulaGuardada,$idFormulaGuardadaReplica){
				
        	$id 								= parent::escaparQueryBDCliente($id);			
			$nombre 							= parent::escaparQueryBDCliente($nombre);
			$cantidad 							= parent::escaparQueryBDCliente($cantidad);
			$frecuencia 						= parent::escaparQueryBDCliente($frecuencia);
			$dosificacion 						= parent::escaparQueryBDCliente($dosificacion);
			$observacion 						= parent::escaparQueryBDCliente($observacion);
			$viaAdministracion 					= parent::escaparQueryBDCliente($viaAdministracion);
			$idFormulaGuardada 					= parent::escaparQueryBDCliente($idFormulaGuardada);
			
			
			
			$query = "INSERT INTO tb_medicamentosFormula (via,cantidad,frecuencia,dosificacion,observacion,idFormula,idMedicamento)
						VALUES
						('$viaAdministracion','$cantidad','$frecuencia','$dosificacion','$observacion','$idFormulaGuardada','$id');";
			
			$conexion = parent::conexionCliente();			
			$res = $conexion->query($query);       			
        	
			/*---------- Replica ----------*/
			$queryReplica = "INSERT INTO tb_medicamentosFormula (nombreMedicamento, via,cantidad,frecuencia,dosificacion,observacion,idFormula)
						VALUES
						('$nombre','$viaAdministracion','$cantidad','$frecuencia','$dosificacion','$observacion','$idFormulaGuardadaReplica');";
			
			$conexionReplica = parent::conexionReplica();			
			$resReplica = $conexionReplica->query($queryReplica);     
			
			/*---------- Replica ----------*/
			
				
        	
        }//fin metodo guardarMedicamentoFormula
        
        
        //metodo para consultar el detalle de una formula
        public function consultarDetalleFormula($idFormula){
        	
				$idFormula	= parent::escaparQueryBDCliente($idFormula);				
				
				$resultado = array();
			
				$query = " SELECT MF.idMedicamentoFormula, MF.via, MF.cantidad, MF.frecuencia, MF.dosificacion, MF.observacion, MF.idFormula, MF.idMedicamento,
									M.nombre, M.codigo, M.observacion as observacionM
							FROM tb_medicamentosFormula AS MF
							
							INNER JOIN tb_formulas AS F ON F.idFormula = MF.idFormula
							INNER JOIN tb_listadoMedicamentos AS M ON M.idMedicamento = MF.idMedicamento
							
							WHERE MF.idFormula = '$idFormula' ";
						
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
			
			
        }//fin metodo consultarDetalleFormula
        

 		
	//metodo para relacionar una formula con una hospitalizacion
	public function relacionarFormulaHospitalizacion($idFormula, $idHospitalizacion){
						
					
		$query = "INSERT INTO tb_formula_hospitalizacion (idHospitalizacion,idFormula)
					VALUES
					('$idHospitalizacion','$idFormula');";
	
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);					
			
		
	}//fin metodo relacionarFormulaHospitalizacion	
		        
 
	//consultar las formulas que no se encuentren relacionadas con hospitalizacion
	public function formulasNoHospitalizacion($idPaciente){
		
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "SELECT 
					    idFormula, fecha, hora
					FROM
					    tb_formulas
					WHERE
					    idFormula NOT IN (SELECT 
					            idFormula
					        FROM
					            tb_formula_hospitalizacion)
					        AND idMascota = '$idPaciente' ";
						
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
		
	}//fin metodo formulasNoHospitalizacion 
 
        
        
}//fin clase




?>