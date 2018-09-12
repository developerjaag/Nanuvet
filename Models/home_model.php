<?php

    /*
        * Clase que controla los datos con los que trabaja el home
    */
    
    
    class home extends Config{
       
       
       //metodo para varificar si existe una sucursal
       public function comprobarExistenciaSucursal(){
           
           $resultado = "";
           
           $query = "select count(idSucursal) as catidadSucursales from tb_sucursales ";
           
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado = $filas['catidadSucursales'];
                    }
                
               
            }
    
            return $resultado;
           
           
       }//fin metodo comprobarExistenciaSucursal
       
       
       //metodo para consultar la cantidad de sucursales que tiene asociado un usuario y que se encuentran activas
       public function sucursalesPorUsuario($idUsuario){

           $resultado = array();
           
           $query = "SELECT US.idUsuarioSucursal, US.idSucursal, US.porDefecto,  U.identificativoNit, U.nombre 
           				FROM tb_usuarios_sucursal  AS US
           				 INNER JOIN tb_sucursales AS U ON U.idSucursal = US.idSucursal
           			WHERE US.idUsuario = '$idUsuario' AND US.estado = 'A'";
           			
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado[] = $filas;
                    }                
               
            }
    
            return $resultado;

      	
       }//fin metodo  sucursalesPorUsuario
       
       
       //metodo para cambiar una sucursal
       public function cambiarSucursalUsuario($idUsuario, $idSucursal, $porDefecto){
       	
		
		$idUsuario	= parent::escaparQueryBDCliente($idUsuario);
		$idSucursal	= parent::escaparQueryBDCliente($idSucursal);
		$porDefecto	= parent::escaparQueryBDCliente($porDefecto);
		
		$query	= "UPDATE tb_usuarios_sucursal SET enUso = 'No' WHERE idUsuario = '$idUsuario'";
		
		$conexion = parent::conexionCliente();
		
		$res = $conexion->query($query); 
		
		$query1	= "UPDATE tb_usuarios_sucursal SET enUso = 'Si' WHERE idUsuario = '$idUsuario' AND idSucursal = '$idSucursal'";
		
		$res1 = $conexion->query($query1); 
		
		
		if($porDefecto == 'Si'){
				
			$query2	= "UPDATE tb_usuarios_sucursal SET porDefecto = 'No' WHERE idUsuario = '$idUsuario'";		
			$res2 = $conexion->query($query2); 	
			
			$query3	= "UPDATE tb_usuarios_sucursal SET porDefecto = 'Si' WHERE idUsuario = '$idUsuario' AND idSucursal = '$idSucursal'";
				
			$res3 = $conexion->query($query3); 			
			
		}
		
       }//fin metodo cambiarSucursalUsuario
       
       
       //metodo para consultar si una sucursal es la por defecto
       public function sucursalCambioPorDefecto($idUsuario, $idSucursal){
       	
           $resultado = "";
           
           $query = "SELECT porDefecto FROM tb_usuarios_sucursal WHERE idUsuario = '$idUsuario' AND idSucursal = '$idSucursal' ";
           
		   
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado = $filas['porDefecto'];
                    }
                
               
            }
    
            return $resultado;
		
		
       }//fin metodo consultarIdSucursalPorDefecto
        
        
       //consultar las citas de un usuario para el día actual
       public function citasUsuarioDiaActual($idUsuario){
       	
		$resultado = array();
           
           $query = "SELECT 
					    C.idAgendaCita,
					    C.fecha,
					    DATE_FORMAT(C.horaInicio, '%H:%i') as horaInicio,
					    C.duracionHoras,
					    C.duracionMinutos,
					    C.idMascota,
					    C.idTipoCita,
					    E.nombre AS nombreEspecie,
					    R.nombre AS nombreRaza,
					    M.nombre AS nombrePacientes,
					    M.sexo,
					    P.nombre AS nombrePropietario,
					    P.apellido AS apellidoPropietario,
					    TC.nombre AS nombreTipoCita
					FROM
					    tb_agendaCitas AS C
					        INNER JOIN
					    tb_mascotas AS M ON M.idMascota = C.idMascota
					        INNER JOIN
					    tb_especies AS E ON E.idEspecie = M.idEspecie
					        INNER JOIN
					    tb_razas AS R ON R.idRaza = M.idRaza
					        INNER JOIN
					    tb_propietarios AS P ON P.idPropietario = M.idPropietario
					        INNER JOIN
					    tb_tiposCita AS TC ON TC.idTipoCita = C.idTipoCita
					        INNER JOIN
					    tb_agendaCitas_usuarios AS CU ON CU.idAgendaCita = C.idAgendaCita
					WHERE
					    C.fecha = CURDATE() AND 
    					C.horaInicio >= CURTIME() AND
    					C.estado <> 'Cancelada'
					        AND CU.idUsuario = '$idUsuario'";
           			
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado[] = $filas;
                    }                
               
            }
    
            return $resultado;
		
		
       }//fin metodo  citasUsuarioDiaActual
       
       
       //metodo para guardar un mensaje para todos los usuarios
       public function guardarNuevoMensajeTexto($fechaVenciemiento, $texto, $idUsuario){
       			
	       	$fechaVenciemiento	= parent::escaparQueryBDCliente($fechaVenciemiento);
	       	$texto				= parent::escaparQueryBDCliente($texto);	
	       	
	       	$query	= "INSERT INTO tb_mensajesUsuarios (fechaCreacion, horaCreacion, texto, fechaVencimiento, estado, idUsuario)
	       				VALUES
	       				(NOW(), NOW(), '$texto', '$fechaVenciemiento', 'A', '$idUsuario')";
		
			$conexion = parent::conexionCliente();
		
			$res = $conexion->query($query); 
		       	
       }//fin metoo guardarNuevoMensajeTexto
       
        
       //metodo para consultar los mensajes a todos los usuarios
       public function consultarMensajesTodosUsuarios(){
       	
		
           $resultado = array();
           
           $query = "SELECT 
           				M.idMensajeUsuarios,
					    M.fechaCreacion,
					    DATE_FORMAT(M.horaCreacion, '%H:%i') as horaCreacion,
					    M.fechaVencimiento,
					    M.texto,
					    U.idUsuario,
					    U.nombre,
					    U.apellido
					FROM
					    tb_mensajesUsuarios AS M
					        INNER JOIN
					    tb_usuarios AS U ON M.idUsuario = U.idUsuario
					WHERE
					    M.estado = 'A'
					        AND fechaVencimiento > CURDATE()
					ORDER BY (M.idMensajeUsuarios) desc";
           			
           $conexion = parent::conexionCliente();
    		
            if($res = $conexion->query($query)){
               
                   /* obtener un array asociativo */
                    while ($filas = $res->fetch_assoc()) {
                        $resultado[] = $filas;
                    }                
               
            }
    
            return $resultado;
		
       } //Fin metodo consultarMensajesTodosUsuarios
        
 
 	//metodo para quitar un mensaje de un usuario para todos los usuarios
 	public function quitarNuevoMensajeTexto($idmensaje){
 					
 			$idmensaje				= parent::escaparQueryBDCliente($idmensaje);	
	       	
	       	$query	= "UPDATE tb_mensajesUsuarios SET estado = 'I' WHERE idMensajeUsuarios = '$idmensaje' ";
		
			$conexion = parent::conexionCliente();
		
			$res = $conexion->query($query); 
 			
 		
 	}//fin metodo quitarNuevoMensajeTexto
 
        
        
    }//fin clase
    
    
?>