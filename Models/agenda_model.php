<?php

/**
 * Clase para manipular los datos de la agenda
 */
class agenda extends Config {
	
	//metodo para consultar los usuarios activos
	public function usuariosActivos(){
		
		$resultado = array();
		
		$query = "SELECT idUsuario, identificacion, nombre, apellido FROM tb_usuarios WHERE estado = 'A' AND agenda = 'Si'";
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }                
               
         }//fin if
		
        return $resultado;			
		
	}
	
	
/*--------------------------Horario semana ----------------------*/

	//metodo para consultar el horario de un usuario en un dia
	public function consultarHorarioDiaUsuario($dia, $idUsuario){
		
		$resultado = array();
		
		$dia  = parent::escaparQueryBDCliente($dia); 
		$idUsuario  = parent::escaparQueryBDCliente($idUsuario); 
		
		$query = "SELECT idAgendaHorarioUsuario, DATE_FORMAT(horaInicio, '%H:%i') as horaInicio, DATE_FORMAT(horaFin, '%H:%i') as horaFin, estado
					FROM tb_agendaHorarioUsuario
				  WHERE numeroDia = '$dia' AND idUsuario = '$idUsuario' AND estado = 'A'";
		
        $conexion = parent::conexionCliente();
		
		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }

        return $resultado;		
			
	}//fin metodo consultarHorarioDiaUsuario
	
	
	//metodo para guardar el horario de  un dia del usuario
	function guardarHorarioDiaUsuario($idUsuario, $dia, $horaInicio, $horaFin){
		
			$dia  			= parent::escaparQueryBDCliente($dia); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 			
            
           $query = "INSERT INTO tb_agendaHorarioUsuario (horaInicio, horaFin, numeroDia, estado, idUsuario) ".
                        " VALUES ('$horaInicio', '$horaFin', '$dia', 'A', '$idUsuario') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;		
		
		
	}//fin metodo guardarHorarioDiaUsuario
	

	//metodo para actualizar el horairo de un usuario en un dia
	public function acturalizarHorarioDiaUsuario($idUsuario, $dia, $horaInicio, $horaFin){

			$dia  			= parent::escaparQueryBDCliente($dia); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 		

           $query = "UPDATE tb_agendaHorarioUsuario SET horaInicio = '$horaInicio', horaFin = '$horaFin' 
           				WHERE numeroDia = '$dia' AND idUsuario = '$idUsuario' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  

		
	}//fin metodo acturalizarHorarioDiaUsuario
	
	//metodo para inactivar el horario de un dia de la semana para un usuario
	public function inactivarHorarioDiaUsuario($idUsuario, $dia){
		
			$dia  			= parent::escaparQueryBDCliente($dia); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 	

           $query = "UPDATE tb_agendaHorarioUsuario SET estado = 'I'
           				WHERE numeroDia = '$dia' AND idUsuario = '$idUsuario' ";
           
           $conexion = parent::conexionCliente();
    		
             $conexion->query($query);
            
		
		
	}//fin metodo inactivarHorarioDiaUsuario

/*--------------------------Horario semana ----------------------*/	
	
