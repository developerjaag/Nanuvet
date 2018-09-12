<?php

/*
 * Consultar todos los permisos que tiene un usuario
 */
 
 $idUsuario	= $_POST['idUsuario'];

 //se importa el config
 require_once ("../../Config/config.php");
 
 //se importa el modelo de los permisos
 require_once ("../../Models/permisos_model.php");
 
 //se intancia el objeto
 $objetoPermisos	= new permisos();
 
 //se llama al metodo que consulta los permisos del usuario
 $permisosUsuario = $objetoPermisos->consultarPermisosUsuario($idUsuario);
 
 //$permisosUsuario = array('0' => array('idPermisoUsuario' => '1', 'idPermiso' => '35', 'estado' => 'A' ) );
 
 $retorno = json_encode($permisosUsuario);
 
 echo $retorno;

?>