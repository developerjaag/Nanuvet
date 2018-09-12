<?php


/**
 * Clase para administra rlos datos d elos propietarios y de los pacientes
 */
class nuevo extends Config {

	//metodo para buscar un propietario segun un string dado
	public function buscarPropietarioString($string){
		
		$string  = parent::escaparQueryBDCliente($string);
		
		$resultado = array();
            
        $query  = "SELECT idPropietario, identificacion, nombre, apellido
        			FROM tb_propietarios
        		   WHERE  identificacion like '%$string%' OR 
        		   	nombre LIKE '%$string%' OR 
        		   	apellido LIKE '%$string%' OR 
        		    CONCAT(nombre,apellido) LIKE '$string' OR 
        		    CONCAT(apellido,nombre) LIKE '$string' ";
        
        $conexion = parent::conexionCliente();
	
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

	//metodo para almacenar el nuevo propietario
	public function guardarPropietario($identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais, $idCiudad, $idBarrio){
		
		$resultado		= array();
		
		$identificacion  = parent::escaparQueryBDCliente($identificacion);
		$nombre  		 = parent::escaparQueryBDCliente($nombre);
		$apellido  		 = parent::escaparQueryBDCliente($apellido);
		$telefono  		 = parent::escaparQueryBDCliente($telefono);
		$celular  		 = parent::escaparQueryBDCliente($celular);
		$direccion  	 = parent::escaparQueryBDCliente($direccion);
		$email  		 = parent::escaparQueryBDCliente($email);
		$idPais  		 = parent::escaparQueryBDCliente($idPais);
		$idCiudad  		 = parent::escaparQueryBDCliente($idCiudad);
		$idBarrio  		 = parent::escaparQueryBDCliente($idBarrio);
		
		$conexion = parent::conexionCliente();
		
		$query1		= "INSERT INTO tb_propietarios
						(identificacion,nombre,apellido,telefono,celular,direccion,email,idPais,idCiudad,idBarrio,estado)
					  VALUES
					  	('$identificacion','$nombre','$apellido','$telefono','$celular','$direccion','$email','$idPais','$idCiudad','$idBarrio','A')";
		
		
		if($res = $conexion->query($query1)){
                
                   
			   $query2	= "SELECT MAX(idPropietario) AS idPropietario FROM tb_propietarios";
			   
			   		if($res2 = $conexion->query($query2)){
			   
			   			/* obtener un array asociativo */
			            while ($filas2 = $res2->fetch_assoc()) {
			                $resultado = $filas2;
			            }//fin while  
           
       	 			}//fin if		   
           
        }//fin if
        
        
		/*Guardar propietario en la BD replica*/
		$conexionReplica	= parent::conexionReplica();
		$queryReplica		= "INSERT IGNORE INTO tb_propietarios
								(identificacion, nombre, apellido, telefono, celular, direccion, email, idPais, estado, fechaRegistro)
							 VALUES
							 	('$identificacion','$nombre','$apellido','$telefono','$celular','$direccion','$email','$idPais','A',NOW())";

		$resReplica = $conexionReplica->query($queryReplica);        
            
            
        return $resultado;
		
	}//fin metodo guardarPropietario
	
/*----------------*---------------------------*/	
	//metodo para consultar la informacion de un propietario en la BDReplica
	public function consultarInfoPropietario_Replica($numeroIdentificacion){
		
		$numeroIdentificacion  = parent::escaparQueryBDCliente($numeroIdentificacion);
		
		$resultado = array();
		
		$query = "SELECT idPropietario, nombre, apellido, telefono, celular, direccion, email
					FROM tb_propietarios
					WHERE identificacion = '$numeroIdentificacion' ";
		

		$conexionReplica = parent::conexionReplica();

			   
   		if($res = $conexionReplica->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;		
		
	}//fin metodo consultarInfoPropietario_Replica
/*----------------*---------------------------*/	
	
	
	
	
	//metodo para editar el propietario
	public function editarPropietario($idPropietarioForm, $identificacion, $nombre, $apellido, $telefono, $celular, $direccion, $email, $idPais, $idCiudad, $idBarrio, $idPropietarioREPLICA){
		
		
		$idPropietarioForm  = parent::escaparQueryBDCliente($idPropietarioForm);
		$identificacion  	= parent::escaparQueryBDCliente($identificacion);
		$nombre  		 	= parent::escaparQueryBDCliente($nombre);
		$apellido  		 	= parent::escaparQueryBDCliente($apellido);
		$telefono  		 	= parent::escaparQueryBDCliente($telefono);
		$celular  		 	= parent::escaparQueryBDCliente($celular);
		$direccion  	 	= parent::escaparQueryBDCliente($direccion);
		$email  		 	= parent::escaparQueryBDCliente($email);
		$idPais  		 	= parent::escaparQueryBDCliente($idPais);
		$idCiudad  		 	= parent::escaparQueryBDCliente($idCiudad);
		$idBarrio  		 	= parent::escaparQueryBDCliente($idBarrio);
		
		$conexion = parent::conexionCliente();
		
		$query		= "UPDATE tb_propietarios SET
						identificacion = '$identificacion', nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', 
						celular  = '$celular', direccion = '$direccion',
						email  = '$email', idPais  = '$idPais', idCiudad  = '$idCiudad', idBarrio = '$idBarrio'
					   WHERE idPropietario = '$idPropietarioForm' ";
		
			
		
		$res = $conexion->query($query);
		
		/*--- Editar propietario en la REPLICA ----*/
		$conexionReplica	= parent::conexionReplica();
		$queryReplica		= "UPDATE tb_propietarios SET
								identificacion = '$identificacion', nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', 
								celular  = '$celular', direccion = '$direccion',
								email  = '$email', idPais  = '$idPais'
							   WHERE idPropietario = '$idPropietarioREPLICA'";

		$resReplica = $conexionReplica->query($queryReplica); 
		/*--- Editar propietario en la REPLICA ----*/
            
            
        return $idPropietarioForm;
		
	}//fin metodo editarPropietario
	
	
	
	
	//metodo para consultar toda la informacion del propietario
	public function ConsultarInformacionPropietario($idPropietario){
		
		$resultado		= array();
		
		
		$query	= "SELECT P.identificacion, P.nombre, P.apellido, P.telefono, P.celular, P.direccion, P.email, P.idPais, P.idCiudad, P.idBarrio,
					PA.nombre as PANombre, C.nombre as CNombre, B.nombre as BNombre
						FROM tb_propietarios AS P 
						INNER JOIN tb_paises AS PA ON P.idPais = PA.idPais
						INNER JOIN tb_ciudades AS C ON P.idCiudad = C.idCiudad
						INNER JOIN tb_barrios AS B ON P.idBarrio = B.idBarrio
					WHERE P.idPropietario = '$idPropietario'  ";
					
		$conexion = parent::conexionCliente();

			   
   		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;
		
		
	}//fin metodo ConsultarInformacionPropietario
	
	//metodo para obtener el listado de pacientes de un propietario
	public function listarPacientesPorPropietario($idPropietario){
		
		$resultado = array();
		
		$idPropietario	= parent::escaparQueryBDCliente($idPropietario);
		
		$query = "SELECT M.idMascota, M.nombre, M.numeroChip, M.sexo, M.esterilizado, M.color, M.fechaNacimiento, M.urlFoto, M.estado, M.alimento, M.frecuenciaDiaria,
					M.frecuenciaBanoDias, M.idPropietario, M.idRaza, M.idEspecie, M.idReplica,
					E.nombre as EspecieNombre, R.nombre as RazaNombre 
					FROM tb_mascotas as M
					INNER JOIN tb_especies AS E ON E.idEspecie = M.idEspecie
					INNER JOIN tb_razas AS  R ON R.idRaza = M.idRaza
					WHERE M.idPropietario = '$idPropietario'";
		
		$conexion = parent::conexionCliente();

			   
   		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;		

		
	}//fin metodo listarPacientesPorPropietario
	

	
	
/*------------ Replica --------------*/	
	//metodo para obtener el listado de pacientes de un propietario en la REPLICA
	public function listarPacientesPorPropietario_REPLICA($idPropietarioREPLICA){
		
		$resultado = array();
		
		$idPropietarioREPLICA	= parent::escaparQueryBDCliente($idPropietarioREPLICA);
		
		$query = "SELECT M.idMascota, M.nombre, M.numeroChip, M.sexo, M.esterilizado, M.color, M.fechaNacimiento, M.urlFoto, M.estado, M.alimento, M.frecuenciaDiaria,
					M.frecuenciaBanoDias, M.idPropietario, M.idRaza, M.idEspecie, E.nombre as EspecieNombre, R.nombre as RazaNombre 
					FROM tb_mascotas as M
					LEFT JOIN tb_especies AS E ON E.idEspecie = M.idEspecie
					LEFT JOIN tb_razas AS  R ON R.idRaza = M.idRaza
					WHERE M.idPropietario = '$idPropietarioREPLICA'";
		
		$conexionReplica = parent::conexionReplica();

			   
   		if($res = $conexionReplica->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;			

		
	}//fin metodo listarPacientesPorPropietario_REPLICA	
	
/*------------ Replica --------------*/	
		
	
	//metodo para guardar un nuevo paciente
	public function guardarPaciente($idEspecie, $idRaza, $paciente_nombre, $paciente_chip, $paciente_sexo, $fechaNacimiento, $paciente_esterilizado,
							$paciente_color, $paciente_alimento, $frecuenciaAlimento, $paciente_bano, $urlFotoPaciente, $idPropietario, $idPropietario_replica, $idReplica = 0 ){
							
			$idEspecie					= parent::escaparQueryBDCliente($idEspecie);
			$idRaza						= parent::escaparQueryBDCliente($idRaza);
			$paciente_nombre			= parent::escaparQueryBDCliente($paciente_nombre);
			$paciente_chip				= parent::escaparQueryBDCliente($paciente_chip);
			$paciente_sexo				= parent::escaparQueryBDCliente($paciente_sexo);
			$fechaNacimiento			= parent::escaparQueryBDCliente($fechaNacimiento);
			$paciente_esterilizado		= parent::escaparQueryBDCliente($paciente_esterilizado);
			$paciente_color				= parent::escaparQueryBDCliente($paciente_color);
			$paciente_alimento			= parent::escaparQueryBDCliente($paciente_alimento);
			$frecuenciaAlimento			= parent::escaparQueryBDCliente($frecuenciaAlimento);
			$paciente_bano				= parent::escaparQueryBDCliente($paciente_bano);
			$idPropietario				= parent::escaparQueryBDCliente($idPropietario);
			$urlFotoPaciente			= parent::escaparQueryBDCliente($urlFotoPaciente);			
			$idPropietario_replica		= parent::escaparQueryBDCliente($idPropietario_replica);	
			$idReplica					= parent::escaparQueryBDCliente($idReplica);			
			
			
			$query	= "INSERT INTO tb_mascotas
						(nombre,numeroChip,sexo,esterilizado,color,fechaNacimiento,urlFoto,estado,alimento,frecuenciaDiaria,
						frecuenciaBanoDias,idPropietario,idRaza,idEspecie, idReplica)
					   VALUES
						('$paciente_nombre', '$paciente_chip', '$paciente_sexo', '$paciente_esterilizado', '$paciente_color', '$fechaNacimiento',
						 '$urlFotoPaciente', 'vivo', '$paciente_alimento', '$frecuenciaAlimento', '$paciente_bano', '$idPropietario', '$idRaza', '$idEspecie', '$idReplica' );";
			
			$conexion = parent::conexionCliente();
			
			$res = $conexion->query($query);
			
			
			/*------------- replica ----------*/
			if($idPropietario_replica != '0' AND $idReplica == '0'){
				
				/*Consultar ultimo id de mascotas*/
				$ultimoIdPaciente	= '';
				$query0 = 'SELECT MAX(idMascota) AS ultimoIdPaciente FROM tb_mascotas';
				
				if($res0 = $conexion->query($query0)){
   
		   			/* obtener un array asociativo */
		            while ($filas0 = $res0->fetch_assoc()) {
		                $ultimoIdPaciente = $filas0['ultimoIdPaciente'];
		            }//fin while  
		   
		 		}//fin if	
				
				/*Consultar ultimo id de mascotas*/
				
				$queryReplica	= "INSERT INTO tb_mascotas
									(nombre,numeroChip,sexo,esterilizado,color,fechaNacimiento,
									estado,alimento,frecuenciaDiaria,
									frecuenciaBanoDias,idPropietario,idRaza,idEspecie)
									VALUES
						('$paciente_nombre', '$paciente_chip', '$paciente_sexo', '$paciente_esterilizado', '$paciente_color', '$fechaNacimiento',
						  'vivo', '$paciente_alimento', '$frecuenciaAlimento', '$paciente_bano', '$idPropietario_replica', '0', '0' );";
			
				$conexionReplica = parent::conexionReplica();
				
				$res2 = $conexionReplica->query($queryReplica);


				/*Consultar ultimo id de mascotas replica*/
				$ultimoIdPacienteReplica	= '';
				$query3 = 'SELECT MAX(idMascota) AS ultimoIdPaciente FROM tb_mascotas';
				
				if($res3 = $conexionReplica->query($query3)){
   
		   			/* obtener un array asociativo */
		            while ($filas3 = $res3->fetch_assoc()) {
		                $ultimoIdPacienteReplica = $filas3['ultimoIdPaciente'];
		            }//fin while  
		   
		 		}//fin if	
				
				/*Consultar ultimo id de mascotas replica*/
				
				$query4 = "UPDATE tb_mascotas SET idReplica = '$ultimoIdPacienteReplica' WHERE idMascota = '$ultimoIdPaciente'";
				
				$res4 = $conexion->query($query4);
				
			}//fin if	para uingresar paciente en la replica	
			
			/*------------- Fin replica ----------*/
					
								
	}//fin metodo guardarPaciente
	
	
	//metodo para editar un paciente
	public function editarPaciente($idPropietarioPaciente, $idEspecie, $idRaza, $idPaciente, $paciente_estado, $paciente_nombre, $paciente_chip,
												 $paciente_sexo, $fechaNacimiento, $paciente_esterilizado, $paciente_color, $paciente_alimento, $frecuenciaAlimento,
												 $paciente_bano, $urlFotoPaciente){
												 	
													
			$idPropietarioPaciente 		= parent::escaparQueryBDCliente($idPropietarioPaciente);
			$idEspecie 					= parent::escaparQueryBDCliente($idEspecie);
			$idRaza 					= parent::escaparQueryBDCliente($idRaza);
			$idPaciente 				= parent::escaparQueryBDCliente($idPaciente);
			$paciente_estado 			= parent::escaparQueryBDCliente($paciente_estado);
			$paciente_nombre 			= parent::escaparQueryBDCliente($paciente_nombre);
			$paciente_chip 				= parent::escaparQueryBDCliente($paciente_chip);
			$paciente_sexo 				= parent::escaparQueryBDCliente($paciente_sexo);
			$fechaNacimiento 			= parent::escaparQueryBDCliente($fechaNacimiento);
			$paciente_esterilizado 		= parent::escaparQueryBDCliente($paciente_esterilizado);
			$paciente_color 			= parent::escaparQueryBDCliente($paciente_color);
			$paciente_alimento 			= parent::escaparQueryBDCliente($paciente_alimento);
			$frecuenciaAlimento 		= parent::escaparQueryBDCliente($frecuenciaAlimento);
			$paciente_bano 				= parent::escaparQueryBDCliente($paciente_bano);
			$urlFotoPaciente			= parent::escaparQueryBDCliente($urlFotoPaciente);
			
			if($urlFotoPaciente != ''){
				$query	= "UPDATE tb_mascotas SET idPropietario = '$idPropietarioPaciente', idEspecie = '$idEspecie', idRaza = '$idRaza', estado = '$paciente_estado',
								nombre = '$paciente_nombre', numeroChip = '$paciente_chip', sexo = '$paciente_sexo', fechaNacimiento = '$fechaNacimiento',
								esterilizado = '$paciente_esterilizado', color = '$paciente_color', alimento = '$paciente_alimento', frecuenciaDiaria = '$frecuenciaAlimento',
								frecuenciaBanoDias = '$paciente_bano', urlFoto = '$urlFotoPaciente'
							WHERE idMascota = '$idPaciente' ";
			}else{
				$query	= "UPDATE tb_mascotas SET idPropietario = '$idPropietarioPaciente', idEspecie = '$idEspecie', idRaza = '$idRaza', estado = '$paciente_estado',
								nombre = '$paciente_nombre', numeroChip = '$paciente_chip', sexo = '$paciente_sexo', fechaNacimiento = '$fechaNacimiento',
								esterilizado = '$paciente_esterilizado', color = '$paciente_color', alimento = '$paciente_alimento', frecuenciaDiaria = '$frecuenciaAlimento',
								frecuenciaBanoDias = '$paciente_bano'
							WHERE idMascota = '$idPaciente'  ";
			}//Fin else
			
			
			
			$conexion = parent::conexionCliente();
			
			$res = $conexion->query($query);
		
	}//fin metodo editarpaciente
	
	
	//metodo para consultar datos del propietario y del paciente con id del paciente
	public function consultarDatosPropietarioPaciente($idPaciente){
				
		$resultado = array();	
					
		$idPaciente 		= parent::escaparQueryBDCliente($idPaciente);		
			
		$query	= "SELECT P.nombre as nombrePaciente, P.fechaNacimiento, P.urlFoto, P.estado, P.sexo, P.esterilizado, P.idReplica,
							PROP.idPropietario, PROP.identificacion, PROP.nombre as nombrePropietario, PROP.apellido, PROP.celular,
							R.nombre as nombreRaza,
							E.nombre as nombreEspecie
					FROM tb_mascotas AS P
					INNER JOIN tb_propietarios AS PROP ON PROP.idPropietario = P.idPropietario
					INNER JOIN tb_razas AS R ON R.idRaza = P.idRaza
					INNER JOIN tb_especies AS E ON E.idEspecie = P.idEspecie
				WHERE P.idMascota = '$idPaciente'";	
				
				$conexion = parent::conexionCliente();

			   
   		if($res = $conexion->query($query)){
   
   			/* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }//fin while  
   
 		}//fin if		   

            
        return $resultado;	
		
	}//fin metodo consultarDatosPropietarioPaciente
	

	//metodo para consultar la cantidad de cirugias de un paciente
	public function totalCirugiasPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idCirugia) as cantidadCirugias from tb_cirugias WHERE idMascota = '$idPaciente' ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadCirugias'];	
		
	}//fin metodo totalCirugiasPaciente	
	
	
		
	//metodo para consultar la cantidad de consultas d eun paciente
	public function totalConsultasPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idConsulta) as cantidadConsultas from tb_consultas WHERE idMascota = '$idPaciente'  ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadConsultas'];	
		
	}//fin metodo totalConsultasPaciente
			

	//metodo para consultar la cantidad de desparasitantes de un paciente
	public function totalDesparasitantesPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idDesparasitanteMascota) as cantidadDesparasitantes from tb_desparasitantesMascotas WHERE idMascota = '$idPaciente'  ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadDesparasitantes'];	
		
	}//fin metodo totalDesparasitantesPaciente




	//metodo para consultar la cantidad de examenes de un paciente
	public function totalExamenesPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idExamen) as cantidadExamenes from tb_examenes WHERE idMascota = '$idPaciente'  ";
		
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
		
	}//fin metodo totalExamenesPaciente




	//metodo para consultar la cantidad de formulas de un paciente
	public function totalFormulasPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idFormula) as cantidadFormulas from tb_formulas WHERE idMascota = '$idPaciente'  ";
		
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
		
	}//fin metodo totalFormulasPaciente





	//metodo para consultar la cantidad de hospitalizaciones de un paciente
	public function totalHospitalizacionesPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idHospitalizacion) as cantidadHospitalizaciones from tb_hospitalizacion WHERE idMascota = '$idPaciente'  ";
		
		$conexion = parent::conexionCliente();
		
		if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();
           
        }

        return $resultado['cantidadHospitalizaciones'];	
		
	}//fin metodo totalHospitalizacionesPaciente





	//metodo para consultar la cantidad de vacunas de un paciente
	public function totalVacunasPaciente($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "Select count(idMascotaVacunas) as cantidadVacunas from tb_mascotas_vacunas WHERE idMascota = '$idPaciente'  ";
		
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
		
	}//fin metodo totalVacunasPaciente


	//metodo para indicar que un paciente falleció
	public function pacienteFallece($idPaciente){
		
		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
		
		$query = "UPDATE tb_mascotas SET estado = 'muerto' WHERE idMascota = '$idPaciente'";
			
		$conexion = parent::conexionCliente();
		$res = $conexion->query($query);	
		
	}//fin metodo pacienteFallece


}//fin clase




?>