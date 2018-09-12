<?php

/*
 * Archivo controller para diagnosticos de consultas
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los diagnosticos
	    require_once("Models/diagnosticosConsultas_model.php");
	    
	    //se define el objeto diagnosticos
	    $objetoDiagnosticosConsultas   = new diagnosticosConsultas();
 
 
 //si llega el formulario para guardar un nuevo diagnostico
 if( isset($_POST['envioNuevoDiagnostico']) and $_POST['envioNuevoDiagnostico'] == "envio" ){
 	
	//se reciben las variables
	$nombreDiagnostico			= $_POST['nombreDiagnostico'];
	$codigoDiagnostico			= $_POST['codigoDiagnostico'];
	$observacionDiagnostico		= $_POST['observacionDiagnostico'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El diagnóstico ya existe!";
    		$ok="Diagnóstico guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The diagnosis it already exists!";
    		$ok="The diagnosis successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreDiagnostico == "") or ($codigoDiagnostico == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el diagnostico existe
		    $comprobarExistencia    = $objetoDiagnosticosConsultas->comprobarExistenciaDiagnostico($nombreDiagnostico);
		    
		    //comprobar si la consulta arrojo datos (Existe el diagnostico)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el diagnostico
		        $guardarDiagnostico = $objetoDiagnosticosConsultas->guardarDiagnostico($nombreDiagnostico, $codigoDiagnostico, $observacionDiagnostico );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a diagnosticos listado
	 header('Location: '.Config::ruta().'listados/diagnosticosConsultas/' );	
	 		
	exit();	
	
	
 }//fin si llega un diagnostico para guardar
 
 
 //si llega el formulario para editar un diagnostico
 if( isset($_POST['idEditarDiagnostico']) and $_POST['idEditarDiagnostico'] != "" ){
 	

	//se reciben las variables
	$idDiagnostico				= $_POST['idEditarDiagnostico'];
	$nombreDiagnostico			= $_POST['nombreEditarDiagnostico'];
	$codigoDiagnostico			= $_POST['codigoEditarDiagnostico'];
	$observacionDiagnostico		= $_POST['observacionEditarDiagnostico'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El diagnóstico ya existe!";
    		$ok="Diagnóstico editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The diagnosis it already exists!";
    		$ok="The diagnosis edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreDiagnostico == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreDiagnostico != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si el diagnostico existe
			    $comprobarExistencia    = $objetoDiagnosticosConsultas->comprobarExistenciaDiagnostico($nombreDiagnostico);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el diagnostico
		        
		        $guardarCiudad  = $objetoDiagnosticosConsultas->editarDiagnostico($idDiagnostico, $nombreDiagnostico, $codigoDiagnostico, $observacionDiagnostico );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a diagnosticos consultas listado
	 header('Location: '.Config::ruta().'listados/diagnosticosConsultas/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar diagnostico
 
 
 
 

 
 //se consulta el total de los diagnosticos existentes
		$TotalDiagnosticos = $objetoDiagnosticosConsultas->tatalDiagnosticos();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoDiagnosticos = $objetoDiagnosticosConsultas->listarDiagnosticos($paginaActual,$records_per_page);//se llama al metodo para listar los diagnosticos segun los limites de la consulta
		
		$pagination->records($TotalDiagnosticos);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>