<?php


/*
 * Para consultar los usuarios relacionados con una cita
 */
 
 $idCita = $_POST['idCita'];
 
   require_once("../../Config/config.php");
   
   require_once("../../Models/agenda_model.php");
   
   $objetoAgenda	= new agenda();
   
   $usuariosCita = $objetoAgenda->consultarUsuariosCita($idCita);
   
   
   echo json_encode($usuariosCita);	    
    

?>