<?php

/*
 * Archivo controller para servicios
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los servicios
	    require_once("Models/servicios_model.php");
	    
	    //se define el objeto servicios
	    $objetoServicios   = new servicios();
 
 
 //si llega el formulario para guardar un nuevo servicio
 if( isset($_POST['envioNuevoServicio']) and $_POST['envioNuevoServicio'] == "envio" ){
 	
	//se reciben las variables
	$nombreServicio			= $_POST['nombreServicio'];
	$codigoServicio			= $_POST['codigoServicio'];
	$descripcionServicio	= $_POST['descripcionServicio'];
	$precioServicio			= $_POST['precioServicio'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El servicio ya existe!";
    		$ok="Servicio guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The service it already exists!";
    		$ok="Service successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreServicio == "") or ($codigoServicio == "") or ($precioServicio == "") or ($descripcionServicio == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el servicio existe
		    $comprobarExistencia    = $objetoServicios->comprobarExistenciaServicio($nombreServicio);
		    
		    //comprobar si la consulta arrojo datos (Existe el servicio)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el servicio
		        $guardarServicio = $objetoServicios->guardarServicio($nombreServicio, $codigoServicio, $descripcionServicio, $precioServicio );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a servicios listado
	 header('Location: '.Config::ruta().'listados/servicios/' );	
	 		
	exit();	
	
	
 }//fin si llega un servicio para guardar
 
 
 //si llega el formulario para editar un servicio
 if( isset($_POST['idEditarServicio']) and $_POST['idEditarServicio'] != "" ){
 	

	//se reciben las variables
	$idServicio				= $_POST['idEditarServicio'];
	$nombreServicio			= $_POST['nombreEditarServicio'];
	$codigoServicio			= $_POST['codigoEditarServicio'];
	$descripcionServicio	= $_POST['descripcionEditarServicio'];
	$precioServicio			= $_POST['precioEditarServicio'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El servicio ya existe!";
    		$ok="Servicio editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The service it already exists!";
    		$ok="Service edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreServicio == "") or ($codigoServicio == "") or ($descripcionServicio == "") or ($precioServicio == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreServicio != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si el servicio existe
			    $comprobarExistencia    = $objetoServicios->comprobarExistenciaServicio($nombreServicio);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el servicio
		        
		        $guardarServicio  = $objetoServicios->editarServicio($idServicio, $nombreServicio, $codigoServicio, $descripcionServicio, $precioServicio );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a servicios listado
	 header('Location: '.Config::ruta().'listados/servicios/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar servicio
 
 
 
 

 
 //se consulta el total de los servicios existentes
		$TotalServicios = $objetoServicios->tatalServicios();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoServicios = $objetoServicios->listarServicios($paginaActual,$records_per_page);//se llama al metodo para listar los servicios segun los limites de la consulta
		
		$pagination->records($TotalServicios);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>