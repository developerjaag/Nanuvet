<?php

/**
 * Clase para manipular los datos d elos usuarios
 */
class usuarios extends Config {
	
	//metodo para consultar todos los usuarios registrados
	public function listarUsuariosSelect(){
		
		$resultado = array();
		
		$query = "SELECT idUsuario, identificacion, nombre, apellido, estado FROM tb_usuarios ";
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }                
               
         }//fin if
		
        return $resultado;	
		
		
	}//fin metodo listarTodosUsuarios
	
	
	//metodo para consultar los datos de los usuarios
	public function listarUsuarios(){
		
		$resultado = array();
		
		$query = "SELECT idUsuario, identificacion, nombre, apellido, telefono, celular, direccion, email, urlFoto, agenda, estado, idLicencia 
					FROM tb_usuarios ";
		
		$conexion = parent::conexionCliente();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado[] = $filas;
            }                
               
         }//fin if
		
        return $resultado;
		
		
	}//fin metodo listarUsuarios
	
	
	//metodo para consultar la fecha final de la vigencia de un usuario
	public function consultarFechaFinLicencia($idLicencia){
		
		$resultado = "";
		
		$query = "SELECT fechaFin
					FROM tb_licencias  WHERE idLicencia = '$idLicencia'";
		
		$conexion = parent::conexionAdmin();
		
    	if($res = $conexion->query($query)){
               
           /* obtener un array asociativo */
            while ($filas = $res->fetch_assoc()) {
                $resultado = $filas['fechaFin'];
            }                
               
         }//fin if
		
        return $resultado;
		
	}//fin metodo consultarFechaFinLicencia
	
	//metodo para guardar un usuario
	public function guardarUsuario($identificacion, $nombre, $apellido, $pass, $telefono, $celular, $direccion, $email, $usarAgenda, $idioma, $estado, $licencia){
		
		$idGuardado = "";
		
		
		$identificacion       			= parent::escaparQueryBDCliente($identificacion); 
		$nombre       					= parent::escaparQueryBDCliente($nombre); 
		$apellido       				= parent::escaparQueryBDCliente($apellido); 
		$pass       					= parent::escaparQueryBDCliente($pass); 
		$telefono       				= parent::escaparQueryBDCliente($telefono); 
		$celular       					= parent::escaparQueryBDCliente($celular); 
		$direccion       				= parent::escaparQueryBDCliente($direccion); 
		$email       					= parent::escaparQueryBDCliente($email); 
		$usarAgenda       				= parent::escaparQueryBDCliente($usarAgenda); 
		$idioma       					= parent::escaparQueryBDCliente($idioma); 
		$estado       					= parent::escaparQueryBDCliente($estado); 
		$licencia       				= parent::escaparQueryBDCliente($licencia); 
		
		
		
		$query = "INSERT INTO tb_usuarios
					(tipoIdentificacion,identificacion,nombre,apellido,pass,telefono,celular,direccion,email,
					agenda,idIdioma,estado,idLicencia)
				  VALUES
					('CC', '$identificacion', '$nombre', '$apellido', '$pass', '$telefono', '$celular', '$direccion', '$email',
						'$usarAgenda', '$idioma', '$estado', '$licencia' );";
		

		
		$conexion = parent::conexionCliente();	
	    	
		$res = $conexion->query($query);
		
		$query2 = "SELECT max(idUsuario) AS ultimoId FROM tb_usuarios ";
		
		if($res2 = $conexion->query($query2)){
               
           /* obtener un array asociativo */
            while ($filas2 = $res2->fetch_assoc()) {
                $idGuardado = $filas2['ultimoId'];
            }                
               
         }//fin if
		
        return $idGuardado;
		
		
	}//fin metodo guardarUsuario
	
	
	//funcion para editar un usuarios desde admin
	public function actualizarUsuarioDesdeAdmin($idUsuario, $telefono, $celular, $direccion, $utilizarAgenda, $estado){
						
		$idUsuario       		= parent::escaparQueryBDCliente($idUsuario); 
		$telefono       		= parent::escaparQueryBDCliente($telefono); 
		$celular       			= parent::escaparQueryBDCliente($celular); 
		$direccion       		= parent::escaparQueryBDCliente($direccion); 
		$utilizarAgenda       	= parent::escaparQueryBDCliente($utilizarAgenda); 
		$estado       			= parent::escaparQueryBDCliente($estado); 			
				
		$query = "UPDATE tb_usuarios SET telefono = '$telefono', celular = '$celular', direccion = '$direccion', agenda = '$utilizarAgenda', estado = '$estado' WHERE idUsuario = '$idUsuario' ";	
		
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo actualizarUsuarioDesdeAdmin
	
	
	
}//fin clase




?>