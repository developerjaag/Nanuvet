<?php

/**
 * Clase para controlar todos los datos de los reportes
 */
class reportes extends Config {
	
/*---------------Gerenciales--------------*/	

	//metodo para consultar el total de las citas
	public function gerencial_totalCitas($fechaInicio = "", $fechaFin = "", $estado = ""){
		
		$resultado 		= 0;
		$adicionQuery	= "";
		
		if($fechaInicio != "" AND $fechaFin != ""){
			$adicionQuery = "AND ( fecha BETWEEN '$fechaInicio' AND '$fechaFin') "; 
		}
		
		if($estado != ""){
			$adicionQuery .= " AND estado = '$estado'";
		}
		
			$query = "SELECT 
						    COUNT(idAgendaCita) AS totalCitas
						FROM
						    tb_agendaCitas
						WHERE
						    1 ".$adicionQuery;
		
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['totalCitas'];
            }                
               
         }//fin if
		
        return $resultado;	
		
		
	}//in metodo gerencial_totalCitas
	
	
	//metodo para sacar totalescon tabla y id dinamico
	public function gerencial_Totales($idCampo, $nombreTabla, $fechaInicial = "", $fechaFinal = "", $nombreFecha = "fecha"){
		
		$resultado 		= 0;
		$adicionQuery	= "";
		
		if($fechaInicial != "" AND $fechaFinal != ""){
			$adicionQuery = "AND ( $nombreFecha BETWEEN '$fechaInicial' AND '$fechaFinal') "; 
		}
		
		
			$query = "SELECT 
						    COUNT($idCampo) AS total
						FROM
						    $nombreTabla
						WHERE
						    1 ".$adicionQuery;

		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['total'];
            }                
               
         }//fin if
		
        return $resultado;	
		
		
	}//fin metodo gerencial_Totales

	
	//valor inventario 
	public function gerencial_valorInventario(){
		
		$resultado = 0;
		
		$query = "SELECT cantidad, idProducto
						FROM
						    tb_productos_sucursal";
		
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
            	
				$idproducto = $filas['idProducto'];
				$cantidad	= $filas['cantidad']; 
				
				$query2 = "SELECT precio 
							FROM  tb_productos WHERE idProducto = '$idproducto'";
							
						if($res2 = $conexion->query($query2)){
							
								 while ($filas2 = $res2->fetch_assoc()) {
								 	
									$precio = str_replace('.', '',$filas2['precio']);
									
									$subtotal = $precio * $cantidad;
									 
									 $resultado = $resultado + $subtotal;
									
								 }	
							
						}	
				
            }                
               
         }//fin if
		
        return $resultado;	
		
	} //fin metodo gerencial_valorInventario

/*---------------Fin Gerenciales--------------*/	