/*--------------------------Horario fecha ----------------------*/

	//metodo para consultar si una un susuario tiene horario para una fecha
	public function consultarHorarioFechaUsuario($fecha, $idUsuario){
		
		$resultado = array();
		
		$fecha  		= parent::escaparQueryBDCliente($fecha); 
		$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
		
		$query = "SELECT idAgendaHorarioFechaUsuario, DATE_FORMAT(horaInicio, '%H:%i') as horaInicio, DATE_FORMAT(horaFin, '%H:%i') as horaFin, estado
					FROM tb_agendaHorarioFechaUsuario
				  WHERE fecha = '$fecha' AND idUsuario = '$idUsuario'";
		
        $conexion = parent::conexionCliente();
		
		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }

        return $resultado;		
			
	}//fin metodo consultarHorarioDiaUsuario


	//metodo para guardar el horario de  un dia del usuario
	public function guardarHorarioFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin){
		
			$fecha  		= parent::escaparQueryBDCliente($fecha); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 			
            
           $query = "INSERT INTO tb_agendaHorarioFechaUsuario (horaInicio, horaFin, fecha, estado, idUsuario) ".
                        " VALUES ('$horaInicio', '$horaFin', '$fecha', 'A', '$idUsuario') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;		
		
		
	}//fin metodo guardarHorarioFechaUsuario
	
	//metodo para actualizar el horairo de un usuario en un dia
	public function acturalizarHorarioFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin){

			$fecha  		= parent::escaparQueryBDCliente($fecha); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 		


           $query = "UPDATE tb_agendaHorarioFechaUsuario SET horaInicio = '$horaInicio', horaFin = '$horaFin' 
           				WHERE fecha = '$fecha' AND idUsuario = '$idUsuario' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  

		
	}//fin metodo acturalizarHorarioDiaUsuario	
	
	
	//metodo para consultar los horarios en fechas superiores a la actual
	public function consultarHoriosFechasListado($idUsuario){
		
		$resultado = array();
		
		$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
		
		$query = "SELECT idAgendaHorarioFechaUsuario, fecha, DATE_FORMAT(horaInicio, '%H:%i') as horaInicio, DATE_FORMAT(horaFin, '%H:%i') as horaFin, estado
					FROM tb_agendaHorarioFechaUsuario
				  WHERE (fecha >= CURDATE() ) AND (idUsuario = '$idUsuario') AND (estado = 'A')";
		
        $conexion = parent::conexionCliente();
		
		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }

        return $resultado;	
		
	}//fin metodo consultarHoriosFechasListado
	
	//metodo para inactivar un horarioFecha
	public function inactivarHorarioFecha($idAgendaHorarioFechaUsuario){
		
		   $idAgendaHorarioFechaUsuario  		= parent::escaparQueryBDCliente($idAgendaHorarioFechaUsuario); 		


           $query = "UPDATE tb_agendaHorarioFechaUsuario SET estado = 'I'
           				WHERE idAgendaHorarioFechaUsuario = '$idAgendaHorarioFechaUsuario' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  

	}//fin metodo inactivarHorarioFecha
	
	
/*--------------------------Fin Horario fecha ----------------------*/	



/*--------------------------Receso dias ----------------------*/

	//metodo para guardar el horario de  un dia del usuario
	function guardarRecesoDia($idUsuario, $dia, $horaInicio, $horaFin){
		
			$dia  			= parent::escaparQueryBDCliente($dia); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 			
            
           $query = "INSERT INTO tb_agendaRecesosUsuario (numeroDia, idUsuario) ".
                        " VALUES ('$dia', '$idUsuario')";
         
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                 $query2	= "SELECT MAX(idAgendaRecesosUsuario) as ultimoIdRecesoUsuario FROM tb_agendaRecesosUsuario";
			
					if($res2 = $conexion->query($query2)){
			           
			               /* obtener un array asociativo */
			                while ($filas = $res2->fetch_assoc()) {
			                	
			                    $resultado = $filas['ultimoIdRecesoUsuario'];
								
								$query3 = "INSERT INTO tb_agendaHorarioReceso (horaInicio, horaFin, estado, idAgendaRecesosUsuario)
											VALUES ('$horaInicio','$horaFin','A','$resultado')";
								
								$conexion->query($query3);
								
			                }
			            
			                /* liberar el conjunto de resultados */
			                $res2->free();
			           
			        }
				 
				    
            }
    
            return $resultado;		
		
		
	}//fin metodo guardarRecesoDia

	//metodo para consultar los recesos de un dia
	public function consultarRecesosDia($idUsuario, $dia){

		$resultado = array();
		
		$dia  			= parent::escaparQueryBDCliente($dia); 
		$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
		
		$query = "SELECT HR.idAgendaHorarioReceso, DATE_FORMAT(HR.horaInicio, '%H:%i') as horaInicio, DATE_FORMAT(HR.horaFin, '%H:%i') as horaFin, HR.idAgendaRecesosUsuario
							FROM tb_agendaHorarioReceso as HR
							
							INNER JOIN tb_agendaRecesosUsuario AS RU on RU.idAgendaRecesosUsuario = HR.idAgendaRecesosUsuario
							
							WHERE (RU.numeroDia = '$dia') AND (RU.idUsuario = '$idUsuario') AND (HR.estado = 'A') ";
		
        $conexion = parent::conexionCliente();
		
		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }

        return $resultado;	

		
	}//fin metodo consultarRecesosDia



	//metodo para inactivar un inactivarRecesoDia
	public function inactivarRecesoDia($idAgendaHorarioReceso){
		
		   $idAgendaHorarioReceso  		= parent::escaparQueryBDCliente($idAgendaHorarioReceso); 		


           $query = "UPDATE tb_agendaHorarioReceso SET estado = 'I'
           				WHERE idAgendaHorarioReceso = '$idAgendaHorarioReceso' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  

	}//fin metodo inactivarRecesoDia



