<?php
//archivo para guardar una raza, antes de eso se valida si la raza ya existe



	$nombreRaza  =   $_POST['nombreRaza'];
	$idEspecie   =	 $_POST['idEspecie'];

    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las razas
    require_once("../../Models/razas_model.php");
    
    //se define el objeto razas
    $objetorazas   = new razas();
    
    //se llama al metodo que consulta si la raza existe
    $comprobarExistencia    = $objetorazas->comprobarExistenciaRaza($nombreRaza, $idEspecie);
    
    //comprobar si la consulta arrojo datos (Existe la raza)
    if( sizeof($comprobarExistencia) > 0 ){
        
        $retorno    = "Existe!";
        
    }else{//sino se inserta la raza
        
        $guardarEspecie = $objetorazas->guardarRaza($nombreRaza, $idEspecie);
        
        $retorno    = "Guardada!";
        
    } //fin else
    
    
    
    echo $retorno;