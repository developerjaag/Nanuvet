<?php


/**
 * Clase para manipular la información de la cuenta, consultar y adicionar licencias
 */
class cuenta extends Config {
	
	//metodo para consultar la informacion de la cuenta
	public function consultarInformacionCuenta(){
		
		$resultado	= array();
		
		$query = "SELECT identificativoNit, nombre, telefono1, telefono2, celular, direccion, email, urlLogo FROM tb_clinica";
				
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
           
        }

        return $resultado;		
		
		
	}//fin metodo consultarInformacionCuenta
	
	
	//metodo para actualizar la informacion d ela cuenta
	public function actualizarInformacionCuenta($identificacion, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlFoto){
		
		$resultado = "ok";
		
		$identificacion  	 = parent::escaparQueryBDCliente($identificacion);		
		$nombre  		 	 = parent::escaparQueryBDCliente($nombre);		
		$telefono1  		 = parent::escaparQueryBDCliente($telefono1);		
		$telefono2  		 = parent::escaparQueryBDCliente($telefono2);
		$celular  		 	 = parent::escaparQueryBDCliente($celular);		
		$direccion  		 = parent::escaparQueryBDCliente($direccion);		
		$email  		 	 = parent::escaparQueryBDCliente($email);	
		$urlFoto  		 	 = parent::escaparQueryBDCliente($urlFoto);	
		
		//saber si llega una imagen de lo contrario se deja como estaba
		if($urlFoto == ""){
			$query = "UPDATE tb_clinica  
					SET identificativoNit = '$identificacion', nombre = '$nombre', telefono1 = '$telefono1', telefono2 = '$telefono2', celular = '$celular',
					 direccion = '$direccion', email = '$email'
				WHERE idClinica = '1' ";
		}else{
			$query = "UPDATE tb_clinica  
					SET identificativoNit = '$identificacion', nombre = '$nombre', telefono1 = '$telefono1', telefono2 = '$telefono2', celular = '$celular',
					 direccion = '$direccion', email = '$email', urlLogo = '$urlFoto'
				WHERE idClinica = '1' ";
		}		
		
		
		$conexion = parent::conexionCliente();
    		
        $res = $conexion->query($query);

        return $resultado;			
		
		
	}//fin metodo actualizarInformacionCuenta
	
	
	//metodo para consultar el listado de licencias
	public function consultarLicencias($idCliente){
		
		$resultado	= array();
		
		$query = "SELECT idLicencia, fechaAdquisicion, fechaInicio, fechaFin, estado FROM tb_licencias WHERE idListadoClienteNV = '$idCliente' order by estado DESC ";
		
		$conexion = parent::conexionAdmin();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
           
        }

        return $resultado;	
		
	}//fin metodo consultarLicencias
	
	
	//metodo para consultar la informacion de un usuario que este utlizando una licencia
	public function consultarInformaiconUsuario($idLicencia){
					
		$resultado = array();
		
		$query = "SELECT idUsuario, identificacion, nombre, apellido, estado FROM tb_usuarios WHERE idLicencia = '$idLicencia'";
		
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
           
        }

        return $resultado;			
			
		
	}//fin metodo consultarInformaiconUsuario
	
	
	//metodo para desvincular la licencia de un usuario
	public function desvincularLicencia($idLicencia){
		
		$retorno	= "";
		
		$resultado	= array();
		
		$query = "SELECT COUNT(idUsuario) AS cantidad FROM tb_usuarios WHERE idLicencia <> '0'";
		
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
           
        }
        
        if($resultado['cantidad'] <= 1){
        	$retorno = "No se puede quitar la licencia";
        }else{
        	
			$query2 = "UPDATE tb_usuarios SET idLicencia = '0' WHERE idLicencia = '$idLicencia'";
			
			$res2 = $conexion->query($query2);
			
			$retorno = "Cambio Ok";
        }
		
		return $retorno;
		
		
	}//fin metodo desvincularLicencia
	
	
	//metodo para consultar los datos de los usuarios sin licencia
	public function usuariosSinLicencia(){
		
		$resultado	= array();
		
		$query = "SELECT idUsuario, identificacion, nombre, apellido FROM tb_usuarios WHERE idLicencia = '0'";
		
		$conexion = parent::conexionCliente();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
           
        }	
		
		return $resultado;	
		
		
	}//fin metodo usuariosSinLicencia
	
	
	//metodo para vincular una licencia con un usuario
	public function vincularLicenciaUsuario($idUsuarioVincular, $idLicenciaVincular){
		
		$query = "UPDATE tb_usuarios SET idLicencia = '$idLicenciaVincular' WHERE idUsuario = '$idUsuarioVincular' ";
		
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query);
		
	}//fin metodo vincularLicenciaUsuario
	
	//metodo para ocupar una licencia
	public function ocuparLicencia($idLicenciaVincular){
		
		$query = "UPDATE tb_licencias SET estado = 'EnUso' WHERE idLicencia = '$idLicenciaVincular' ";
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);
		
		
	}//fin ocuparLicencia
	
	//metodo para marcar una licenciua como disponible
	public function liberarLicencia($idLicenciaLiberar){
		
		$query = "UPDATE tb_licencias SET estado = 'Disponible' WHERE idLicencia = '$idLicenciaLiberar' ";
		
		$conexion = parent::conexionAdmin();
		
		$res = $conexion->query($query);
		
	}//fin metodo liberarLicencia
	
	
	//metodo para consultar la información del titular de la cuenta
	public function consultarDatosTitular($idTitularTabla){
		
		$retultado = array();
		
		$query = "SELECT identificacion, email, celular, direccion, telefono1 FROM tb_listadoClienteNV  WHERE idListadoClienteNV = '$idTitularTabla'";
				
		$conexion = parent::conexionAdmin();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas;
                }
            
           
        }	
		
		return $resultado;	
		
		
	}//fin metodo consultarDatosTitular
	
	
	//metodo para consultar las licencias libres y con fecha de vencimiento sin cumplirse
	public function consultarLicenciasParaVincularUsuario($idCliente){
				
		$resultado	= array();
		
		$query = "SELECT idLicencia, fechaFin 
					FROM tb_licencias 
				  WHERE (idListadoClienteNV = '$idCliente') AND (fechaFin > NOW()) AND (estado = 'Disponible')  ";
		
		$conexion = parent::conexionAdmin();
    		
        if($res = $conexion->query($query)){
           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado[] = $filas;
                }
            
           
        }

        return $resultado;		
		
	}//fin metodo consultarLicenciasParaVincularUsuario
	
	
	//metodo para consultar si la cuenta es demos
	public function consultarCuentaDemo($idCliente){
		
		$resultado = "No";
		
		$query = "SELECT demo FROM tb_listadoClienteNV WHERE idListadoClienteNV = '$idCliente'";
		
		$conexion = parent::conexionAdmin();
    		
	        if($res = $conexion->query($query)){
	           
               /* obtener un array asociativo */
                while ($filas = $res->fetch_assoc()) {
                    $resultado = $filas['demo'];
                }
            
           
        }

        return $resultado;	
		
		
	}//fin metodo consultarCuentaDemo
	
	
	
}//fin clase


?>