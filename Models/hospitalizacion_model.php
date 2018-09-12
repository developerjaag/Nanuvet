<?php

/**
 * Clase para manipular los datos de la hospitalizacion
 */
class hospitalizacion extends Config {
	
	
	//metodo para consultar el total de la shospitalizaciones
	public function tatalHospitalizaciones($idPaciente){
		
		$resultado = array();
			
			$query = "Select count(idHospitalizacion) as cantidadHospitalizaicones from tb_hospitalizacion WHERE idMascota = '$idPaciente' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadHospitalizaicones'];	
		
		
	}//fin metodo tatalHospitalizaciones
	
	
	//metodo para listar las hospitalizaciones de un paciente
        public function listarHospitalizaciones($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			
			$resultado = array();
		
			$query = "SELECT H.idHospitalizacion, H.fechaIngreso,  DATE_FORMAT(H.horaIngreso, '%H:%i') as horaIngreso , H.motivoHospitalizacion, H.observacion,
							 S.nombre as nombreSucursal, S.identificativoNit,	
							 U.identificacion, U.nombre as nombreUsuario, U.apellido,
							 EH.idEspacioHospitalizacion,  EH.nombre as nombreEspacio,
                             
                             HA.idHospitalizacionAlta, HA.fecha as fechaAlta, DATE_FORMAT(HA.hora, '%H:%i') as horaAlta, HA.observaciones as observacionesAlta, HA.cuidadosATener, HA.vivo, HA.idUsuario as idUsuarioAlta,
                             UA.identificacion as identificacionAlta, UA.nombre as nombreUsuarioAlta, UA.apellido as apellidoAlta,
                             EHH.idEspacioHospitalizacionHospitalizacion as idRelacionEspacioHospitalizacion
							
						FROM tb_hospitalizacion AS H						
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = H.idSucursal
						
						INNER JOIN tb_usuarios AS U ON U.idUsuario = H.idUsuario                        
                        
						
						INNER JOIN tb_espacioHospitalizacion_Hospitalizacion AS EHH ON EHH.idHospitalizacion = H.idHospitalizacion
						
						INNER JOIN tb_espacioHospitalizacion AS EH ON EH.idEspacioHospitalizacion = EHH.idEspacioHospitalizacion
                        
                        LEFT JOIN tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
                        
                        LEFT JOIN tb_usuarios AS UA ON UA.idUsuario = HA.idUsuario
						
						WHERE H.idMascota = '$idPaciente' ORDER BY H.idHospitalizacion DESC
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
			
			
        }//fin metodo listarDesparasitantesPaciente 
        	

        	
        	
	//metodo para listar una hospitalizacion de un paciente
        public function listarUnaHospitalizacion($idHospitalizacion){
        	
			$idHospitalizacion	= parent::escaparQueryBDCliente($idHospitalizacion);
			
			
			$resultado = array();
		
			$query = "SELECT H.idHospitalizacion, H.fechaIngreso,  DATE_FORMAT(H.horaIngreso, '%H:%i') as horaIngreso , H.motivoHospitalizacion, H.observacion, H.idMascota, 
							 S.nombre as nombreSucursal, S.identificativoNit,	
							 U.identificacion, U.nombre as nombreUsuario, U.apellido,
							 EH.idEspacioHospitalizacion,  EH.nombre as nombreEspacio,
                             
                             HA.idHospitalizacionAlta, HA.fecha as fechaAlta, DATE_FORMAT(HA.hora, '%H:%i') as horaAlta, HA.observaciones as observacionesAlta, HA.cuidadosATener, HA.vivo, HA.idUsuario as idUsuarioAlta,
                             UA.identificacion as identificacionAlta, UA.nombre as nombreUsuarioAlta, UA.apellido as apellidoAlta,
                             EHH.idEspacioHospitalizacionHospitalizacion as idRelacionEspacioHospitalizacion
							
						FROM tb_hospitalizacion AS H						
						
						INNER JOIN tb_sucursales AS S ON S.idSucursal = H.idSucursal
						
						INNER JOIN tb_usuarios AS U ON U.idUsuario = H.idUsuario                        
                        
						
						INNER JOIN tb_espacioHospitalizacion_Hospitalizacion AS EHH ON EHH.idHospitalizacion = H.idHospitalizacion
						
						INNER JOIN tb_espacioHospitalizacion AS EH ON EH.idEspacioHospitalizacion = EHH.idEspacioHospitalizacion
                        
                        LEFT JOIN tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
                        
                        LEFT JOIN tb_usuarios AS UA ON UA.idUsuario = HA.idUsuario
						
						WHERE H.idHospitalizacion = '$idHospitalizacion' ";
					
	
					
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
			
			
        }//fin metodo listarDesparasitantesPaciente         	
        	
        	
        	        	
