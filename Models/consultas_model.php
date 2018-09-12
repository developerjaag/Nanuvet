<?php
	if(!isset($_SESSION)){
		    session_start();
		}

/**
 * Clase para manipular y administrar los datos de las consultas
 */
class consultas extends Config {
	
    //metodo para contar la cantidad de consultas de u n paciente
    public function tatalConsultas($idPaciente){        	

		$idPaciente	= parent::escaparQueryBDCliente($idPaciente);

		$resultado = array();
		
		$query = "Select count(idConsulta) as cantidadConsultas from tb_consultas WHERE idMascota = '$idPaciente' ";
		
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
		
		
    }//fin metodo tatalConsultas
	


        //metodo para listar las consultas
        public function listarConsultas($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			$resultado = array();
		
			$query = " SELECT C.idConsulta, C.fecha, DATE_FORMAT(C.hora, '%H:%i') as hora, C.motivo, C.observaciones, C.planASeguir, C.edadActualMascota, 
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido,
							EF.idExamenFisico, EF.peso, EF.medidaCm, EF.observaciones as observacionesExamenFisico, EF.temperatura
			
						FROM tb_consultas AS C
						
						 INNER JOIN tb_sucursales AS S ON S.idSucursal = C.idSucursal
						 INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario
						 
						 LEFT JOIN tb_examenFisico AS EF ON C.idConsulta = EF.idConsulta						 
						
						WHERE C.idMascota = '$idPaciente' ORDER BY C.idConsulta DESC
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
			
			
        }//fin metodo listarConsultas	
        
        
        //metodo para consultar los diagnosticos de una consulta
        public function consultarDxsConsulta($idConsulta){
        				
        	$resultado = array();
		
			$query = " SELECT PDX.nombre, PDX.codigo, PDX.observacion as observacionItemDX
						FROM tb_consultas_diagnosticos AS CDX 
					  INNER JOIN tb_panelDiagnosticoConsulta AS PDX ON PDX.idPanelDiagnosticoConsulta = CDX.idPanelDiagnosticoConsulta
					   WHERE  CDX.idConsulta = '$idConsulta'";
						
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
        
        //metodo para consultar los items adicionales en examen fisico
        public function consultarItemsExamenFisico($idExamenFisico){
        	
			$resultado = array();
		
			$query = " SELECT IEF.nombre, IEF.observacion, IEF.estadoRevision
						FROM tb_itemsExamenFisico AS IEF
						INNER JOIN tb_examenFisico AS EF ON EF.idExamenFisico = IEF.idExamenFisico
						WHERE EF.idExamenFisico = '$idExamenFisico'";
						
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
			
			
        }//fin metodo consultarItemsExamenFisico
	
	
		
	//metodo para guardar una consulta
	public function guardarConsulta($motivoConsulta, $observaciones, $plan, $edadActual, $idPaciente, $idUsuario, $idSucursal, $idPacienteReplica){
		
		
		$resultado = array();
		
		$motivoConsulta 		= parent::escaparQueryBDCliente($motivoConsulta);
		$observaciones 			= parent::escaparQueryBDCliente($observaciones);
		$plan 					= parent::escaparQueryBDCliente($plan);
		$edadActual 			= parent::escaparQueryBDCliente($edadActual);
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		$idUsuario 				= parent::escaparQueryBDCliente($idUsuario);
		$idSucursal 			= parent::escaparQueryBDCliente($idSucursal);
		$idPacienteReplica		= parent::escaparQueryBDCliente($idPacienteReplica);
		
		
		$query = "INSERT INTO tb_consultas (fecha,hora,motivo,observaciones,planASeguir,edadActualMascota,idMascota,idUsuario,idSucursal)
					VALUES
					(NOW(),NOW(),'$motivoConsulta','$observaciones','$plan','$edadActual','$idPaciente','$idUsuario','$idSucursal');";
		
	
		
		$conexion = parent::conexionCliente();
			
		if($res = $conexion->query($query)){
			
			$query2	= "SELECT MAX(idConsulta) as ultimoIdConsulta FROM tb_consultas";
			
			if($res2 = $conexion->query($query2)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $resultado[] = $filas['ultimoIdConsulta'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
	           
	        }	
					
		}
		
		
		/*--------------- Replica -----------*/
		

		$nombreSucursal = $_SESSION['sucursalActual_nombreSucursal'];
		
		$nombreMedico = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];		
		
		$queryR1 = "INSERT INTO tb_consultas (fecha,hora,motivo,observaciones,planASeguir,edadActualMascota,idMascota,medico,nombreSucursal)
					VALUES
					(NOW(),NOW(),'$motivoConsulta','$observaciones','$plan','$edadActual','$idPacienteReplica','$nombreMedico','$nombreSucursal');";
		
	
		
		$conexionReplica = parent::conexionReplica();

		
		if($resR = $conexionReplica->query($queryR1)){
			
			$queryR2	= "SELECT MAX(idConsulta) as ultimoIdConsulta FROM tb_consultas";
			
			if($resR2 = $conexionReplica->query($queryR2)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $resR2->fetch_assoc()) {
	                    $resultado[] = $filas['ultimoIdConsulta'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $resR2->free();
          			
			}	
 
        }			
		/*--------------- Replica -----------*/

        return $resultado;	
		
		
	}//fin metodo guardarConsulta
	
	
	//metodo para guardar los dxs de las consultas
	public function guardarDxConsulta($selectedDX,$idConsultaGuardada, $idConsultaGuardadaReplica){
		
		$selectedDX 		= parent::escaparQueryBDCliente($selectedDX);
		
		$query = "INSERT INTO tb_consultas_diagnosticos (idConsulta,idPanelDiagnosticoConsulta)
			VALUES
			('$idConsultaGuardada','$selectedDX');";
			
		
		$conexion = parent::conexionCliente();
			
		$res = $conexion->query($query);

		
		/*--------- Replica -------------*/
		$queryConsulta = "SELECT nombre from  tb_panelDiagnosticoConsulta WHERE idPanelDiagnosticoConsulta = '$selectedDX' ";
		
			if($res2 = $conexion->query($queryConsulta)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $nombreDX = $filas['nombre'];
	                }
	            
	        }
			
			//insertar dx en replica
			
		$queryReplica = "INSERT INTO tb_diagnosticosConsulta (nombreDiagnostico, idConsulta)
							VALUES
						('$nombreDX','$idConsultaGuardadaReplica');";
		
		$conexionReplica = parent::conexionReplica();
		
		$resReplica = $conexionReplica->query($queryReplica);
		
		/*--------- Replica -------------*/
				
		
	}//fin metodo guardarDxConsulta
	
	
	
	
	//metodo para guardar el examen fisico
	public function guardarExamenFisico($peso, $altura, $temperatura, $observacionesExamenFisico, $idConsultaGuardada, $idConsultaGuardadaReplica){
		
		$resultado = array();
		
		$peso 							= parent::escaparQueryBDCliente($peso);
		$altura 						= parent::escaparQueryBDCliente($altura);
		$temperatura 					= parent::escaparQueryBDCliente($temperatura);
		$observacionesExamenFisico 		= parent::escaparQueryBDCliente($observacionesExamenFisico);
		
		
		$query = "INSERT INTO tb_examenFisico (peso,medidaCm,temperatura,observaciones,idConsulta)
					VALUES
					('$peso','$altura','$temperatura','$observacionesExamenFisico','$idConsultaGuardada');";
		
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);
		
		$query2	= "SELECT MAX(idExamenFisico) as ultimoIdExamenFisico FROM tb_examenFisico";
		
		if($res2 = $conexion->query($query2)){
           
               /* obtener un array asociativo */
                while ($filas = $res2->fetch_assoc()) {
                    $resultado[] = $filas['ultimoIdExamenFisico'];
                }
            
                /* liberar el conjunto de resultados */
                $res2->free();
           
        }
		
		
		/*---------Replica ------------*/
		
		$queryReplica	= "INSERT INTO tb_examenFisico (peso,medidaCm,temperatura,observaciones,idConsulta)
					VALUES
					('$peso','$altura','$temperatura','$observacionesExamenFisico','$idConsultaGuardadaReplica');";
		
		$conexionReplica = parent::conexionReplica();	
				
		$resReplica = $conexionReplica->query($queryReplica);

		$queryReplica2	= "SELECT MAX(idExamenFisico) as ultimoIdExamenFisico FROM tb_examenFisico";
		
		if($resReplica2 = $conexionReplica->query($queryReplica2)){
           
               /* obtener un array asociativo */
                while ($filas = $resReplica2->fetch_assoc()) {
                    $resultado[] = $filas['ultimoIdExamenFisico'];
                }
            
                /* liberar el conjunto de resultados */
                $resReplica2->free();
           
        }		
		
				
		/*---------Replica ------------*/
		

        return $resultado;			
		
		
	}//fin metodo 
	
	
	
