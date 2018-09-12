<?php

/**
 * Clase que contiene la configuracion general de la aplicación
 */
class Config  {
	
	/*
	 * retorna la ruta absoluta de la aplicación
	 */
	public function ruta() {
		//https://quiazack-jaag2106.c9users.io/phpmyadmin/
		return "http://www.nanuvet.com/";
		
	}//fin metodo ruta
	
	
	
	/*
	 * retorna la conexion a la base de datos principal que contiene las conexiones a las demas
	 */
	public function conexionAdmin(){
		
	    $link = mysqli_connect('localhost','root','3104588379Chessmaster1Quiana','AAAadmonNanuVet') or die("Error en la conexión a a la BD admin" . mysqli_error($link));
		$link->query("SET NAMES 'utf8'");
		return $link;
		
	}//fin metodo conexion
	
	
	/*
	 * retorna la conexion para crear una base de datos
	 */
	static function conexionCrearBD(){
		
	    $link = mysqli_connect('localhost','root','3104588379Chessmaster1Quiana','') or die("Error en la conexión para crear BD" . mysqli_error($link));
		$link->query("SET NAMES 'utf8'");
		return $link;
		
		
	}//fin metodo conexion	


	
	/*
	 * retorna la conexion para la base de datos web
	 */
	static function conexionWeb(){
		
	    $link = mysqli_connect('localhost','root','3104588379Chessmaster1Quiana','AAAweb') or die("Error en la conexión para la web" . mysqli_error($link));
		$link->query("SET NAMES 'utf8'");
		return $link;
		
		
	}//fin metodo conexion	



	/*
     * Retorna la conexión la conexión a la base de datos del cliente
     */
	public function conexionCliente($nombreBD = null, $servidorBD = null, $usuarioBD = null, $passBD = null){
       	
       	if(!isset($_SESSION)){
		    session_start();
		}
       	
       	if( ($nombreBD == null) or ($servidorBD == null) or ($usuarioBD == null) or ($passBD == null) ){

       		//si algun parametro es null se verifica las variables de session
       		if( (isset($_SESSION['BDC_ubicacion_BD'])) and (isset($_SESSION['BDC_usuario_BD'])) and (isset($_SESSION['BDC_pass_BD'])) and (isset($_SESSION['BDC_nombre_BD']))  ){
       			
       			$servidorBD	= $_SESSION['BDC_ubicacion_BD'];
       			$usuarioBD	= $_SESSION['BDC_usuario_BD'];
       			$passBD		= $_SESSION['BDC_pass_BD'];
       			$nombreBD	= $_SESSION['BDC_nombre_BD'];
       			
       			$link = new mysqli($servidorBD, $usuarioBD, $passBD, $nombreBD);
       			
       		}else{
       			//sino llegaron los parametros y no estan definidas las variablese de sesion se redirecciona al principio
       			 header('Location: '.$this->ruta() );
       			 exit();
       		}
       		
       	}else{
       		
       		$link = new mysqli($servidorBD, $usuarioBD, $passBD, $nombreBD);
       		
       	}//fin else si llegan las variables por la funcion

        if ($link->connect_error) {
            die('Error en conexión a base de datos del cliente (' . $link->connect_errno . ') ' . $link->connect_error);
        }
		
		$link->query("SET NAMES 'utf8'");
		
		return $link;
		
		
	}//fin metodo conexion cliente
	
	
	/*
	 * 	Metodo que retorna la conexion a la base de datos de replica 
	 */
	public function conexionReplica(){

	    $link = mysqli_connect('localhost','root','3104588379Chessmaster1Quiana','AAAReplica') or die("Error en la conexión replica" . mysqli_error($link));
		$link->query("SET NAMES 'utf8'");
		return $link;
		
	}
	
	/*
    * Metodo para escapar y devolver correctamente un parametro para un query (en la base de datos administrativa) 
    */
	public function escaparQueryBDAdmin($parametro){
	    
        $conexion = $this->conexionAdmin();
        
        $parametro = $conexion->real_escape_string($parametro);
        
        return $parametro;
	}
	
	
     /*
     * Metodo para escapar y devolver correctamente un parametro para un query(en la base de datos del cliente) 
     */
    public function escaparQueryBDCliente($parametro){
        
        $conexion = $this->conexionCliente();
        
        $parametro = $conexion->real_escape_string($parametro);
        
        return $parametro;
    }
	

	/*
    * Metodo para escapar y devolver correctamente un parametro para un query (en la base de datos de la web) 
    */
	public function escaparQueryBDWeb($parametro){
	    
        $conexion = $this->conexionWeb();
        
        $parametro = $conexion->real_escape_string($parametro);
        
        return $parametro;
	}
	
	
	/*
    * Metodo para escapar y devolver correctamente un parametro para un query (en la base de datos de la replica) 
    */
	public function escaparQueryBDReplica($parametro){
	    
        $conexion = $this->conexionReplica();
        
        $parametro = $conexion->real_escape_string($parametro);
        
        return $parametro;
	}
		
	
	/*
		* Metodo para detectar el idioma del cliente o navegador
	*/
	public function getUserLanguage() {  
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
		$browser_lang = substr($browser_lang, 0,2);
		
		return $browser_lang;
		
  	}//fin metodo para obtener el idioma
	
}//fin clase Config



/* Truncate tablas con foreign key 

	SET FOREIGN_KEY_CHECKS = 0; 
	TRUNCATE tb_especies; 
	SET FOREIGN_KEY_CHECKS = 1;

*/

/*
 if(!isset($_SESSION)) {
	     session_start();
	}
 * */