        //metodo para guardar una hospitalizacion
        public function guardarHospitalizacion($idPaciente, $motivoHospitalizacion, $fechaIngreso, $horaIngreso, $observaciones, $idUsuario, $idSucursal){
        			
        	$resultado = "";	
        				
        	$idPaciente					= parent::escaparQueryBDCliente($idPaciente);
        	$motivoHospitalizacion		= parent::escaparQueryBDCliente($motivoHospitalizacion);
        	$fechaIngreso				= parent::escaparQueryBDCliente($fechaIngreso);
			$horaIngreso				= parent::escaparQueryBDCliente($horaIngreso);
			$observaciones				= parent::escaparQueryBDCliente($observaciones);	
			$idUsuario					= parent::escaparQueryBDCliente($idUsuario);	
			$idSucursal					= parent::escaparQueryBDCliente($idSucursal);	
			
           $query = "INSERT INTO tb_hospitalizacion (fechaIngreso, horaIngreso, motivoHospitalizacion, observacion, idMascota, idUsuario, idSucursal) ".
            " VALUES ('$fechaIngreso', '$horaIngreso', '$motivoHospitalizacion', '$observaciones', '$idPaciente', '$idUsuario', '$idSucursal') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
					$query2	= "SELECT MAX(idHospitalizacion) as ultimoIdHospitalizacion FROM tb_hospitalizacion";
					
					if($res2 = $conexion->query($query2)){
			           
			               /* obtener un array asociativo */
			                while ($filas = $res2->fetch_assoc()) {
			                    $resultado = $filas['ultimoIdHospitalizacion'];
			                }
			            
			                /* liberar el conjunto de resultados */
			                $res2->free();
			           
			        }	
            }
    
