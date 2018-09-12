<?php
/*
 * Archivo para consultar los datos de una cita
 */

 $idCita = $_POST['idCita'];
 
   require_once("../../Config/config.php");
   
   require_once("../../Models/agenda_model.php");
   
   $objetoAgenda	= new agenda();
   
   $datosCita = $objetoAgenda->consultarDatosCita($idCita);
   
   
   echo json_encode($datosCita);	    
    

?>