/*---------------Citas--------------*/


        //metodo para contar la cantidad de citas
        public function citas_tatalCitas(){        	

			$resultado = array();
			
			$query = "Select count(idAgendaCita) as cantidadCitas from tb_agendaCitas ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadCitas'];			
			
			
        }//fin metodo citas_tatalCitas 
        
        
        //metodo para listar las citas
        public function citas_listarCitas($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    C.idAgendaCita,
						    C.fecha,
						    DATE_FORMAT(C.horaInicio, '%H:%i') as horaInicio,
						    C.fechaFin,
						    DATE_FORMAT(C.horaFin, '%H:%i') as horaFin,
						    C.duracionHoras,
						    C.duracionMinutos,
						    C.estado,
						    C.observaciones,
						    C.motivoCancelacion,
						    C.idUsuarioCancela,
						    C.idMascota,
						    C.idSucursal,
						    C.idTipoCita,
						    C.idPropietario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario,
    						TC.nombre AS nombreTipoCita
						FROM
						    tb_agendaCitas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = C.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        LEFT JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuarioCancela
						        LEFT JOIN
						    tb_tiposCita AS TC ON TC.idTipoCita = C.idTipoCita
						ORDER BY (C.idAgendaCita) DESC
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
			
			
        }//fin metodo citas_listarCitas    
        
        //metodo para consultar los usuarios asignados a una cita
        public function citas_usuariosCita($idCita){
        	
        	$resultado = array();
		
			$query = " SELECT UC.idAgendaCitasUsuarios,
							U.identificacion, U.nombre, U.apellido
						FROM tb_agendaCitas_usuarios AS UC
						INNER JOIN tb_usuarios AS U ON U.idUsuario = UC.idUsuario
						WHERE UC.estado = 'A' AND UC.idAgendaCita = '$idCita'";
						
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
        }//fin metodo   citas_usuariosCita   
        
        
        //metodo para consultar los usuarios para select de filtro citas
        public function citas_usuariosCitas(){
        	
			$resultado = array();
		
			$query = " SELECT idUsuario, identificacion, nombre, apellido
						FROM tb_usuarios";
						
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
			
        }//fin metodo citas_usuariosCitas


        //metodo para consultar los tipos cita para select de filtro citas
        public function citas_tiposCitas(){
        	
			$resultado = array();
		
			$query = " SELECT idTipoCita, nombre
						FROM tb_tiposCita";
						
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
			
        }//fin metodo citas_tiposCitas
        
        
        //metodo para aplicar filtros
        public function citas_aplicarFiltrosCitas($fechaInicial, $fechaFinal, $usuarios, $tipoCita, $idPropietario, $paciente){
        	
			$resultado = array();
			//$adicionQuery = "WHERE 1 ";
			
			if(sizeof($usuarios) > 0){
				
				
				if(sizeof($usuarios) > 1){
					$andOr = "OR";
					
				}else{
					$andOr = "AND";
				}
				
				$adicionQuery = " INNER JOIN tb_agendaCitas_usuarios AS ACU ON ACU.idAgendaCita = C.idAgendaCita  WHERE ( ";	
				
				for ($i=0; $i < sizeof($usuarios); $i++) {
					
					if($i == 0){
						$opt = "";
					}else{
						$opt = $andOr;
					}
					
					$idUsuario =  $usuarios[$i];
					$adicionQuery .= " $opt  ACU.idUsuario = '$idUsuario' ";	
					
				}
				
				$adicionQuery .= " ) AND ACU.estado = 'A'";
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			
			
			
			if($tipoCita != ""){
				
				$adicionQuery .= " AND  TC.idTipoCita = '$tipoCita' ";
			
			}
			
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    C.idAgendaCita,
						    C.fecha,
						    DATE_FORMAT(C.horaInicio, '%H:%i') as horaInicio,
						    C.fechaFin,
						    DATE_FORMAT(C.horaFin, '%H:%i') as horaFin,
						    C.duracionHoras,
						    C.duracionMinutos,
						    C.estado,
						    C.observaciones,
						    C.motivoCancelacion,
						    C.idUsuarioCancela,
						    C.idMascota,
						    C.idSucursal,
						    C.idTipoCita,
						    C.idPropietario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario,
						    TC.nombre AS nombreTipoCita
						FROM
						    tb_agendaCitas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = C.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        LEFT JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuarioCancela
						        LEFT JOIN
						    tb_tiposCita AS TC ON TC.idTipoCita = C.idTipoCita
						    
							".$adicionQuery."
						
						GROUP BY (C.idAgendaCita)
							
						ORDER BY (C.idAgendaCita) DESC; ";
						
						
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
			
			
        }//fin metodo citas_aplicarFiltrosCitas
        
        
         
     //metodo para aplicar filtros
        public function citas_TotalAplicarFiltrosCitas($fechaInicial, $fechaFinal, $usuarios, $tipoCita, $idPropietario, $paciente){
        	
			$resultado = 0;
			//$adicionQuery = "WHERE 1 ";
			if(sizeof($usuarios) > 0){
				
				
				if(sizeof($usuarios) > 1){
					$andOr = "OR";
					
				}else{
					$andOr = "AND";
				}
				
				$adicionQuery = " INNER JOIN tb_agendaCitas_usuarios AS ACU ON ACU.idAgendaCita = C.idAgendaCita  WHERE ( ";	
				
				for ($i=0; $i < sizeof($usuarios); $i++) {
					
					if($i == 0){
						$opt = "";
					}else{
						$opt = $andOr;
					}
					
					$idUsuario =  $usuarios[$i];
					$adicionQuery .= " $opt  ACU.idUsuario = '$idUsuario' ";	
					
				}
				
				$adicionQuery .= " ) AND ACU.estado = 'A'";
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			
			
			
			if($tipoCita != ""){
				
				$adicionQuery .= " AND  TC.idTipoCita = '$tipoCita' ";
			
			}
			
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    count(C.idAgendaCita) as totalRegistros
						FROM
						    tb_agendaCitas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = C.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        LEFT JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuarioCancela
						        LEFT JOIN
						    tb_tiposCita AS TC ON TC.idTipoCita = C.idTipoCita
						    
							".$adicionQuery."
						 ";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo cirugias_TotalAplicarFiltrosCirugias   

/*---------------Fin Citas--------------*/


/*---------------Cirugias--------------*/


        //metodo para contar la cantidad de cirugias
        public function cirugias_tatalCirugias(){        	

			$resultado = array();
			
			$query = "Select count(idCirugia) as cantidadCirugias from tb_cirugias ";
			
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
			
			
        }//fin metodo cirugias_tatalCirugias 
        
        
        
 //metodo para listar las cirugias
        public function cirugias_listarCirugias($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    C.idCirugia,
						    C.fecha,
						    DATE_FORMAT(C.hora, '%H:%i') as hora,
						    C.tipoAnestesia,
						    C.motivo,
						    C.complicaciones,
						    C.observaciones, 
						    C.planASeguir,
						    C.edadActualMascota,
						    C.idMascota,
						    C.idSucursal,
						    C.idUsuario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_cirugias AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						ORDER BY (C.idCirugia) DESC
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
			
			
        }//fin metodo cirugias_listarCirugias        
        
        
        //metodo para consultar los diagnosticos de una cirugia
        public function consultarDiagnosticosCirugia($idCirugia){
        				
        	$resultado = array();
		
			$query = " SELECT PDC.nombre, PDC.codigo, PDC.precio
						FROM tb_panelesCirugiaDiagnosticos as PDC
						inner join tb_diagnosticosCirugias AS DC ON DC.idPanelCirugiaDiagnostico = PDC.idPanelCirugiaDiagnostico
						
						where DC.idCirugia = '$idCirugia'
						";
						
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
        		
        	
        }//fin metodo consultarDiagnosticosCirugia
        

        
     //metodo para aplicar filtros
        public function cirugias_aplicarFiltrosCirugias($fechaInicial, $fechaFinal, $usuarios, $idCirugia, $idPropietario, $paciente){
        	
			$resultado = array();
			//$adicionQuery = "WHERE 1 ";
			
			if($idCirugia != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_diagnosticosCirugias AS DC ON DC.idCirugia = C.idCirugia
								  INNER JOIN tb_panelesCirugiaDiagnosticos AS PCD ON PCD.idPanelCirugiaDiagnostico = DC.idPanelCirugiaDiagnostico
								   WHERE PCD.idPanelCirugiaDiagnostico = '$idCirugia' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND C.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    C.idCirugia,
						    C.fecha,
						    DATE_FORMAT(C.hora, '%H:%i') as hora,
						    C.tipoAnestesia,
						    C.motivo,
						    C.complicaciones,
						    C.observaciones, 
						    C.planASeguir,
						    C.edadActualMascota,
						    C.idMascota,
						    C.idSucursal,
						    C.idUsuario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_cirugias AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						    
							".$adicionQuery."
						
						GROUP BY (C.idCirugia)
							
						ORDER BY (C.idCirugia) DESC; ";
						
						
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
			
			
        }//fin metodo cirugias_aplicarFiltrosCirugias        
        
 
 
     //metodo para aplicar filtros
        public function cirugias_TotalAplicarFiltrosCirugias($fechaInicial, $fechaFinal, $usuarios, $idCirugia, $idPropietario, $paciente){
        	
			$resultado = 0;
			//$adicionQuery = "WHERE 1 ";
			
			if($idCirugia != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_diagnosticosCirugias AS DC ON DC.idCirugia = C.idCirugia
								  INNER JOIN tb_panelesCirugiaDiagnosticos AS PCD ON PCD.idPanelCirugiaDiagnostico = DC.idPanelCirugiaDiagnostico
								   WHERE PCD.idPanelCirugiaDiagnostico = '$idCirugia' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND C.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    count(C.idCirugia) as totalRegistros
						FROM
						    tb_cirugias AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						    
							".$adicionQuery."
						 ";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo cirugias_TotalAplicarFiltrosCirugias    
        
        
        //metodo para consultar las notas aclaratorias de una cirugia
        public function consultarNotasAclaratoriasCirugia($idCirugia){
        	$resultado = array();
		
			$query = " SELECT CN.idCirugiaNotaAclaratoria, CN.texto, CN.fecha, DATE_FORMAT(CN.hora, '%H:%i') as hora, CN.idUsuario, 
								U.identificacion, U.nombre, U.apellido
			
						FROM tb_cirugiasNotasAclaratorios as CN
						
						
						inner join tb_usuarios AS U ON U.idUsuario = CN.idUsuario
						
						where CN.idCirugia = '$idCirugia'
						";
						
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
        }//fin metodo consultarNotasAclaratoriasCirugia
        
/*---------------Fin Cirugias--------------*/




/*---------------Consultas--------------*/


        //metodo para contar la cantidad de consultas
        public function consultas_tatalConsultas(){        	

			$resultado = array();
			
			$query = "Select count(idConsulta) as cantidadConsultas from tb_consultas ";
			
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
			
			
        }//fin metodo consultas_tatalConsultas 
        
        
        
 //metodo para listar las consultas
        public function consultas_listarConsultas($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    C.idConsulta,
						    C.fecha,
						    DATE_FORMAT(C.hora, '%H:%i') as hora,
						    C.motivo,
						    C.observaciones,
						    C.planASeguir,
						    C.edadActualMascota,
						    
						    EF.idExamenFisico,
						    EF.peso,
						    EF.medidaCm,
						    EF.temperatura,
						    EF.observaciones as observacionesExamenFisico,
						    
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_consultas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						    	LEFT JOIN
						    tb_examenFisico AS EF ON EF.idConsulta = C.idConsulta
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						ORDER BY (C.idConsulta) DESC
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
			
			
        }//fin metodo consultas_listarConsultas        
        
        
        //metodo para consultar los diagnosticos de una consulta
        public function consultarDiagnosticosConsulta($idConsulta){
        				
        	$resultado = array();
		
			$query = " SELECT PDC.nombre, PDC.codigo
			
						FROM tb_panelDiagnosticoConsulta as PDC
						
						inner join tb_consultas_diagnosticos AS DC ON DC.idPanelDiagnosticoConsulta = PDC.idPanelDiagnosticoConsulta
						
						where DC.idConsulta = '$idConsulta'
						";
						
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
        		
        	
        }//fin metodo consultarDiagnosticosConsulta
        

        
     //metodo para aplicar filtros
        public function consultas_aplicarFiltrosConsultas($fechaInicial, $fechaFinal, $usuarios, $idDxConsulta, $idPropietario, $paciente){
        	
			$resultado = array();
			//$adicionQuery = "WHERE 1 ";
			
			if($idDxConsulta != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_consultas_diagnosticos AS DC ON DC.idConsulta = C.idConsulta
								  INNER JOIN tb_panelDiagnosticoConsulta AS PCD ON PCD.idPanelDiagnosticoConsulta = DC.idPanelDiagnosticoConsulta
								   WHERE PCD.idPanelDiagnosticoConsulta = '$idDxConsulta' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND C.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    C.idConsulta,
						    C.fecha,
						    DATE_FORMAT(C.hora, '%H:%i') as hora,
						    C.motivo,
						    C.observaciones,
						    C.planASeguir,
						    C.edadActualMascota,
						    
						    EF.idExamenFisico,
						    EF.peso,
						    EF.medidaCm,
						    EF.temperatura,
						    EF.observaciones as observacionesExamenFisico,
						    
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_consultas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						    	LEFT JOIN
						    tb_examenFisico AS EF ON EF.idConsulta = C.idConsulta
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						    
							".$adicionQuery."
						
						GROUP BY (C.idConsulta)
							
						ORDER BY (C.idConsulta) DESC; ";
						
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
			
			
        }//fin metodo consultas_aplicarFiltrosConsultas        
        
 
 
     //metodo para aplicar filtros
        public function consultas_TotalAplicarFiltrosConsultas($fechaInicial, $fechaFinal, $usuarios, $idDxConsulta, $idPropietario, $paciente){
        	
			$resultado = 0;
			//$adicionQuery = "WHERE 1 ";
			
			if($idConsulta != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_consultas_diagnosticos AS DC ON DC.idConsulta = C.idConsulta
								  INNER JOIN tb_panelDiagnosticoConsulta AS PCD ON PCD.idPanelDiagnosticoConsulta = DC.idPanelDiagnosticoConsulta
								   WHERE PCD.idPanelDiagnosticoConsulta = '$idDxConsulta' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND C.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( C.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  C.idMascota = '$paciente' ";
				
			}

			
			$query = "SELECT 
						    count(C.idConsulta) as totalRegistros
						FROM
						    tb_consultas AS C
						        INNER JOIN
						    tb_mascotas AS M ON C.idMascota = M.idMascota
						    	LEFT JOIN
						    tb_examenFisico AS EF ON EF.idConsulta = C.idConsulta
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = C.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = C.idUsuario
						    
							".$adicionQuery."";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo     consultas_TotalAplicarFiltrosConsultas
        

        //metodo para consultar las notas aclaratorias de una consulta
        public function consultarNotasAclaratoriasConsulta($idConsulta){
        	$resultado = array();
		
			$query = " SELECT CN.idConsultaNotaAclaratoria, CN.texto, CN.fecha, DATE_FORMAT(CN.hora, '%H:%i') as hora, CN.idUsuario, 
								U.identificacion, U.nombre, U.apellido
			
						FROM tb_consultasNotasAclaratorias as CN
						
						
						inner join tb_usuarios AS U ON U.idUsuario = CN.idUsuario
						
						where CN.idConsulta = '$idConsulta'";
						
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
        }//fin metodo consultarNotasAclaratoriasConsulta        
        
        
/*---------------Fin consultas--------------*/


/*---------------Desparasitantes--------------*/



        //metodo para contar la cantidad de desparasitantes
        public function desparasitantes_tatalDesparasitantes(){        	

			$resultado = array();
			
			$query = "Select count(idDesparasitanteMascota) as cantidadDesparasitantes from tb_desparasitantesMascotas ";
			
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
			
			
        }//fin metodo desparasitantes_tatalDesparasitantes 
        
        
        
 //metodo para listar los desparasitantes
        public function desparasitantes_listarDesparasitantes($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    D.idDesparasitanteMascota,
						    D.dosificacion,
						    D.fecha,
						    DATE_FORMAT(D.hora, '%H:%i') AS hora,
						    D.fechaProximoDesparasitante,
						    D.observacion,
						    D.idMascota,
						    D.idDesparasitante,
						    DD.nombre AS nombreDesparasitante,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						FROM
						    tb_desparasitantesMascotas AS D
						        INNER JOIN
						    tb_mascotas AS M ON D.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_desparasitantes AS DD ON DD.idDesparasitante = D.idDesparasitante
						ORDER BY (D.idDesparasitanteMascota) DESC
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
			
			
        }//fin metodo desparasitantes_listarDesparasitantes        
        

        
     //metodo para aplicar filtros
        public function desparasitantes_aplicarFiltrosDesparasitantes($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idDesparasitante, $idPropietario, $paciente){
        	
			$resultado = array();
			$adicionQuery = "WHERE 1 ";
			
			if($idDesparasitante != '0'){
				
				
				$adicionQuery .= " AND D.idDesparasitante = '$idDesparasitante' ";	
				
												
			}
			
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( D.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			if($fechaInicialProximo != "" AND $fechaFinalProximo != ""){
				
				$adicionQuery .= " AND ( D.fechaProximoDesparasitante BETWEEN '$fechaInicialProximo' AND '$fechaFinalProximo')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  D.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    D.idDesparasitanteMascota,
						    D.dosificacion,
						    D.fecha,
						    DATE_FORMAT(D.hora, '%H:%i') AS hora,
						    D.fechaProximoDesparasitante,
						    D.observacion,
						    D.idMascota,
						    D.idDesparasitante,
						    DD.nombre AS nombreDesparasitante,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						FROM
						    tb_desparasitantesMascotas AS D
						        INNER JOIN
						    tb_mascotas AS M ON D.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_desparasitantes AS DD ON DD.idDesparasitante = D.idDesparasitante
						    
							".$adicionQuery."
						
						GROUP BY (D.idDesparasitanteMascota)
							
						ORDER BY (D.idDesparasitanteMascota) DESC; ";
						
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
			
			
        }//fin metodo desparasitantes_aplicarFiltrosDesparasitantes        
        
 
 
     //metodo para aplicar filtros total
        public function desparasitantes_TotalAplicarFiltrosDesparasitantes($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idDesparasitante, $idPropietario, $paciente){
        	
			$resultado = 0;
			$adicionQuery = "WHERE 1 ";
			
			if($idDesparasitante != '0'){
				
				
				$adicionQuery .= " AND D.idDesparasitante = '$idDesparasitante' ";	
				
												
			}
			
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( D.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			if($fechaInicialProximo != "" AND $fechaFinalProximo != ""){
				
				$adicionQuery .= " AND ( D.fechaProximoDesparasitante BETWEEN '$fechaInicialProximo' AND '$fechaFinalProximo')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  D.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    count(D.idDesparasitanteMascota) as totalRegistros
						FROM
						    tb_desparasitantesMascotas AS D
						        INNER JOIN
						    tb_mascotas AS M ON D.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_desparasitantes AS DD ON DD.idDesparasitante = D.idDesparasitante
						    
							".$adicionQuery."
						";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo desparasitantes_TotalAplicarFiltrosDesparasitantes    
        
       

/*---------------Fin desparasitantes--------------*/



/*---------------Examenes--------------*/


        //metodo para contar la cantidad de examenes
        public function examenes_tatalExamenes(){        	

			$resultado = array();
			
			$query = "Select count(idExamen) as cantidadExamenes from tb_examenes ";
			
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
			
			
        }//fin metodo examenes_tatalExamenes 
        
        
        
 //metodo para listar los examenes
        public function examenes_listarExamenes($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
							E.idExamen, 
							E.fecha,
							DATE_FORMAT(E.hora, '%H:%i') AS hora,
							E.observaciones,
							E.idMascota,
							E.idUsuario,
							E.idSucursal,
							M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
							
						FROM
						    tb_examenes AS E
						        INNER JOIN
						    tb_mascotas AS M ON E.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = E.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = E.idUsuario
						ORDER BY (E.idExamen) DESC
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
			
			
        }//fin metodo examenes_listarExamenes        
        
        
        //metodo para consultar los detalles de unexamen
        public function consultarDetalleExamen($idExamen){
        				
        	$resultado = array();
		
			$query = " SELECT DE.idExamenDetalle, LE.nombre, LE.codigo, LE.precio,
							DE.observacion
						FROM tb_listadoExamenes as LE
						inner join tb_examenDetalle AS DE ON DE.idListadoExamen = LE.idListadoExamen
						
						where DE.idExamen = '$idExamen'";
						
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
        		
        	
        }//fin metodo consultarDetalleExamen
        

        
     //metodo para aplicar filtros
        public function examenes_aplicarFiltrosExamenes($fechaInicial, $fechaFinal, $usuarios, $idExamen, $idPropietario, $paciente){
        	
			$resultado = array();
			//$adicionQuery = "WHERE 1 ";
			
			if($idExamen != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_examenDetalle AS DE ON DE.idExamen = E.idExamen
								  INNER JOIN tb_listadoExamenes AS LE ON LE.idListadoExamen = DE.idListadoExamen
								   WHERE LE.idListadoExamen = '$idExamen' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND E.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( E.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  E.idMascota = '$paciente' ";
				
			}
		
			$query = " SELECT 
							E.idExamen, 
							E.fecha,
							DATE_FORMAT(E.hora, '%H:%i') AS hora,
							E.observaciones,
							E.idMascota,
							E.idUsuario,
							E.idSucursal,
							M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
							
						FROM
						    tb_examenes AS E
						        INNER JOIN
						    tb_mascotas AS M ON E.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = E.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = E.idUsuario
						    
							".$adicionQuery."
						
						GROUP BY (E.idExamen)
							
						ORDER BY (E.idExamen) DESC; ";
						
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
			
			
        }//fin metodo examenes_aplicarFiltrosExamenes        
        
 
 
     //metodo para aplicar filtros
        public function examenes_TotalAplicarFiltrosExamenes($fechaInicial, $fechaFinal, $usuarios, $idExamen, $idPropietario, $paciente){
        	
			$resultado = 0;
			//$adicionQuery = "WHERE 1 ";
			
			if($idExamen != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_examenDetalle AS DE ON DE.idExamen = E.idExamen
								  INNER JOIN tb_listadoExamenes AS LE ON LE.idListadoExamen = DE.idListadoExamen
								   WHERE LE.idListadoExamen = '$idExamen' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND E.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( E.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  E.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    count(E.idExamen) as totalRegistros
						FROM
						    tb_examenes AS E
						        INNER JOIN
						    tb_mascotas AS M ON E.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = E.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = E.idUsuario
						    
							".$adicionQuery."
						";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo examenes_TotalAplicarFiltrosExamenes    
        
        
        //metodo para consultar los recultados de un examen (detalle examen)
        public function consultarResultadoExamen($idExamenDetalle){
        	$resultado = array();
		
			$query = " SELECT 
							R.idresultadoExamen,
							R.fecha,
							DATE_FORMAT(R.hora, '%H:%i') AS hora,
							R.general,
							R.observaciones,
							U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
							
			
						FROM tb_resultadoExamen as R
						
						
						inner join tb_usuarios AS U ON U.idUsuario = R.idUsuario
						
						where R.idExamenDetalle = '$idExamenDetalle'
						";
						
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
        }//fin metodo consultarResultadoExamen


/*---------------Fin examenes--------------*/


/*---------------Formulas--------------*/

        //metodo para contar la cantidad de formulas
        public function formulas_tatalFormulas(){        	

			$resultado = array();
			
			$query = "Select count(idFormula) as cantidadFormulas from tb_formulas ";
			
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
			
			
        }//fin metodo formulas_tatalFormulas 
        
        
        
 //metodo para listar las formulas
        public function formulas_listarFormulas($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    F.idFormula,
						    F.fecha,
						    DATE_FORMAT(F.hora, '%H:%i') as hora,
						    F.observaciones,
						    F.idMascota,
						    F.idSucursal,
						    F.idUsuario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_formulas AS F
						        INNER JOIN
						    tb_mascotas AS M ON F.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = F.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = F.idUsuario
						ORDER BY (F.idFormula) DESC
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
			
			
        }//fin metodo formulas_listarFormulas        
        
        
        //metodo para consultar los medicamentos de una formula
        public function consultarMedicamentosFormula($idFormula){
        				
        	$resultado = array();
		
			$query = " SELECT MF.idMedicamentoFormula, MF.via, MF.cantidad, MF.frecuencia, MF.dosificacion, MF.observacion,
								M.nombre as nombreMedicamento, M.codigo
						FROM tb_medicamentosFormula as MF
						inner join tb_listadoMedicamentos AS M ON M.idMedicamento = MF.idMedicamento
						
						where MF.idFormula = '$idFormula'
						";
						
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
        		
        	
        }//fin metodo consultarMedicamentosFormula
        

        
     //metodo para aplicar filtros
        public function formulas_aplicarFiltrosFormulas($fechaInicial, $fechaFinal, $usuarios, $idMedicamento, $idPropietario, $paciente){
        	
			$resultado = array();
			//$adicionQuery = "WHERE 1 ";
			
			if($idMedicamento != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_medicamentosFormula AS MF ON MF.idFormula = F.idFormula
								  INNER JOIN tb_listadoMedicamentos AS ME ON ME.idMedicamento = MF.idMedicamento
								   WHERE ME.idMedicamento = '$idMedicamento' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND F.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( F.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  F.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    F.idFormula,
						    F.fecha,
						    DATE_FORMAT(F.hora, '%H:%i') as hora,
						    F.observaciones,
						    F.idMascota,
						    F.idSucursal,
						    F.idUsuario,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_formulas AS F
						        INNER JOIN
						    tb_mascotas AS M ON F.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = F.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = F.idUsuario
						    
							".$adicionQuery."
						
						GROUP BY (F.idFormula)
							
						ORDER BY (F.idFormula) DESC; ";
						
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
			
			
        }//fin metodo formulas_aplicarFiltrosFormulas        
        
 
 
     //metodo para aplicar filtros
        public function formulas_TotalAplicarFiltrosFormulas($fechaInicial, $fechaFinal, $usuarios, $idMedicamento, $idPropietario, $paciente){
        	
			$resultado = 0;
			//$adicionQuery = "WHERE 1 ";
			
			if($idMedicamento != '0'){
				
				
				$adicionQuery = " INNER JOIN tb_medicamentosFormula AS MF ON MF.idFormula = F.idFormula
								  INNER JOIN tb_listadoMedicamentos AS ME ON ME.idMedicamento = MF.idMedicamento
								   WHERE ME.idMedicamento = '$idMedicamento' ";	
				
												
			}else{
				$adicionQuery = "WHERE 1 ";
			}
			
			
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND F.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( F.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  F.idMascota = '$paciente' ";
				
			}
		
			$query = "SELECT 
						    count(F.idFormula) as totalRegistros
						FROM
						    tb_formulas AS F
						        INNER JOIN
						    tb_mascotas AS M ON F.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = F.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = F.idUsuario
						    
							".$adicionQuery."
						 ";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo cirugias_TotalAplicarFiltrosFormulas    
        
        

/*---------------Fin formulas--------------*/


/*---------------Vacunas--------------*/


        //metodo para contar la cantidad de vacunas
        public function vacunas_tatalVacunas(){        	

			$resultado = array();
			
			$query = "Select count(idMascotaVacunas) as cantidadVacunas from tb_mascotas_vacunas ";
			
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
			
			
        }//fin metodo vacunas_tatalVacunas 
        
        
        
 //metodo para listar las vacunas
        public function vacunas_listarVacunas($paginaActual,$records_per_page){
        	
			$resultado = array();
			
			$query = " SELECT 
						    V.idMascotaVacunas,
						    V.fecha,
						    DATE_FORMAT(V.hora, '%H:%i') as hora,
						    V.fechaProximaVacuna,
						    V.observaciones,
						    V.idVacuna,
						    VV.nombre as nombreVacuna,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						FROM
						    tb_mascotas_vacunas AS V
						        INNER JOIN
						    tb_mascotas AS M ON V.idMascota = M.idMascota
						    	INNER JOIN
						    tb_vacunas AS VV ON V.idVacuna = VV.idVacuna
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						ORDER BY (V.idMascotaVacunas) DESC
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
			
			
        }//fin metodo vacunas_listarVacunas        
        

        
     //metodo para aplicar filtros
        public function vacunas_aplicarFiltrosVacunas($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idVacuna, $idPropietario, $paciente){
        	
			$resultado = array();
			$adicionQuery = "WHERE 1 ";
			
			if($idVacuna != '0'){
				
				
				$adicionQuery .= " AND V.idVacuna = '$idVacuna' ";	
				
												
			}
			
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( V.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			if($fechaInicialProximo != "" AND $fechaFinalProximo != ""){
				
				$adicionQuery .= " AND ( V.fechaProximoDesparasitante BETWEEN '$fechaInicialProximo' AND '$fechaFinalProximo')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  V.idMascota = '$paciente' ";
				
			}
		
			$query = " SELECT 
						    V.idMascotaVacunas,
						    V.fecha,
						    DATE_FORMAT(V.hora, '%H:%i') as hora,
						    V.fechaProximaVacuna,
						    V.observaciones,
						    V.idVacuna,
						    VV.nombre as nombreVacuna,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						FROM
						    tb_mascotas_vacunas AS V
						        INNER JOIN
						    tb_mascotas AS M ON V.idMascota = M.idMascota
						    	INNER JOIN
						    tb_vacunas AS VV ON V.idVacuna = VV.idVacuna
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						    
							".$adicionQuery."
						
						GROUP BY (V.idMascotaVacunas)
							
						ORDER BY (V.idMascotaVacunas) DESC; ";
					
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
			
			
        }//fin metodo vacunas_aplicarFiltrosVacunas        
        
 
 
     //metodo para aplicar filtros total
        public function vacunas_TotalAplicarFiltrosVacunas($fechaInicial, $fechaFinal, $fechaInicialProximo, $fechaFinalProximo, $idVacuna, $idPropietario, $paciente){
        	
			$resultado = 0;
			$adicionQuery = "WHERE 1 ";
			
			if($idVacuna != '0'){
				
				
				$adicionQuery .= " AND V.idVacuna = '$idVacuna' ";	
				
												
			}
			
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( V.fecha BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
			if($fechaInicialProximo != "" AND $fechaFinalProximo != ""){
				
				$adicionQuery .= " AND ( V.fechaProximoDesparasitante BETWEEN '$fechaInicialProximo' AND '$fechaFinalProximo')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  V.idMascota = '$paciente' ";
				
			}
		
		
			$query = "SELECT 
						    count(V.idMascotaVacunas) as totalRegistros
						   FROM
						    tb_mascotas_vacunas AS V
						        INNER JOIN
						    tb_mascotas AS M ON V.idMascota = M.idMascota
						    	INNER JOIN
						    tb_vacunas AS VV ON V.idVacuna = VV.idVacuna
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						    
							".$adicionQuery."
						";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo vacunas_TotalAplicarFiltrosVacunas    
        
       



/*---------------Fin vacunas--------------*/




/*---------------Hospitalizaciones--------------*/


        //metodo para contar la cantidad de hospitalizaciones
        public function hospitalizaciones_tatalHospitalizaciones(){        	

			$resultado = array();
			
			$query = "Select count(idHospitalizacion) as cantidadHospitalizaciones from tb_hospitalizacion ";
			
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
			
			
        }//fin metodo hospitalizaciones_tatalHospitalizaciones 
        
        
        
 //metodo para listar las hospitalizaciones
        public function hospitalizaciones_listarHospitalizaciones($paginaActual,$records_per_page){
        	
			$resultado = array();
		
			$query = " SELECT 
						    H.idHospitalizacion,
						    H.fechaIngreso,
						    DATE_FORMAT(H.horaIngreso, '%H:%i') AS hora,
						    H.motivoHospitalizacion,
						    H.observacion,
						    HA.idHospitalizacionAlta,
						    HA.fecha as fechaAlta,
						    DATE_FORMAT(HA.hora, '%H:%i') AS horaAlta,
						    HA.observaciones AS observacionesAlta,
						    HA.cuidadosATener,
						    UA.nombre AS nombreUsuarioAlta,
						    UA.apellido AS apellidoUsuarioAlta,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_hospitalizacion AS H
						        LEFT JOIN
						    tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
						        LEFT JOIN
						    tb_usuarios AS UA ON UA.idUsuario = HA.idUsuario
						        INNER JOIN
						    tb_mascotas AS M ON H.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = H.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = H.idUsuario
						ORDER BY (H.idHospitalizacion) DESC
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
			
			
        }//fin metodo hospitalizaciones_listarHospitalizaciones        

        

        
     //metodo para aplicar filtros
        public function hospitalizaciones_aplicarFiltrosHospitalizaciones($fechaInicial, $fechaFinal, $usuarios, $idPropietario, $paciente){
        	
			$resultado = array();
			$adicionQuery = "WHERE 1 ";
						
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND H.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( H.fechaIngreso BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  H.idMascota = '$paciente' ";
				
			}
		
			$query = " SELECT 
						    H.idHospitalizacion,
						    H.fechaIngreso,
						    DATE_FORMAT(H.horaIngreso, '%H:%i') AS hora,
						    H.motivoHospitalizacion,
						    H.observacion,
						    HA.idHospitalizacionAlta,
						    HA.fecha as fechaAlta,
						    DATE_FORMAT(HA.hora, '%H:%i') AS horaAlta,
						    HA.observaciones AS observacionesAlta,
						    HA.cuidadosATener,
						    UA.nombre AS nombreUsuarioAlta,
						    UA.apellido AS apellidoUsuarioAlta,
						    M.nombre AS nombreMascota,
						    M.sexo AS sexoMascota,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono,
						    SU.nombre AS nombreSucursal,
						    U.nombre AS nombreUsuario,
						    U.apellido AS apellidoUsuario
						FROM
						    tb_hospitalizacion AS H
						        LEFT JOIN
						    tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
						        LEFT JOIN
						    tb_usuarios AS UA ON UA.idUsuario = HA.idUsuario
						        INNER JOIN
						    tb_mascotas AS M ON H.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = H.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = H.idUsuario
							".$adicionQuery."
						
						GROUP BY (H.idHospitalizacion)
							
						ORDER BY (H.idHospitalizacion) DESC; ";
					
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
			
			
        }//fin metodo hospitalizaciones_aplicarFiltrosHospitalizaciones        
        
 
 
     //metodo para aplicar filtros
        public function hospitalizaciones_TotalAplicarFiltrosHospitalizaciones($fechaInicial, $fechaFinal, $usuarios, $idPropietario, $paciente){
        	
			$resultado = 0;
			$adicionQuery = "WHERE 1 ";
					
			
			if($usuarios != ""){				
				
				$adicionQuery = " AND H.idUsuario = '$usuarios' ";					
												
			}
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= "AND ( H.fechaIngreso BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($paciente != ""){
				
				$adicionQuery .= " AND  H.idMascota = '$paciente' ";
				
			}

			
			$query = "SELECT 
						    count(H.idHospitalizacion) as totalRegistros
						FROM
						    tb_hospitalizacion AS H
						    	LEFT JOIN
						    tb_hospitalizacionAlta AS HA ON HA.idHospitalizacion = H.idHospitalizacion
						        INNER JOIN
						    tb_mascotas AS M ON H.idMascota = M.idMascota
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						        INNER JOIN
						    tb_sucursales AS SU ON SU.idSucursal = H.idSucursal
						        INNER JOIN
						    tb_usuarios AS U ON U.idUsuario = H.idUsuario
						    
							".$adicionQuery."";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo hospitalizaciones_TotalAplicarFiltrosHospitalizaciones
        
      //metodo para consultar la cantidad de consultas en una hospitalizacion
      public function hospitalizaciones_cantidadConsultas($idHospitalizacion){
      			
      	$resultado = 0;	
      	
      	$query = "SELECT 
						    count(idConsultaHospitalizacion) as totalRegistros
					FROM tb_ConsultaHospitalzacion
					WHERE idHospitalizacion = '$idHospitalizacion'";
      	
      	$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
      	
      }//fine metodo hospitalizaciones_cantidadConsultas
        
 
     //metodo para consultar la cantidad de cirugias en una hospitalizacion
      public function hospitalizaciones_cantidadCirugias($idHospitalizacion){
      			
      	$resultado = 0;	
      	
      	$query = "SELECT 
						    count(idCirugiaHospitalizacion) as totalRegistros
					FROM tb_cirugia_hospitalizacion
					WHERE idHospitalizacion = '$idHospitalizacion'";
      	
      	$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
      	
      }//fine metodo hospitalizaciones_cantidadCirugias
         
 
     //metodo para consultar la cantidad de examenes en una hospitalizacion
      public function hospitalizaciones_cantidadExamenes($idHospitalizacion){
      			
      	$resultado = 0;	
      	
      	$query = "SELECT 
						    count(idExamenHospitalizacion) as totalRegistros
					FROM tb_examen_hospitalizacion
					WHERE idHospitalizacion = '$idHospitalizacion'";
      	
      	$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
      	
      }//fine metodo hospitalizaciones_cantidadExamenes

      
     //metodo para consultar la cantidad de formulas en una hospitalizacion
      public function hospitalizaciones_cantidadFormulas($idHospitalizacion){
      			
      	$resultado = 0;	
      	
      	$query = "SELECT 
						    count(idFormulaHospitalizacion) as totalRegistros
					FROM tb_formula_hospitalizacion
					WHERE idHospitalizacion = '$idHospitalizacion'";
      	
      	$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
      	
      }//fine metodo hospitalizaciones_cantidadFormulas      
            
              
/*---------------Fin hospitalizaciones--------------*/



/*---------------Pacientes--------------*/

        //metodo para contar la cantidad de pacientes
        public function pacientes_tatalPacientes(){        	

			$resultado = array();
			
			$query = "Select count(idMascota) as cantidadPacientes from tb_mascotas ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPacientes'];			
			
			
        }//fin metodo pacientes_tatalPacientes 
        
        
        
 //metodo para listar los pacientes
        public function pacientes_listarPacientes($paginaActual,$records_per_page){
        	
			$resultado = array();
			
			$query = " SELECT 
						   	M.idMascota,
						   	M.nombre,
						   	M.numeroChip,
						   	M.sexo,
						   	M.esterilizado,
						   	M.color,
						   	M.fechaNacimiento,
						   	M.estado,
						   	M.alimento,
						   	M.frecuenciaBanoDias,
						   	M.idRaza,
						   	M.idEspecie,
						   	E.nombre as nombreEspecie,
						   	R.nombre as nombreRaza,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						    
						FROM
						    tb_mascotas AS M
						        INNER JOIN
						    tb_especies AS E ON E.idEspecie = M.idEspecie
						    	INNER JOIN
						    tb_razas AS R ON R.idRaza = M.idRaza
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						ORDER BY (M.idMascota) DESC
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
			
			
        }//fin metodo vacunas_listarVacunas        
        

        
     //metodo para aplicar filtros
        public function pacientes_aplicarFiltrosPacientes($idEspecie, $idRaza, $idPropietario, $fechaInicial, $fechaFinal){
        	
			$resultado = array();
			$adicionQuery = "WHERE 1 ";
			
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( M.fechaNacimiento BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
					
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($idEspecie != "0"){
				
				$adicionQuery .= " AND  M.idEspecie = '$idEspecie' ";
				
			}
			
			if($idRaza != "0"){
				
				$adicionQuery .= " AND  M.idRaza = '$idRaza' ";
				
			}
		
			$query = " SELECT 
						   	M.idMascota,
						   	M.nombre,
						   	M.numeroChip,
						   	M.sexo,
						   	M.esterilizado,
						   	M.color,
						   	M.fechaNacimiento,
						   	M.estado,
						   	M.alimento,
						   	M.frecuenciaBanoDias,
						   	M.idRaza,
						   	M.idEspecie,
						   	E.nombre as nombreEspecie,
						   	R.nombre as nombreRaza,
						    P.identificacion AS identificacionPropietario,
						    P.nombre AS nombrePropietario,
						    P.apellido AS apellidoPropietario,
						    P.telefono
						    
						FROM
						    tb_mascotas AS M
						        INNER JOIN
						    tb_especies AS E ON E.idEspecie = M.idEspecie
						    	INNER JOIN
						    tb_razas AS R ON R.idRaza = M.idRaza
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						    
							".$adicionQuery."
						
						GROUP BY (M.idMascota)
							
						ORDER BY (M.idMascota) DESC; ";
					
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
			
			
        }//fin metodo pacientes_aplicarFiltrosPacientes        
        
 
 
     //metodo para aplicar filtros total
        public function pacientes_TotalAplicarFiltrosPacientes($idEspecie, $idRaza, $idPropietario, $fechaInicial, $fechaFinal){
        	
			$resultado = 0;
			$adicionQuery = "WHERE 1 ";
			
			if($fechaInicial != "" AND $fechaFinal != ""){
				
				$adicionQuery .= " AND ( M.fechaNacimiento BETWEEN '$fechaInicial' AND '$fechaFinal')";
				
			}
			
						
			
			if($idPropietario != "0"){
				
				$adicionQuery .= " AND  P.idPropietario = '$idPropietario' ";
				
			}
			
			if($idEspecie != "0"){
				
				$adicionQuery .= " AND  M.idEspecie = '$idEspecie' ";
				
			}
			
			if($idRaza != "0"){
				
				$adicionQuery .= " AND  M.idRaza = '$idRaza' ";
				
			}
		
		
			$query = "SELECT 
						    count(M.idMascota) as totalRegistros
						   FROM
						    tb_mascotas AS M
						        INNER JOIN
						    tb_especies AS E ON E.idEspecie = M.idEspecie
						    	INNER JOIN
						    tb_razas AS R ON R.idRaza = M.idRaza
						        INNER JOIN
						    tb_propietarios AS P ON P.idPropietario = M.idPropietario
						    
						    
							".$adicionQuery."
						";
						
						
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas['totalRegistros'];
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo pacientes_TotalAplicarFiltrosPacientes    
        
       

/*---------------Fin pacientes--------------*/


/*---------------propietarios--------------*/

     //metodo para contar la cantidad de propietarios
        public function propietarios_tatalPropietarios(){        	

			$resultado = array();
			
			$query = "Select count(idPropietario) as cantidadPropietarios from tb_propietarios ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPropietarios'];			
			
			
        }//fin metodo propietarios_tatalPropietarios 
        
        
        
 //metodo para listar los propietarios
        public function propietarios_listarPropietarios($paginaActual,$records_per_page){
        	
			$resultado = array();
			
			$query = "SELECT 
					    P.idPropietario,
					    P.identificacion,
					    P.nombre,
					    P.apellido,
					    P.telefono,
					    P.celular,
					    P.direccion,
					    P.email,
					    P.idPais,
					    P.idCiudad,
					    P.idBarrio,
					    P.estado,
					    PA.nombre AS nombrePais,
					    C.nombre AS nombreCiudad,
					    B.nombre AS nombreBarrio
					FROM
					    tb_propietarios AS P
					        INNER JOIN
					    tb_paises AS PA ON PA.idPais = P.idPais
					        INNER JOIN
					    tb_ciudades AS C ON C.idCiudad = P.idCiudad
					        INNER JOIN
					    tb_barrios AS B ON B.idBarrio = P.idBarrio

						ORDER BY (P.idPropietario) DESC
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
			
			
        }//fin metodo pacientes_listarPacientes     
        
        
        //metodo para consultar la cantidad de pacientes de un propietario
        public function propietarios_cantidadPacientes($idPropietario){
        				
        	$resultado = array();
			
			$query = "Select count(idMascota) as cantidadPacientes from tb_mascotas where idPropietario = '$idPropietario' ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPacientes'];			
        		
        	
        }//fin metodo propietarios_cantidadPacientes
        
        
        //metodo para listar algunos datos de los pacientes de un propietario
        public function propietario_listarPacientes($idPropietario){
        	
			$resultado = array();
			
			$query = "SELECT 
						    M.nombre, E.nombre AS nombreEspecie, R.nombre AS nombreRaza
						FROM
						    tb_mascotas AS M
						        INNER JOIN
						    tb_especies AS E ON E.idEspecie = M.idEspecie
						        INNER JOIN
						    tb_razas AS R ON R.idRaza = M.idRaza
						WHERE
						    M.idPropietario = '$idPropietario' ";
						
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
			
			
        }//fin metodo propietario_listarPacientes
           
        



/*---------------Fin propietarios--------------*/




/*---------------Inventario--------------*/


     //metodo para contar la cantidad de productos
        public function inventario_tatalProductos(){        	

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
			
			
        }//fin metodo inventario_tatalProductos 



//metodo para listar los productos
        public function inventario_listarProductos($paginaActual,$records_per_page, $idSucursal = ""){
        	
			$resultado = array();
			
			if($idSucursal != ""){
				
				$adicionCampo = "S.cantidad,";
				
				$adicion = "left join 
					    tb_productos_sucursal AS S ON S.idProducto = P.idProducto
					    	where S.idSucursal = '$idSucursal'";
			}else{
				$adicionCampo = "";
				$adicion = "";
			}
			
			$query = "SELECT 
					    P.idProducto,
					    P.nombre,
					    P.descripcion,
					    P.codigo,
					    P.precio,
					    P.estado,
					    P.idCategoria,
					    P.tipoExterno,
					    P.idExterno,
					    ".$adicionCampo."
					    C.nombre as nombreCategoria 
					FROM
					    tb_productos AS P
					        INNER JOIN
					    tb_categoriasProductos AS C ON C.idCategoria = P.idCategoria
						".$adicion."
						ORDER BY (P.idProducto) DESC
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
			
			
        }//fin metodo inventario_listarProductos  
        
        
        
        //metodo para consultar la cantidades que estan las sucursales de un producto
        public function inventario_consultarCantidadesProducto($idProducto){
        				
        		$resultado = array();	
        			
        		$query = "SELECT 
							    PS.cantidad, S.nombre AS nombreSucursal
							FROM
							    tb_productos_sucursal AS PS
							        INNER JOIN
							    tb_sucursales AS S ON S.idSucursal = PS.idSucursal
							WHERE
							    PS.idProducto = '$idProducto'";
											
										
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
        	
        }//fin metodo inventario_consultarCantidadesProducto


   		//metodo para consultar los proveedores de un producto
        public function inventario_consultarProveedoresProducto($idProducto){
        				
        		$resultado = array();	
        			
        		$query = "SELECT 
							    PP.costo, P.nombre AS nombreProveedor, P.telefono1
							FROM
							    tb_productos_proveedores AS PP
							        INNER JOIN
							    tb_proveedores AS P ON P.idProveedor = PP.idProveedor
							WHERE
							    PP.idProducto = '$idProducto'";
											
										
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
        	
        }//fin metodo inventario_consultarProveedoresProducto


/*---------------Fin inventario--------------*/





}//fin clase


?>