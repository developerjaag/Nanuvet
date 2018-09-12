<?php

/*
 * Archivo para actualizar el estado de un tutorial interactivo
 */
 
  if(!isset($_SESSION)) {
	     session_start();
	}
 
 //se recibe el parametro que es el identificador del tutorial
 $numeroTutorial	= $_POST['idIntro'];
 $estado			= $_POST['estado'];
 
 
 //se importa el archivo de configuracion
 require_once ("../../Config/config.php");
 //se i mporta el modelo del shop
 require_once ("../ShopModels/shop_model.php");
 
 //se instancia el objeto
 $objetoShopModel = new shop_model();
 
 $usuario  = $_SESSION['usuario_idUsuario'];
 
 //se llama al metodo que actualiza el tutorial
 $resultado = $objetoShopModel->actualizarTutorial($numeroTutorial, $estado, $usuario);
 
 $_SESSION['tutoriales_usuario']	= $objetoShopModel->consultarTutorialesUsuario($usuario);
 
 echo $resultado;
