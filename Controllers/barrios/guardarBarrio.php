<?php
//archivo para guardar un barrio, antes de eso se valida si el barrio ya existe



$idCiudad         =   $_POST['idCiudad'];
$nombreBarrio     =   $_POST['nombreBarrio'];


    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de los barrios
    require_once("../../Models/barrios_model.php");
    
    //se define el objeto barrios
    $objetoBarrios   = new barrios();
    
    //se llama al metodo que consulta si el barrio existe
    $comprobarExistencia    = $objetoBarrios->comprobarExistenciaBarrio($idCiudad, $nombreBarrio);
    
    //comprobar si la consulta arrojo datos (Existe el barrio)
    if( sizeof($comprobarExistencia) > 0 ){
        
        $retorno    = "Existe!";
        
    }else{//sino se inserta el barrio
        
        $guardarBarrio  = $objetoBarrios->guardarBarrio($idCiudad, $nombreBarrio);
        
        $retorno    = "Guardado!";
        
    } //fin else
    
    
    
    echo $retorno;