<?php

/*
 * Archivo para almacenar un mensaje que se realice por la pagina
 */
 
 //se reciben las variables
 $nombre		= $_POST['nombre'];
 $email			= $_POST['email'];
 $texto			= $_POST['texto'];

 //se incorpora el archivo de configuracion
 require_once ("../../Config/config.php");
 //se incorpora el modelo encargado de registrar los datos en la BD
 require_once ("../../Models/index_model.php");	
 
 //se instancian el objeto del modelo
 $objetoIndex = new index();	
 
 $objetoIndex->guardarMensajeContactenos($nombre, $email, $texto);


?>