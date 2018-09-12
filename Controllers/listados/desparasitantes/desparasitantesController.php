<?php

/*
 * Archivo controller para desparasitantes
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los desparasitantes
	    require_once("Models/desparasitantes_model.php");
	    
	    //se define el objeto desparasitantes
	    $objetodesparasitantes   = new desparasitantes();
 
 
 //si llega el formulario para guardar un nuevo desparasitante
 if( isset($_POST['envioNuevoDesparasitante']) and $_POST['envioNuevoDesparasitante'] == "envio" ){
 	
	//se reciben las variables
	$nombreDesparasitante		= $_POST['nombreDesparasitante'];
	$descripcionDesparasitante	= $_POST['descripcionDesparasitante'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El desparasitante ya existe!";
    		$ok="Desparasitante guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="To deworm it already exists!";
    		$ok="To deworm successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreDesparasitante == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el desparasitante existe
		    $comprobarExistencia    = $objetodesparasitantes->comprobarExistenciaDesparasitante($nombreDesparasitante);
		    
		    //comprobar si la consulta arrojo datos (Existe el desparasitante)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el desparasitante
		        
		        $guardarDesparasitnete  = $objetodesparasitantes->guardarDesparasitante($nombreDesparasitante, $descripcionDesparasitante);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a desparasitnetes listado
	 header('Location: '.Config::ruta().'listados/desparasitantes/' );	
	 		
	exit();	
	
	
 }//fin si llega un desparasitente para guardar
 
 
 //si llega el formulario para editar un desparasitante
 if( isset($_POST['idEditarDesparasitante']) and $_POST['idEditarDesparasitante'] != "" ){
 	

	//se reciben las variables
	$idDesparasitante		= $_POST['idEditarDesparasitante'];
	$nombreDesparasitante	= $_POST['editarNombreDesparasitante'];
	$descripcionDesparasitante	= $_POST['editarDescripcionDesparasitante'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El desparasitante ya existe!";
    		$ok="Desparasitante editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="To deworm it already exists!";
    		$ok="To deworm edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreDesparasitante == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	

		    
		    
		     if($nombreDesparasitante != $_POST['replicaNombre']){
				
				 //se llama al metodo que consulta si el desparasitante existe
		    		$comprobarExistencia    = $objetodesparasitantes->comprobarExistenciaDesparasitante($nombreDesparasitante);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el desparasitente
		        
		        $guardarCiudad  = $objetodesparasitantes->editarDesparasitante($idDesparasitante, $nombreDesparasitante, $descripcionDesparasitante);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a desparasitantes listado
	 header('Location: '.Config::ruta().'listados/desparasitantes/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar desparasitante
 
 
 
 

 
 //se consulta el total de los desparasitantes existentes
		$TotalDesparasitantes = $objetodesparasitantes->tatalDesparasitantes();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoDesparasitantes = $objetodesparasitantes->listarDesparasitantes($paginaActual,$records_per_page);//se llama al metodo para listar los desparasitantes segun los limites de la consulta
		
		$pagination->records($TotalDesparasitantes);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>