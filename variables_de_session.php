<?php

    $_SESSION['usuario_idioma']; //almacena el idioma con el que se muestra el aplicativo
    
    //variable de sesion que contiene la identificacion del titular
    $_SESSION['identificacion_cliente'];
    
    //para almacenar la conexion a la base de datos del cliente
    $_SESSION['BDC_id'];//almacena el id de la tabla de admon
    $_SESSION['BDC_ubicacion_BD'];//ubicacion de la bd del cliente ireccion del servidor
    $_SESSION['BDC_usuario_BD'];//usuario de la bd del cliente
    $_SESSION['BDC_pass_BD'];//contraseña de la bd del cliente
    $_SESSION['BDC_nombre_BD'];//nombre bd del cliente
    $_SESSION['BDC_estado'];//estado del cliente (Activo o inactivo)
    $_SESSION['BDC_carpeta'];//se guarda el nombre de la carpeta del cliente, donde se almacenan los archivos (images, etc)
    
    //para almacenar los datos de un usuario que se ha logueado
    $_SESSION['usuario_idUsuario'];//id en la tabla
   	$_SESSION['usuario_identificacion'];//identificacion
   	$_SESSION['usuario_nombre'];//nombre
   	$_SESSION['Usuario_Apellido'];//apellido
   	$_SESSION['usuario_urlFoto'];//url donde se encuentra la imagen del usuario
   	
   	
   	//para almacenar la sucursal actual del usuario
   	$_SESSION['sucursalActual_idSucursal'];
	$_SESSION['sucursalActual_nombreSucursal'];
	$_SESSION['sucursalActual_cambioSucursal'];//para saber si se manipulo el select de cambio de sucursal
   	
 	//se utiliza la siguiente variable como una array para almacenar los permisos que posee un usuario
$_SESSION['permisos_usuario'];

 	//se utiliza la siguiente variable como una array para almacenar los tutoriales activos de un usuario
$_SESSION['tutoriales_usuario'];	

	//variables de sesion para almacenar la información del propietario creado (Son efimeras, solo se utilizan para pasar datos a la vista de nuevo paciente)
   	$_SESSION['idPropietario'];
	$_SESSION['propietario_nombre'];
	$_SESSION['propietario_apellido'];	
	
	//variable efimera, para volver a la misma vista de "nuevo"
	$_SESSION['PacienteCreado'] = 'Si';
	
	//variables de sesion efimeras para reporte de cita (Cuando se aplican filtros)
	$_SESSION['filtro_post'];
   	$_SESSION['filtro_1'];
	$_SESSION['filtro_2'];
	$_SESSION['filtro_3'];
	$_SESSION['filtro_4'];
	$_SESSION['filtro_5'];
	$_SESSION['filtro_6'];
	$_SESSION['filtro_7'];
	$_SESSION['filtro_8'];
	   	
   	//almacena mensajes para mostrar temporalmente
   	$_SESSION['mensaje'];