/*--------------------------Fin Receso dias ----------------------*/


/*--------------------------Receso fechas ----------------------*/


	//metodo para guardar el receso de  un dia del usuario
	public function guardarRecesoFechaUsuario($idUsuario, $fecha, $horaInicio, $horaFin){
		
			$fecha  		= parent::escaparQueryBDCliente($fecha); 
			$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
			$horaInicio  	= parent::escaparQueryBDCliente($horaInicio); 
			$horaFin  		= parent::escaparQueryBDCliente($horaFin); 			
            
			$resultado = "";
			
           $query = "INSERT INTO tb_agendaRecesosFechaUsuario (fecha, idUsuario) ".
                        " VALUES ('$fecha', '$idUsuario') ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
					$query2	= "SELECT MAX(idAgendaRecesosFechaUsuario) as ultimoIdRecesoFechaUsuario FROM tb_agendaRecesosFechaUsuario";
			
					if($res2 = $conexion->query($query2)){
			           
			               /* obtener un array asociativo */
			                while ($filas = $res2->fetch_assoc()) {
			                	
			                    $resultado = $filas['ultimoIdRecesoFechaUsuario'];
								
								$query3 = "INSERT INTO tb_agendaHorarioRecesoFecha (horaInicio, horaFin, estado, idAgendaRecesosFechaUsuario)
											VALUES ('$horaInicio','$horaFin','A','$resultado')";
								
								$conexion->query($query3);
								
			                }
			            
			                /* liberar el conjunto de resultados */
			                $res2->free();
			           
			        }//fin if
            }//fin if externo
    
		
		
	}//fin metodo guardarRecesoFechaUsuario

	
	//metodo para consultar los horarios en fechas superiores a la actual
	public function consultarRecesosFechasListado($idUsuario){
		
		$resultado = array();
		
		$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
		
		$query = "SELECT 
					    RFU.idAgendaRecesosFechaUsuario,
					    RFU.fecha,
					    HR.idAgendaHorarioRecesoFecha,
					    DATE_FORMAT(HR.horaInicio, '%H:%i') horaInicio,
					    DATE_FORMAT(HR.horaFin, '%H:%i') horaFin
					FROM
					    tb_agendaRecesosFechaUsuario AS RFU
					        INNER JOIN
					    tb_agendaHorarioRecesoFecha AS HR ON HR.idAgendaRecesosFechaUsuario = RFU.idAgendaRecesosFechaUsuario
					WHERE
					    (HR.estado = 'A')
					        AND (RFU.idUsuario = '$idUsuario')
					ORDER BY RFU.fecha ASC;";
		
        $conexion = parent::conexionCliente();
		
		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] =   $filas;
                }
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }

        return $resultado;	
		
	}//fin metodo consultarRecesosFechasListado


	//metodo para inactivar un recesoFecha
	public function inactivarRecesoFecha($idAgendaHorarioRecesoFecha){
		
		   $idAgendaHorarioRecesoFecha  		= parent::escaparQueryBDCliente($idAgendaHorarioRecesoFecha); 		


           $query = "UPDATE tb_agendaHorarioRecesoFecha SET estado = 'I'
           				WHERE idAgendaHorarioRecesoFecha = '$idAgendaHorarioRecesoFecha' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  

	}//fin metodo inactivarRecesoFecha