            return $resultado;	        		
        	
        }//fin metodo 	guardarHospitalizacion
        
        
        //Determinar si a una hospitalizacion se le dio de alta
        public function comprobarAltaHospitalizacion($idPaciente){
        	
			$resultado = array();
			
			$idPaciente					= parent::escaparQueryBDCliente($idPaciente);
			
			$query = "SELECT 
						    H.idHospitalizacion
						FROM
						    tb_hospitalizacion AS H
						WHERE
						    H.idMascota = '$idPaciente'
						        AND H.idHospitalizacion NOT IN (SELECT 
						            idHospitalizacion
						        FROM
						            tb_hospitalizacionAlta);";	
			
			
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
			
			
        }//fin metodo comprobarAltaHospitalizacion
        
        
        //metodo para guardar el espacio donde se hospitalizo un paciente
        public function guardarEspacioHospitalizacionPaciente($idEspacioHospitalizacion, $idHospitalizacion){
        	
        	$resultado = "";	
        				
        	$idEspacioHospitalizacion					= parent::escaparQueryBDCliente($idEspacioHospitalizacion);
        	$idHospitalizacion							= parent::escaparQueryBDCliente($idHospitalizacion);
			
           $query = "INSERT INTO tb_espacioHospitalizacion_Hospitalizacion (idEspacioHospitalizacion, idHospitalizacion, estado) ".
            " VALUES ('$idEspacioHospitalizacion', '$idHospitalizacion', 'A') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;	 			
			
			
        }//fin metodo guardarEspacioHospitalizacionPaciente
        
        
        //metodo para ocupar un espacio de los espacios de hospitalizacion
        public function ocuparEspacioHospitalizacion($idEspacioHospitalizacion){
        	
			$idEspacioHospitalizacion					= parent::escaparQueryBDCliente($idEspacioHospitalizacion);
			
			$query = "UPDATE tb_espacioHospitalizacion SET espaciosOcupados = espaciosOcupados+1 WHERE idEspacioHospitalizacion = '$idEspacioHospitalizacion'";
			
			$conexion = parent::conexionCliente();
			$res = $conexion->query($query);
			
			
        } //fin metodo ocuparEspacioHospitalizacion
        
        //metodo para guardar el alta d euna hospitalizacion
        public function guardarAlta($fecha, $hora, $observaciones, $cuidados, $estado, $idHospitalizacion, $idUsuario){
				
        	$fecha					= parent::escaparQueryBDCliente($fecha);
			$hora					= parent::escaparQueryBDCliente($hora);
			$observaciones			= parent::escaparQueryBDCliente($observaciones);
			$cuidados				= parent::escaparQueryBDCliente($cuidados);
			$estado					= parent::escaparQueryBDCliente($estado);
			$idHospitalizacion		= parent::escaparQueryBDCliente($idHospitalizacion);
			$idUsuario				= parent::escaparQueryBDCliente($idUsuario);
			
			$query = "INSERT INTO tb_hospitalizacionAlta 
						(fecha, hora, observaciones, cuidadosATener, vivo, idHospitalizacion, idUsuario)
						VALUES ('$fecha', '$hora', '$observaciones', '$cuidados', '$estado', '$idHospitalizacion', '$idUsuario') ";
			
			$conexion = parent::conexionCliente();
			$res = $conexion->query($query);
			
			
        }//fin metodo guardarAlta
        
        
        //metodo para inactivar el vinculo de una hospitalizacion con un espacio
        public function desvincularEspacioHospitalizacionPaciente($idRelacionEspacioHospitalizacion){
        	
			$idRelacionEspacioHospitalizacion					= parent::escaparQueryBDCliente($idRelacionEspacioHospitalizacion);
			
			$query = "UPDATE tb_espacioHospitalizacion_Hospitalizacion SET estado = 'I' WHERE idEspacioHospitalizacionHospitalizacion = '$idRelacionEspacioHospitalizacion'";
			
			$conexion = parent::conexionCliente();
			$res = $conexion->query($query);			
			
        }//fin metodo desvincularEspacioHospitalizacionPaciente
        
        
        //metodo para liberar un lugar en un espacio para hospitalizar
        public function liberarEspacioHospitalizacion($idEspacioHospitalizacion){
        	
			$idEspacioHospitalizacion					= parent::escaparQueryBDCliente($idEspacioHospitalizacion);
			
			$query = "UPDATE tb_espacioHospitalizacion SET espaciosOcupados = espaciosOcupados-1 WHERE idEspacioHospitalizacion = '$idEspacioHospitalizacion'";
			

			
			$conexion = parent::conexionCliente();
			$res = $conexion->query($query);			
			
        }//liberarEspacioHospitalizacion
        

        //metodo para consultar las cirugias de una hospitalizacion
        public function cirugiasHospitalizacion($idHospitalizacion){
        				
			$resultado = array();
			
			$idHospitalizacion					= parent::escaparQueryBDCliente($idHospitalizacion);
			
			$query = "SELECT 
						    HC.idCirugiaHospitalizacion, HC.idCirugia 
						FROM
						    tb_cirugia_hospitalizacion AS HC
						WHERE
						    HC.idHospitalizacion = '$idHospitalizacion';";	
			
			
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
        		
        	
        }// fin metodo cirugiasHospitalizacion
        
 

        //metodo para consultar las consultas de una hospitalizacion
        public function consultasHospitalizacion($idHospitalizacion){
        				
			$resultado = array();
			
			$idHospitalizacion					= parent::escaparQueryBDCliente($idHospitalizacion);
			
			$query = "SELECT 
						    HC.idConsultaHospitalizacion, HC.idConsulta 
						FROM
						    tb_ConsultaHospitalzacion AS HC
						WHERE
						    HC.idHospitalizacion = '$idHospitalizacion';";	
			
			
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
        		
        	
        }// fin metodo consultasHospitalizacion 
 
        

        //metodo para consultar los examenes de una hospitalizacion
        public function examenesHospitalizacion($idHospitalizacion){
        				
			$resultado = array();
			
			$idHospitalizacion					= parent::escaparQueryBDCliente($idHospitalizacion);
			
			$query = "SELECT 
						    HE.idExamenHospitalizacion, HE.idExamen 
						FROM
						    tb_examen_hospitalizacion AS HE
						WHERE
						    HE.idHospitalizacion = '$idHospitalizacion';";	
			
			
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
        		
        	
        }// fin metodo examenesHospitalizacion         
        
        
        //metodo para consultar las formulas de una hospitalizacion
        public function formulasHospitalizacion($idHospitalizacion){
        				
			$resultado = array();
			
			$idHospitalizacion					= parent::escaparQueryBDCliente($idHospitalizacion);
			
			$query = "SELECT 
						    HF.idFormulaHospitalizacion, HF.idFormula 
						FROM
						    tb_formula_hospitalizacion AS HF
						WHERE
						    HF.idHospitalizacion = '$idHospitalizacion';";	
			
			
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
        		
        	
        }// fin metodo formulasHospitalizacion      
        
        
		//consultar las hospitalizaciones para la impresion por fechas
		public function hospitalizacionesImpresionFechas($idPaciente){
			
			$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
			
			$resultado = array();
			
			$query = "SELECT 
						    idHospitalizacion, fechaIngreso, horaIngreso
						FROM
						    tb_hospitalizacion
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
			
		}//fin metodo hospitalizacionesImpresionFechas 
 
  
        
}//fin class


?>