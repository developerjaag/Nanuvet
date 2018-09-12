<?php

    /*
        * modelo con funciones generales utilizadas a la largo del aplicativo
    */
    
    class shop_model extends Config{
        
        /*Metodo para buscar el cliente en la base de datos proncipal y retornar la conexión a tal base de datos*/
        public function conexionBDCliente($identifiacionTitular = ''){
         
		 		if($identifiacionTitular == ''){
		 			$identifiacionTitular	= $_SESSION['identificacion_cliente']; 
		 		}
		 
                $resultado = array();
                
                if(isset($_SESSION['BDC_id']) and isset($_SESSION['BDC_ubicacion_BD']) and isset($_SESSION['BDC_usuario_BD']) and isset($_SESSION['BDC_pass_BD']) and isset($_SESSION['BDC_nombre_BD']) and isset($_SESSION['BDC_estado'] )){
                
                    $resultado = array("BDC_id" => $_SESSION['BDC_id'], "BDC_ubicacion_BD" => $_SESSION['BDC_ubicacion_BD'],
                                        "BDC_usuario_BD" => $_SESSION['BDC_usuario_BD'], "BDC_pass_BD" => $_SESSION['BDC_pass_BD'], "BDC_nombre_BD" => $_SESSION['BDC_nombre_BD'],
                                        "BDC_estado" => $_SESSION['BDC_estado']);
                }else{
        
        
                    $identifiacionTitular   = parent::escaparQueryBDAdmin($identifiacionTitular);
                    
                    $query = "Select idListadoClienteNV as BDC_id, ubicacion_BD as BDC_ubicacion_BD, usuario_BD as BDC_usuario_BD, pass_BD as BDC_pass_BD, nombre_BD as BDC_nombre_BD, estado as  BDC_estado ".
                             " from tb_listadoClienteNV ".
                             " where identificacion = '$identifiacionTitular'";
                 
            
                    $conexion = parent::conexionAdmin();
            
            
                    if($res = $conexion->query($query)){
                       
                           /* obtener un array asociativo */
                            while ($filas = $res->fetch_assoc()) {
                                $resultado = $filas;
                            }
                        
                       
                    }
        
                    
                }//fin si no existen las variables de session, que permiten no hacer una consulta a la bd
        
                return $resultado;
         
        }//fin metodo para consultar la base de datos de un cliente
        
        
        //metodo para consultar que tutoriales que se muestran a un usuario
        public function consultarTutorialesUsuario($idUsuario){
        	
        	$resultado = array();
        	
			$query	= "SELECT  idIntroTutorial  
						FROM tb_usuario_introTutorial  
						WHERE idUsuario = '$idUsuario' AND estado = 'I'";
			
			$conexion = parent::conexionCliente();
			
			 if($res = $conexion->query($query)){
                       
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado[] = $filas['idIntroTutorial'];
                    }
 
            }//fin if
            
            return $resultado;

        }//fin metodo consultarTutorialesUsuario
        
        
        //metodo para actualizar el estado de un tutorial
        public function actualizarTutorial($numeroTutorial, $estado = '', $usuario){
        	
			$conexion = parent::conexionCliente();
			
			$idActualizar = "";
			
			$query1 = "SELECT idUsuarioIntroTutorial FROM tb_usuario_introTutorial WHERE idIntroTutorial = '$numeroTutorial' AND idUsuario = '$usuario' ";
        	
			
			
			if($res = $conexion->query($query1)){
					//obtener el numero de resultados que devuelve la consulta   
                   $rowcount=mysqli_num_rows($res);
                   
                  
                   
                   //si el resultado qes igual o mayor a 1 se actualiza, sino se inserta el registro
                   if($rowcount >= 1){
                   	
						while ($filas = $res->fetch_assoc()) {
	                        $idActualizar = $filas['idUsuarioIntroTutorial'];
	                    }
                   	
					 	$query2 = "UPDATE tb_usuario_introTutorial SET estado = '$estado' WHERE idUsuarioIntroTutorial = '$idActualizar'";
					
                   }else{
                   	
						$query2 = "INSERT INTO tb_usuario_introTutorial
									(idIntroTutorial,idUsuario,estado)
									VALUES
									('$numeroTutorial','$usuario','I')";
					
                   }//fin else
                   
                   
                   
                   $res2 = $conexion->query($query2);
                   
                   return 'OK';
 
            }//fin if
			
			
        }//fin metodo actualizarTutorial
        
        
        //metodo para consultar los permisos que tiene un usuario
        public function permisos_consultarPermisosUsuario($idUsuario){
        	
			$resultado = array();
        	
			$query	= "SELECT  idPermiso  
						FROM tb_permisos_usuarios  
						WHERE idUsuario = '$idUsuario' AND estado = 'A'";
			
			
			$conexion = parent::conexionCliente();
			
			 if($res = $conexion->query($query)){
                       
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_array() ) {
                        $resultado[] = $filas['idPermiso'];
                    }
 
            }//fin if
            
            return $resultado;
			
        }//fin metodo permisos_consultarPermisosUsuario    
        
        
    }//fin clase
    