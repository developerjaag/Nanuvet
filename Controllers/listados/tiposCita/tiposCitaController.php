<?php

/*
 * Archivo controller para vacunas
 */

 
 	    //se importa el archivo de config
	    require_once("Config/config.php");
	    
	    //se importa el modelo de los tiposCita
	    require_once("Models/tiposCita_model.php");
	    
	    //se define el objeto tiposCita
	    $objetoTiposCita   = new tiposCita();
 
 
 //si llega el formulario para guardar un nuevo tipo d ecita
 if( isset($_POST['envioNuevoTipoCita']) and $_POST['envioNuevoTipoCita'] == "envio" ){
 	
	//se reciben las variables
	$nombreTipoCita		= $_POST['nombreTipoCita'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El tipo de cita ya existe!";
    		$ok="Tipo de cita guardado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Type of Appointment already exists!";
    		$ok="Type of Appointment successfully saved!";
    		break;
        
    }//fin swtich
    
    //validar si algun campo obligatorio llega vacio
    if(($nombreTipoCita == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos
     
     if($sw == 0){
     	

		    //se llama al metodo que consulta si el tipo de cita existe
		    $comprobarExistencia    = $objetoTiposCita->comprobarExistenciaTipoCita($nombreTipoCita);
		    
		    //comprobar si la consulta arrojo datos (Existe la vacuna)
		    if( sizeof($comprobarExistencia) > 0 ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el tipo de cita
		        
		        $guardarTipoCita  = $objetoTiposCita->guardarTipoCita($nombreTipoCita);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a tipos de cita listado
	 header('Location: '.Config::ruta().'listados/tiposCita/' );	
	 		
	exit();	
	
	
 }//fin si llega un tipo de cita para guardar
 
 
 //si llega el formulario para editar un tipo de cita
 if( isset($_POST['idEditarTipoCita']) and $_POST['idEditarTipoCita'] != "" ){
 	

	//se reciben las variables
	$idTipoCita					= $_POST['idEditarTipoCita'];
	$nombreTipoCita				= $_POST['editarNombreTipoCita'];
	
	$sw        = 0;//para controlar si entra en un error_get_last
        
    switch($_SESSION['usuario_idioma']){
        
        case 'Es':
    		$error="Algo salió mal";
			$error2="El tipo de cita ya existe!";
    		$ok="Tipo de cita editado correctamente!";
    		break;
    		
    	case 'En':
    		$error="Something went wrong";
			$error2="Type of Appointment it already exists!";
    		$ok="Type of Appointment edit successfully!";
    		break;
        
    }//fin swtich	

    
    //validar si algun campo obligatorio llega vacio
    if(($nombreTipoCita == "")){
         $sw = 1;			
         $_SESSION['mensaje']   = $error;
     }//fin if validar los campos	

     
     if($sw == 0){     	


		    
		     if($nombreTipoCita != $_POST['replicaNombre']){
				
			    //se llama al metodo que consulta si el tipo de cita existe
			    $comprobarExistencia    = $objetoTiposCita->comprobarExistenciaTipoCita($nombreTipoCita);
				
			}
		    
		    
		    //comprobar si la consulta arrojo datos
		    if( (isset($comprobarExistencia)) and (sizeof($comprobarExistencia) > 0) ){
		        
		        $_SESSION['mensaje']   = $error2;
		        
		    }else{//sino se inserta el desparasitente
		        
		        $guardarTipoCita  = $objetoTiposCita->editarTipoCita($idTipoCita, $nombreTipoCita);
		        
		        $_SESSION['mensaje']   = $ok;
		        
		    } //fin else
	
     }//fin sw == 0
	
	//se redirecciona nuevamente a tipos de cita listado
	 header('Location: '.Config::ruta().'listados/tiposCita/' );	
	 		
	exit();	     
     
     	
 }//fin formulario para editar un tipo de cita
 
 
 
 

 
 //se consulta el total de los tipos de cita existentes
		$TotalTiposCita = $objetoTiposCita->tatalTiposCita();	
		$records_per_page = 7;//total de registros por pagina
		
		require_once ("libs/Zebra_Pagination/Zebra_Pagination.php");//se importa el archivo

		
   		$pagination = new Zebra_Pagination();//se instancia el objeto
		
		$pagination->base_url(Config::ruta());//base da la url para la paginacion, se le envia la de config
		
		$pagination->method('get');//metod por el que se recive la variable

		$pagination->variable_name('id2');//nombre de la variable get
		
		$pagination->padding(false);//para que no se muestre un cero adelante
		
		$paginaActual = $pagination->get_page() - 1;
		
		$listadoTiposCita = $objetoTiposCita->listarTiposCita($paginaActual,$records_per_page);//se llama al metodo para listar los tipos de cita segun los limites de la consulta
		
		$pagination->records($TotalTiposCita);
		
		$pagination->records_per_page($records_per_page);//se le envia al objeto la cantidad de registros por pagina
			
			
	//fin paginación
 
  
 
 

?>