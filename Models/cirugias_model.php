<?php
	if(!isset($_SESSION)){
		    session_start();
		}
/**
 * Clae para los datos de las cirugias
 */
class cirugias extends Config {
	
    //metodo para contar la cantidad de cirugias de un paciente
    public function tatalCirugias($idPaciente){        	

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
		
		
    }//fin metodo tatalCirugias


        //metodo para listar las cirugias
        public function listarCirugias($idPaciente,$paginaActual,$records_per_page){
        	
			$idPaciente	= parent::escaparQueryBDCliente($idPaciente);
			
			$resultado = array();
		
			$query = " SELECT C.idCirugia, C.fecha, DATE_FORMAT(C.hora, '%H:%i') as hora, C.tipoAnestesia, C.motivo, C.complicaciones, C.observaciones, C.planASeguir, C.edadActualMascota, 
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
			
						FROM tb_cirugias AS C
						
						 INNER JOIN tb_sucursales AS S ON S.idSucursal = C.idSucursal
						 INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario					 
						
						WHERE C.idMascota = '$idPaciente' ORDER BY C.idCirugia DESC
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
			
			
        }//fin metodo listarCirugias	


        //metodo para consultar los diagnosticos de una cirugia
        public function consultarDxsCirugia($idCirugia){
        				
        	$resultado = array();
		
			$query = " SELECT PDX.nombre, PDX.codigo, PDX.observacion as observacionItemDX
						FROM tb_diagnosticosCirugias AS CDX 
					  INNER JOIN tb_panelesCirugiaDiagnosticos AS PDX ON PDX.idPanelCirugiaDiagnostico = CDX.idPanelCirugiaDiagnostico
					   WHERE  CDX.idCirugia = '$idCirugia'";
						
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
        		
        	
        }//fin metodo consultarDxsCirugia


	//consultar los archivos adjuntos de una cirugia
	public function consultarAdjuntosCirugia($idCirugia){
		
		$resultado = array();
		
			$query = " SELECT A.idAdjuntoCirugia, A.fecha, A.urlArchivo, A.pesoArchivo, A.idCirugia,
							U.nombre, U.apellido, U.identificacion 
						FROM tb_adjuntosCirugias as A 
						INNER JOIN tb_usuarios as U ON A.idUsuario = U.idUsuario
					   WHERE A.idCirugia = '$idCirugia'";
						
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
		
	}//fin metodo consultarAdjuntosCirugia


