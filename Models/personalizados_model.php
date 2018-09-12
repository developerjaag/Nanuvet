<?php 

/**
 * Clase para administrar los personalizados
 */
class personalizados extends Config {

	//buscar personalizado motivo consulta con string
	public function buscarPersonalizadoMCConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoMotivoConsulta, titulo FROM tb_personalizados_motivoConsulta ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoMotivoConsulta, titulo FROM tb_personalizados_motivoConsulta ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoMotivoConsulta'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoMCConString 


	//consultar el total de motivo de consulta
	public function tatalPersonalizadosMC(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoMotivoConsulta) as cantidadPersonalizados from tb_personalizados_motivoConsulta ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosMC

	
	//listar la informacion de los motivos de consulta
	public function listarPersonalizadosMC($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoConsulta, titulo, texto, estado
						FROM tb_personalizados_motivoConsulta
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosMC
	
	
	//guardar personalizado de motivo consulta
	public function guardarPersonalizadoMotivoConsulta($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_motivoConsulta (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoMotivoConsulta
	
	
	
	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoMC($idPersonalizadoMC){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoConsulta, titulo, texto, estado
						FROM tb_personalizados_motivoConsulta
						WHERE idPersonalizadoMotivoConsulta = '$idPersonalizadoMC'";
						
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
			
	}//fin metodo consultarUnPersonalizadoMC
	
	
	//metodo para editar el personalizado de un motivo de consulta
	public function editarPersonalizadoMotivoConsulta($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_motivoConsulta SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoMotivoConsulta = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoMotivoConsulta
	
	
	//metodo para desactivar un personalizado del motivo de consulta
	public function desactivarPersonalizadoMotivoConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoConsulta SET estado = 'I' WHERE idPersonalizadoMotivoConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoMotivoConsulta
	
	
	
	//metodo para activar un pérsonalizado del motivo de consulta
	public function activarPersonalizadoMotivoConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoConsulta SET estado = 'A' WHERE idPersonalizadoMotivoConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoMotivoConsulta	
	
	
////---------------------------------

	//buscar personalizado observaciones consulta con string
	public function buscarPersonalizadoOCConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionConsulta, titulo FROM tb_personalizados_observacionesConsulta ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionConsulta, titulo FROM tb_personalizados_observacionesConsulta ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionConsulta'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOCConString 



	//consultar el total de observaciones de consulta
	public function tatalPersonalizadosOC(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionConsulta) as cantidadPersonalizados from tb_personalizados_observacionesConsulta ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOC


	//listar la informacion de los observaciones de consulta
	public function listarPersonalizadosOC($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionConsulta, titulo, texto, estado
						FROM tb_personalizados_observacionesConsulta
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOC


	//guardar personalizado de observacion consulta
	public function guardarPersonalizadoObservacionesConsulta($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesConsulta (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesConsulta	
	
	
	//metodo para editar el personalizado de observaciones de consulta
	public function editarPersonalizadoObservacionesConsulta($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesConsulta SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionConsulta = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesConsulta	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOC($idPersonalizadoOC){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionConsulta, titulo, texto, estado
						FROM tb_personalizados_observacionesConsulta
						WHERE idPersonalizadoObservacionConsulta = '$idPersonalizadoOC'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOC		
	


	//metodo para activar un pérsonalizado observaciones de consulta
	public function activarPersonalizadoObservacionesConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesConsulta SET estado = 'A' WHERE idPersonalizadoObservacionConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesConsulta		
	

	//metodo para desactivar un personalizado observaciones consulta
	public function desactivarPersonalizadoObservacionesConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesConsulta SET estado = 'I' WHERE idPersonalizadoObservacionConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesConsulta	

	
	
////-------------------------------------------------------------------------------------

	//buscar personalizado plan consulta con string
	public function buscarPersonalizadoPCConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoPlanConsulta, titulo FROM tb_personalizados_planConsulta ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoPlanConsulta, titulo FROM tb_personalizados_planConsulta ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoPlanConsulta'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoPCConString 



	//consultar el total de plan de consulta
	public function tatalPersonalizadosPC(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoPlanConsulta) as cantidadPersonalizados from tb_personalizados_planConsulta ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosPC


	//listar la informacion de los planes de consulta
	public function listarPersonalizadosPC($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoPlanConsulta, titulo, texto, estado
						FROM tb_personalizados_planConsulta
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosPC


	//guardar personalizado de plan consulta
	public function guardarPersonalizadoPlanConsulta($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_planConsulta (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoPlanConsulta	
	
	
	//metodo para editar el personalizado de plan de consulta
	public function editarPersonalizadoPlanConsulta($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_planConsulta SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoPlanConsulta = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoPlanConsulta	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoPC($idPersonalizadoPC){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoPlanConsulta, titulo, texto, estado
						FROM tb_personalizados_planConsulta
						WHERE idPersonalizadoPlanConsulta = '$idPersonalizadoPC'";
						
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
			
	}//fin metodo consultarUnPersonalizadoPC		
	


	//metodo para activar un pérsonalizado plan de consulta
	public function activarPersonalizadoPlanConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_planConsulta SET estado = 'A' WHERE idPersonalizadoPlanConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoPlanConsulta		
	

	//metodo para desactivar un personalizado plan consulta
	public function desactivarPersonalizadoPlanConsulta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_planConsulta SET estado = 'I' WHERE idPersonalizadoPlanConsulta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoPlanConsulta		
	
	
////-----------------------------------------------------------------------------------

	//buscar personalizado observaciones examen fisico con string
	public function buscarPersonalizadoOEFConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionExamenFisico, titulo FROM tb_personalizados_observacionesExamenFisico ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionExamenFisico, titulo FROM tb_personalizados_observacionesExamenFisico ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionExamenFisico'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOEFConString 



	//consultar el total de observaciones de examen fisico
	public function tatalPersonalizadosOEF(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionExamenFisico) as cantidadPersonalizados from tb_personalizados_observacionesExamenFisico ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOEF


	//listar la informacion de los observaciones de examen fisico
	public function listarPersonalizadosOEF($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionExamenFisico, titulo, texto, estado
						FROM tb_personalizados_observacionesExamenFisico
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOEF


	//guardar personalizado de observacion examen fisico
	public function guardarPersonalizadoObservacionesExamenFisico($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesExamenFisico (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesExamenFisico	
	
	
	//metodo para editar el personalizado de observaciones de examen fisico
	public function editarPersonalizadoObservacionesExamenFisico($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesExamenFisico SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionExamenFisico = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesExamenFisico	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOEF($idPersonalizadoOEF){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionExamenFisico, titulo, texto, estado
						FROM tb_personalizados_observacionesExamenFisico
						WHERE idPersonalizadoObservacionExamenFisico = '$idPersonalizadoOEF'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOEF		
	


	//metodo para activar un pérsonalizado observaciones de examen fisico
	public function activarPersonalizadoObservacionesExamenFisico($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesExamenFisico SET estado = 'A' WHERE idPersonalizadoObservacionExamenFisico = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesExamenFisico		
	

	//metodo para desactivar un personalizado observaciones examen fisico
	public function desactivarPersonalizadoObservacionesExamenFisico($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesExamenFisico SET estado = 'I' WHERE idPersonalizadoObservacionExamenFisico = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesExamenFisico	
	
	
//-------------------------------------------------------------------------------	
	//guardar personalizado de motivo cirugia
	public function guardarPersonalizadoMotivoCirugia($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_motivoCirugia (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoMotivoCirugia	
	

	
	//metodo para editar el personalizado de un motivo de cirugia
	public function editarPersonalizadoMotivoCirugia($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_motivoCirugia SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoMotivoCirugia = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoMotivoCirugia	

	
	//consultar el total de motivo de cirugia
	public function tatalPersonalizadosMCI(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoMotivoCirugia) as cantidadPersonalizados from tb_personalizados_motivoCirugia ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosMCI	

	
	//listar la informacion de los motivos de cirugia
	public function listarPersonalizadosMCI($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoCirugia, titulo, texto, estado
						FROM tb_personalizados_motivoCirugia
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosMCI	

	
	
	//metodo para activar un pérsonalizado del motivo de cirugia
	public function activarPersonalizadoMotivoCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoCirugia SET estado = 'A' WHERE idPersonalizadoMotivoCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoMotivoCirugia		
							

	//buscar personalizado motivo cirugia con string
	public function buscarPersonalizadoMCIConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoMotivoCirugia, titulo FROM tb_personalizados_motivoCirugia ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoMotivoCirugia, titulo FROM tb_personalizados_motivoCirugia ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoMotivoCirugia'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoMCIConString 							
							

							
	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoMCI($idPersonalizadoMCI){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoCirugia, titulo, texto, estado
						FROM tb_personalizados_motivoCirugia
						WHERE idPersonalizadoMotivoCirugia = '$idPersonalizadoMCI'";
						
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
			
	}//fin metodo consultarUnPersonalizadoMCI		
	
	
	//metodo para desactivar un personalizado del motivo de cirugia
	public function desactivarPersonalizadoMotivoCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoCirugia SET estado = 'I' WHERE idPersonalizadoMotivoCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoMotivoCirugia	
						
//-------------------------------------------------------------------------------

	//buscar personalizado observaciones cirugia con string
	public function buscarPersonalizadoOCIConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionCirugia, titulo FROM tb_personalizados_observacionesCirugia ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionCirugia, titulo FROM tb_personalizados_observacionesCirugia ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionCirugia'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOCIConString 



	//consultar el total de observaciones de cirugia
	public function tatalPersonalizadosOCI(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionCirugia) as cantidadPersonalizados from tb_personalizados_observacionesCirugia ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOCI


	//listar la informacion de los observaciones de cirugia
	public function listarPersonalizadosOCI($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionCirugia, titulo, texto, estado
						FROM tb_personalizados_observacionesCirugia
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOCI


	//guardar personalizado de observacion consulta
	public function guardarPersonalizadoObservacionesCirugia($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesCirugia (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesCirugia	
	
	
	//metodo para editar el personalizado de observaciones de cirugia
	public function editarPersonalizadoObservacionesCirugia($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesCirugia SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionCirugia = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesCirugia	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOCI($idPersonalizadoOC){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionCirugia, titulo, texto, estado
						FROM tb_personalizados_observacionesCirugia
						WHERE idPersonalizadoObservacionCirugia = '$idPersonalizadoOC'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOCI		
	


	//metodo para activar un pérsonalizado observaciones de cirugia
	public function activarPersonalizadoObservacionesCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesCirugia SET estado = 'A' WHERE idPersonalizadoObservacionCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesCirugia		
	

	//metodo para desactivar un personalizado observaciones cirugia
	public function desactivarPersonalizadoObservacionesCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesCirugia SET estado = 'I' WHERE idPersonalizadoObservacionCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesCirugia	

	
	
////-------------------------------------------------------------------------------------	
	

	

	//buscar personalizado plan cirugia con string
	public function buscarPersonalizadoPCIConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoPlanCirugia, titulo FROM tb_personalizados_planCirugia ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoPlanCirugia, titulo FROM tb_personalizados_planCirugia ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoPlanCirugia'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoPCIConString 



	//consultar el total de plan de cirugia
	public function tatalPersonalizadosPCI(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoPlanCirugia) as cantidadPersonalizados from tb_personalizados_planCirugia ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosPCI


	//listar la informacion de los planes de cirugia
	public function listarPersonalizadosPCI($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoPlanCirugia, titulo, texto, estado
						FROM tb_personalizados_planCirugia
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosPCI


	//guardar personalizado de plan cirugia
	public function guardarPersonalizadoPlanCirugia($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_planCirugia (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoPlanCirugia	
	
	
	//metodo para editar el personalizado de plan de cirugia
	public function editarPersonalizadoPlanCirugia($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_planCirugia SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoPlanCirugia = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoPlanCirugia	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoPCI($idPersonalizadoPCI){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoPlanCirugia, titulo, texto, estado
						FROM tb_personalizados_planCirugia
						WHERE idPersonalizadoPlanCirugia = '$idPersonalizadoPCI'";
						
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
			
	}//fin metodo consultarUnPersonalizadoPCI		
	


	//metodo para activar un pérsonalizado plan de cirugia
	public function activarPersonalizadoPlanCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_planCirugia SET estado = 'A' WHERE idPersonalizadoPlanCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoPlanCirugia		
	

	//metodo para desactivar un personalizado plan cirugia
	public function desactivarPersonalizadoPlanCirugia($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_planCirugia SET estado = 'I' WHERE idPersonalizadoPlanCirugia = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoPlanCirugia		
	
	
		
	
////-----------------------------------------------------------------------------------Observaciones examen

	//buscar personalizado observaciones examen con string
	public function buscarPersonalizadoOEConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionExamen, titulo FROM tb_personalizados_observacionesExamen ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionExamen, titulo FROM tb_personalizados_observacionesExamen ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionExamen'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOEConString 



	//consultar el total de observaciones de examen
	public function tatalPersonalizadosOE(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionExamen) as cantidadPersonalizados from tb_personalizados_observacionesExamen ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOE


	//listar la informacion de los observaciones de examen
	public function listarPersonalizadosOE($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionExamen, titulo, texto, estado
						FROM tb_personalizados_observacionesExamen
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOE


	//guardar personalizado de observacion examen
	public function guardarPersonalizadoObservacionesExamen($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesExamen (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesExamen
	
	
	//metodo para editar el personalizado de observaciones de examen 
	public function editarPersonalizadoObservacionesExamen($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesExamen SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionExamen = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesExamen	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOE($idPersonalizadoOE){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionExamen, titulo, texto, estado
						FROM tb_personalizados_observacionesExamen
						WHERE idPersonalizadoObservacionExamen = '$idPersonalizadoOE'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOE		
	


	//metodo para activar un pérsonalizado observaciones de examen 
	public function activarPersonalizadoObservacionesExamen($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesExamen SET estado = 'A' WHERE idPersonalizadoObservacionExamen = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesExamen	
	

	//metodo para desactivar un personalizado observaciones examen
	public function desactivarPersonalizadoObservacionesExamen($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesExamen SET estado = 'I' WHERE idPersonalizadoObservacionExamen = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesExamen	
	
	
//-------------------------------------------------------------------------------	Fin personalizado examen
		

		
		
		
		
		
		
		
	
////-----------------------------------------------------------------------------------Observaciones formula

	//buscar personalizado observaciones formula con string
	public function buscarPersonalizadoOFConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionFormulacion, titulo FROM tb_personalizados_observacionesFormulacion ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionFormulacion, titulo FROM tb_personalizados_observacionesFormulacion ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionFormulacion'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOFConString 



	//consultar el total de observaciones de formula
	public function tatalPersonalizadosOF(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionFormulacion) as cantidadPersonalizados from tb_personalizados_observacionesFormulacion ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOF


	//listar la informacion de los observaciones de formula
	public function listarPersonalizadosOF($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionFormulacion, titulo, texto, estado
						FROM tb_personalizados_observacionesFormulacion
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOF


	//guardar personalizado de observacion formula
	public function guardarPersonalizadoObservacionesFormula($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesFormulacion (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesFormula
	
	
	//metodo para editar el personalizado de observaciones de formula 
	public function editarPersonalizadoObservacionesFormula($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesFormulacion SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionFormulacion = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesFormula	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOF($idPersonalizadoOF){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionFormulacion, titulo, texto, estado
						FROM tb_personalizados_observacionesFormulacion
						WHERE idPersonalizadoObservacionFormulacion = '$idPersonalizadoOF'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOF		
	


	//metodo para activar un pérsonalizado observaciones de formula 
	public function activarPersonalizadoObservacionesFormula($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesFormulacion SET estado = 'A' WHERE idPersonalizadoObservacionFormulacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesFormula	
	

	//metodo para desactivar un personalizado observaciones formula
	public function desactivarPersonalizadoObservacionesFormula($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesFormulacion SET estado = 'I' WHERE idPersonalizadoObservacionFormulacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesFormula	
	
	
//-------------------------------------------------------------------------------	Fin personalizado formula
		
			
	

	
//----------------------------------------------------------------------- Motivo de hospitalizacion	

	//buscar personalizado motivo hospitalizacion con string
	public function buscarPersonalizadoMHConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoMotivoHospitalizacion, titulo FROM tb_personalizados_motivoHospitalizacion ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoMotivoHospitalizacion, titulo FROM tb_personalizados_motivoHospitalizacion ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoMotivoHospitalizacion'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoMHConString 


	//consultar el total de motivo de hospitalización
	public function tatalPersonalizadosMH(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoMotivoHospitalizacion) as cantidadPersonalizados from tb_personalizados_motivoHospitalizacion ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosMH

	
	//listar la informacion de los motivos de hospitalización
	public function listarPersonalizadosMH($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoHospitalizacion, titulo, texto, estado
						FROM tb_personalizados_motivoHospitalizacion
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosMH
	
	
	//guardar personalizado de motivo hospitalizacion
	public function guardarPersonalizadoMotivoHospitalizacion($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_motivoHospitalizacion (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoMotivoHospitalizacion
	
	
	
	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoMH($idPersonalizadoMH){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoMotivoHospitalizacion, titulo, texto, estado
						FROM tb_personalizados_motivoHospitalizacion
						WHERE idPersonalizadoMotivoHospitalizacion = '$idPersonalizadoMH'";
						
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
			
	}//fin metodo consultarUnPersonalizadoMH
	
	
	//metodo para editar el personalizado de un motivo de hospitalizacion
	public function editarPersonalizadoMotivoHospitalizacion($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_motivoHospitalizacion SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoMotivoHospitalizacion = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoMotivoHospitalizacion
	
	
	//metodo para desactivar un personalizado del motivo de hospitalizacion
	public function desactivarPersonalizadoMotivoHospitalizacion($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoHospitalizacion SET estado = 'I' WHERE idPersonalizadoMotivoHospitalizacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoMotivoHospitalizacion
	
	
	
	//metodo para activar un pérsonalizado del motivo de hospitalizacion
	public function activarPersonalizadoMotivoHospitalizacion($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_motivoHospitalizacion SET estado = 'A' WHERE idPersonalizadoMotivoHospitalizacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoMotivoHospitalizacion	
	
	
////----------------------------------------------------- Fin motivo hospitalizacion

	
////----------------------------------------------------- observaciones hospitalizacion
	//buscar personalizado observaciones consulta con string
	public function buscarPersonalizadoOHConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoObservacionHospitalizacion, titulo FROM tb_personalizados_observacionesHospitalizacion ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoObservacionHospitalizacion, titulo FROM tb_personalizados_observacionesHospitalizacion ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoObservacionHospitalizacion'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOHConString 



	//consultar el total de observaciones de hospitalizacion
	public function tatalPersonalizadosOH(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoObservacionHospitalizacion) as cantidadPersonalizados from tb_personalizados_observacionesHospitalizacion ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosOH


	//listar la informacion de los observaciones de hospitalización
	public function listarPersonalizadosOH($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionHospitalizacion, titulo, texto, estado
						FROM tb_personalizados_observacionesHospitalizacion
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosOH


	//guardar personalizado de observacion hospitalizacion
	public function guardarPersonalizadoObservacionesHospitalizacion($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_observacionesHospitalizacion (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoObservacionesHospitalizacion	
	
	
	//metodo para editar el personalizado de observaciones de hospitalizacion
	public function editarPersonalizadoObservacionesHospitalizacion($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_observacionesHospitalizacion SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoObservacionHospitalizacion = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoObservacionesConsulta	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoOH($idPersonalizadoOH){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoObservacionHospitalizacion, titulo, texto, estado
						FROM tb_personalizados_observacionesHospitalizacion
						WHERE idPersonalizadoObservacionHospitalizacion = '$idPersonalizadoOH'";
						
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
			
	}//fin metodo consultarUnPersonalizadoOH		
	


	//metodo para activar un pérsonalizado observaciones de hospitalizacion
	public function activarPersonalizadoObservacionesHospitalizacion($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesHospitalizacion SET estado = 'A' WHERE idPersonalizadoObservacionHospitalizacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoObservacionesHospitalizacion		
	

	//metodo para desactivar un personalizado observaciones hospitalizacion
	public function desactivarPersonalizadoObservacionesHospitalizacion($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_observacionesHospitalizacion SET estado = 'I' WHERE idPersonalizadoObservacionHospitalizacion = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoObservacionesHospitalizacion	

	
	
////-------------------------------------------------------------------------------------observaciones Hospitalizacion
			
	

	
	
////----------------------------------------------------- cuidados alta
	//buscar personalizado cuidados alta con string
	public function buscarPersonalizadoCAConString($sting, $utilizar = 'No'){
            
            $sting  = parent::escaparQueryBDCliente($sting); 
            
            $resultado = array();


			if($utilizar == 'No'){
				
				$query  = "SELECT idPersonalizadoCuidadosAlta, titulo FROM tb_personalizados_cuidadosAlta ".
					    " where  (titulo like '%$sting%') ";
			}else{
				
				$query  = "SELECT idPersonalizadoCuidadosAlta, titulo FROM tb_personalizados_cuidadosAlta ".
					    " where  (titulo like '%$sting%') AND estado = 'A' ";
			}

	            
            $conexion = parent::conexionCliente();
		
    		if($res = $conexion->query($query)){
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] =   array('label' => $filas['titulo'],
	                    						'id' => $filas['idPersonalizadoCuidadosAlta'],
	                    						'nombre' => $filas['titulo'],
	                    						'value' => $filas['titulo'] );
	                }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;	

        }//fin metodo buscarPersonalizadoOHConString 



	//consultar el total de cuidados alta
	public function tatalPersonalizadosCA(){

			$resultado = array();
			
			$query = "Select count(idPersonalizadoCuidadosAlta) as cantidadPersonalizados from tb_personalizados_cuidadosAlta ";
			
			$conexion = parent::conexionCliente();
			
			if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado = $filas;
	                }
	            
	                /* liberar el conjunto de resultados */
	                $res->free();
	           
	        }
	
	        return $resultado['cantidadPersonalizados'];	
		
	}//fin metodo tatalPersonalizadosCA


	//listar la informacion de los cuidados alta
	public function listarPersonalizadosCA($idUsuario, $paginaActual,$records_per_page){

			$resultado = array();
		
			$query = " SELECT idPersonalizadoCuidadosAlta, titulo, texto, estado
						FROM tb_personalizados_cuidadosAlta
						WHERE idUsuario = '$idUsuario'
						ORDER BY (titulo)
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
			
		
	}//fin metodo listarPersonalizadosCA


	//guardar personalizado de cuidados alta
	public function guardarPersonalizadoCuidadosAlta($titulo, $texto, $idUsuario){
		
		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		
		 $query = "INSERT INTO tb_personalizados_cuidadosAlta (titulo, texto, estado, idUsuario) ".
                        " VALUES ('$titulo', '$texto' ,'A', '$idUsuario') ";
           
		   
		   
	       $conexion = parent::conexionCliente();
			
	        if($res = $conexion->query($query)){
	            
	                $resultado = "Ok";
	        }
	
	        return $resultado;
		
		
	}	//fin metodo guardarPersonalizadoCuidadosAlta	
	
	
	//metodo para editar el personalizado de cuidados alta
	public function editarPersonalizadoCuidadosAlta($idPersonalizado, $titulo, $texto){

		$titulo  = parent::escaparQueryBDCliente($titulo);
		$texto   = parent::escaparQueryBDCliente($texto);
		
		$query	= "UPDATE tb_personalizados_cuidadosAlta SET titulo = '$titulo', texto = '$texto' 
					WHERE idPersonalizadoCuidadosAlta = '$idPersonalizado'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo editarPersonalizadoCuidadosAlta	
	
	

	//metodo para consultar los datos de un personalizado
	public function consultarUnPersonalizadoCA($idPersonalizadoCA){
		
			$resultado = array();
		
			$query = " SELECT idPersonalizadoCuidadosAlta, titulo, texto, estado
						FROM tb_personalizados_cuidadosAlta
						WHERE idPersonalizadoCuidadosAlta = '$idPersonalizadoCA'";
						
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
			
	}//fin metodo consultarUnPersonalizadoCA		
	


	//metodo para activar un pérsonalizado cuidados alta
	public function activarPersonalizadoCuidadosAlta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_cuidadosAlta SET estado = 'A' WHERE idPersonalizadoCuidadosAlta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo activarPersonalizadoCuidadosAlta		
	

	//metodo para desactivar un personalizado cuidados alta
	public function desactivarPersonalizadoCuidadosAlta($idPersonalizado){
		
           $query = "UPDATE tb_personalizados_cuidadosAlta SET estado = 'I' WHERE idPersonalizadoCuidadosAlta = '$idPersonalizado' ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
            }
    
            return $resultado;  		
		
		
	}//fin metodo desactivarPersonalizadoCuidadosAlta	

	
	
////-------------------------------------------------------------------------------------fin cuidados alta
	
	
		
	
																		
}//fin clase


?>