/*--------------------------Fin Receso fechas ----------------------*/	
	
	
	//metodo para guardar una cita
	public function guardarCita($fecha_cita, $hora_cita, $fechaFinCita, $horaFinCita, $duracion_citaHoras, $duracion_citaMinutos,  $estado, $observaciones, $idPaciente, $idSucursal, $tipoCita, $idPropietario){
		
		$resultado = "";
		
		$fecha_cita  				= parent::escaparQueryBDCliente($fecha_cita);
		$hora_cita  				= parent::escaparQueryBDCliente($hora_cita);
		$fechaFinCita  				= parent::escaparQueryBDCliente($fechaFinCita);
		$horaFinCita  				= parent::escaparQueryBDCliente($horaFinCita);
		$duracion_citaHoras  		= parent::escaparQueryBDCliente($duracion_citaHoras);
		$duracion_citaMinutos  		= parent::escaparQueryBDCliente($duracion_citaMinutos);		
		$estado  					= parent::escaparQueryBDCliente($estado);
		$observaciones  			= parent::escaparQueryBDCliente($observaciones);
		$idPaciente  				= parent::escaparQueryBDCliente($idPaciente);
		$idSucursal  				= parent::escaparQueryBDCliente($idSucursal);
		$tipoCita  					= parent::escaparQueryBDCliente($tipoCita);
		$idPropietario  			= parent::escaparQueryBDCliente($idPropietario);
		
		$query = "INSERT INTO tb_agendaCitas (fecha, horaInicio, fechaFin, horaFin, duracionHoras, duracionMinutos, estado, observaciones, idMascota, idSucursal, idTipoCita, idPropietario)
					VALUES
					('$fecha_cita', '$hora_cita', '$fechaFinCita','$horaFinCita','$duracion_citaHoras','$duracion_citaMinutos','$estado', '$observaciones', '$idPaciente','$idSucursal','$tipoCita','$idPropietario');";
		

		
		$conexion = parent::conexionCliente();
			
		if($res = $conexion->query($query)){
			
			$query2	= "SELECT MAX(idAgendaCita) as ultimoIdCita FROM tb_agendaCitas";
			
			if($res2 = $conexion->query($query2)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $resultado = $filas['ultimoIdCita'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
	           
	        }	
					
		}
		


		/*--------------- Replica -----------*/
		
		/*--------------- Replica -----------*/

        return $resultado;	

		
	}//fin metodo guardarCita
	
	
	
	//metodo para vincular un usuario con una cita
	public function vincularUsuarioCita($idCita, $idUsuario){
					
		$idCita  		= parent::escaparQueryBDCliente($idCita); 	
		$idUsuario  		= parent::escaparQueryBDCliente($idUsuario); 			
            
		
       $query = "INSERT INTO tb_agendaCitas_usuarios (idAgendaCita, idUsuario, estado) ".
                    " VALUES ('$idCita', '$idUsuario', 'A') ";

       
       $conexion = parent::conexionCliente();		
		
	   $res = $conexion->query($query);	
		
	}//fin metoo vincularUsuarioCita
	
	
	//metodo para consultar los eventos del calendario  de un usuario
	public function consultarEventosCalendarioUsuario($idUsuario, $fechaInicio, $fechaFin){
		
		
		$resultadoEventos = array();
		
		$idUsuario  	= parent::escaparQueryBDCliente($idUsuario); 
		/*Citas--------------------------------------------------*/
		$query = "SELECT C.idAgendaCita, C.fecha, C.horaInicio, C.fechaFin, C.horaFin, C.estado, C.observaciones, C.idMascota, C.idSucursal,
					C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					S.nombre as nombreSucursal, S.telefono1 as telefono1Sucursal, S.direccion,
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_agendaCitas_usuarios AS U on U.idAgendaCita = C.idAgendaCita
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_sucursales AS S on S.idSucursal = C.idSucursal
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  (C.estado <> 'Cancelada') AND (C.fecha BETWEEN '$fechaInicio' and '$fechaFin') AND (U.idUsuario = '$idUsuario') AND (U.estado = 'A')  ";
		
        $conexion = parent::conexionCliente();		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                			
                		$color = "";	
                		if($filas['estado'] == "inasistida"){
                			$color = "#e57373";
                		}

						if($filas['estado'] == "Atendida"){
                			$color = "#9e9e9e";
                		}
                	
                    $resultadoEventos[] =   array(
													'id'		 			 => $filas['idAgendaCita'],
													'title'		 			 => $filas['nombrePropietario']." ".$filas['apellido']." (".$filas['nombrePaciente'].")",
													'start'					 => $filas['fecha']."T".$filas['horaInicio']."-05:00",
													'end'		 			 => $filas['fechaFin']."T".$filas['horaFin']."-05:00",
													'color'					 => $color,
													'TipoCita'				 => " -".$filas['nombreTipoCita']."- ",
													'className'				 => 'cita'
												);
                    
                    
                    
                }//fin while
            
                /* liberar el conjunto de resultados */
                $res->free();           
        }
		/*Fin Citas--------------------------------------------------*/
		
		
		
		/*Horarios Semana---------------------------------------------*/
		
		$queryHorarioSemana = "SELECT idAgendaHorarioUsuario, horaInicio, horaFin, numeroDia 
								FROM tb_agendaHorarioUsuario
								WHERE idUsuario = '$idUsuario' AND estado = 'A'";
		
				if($res2 = $conexion->query($queryHorarioSemana)){
	                while ($filas2 = $res2->fetch_assoc()) {
	                		                		
						if($dia == '6'){
							$dia = '0';
						}else{
							$dia =     $filas2['numeroDia']+1; 
						}
						
						           		                	
	                    $resultadoEventos[] =   array(                   
														'id'					 => 'prueba',
														'start'					 => $filas2['horaInicio'],
														'end'		 			 => $filas2['horaFin'],
														'rendering'				 => 'background',
														'dow'					 => '['.$dia.']',
														'className'				 => 'horarioDiaSemana'
													);
	                                        
	                }//fin while
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();           
        		}
		/*Fin Horarios Semana---------------------------------------------*/
		
		
		/*recesos Semana---------------------------------------------*/
		
		$queryRecesosSemana = "SELECT 
								    ARU.idAgendaRecesosUsuario,
								    ARU.numeroDia,
								    AHR.idAgendaHorarioReceso,
								    AHR.horaInicio,
								    AHR.horaFin
								FROM
								    tb_agendaRecesosUsuario AS ARU
								        INNER JOIN
								    tb_agendaHorarioReceso AS AHR ON AHR.idAgendaRecesosUsuario = ARU.idAgendaRecesosUsuario
								WHERE
								    ARU.idUsuario = '$idUsuario' AND AHR.estado = 'A'";
		
				if($res3 = $conexion->query($queryRecesosSemana)){
	                while ($filas3 = $res3->fetch_assoc()) {
	                	
						if($dia == '6'){
							$dia = '0';
						}else{
							$dia =     $filas3['numeroDia']+1; 
						}
						                		
						           		                	
	                    $resultadoEventos[] =   array(                   
														
														'start'					 => $filas3['horaInicio'],
														'end'		 			 => $filas3['horaFin'],
														'rendering'				 => 'background',
														'color'					 => 'orange',
														'dow'					 => '['.$dia.']',
														'className'				 => 'recesoDiaSemana'
													);
	                                        
	                }//fin while
	            
	                /* liberar el conjunto de resultados */
	                $res3->free();           
        		}
		/*Fin recesos Semana---------------------------------------------*/		
		
		
		/*Horario por fechas----------------------------------------------*/
		$queryHorarioFechas = "SELECT 
								    idAgendaHorarioFechaUsuario, horaInicio, horaFin, fecha
							   FROM tb_agendaHorarioFechaUsuario
							   WHERE estado = 'A' AND idUsuario = '$idUsuario'";
		
				if($res4 = $conexion->query($queryHorarioFechas)){
	                while ($filas4 = $res4->fetch_assoc()) {
	                					                		
						           		                	
	                    $resultadoEventos[] =   array(                   
														
														'start'					 => $filas4['fecha']."T".$filas4['horaInicio']."-05:00",
														'end'		 			 => $filas4['fecha']."T".$filas4['horaFin']."-05:00",
														'rendering'				 => 'background',
														'className'				 => 'horarioFecha'
													);
	                                        
	                }//fin while
	            
	                /* liberar el conjunto de resultados */
	                $res4->free();           
        		}
		
		
		
		/*Fin horario por fechas-------------------------------------------*/
		
		
		/*recesos por fechas-------------------------------------------*/
			$queryRecesoFechas = "SELECT 
								    RFU.fecha, RF.horaInicio, RF.horaFin
							   FROM tb_agendaHorarioRecesoFecha AS RF
							   INNER JOIN tb_agendaRecesosFechaUsuario AS RFU ON RFU.idAgendaRecesosFechaUsuario = RF.idAgendaRecesosFechaUsuario
							   WHERE RF.estado = 'A' AND RFU.idUsuario = '$idUsuario'";
		
				if($res5 = $conexion->query($queryRecesoFechas)){
	                while ($filas5 = $res5->fetch_assoc()) {
	                					                		
						           		                	
	                    $resultadoEventos[] =   array(                   
														
														'start'					 => $filas5['fecha']."T".$filas5['horaInicio']."-05:00",
														'end'		 			 => $filas5['fecha']."T".$filas5['horaFin']."-05:00",
														'rendering'				 => 'background',
														'className'				 => 'recesoFecha',
														'color'					 => 'orange'
													);
	                                        
	                }//fin while
	            
	                /* liberar el conjunto de resultados */
	                $res5->free();           
        		}
		/*Fin recesos por fechas-------------------------------------------*/
		
		


        return $resultadoEventos;	

		
		
	}//fin metodo consultarCitasUsuario
	
	
	//metodo para consultar los datos de una cita
	public function consultarDatosCita($idCita){
		

		$resultadoCita = array();
		
		$idCita  	= parent::escaparQueryBDCliente($idCita); 
		
		$query = "SELECT C.idAgendaCita, C.fecha, DATE_FORMAT(C.horaInicio, '%H:%i') horaInicio, C.fechaFin, C.horaFin, C.duracionHoras, C.duracionMinutos, C.estado, 
					C.observaciones, C.idMascota, C.idSucursal,C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					S.nombre as nombreSucursal, S.telefono1 as telefono1Sucursal, S.direccion,
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_agendaCitas_usuarios AS U on U.idAgendaCita = C.idAgendaCita
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_sucursales AS S on S.idSucursal = C.idSucursal
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  C.idAgendaCita = '$idCita' LIMIT 1";
		
        $conexion = parent::conexionCliente();		
	
		if($res = $conexion->query($query)){
                while ($filas = $res->fetch_assoc()) {
                		$resultadoCita[] = $filas;
                	}//fin while
                	
                }//fin if	
                
                
         return $resultadoCita;	
		
		
	}//fin metodo consultarDatosCita
	
	
	//metodo para consultar los usuarios vinculados con una cita
	public function consultarUsuariosCita($idCita){
				
		$resultado = array();
		
		$idCita  	= parent::escaparQueryBDCliente($idCita); 	
			
		$query = "SELECT UC.idUsuario, U.identificacion, U.nombre, U.apellido				
					
					FROM tb_agendaCitas_usuarios as UC					
					
					INNER JOIN tb_usuarios AS U on U.idUsuario = UC.idUsuario
					
					WHERE  UC.idAgendaCita = '$idCita' AND UC.estado = 'A' ";
	
		
        $conexion = parent::conexionCliente();		
	
		if($res = $conexion->query($query)){
            while ($filas = $res->fetch_assoc()) {
            		$resultado[] = $filas;
            	}//fin while
            	
          }//fin if	
                
                
         return $resultado;	
		
		
	}//fin metodo consultarUsuariosCita
	
	
	//metodo para editar una cita
	public function editarCita($idCita, $fecha_cita, $hora_cita, $fechaFinCita, $horaFinCita, $duracion_citaHoras, $duracion_citaMinutos, $observaciones, $tipoCita){
		
		$idCita  					= parent::escaparQueryBDCliente($idCita);
		$fecha_cita  				= parent::escaparQueryBDCliente($fecha_cita);
		$hora_cita  				= parent::escaparQueryBDCliente($hora_cita);
		$fechaFinCita  				= parent::escaparQueryBDCliente($fechaFinCita);
		$horaFinCita  				= parent::escaparQueryBDCliente($horaFinCita);
		$duracion_citaHoras  		= parent::escaparQueryBDCliente($duracion_citaHoras);
		$duracion_citaMinutos  		= parent::escaparQueryBDCliente($duracion_citaMinutos);		
		$observaciones  			= parent::escaparQueryBDCliente($observaciones);
		$tipoCita  					= parent::escaparQueryBDCliente($tipoCita);
		
		$query = "UPDATE tb_agendaCitas SET 
					fecha = '$fecha_cita',
					horaInicio = '$hora_cita',
					fechaFin = '$fechaFinCita',
					horaFin = '$horaFinCita',
					duracionHoras = '$duracion_citaHoras',
					duracionMinutos = '$duracion_citaMinutos',
					observaciones = '$observaciones',
					idTipoCita = '$tipoCita'
					WHERE idAgendaCita = '$idCita'";

		$conexion = parent::conexionCliente();
			
		$res = $conexion->query($query);
		
	}//fin metodo editarCita
	
	
	//metodo para desactivar todos los vinculos de usuarios con una cita
	public function incativarTodosVinculosUsuarioCita($idCita){
		
		$idCita  					= parent::escaparQueryBDCliente($idCita);	
		
		$query = "UPDATE tb_agendaCitas_usuarios SET 
					estado = 'I'
					WHERE idAgendaCita = '$idCita'";

		$conexion = parent::conexionCliente();
			
		$res = $conexion->query($query);
		
		
	}//fin incativarTodosVinculosUsuarioCita
	
	
	//metodo para verificar que existea el vinculo de un usuario con una cita
	public function consultarVinculoCita($idCita, $idUsuario){
				
		$resultado = 0;
		
		$idCita  					= parent::escaparQueryBDCliente($idCita);	
		$idUsuario  				= parent::escaparQueryBDCliente($idUsuario);	
		
		$conexion = parent::conexionCliente();
		
		$query = "SELECT idAgendaCitasUsuarios 
					FROM tb_agendaCitas_usuarios 
					WHERE idAgendaCita = '$idCita' AND idUsuario = '$idUsuario'";
					
		if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['idAgendaCitasUsuarios'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }	
			
			
		return $resultado;
		
	}//fin metodo consultarVinculoCita
	
	
	//metodo para actualizar un solo vinculo de un usuairo con una cita
	public function actualizarVinculoUsuarioCita($idCita, $idUsuario){
		
		$idCita  					= parent::escaparQueryBDCliente($idCita);	
		$idUsuario  				= parent::escaparQueryBDCliente($idUsuario);	
		
		$conexion = parent::conexionCliente();
		
		$query = "UPDATE tb_agendaCitas_usuarios 
					SET estado = 'A'
					WHERE idAgendaCita = '$idCita' AND idUsuario = '$idUsuario'";
		
		$res = $conexion->query($query);
		
	}//fin metodo actualizarVinculoUsuarioCita
	
	
	
	//metodo para realizar la busqueda de citas
	public function buscarCitas($idPropietario, $fechaInicial, $fechaFinal){
		
		$idPropietario  				= parent::escaparQueryBDCliente($idPropietario);
		$fechaInicial  					= parent::escaparQueryBDCliente($fechaInicial);
		$fechaFinal  					= parent::escaparQueryBDCliente($fechaFinal);
		
		$resultado = array();
		
		if ($fechaInicial != "" AND $fechaFinal != "") {
			
			$query = "SELECT C.idAgendaCita, C.fecha, DATE_FORMAT(C.horaInicio, '%H:%i') horaInicio, C.fechaFin, C.horaFin, C.duracionHoras, C.duracionMinutos, C.estado, 
					C.observaciones, C.idMascota, C.idSucursal,C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  C.idPropietario = '$idPropietario' AND C.fecha BETWEEN '$fechaInicial' and '$fechaFinal' ";
			
		}

		if($fechaInicial != "" AND $fechaFinal == ""){
			$query = "SELECT C.idAgendaCita, C.fecha, DATE_FORMAT(C.horaInicio, '%H:%i') horaInicio, C.fechaFin, C.horaFin, C.duracionHoras, C.duracionMinutos, C.estado, 
					C.observaciones, C.idMascota, C.idSucursal,C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  C.idPropietario = '$idPropietario' AND C.fecha >= '$fechaInicial'";
		}
		
		if($fechaInicial == "" AND $fechaFinal != ""){
			$query = "SELECT C.idAgendaCita, C.fecha, DATE_FORMAT(C.horaInicio, '%H:%i') horaInicio, C.fechaFin, C.horaFin, C.duracionHoras, C.duracionMinutos, C.estado, 
					C.observaciones, C.idMascota, C.idSucursal,C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  C.idPropietario = '$idPropietario' AND C.fecha <= '$fechaFinal'";
		}		

		if($fechaInicial == "" AND $fechaFinal == ""){
			$query = "SELECT C.idAgendaCita, C.fecha, DATE_FORMAT(C.horaInicio, '%H:%i') horaInicio, C.fechaFin, C.horaFin, C.duracionHoras, C.duracionMinutos, C.estado, 
					C.observaciones, C.idMascota, C.idSucursal,C.idTipoCita, C.idPropietario,
					M.nombre as nombrePaciente, 
					TC.nombre as nombreTipoCita,
					P.identificacion, P.nombre as nombrePropietario, P.apellido, P.telefono, P.celular, P.email
					
					
					FROM tb_agendaCitas as C					
					
					INNER JOIN tb_mascotas as M on M.idMascota = C.idMascota
					INNER JOIN tb_propietarios AS P on P.idPropietario = C.idPropietario
					LEFT JOIN tb_tiposCita AS TC on TC.idTipoCita = C.idTipoCita
					
					WHERE  C.idPropietario = '$idPropietario'";
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


		
	} //fin metodo buscarCitas
	
	
	//metodo para cancelar una cita
	public function cancelarCita($idCita, $idUsuario, $motivo){
					
		$idCita  					= parent::escaparQueryBDCliente($idCita);
		$idUsuario  				= parent::escaparQueryBDCliente($idUsuario);
		$motivo  					= parent::escaparQueryBDCliente($motivo);		
			
		$query = "UPDATE tb_agendaCitas SET estado = 'Cancelada', idUsuarioCancela = '$idUsuario', motivoCancelacion = '$motivo'
					WHERE idAgendaCita = '$idCita'";
			
		$conexion = parent::conexionCliente();
							
		$res = $conexion->query($query);
			
					
	}//fin metodo 	cancelarCita
	

}//fin clase


?>