	//metodo para guardar un archivo adjunto
	public function guardarArchivoAdjuntoCirugia($idCirugiaEnvioAdjunto, $nombreArchivo, $peso, $idUsuario){
				
		$idCirugiaEnvioAdjunto 			= parent::escaparQueryBDCliente($idCirugiaEnvioAdjunto);
		$nombreArchivo 						= parent::escaparQueryBDCliente($nombreArchivo);
		
		
		$query = "INSERT INTO tb_adjuntosCirugias (fecha,urlArchivo,pesoArchivo,idCirugia, idUsuario)
					VALUES
					(NOW(),'$nombreArchivo','$peso','$idCirugiaEnvioAdjunto', '$idUsuario');";
		
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);
					
		
	}//guardarArchivoAdjuntoCirugia


		
	//metodo para guardar una cirugia
	public function guardarCirugia($motivoCirugia, $observaciones, $tipoAnestesia, $complicaciones, $plan, $edadActual, $idPaciente, $idUsuario, $idSucursal, $idPacienteReplica){
		
		
		$resultado = array();
		
		$motivoCirugia 			= parent::escaparQueryBDCliente($motivoCirugia);
		$observaciones 			= parent::escaparQueryBDCliente($observaciones);
		$complicaciones 		= parent::escaparQueryBDCliente($complicaciones);
		$plan 					= parent::escaparQueryBDCliente($plan);
		$edadActual 			= parent::escaparQueryBDCliente($edadActual);
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		$idUsuario 				= parent::escaparQueryBDCliente($idUsuario);
		$idSucursal 			= parent::escaparQueryBDCliente($idSucursal);
		$idPacienteReplica 		= parent::escaparQueryBDCliente($idPacienteReplica);
		
		
		$query = "INSERT INTO tb_cirugias (fecha,hora,fechaFin,horaFin,tipoAnestesia, motivo, complicaciones, observaciones,planASeguir,edadActualMascota,idMascota,idUsuario,idSucursal)
					VALUES
					(NOW(),NOW(),NOW(),NOW(),'$tipoAnestesia','$motivoCirugia','$complicaciones','$observaciones','$plan','$edadActual','$idPaciente','$idUsuario','$idSucursal');";
		
	
		
		$conexion = parent::conexionCliente();
			
		if($res = $conexion->query($query)){
			
			$query2	= "SELECT MAX(idCirugia) as ultimoIdCirugia FROM tb_cirugias";
			
			if($res2 = $conexion->query($query2)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $resultado[] = $filas['ultimoIdCirugia'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res2->free();
          			
			}	
 
        }


		$nombreSucursal = $_SESSION['sucursalActual_nombreSucursal'];
		
		$nombreMedico = $_SESSION['usuario_nombre']." ".$_SESSION['Usuario_Apellido'];
		
		$queryR1 = "INSERT INTO tb_cirugias (fecha,hora,fechaFin,horaFin,tipoAnestesia, motivo, complicaciones, observaciones,planASeguir,edadActualMascota,medico,nombreSucursal,idMascota)
					VALUES
					(NOW(),NOW(),NOW(),NOW(),'$tipoAnestesia','$motivoCirugia','$complicaciones','$observaciones','$plan','$edadActual','$nombreMedico','$nombreSucursal','$idPacienteReplica');";
		
	
		
		$conexionReplica = parent::conexionReplica();

		
		if($resR = $conexionReplica->query($queryR1)){
			
			$queryR2	= "SELECT MAX(idCirugia) as ultimoIdCirugia FROM tb_cirugias";
			
			if($resR2 = $conexionReplica->query($queryR2)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $resR2->fetch_assoc()) {
	                    $resultado[] = $filas['ultimoIdCirugia'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $resR2->free();
          			
			}	
 
        }		
		
        return $resultado;	
		
		
	}//fin metodo guardarCirugia
	

	//metodo para guardar los dxs de las cirugias
	public function guardarDxCirugia($selectedDX,$idCirugiaGuardada, $idCirugiaGuardadaReplica){
				
		$nombreDX = "";	
		
		$selectedDX 		= parent::escaparQueryBDCliente($selectedDX);
		
		$query = "INSERT INTO tb_diagnosticosCirugias (idCirugia,idPanelCirugiaDiagnostico)
			VALUES
			('$idCirugiaGuardada','$selectedDX');";
			
		
		$conexion = parent::conexionCliente();
			
		$res = $conexion->query($query);
		
		/*--------- Replica -------------*/
		$queryConsulta = "SELECT nombre from  tb_panelesCirugiaDiagnosticos WHERE idPanelCirugiaDiagnostico = '$selectedDX' ";
		
			if($res2 = $conexion->query($queryConsulta)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res2->fetch_assoc()) {
	                    $nombreDX = $filas['nombre'];
	                }
	            
	        }
			
			//insertar dx en replica
			
		$queryReplica = "INSERT INTO tb_diagnosticosCirugias (nombreDiagnostico, idCirugia)
							VALUES
						('$nombreDX','$idCirugiaGuardadaReplica');";
		
		$conexionReplica = parent::conexionReplica();
		
		$resReplica = $conexionReplica->query($queryReplica);
		
		/*--------- Replica -------------*/
		
		
	}//fin metodo guardarDxCirugia

	
	//metodo para guardar una nota aclaratoria
	public function guardarNotaAclaratoria($idCirugia, $textoNota, $idUsurio){
		
				
		$idCirugia 			= parent::escaparQueryBDCliente($idCirugia);
		$textoNota 			= parent::escaparQueryBDCliente($textoNota);
		
		
		$query = "INSERT INTO tb_cirugiasNotasAclaratorios (texto,fecha,hora,idCirugia, idUsuario)
					VALUES
					('$textoNota',NOW(),NOW(),'$idCirugia','$idUsurio');";

		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);		
		
	}//fin metodo guardarNotaAclaratoria	
	
	
	
	//metodo para consultar la informacion de las notas aclaratorias de una cirugia
	public function consultarNotasAclaratorias($idCirugia){
		
			$resultado = array();
		
			$query = " SELECT N.idCirugiaNotaAclaratoria, N.texto, N.fecha, U.nombre, U.apellido, U.identificacion
						FROM tb_cirugiasNotasAclaratorios as N 
						INNER JOIN tb_usuarios as U ON N.idUsuario = U.idUsuario
					   WHERE idCirugia = '$idCirugia' order by N.idCirugiaNotaAclaratoria DESC";
		
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
	

	
	//consultar la informacion de una sola cirugia
	public function listarUnaCirugia($idCirugia){
		$resultado = array();
		
			$query = "  SELECT C.idCirugia, C.fecha, C.hora, C.tipoAnestesia, C.motivo, C.complicaciones, C.observaciones, C.planASeguir, C.edadActualMascota,  C.idMascota,
							S.nombre as nombreSucursal, 
							U.identificacion, U.nombre as nombreUsuario, U.apellido
			
						FROM tb_cirugias AS C
												
						 INNER JOIN tb_sucursales AS S ON S.idSucursal = C.idSucursal
						 INNER JOIN tb_usuarios AS U ON U.idUsuario = C.idUsuario					 
						
						WHERE C.idCirugia = '$idCirugia' ";
						
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
			
	}//fin metodo listarUnaCirugia	
	
		
	//metodo para relacionar una cirugia con una hospitalizacion
	public function relacionarCirugiaHospitalizacion($idCirugiaGuardada, $idHospitalizacion){
						
					
		$query = "INSERT INTO tb_cirugia_hospitalizacion (idHospitalizacion,idCirugia)
					VALUES
					('$idHospitalizacion','$idCirugiaGuardada');";
	
		$conexion = parent::conexionCliente();			
		$res = $conexion->query($query);					
			
		
	}//fin metodo relacionarCirugiaHospitalizacion
	
	
	//consultar las cirugias que no se encuentren relacionadas con hospitalizacion
	public function cirugiasNoHospitalizacion($idPaciente){
		
		$idPaciente 			= parent::escaparQueryBDCliente($idPaciente);
		
		$resultado = array();
		
		$query = "SELECT 
					    idCirugia, fecha, hora
					FROM
					    tb_cirugias
					WHERE
					    idCirugia NOT IN (SELECT 
					            idCirugia
					        FROM
					            tb_cirugia_hospitalizacion)
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
		
	}//fin metodo cirugiasNoHospitalizacion
	
}//fin clase


?>