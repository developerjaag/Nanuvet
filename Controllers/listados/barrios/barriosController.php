<?php

/*
 * Archivo controller para barrios
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los barrios
	    require_once("Models/barrios_model.php");
	    
	    //se define el objeto barrios
	    $objetoBarrios   = new barrios();
 
 
 //si llega el formulario para guardar un nuevop barrio
 if( isset($_POST['envioNuevoBarrio']) and $_POST['envioNuevoBarrio'] == "envio" ){
 	
	//se reciben las variables
	$idPais 		= $_POST['idPais'];
	$idCiudad		= $_POST['idCiudad'];
	$nombreBarrio	= $_POST['nombreBarrio'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El barrio ya existe!";
    		$ok="Barrio guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The Neighborhood it already exists!";
    		$ok="Neighborhood successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($idPais == "") or ($idPais == "0") or ($idCiudad == "") or ($idCiudad == "0") or ($nombreBarrio == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el barrio existe
		    $comprobarExistencia    = $objetoBarrios->comprobarExistenciaBarrio($idCiudad, $nombreBarrio);
		    
		    //comprobar si la consulta arrojo datos (Existe el barrio)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el barrio
		        
		        $guardarBarrio  = $objetoBarrios->guardarBarrio($idCiudad, $nombreBarrio);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a barrios listado
	 header('Location: '.Config::ruta().'listados/barrios/' );	
	 		
	exit();	
	
	
 }//fin si llega un barrio para guardar
 
 
 //si llega el formulario para editar un barrio
 if( isset($_POST['idEditarBarrio']) and $_POST['idEditarBarrio'] != "" ){
 	

	//se reciben las variables
	$idCiudad		= $_POST['idEditarCiudad'];
	$idBarrio		= $_POST['idEditarBarrio'];
	$nombreBarrio	= $_POST['editarNombreBarrio'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El barrio ya existe!";
    		$ok="Barrio editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The Neighborhood it already exists!";
    		$ok="Neighborhood edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($idBarrio == "") or ($idBarrio == "0") or ($nombreBarrio == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	

			if($nombreBarrio != $_POST['replicaNombre']){
				
				//se llama al metodo que consulta si el barrio existe
		   	    $comprobarExistencia    = $objetoBarrios->comprobarExistenciaBarrio($idCiudad, $nombreBarrio);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el barrio
		        
		        $guardarBarrio  = $objetoBarrios->editarBarrio($idBarrio, $nombreBarrio);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a barrios listado
	 header('Location: '.Config::ruta().'listados/barrios/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar barrio
 
 
 
 

 
 //se consulta el total de los barrios existentes
		$TotalBarrios = $objetoBarrios->tatalBarrios();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoBarrios = $objetoBarrios->listarBarrios($paginaActual,$records_per_page);//se llama al metodo para listar los directorios segun los limites de la consulta
		
		$pagination->records($TotalBarrios);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>