<?php

/**
 * Clase para administrar los permisos d eun usuario
 */
class permisos extends Config {
	
	//metodo para consultar los permisos de un usuario
	public function consultarPermisosUsuario($idUsuario){
		
		$resultado	= array();
		
		$query	= "SELECT idPermisoUsuario, idPermiso  FROM tb_permisos_usuarios WHERE idUsuario = '$idUsuario' AND estado = 'A'";
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }                
               
         }//fin if
		
        return $resultado;	
		
		
	}//fin metodo consultarPermisosUsuario
	
	//metodo para cambiar el estado de un permiso
	public function cambiarEstadoPermiso($idUsuario, $estado, $idPermiso){
		
		$resultado  = '';
		$resultado1 = '';
		
		//se comprueba si el registro existe
		
		$query1 = "SELECT idPermisoUsuario FROM tb_permisos_usuarios WHERE idUsuario = '$idUsuario' AND idPermiso = '$idPermiso' ";
		
		
		
		$conexion = parent::conexionCliente();
		
    	if($res1 = $conexion->query($query1)){
               
           /* obtener un array asociativo */
            while ($filas1 = $res1->fetch_assoc()) {
                $resultado1 = $filas1['idPermisoUsuario'];
            }                
               
         }//fin if
		
		
		
		//si se obtuvo resultado se actualiza
		if($resultado1 != ''){
			
			$query2 = "UPDATE tb_permisos_usuarios SET estado = '$estado' WHERE idPermisoUsuario = '$resultado1' ";
			
		}else{
			
			$query2 = "INSERT INTO tb_permisos_usuarios(idPermiso,idUsuario,estado) VALUES('$idPermiso','$idUsuario','$estado') ";
			
		}//fin else
		

		
		$res2 = $conexion->query($query2);
		
		return "OK";
		
		
		
	}//fin metodo cambiarEstadoPermiso
	
	
	
}//fin clase



?>