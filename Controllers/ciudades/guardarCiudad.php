<?php
//archivo para guardar una ciudad, antes de eso se valida si la ciudad ya existe



$idPais         =   $_POST['idPais'];
$nombreCiudad   =   $_POST['nombreCiudad'];


    //se importa el archivo de config
    require_once("../../Config/config.php");
    
    //se importa el modelo de las ciudades
    require_once("../../Models/ciudades_model.php");
    
    //se define el objeto ciudades
    $objetoCiudades   = new ciudades();
    
    //se llama al metodo que consulta si la ciudad existe
    $comprobarExistencia    = $objetoCiudades->comprobarExistenciaCiudad($idPais, $nombreCiudad);
    
    //comprobar si la consulta arrojo datos (Existe la ciudad)
    if( sizeof($comprobarExistencia) > 0 ){
        
        $retorno    = "Existe!";
        
    }else{//sino se inserta la ciudad
        
        $guardarCiudad  = $objetoCiudades->guardarCiudad($idPais, $nombreCiudad);
        
        $retorno    = "Guardada!";
        
    } //fin else
    
    
    
    echo $retorno;