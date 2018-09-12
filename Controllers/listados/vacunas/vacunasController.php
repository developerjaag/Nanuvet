<?php

/*
 * Archivo controller para vacunas
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los vacunas
	    require_once("Models/vacunas_model.php");
	    
	    //se define el objeto vacunas
	    $objetoVacunas   = new vacunas();
 
 
 //si llega el formulario para guardar una nueva vacuna
 if( isset($_POST['envioNuevaVacuna']) and $_POST['envioNuevaVacuna'] == "envio" ){
 	
	//se reciben las variables
	$nombrevacuna		= $_POST['nombreVacuna'];
	$descripcionVacuna	= $_POST['descripcionVacuna'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La vacuna ya existe!";
    		$ok="Vacuna guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Vaccineit already exists!";
    		$ok="Vaccine successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombrevacuna == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si la vacuna existe
		    $comprobarExistencia    = $objetoVacunas->comprobarExistenciaVacuna($nombrevacuna);
		    
		    //comprobar si la consulta arrojo datos (Existe la vacuna)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el desparasitante
		        
		        $guardarVacuna  = $objetoVacunas->guardarVacuna($nombrevacuna, $descripcionVacuna);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a vacunas listado
	 header('Location: '.Config::ruta().'listados/vacunas/' );	
	 		
	exit();	
	
	
 }//fin si llega una vacunas para guardar
 
 
 //si llega el formulario para editar una vacuna
 if( isset($_POST['idEditarVacuna']) and $_POST['idEditarVacuna'] != "" ){
 	

	//se reciben las variables
	$idVacuna					= $_POST['idEditarVacuna'];
	$nombreVacuna				= $_POST['editarNombreVacuna'];
	$descripcionVacuna			= $_POST['editarDescripcionVacuna'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="La vacuna ya existe!";
    		$ok="Vacuna editada correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Vaccine it already exists!";
    		$ok="Vaccine edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreVacuna == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreVacuna != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si la vacuna existe
			    $comprobarExistencia    = $objetoVacunas->comprobarExistenciaVacuna($nombreVacuna);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el desparasitente
		        
		        $guardarVacuna  = $objetoVacunas->editarVacuna($idVacuna, $nombreVacuna, $descripcionVacuna);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a vacunas listado
	 header('Location: '.Config::ruta().'listados/vacunas/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar vacunas
 
 
 
 

 
 //se consulta el total de las vacunas existentes
		$TotalVacunas = $objetoVacunas->tatalVacunas();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoVacunas = $objetoVacunas->listarVacunas($paginaActual,$records_per_page);//se llama al metodo para listar las vacunas segun los limites de la consulta
		
		$pagination->records($TotalVacunas);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>