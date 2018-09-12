<?php

/**
 * Archivo para guardar una nota aclaratoria
 */
	if(!isset($_SESSION)){
		    session_start();
		}
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 	
	$idConsulta = $_POST['idConsulta'];
	$textoNota	= $_POST['textoNota'];
	
	//se importa el config y el modelo
	require_once('../../../Config/config.php');
	
	require_once('../../../Models/consultas_model.php');
	
	$objetoConsulta	= new consultas();	
	
	$objetoConsulta->guardarNotaAclaratoria($idConsulta, $textoNota, $_SESSION['usuario_idUsuario']);
	
	
 }//fin if	
 

?>