<?php

/**
 * Clase para controlar los datos de la  BD replica
 */
class replica extends Config {

	//metodo para buscar un propietario segun un string dado
	public function buscarPropietarioString($string){
		
		$string  = parent::escaparQueryBDReplica($string);
		
		$resultado = array();
            
        $query  = "SELECT idPropietario, identificacion, nombre, apellido
        			FROM tb_propietarios
        		   WHERE  identificacion like '%$string%' OR 
        		   	nombre LIKE '%$string%' OR 
        		   	apellido LIKE '%$string%' OR 
        		    CONCAT(nombre,apellido) LIKE '$string' OR 
        		    CONCAT(apellido,nombre) LIKE '$string' ";
        
        $conexion = parent::conexionReplica();
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   array('label' => $filas['identificacion']." ".$filas['nombre']." ".$filas['apellido'],
                    						'id' => $filas['idPropietario'],
                    						'value' => $filas['identificacion']." ".$filas['nombre']." ".$filas['apellido'] );
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado;
		
		
	}//fin metodo buscarPropietarioString
	
	        //metodo para buscar un pais según un string ingresado en un campo input text
        public function buscarPaisConString($sting){
            
            $sting  = parent::escaparQueryBDReplica($sting); 
            
            $resultado = array();
            
            $query  = "SELECT idPais, nombre from tb_paises ".
					    " where  (nombre like '%$sting%') and estado = 'A' ";
            
            $conexion = parent::conexionReplica();
		
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
	
	
	//metodo para guardar un nuevo propietario
	public function guardarPropietarioReplica($identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais){
				
		$identificacion = parent::escaparQueryBDReplica($identificacion);
		$nombre  		= parent::escaparQueryBDReplica($nombre);
		$apellido  		= parent::escaparQueryBDReplica($apellido);
		$telefono  		= parent::escaparQueryBDReplica($telefono);
		$celular  		= parent::escaparQueryBDReplica($celular);
		$direccion  	= parent::escaparQueryBDReplica($direccion);
		$email  		= parent::escaparQueryBDReplica($email);
		$idPais  		= parent::escaparQueryBDReplica($idPais);	
		
		$resultado = "";
		
		$query = "INSERT  INTO tb_propietarios (identificacion, nombre, apellido, telefono, celular, direccion, email, idPais, estado, fechaRegistro) 
					VALUES ('$identificacion', '$nombre', '$apellido', '$telefono', '$celular', '$direccion', '$email', '$idPais', 'A', NOW() )";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
		
			$query2 = "SELECT MAX(idPropietario) AS ultimoId FROM tb_propietarios";
			
			if ($res2 = $conexion->query($query2)) {
				
				 while ($filas = $res2->fetch_assoc()) {
                   
				   $resultado = $filas['ultimoId'];
                }
				
				/* liberar el conjunto de resultados */
                $res2->free();
				
			}
			
		}
		
		
		return $resultado;
		
	}//fin metodo guardarPropietarioReplica
	
	
	//metodo para consultar la informacion del propietario
	public function replica_consultarInformacionPropietario($idPropietario){
		
		$idPropietario = parent::escaparQueryBDReplica($idPropietario);
		
		$resultado = array();
		
		$conexion = parent::conexionReplica();
		
		$query = "SELECT P.idPropietario, P.identificacion, P.nombre, P.apellido, P.telefono, P.celular, P.direccion, P.email, P.idPais, P.estado,
						PA.nombre as nombrePais
						FROM tb_propietarios AS P
						INNER JOIN tb_paises AS PA ON PA.idPais = P.idPais
						WHERE P.idPropietario = '$idPropietario' ";
		

		if($res = $conexion->query($query)){
			while ($filas = $res->fetch_assoc()) {
                   
				   $resultado = $filas;
                }
		}
		
		return $resultado;
		
		
	}//fin metodo replica_consultarInformacionPropietario
	
	
	//metodo para consultar la informacion de un paciente
	public function replica_consultarInformacionPaciente($idPaciente){
		
		$idPaciente = parent::escaparQueryBDReplica($idPaciente);
		
		$resultado = array();
		
		$conexion = parent::conexionReplica();
		
		$query = "SELECT P.idMascota, P.nombre, P.numeroChip, P.sexo, P.esterilizado, P.color, DATE_FORMAT(P.fechaNacimiento, '%Y/%m/%d') as fechaNacimiento, P.estado, P.alimento,
							P.frecuenciaDiaria, P.cantidadComidaGramos, P.frecuenciaBanoDias, P.idRaza, P.idEspecie,
							R.nombre AS nombreRaza, E.nombre AS nombreEspecie
							
							FROM tb_mascotas AS P
							
							INNER JOIN tb_razas AS R ON P.idRaza = R.idRaza
							INNER JOIN tb_especies AS E ON E.idEspecie = P.idEspecie
		
						WHERE P.idMascota = '$idPaciente' ";
		

		if($res = $conexion->query($query)){
			while ($filas = $res->fetch_assoc()) {
                   
				   $resultado = $filas;
                }
		}
		
		return $resultado;		
		
		
	}//fin metodo replica_consultarInformacionPaciente
	
	
	//metodo para listar pacientes por propietario
	public function replica_listarPacientesPorPropietario($idPropietario){
		
		$idPropietario = parent::escaparQueryBDReplica($idPropietario);
		
		$resultado = array();
		
		$conexion = parent::conexionReplica();
		
		$query = "SELECT 
				    M.idMascota,
				    M.nombre,
				    M.numeroChip,
				    M.sexo,
				    M.esterilizado,
				    M.color,
				    M.fechaNacimiento,
				    M.urlFoto,
				    M.estado,
				    M.alimento,
				    M.frecuenciaDiaria,
				    M.frecuenciaBanoDias,
				    M.idPropietario,
				    M.idRaza,
				    M.idEspecie,
				    E.nombre AS EspecieNombre,
				    R.nombre AS RazaNombre
				FROM
				    tb_mascotas AS M
				        INNER JOIN
				    tb_especies AS E ON E.idEspecie = M.idEspecie
				        INNER JOIN
				    tb_razas AS R ON R.idRaza = M.idRaza
				WHERE
				    M.idPropietario = '$idPropietario'";
			   
   		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo listarPacientesPorPropietario
	
	
	        
        //metodo para buscar una especie según un string ingresado en un campo input text
        public function buscarRazaConString($string, $idEspecie = ""){
            
            $string  	= parent::escaparQueryBDReplica($string);
			$idEspecie  = parent::escaparQueryBDReplica($idEspecie); 
            
            $resultado = array();

			if($idEspecie == ""){
				
				$query  = "SELECT idRaza, nombre from tb_razas ".
					    " where  (nombre like '%$string%') ";
				
			}else{
			
				$query  = "SELECT idRaza, nombre from tb_razas ".
					    " where  (nombre like '%$string%') and estado = 'A' and idEspecie = '$idEspecie' ";
				
			}

            
            $conexion = parent::conexionReplica();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['nombre'],
	                    						'id' => $filas['idRaza'],
	                    						'nombre' => $filas['nombre'],
	                    						'value' => $filas['nombre'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarRazaConString
	

	
	//metodo para guardar un nuevo paciente
	public function guardarPaciente($idEspecie, $idRaza, $paciente_nombre, $paciente_chip, $paciente_sexo, $fechaNacimiento, $paciente_esterilizado,
							$paciente_color, $paciente_alimento, $frecuenciaAlimento, $paciente_bano, $urlFotoPaciente, $idPropietario){
							
			$idEspecie					= parent::escaparQueryBDReplica($idEspecie);
			$idRaza						= parent::escaparQueryBDReplica($idRaza);
			$paciente_nombre			= parent::escaparQueryBDReplica($paciente_nombre);
			$paciente_chip				= parent::escaparQueryBDReplica($paciente_chip);
			$paciente_sexo				= parent::escaparQueryBDReplica($paciente_sexo);
			$fechaNacimiento			= parent::escaparQueryBDReplica($fechaNacimiento);
			$paciente_esterilizado		= parent::escaparQueryBDReplica($paciente_esterilizado);
			$paciente_color				= parent::escaparQueryBDReplica($paciente_color);
			$paciente_alimento			= parent::escaparQueryBDReplica($paciente_alimento);
			$frecuenciaAlimento			= parent::escaparQueryBDReplica($frecuenciaAlimento);
			$paciente_bano				= parent::escaparQueryBDReplica($paciente_bano);
			$idPropietario				= parent::escaparQueryBDReplica($idPropietario);
			$urlFotoPaciente			= parent::escaparQueryBDReplica($urlFotoPaciente);			
			
			
			$query	= "INSERT INTO tb_mascotas
						(nombre,numeroChip,sexo,esterilizado,color,fechaNacimiento,urlFoto,estado,alimento,frecuenciaDiaria,
						frecuenciaBanoDias,idPropietario,idRaza,idEspecie)
					   VALUES
						('$paciente_nombre', '$paciente_chip', '$paciente_sexo', '$paciente_esterilizado', '$paciente_color', '$fechaNacimiento',
						 '$urlFotoPaciente', 'vivo', '$paciente_alimento', '$frecuenciaAlimento', '$paciente_bano', '$idPropietario', '$idRaza', '$idEspecie' );";
			
			$conexion = parent::conexionReplica();
			
			$res = $conexion->query($query);
					
								
	}//fin metodo guardarPaciente	
	

	//metodo para consultar el total de cirugias de un paciente
	public function total_cirugias($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idCirugia) AS totalCirugias FROM tb_cirugias WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalCirugias'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_cirugias	
	
	
		
	//metodo para consultar el total de consultas de un paciente
	public function total_consultas($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idConsulta) AS totalConsultas FROM tb_consultas WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalConsultas'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_consultas
	

	//metodo para consultar el total de desparasitantes de un paciente
	public function total_desparasitantes($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idDesparasitante) AS totalDesparasitantes FROM tb_desparasitantes WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalDesparasitantes'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_desparasitantes	
		

	//metodo para consultar el total de examenes de un paciente
	public function total_examenes($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idExamen) AS totalExamenes FROM tb_examenes WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalExamenes'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_examenes	
				

	//metodo para consultar el total de formulas de un paciente
	public function total_formulas($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idFormula) AS totalFormulas FROM tb_formulas WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalFormulas'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_formulas					
						

	//metodo para consultar el total de vacunas de un paciente
	public function total_vacunas($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idMascotaVacunas) AS totalVacunas FROM tb_mascotas_vacunas WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalVacunas'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_vacunas					
												

												
	//metodo para consultar el total de antipulgas/garrapatas de un paciente
	public function total_antipulgas($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = 0;
		
		$query = "SELECT COUNT(idAntiPulgasGarrapatas) AS totalAntipulgas FROM tb_antiPulgasGarrapatas WHERE idMascota = '$idPaciente'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalAntipulgas'];
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo total_antipulgas		
	

/*********************************************************---------Fin Concultas------*/	
	
	//metodo para consultar toda la información de la consulta de un paciente
	public function listado_consultasPaciente($idPaciente){
		
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT C.idConsulta, C.fecha, C.motivo, C.observaciones, C.planASeguir, C.edadActualMascota, C.medico, C.nombreSucursal,
							EF.idExamenFisico, EF.peso, EF.medidaCm, EF.temperatura, EF.observaciones as observacionesExamenFisico
					FROM tb_consultas AS C
					LEFT JOIN tb_examenFisico AS EF ON EF.idConsulta = C.idConsulta
					WHERE C.idMascota = '$idPaciente' order by  C.idConsulta desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	
		
	}//fin metodo listado_consultasPaciente
	
	
	//metodo para consultar los diagnosticos de consulta
	public function consultarDxsConsulta($idConsulta){
		
		$resultado = array();
		
		$query = "SELECT idDiagnosticoConsulta, descripcion, nombreDiagnostico 
					FROM tb_diagnosticosConsulta 
					WHERE idConsulta = '$idConsulta'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	
		
	}//fin metodo consultarDxsConsulta
	
	//metodo para consultar los items de un examen fisico de una consulta
	public function consultarItemsExamenFisico($idExamenFisico){
		
		$resultado = array();
		
		$query = "SELECT idItiemExamenFisico, nombre, observacion, estadoRevision 
					FROM tb_itemsExamenFisico 
					WHERE idExamenFisico = '$idExamenFisico'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	
		
		
	}//fin metodo consultarItemsExamenFisico
	
/*********************************************************---------Fin Concultas------*/



/*********************************************************---------Cirugias------*/

//metodo para listar las cirugias de un paciente
public function listado_cirugiasPaciente($idPaciente){
	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idCirugia, fecha, DATE_FORMAT(hora, '%H:%i') as hora, fechaFin, DATE_FORMAT(horaFin, '%H:%i') as horaFin, tipoAnestesia, motivo, complicaciones, observaciones, planASeguir, edadActualMascota, 
							medico, nombreSucursal 
					FROM tb_cirugias 
					WHERE idMascota = '$idPaciente' order by  idCirugia desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	
	
	
}//fin metodo listado_cirugiasPaciente

//metodo para consultar los diagnosticos de una cirugia
public function consultarDxsCirugia($idCirugia){
	
		$resultado = array();
		
		$query = "SELECT idDiagnosticoCirugia, descripcion, nombreDiagnostico
					FROM tb_diagnosticosCirugias 
					WHERE idCirugia = '$idCirugia'";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	
	
	
}//fin metodo consultarDxsCirugia



/*********************************************************---------Fin Cirugias------*/


/*********************************************************---------Desparasitantes------*/

//metodo para listar los desparasitantes de un paciente
public function listado_desparasitantesPaciente($idPaciente){
	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idDesparasitante, fecha, fechaProximoDesparasitante,  nombre, dosificacion, observaciones, estado
					FROM tb_desparasitantes 
					WHERE idMascota = '$idPaciente' order by  idDesparasitante desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		
	
	
}//fin metodo listado_desparasitantesPaciente


//metodo para guardar la aplicacion de un desparasitante
public function guardarAplicacionDesparasitante($idPaciente, $nombreDesparasitante, $dosificacion, $fechaProximoDesparasitante, $observaciones){
	
	$idPaciente						= parent::escaparQueryBDReplica($idPaciente);
	$nombreDesparasitante			= parent::escaparQueryBDReplica($nombreDesparasitante);
	$dosificacion					= parent::escaparQueryBDReplica($dosificacion);
	$fechaProximoDesparasitante		= parent::escaparQueryBDReplica($fechaProximoDesparasitante);
	$observaciones					= parent::escaparQueryBDReplica($observaciones);
	
	
	$conexion = parent::conexionReplica();
	
	
	$query = "INSERT INTO tb_desparasitantes (fecha, hora, fechaProximoDesparasitante, nombre, dosificacion, observaciones, estado, idMascota) 
				VALUES (NOW(),NOW(), '$fechaProximoDesparasitante', '$nombreDesparasitante', '$dosificacion', '$observaciones', 'A', '$idPaciente' )";
	
	
				
	$conexion->query($query);
	
	
}//fin metodo guardarAplicacionDesparasitante


/*********************************************************---------Fin Desparasitantes------*/


/*********************************************************---------Examenes------*/


//metodo para listar los examenes de un paciente
public function listado_examenesPaciente($idPaciente){
	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idExamen, fecha, DATE_FORMAT(hora, '%H:%i') as hora, observaciones,  usuario, nombreSucursal
					FROM tb_examenes 
					WHERE idMascota = '$idPaciente' order by  idExamen desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		
		
	
	
}//fin metodo listado_examenesPaciente


//metodo para consultar el detalle de un examen
public function consultarDetalleExamenEncabezado($idExamen){
	
		
		$resultado = array();
		
		$query = "SELECT D.idExamenDetalle, D.nombre, 
							R.fecha, DATE_FORMAT(R.hora, '%H:%i') as hora, R.general, R.observaciones, R.usuario, R.nombreSucursal
		
					FROM tb_examenDetalle AS D  
					
					LEFT JOIN tb_resultadoExamen AS R ON R.idExamenDetalle = D.idExamenDetalle
					
					WHERE D.idExamen = '$idExamen' 
					
					";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		
	
	
	
}//fin metodo consultarDetalleExamenEncabezado


/*********************************************************---------Fin Examenes------*/


/*********************************************************---------Formulas------*/

//metodo para listar las formulas de un paciente
public function listado_formulasPaciente($idPaciente){
	
	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idFormula, fecha, DATE_FORMAT(hora, '%H:%i') as hora, observaciones,  usuario, nombreSucursal
					FROM tb_formulas 
					WHERE idMascota = '$idPaciente' order by  idFormula desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		
	
}//fin metodo listado_formulasPaciente


//metodo para consultar el detalle de una formula
public function consultarDetalleFormula($idFormula){

		$resultado = array();
		
		$query = "SELECT idMedicamentoFormula, nombreMedicamento, via, cantidad, frecuencia, dosificacion, observacion 
					FROM tb_medicamentosFormula 
					WHERE idFormula = '$idFormula' ";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;	

	
}//fin metodo consultarDetalleFormula


/*********************************************************---------Fin Formulas------*/


/*********************************************************---------Vacunas------*/

//metodo para consultar las vacunas de un paciente
public function listado_vacunasPaciente($idPaciente){

	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idMascotaVacunas, fecha, DATE_FORMAT(hora, '%H:%i') as hora, fechaProximaVacuna,  observaciones, estado,
							nombreVacuna, descripcionVacuna, usuario, nombreSucursal
					FROM tb_mascotas_vacunas 
					WHERE idMascota = '$idPaciente' order by  idMascotaVacunas desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		

	
}//fin metodo listado_vacunasPaciente



/*********************************************************---------Fin Vacunas------*/


/*********************************************************---------AntiPulgas------*/
//metodo para consultar los antipulgas de un paciente
public function listado_anipulgasPaciente($idPaciente){
	
		$idPaciente					= parent::escaparQueryBDReplica($idPaciente);

		$resultado = array();
		
		$query = "SELECT idAntiPulgasGarrapatas, fecha, nombreProducto, observaciones, fechaProximaAplicacion
							
					FROM tb_antiPulgasGarrapatas 
					WHERE idMascota = '$idPaciente' order by  idAntiPulgasGarrapatas desc";
		
		$conexion = parent::conexionReplica();
		
		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
		return $resultado;		
	
	
}///fin metodo listado_anipulgasPaciente


//metodo para guardar una aplicacion de un antipulgas
public function guardarAplicacionAntipulgas($idPaciente, $nombreProducto, $fechaProximoAntipulgas, $observaciones ){
	
	$idPaciente						= parent::escaparQueryBDReplica($idPaciente);
	$nombreProducto					= parent::escaparQueryBDReplica($nombreProducto);	
	$fechaProximoAntipulgas			= parent::escaparQueryBDReplica($fechaProximoAntipulgas);
	$observaciones					= parent::escaparQueryBDReplica($observaciones);
	
	
	$conexion = parent::conexionReplica();
	
	
	$query = "INSERT INTO tb_antiPulgasGarrapatas (fecha, fechaProximaAplicacion, nombreProducto, observaciones, estadoAlertaAplicacion, idMascota) 
				VALUES (NOW(), '$fechaProximoAntipulgas', '$nombreProducto', '$observaciones', 'Pendiente', '$idPaciente' )";


				
	$conexion->query($query);	
	
	
}//fin metodo guardarAplicacionAntipulgas



/*********************************************************---------Fin AntiPulgas------*/

													
																					
}//fin clase



?>