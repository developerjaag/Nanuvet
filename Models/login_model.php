<?php

    /*
        * clase para manipular y confornttar los datos de inicio de sesión
    */
    
    class login extends Config{
        
        //metodo para validar los datos ingresados
        public function loginUsuario($servidor,$BD,$usuarioBD,$passBD,$usuario){
        
            $resultado = array();
    		
    		$servidor   = parent::escaparQueryBDAdmin($servidor);
    		$BD   		= parent::escaparQueryBDAdmin($BD);
    		$usuarioBD  = parent::escaparQueryBDAdmin($usuarioBD);
    		$passBD   	= parent::escaparQueryBDAdmin($passBD);
    		$usuario   	= parent::escaparQueryBDAdmin($usuario);
            
            $query = "Select U.idUsuario, U.identificacion, U.nombre, U.apellido, U.pass , U.urlFoto, U.idIdioma, U.estado, U.idLicencia , U.idLicencia, I.urlArchivo  ".
                     " from tb_usuarios as U".
                     " inner join tb_idiomas as I on U.idIdioma = I.idIdioma ".
                     " where U.identificacion = '$usuario'  ";

    		$conexion = parent::conexionCliente($BD, $servidor, $usuarioBD, $passBD);
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado = $filas;
                    }
                
                    /* liberar el conjunto de resultados */
                    $res->free();
               
            }
    
            return $resultado;
         
        }//fin metodo para validar los datos
        
        
        //metodo para consultar si una licencia esta vencida
        public function comprobarVencimientoLicencia($idLicencia){
        			
        	$resultado = 0;
        	
        	$query = "SELECT fechaFin FROM tb_licencias WHERE (idLicencia = '$idLicencia') AND (fechaFin >= NOW())";	
			
			$conexion = parent::conexionAdmin();
			
			if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado = 1;
                    }
                               
            }
    
            return $resultado;
        	
        }//fin metodo comprobarVencimientoLicencia
        
        
    }//fin clase