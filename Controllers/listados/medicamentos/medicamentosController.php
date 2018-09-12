<?php

/*
 * Archivo controller para examenes
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los medicamentos
	    require_once("Models/medicamentos_model.php");
	    
	    //se define el objeto medicamentos
	    $objetoMedicamentos  = new medicamentos();
 
 
 //si llega el formulario para guardar un nuevo medicamento
 if( isset($_POST['envioNuevoMedicamento']) and $_POST['envioNuevoMedicamento'] == "envio" ){
 	
	//se reciben las variables
	$nombreMedicamento		= $_POST['nombreMedicamento'];
	$codigoMedicamento		= $_POST['codigoMedicamento'];
	$observacionMedicamento	= $_POST['observacionMedicamento'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El medicamento ya existe!";
    		$ok="Medicamento guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="The medicine already exists!";
    		$ok="Medicine saved correctly!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreMedicamento == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el medicamento existe
		    $comprobarExistencia    = $objetoMedicamentos->comprobarExistenciaMedicamento($nombreMedicamento);
		    
		    //comprobar si la consulta arrojo datos (Existe el Medicamento)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el Medicamento
		        
		        $guardarMedicamento  = $objetoMedicamentos->guardarMedicamento($nombreMedicamento, $codigoMedicamento, $observacionMedicamento);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a Medicamento listado
	 header('Location: '.Config::ruta().'listados/medicamentos/' );	
	 		
	exit();	
	
	
 }//fin si llega un Medicamento para guardar
 
 
 //si llega el formulario para editar un Medicamento
 if( isset($_POST['idEditarMedicamento']) and $_POST['idEditarMedicamento'] != "" ){
 	

	//se reciben las variables
	$idMedicamento		= $_POST['idEditarMedicamento'];
	$nombreMedicamento	= $_POST['editarNombreMedicamento'];
	$codigoMedicamento	= $_POST['editarCodigoMedicamento'];
	$observacionMedicamento	= $_POST['editarObservacionMedicamento'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El medicamento ya existe!";
    		$ok="Medicamento editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Medicine it already exists!";
    		$ok="Medicine edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreMedicamento == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreMedicamento != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si el examen existe
			    $comprobarExistencia    = $objetoMedicamentos->comprobarExistenciaMedicamento($nombreMedicamento);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el examen
		        
		        $editarMedicamento  = $objetoMedicamentos->editarMedicamento($idMedicamento, $nombreMedicamento, $codigoMedicamento, $observacionMedicamento );
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a Medicamento listado
	 header('Location: '.Config::ruta().'listados/medicamentos/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar Medicamento
 
 
 
 

 
 //se consulta el total de los Medicamento existentes
		$TotalMedicamentos = $objetoMedicamentos->tatalMedicamentos();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoMedicamentos = $objetoMedicamentos->listarMedicamentos($paginaActual,$records_per_page);//se llama al metodo para listar los Medicamentos segun los limites de la consulta
		
		$pagination->records($TotalMedicamentos);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>