	//metodo para guardar un item adicional en examen fisico
	public function guardarItemAdicionalExamenFisico($nombre,$observacion,$estadoRevision,$idExamenFisicoGuardado, $idExamenFisicoGuardadoReplica){
		
		$nombre 							= parent::escaparQueryBDCliente($nombre);
		$observacion 						= parent::escaparQueryBDCliente($observacion);
		$estadoRevision 					= parent::escaparQueryBDCliente($estadoRevision);
		
		
		$query = "INSERT INTO tb_itemsExamenFisico (nombre,observacion,estadoRevision,idExamenFisico)
					VALUES
					('$nombre','$observacion','$estadoRevision','$idExamenFisicoGuardado');";
		
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);
		
		
		/*---- Replica ---------------*/
		$queryReplica = "INSERT INTO tb_itemsExamenFisico (nombre,observacion,estadoRevision,idExamenFisico)
					VALUES
					('$nombre','$observacion','$estadoRevision','$idExamenFisicoGuardadoReplica');";
		
		$conexionReplica = parent::conexionReplica();			
		$resReplica = $conexionReplica->query($queryReplica);		
		/*---- Replica ---------------*/
		
		
	}//fin metodo guardarItemAdicionalExamenFisico
	
	
	
	//consultar la informacion de una sola consulta
	public function listarUnaConsulta($idConsulta){
		$resultado = array();
		
			$query = " SELECT C.idConsulta, C.fecha, C.hora, C.motivo, C.observaciones, C.planASeguir, C.edadActualMascota, C.idMascota,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido,
							EF.idExamenFisico, EF.peso, EF.medidaCm, EF.observaciones as observacionesExamenFisico, EF.temperatura
			
						FROM tb_consultas AS C
						
						 INNER JOIN tb_sucursales AS S ON S.idSucursal = C.idSucursal
						 INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario
						 
						 LEFT JOIN tb_examenFisico AS EF ON C.idConsulta = EF.idConsulta						 
						
						WHERE C.idConsulta = '$idConsulta' ";
						
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
	}//fin metodo listarUnaConsulta
	
	//metodo para guardar un archivo adjunto
	public function guardarArchivoAdjuntoConsulta($idConsultaEnvioAdjunto, $nombreArchivo, $peso, $idUsuario){
				
		$idConsultaEnvioAdjunto 			= parent::escaparQueryBDCliente($idConsultaEnvioAdjunto);
		$nombreArchivo 						= parent::escaparQueryBDCliente($nombreArchivo);
		
		
		$query = "INSERT INTO tb_adjuntosConsulta (fecha,urlArchivo,pesoArchivo,idConsulta, idUsuario)
					VALUES
					(NOW(),'$nombreArchivo','$peso','$idConsultaEnvioAdjunto', '$idUsuario');";
		
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);
					
		
	}//guardarArchivoAdjuntoConsulta
	
	
	//consultar los archivos adjuntos de una consulta
	public function consultarAdjuntosConsulta($idConsulta){
		
		$resultado = array();
		
			$query = " SELECT A.idAdjuntoConsulta, A.fecha, A.urlArchivo, A.pesoArchivo, A.idConsulta,
							U.nombre, U.apellido, U.identificacion 
						FROM tb_adjuntosConsulta as A 
						INNER JOIN tb_usuarios as U ON A.idUsuario = U.idUsuario
					   WHERE idConsulta = '$idConsulta'";
						
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
		
	}//fin metodo consultarAdjuntosConsulta

	
	//metodo para consultar la informacion de las notas aclaratorias de una consulta
	public function consultarNotasAclaratorias($idConsulta){
		
			$resultado = array();
		
			$query = " SELECT N.idConsultaNotaAclaratoria, N.texto, N.fecha, U.nombre, U.apellido, U.identificacion
						FROM tb_consultasNotasAclaratorias as N 
						INNER JOIN tb_usuarios as U ON N.idUsuario = U.idUsuario
					   WHERE idConsulta = '$idConsulta' order by N.idConsultaNotaAclaratoria DESC";
		
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
		
	}//fin consultarNotasAclaratorias
	
	
	//metodo para guardar una nota aclaratoria
	public function guardarNotaAclaratoria($idConsulta, $textoNota, $idUsurio){
		
				
		$idConsulta 			= parent::escaparQueryBDCliente($idConsulta);
		$textoNota 				= parent::escaparQueryBDCliente($textoNota);
		
		
		$query = "INSERT INTO tb_consultasNotasAclaratorias (texto,fecha,hora,idConsulta, idUsuario)
					VALUES
					('$textoNota',NOW(),NOW(),'$idConsulta','$idUsurio');";

		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);		
		
	}//fin metodo guardarNotaAclaratoria
	

		
	//metodo para relacionar una consulta con una hospitalizacion
	public function relacionarConsultaHospitalizacion($idConsulta, $idHospitalizacion){
						
					
		$query = "INSERT INTO tb_ConsultaHospitalzacion (idHospitalizacion,idConsulta)
					VALUES
					('$idHospitalizacion','$idConsulta');";
	
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);					
			
		
	}//fin metodo relacionarConsultaHospitalizacion	
		
	
//consultar las consultas que no se encuentren relacionadas con hospitalizacion
	public function consultasNoHospitalizacion($idPaciente){
		
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "SELECT 
					    idConsulta, fecha, hora
					FROM
					    tb_consultas
					WHERE
					    idConsulta NOT IN (SELECT 
					            idConsulta
					        FROM
					            tb_ConsultaHospitalzacion)
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
		
	}
		
	
	
}//fin clase



?>