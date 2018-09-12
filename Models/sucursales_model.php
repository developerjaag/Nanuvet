<?php

    /*
        * Clase que controla los datos de las sucursales
    */
    
    class sucursales extends Config{
       
       
       //metodo para varificar si existe una sucursal
       public function guardarSucursal($identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlLogo, $leyendaencabezado, $idPais, $idCiudad, $idBarrio, $latitud = "", $longitud = "" ){
           
           $identificativoNit       = parent::escaparQueryBDCliente($identificativoNit); 
           $nombre                  = parent::escaparQueryBDCliente($nombre);  
           $telefono1               = parent::escaparQueryBDCliente($telefono1);  
           $telefono2               = parent::escaparQueryBDCliente($telefono2);  
           $celular                 = parent::escaparQueryBDCliente($celular);  
           $direccion               = parent::escaparQueryBDCliente($direccion);  
           $email                   = parent::escaparQueryBDCliente($email);  
           $urlLogo                 = parent::escaparQueryBDCliente($urlLogo);  
           $leyendaencabezado       = parent::escaparQueryBDCliente($leyendaencabezado);  
           $idPais                  = parent::escaparQueryBDCliente($idPais);  
           $idCiudad                = parent::escaparQueryBDCliente($idCiudad);  
           $idBarrio                = parent::escaparQueryBDCliente($idBarrio); 
		   $latitud                 = parent::escaparQueryBDCliente($latitud); 
		   $longitud                = parent::escaparQueryBDCliente($longitud); 
           
           
           $resultado = "";
           
           $query = "INSERT INTO tb_sucursales (identificativoNit, nombre, telefono1, telefono2, celular, direccion, email, urlLogo, leyendaencabezado, estado, idPais, idCiudad, idBarrio, idClinica, longitud, latitud ) ".
                        " VALUES ('$identificativoNit', '$nombre', '$telefono1', '$telefono2', '$celular', '$direccion', '$email', '$urlLogo', '$leyendaencabezado', 'A', '$idPais', '$idCiudad', '$idBarrio', '1', '$longitud', '$latitud') ";
           
           
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
                
                    $resultado = "Ok";
               
            }
    
            return $resultado;
           
           
       }//fin metodo comprobarExistenciaSucursal
       
       
       //metodo para consultar la informacion de las sucursales
        public function consultarInfomacionSucursales(){
        	
			$resultado = array();
			
			$query = "SELECT S.idSucursal, S.identificativoNit, S.nombre, S.telefono1, S.telefono2, S.celular, S.direccion, S.longitud, S.latitud, S.email, S.urlLogo, S.leyendaencabezado,
						S.estado, S.idPais, S.idCiudad, S.idBarrio, C.nombre as NombreCiudad, P.nombre as NombrePais, B.nombre as NombreBarrio
					  FROM tb_sucursales AS S
					  	INNER JOIN tb_ciudades AS C ON S.idCiudad = C.idCiudad
					  	INNER JOIN tb_barrios AS B ON S.idBarrio = B.idBarrio
					  	INNER JOIN tb_paises AS P ON S.idPais = P.idPais";
			
			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;
			
			
        }//fin metodo consultarInfomacionSucursales
        
 
    	 //metodo para editar una sucursal
	    public function editarSucursal($idSucursal,$identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email, $urlLogo, $leyendaencabezado, $idPais, $idCiudad, $idBarrio, $latitud, $longitud, $estado  ){
	    			
	    	$idSucursal       			= parent::escaparQueryBDCliente($idSucursal); 	
	    	$identificativoNit       	= parent::escaparQueryBDCliente($identificativoNit);
	    	$nombre       				= parent::escaparQueryBDCliente($nombre); 	
	    	$telefono1       			= parent::escaparQueryBDCliente($telefono1); 	
	    	$telefono2       			= parent::escaparQueryBDCliente($telefono2); 	
			$celular       				= parent::escaparQueryBDCliente($celular); 	
			$direccion       			= parent::escaparQueryBDCliente($direccion); 	
			$email       				= parent::escaparQueryBDCliente($email); 	
			$urlLogo       				= parent::escaparQueryBDCliente($urlLogo); 	
			$leyendaencabezado       	= parent::escaparQueryBDCliente($leyendaencabezado); 	
			$idPais       				= parent::escaparQueryBDCliente($idPais); 	
			$idCiudad       			= parent::escaparQueryBDCliente($idCiudad); 	
			$idBarrio       			= parent::escaparQueryBDCliente($idBarrio); 	
			$latitud       				= parent::escaparQueryBDCliente($latitud); 	
			$longitud       			= parent::escaparQueryBDCliente($longitud); 
			
			$resultado = "OK";
		
			//saber si llega una imagen de lo contrario se deja como estaba
			if($urlFoto == ""){
				$query = "UPDATE tb_sucursales  
						SET identificativoNit = '$identificativoNit', nombre = '$nombre', telefono1 = '$telefono1', telefono2 = '$telefono2',
							celular = '$celular', direccion = '$direccion', longitud = '$longitud', latitud = '$latitud', email = '$email',
							leyendaencabezado = '$leyendaencabezado', estado = '$estado', idPais = '$idPais', idCiudad = '$idCiudad', idBarrio = '$idBarrio'
							WHERE idSucursal =  '$idSucursal' ";
			}else{
				$query = "UPDATE tb_sucursales  
						SET identificativoNit = '$identificativoNit', nombre = '$nombre', telefono1 = '$telefono1', telefono2 = '$telefono2',
							celular = '$celular', direccion = '$direccion', longitud = '$longitud', latitud = '$latitud', email = '$email',
							leyendaencabezado = '$leyendaencabezado', estado = '$estado', idPais = '$idPais', idCiudad = '$idCiudad', idBarrio = '$idBarrio',
							urlLogo = '$urlLogo'
							WHERE idSucursal =  '$idSucursal' ";
			}
			
			
			
			$conexion = parent::conexionCliente();
	    		
	        $res = $conexion->query($query);
	
	        return $resultado;		
	    	
	    }//fin metodo editarSucursal
	    
	    
	    //metodo para consultar sucursales para select
	    public function consultarSucursalesSelect(){
	    			
	    	$resultado = array();
			
			$query = "SELECT idSucursal, nombre
					  FROM tb_sucursales ";
			
			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;	
	    	
	    }//fin metodo consultarSucursalesSelect
	    
	    
	    //metodo para vincular un usuario con una sucursal
	    public function vincularUsuarioSucursal($idUsuario,$idSucursal){
	    				
	    	$query = "INSERT INTO tb_usuarios_sucursal 
	    				(idSucursal, idUsuario, estado)
	    			VALUES ('$idSucursal', '$idUsuario', 'A')";		
	    	
			$conexion = parent::conexionCliente();	
	    	
			$res = $conexion->query($query);
			
	    }//fin metodo vincularUsuarioSucursal
 
 
 		//metodo para consultar las sucursales que tiene asociado un usuario
 		public function consultarSucursalesUsuario($idUsuario){
 						
 			$resultado = array();
			
			$query = "SELECT US.idSucursal, S.nombre
						FROM tb_usuarios_sucursal AS US
						INNER JOIN tb_sucursales AS S ON S.idSucursal =  US.idSucursal
					  WHERE US.idUsuario = '$idUsuario' AND US.estado = 'A'";		
 			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;
				
 			
 		}//fin meotod consultarSucursalesUsuario
 		
 		
 		
 		//metodo para consultar los usuarios que tiene asociados una sucursal
 		public function consultarUsuariosDeLaSucursal($idSucursal){
 			
			$resultado = array();
			
			$query = "SELECT US.idUsuarioSucursal, US.estado, U.identificacion, U.nombre, U.apellido
						FROM tb_usuarios_sucursal AS US
						INNER JOIN tb_usuarios AS U ON US.idUsuario =  U.idUsuario
					  WHERE US.idSucursal = '$idSucursal'";		
 			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;
			
 		}//fin metodo consultarUsuariosDeLaSucursal
 		
 		
 		//consultar los usuarios qu eno estan en una sucursal
 		public function usuariosQueNoEstanEnLASucursal($idSucursal){
 			
			$resultado = array();
			
			$query = "Select U.idUsuario, U.identificacion, U.nombre, U.apellido
  						FROM tb_usuarios AS U 
  					where Not U.idUsuario In (Select US.idUsuario From tb_usuarios_sucursal AS US WHERE US.idSucursal = '$idSucursal')";		
 			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;
			
			
 		}//fin metodo usuariosQueNoEstanEnLASucursal
 		
 		
 		//metodo para activar el vinculo entre una sucursal y un usuario
 		public function activarVinculoSucursalUsuario($idVinculo){
 			
			$query = "UPDATE tb_usuarios_sucursal SET estado = 'A' WHERE idUsuarioSucursal = '$idVinculo'";		
 			
			$conexion = parent::conexionCliente();
			
			$res = $conexion->query($query);
			
 		}//fin metodo activarVinculoSucursalUsuario
 		

 		
 		//metodo para desactivar el vinculo entre una sucursal y un usuario
 		public function desactivarVinculoSucursalUsuario($idVinculo){
 			
			$query = "UPDATE tb_usuarios_sucursal SET estado = 'I' WHERE idUsuarioSucursal = '$idVinculo'";		

			
			$conexion = parent::conexionCliente();
			
			$res = $conexion->query($query);
			
 		}//fin metodo desactivarVinculoSucursalUsuario 				
  
  
  		//espacios para hospitalizacion
  		
  		public function consultarEspaciosHospitalizacionSucursal($idSucursal){
  			
			$resultado = array();
			
			$query = "Select idEspacioHospitalizacion, nombre, observacion, capacidad, espaciosOcupados, estado
  						FROM tb_espacioHospitalizacion 
  						WHERE idSucursal = '$idSucursal'";		
 			
			$conexion = parent::conexionCliente();
    		
	        if($res = $conexion->query($query)){
	           
	               /* obtener un array asociativo */
	                while ($filas = $res->fetch_assoc()) {
	                    $resultado[] = $filas;
	                }
	            
	           
	        }
	
	        return $resultado;
						
			
			
  		}//consultarEspaciosHospitalizacionSucursal
  		
  		
  		//metodo para guardar un espacio de hospitalizacion 
  		public function guardarEspacioHospitalizacionSucursal($idSucursal, $nombre, $capacidad, $observacion){
  			
			$idSucursal       			= parent::escaparQueryBDCliente($idSucursal); 
			$nombre       				= parent::escaparQueryBDCliente($nombre); 
			$capacidad       			= parent::escaparQueryBDCliente($capacidad); 
			$observacion       			= parent::escaparQueryBDCliente($observacion); 
			
			$query = "INSERT INTO tb_espacioHospitalizacion 
	    				(nombre, observacion, capacidad, espaciosOcupados, estado, idSucursal)
	    			VALUES ('$nombre', '$observacion', '$capacidad', '0','A', '$idSucursal')";		
	    	
			$conexion = parent::conexionCliente();	
	    	
			$res = $conexion->query($query);	
			
			
  		}//fin metodo  guardarEspacioHospitalizacionSucursal
  		
  
  		//metodo para editar un espacio de hospitalizacion 
  		public function editarEspacioHospitalizacionSucursal($idEspacio, $nombre, $capacidad, $ocupado, $observacion){
  			
			$idEspacio       			= parent::escaparQueryBDCliente($idEspacio); 
			$nombre       				= parent::escaparQueryBDCliente($nombre); 
			$ocupado       				= parent::escaparQueryBDCliente($ocupado); 
			$observacion       			= parent::escaparQueryBDCliente($observacion); 
			$capacidad       			= parent::escaparQueryBDCliente($capacidad); 
			
			
			$query = "UPDATE tb_espacioHospitalizacion 
	    				SET nombre = '$nombre', observacion = '$observacion', capacidad = '$capacidad', espaciosOcupados = '$ocupado' 
	    				WHERE idEspacioHospitalizacion = '$idEspacio'";		
	    	
			$conexion = parent::conexionCliente();	
	    	
			$res = $conexion->query($query);	
			
			
  		}//fin metodo  guardarEspacioHospitalizacionSucursal  
  		
  		
  		//metodo para desactivar un espacio de para hospitalizacion
  		public function desactivarEspacioHospitalizacion($idEspacio){
  			
			$idEspacio       			= parent::escaparQueryBDCliente($idEspacio); 
			
			$query = "UPDATE tb_espacioHospitalizacion 
	    				SET estado = 'I'
	    				WHERE idEspacioHospitalizacion = '$idEspacio'";		
	    	
			$conexion = parent::conexionCliente();	
	    	
			$res = $conexion->query($query);
			
  		}//fin metodo desactivarEspacioHospitalizacion
  		
  		
   		//metodo para activar un espacio de para hospitalizacion
  		public function activarEspacioHospitalizacion($idEspacio){
  			
			$idEspacio       			= parent::escaparQueryBDCliente($idEspacio); 
			
			$query = "UPDATE tb_espacioHospitalizacion 
	    				SET estado = 'A'
	    				WHERE idEspacioHospitalizacion = '$idEspacio'";		
	    	
			$conexion = parent::conexionCliente();	
	    	
			$res = $conexion->query($query);
			
  		}//fin metodo activarEspacioHospitalizacion 		
  		
  		
  		//Fin espacios para hospitalizacion
  
  
  
        
    }//fin clase
    
    
?>