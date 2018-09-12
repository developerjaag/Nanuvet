<?php


/*
 * Archivo para cambiar el estado de un permiso para un usuario
 */
 
 $idUsuario	= $_POST['idUsuario'];
 $estado	= $_POST['estado'];
 $idPermiso = $_POST['idPermiso'];
 
 
 //se importa el config
 require_once ("../../Config/config.php");
 
 //se importa el modelo de los permisos
 require_once ("../../Models/permisos_model.php");
 
 //se intancia el objeto
 $objetoPermisos	= new permisos();
 
 //se llama al metodo que cambia el estado del permiso
 $retorno	= $objetoPermisos->cambiarEstadoPermiso($idUsuario, $estado, $idPermiso);
 
 echo $retorno;
 
?>