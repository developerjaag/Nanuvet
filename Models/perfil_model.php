<?php



/**
 * Clase para administrar los datos del perfil d eun usuario
 */
class perfiles extends Config {
	

	//metodo para consultar los datos de  un usuario
	public function consultarDatosUsuario($idUsuario){
		
		$resultado = array();
		
		$query = "SELECT U.identificacion, U.nombre, U.apellido, U.telefono, U.celular, U.direccion, U.email, U.urlFoto, U.idIdioma, I.urlArchivo 
					FROM tb_usuarios AS U INNER JOIN tb_idiomas AS I ON U.idIdioma = I.idIdioma
				 WHERE idUsuario = '$idUsuario' ";
		
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
           
        }

        return $resultado;
		
		
	}//fin metodo consultarDatosUsuario
	
	//metodo paraconfirmar la contraseña actual de un usuario
	public function confirmarPass($idUsuario){
		
		$resultado = "";
		
		$query = "SELECT pass
					FROM tb_usuarios WHERE idUsuario = '$idUsuario' ";
		
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas['pass'];
                }
            
           
        }

        return $resultado;
		
		
	}//fin metodo confirmarPass
	
	
	//metodo para cambiar la contraseña de un usuario
	public function cambiarPass($nuevaPass, $idUsuario){
		
		$resultado = "OK";
		
		$query = "UPDATE tb_usuarios  SET pass = '$nuevaPass' WHERE idUsuario = '$idUsuario' ";
		
		$conexion = parent::conexionCliente();
    		
        $res = $conexion->query($query);

        return $resultado;
		
		
	}//fin metodo cambiarPass
	
	
	//metodo para actualizar los datos de un usuario
	public function actualizarUsuario($idUsuario,$identificacion,$nombres,$apellidos,$telefono,$celular,$direccion,$email,$idioma,$urlFoto){
			
		$identificacion  = parent::escaparQueryBDCliente($identificacion);
		$nombres  		 = parent::escaparQueryBDCliente($nombres);
		$apellidos  	 = parent::escaparQueryBDCliente($apellidos);
		$telefono  		 = parent::escaparQueryBDCliente($telefono);
		$celular  		 = parent::escaparQueryBDCliente($celular);
		$direccion  	 = parent::escaparQueryBDCliente($direccion);
		$email  		 = parent::escaparQueryBDCliente($email);
		$idioma  		 = parent::escaparQueryBDCliente($idioma);			
				
		$resultado = "OK";
		
		//saber si llega una imagen de lo contrario se deja como estaba
		if($urlFoto == ""){
			$query = "UPDATE tb_usuarios  
					SET identificacion = '$identificacion', nombre = '$nombres', apellido = '$apellidos', telefono = '$telefono', celular = '$celular',
					 direccion = '$direccion', email = '$email', idIdioma = '$idioma'
				WHERE idUsuario = '$idUsuario' ";
		}else{
			$query = "UPDATE tb_usuarios  
					SET identificacion = '$identificacion', nombre = '$nombres', apellido = '$apellidos', telefono = '$telefono', celular = '$celular',
					 direccion = '$direccion', email = '$email', idIdioma = '$idioma', urlFoto = '$urlFoto'
				WHERE idUsuario = '$idUsuario' ";
		}
		
		
		
		$conexion = parent::conexionCliente();
    		
        $res = $conexion->query($query);

        return $resultado;	
		
	}//fin metodo actualizarUsuario
	
	
}//fin clase




?>