<?php

/*
 * Archivo controller para ciudades
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de las ciudades
	    require_once("Models/ciudades_model.php");
	    
	    //se define el objeto ciudades
	    $objetoCiudades   = new ciudades();
 
 
 //si llega el formulario para guardar una nueva ciudad
 if( isset($_POST['envioNuevaCiudad']) and $_POST['envioNuevaCiudad'] == "envio" ){
 	
	//se reciben las variables
	$idPais 		= $_POST['idPais'];
	$nombreCiudad	= $_POST['nombreCiudad'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La ciudad ya existe!";
    		$ok="Ciudad guardada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The city it already exists!";
    		$ok="City successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($idPais == "") or ($idPais == "0") or ($nombreCiudad == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si la ciudad existe
		    $comprobarExistencia    = $objetoCiudades->comprobarExistenciaCiudad($idPais, $nombreCiudad);
		    
		    //comprobar si la consulta arrojo datos (Existe la ciudades)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la ciudad
		        
		        $guardarCiudad  = $objetoCiudades->guardarCiudad($idPais, $nombreCiudad);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a ciudades listado
	 header('Location: '.Config::ruta().'listados/ciudades/' );	
	 		
	exit();	
	
	
 }//fin si llega una ciudad para guardar
 
 
 //si llega el formulario para editar una ciudad
 if( isset($_POST['idEditarCiudad']) and $_POST['idEditarCiudad'] != "" ){
 	

	//se reciben las variables
	$idPais			= $_POST['idEditarPais'];
	$idCiudad		= $_POST['idEditarCiudad'];
	$nombreCiudad	= $_POST['editarNombreCiudad'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La ciudad ya existe!";
    		$ok="Ciudad editada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The city it already exists!";
    		$ok="City edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($idCiudad == "") or ($idCiudad == "0") or ($nombreCiudad == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	

		   
		    
		    if($nombreCiudad != $_POST['replicaNombre']){
				
				  //se llama al metodo que consulta si la ciudad existe
		    		$comprobarExistencia    = $objetoCiudades->comprobarExistenciaCiudad($idPais, $nombreCiudad);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta la ciudad
		        
		        $guardarCiudad  = $objetoCiudades->editarCiudad($idCiudad, $nombreCiudad);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a ciudades listado
	 header('Location: '.Config::ruta().'listados/ciudades/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar ciudad
 
 
 
 

 
 //se consulta el total de los directorios existentes
		$TotalCiudades = $objetoCiudades->tatalCiudades();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoCiudades = $objetoCiudades->listarCiudades($paginaActual,$records_per_page);//se llama al metodo para listar las ciudades segun los limites de la consulta
		
		$pagination->records($TotalCiudades);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>