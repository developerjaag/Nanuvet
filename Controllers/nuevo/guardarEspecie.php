<?php
//archivo para guardar una especie, antes de eso se valida si la especie ya existe



	$nombreEspecie  =   $_POST['nombreEspecie'];


    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las especies
    require_once("../../Models/especies_model.php");
    
    //se define el objeto especies
    $objetoEspecies   = new especies();
    
    //se llama al metodo que consulta si la especie existe
    $comprobarExistencia    = $objetoEspecies->comprobarExistenciaEspecie($nombreEspecie);
    
    //comprobar si la consulta arrojo datos (Existe la especie)
    if( sizeof($comprobarExistencia) > 0 ){
        
        $retorno    = "Existe!";
        
    }else{//sino se inserta la especie
        
        $guardarEspecie = $objetoEspecies->guardarEspecie($nombreEspecie);
        
        $retorno    = "Guardada!";
        
    } //fin else
    
    
    
    echo $retorno;