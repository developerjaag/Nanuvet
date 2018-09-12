<?php

/**
 * Archivo para guardar una nota aclaratoria
 */
	if(!isset($_SESSION)){
		    session_start();
		}
 
 if( isset($_SESSION['usuario_idUsuario']) and $_SESSION['usuario_idUsuario'] != '' ){
 	
	$idCirugia = $_POST['idCirugia'];
	$textoNota	= $_POST['textoNota'];
	
	//se importa el config y el modelo
	require_once('../../../Config/config.php');
	
	require_once('../../../Models/cirugias_model.php');
	
	$objetoCirugias	= new cirugias();	
	
	$objetoCirugias->guardarNotaAclaratoria($idCirugia, $textoNota, $_SESSION['usuario_idUsuario']);
	
	
 }//fin if	
 

?>